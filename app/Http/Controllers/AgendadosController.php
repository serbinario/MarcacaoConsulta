<?php

namespace Seracademico\Http\Controllers;

use Composer\Repository\Pear\PackageDependencyParser;
use Illuminate\Http\Request;

use Seracademico\Http\Requests;
use Seracademico\Repositories\AgendamentoRepository;
use Seracademico\Services\AgendamentoService;
use Yajra\Datatables\Datatables;
use Prettus\Validator\Exceptions\ValidatorException;
use Prettus\Validator\Contracts\ValidatorInterface;
use Seracademico\Uteis\SerbinarioDateFormat;

class AgendadosController extends Controller
{
    /**
    * @var AgendamentoService
    */
    private $service;


    /**
     * @var AgendamentoRepository
     */
    private $repository;

    /**
    * @var array
    */
    private $loadFields = [
        'StatusAgendamento',
        'Prioridade',
        'PostoSaude',
        'TipoOperacao'
    ];

    /**
     * @param AgendamentoService $service
     * @param AgendamentoRepository $repository
     */
    public function __construct(AgendamentoService $service, AgendamentoRepository $repository)
    {
        $this->service      =  $service;
        $this->repository   =  $repository;
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        #Carregando os dados para o cadastro
        $loadFields = $this->service->load($this->loadFields);

        #Carregando a situação do agendamento
        $situacoes = \DB::table('status_agendamento')->select()->get();

        return view('agendamento.pacientes_agendados', compact('loadFields', 'situacoes'));
    }

    /**
     * @return mixed
     */
    public function grid(Request $request)
    {

        //Tratando as datas
        $dataIni = SerbinarioDateFormat::toUsa($request->get('data_inicio'));
        $dataFim = SerbinarioDateFormat::toUsa($request->get('data_fim'));

        #Criando a consulta
        $rows = \DB::table('agendamento')
            ->join('fila', 'fila.id', '=', 'agendamento.fila_id')
            ->join('cgm', 'cgm.id', '=', 'fila.cgm_id')
            ->join('especialidade', 'especialidade.id', '=', 'fila.especialidade_id')
            ->join('operacoes', 'operacoes.id', '=', 'especialidade.operacao_id')
            ->join('prioridade', 'prioridade.id', '=', 'fila.prioridade_id')
            ->leftJoin('posto_saude', 'posto_saude.id', '=', 'fila.posto_saude_id')
            ->join('calendario', 'calendario.id', '=', 'agendamento.calendario_id')
            ->join('especialista', 'especialista.id', '=', 'calendario.especialista_id')
            ->join('cgm as cgm_especialista', 'cgm_especialista.id', '=', 'especialista.cgm')
            ->join('status_agendamento', 'status_agendamento.id', '=', 'agendamento.status_agendamento_id')
            ->select([
                'agendamento.id',
                'cgm.nome',
                'operacoes.nome as especialidade',
                'prioridade.nome as prioridade',
                'posto_saude.nome as psf',
                \DB::raw('DATE_FORMAT(calendario.data,"%d/%m/%Y") as data'),
                'agendamento.hora',
                'cgm_especialista.nome as especialista',
                'status_agendamento.nome as status'
            ]);

        if($dataIni && $dataFim) {
            $rows->whereBetween('fila.data', array($dataIni, $dataFim));
        }

        if($request->has('exame') && $request->get('exame') != "") {
            $rows->where('especialidade.id', $request->get('exame'));
        }

        if($request->has('prioridade') && $request->get('prioridade') != "") {
            $rows->where('prioridade.id', $request->get('prioridade'));
        }

        if($request->has('psf') && $request->get('psf') != "") {
            $rows->where('posto_saude.id', $request->get('psf'));
        }

        if($request->has('situacao') && $request->get('situacao') != "") {
            $rows->where('status_agendamento.id', $request->get('situacao'));
        }

        #Editando a grid
        return Datatables::of($rows)->filter(function ($query) use ($request) {
            // Filtrando Global
            if ($request->has('globalSearch')) {
                # recuperando o valor da requisição
                $search = $request->get('globalSearch');

                #condição
                $query->where(function ($where) use ($search) {
                    $where->orWhere('cgm.nome', 'like', "%$search%")
                        ->orWhere('cgm_especialista.nome', 'like', "%$search%")
                    ;
                });

            }
        })->addColumn('action', function ($row) {

            $html = "";
            $html .= '<a href="edit/'.$row->id.'" class="btn btn-xs btn-primary"><i class="glyphicon glyphicon-edit"></i> Editar</a> ';

            return $html;


        })->make(true);
    }


    /**
     * @param Request $request
     * @return $this|array|\Illuminate\Http\RedirectResponse
     */
    public function alterarSituacao(Request $request)
    {
        try {
            #Recuperando os dados da requisição
            $data = $request->all();

            // Alterando a situação dos pacientes
            foreach($data['pacientes'] as $paciente) {
                $agendamento = $this->repository->find($paciente);
                $agendamento->status_agendamento_id = $data['situacao'];
                $agendamento->save();
            }

            # Retorno
            return \Illuminate\Support\Facades\Response::json(['success' => true]);
        } catch (\Throwable $e) {
            return \Illuminate\Support\Facades\Response::json(['error' => $e->getMessage()]);
        }
    }

}
