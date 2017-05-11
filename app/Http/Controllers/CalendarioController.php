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

}
