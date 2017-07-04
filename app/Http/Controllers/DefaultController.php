<?php

namespace Seracademico\Http\Controllers;

use Illuminate\Http\Request;

use Seracademico\Http\Requests;
use Seracademico\Http\Controllers\Controller;

class DefaultController extends Controller
{
    public function index()
    {
        $data  = new \DateTime('now');

        #Criando pessoas na fila
        $fila = \DB::table('fila')
            ->where('fila.status', '0')
            ->select([
                \DB::raw('count(fila.id) as qtd'),
            ])->first();

        #Criando pessoas aguardando atendimento
        $aguardando = \DB::table('agendamento')
            ->where('agendamento.status_agendamento_id', '1')
            ->select([
                \DB::raw('count(agendamento.id) as qtd'),
            ])->first();

        #Criando pessoas atendidas
        $atendidos = \DB::table('agendamento')
            ->where('agendamento.status_agendamento_id', '3')
            ->select([
                \DB::raw('count(agendamento.id) as qtd'),
            ])->first();

        #Criando pessoas atendidas
        $naoAtendidos = \DB::table('agendamento')
            ->where('agendamento.status_agendamento_id', '4')
            ->select([
                \DB::raw('count(agendamento.id) as qtd'),
            ])->first();


        return view('default.index', compact('fila', 'aguardando', 'atendidos', 'naoAtendidos'));
    }

    /**
     * @return string
     */
    public function graficoTotalAtendidos()
    {

        #Criando pessoas atendidas
        $rows = \DB::table('agendamento')
            ->where('agendamento.status_agendamento_id', '3')
            ->select([
                \DB::raw('month(agendamento.data) as mes'),
                \DB::raw('year(agendamento.data) as ano'),
                \DB::raw('CONCAT(DATE_FORMAT(agendamento.data,"%m"), "/", DATE_FORMAT(agendamento.data,"%Y")) as legenda'),
                \DB::raw('count(agendamento.id) as qtd'),
            ])->groupBy('mes', 'ano');

        $rows = $rows->get();

        $nomes = [];
        $data = [];

        foreach ($rows as $row) {
            $nomes[] = $row->legenda;
            $data[] = $row->qtd;
        }

        return response()->json([$nomes,$data]);
    }

    /**
     * @return string
     */
    public function graficoPacientesNaFila()
    {

        #Criando pessoas na fila
        $rows = \DB::table('fila')
            ->select([
                \DB::raw('month(fila.data) as mes'),
                \DB::raw('DATE_FORMAT(fila.data,"%m") as legenda'),
                \DB::raw('count(fila.id) as qtd'),
            ])->groupBy('mes');

        $rows = $rows->get();

        $nomes = [];
        $data = [];

        foreach ($rows as $row) {
            $nomes[] = $this->getMesNominal($row->legenda);
            $data[] = $row->qtd;
        }

        return response()->json([$nomes,$data]);
    }

    /**
     * @return string
     */
    public function graficoPacientesAtendidas()
    {

        #Criando pessoas na fila
        $rows = \DB::table('agendamento')
            ->where('agendamento.status_agendamento_id', '3')
            ->select([
                \DB::raw('month(agendamento.data) as mes'),
                \DB::raw('DATE_FORMAT(agendamento.data,"%m") as legenda'),
                \DB::raw('count(agendamento.id) as qtd'),
            ])->groupBy('mes');

        $rows = $rows->get();

        $nomes = [];
        $data = [];

        foreach ($rows as $row) {
            $nomes[] = $this->getMesNominal($row->legenda);
            $data[] = $row->qtd;
        }

        return response()->json([$nomes,$data]);
    }

    /**
     * Método para retorna o mês em forma nominal
     *
     * @param $data
     * @return string
     */
    public static function getMesNominal($data)
    {
        $mes = "";

        // Retorna o dia da semana por extenso
        switch($data) {

            case"01": $mes = "Janeiro"; break;

            case"02": $mes = "Fevereiro"; break;

            case"03": $mes = "Março"; break;

            case"04": $mes = "Abril"; break;

            case"05": $mes = "Maio"; break;

            case"06": $mes = "Junho"; break;

            case"07": $mes = "Julho"; break;

            case"08": $mes = "Agosto"; break;

            case"09": $mes = "Setembro"; break;

            case"10": $mes = "Outubro"; break;

            case"11": $mes = "Novembro"; break;

            case"12": $mes = "Dezembro"; break;
        }

        return utf8_encode($mes);
    }
}
