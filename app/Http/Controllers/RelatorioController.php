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

            #Criando a consulta
            $rows = \DB::table('age_agendamento')
                ->join('age_fila', 'age_fila.id', '=', 'age_agendamento.fila_id')
                ->join('gen_cgm', 'gen_cgm.id', '=', 'age_fila.cgm_id')
                ->join('age_especialidade', 'age_especialidade.id', '=', 'age_fila.especialidade_id')
                ->join('age_operacoes', 'age_operacoes.id', '=', 'age_especialidade.operacao_id')
                ->join('age_prioridade', 'age_prioridade.id', '=', 'age_fila.prioridade_id')
                ->leftJoin('age_posto_saude', 'age_posto_saude.id', '=', 'age_fila.posto_saude_id')
                ->join('age_calendario', 'age_calendario.id', '=', 'age_agendamento.calendario_id')
                ->join('age_localidade', 'age_localidade.id', '=', 'age_calendario.localidade_id')
                ->join('age_especialista', 'age_especialista.id', '=', 'age_calendario.especialista_id')
                ->join('gen_cgm as cgm_especialista', 'cgm_especialista.id', '=', 'age_especialista.cgm')
                ->join('age_status_agendamento', 'age_status_agendamento.id', '=', 'age_agendamento.status_agendamento_id')
                ->join('age_mapas', 'age_mapas.id', '=', 'age_agendamento.mapa_id')
                ->select([
                    'age_agendamento.id',
                    'age_mapas.horario',
                    'age_localidade.nome as localidade',
                    'gen_cgm.nome as nome',
                    'gen_cgm.numero_sus',
                    'age_operacoes.nome as especialidade'
                ]);

            if($request->has('especialista') && $request->get('especialista') != "") {
                $rows->where('age_especialista.id', $request->get('especialista'));
            }

            if($request->has('localidade') && $request->get('localidade') != "") {
                $rows->where('age_calendario.id', $request->get('localidade'));
            }

            if($request->has('horario') && $request->get('horario') != "") {
                $rows->where('age_mapas.id', $request->get('horario'));
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
    public function reportPdfByAgenda(Request $request)
    {
        try {
            #Criando a consulta
            $pacientes = \DB::table('age_agendamento')
                ->join('age_fila', 'age_fila.id', '=', 'age_agendamento.fila_id')
                ->join('gen_cgm', 'gen_cgm.id', '=', 'age_fila.cgm_id')
                ->join('age_especialidade', 'age_especialidade.id', '=', 'age_fila.especialidade_id')
                ->join('age_operacoes', 'age_operacoes.id', '=', 'age_especialidade.operacao_id')
                ->join('age_prioridade', 'age_prioridade.id', '=', 'age_fila.prioridade_id')
                ->leftJoin('age_posto_saude', 'age_posto_saude.id', '=', 'age_fila.posto_saude_id')
                ->join('age_calendario', 'age_calendario.id', '=', 'age_agendamento.calendario_id')
                ->join('age_localidade', 'age_localidade.id', '=', 'age_calendario.localidade_id')
                ->join('age_especialista', 'age_especialista.id', '=', 'age_calendario.especialista_id')
                ->join('gen_cgm as cgm_especialista', 'cgm_especialista.id', '=', 'age_especialista.cgm')
                ->join('age_status_agendamento', 'age_status_agendamento.id', '=', 'age_agendamento.status_agendamento_id')
                ->join('age_mapas', 'age_mapas.id', '=', 'age_agendamento.mapa_id')
                ->leftJoin('age_sub_operacoes', 'age_sub_operacoes.id', '=', 'age_agendamento.sub_operacao_id')
                ->where('age_especialista.id', $request->get('especialista'))
                ->where('age_calendario.id', $request->get('localidade'))
                ->where('age_mapas.id', $request->get('horario'))
                ->select([
                    'age_agendamento.id',
                    'age_mapas.horario',
                    'age_localidade.nome as localidade',
                    'gen_cgm.nome as nome',
                    'gen_cgm.numero_sus',
                    'gen_cgm.fone',
                    'age_operacoes.nome as especialidade',
                    'cgm_especialista.nome as especialista',
                    'age_mapas.horario',
                    'age_status_agendamento.nome as status',
                    'age_sub_operacoes.nome as suboperacao'
                ])->get();

            //$pacientes = $rows->get();

            # Recuperando o serviço de pdf / dompdf
            //$PDF = App::make('dompdf.wrapper');

            # Carregando a página
            //$PDF->loadView('reports.viewPdfReportByAgenda', ['pacientes' => $pacientes]);

            return \PDF::loadView('reports.viewPdfReportByAgenda', compact('pacientes'))->setOrientation('landscape')->stream();
            # Retornando para página
           // return $PDF->stream();

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
            $especialistas = \DB::table('age_especialista')
                ->join('gen_cgm', 'gen_cgm.id', '=', 'age_especialista.cgm')
                ->select([
                    'age_especialista.id',
                    'gen_cgm.nome'
                ])->get();

            // Montando array com resultado da pesquisa
            foreach ($especialistas as $especialista) {
                $arrayEspecialistas[$especialista->id] = $especialista->nome;
            }

            // Retorno
            return $arrayEspecialistas;

        } catch (\Throwable $e) {
            return $e->getMessage();
        }
    }
}