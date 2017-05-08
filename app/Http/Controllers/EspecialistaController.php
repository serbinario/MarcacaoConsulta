<?php

namespace Seracademico\Http\Controllers;

use Illuminate\Http\Request;

use Seracademico\Http\Requests;
use Seracademico\Services\EspecialistaService;
use Yajra\Datatables\Datatables;
use Prettus\Validator\Exceptions\ValidatorException;
use Prettus\Validator\Contracts\ValidatorInterface;
use Seracademico\Validators\EspecialistaValidator;

class EspecialistaController extends Controller
{
    /**
    * @var EspecialistaService
    */
    private $service;

    /**
    * @var EspecialistaValidator
    */
    private $validator;

    /**
    * @var array
    */
    private $loadFields = [
        'TipoOperacao'
    ];

    /**
    * @param EspecialistaService $service
    * @param EspecialistaValidator $validator
    */
    public function __construct(EspecialistaService $service, EspecialistaValidator $validator)
    {
        $this->service   =  $service;
        $this->validator =  $validator;
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view('especialista.index');
    }

    /**
     * @return mixed
     */
    public function grid()
    {
        #Criando a consulta
        $rows = \DB::table('especialista')
            ->join('cgm', 'cgm.id', '=', 'especialista.cgm')
            ->select([
                'especialista.id',
                'cgm.nome',
                'especialista.crm',
                'especialista.qtd_vagas',
            ]);

        #Editando a grid
        return Datatables::of($rows)->addColumn('action', function ($row) {

            $html = "";

            $html .= '<a href="edit/'.$row->id.'" class="btn btn-xs btn-primary"><i class="glyphicon glyphicon-edit"></i></a> ';
            $html .= '<a href="agenda/'.$row->id.'" class="btn btn-xs btn-success"><i class="zmdi zmdi-calendar-check"></i></a> ';
            $html .= '<a style="margin-right: 5%;" title="Adicionar Especialidade" id="btnModalAdicionarEspecialidades" class="btn btn-xs btn-warning"><i class="zmdi zmdi-local-hospital"></i></a>';

            return $html;

        })->addColumn('especialidades', function ($row) {

            $especialidades = $this->service->findEspecialidades($row->id);

            return $especialidades;

        })->make(true);
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        #Carregando os dados para o cadastro
        $loadFields = $this->service->load($this->loadFields);

        #Retorno para view
        return view('especialista.create', compact('loadFields'));
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
            return redirect()->back()->with("message", "Cadastro realizado com sucesso!");
        } catch (ValidatorException $e) {
            return redirect()->back()->withErrors($this->validator->errors())->withInput();
        } catch (\Throwable $e) {print_r($e->getMessage()); exit;
            return redirect()->back()->with('message', $e->getMessage());
        }
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function edit($id)
    {
        try {
            #Recuperando a empresa
            $model = $this->service->find($id);

            #Carregando os dados para o cadastro
            $loadFields = $this->service->load($this->loadFields);

            #retorno para view
            return view('especialista.edit', compact('model', 'loadFields'));
        } catch (\Throwable $e) {dd($e);
            return redirect()->back()->with('message', $e->getMessage());
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

            #tratando as rules
            $this->validator->replaceRules(ValidatorInterface::RULE_UPDATE, ":id", $id);

            #Validando a requisição
            $this->validator->with($data)->passesOrFail(ValidatorInterface::RULE_UPDATE);

            #Executando a ação
            $this->service->update($data, $id);

            #Retorno para a view
            return redirect()->back()->with("message", "Alteração realizada com sucesso!");
        } catch (ValidatorException $e) {
            return redirect()->back()->withErrors($this->validator->errors())->withInput();
        } catch (\Throwable $e) { dd($e);
            return redirect()->back()->with('message', $e->getMessage());
        }
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
    public function getEspecialidades(Request $request)
    {
        $especialidades = $this->service->findEspecialidades($request->get('idEspecialista'));

        return compact('especialidades');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getTipoOperacao(Request $request)
    {

        $tipos = \DB::table('tipo_operacoes')
            ->select('id', 'nome')
            ->get();

        return response()->json($tipos);

    }

    /**
     * @param $id
     * @return mixed
     */
    public function gridEspecialidades($id)
    {
        #Criando a consulta
        $rows = \DB::table('especialidade')
            ->join('especialista_especialidade', 'especialidade.id', '=', 'especialista_especialidade.especialidade_id')
            ->join('operacoes', 'operacoes.id', '=', 'especialidade.operacao_id')
            ->join('grupo_operacoes', 'grupo_operacoes.id', '=', 'operacoes.grupo_operaco_id')
            ->join('tipo_operacoes', 'tipo_operacoes.id', '=', 'grupo_operacoes.tipo_operacao_id')
            ->where('especialista_especialidade.especialista_id', '=', $id)
            ->select([
                'especialista_especialidade.id',
                'tipo_operacoes.nome as tipo',
                'operacoes.nome as especialidade'
            ]);

        #Editando a grid
        return Datatables::of($rows)->addColumn('action', function ($row) {

            $html = "";

            $especialidade = $this->service->findEspecialistaEspecialidade($row->id);

            if(count($especialidade->calendarioUm) <= 0 && count($especialidade->calendarioDois) <= 0) {
                $html .= '<a title="Remover" id="deleteEspecialidade" class="btn btn-xs btn-primary"><i class="glyphicon glyphicon-remove"></i></a>';
            }

            # Retorno
            return $html;
        })->make(true);
    }

    /**
     * @return $this|\Illuminate\Http\RedirectResponse
     */
    public function storeEspecialidade(Request $request)
    {
        try {
            #Recuperando os dados da requisição
            $data = $request->all();

            #Executando a ação
            $this->service->storeEspecialidade($data);

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
    public function destroyEspecialidade(Request $request)
    {
        try {
            #Executando a ação
            $this->service->destroyEspecialidade($request->get("idEspecialidade"));

            # Retorno
            return \Illuminate\Support\Facades\Response::json(['success' => true]);
        } catch (\Throwable $e) {
            return \Illuminate\Support\Facades\Response::json(['error' => $e->getMessage()]);
        }
    }
}
