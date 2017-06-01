<?php

namespace Seracademico\Http\Controllers;

use Illuminate\Http\Request;

use Seracademico\Entities\Especialista;
use Seracademico\Http\Requests;
use Seracademico\Repositories\CalendarioRepository;
use Seracademico\Services\CalendarioService;
use Seracademico\Services\EspecialistaService;
use Yajra\Datatables\Datatables;
use Prettus\Validator\Exceptions\ValidatorException;
use Prettus\Validator\Contracts\ValidatorInterface;
use Seracademico\Validators\CalendarioValidator;

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
    * @var array
    */
    private $loadFields = [];

    /**
    * @param CalendarioService $service
    * @param CalendarioValidator $validator
    */
    public function __construct(CalendarioService $service,
                                CalendarioValidator $validator,
                                EspecialistaService $espSservice, CalendarioRepository $repository)
    {
        $this->service   =  $service;
        $this->validator =  $validator;
        $this->espSservice =  $espSservice;
        $this->repository =  $repository;
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index($id)
    {
        #Executando a ação
        $calendarios = $this->service->quadroCalendario($id);

        $especialista = $this->espSservice->find($id);

        return view('calendario.calendarioMedico', compact('especialista', 'calendarios'));
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
    public function bloquear($id)
    {
        try {

            #Executando a ação
            $calendario = $this->repository->find($id);
            $calendario->status_id = '3';
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

        $calendario = $this->service->findCalendarioData($data['date']);

        return compact('calendario');
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
        $mapa1          = $result['mapa1'];
        $mapa2          = $result['mapa2'];

        if($result['status']) {
            $retorno = true;
        } else {
            $retorno = false;
        }

        return compact('calendario', 'retorno', 'mapa1', 'mapa2');
    }

    /**
     * @return mixed
     */
    public function gridPacientes($id)
    {
        #Criando a consulta
        $rows = \DB::table('agendamento')
            ->join('calendario', 'calendario.id', '=', 'agendamento.calendario_id')
            ->join('especialista', 'especialista.id', '=', 'calendario.especialista_id')
            ->join('fila', 'fila.id', '=', 'agendamento.fila_id')
            ->join('cgm', 'cgm.id', '=', 'fila.cgm_id')
            ->join('cgm as cgm_especialista', 'cgm_especialista.id', '=', 'especialista.cgm')
            ->join('status_agendamento', 'status_agendamento.id', '=', 'agendamento.status_agendamento_id')
            ->where('calendario.id', '=', $id)
            ->select([
                'cgm.nome',
                'fila.id as fila_id',
                'calendario.id as calendario_id',
                'calendario.status_id',
                'calendario.mais_mapa',
                'calendario.hora as hora_mapa1',
                'calendario.hora2 as hora_mapa2',
                'calendario.especialidade_id_um',
                'calendario.especialidade_id_dois',
                'agendamento.id as agendamento_id',
                'agendamento.hora',
                'cgm_especialista.nome as especialista',
                'especialista.crm',
                'status_agendamento.nome as status'
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

            })->addColumn('exame', function ($row) {

                $retorno = $this->exameDoPacienteAgendado($row);

                // Validade de qual mapa o paciente pertence e pega a especialidade ao foi agendado
                if($row->hora == $row->hora_mapa1) {
                    return $retorno['especialidade_um']->nome;
                } else if ($row->hora == $row->hora_mapa2) {
                    return $retorno['especialidade_dois']->nome;
                } else {
                    return "";
                }

        })->addColumn('exame_id', function ($row) {

                $retorno = $this->exameDoPacienteAgendado($row);

                // Validade de qual mapa o paciente pertence e pega a especialidade ao foi agendado
                if($row->hora == $row->hora_mapa1) {
                    return $retorno['especialidade_um']->especialidade_id;
                } else if ($row->hora == $row->hora_mapa2) {
                    return $retorno['especialidade_dois']->especialidade_id;
                } else {
                    return "";
                }

            })->make(true);
    }

    /**
     * @param Request $request
     * @return array
     * @throws \Exception
     */
    public function getCalendarioEspecialista(Request $request)
    {

        #Recuperando o registro no banco de dados
        $calendarios = \DB::table('calendario')
            ->join('especialista', 'especialista.id', '=', 'calendario.especialista_id')
            ->leftJoin('especialista_especialidade as especialidade_um', 'especialidade_um.id', '=', 'calendario.especialidade_id_um')
            ->leftJoin('especialista_especialidade as especialidade_dois', 'especialidade_dois.id', '=', 'calendario.especialidade_id_dois')
            ->where('especialista.id', '=', $request->get('idEspecialista'))
            ->where('calendario.status_id', '=', '1')
            ->where(function ($query) use ($request) {
                $query->orWhere('especialidade_um.id', '=', $request->get('idEspecialidade'))
                    ->orWhere('especialidade_dois.id', '=', $request->get('idEspecialidade'));
            })
            ->select([
                'calendario.id',
                \DB::raw('DATE_FORMAT(calendario.data,"%d/%m/%Y") as nome'),
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

        #Pegando o calendário
        $calendario = \DB::table('calendario')
            ->where('id', '=', $request->get('id'))
            ->select([
                'id',
                'hora',
                'hora2',
                'especialidade_id_um',
                'especialidade_id_dois',
            ])->get();

        #retorno
        return $calendario;
    }

    /**
     * @param Request $request
     * @return array
     * @throws \Exception
     */
    public function getVagasByMapa(Request $request)
    {

        #Pegando o calendário
        $calendario = \DB::table('calendario')
            ->where('id', '=', $request->get('idCalendario'))
            ->select([
                'qtd_vagas',
                'mais_mapa'
            ])->first();

        // Pegando a quantidade de agendados para o mapa selecionado
        $agendamentos = \DB::table('agendamento')
            ->where('calendario_id', '=', $request->get('idCalendario'))
            ->where('hora', '=', $request->get('mapa'))
            ->select([
                \DB::raw('COUNT(agendamento.id) as qtd_agendados')
            ])->first();

        // Pegando a quantidade de vagas do mapa e vagas restantes
        $vagas          = $calendario->mais_mapa ? $calendario->qtd_vagas / 2 : $calendario->qtd_vagas;
        $vagasRestantes = $vagas - $agendamentos->qtd_agendados;

        $dados = [
            'totalVagas' => $vagas,
            'vagasRestantes' => $vagasRestantes
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
     * @param $row
     * @return array
     */
    private function exameDoPacienteAgendado($row) {

        // Pega a especilidade do primeiro mapa
        $especialidadeUm = \DB::table('especialista_especialidade')
            ->join('especialidade', 'especialidade.id', '=', 'especialista_especialidade.especialidade_id')
            ->join('operacoes', 'operacoes.id', '=', 'especialidade.operacao_id')
            ->where('especialista_especialidade.id', '=', $row->especialidade_id_um)
            ->select([
                "operacoes.nome",
                "especialidade.id as especialidade_id",
            ])->first();

        // Pega a especilidade do segundo mapa
        $especialidadeDois = \DB::table('especialista_especialidade')
            ->join('especialidade', 'especialidade.id', '=', 'especialista_especialidade.especialidade_id')
            ->join('operacoes', 'operacoes.id', '=', 'especialidade.operacao_id')
            ->where('especialista_especialidade.id', '=', $row->especialidade_id_dois)
            ->select([
                "operacoes.nome",
                "especialidade.id as especialidade_id",
            ])->first();

        return ['especialidade_um' => $especialidadeUm, 'especialidade_dois' => $especialidadeDois];

    }
}
