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
        foreach($dados['calendarios'] as $calendario) {
            $calendarios[$count]['date_start'] = $calendario['data'];
            $calendarios[$count]['overlap']     = false;
            $calendarios[$count]['rendering']   = "background";
            $vagasRestantes = $calendario['qtd_vagas'] - count($calendario['agendamento']);

            if($vagasRestantes <= 0) {
                $calendarios[$count]['color']  = "#ff9f89";
            } else if ($calendario['status_id'] == '2') {
                $calendarios[$count]['color']       = "#e899a0";
            } else if ($calendario['status_id'] == '3') {
                $calendarios[$count]['color']  = "#f3bb75";
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

        $paciente = \DB::table('age_agendamento')
            ->join('age_fila', 'age_fila.id', '=', 'age_agendamento.fila_id')
            ->join('gen_cgm', 'gen_cgm.id', '=', 'age_fila.cgm_id')
            ->join('age_calendario', 'age_agendamento.calendario_id', '=', 'age_calendario.id')
            ->join('age_localidade', 'age_calendario.localidade_id', '=', 'age_localidade.id')
            ->join('age_especialista', 'age_calendario.especialista_id', '=', 'age_especialista.id')
            ->join('age_mapas', 'age_mapas.id', '=', 'age_agendamento.mapa_id')
            ->join('age_especialista_especialidade', 'age_especialista_especialidade.id', '=', 'age_mapas.especialidade_id')
            ->join('age_especialidade', 'age_especialidade.id', '=', 'age_especialista_especialidade.especialidade_id')
            ->join('age_operacoes', 'age_operacoes.id', '=', 'age_especialidade.operacao_id')
            ->join('age_status_agendamento', 'age_status_agendamento.id', '=', 'age_agendamento.status_agendamento_id')
            ->where('age_agendamento.id', '=', $request['id'])
            ->select([
                'age_agendamento.id',
                'gen_cgm.nome',
                \DB::raw('DATE_FORMAT(age_calendario.data,"%d/%m/%Y") as data'),
                'age_agendamento.obs',
                'age_operacoes.nome as especialidade',
                'age_mapas.horario as horario',
                'age_status_agendamento.nome as situacao'
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
        $pacientes = \DB::table('age_fila')
            ->join('gen_cgm', 'gen_cgm.id', '=', 'age_fila.cgm_id')
            ->join('age_especialidade', 'age_especialidade.id', '=', 'age_fila.especialidade_id')
            ->join('age_prioridade', 'age_prioridade.id', '=', 'age_fila.prioridade_id')
            ->where('age_especialidade.id', '=', $request->get('especialidade'))
            ->where('age_fila.status', '=', '0')
            ->orderBy('age_fila.prioridade_id', 'ASC')
            ->orderBy('age_fila.data', 'ASC')
            ->select([
                'age_fila.id',
                \DB::raw('CONCAT(gen_cgm.nome, " - ", age_prioridade.nome, " - ", DATE_FORMAT(age_fila.data,"%d/%m/%Y")) as nome'),
            ])->get();

        return compact('pacientes');
    }

}
