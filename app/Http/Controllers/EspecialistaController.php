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
        $rows = \DB::table('age_especialista')
            ->join('gen_cgm', 'gen_cgm.id', '=', 'age_especialista.cgm')
            ->select([
                'age_especialista.id',
                'gen_cgm.nome',
                'age_especialista.crm',
                'age_especialista.qtd_vagas',
            ]);

        #Editando a grid
        return Datatables::of($rows)->addColumn('action', function ($row) {

            # Recuperando a calendario
            $especialista = $this->service->find($row->id);

            $html = "";

            $html .= '<a href="edit/'.$row->id.'" class="btn btn-xs btn-primary"><i class="glyphicon glyphicon-edit"></i></a> ';
            $html .= '<a href="agenda/'.$row->id.'" class="btn btn-xs btn-success"><i class="zmdi zmdi-calendar-check"></i></a> ';
            $html .= '<a style="margin-right: 5%;" title="Adicionar Especialidade" id="btnModalAdicionarEspecialidades" class="btn btn-xs btn-warning"><i class="zmdi zmdi-local-hospital"></i></a>';

            if(count($especialista->calendario) == 0) {
                $html .= '<a href="destroy/'.$row->id.'" class="btn btn-xs btn-danger excluir"><i class="fa fa-edit"></i> Deletar</a>';
            }

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
    public function getByEspacialidade($id)
    {
        $especialistas = $this->service->findByEspecialidade($id);

        return $especialistas;
    }

    /**
     * @param Request $request
     * @return array
     * @throws \Exception
     */
    public function getEspecialidades(Request $request)
    {
        $especialidades = $this->service->findEspecialidades($request->get('idEspecialista'));

        return $especialidades;
    }

    /**
     * @param Request $request
     * @return array
     * @throws \Exception
     */
    public function getEspecialidadesEspecificas(Request $request)
    {

        $especialidades = $this->service->findEspecialidadesEspecificas($request->get('idEspecialista'), $request->get('idEspecialidade'));

        return $especialidades;
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getTipoOperacao(Request $request)
    {

        $tipos = \DB::table('age_tipo_operacoes')
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
        $rows = \DB::table('age_especialidade')
            ->join('age_especialista_especialidade', 'age_especialidade.id', '=', 'age_especialista_especialidade.especialidade_id')
            ->join('age_operacoes', 'age_operacoes.id', '=', 'age_especialidade.operacao_id')
            ->join('age_grupo_operacoes', 'age_grupo_operacoes.id', '=', 'age_operacoes.grupo_operaco_id')
            ->join('age_tipo_operacoes', 'age_tipo_operacoes.id', '=', 'age_grupo_operacoes.tipo_operacao_id')
            ->where('age_especialista_especialidade.especialista_id', '=', $id)
            ->select([
                'age_especialista_especialidade.id',
                'age_tipo_operacoes.nome as tipo',
                'age_operacoes.nome as especialidade'
            ]);

        #Editando a grid
        return Datatables::of($rows)->addColumn('action', function ($row) {

            $html = "";

            $especialidade = $this->service->findEspecialistaEspecialidade($row->id);

            if( count($especialidade->mapas) <= 0 ) {
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

    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        try {
            #Executando a ação
            $this->service->destroy($id);

            #Retorno para a view
            return redirect()->back()->with("message", "Remoção realizada com sucesso!");
        } catch (\Throwable $e) {
            dd($e);
            return redirect()->back()->with('message', $e->getMessage());
        }
    }
}
