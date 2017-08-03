<?php

namespace Seracademico\Http\Controllers;

use Illuminate\Http\Request;

use Seracademico\Entities\Especialista;
use Seracademico\Http\Requests;
use Seracademico\Repositories\CalendarioRepository;
use Seracademico\Repositories\FilaRepository;
use Seracademico\Services\CalendarioService;
use Seracademico\Services\EspecialistaService;
use Yajra\Datatables\Datatables;
use Prettus\Validator\Exceptions\ValidatorException;
use Prettus\Validator\Contracts\ValidatorInterface;
use Seracademico\Validators\CalendarioValidator;
use Seracademico\Uteis\SerbinarioDateFormat;

class CalendarioController extends Controller
{
    /**
    * @var CalendarioService
    */
    private $service;

    /**
    * @var CalendarioValidator
    */
    private $validator;

    /**
     * @var EspecialistaService
     */
    private $espSservice;

    /**
     * @var CalendarioRepository
     */
    private $repository;

    /**
     * @var FilaRepository
     */
    private $filaRepository;

    /**
    * @var array
    */
    private $loadFields = [
        'Status'
    ];

    /**
    * @param CalendarioService $service
    * @param CalendarioValidator $validator
    */
    public function __construct(CalendarioService $service,
                                CalendarioValidator $validator,
                                EspecialistaService $espSservice,
                                CalendarioRepository $repository,
                                FilaRepository $filaRepository)
    {
        $this->service          =  $service;
        $this->validator        =  $validator;
        $this->espSservice      =  $espSservice;
        $this->repository       =  $repository;
        $this->filaRepository   =  $filaRepository;
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index($id)
    {

        #Carregando os dados para o cadastro
        $loadFields = $this->service->load($this->loadFields);

        $especialista = $this->espSservice->find($id);

        return view('calendario.calendarioMedico', compact('especialista', 'loadFields'));
    }

    /**
     * @return mixed
     */
    public function gridCalendario(Request $request, $id)
    {

        //Tratando as datas
        $dataIni = SerbinarioDateFormat::toUsa($request->get('data_inicio'));
        $dataFim = SerbinarioDateFormat::toUsa($request->get('data_fim'));

        $rows = \DB::table('age_calendario')
            ->join('age_especialista', 'age_especialista.id', '=', 'age_calendario.especialista_id')
            ->join('gen_cgm', 'gen_cgm.id', '=', 'age_especialista.cgm')
            ->join('age_localidade', 'age_localidade.id', '=', 'age_calendario.localidade_id')
            ->leftJoin('age_status', 'age_status.id', '=', 'age_calendario.status_id')
            ->where('age_calendario.especialista_id', '=', $id)
            ->select([
                'age_calendario.id',
                'age_calendario.qtd_vagas',
                'age_calendario.mais_mapa',
                'age_status.nome as status',
                \DB::raw('DATE_FORMAT(age_calendario.data,"%d/%m/%Y") as data'),
                'gen_cgm.nome',
                'age_localidade.nome as localidade',
            ]);

        // Por período de data
        if($dataIni && $dataFim) {
            $rows->whereBetween('age_calendario.data', array($dataIni, $dataFim));
        }

        // Filtrar por especialidade
        if($request->has('especialidade') && $request->get('especialidade') != "") {
            $rows->join('age_mapas', 'age_mapas.calendario_id', '=', 'age_calendario.id');
            $rows->where('age_mapas.especialidade_id', $request->get('especialidade'));
            $rows->groupBy('age_calendario.id');
        }

        // Filtrar por status
        if($request->has('status') && $request->get('status') != "") {
            $rows->where('age_status.id', $request->get('status'));
        }

        #Editando a grid
        return Datatables::of($rows)
            ->addColumn('action', function ($row) {
                $calendario = $this->repository->find($row->id);

                $html = "";
                // Valida se o calendario esta bloqueado, caso sim, esse paciente recebe o direito de ser reagendado
                if (count($calendario->agendamento) <= 0) {
                    $html .= '<a href="/serbinario/calendario/deletar/'.$row->id.'" title="Remover" class="btn btn-xs btn-primary excluir"><i class="glyphicon glyphicon-remove"></i></a>';
                }

                return $html;

            })
            ->addColumn('mapas', function ($row) {

                $html = "";

                // Seleciona os mapas
                $mapas = \DB::table('age_mapas')
                    ->where('age_mapas.calendario_id', '=', $row->id)
                    ->select([
                        "id",
                        'horario'
                    ])->get();

                // Processando os mapas
                foreach ($mapas as $mapa) {
                    $html .= $mapa->horario ."<br />";
                }

                return $html;

            })->addColumn('especialidades', function ($row) {


                $html = "";

                // Pega a especilidade do primeiro mapa
                $mapas = \DB::table('age_mapas')
                    ->join('age_especialista_especialidade', 'age_especialista_especialidade.id', '=', 'age_mapas.especialidade_id')
                    ->join('age_especialidade', 'age_especialidade.id', '=', 'age_especialista_especialidade.especialidade_id')
                    ->join('age_operacoes', 'age_operacoes.id', '=', 'age_especialidade.operacao_id')
                    ->where('age_mapas.calendario_id', '=', $row->id)
                    ->select([
                        "age_operacoes.nome",
                        'age_mapas.horario'
                    ])->get();

                // Processando os mapas
                foreach ($mapas as $mapa) {
                    $html .= $mapa->horario ." : ". $mapa->nome ."<br />";
                }

                return $html;

            })->addColumn('agendamentos', function ($row) {

                $html = "";

                // Seleciona os mapas
                $mapas = \DB::table('age_mapas')
                    ->where('age_mapas.calendario_id', '=', $row->id)
                    ->select([
                        "id",
                        'horario'
                    ])->get();


                // Processando os mapas
                foreach ($mapas as $mapa) {

                    $agendamento = \DB::table('age_agendamento')
                        ->join('age_calendario', 'age_calendario.id', '=', 'age_agendamento.calendario_id')
                        ->where('age_agendamento.mapa_id', '=', $mapa->id)
                        ->where('age_calendario.id', '=', $row->id)
                        ->select([
                            \DB::raw('count(age_agendamento.id) as qtdAgendados'),
                        ])->first();

                    $html .= $mapa->horario ." : ". $agendamento->qtdAgendados ."<br />";
                }

                return $html;

            })->addColumn('vagas', function ($row) {

                $html = "";

                // Seleciona os mapas
                $mapas = \DB::table('age_mapas')
                    ->where('age_mapas.calendario_id', '=', $row->id)
                    ->select([
                        "id",
                        'vagas',
                        'horario'
                    ])->get();

                // Processando os mapas
                foreach ($mapas as $mapa) {
                    $html .= $mapa->horario ." : ". $mapa->vagas ."<br />";
                }

                return $html;

            })->make(true);
    }

    /**
     * @param Request $request
     * @return $this|array|\Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        try {
            #Recuperando os dados da requisição
            $data = $request->all();

            #Validando a requisição
            $this->validator->with($data)->passesOrFail(ValidatorInterface::RULE_CREATE);

            #Executando a ação
            $this->service->store($data['calendario']);

            #Retorno para a view
            return array('msg' => 'sucesso');
        } catch (ValidatorException $e) {
            return $this->validator->errors();
        } catch (\Throwable $e) {print_r($e->getMessage()); exit;
            return $e->getMessage();
        }
    }

    /**
     * @param Request $request
     * @param $id
     * @return $this|\Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id)
    {
        try {
            #Recuperando os dados da requisição
            $data = $request->all();

            #Executando a ação
            $this->service->update($data['calendario'], $id);

            #Retorno para a view
            return array('msg' => 'sucesso');
        } catch (ValidatorException $e) {
            return $this->validator->errors();
        } catch (\Throwable $e) { dd($e);
            return $e->getMessage();
        }
    }

    /**
     * @param $id
     * @return array|string
     */
    public function fechar($id)
    {
        try {

            #Executando a ação
            $calendario = $this->repository->find($id);
            $calendario->status_id = '2';
            $calendario->save();

            #Retorno para a view
            return array('msg' => 'sucesso');
        } catch (ValidatorException $e) {
            return $this->validator->errors();
        } catch (\Throwable $e) { dd($e);
            return $e->getMessage();
        }
    }

    /**
     * @param $id
     * @return array|string
     */
    public function bloquear(Request $request)
    {
        try {

            #Executando a ação
            $calendario = $this->repository->find($request->get('id'));
            $calendario->status_id = '3';
            $calendario->comentario_bloqueio = $request->get('descricao');
            $calendario->save();

            #Retorno para a view
            return array('msg' => 'sucesso');
        } catch (ValidatorException $e) {
            return $this->validator->errors();
        } catch (\Throwable $e) { dd($e);
            return $e->getMessage();
        }
    }

    /**
     * @param $id
     * @return array|string
     */
    public function deletar($id)
    {
        try {

            \DB::table('age_mapas')->where('calendario_id',$id)->delete();

            #Executando a ação
            $calendario = $this->repository->delete($id);

            #Retorno para a view
            return redirect()->back()->with("message", "Agenda deletada com sucesso!");
        } catch (\Throwable $e) {
            dd($e);
            return redirect()->back()->with('message', $e->getMessage());
        }
    }

    /**
     * @param $id
     * @return array
     * @throws \Exception
     */
    public function getCalendarioByMedico($id)
    {
        $dados = $this->service->getCalendarioByMedico($id);

        $calendarios = array();

        $count = 0;
        foreach($dados as $dado) {
            $calendarios[$count]['date'] = $dado['data'];
            $calendarios[$count]['badge'] = true;

            if($dado['status_id'] == '1') {
                $calendarios[$count]['classname'] = 'aberto';
            } else if ($dado['status_id'] == '2') {
                $calendarios[$count]['classname'] = 'fechado';
            } else if ($dado['status_id'] == '3') {
                $calendarios[$count]['classname'] = 'bloqueado';
            }

            $count++;
        }

        return $calendarios;
    }

    /**
     * @param Request $request
     * @return array
     * @throws \Exception
     */
    public function findCalendarioData(Request $request)
    {
        $data = $request->all();

        $calendario = $this->service->findCalendarioData($data);
        $qtdAgendado = count($calendario->agendamento);

        return compact('calendario', 'qtdAgendado');
    }

    /**
     * @param Request $request
     * @return array
     */
    public function findCalendarioDataMedico(Request $request)
    {
        $data = $request->all();

        $result = $this->service->findCalendarioDataMedico($data['data'], $data['idMedico'], $data['idLocalidade']);
        $calendario     = $result['calendario'];
        $mapas          = $result['mapas'];

        if($result['status']) {
            $retorno = true;
        } else {
            $retorno = false;
        }

        return compact('calendario', 'retorno', 'mapas');
    }

    /**
     * @return mixed
     */
    public function gridPacientes($id)
    {
        #Criando a consulta
        $rows = \DB::table('age_agendamento')
            ->join('age_calendario', 'age_calendario.id', '=', 'age_agendamento.calendario_id')
            ->join('age_especialista', 'age_especialista.id', '=', 'age_calendario.especialista_id')
            ->join('age_fila', 'age_fila.id', '=', 'age_agendamento.fila_id')
            ->join('gen_cgm', 'gen_cgm.id', '=', 'age_fila.cgm_id')
            ->join('gen_cgm as cgm_especialista', 'cgm_especialista.id', '=', 'age_especialista.cgm')
            ->join('age_status_agendamento', 'age_status_agendamento.id', '=', 'age_agendamento.status_agendamento_id')
            ->join('age_mapas', 'age_mapas.id', '=', 'age_agendamento.mapa_id')
            ->join('age_especialista_especialidade', 'age_especialista_especialidade.id', '=', 'age_mapas.especialidade_id')
            ->join('age_especialidade', 'age_especialidade.id', '=', 'age_especialista_especialidade.especialidade_id')
            ->join('age_operacoes', 'age_operacoes.id', '=', 'age_especialidade.operacao_id')
            ->where('age_calendario.id', '=', $id)
            ->select([
                'gen_cgm.nome',
                'age_fila.id as fila_id',
                'age_calendario.id as calendario_id',
                'age_calendario.status_id',
                'age_calendario.mais_mapa',
                'age_mapas.horario as horario',
                'age_especialidade.id as exame_id',
                'age_agendamento.id as agendamento_id',
                'cgm_especialista.nome as especialista',
                'age_especialista.crm',
                'age_status_agendamento.nome as status',
                'age_operacoes.nome as especialidade'
            ]);

        #Editando a grid
        return Datatables::of($rows)
            ->addColumn('action', function ($row) {

                $html = "";
                // Valida se o calendario esta bloqueado, caso sim, esse paciente recebe o direito de ser reagendado
                if($row->status_id == '3') {
                    $html .= '<a href="#" class="btn btn-xs btn-danger excluir"><i class="fa fa-edit"></i> Reagendar</a>';
                }

                return $html;

            })->make(true);
    }

    /**
     * @param Request $request
     * @return array
     * @throws \Exception
     */
    public function getCalendarioEspecialista(Request $request)
    {

        $data = new \DateTime('now');

        #Recuperando o registro no banco de dados
        $calendarios = \DB::table('age_calendario')
            ->join('age_especialista', 'age_especialista.id', '=', 'age_calendario.especialista_id')
            ->join('age_localidade', 'age_localidade.id', '=', 'age_calendario.localidade_id')
            ->join('age_mapas', 'age_calendario.id', '=', 'age_mapas.calendario_id')
            ->join('age_especialista_especialidade', 'age_especialista_especialidade.id', '=', 'age_mapas.especialidade_id')
            ->groupBy('age_calendario.id')
            ->where('age_especialista.id', '=', $request->get('idEspecialista'))
            ->where('age_calendario.status_id', '=', '1')
            ->where('age_calendario.data', '>=', $data->format('Y-m-d'))
            ->where('age_especialista_especialidade.id', '=', $request->get('idEspecialidade'))
            ->select([
                'age_calendario.id',
                \DB::raw('DATE_FORMAT(age_calendario.data,"%d/%m/%Y") as nome'),
                'age_localidade.nome as localidade',
            ])->get();

        #retorno
        return $calendarios;
    }

    /**
     * @param Request $request
     * @return array
     * @throws \Exception
     */
    public function getCalendario(Request $request)
    {

        // Seleciona os mapas
        $mapas = \DB::table('age_mapas')
            ->join('age_calendario', 'age_calendario.id', '=', 'age_mapas.calendario_id')
            ->where('age_mapas.calendario_id', '=', $request->get('id'))
            ->where('age_mapas.especialidade_id', '=', $request->get('especialidadeId'))
            ->select([
                "age_mapas.id",
                "age_mapas.horario"
            ])->get();

        #retorno
        return $mapas;
    }

    /**
     * @param Request $request
     * @return array
     * @throws \Exception
     */
    public function getVagasByMapa(Request $request)
    {

        // Seleciona o mapas
        $mapa = \DB::table('age_mapas')
            ->where('calendario_id', '=', $request->get('idCalendario'))
            ->where('id', '=', $request->get('mapa'))
            ->select([
                "id",
                'vagas'
            ])->first();

        // Pegando a quantidade de agendados para o mapa selecionado
        $agendamentos = \DB::table('age_agendamento')
            ->where('mapa_id', '=', $mapa->id)
            ->groupBy('age_agendamento.fila_id')
            ->select([
                //'age_agendamento.fila_id'
                \DB::raw('COUNT(age_agendamento.id) as qtd_agendados')
            ])->first();

        # Varre os pacientes afim de validar o limite de vagas
        foreach ($request->get('idsPacientes') as $idPaciente) {

            // Consulta a fila
            $fila = $this->filaRepository->find($idPaciente);

            // Pega a quantidade de pacientes de acordo com a quantidade de suboperações que o paciente possui
            $qtdPacientes = count($fila->suboperacoes) > 0 ? count($fila->suboperacoes) : 1;
        }

        // Pegando a quantidade de vagas do mapa e vagas restantes
        $vagasRestantes = $mapa->vagas - $agendamentos->qtd_agendados;

        $dados = [
            'totalVagas' => $mapa->vagas,
            'vagasRestantes' => $vagasRestantes,
            'qtdPacientes' => $qtdPacientes
        ];

        #retorno
        return response()->json($dados);
    }

    /**
     * @return $this|\Illuminate\Http\RedirectResponse
     */
    public function reagendamento(Request $request)
    {
        try {
            #Recuperando os dados da requisição
            $data = $request->all();

            #Executando a ação
            $this->service->reagendamento($data);

            # Retorno
            return \Illuminate\Support\Facades\Response::json(['success' => true]);
        } catch (\Throwable $e) {
            return \Illuminate\Support\Facades\Response::json(['error' => $e->getMessage()]);
        }
    }

    /**
     * @return $this|\Illuminate\Http\RedirectResponse
     */
    public function agendamento(Request $request)
    {
        try {
            #Recuperando os dados da requisição
            $data = $request->all();

            #Executando a ação
            $this->service->agendamento($data);

            # Retorno
            return \Illuminate\Support\Facades\Response::json(['success' => true]);
        } catch (\Throwable $e) {
            return \Illuminate\Support\Facades\Response::json(['error' => $e->getMessage()]);
        }
    }

}
