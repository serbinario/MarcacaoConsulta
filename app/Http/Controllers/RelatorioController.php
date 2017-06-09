<?php

namespace Seracademico\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\App;
use Seracademico\Http\Requests;
use Seracademico\Http\Controllers\Controller;
use Yajra\Datatables\Datatables;
use Seracademico\Services\RelatorioService;

class RelatorioController extends Controller
{
    /**
     * @var array
     */
    private $loadFields = [
        'CGM'
    ];

    /**
     * @var
     */
    private $service;

    /**
     * @param RelatorioService $service
     */
    public function __construct(RelatorioService $service)
    {
        $this->service = $service;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function indexByAgenda()
    {
        #Carregando os dados para o cadastro
        $loadFields = $this->service->load($this->loadFields);
        $especialistas = $this->getEspecialistas();

        #Retorno para view
        return view('reports.viewReportByAgenda', compact('loadFields', 'especialistas'));
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function reportPdf()
    {
        #Retorno para view
        return view('reports.viewPdfReportByAgenda');
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function indexByQuantidade()
    {
        #Retorno para view
        return view('reports.viewReportByQuantidade');
    }

    /**
     *  Dados que alimentam a grid de relatório de acordo com o especialista selecionado
     *  Menu > relatorios > por agenda > pesquisar
     */
    public function gridReportByAgenda(Request $request)
    {
        try {

            dd($request->request->all());

            #Criando a consulta
            $rows = \DB::table('agendamento')
                ->join('fila', 'fila.id', '=', 'agendamento.fila_id')
                ->join('cgm', 'cgm.id', '=', 'fila.cgm_id')
                ->join('especialidade', 'especialidade.id', '=', 'fila.especialidade_id')
                ->join('operacoes', 'operacoes.id', '=', 'especialidade.operacao_id')
                ->join('prioridade', 'prioridade.id', '=', 'fila.prioridade_id')
                ->leftJoin('posto_saude', 'posto_saude.id', '=', 'fila.posto_saude_id')
                ->join('calendario', 'calendario.id', '=', 'agendamento.calendario_id')
                ->join('localidade', 'localidade.id', '=', 'calendario.localidade_id')
                ->join('especialista', 'especialista.id', '=', 'calendario.especialista_id')
                ->join('cgm as cgm_especialista', 'cgm_especialista.id', '=', 'especialista.cgm')
                ->join('status_agendamento', 'status_agendamento.id', '=', 'agendamento.status_agendamento_id')
                //->join('especialista_especialidade', 'especialista.id', '=', 'calendario.especialista_id')
                ->select([
                    'agendamento.id',
                    'agendamento.hora',
                    'localidade.nome as localidade',
                    'cgm.nome as nome',
                    'cgm.numero_sus',
                    'operacoes.nome as especialidade'
                ]);

            if($request->has('especialista') && $request->get('especialista') != "") {
                $rows->where('especialista.id', $request->get('especialista'));
            }

            if($request->has('localidade') && $request->get('localidade') != "") {
                $rows->where('calendario.id', $request->get('localidade'));
            }

            if($request->has('horario') && $request->get('horario') != "") {
                $rows->where(function ($query) use ($request) {
                    $query->orWhere('calendario.hora', '=', $request->get('horario'))
                        ->orWhere('calendario.hora2',  '=', $request->get('horario'));
                });
            }


            #Editando a grid
            return Datatables::of($rows)->addColumn('action', function ($row) {
                //return '<a href="edit/'.$row->id.'" class="btn btn-xs btn-primary"><i class="glyphicon glyphicon-edit"></i> Editar</a>';
            })->make(true);

        } catch (\Throwable $e) {
            return $e->getMessage();
        }
    }

    /**
     *  Dados que irão preencher o relatório gerado em pdf
     *  Menu > relatorios > por agenda > gerar pdf
     */
    public function getReportByAgenda($idEspecialista)
    {
        try {
            #Criando a consulta
            $rows = \DB::table('agendamento')
                ->join('fila', 'fila.id', '=', 'agendamento.fila_id')
                ->join('especialidade', 'especialidade.id', '=', 'fila.especialidade_id')
                ->join('operacoes', 'operacoes.id', '=', 'especialidade.operacao_id')
                ->join('cgm', 'cgm.id', '=', 'fila.cgm_id')
                ->join('calendario', 'calendario.id', '=', 'agendamento.calendario_id')
                ->join('localidade', 'localidade.id', '=', 'calendario.localidade_id')
                ->join('especialista', 'especialista.id', '=', 'calendario.especialista_id')
                ->join('especialista_especialidade', 'especialista.id', '=', 'especialista_especialidade.especialista_id')
                ->select([
                    'agendamento.id',
                    'agendamento.hora',
                    'localidade.nome as localidade',
                    'cgm.nome as nomePaciente',
                    'cgm.numero_sus',
                    'operacoes.nome as especialidade'
                ])
                ->where('agendamento.id', '=', $idEspecialista);

            $pacientes = $rows->get();

            # Recuperando o serviço de pdf / dompdf
            $PDF = App::make('dompdf.wrapper');

            # Carregando a página
            $PDF->loadView('reports.viewPdfReportByAgenda', ['pacientes' => $pacientes]);

            # Retornando para página
            return $PDF->stream();

        } catch (\Throwable $e) {
            return $e->getMessage();
        }
    }

    /**
     * @return array|string
     */
    public function getEspecialistas()
    {
        //Variavel global p/ uso
        $arrayEspecialistas = [];

        try {
            $especialistas = \DB::table('especialista')
                ->join('cgm', 'cgm.id', '=', 'especialista.cgm')
                ->select([
                    'especialista.id',
                    'cgm.nome'
                ])
                ->get();

            //Montando array com resultado da pesquisa
            foreach ($especialistas as $especialista) {
                $arrayEspecialistas[$especialista->id] = $especialista->nome;
            }

            //Retorno
            return $arrayEspecialistas;

        } catch (\Throwable $e) {
            return $e->getMessage();
        }
    }
}