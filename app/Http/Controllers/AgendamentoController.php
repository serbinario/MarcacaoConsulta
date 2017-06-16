<?php

namespace Seracademico\Http\Controllers;

use Illuminate\Http\Request;

use Seracademico\Entities\TipoOperacao;
use Seracademico\Http\Requests;
use Seracademico\Services\AgendamentoService;
use Seracademico\Services\CalendarioService;
use Yajra\Datatables\Datatables;
use Prettus\Validator\Exceptions\ValidatorException;
use Prettus\Validator\Contracts\ValidatorInterface;
use Seracademico\Validators\AgendamentoValidator;

class AgendamentoController extends Controller
{
    /**
    * @var AgendamentoService
    */
    private $service;

    /**
    * @var AgendamentoValidator
    */
    private $validator;

    /**
     * @var CalendarioService
     */
    private $calendarService;

    /**
    * @var array
    */
    private $loadFields = [
        'Localidade',
        'TipoOperacao'
    ];

    /**
    * @param AgendamentoService $service
    * @param AgendamentoValidator $validator
    */
    public function __construct(AgendamentoService $service, CalendarioService $calendarService, AgendamentoValidator $validator)
    {
        $this->service           =  $service;
        $this->validator         =  $validator;
        $this->calendarService   =  $calendarService;
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        $localidades = $this->service->getAllLocalidades();
        $tipoOperacoes  = TipoOperacao::all();

        $loadFields = $this->service->load($this->loadFields);

        return view('agendamento.agendamento', compact('localidades', 'id', 'tipoOperacoes', 'loadFields'));
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function calendarMedico(Request $request)
    {
        $dados = $request->all();

        $localidades = $this->service->getAllLocalidades();
        $especialidades = $this->service->getAllEspecialidades();

        return view('agendamento.agendamento', compact('localidades', 'especialidades', 'dados'));
    }

    /**
     * @param Request $request
     * @return array
     */
    public function loadCalendar(Request $request)
    {
        $request = $request->all();

        $idEspecialista = isset($request['data']['idEspecialista']) ? $request['data']['idEspecialista'] : "0";
        $idLocalidade   = isset( $request['data']['idLocalidade']) ?  $request['data']['idLocalidade'] : "0";

        // Pegas todos os calendário e agendamentos contidos nos mesmos
        $dados = $this->service->getCalendarioByMedicoLocal($idEspecialista, $idLocalidade);

        // Array para montar o dia do calendário
        $calendarios = array();

        $count = 0;
        // Preenche o array com os eventos (agendamentos) de cada dia da agenda do médico
        foreach($dados['eventos'] as $evento) {
            $calendarios[$count]['title']       = $evento->title;
            $calendarios[$count]['date_start']  = $evento->start;
            $calendarios[$count]['id']          = $evento->calendario_id;
            $calendarios[$count]['idPaciente']  = $evento->cgm_id;
            $calendarios[$count]['idAgendamento']  = $evento->agendamento_id;
            $count++;
        }

        // Preenche a array com os dados do calendário médico
        foreach($dados['calendarios'] as $calendario) {
            $calendarios[$count]['date_start'] = $calendario['data'];
            $calendarios[$count]['overlap']     = false;
            $calendarios[$count]['rendering']   = "background";
            $vagasRestantes = $calendario['qtd_vagas'] - count($calendario['agendamento']);

            // Define a cor do dia na agenda de acordo com a situação do calendário
            if($vagasRestantes <= 0) {
                $calendarios[$count]['color']  = "#ff9f89";
            } else if ($calendario['status_id'] == '2') {
                $calendarios[$count]['color']       = "#eeb5ba";
            } else if ($calendario['status_id'] == '3') {
                $calendarios[$count]['color']  = "#f7d2a4";
            } else {
                $calendarios[$count]['color']  = "#2be135";
            }

            $calendarios[$count]['id'] = $calendario['id'];
            $count++;
        }

        return $calendarios;
    }

    /**
     * @param Request $request
     * @return array
     */
    public function loadCalendarParaConsulta(Request $request)
    {
        $request = $request->all();

        $idEspecialista = isset($request['data']['idEspecialista']) ? $request['data']['idEspecialista'] : "0";
        $idLocalidade   = isset( $request['data']['idLocalidade']) ?  $request['data']['idLocalidade'] : "0";

        $dados = $this->service->getCalendarioByMedicoLocal($idEspecialista, $idLocalidade);

        $calendarios = array();
        $count = 0;

        // Carregando apenas os dias de atendimento do especialista sem os eventos (pacientes)
        foreach($dados['calendarios'] as $dado) {
            $calendarios[$count]['date_start'] = $dado['data'];
            $calendarios[$count]['overlap']     = false;
            $calendarios[$count]['rendering']   = "background";
            $vagasRestantes = $dado['qtd_vagas'] - count($dado['agendamento']);
            if($vagasRestantes <= 0) {
                $calendarios[$count]['color']       = "#ff9f89";
            } else {
                $calendarios[$count]['color']       = "#2be135";
            }
            $calendarios[$count]['id']          = $dado['id'];
            $count++;
        }

        return $calendarios;
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

            #pegando sessão de usuário
            $user = \Auth::user();

            $calendario = $this->calendarService->find($data['dados']['calendario_id']);

            //Verificando limite de vagas
            $vagasRestantes = $calendario->qtd_vagas - count($calendario->agendamento);

            // Validando internamento se o limite de vagas foi atingido
            if ($vagasRestantes <= 0 && $user->is('submaster')) {
                return array('msg' => 'Limite de vagas atingido, você não pode marcar mais consultas para esse dia!');
            }

            #Validando a requisição
            $this->validator->with($data)->passesOrFail(ValidatorInterface::RULE_CREATE);

            #Executando a ação
            $this->service->store($data);

            #Retorno para a view
            return array('msg' => 'sucesso');
        } catch (ValidatorException $e) {
            return $this->validator->errors();
        } catch (\Throwable $e) {print_r($e->getMessage()); exit;
            return $e->getMessage();
        }
    }

