<?php

namespace Seracademico\Http\Controllers;

use Illuminate\Http\Request;

use Seracademico\Http\Controllers\Controller;
use Seracademico\Http\Requests;
use Seracademico\Services\FilaService;
use Yajra\Datatables\Datatables;
use Prettus\Validator\Exceptions\ValidatorException;
use Prettus\Validator\Contracts\ValidatorInterface;
use Seracademico\Uteis\SerbinarioDateFormat;
use Illuminate\Support\Facades\Auth;

class GraficosController extends Controller
{


    /**
     * @var FilaService
     */
    private $service;

    /**
     * @var array
     */
    private $loadFields = [
        'TipoOperacao',
        'PostoSaude'
    ];

    /**
     * @var
     */
    private $user;

    /**
     * @param FilaService $service
     */
    public function __construct(FilaService $service)
    {
        $this->service = $service;
        $this->user    = Auth::user();
    }

    /**
     * @return mixed
     */
    public function qtdAtendimento()
    {
        $loadFields = $this->service->load($this->loadFields);

        // Pegando os especialistas
        $especialistas = \DB::table('especialista')
            ->join('cgm', 'cgm.id', '=', 'especialista.cgm')
            ->select([
                'cgm.nome',
                'especialista.id'
            ])->get();

        return view('graficos.chartQtdAtendimento', compact('loadFields', 'especialistas'));
    }

    /**
     * @return string
     */
    public function qtdAtendimentoAjax(Request $request)
    {

        $dados = $request->request->all();

        //Tratando as datas
        $dataIni = isset($dados['data_inicio']) ? SerbinarioDateFormat::toUsa($dados['data_inicio'], 'date') : "";
        $dataFim = isset($dados['data_fim']) ? SerbinarioDateFormat::toUsa($dados['data_fim'], 'date') : "";
        $especialidade = isset($dados['especialidade']) ? $dados['especialidade'] : '';
        $especialista  = isset($dados['especialista']) ? $dados['especialista'] : '';

        #Criando a consulta
        $rows = \DB::table('agendamento')
            ->join('calendario', 'calendario.id', '=', 'agendamento.calendario_id')
            ->join('fila', 'fila.id', '=', 'agendamento.fila_id')
            ->where('agendamento.status_agendamento_id', '3')
            ->select([
                \DB::raw('count(agendamento.id) as qtd'),
            ]);

        if($dataIni && $dataFim) {
            $rows->whereBetween('agendamento.data', array($dataIni, $dataFim));
        }

        if($especialidade) {
            $rows->join('mapas', 'calendario.id', '=', 'mapas.calendario_id');
            $rows->join('especialista_especialidade', 'especialista_especialidade.id', '=', 'mapas.especialidade_id');
            $rows->where('especialista_especialidade.especialidade_id', $especialidade);
        }

        if($especialista) {
            $rows->where('calendario.especialista_id', '=', $especialista);
        }

        $rows = $rows->first();

        $nomes = [];
        $data = [];

        //foreach ($rows as $row) {
            $nomes[] = 'Quantidade';
            $data[] = $rows->qtd;
       // }

        return response()->json([$nomes, $data]);
    }

    /**
     * @return mixed
     */
    public function qtdPessoasNaFila()
    {
        $loadFields = $this->service->load($this->loadFields);

        return view('graficos.chartQtdPessoasNaFila', compact('loadFields'));
    }

    /**
     * @return string
     */
    public function qtdPessoasNaFilaAjax(Request $request)
    {

        $dados = $request->request->all();

        //Tratando as datas
        $dataIni = isset($dados['data_inicio']) ? SerbinarioDateFormat::toUsa($dados['data_inicio'], 'date') : "";
        $dataFim = isset($dados['data_fim']) ? SerbinarioDateFormat::toUsa($dados['data_fim'], 'date') : "";
        $especialidade = isset($dados['especialidade']) ? $dados['especialidade'] : '';

        #Criando a consulta
        $rows = \DB::table('fila')
            ->join('especialidade', 'especialidade.id', '=', 'fila.especialidade_id')
            ->where('fila.status', '0')
            ->select([
                \DB::raw('count(fila.id) as qtd'),
            ]);

        if($dataIni && $dataFim) {
            $rows->whereBetween('fila.data', array($dataIni, $dataFim));
        }

        if($especialidade) {
            $rows->where('especialidade.id', '=', $especialidade);
        }


        $rows = $rows->first();

        $nomes = [];
        $data = [];

        //foreach ($rows as $row) {
        $nomes[] = 'Quantidade';
        $data[] = $rows->qtd;
        // }

        return response()->json([$nomes, $data]);
    }

    /**
     * @return mixed
     */
    public function qtdPacientes()
    {
        $loadFields = $this->service->load($this->loadFields);

        return view('graficos.chartQtdPacientes', compact('loadFields'));
    }

    /**
     * @return string
     */
    public function qtdPacientesAjax(Request $request)
    {

        $dados = $request->request->all();

        //Tratando as datas
        $dataIni = isset($dados['data_inicio']) ? SerbinarioDateFormat::toUsa($dados['data_inicio'], 'date') : "";
        $dataFim = isset($dados['data_fim']) ? SerbinarioDateFormat::toUsa($dados['data_fim'], 'date') : "";
        $psf = isset($dados['psf']) ? $dados['psf'] : '';

        #Criando a consulta
        $rows = \DB::table('fila')
            ->join('posto_saude', 'posto_saude.id', '=', 'fila.posto_saude_id')
            ->select([
                \DB::raw('count(fila.id) as qtd'),
            ]);

        if($dataIni && $dataFim) {
            $rows->whereBetween('fila.data', array($dataIni, $dataFim));
        }

        if($psf) {
            $rows->where('posto_saude.id', '=', $psf);
        }


        $rows = $rows->first();

        $nomes = [];
        $data = [];

        //foreach ($rows as $row) {
        $nomes[] = 'Quantidade';
        $data[] = $rows->qtd;
        // }

        return response()->json([$nomes, $data]);
    }
}
