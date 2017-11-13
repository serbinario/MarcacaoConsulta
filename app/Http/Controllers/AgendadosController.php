<?php

namespace Seracademico\Http\Controllers;

use Composer\Repository\Pear\PackageDependencyParser;
use Illuminate\Http\Request;

use Seracademico\Http\Requests;
use Illuminate\Support\Facades\Auth;
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
        'TipoOperacao',
        'Localidade'
    ];

    /**
     * @var
     */
    private $user;

    /**
     * @param AgendamentoService $service
     * @param AgendamentoRepository $repository
     */
    public function __construct(AgendamentoService $service, AgendamentoRepository $repository)
    {
        $this->service      =  $service;
        $this->repository   =  $repository;
        $this->user         = Auth::user();
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        #Carregando os dados para o cadastro
        $loadFields = $this->service->load($this->loadFields);

        #Carregando a situação do agendamento
        $situacoes = \DB::table('age_status_agendamento')->select()->get();

        return view('agendamento.pacientes_agendados', compact('loadFields', 'situacoes'));
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function indexDois()
    {
        #Carregando os dados para o cadastro
        $loadFields = $this->service->load($this->loadFields);

        #Carregando a situação do agendamento
        $situacoes = \DB::table('age_status_agendamento')->select()->get();

        return view('agendamento.pacientes_agendados_calendario', compact('loadFields', 'situacoes'));
    }

    /**
     * @return mixed
     */
    public function grid(Request $request)
    {

        //Tratando as datas
        $dataIni    = SerbinarioDateFormat::toUsa($request->get('data_inicio'));
        $dataFim    = SerbinarioDateFormat::toUsa($request->get('data_fim'));
        //$dataUnica  = SerbinarioDateFormat::toUsa($request->get('data_unica'));

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
            ->leftJoin('age_sub_operacoes', 'age_sub_operacoes.id', '=', 'age_agendamento.sub_operacao_id')
            ->select([
                'age_agendamento.id',
                'age_fila.id as fila_id',
                'gen_cgm.nome',
                'gen_cgm.numero_sus',
                'age_operacoes.nome as especialidade',
                'age_prioridade.nome as prioridade',
                'age_posto_saude.nome as psf',
                \DB::raw('DATE_FORMAT(age_calendario.data,"%d/%m/%Y") as data'),
               // \DB::raw('IF(age_agendamento.sub_operacao_id, operacoes.nome, CONCAT(operacoes.nome, " ", sub_operacoes.nome))  as especialidade'),
                'age_mapas.horario',
                'cgm_especialista.nome as especialista',
                'age_status_agendamento.nome as status',
                'age_status_agendamento.id as status_id',
                'age_especialidade.id as exame',
                'age_agendamento.obs_atendimento',
                'age_sub_operacoes.nome as sub_operacao',
            ]);

        if($dataIni && $dataFim) {
            $rows->whereBetween('age_calendario.data', array($dataIni, $dataFim));
        }

        if($request->has('data_unica') && $request->get('data_unica') != "") {
            $rows->where('age_calendario.data', '=', $request->get('data_unica'));
        }

        if($request->has('exame') && $request->get('exame') != "") {
            $rows->where('age_especialidade.id', $request->get('exame'));
        }

        if($request->has('prioridade') && $request->get('prioridade') != "") {
            $rows->where('age_prioridade.id', $request->get('prioridade'));
        }

        if($request->has('psf') && $request->get('psf') != "") {
            $rows->where('age_posto_saude.id', $request->get('psf'));
        }

        if($request->has('situacao') && $request->get('situacao') != "") {
            $rows->where('age_status_agendamento.id', $request->get('situacao'));
        }

        if($request->has('localidade') && $request->get('localidade') != "") {
            $rows->where('age_localidade.id', $request->get('localidade'));
        }

        if($request->has('especialista') && $request->get('especialista') != "") {
            $rows->where('age_especialista.id', $request->get('especialista'));
        }


        #Editando a grid
        return Datatables::of($rows)->filter(function ($query) use ($request) {
            // Filtrando Global
            if ($request->has('globalSearch')) {

                # recuperando o valor da requisição
                $search = $request->get('globalSearch');

                #condição
                $query->where(function ($where) use ($search) {
                    $where->orWhere('gen_cgm.nome', 'like', "%$search%")
                        ->orWhere('cgm_especialista.nome', 'like', "%$search%")
                        ->orWhere('gen_cgm.numero_sus', 'like', "%$search%");
                });

            }
        })->addColumn('action', function ($row) {

            $html = "";

            # Habilita a opção de deletar apenas se o paciente estiver com status de (aguardando atendimento)
            if($row->status_id == '1' || $this->user->is('admin')) {
                $html .= '<a href="delete/'.$row->id.'" class="btn btn-xs btn-danger excluir"><i class="glyphicon glyphicon-remove"></i></a> ';
            }

            # Habilita a opção de inserir observação se o paciente estiver com status de (não atendido)
            if($row->status_id == '4' && $this->user->is('admin|master')) {
                $html .= '<a title="Inserir observação" id="inserirObservacao" class="btn btn-xs btn-primary"><i class="glyphicon glyphicon-edit"></i></a>';
            }

            return $html;


        })->make(true);
    }


    /**
     * @param Request $request
     * @return mixed
     */
    public function alterarSituacao(Request $request)
    {
        try {

            #Recuperando os dados da requisição
            $data = $request->all();

            // Trata a ação se for para definição de atendimento ou para inserir observação de atendimento
            if ($data['situacao']) {

                // Alterando a situação dos pacientes
                foreach($data['pacientes'] as $paciente) {
                    $agendamento = $this->repository->find($paciente);
                    $agendamento->status_agendamento_id = $data['situacao'];
                    $agendamento->save();
                }

            } else {

                // Inserindo observação de atendimento no pacientes
                $agendamento = $this->repository->find($data['paciente']);
                $agendamento->obs_atendimento = $data['observacao'];
                $agendamento->save();

            }

            # Retorno
            return \Illuminate\Support\Facades\Response::json(['success' => true]);
        } catch (\Throwable $e) {
            return \Illuminate\Support\Facades\Response::json(['error' => $e->getMessage()]);
        }
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function InserirNaFila(Request $request)
    {
        try {

            #Recuperando os dados da requisição
            $data = $request->all();

            #Executando da ação
            $retorno = $this->service->InserirNaFila($data);

            // Validando o retorno
            if($retorno) {
                return \Illuminate\Support\Facades\Response::json(['success' => true]);
            } else {
                return \Illuminate\Support\Facades\Response::json(['success' => false]);
            }

        } catch (\Throwable $e) {
            return \Illuminate\Support\Facades\Response::json(['error' => $e->getMessage()]);
        }
    }

    /**
     * @param Request $request
     * @param $id
     * @return $this|\Illuminate\Http\RedirectResponse
     */
    public function delete($id)
    {
        try {

            #Executando a ação
            $this->service->delete($id);

            #Retorno para a view
            return \Illuminate\Support\Facades\Response::json(['success' => true]);
        } catch (\Throwable $e) {
            return \Illuminate\Support\Facades\Response::json(['error' => $e->getMessage()]);
        }
    }
}
