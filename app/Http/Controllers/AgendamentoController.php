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

        $dados = $this->service->getCalendarioByMedicoLocal($idEspecialista, $idLocalidade);

        $calendarios = array();

        $count = 0;
        foreach($dados['eventos'] as $evento) {
            $calendarios[$count]['title']       = $evento->title;
            $calendarios[$count]['date_start']  = $evento->start;
            $calendarios[$count]['id']          = $evento->calendario_id;
            $calendarios[$count]['idPaciente']  = $evento->cgm_id;
            $calendarios[$count]['idAgendamento']  = $evento->agendamento_id;
            $count++;
        }

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

        //dd($calendarios);

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

        #Recuperando a empresa
        $model = $this->service->find($request['id']);

        #retorno para view
        return compact('model');

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

            #Validando a requisição
            //$this->validator->with($data)->passesOrFail(ValidatorInterface::RULE_UPDATE);

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
            $this->service->delete($id);

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
