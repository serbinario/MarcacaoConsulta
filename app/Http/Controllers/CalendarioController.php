<?php

namespace Seracademico\Http\Controllers;

use Illuminate\Http\Request;

use Seracademico\Entities\Especialista;
use Seracademico\Http\Requests;
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
    * @var array
    */
    private $loadFields = [];

    /**
    * @param CalendarioService $service
    * @param CalendarioValidator $validator
    */
    public function __construct(CalendarioService $service, CalendarioValidator $validator, EspecialistaService $espSservice)
    {
        $this->service   =  $service;
        $this->validator =  $validator;
        $this->espSservice =  $espSservice;
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index($id)
    {
        $especialista = $this->espSservice->find($id);

        return view('calendario.calendarioMedico', compact('especialista'));
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

            //dd(json_encode($data));

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

           //dd($data);

            #Validando a requisição
            //$this->validator->with($data)->passesOrFail(ValidatorInterface::RULE_UPDATE);

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
            $count++;
        }

        return $calendarios;
    }

    /**
     * @param $data
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
     * @param $data
     * @return array
     * @throws \Exception
     */
    public function findCalendarioDataMedico(Request $request)
    {
        $data = $request->all();

        $calendario = $this->service->findCalendarioDataMedico($data['data'], $data['idMedico'], $data['idLocalidade']);
        $qtdAgendados = 0;
        
        //dd(count($calendario[0]->agendamento));

        if($calendario) {
            $retorno = true;
        } else {
            $retorno = false;
        }

        return compact('calendario', 'retorno');
    }

}
