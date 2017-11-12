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
        'PostoSaude',
        'Prioridade',
        'StatusAgendamento'
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
        $especialistas = \DB::table('age_especialista')
            ->join('gen_cgm', 'gen_cgm.id', '=', 'age_especialista.cgm')
            ->select([
                'gen_cgm.nome',
                'age_especialista.id'
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

        $dataIni = isset($dados['data_inicio']) ? SerbinarioDateFormat::toUsa($dados['data_inicio']) : "";
        $dataFim = isset($dados['data_fim']) ? SerbinarioDateFormat::toUsa($dados['data_fim']) : "";

        $especialidade = isset($dados['especialidade']) ? $dados['especialidade'] : '';
        $especialista  = isset($dados['especialista']) ? $dados['especialista'] : '';
        $situacao      = isset($dados['situacao']) ? $dados['situacao'] : '';
        $prioridade    = isset($dados['prioridade']) ? $dados['prioridade'] : '';

        #Criando a consulta
        $rows = \DB::table('age_agendamento')
            ->join('age_calendario', 'age_calendario.id', '=', 'age_agendamento.calendario_id')
            ->join('age_fila', 'age_fila.id', '=', 'age_agendamento.fila_id')
            //->where('age_agendamento.status_agendamento_id', '3')
            ->select([
                \DB::raw('count(age_agendamento.id) as qtd'),
            ]);

        if($dataIni && $dataFim) {
            $rows->whereBetween('age_agendamento.data', array($dataIni, $dataFim));
        }

        if($especialidade) {
            $rows->join('age_mapas', 'age_calendario.id', '=', 'age_mapas.calendario_id');
            $rows->join('age_especialista_especialidade', 'age_especialista_especialidade.id', '=', 'age_mapas.especialidade_id');
            $rows->where('age_especialista_especialidade.especialidade_id', $especialidade);
        }

        if($especialista) {
            $rows->where('age_calendario.especialista_id', $especialista);
        }

        if($situacao) {
            $rows->where('age_agendamento.status_agendamento_id', $situacao);
        }

        if($prioridade) {
            $rows->where('age_fila.prioridade_id', $prioridade);
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
        $rows = \DB::table('age_fila')
            ->join('age_especialidade', 'age_especialidade.id', '=', 'age_fila.especialidade_id')
            ->where('age_fila.status', '0')
            ->select([
                \DB::raw('count(age_fila.id) as qtd'),
            ]);

        if($dataIni && $dataFim) {
            $rows->whereBetween('age_fila.data', array($dataIni, $dataFim));
        }

        if($especialidade) {
            $rows->where('age_especialidade.id', '=', $especialidade);
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
        $rows = \DB::table('age_fila')
            ->join('age_posto_saude', 'age_posto_saude.id', '=', 'age_fila.posto_saude_id')
            ->select([
                \DB::raw('count(age_fila.id) as qtd'),
            ]);

        if($dataIni && $dataFim) {
            $rows->whereBetween('age_fila.data', array($dataIni, $dataFim));
        }

        if($psf) {
            $rows->where('age_posto_saude.id', '=', $psf);
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
