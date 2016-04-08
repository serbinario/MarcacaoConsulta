<?php

namespace Seracademico\Http\Controllers;

use Illuminate\Http\Request;

use Seracademico\Http\Requests;
use Seracademico\Services\AgendamentoService;
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
    * @var array
    */
    private $loadFields = [];

    /**
    * @param AgendamentoService $service
    * @param AgendamentoValidator $validator
    */
    public function __construct(AgendamentoService $service, AgendamentoValidator $validator)
    {
        $this->service   =  $service;
        $this->validator =  $validator;
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        $localidades = $this->service->getAllLocalidades();
        $especialidades = $this->service->getAllEspecialidades();

        return view('agendamento.agendamento', compact('localidades', 'especialidades', 'id'));
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

        $dados = $this->service->getCalendarioByMedicoLocal($request['data']['idEspecialista'], $request['data']['idLocalidade']);

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
            $calendarios[$count]['color']       = "#ff9f89";
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
        //dd($model);
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
            $this->service->update($data['agendamento'], $id);

            #Retorno para a view
            return array('msg' => 'sucesso');
        } catch (ValidatorException $e) {
            return $this->validator->errors();
        } catch (\Throwable $e) { dd($e);
            return $e->getMessage();
        }
    }

}