    /**
     * @param $id
     * @return array
     */
    public function edit(Request $request)
    {
        $request = $request->all();

        $paciente = \DB::table('agendamento')
            ->join('fila', 'fila.id', '=', 'agendamento.fila_id')
            ->join('cgm', 'cgm.id', '=', 'fila.cgm_id')
            ->join('calendario', 'agendamento.calendario_id', '=', 'calendario.id')
            ->join('localidade', 'calendario.localidade_id', '=', 'localidade.id')
            ->join('especialista', 'calendario.especialista_id', '=', 'especialista.id')
            ->join('mapas', 'mapas.id', '=', 'agendamento.mapa_id')
            ->join('especialista_especialidade', 'especialista_especialidade.id', '=', 'mapas.especialidade_id')
            ->join('especialidade', 'especialidade.id', '=', 'especialista_especialidade.especialidade_id')
            ->join('operacoes', 'operacoes.id', '=', 'especialidade.operacao_id')
            ->join('status_agendamento', 'status_agendamento.id', '=', 'agendamento.status_agendamento_id')
            ->where('agendamento.id', '=', $request['id'])
            ->select([
                'agendamento.id',
                'cgm.nome',
                \DB::raw('DATE_FORMAT(calendario.data,"%d/%m/%Y") as data'),
                'agendamento.obs',
                'operacoes.nome as especialidade',
                'mapas.horario as horario',
                'status_agendamento.nome as situacao'
            ])->first();

        #retorno para view
        return compact('paciente');

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
            $this->service->update($data['dados'], $id);

            #Retorno para a view
            return array('msg' => 'sucesso');
        } catch (ValidatorException $e) {
            return $this->validator->errors();
        } catch (\Throwable $e) {;
            return $e->getMessage();
        }
    }

    /**
     * @param Request $request
     * @param $id
     * @return $this|\Illuminate\Http\RedirectResponse
     */
    public function delete(Request $request, $id)
    {
        try {

            #Executando a ação
            $retorno = $this->service->delete($id);

            #Retorno para a view
            return array('retorno' => $retorno);
        } catch (ValidatorException $e) {
            return $this->validator->errors();
        } catch (\Throwable $e) {
            return $e->getMessage();
        }
    }

    /**
     * @param Request $request
     * @return array
     * @throws \Exception
     */
    public function getTipoOperacao()
    {
        $tipoOperacoes = TipoOperacao::all();

        return compact('tipoOperacoes');
    }

    /**
     * @param Request $request
     * @return array
     * @throws \Exception
     */
    public function getByEspacialidade(Request $request)
    {
        $data = $request->all();

        $especialistas = $this->service->findByEspecialidade($data['especialidade']);

        return compact('especialistas');
    }

    /**
     * @param Request $request
     * @return array
     * @throws \Exception
     */
    public function getPacientes(Request $request)
    {
        $pacientes = \DB::table('fila')
            ->join('cgm', 'cgm.id', '=', 'fila.cgm_id')
            ->join('especialidade', 'especialidade.id', '=', 'fila.especialidade_id')
            ->join('prioridade', 'prioridade.id', '=', 'fila.prioridade_id')
            ->where('especialidade.id', '=', $request->get('especialidade'))
            ->where('fila.status', '=', '0')
            ->orderBy('fila.prioridade_id', 'ASC')
            ->orderBy('fila.data', 'ASC')
            ->select([
                'fila.id',
                \DB::raw('CONCAT(cgm.nome, " - ", prioridade.nome, " - ", DATE_FORMAT(fila.data,"%d/%m/%Y")) as nome'),
            ])->get();

        return compact('pacientes');
    }

}
