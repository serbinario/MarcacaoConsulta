<?php

namespace Seracademico\Http\Controllers;

use Illuminate\Http\Request;

use Seracademico\Http\Requests;
use Seracademico\Services\EspecialidadeService;
use Yajra\Datatables\Datatables;
use Prettus\Validator\Exceptions\ValidatorException;
use Prettus\Validator\Contracts\ValidatorInterface;
use Seracademico\Validators\EspecialidadeValidator;

class EspecialidadeController extends Controller
{
    /**
    * @var EspecialidadeService
    */
    private $service;

    /**
    * @var EspecialidadeValidator
    */
    private $validator;

    /**
    * @var array
    */
    private $loadFields = [
        'TipoOperacao',
        'GrupoOperacao'
    ];

    /**
    * @param EspecialidadeService $service
    * @param EspecialidadeValidator $validator
    */
    public function __construct(EspecialidadeService $service, EspecialidadeValidator $validator)
    {
        $this->service   =  $service;
        $this->validator =  $validator;
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view('especialidade.index');
    }

    /**
     * @return mixed
     */
    public function grid()
    {
        #Criando a consulta
        $rows = \DB::table('age_especialidade')
            ->join('age_operacoes', 'age_operacoes.id', '=', 'age_especialidade.operacao_id')
            ->join('age_grupo_operacoes', 'age_grupo_operacoes.id', '=', 'age_operacoes.grupo_operaco_id')
            ->join('age_tipo_operacoes', 'age_tipo_operacoes.id', '=', 'age_grupo_operacoes.tipo_operacao_id')
            ->select([
                'age_especialidade.id as id',
                'age_operacoes.nome',
                'age_tipo_operacoes.nome as tipo_operacao'
            ]);

        #Editando a grid
        return Datatables::of($rows)->addColumn('action', function ($row) {

            # Recuperando a calendario
            $especialidade = $this->service->find($row->id);

            $html = "";
            $html .= '<a href="edit/'.$row->id.'" class="btn btn-xs btn-primary"><i class="glyphicon glyphicon-edit"></i> Editar</a> ';

            if(count($especialidade->especialistaEspecialidade) == 0 || count($especialidade->fila) == 0) {
                $html .= '<a href="destroy/'.$row->id.'" class="btn btn-xs btn-danger excluir"><i class="fa fa-edit"></i> Deletar</a>';
            }

            return $html;

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
        return view('especialidade.create', compact('loadFields'));
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
            return view('especialidade.edit', compact('model', 'loadFields'));
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
     * @return array
     * @throws \Exception
     */
    public function all()
    {
        $especialidades = $this->service->all();

        #Retorno para view
        return compact('especialidades');
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
