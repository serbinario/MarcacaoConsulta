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
        $situacoes = \DB::table('status_agendamento')->select()->get();

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
        $situacoes = \DB::table('status_agendamento')->select()->get();

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
            ->join('mapas', 'mapas.id', '=', 'agendamento.mapa_id')
            ->select([
                'agendamento.id',
                'cgm.nome',
                'cgm.numero_sus',
                'operacoes.nome as especialidade',
                'prioridade.nome as prioridade',
                'posto_saude.nome as psf',
                \DB::raw('DATE_FORMAT(calendario.data,"%d/%m/%Y") as data'),
                'mapas.horario',
                'cgm_especialista.nome as especialista',
                'status_agendamento.nome as status',
                'status_agendamento.id as status_id'
            ]);

        if($dataIni && $dataFim) {
            $rows->whereBetween('calendario.data', array($dataIni, $dataFim));
        }

        if($request->has('data_unica') && $request->get('data_unica') != "") {
            $rows->where('calendario.data', '=', $request->get('data_unica'));
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

        if($request->has('localidade') && $request->get('localidade') != "") {
            $rows->where('localidade.id', $request->get('localidade'));
        }

        if($request->has('especialista') && $request->get('especialista') != "") {
            $rows->where('especialista.id', $request->get('especialista'));
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
                        ->orWhere('cgm.numero_sus', 'like', "%$search%");
                });

            }
        })->addColumn('action', function ($row) {

            $html = "";

            # Habilita a opção de deletar apenas se o paciente estiver com status de (aguardando atendimento)
            if($row->status_id == '1' || $this->user->is('admin')) {
                $html .= '<a href="delete/'.$row->id.'" class="btn btn-xs btn-danger excluir"><i class="glyphicon glyphicon-remove"></i></a> ';
            }

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
