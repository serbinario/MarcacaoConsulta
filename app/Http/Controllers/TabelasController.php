<?php

namespace Seracademico\Http\Controllers;

use Illuminate\Http\Request;

use Seracademico\Entities\Agendamento;
use Seracademico\Http\Controllers\Controller;
use Seracademico\Http\Requests;
use Seracademico\Services\AgendamentoService;
use Yajra\Datatables\Datatables;
use Prettus\Validator\Exceptions\ValidatorException;
use Prettus\Validator\Contracts\ValidatorInterface;
use Seracademico\Uteis\SerbinarioDateFormat;

class TabelasController extends Controller
{

    /**
     * @var AgendamentoService
     */
    private $service;

    /**
     * @var array
     */
    private $loadFields = [
        'StatusAgendamento',
        'TipoOperacao'
    ];

    /**
     * @param AgendamentoService $service
     */
    public function __construct(AgendamentoService $service)
    {
        $this->service   =  $service;
    }

    /**
     * @return string
     */
    public function procedimentoView()
    {
        $loadFields = $this->service->load($this->loadFields);
        
        return view('tabelas.procedimentos', compact('loadFields'));
    }

    /**
     * @return string
     */
    public function procedimentos(Request $request)
    {
        $loadFields = $this->service->load($this->loadFields);
        
        $dados = $request->request->all();
        $procedimento = isset($dados['operacao']) ? $dados['operacao'] : "";
        $situacao     = isset($dados['situacao']) ? $dados['situacao'] : "";

        //Tratando as datas
        $dataIni = isset($dados['data_inicio']) ? SerbinarioDateFormat::toUsa($dados['data_inicio'], 'date') : "";
        $dataFim = isset($dados['data_fim']) ? SerbinarioDateFormat::toUsa($dados['data_fim'], 'date') : "";

        $procedimentoFirst = \DB::table('age_operacoes')
            ->where('age_operacoes.id', $procedimento)->select(['nome'])->first();

        $situacaoFirst = \DB::table('age_status_agendamento')
            ->where('age_status_agendamento.id', $situacao)->select(['nome'])->first();

        #Criando a consulta
        $rows = \DB::table('age_agendamento')
            ->join('age_sub_operacoes', 'age_sub_operacoes.id', '=', 'age_agendamento.sub_operacao_id')
            ->join('age_operacoes', 'age_operacoes.id', '=', 'age_sub_operacoes.operacao_id')
            ->join('age_status_agendamento', 'age_status_agendamento.id', '=', 'age_agendamento.status_agendamento_id')
            ->where('age_operacoes.id', '=', $procedimento)
            ->groupBy('age_agendamento.sub_operacao_id')
            ->select([
                'age_sub_operacoes.nome as suboperacao',
                'age_sub_operacoes.id as suboperacao_id',
                \DB::raw('count(age_agendamento.id) as qtd'),
            ]);

        if($dataIni && $dataFim) {
            $rows->whereBetween('age_agendamento.data', array($dataIni, $dataFim));
        }

        if($situacao) {
            $rows->where('age_status_agendamento.id', $situacao);
        }

        $rows = $rows->get();

        $totalAgendamentos = 0;

        foreach ($rows as $row) {
            $totalAgendamentos += $row->qtd;
        }
        
        return view('tabelas.procedimentos',
            compact('procedimentoFirst', 'situacaoFirst',
                'rows', 'totalAgendamentos', 'loadFields'), ['request' => $request]);
    }
}
