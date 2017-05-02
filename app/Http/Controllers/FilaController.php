<?php

namespace Seracademico\Http\Controllers;

use Illuminate\Http\Request;

use Seracademico\Http\Requests;
use Seracademico\Services\FilaService;
use Yajra\Datatables\Datatables;
use Prettus\Validator\Exceptions\ValidatorException;
use Prettus\Validator\Contracts\ValidatorInterface;
use Seracademico\Validators\FilaValidator;

class FilaController extends Controller
{
    /**
    * @var FilaService
    */
    private $service;

    /**
    * @var FilaValidator
    */
    private $validator;

    /**
    * @var array
    */
    private $loadFields = [
        'Estado',
        'Prioridade',
        'CGM'
    ];

    /**
    * @param FilaService $service
    * @param FilaValidator $validator
    */
    public function __construct(FilaService $service, FilaValidator $validator)
    {
        $this->service   =  $service;
        $this->validator =  $validator;
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view('fila.index');
    }

    /**
     * @return mixed
     */
    public function grid()
    {
        #Criando a consulta
        $rows = \DB::table('fila')
            ->join('cgm', 'cgm.id', '=', 'fila.cgm_id')
            ->join('especialidade', 'especialidade.id', '=', 'fila.especialidade_id')
            ->join('operacoes', 'operacoes.id', '=', 'especialidade.operacao_id')
            ->join('prioridade', 'prioridade.id', '=', 'fila.prioridade_id')
            ->select([
                'fila.id',
                'cgm.nome',
                'operacoes.nome as especialidade',
                'prioridade.nome as prioridade',
                \DB::raw('DATE_FORMAT(fila.data,"%d/%m/%Y") as data_cadastro')
            ]);

        #Editando a grid
        return Datatables::of($rows)->addColumn('action', function ($row) {
            return '<a href="edit/'.$row->id.'" class="btn btn-xs btn-primary"><i class="glyphicon glyphicon-edit"></i> Editar</a>';
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
        return view('fila.create', compact('loadFields'));
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

            #Tratando as datas
           // $aluno = $this->service->getAlunoWithDateFormatPtBr($aluno);

            #Carregando os dados para o cadastro
            $loadFields = $this->service->load($this->loadFields);

            #retorno para view
            return view('fila.edit', compact('model', 'loadFields'));
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

            #Validando a requisição
            //$this->validator->with($data)->passesOrFail(ValidatorInterface::RULE_UPDATE);

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
     *
     */
    public function all()
    {
        $localidades = $this->service->all();

        #Retorno para view
        return compact('localidades');
    }

    /**
     *
     */
    public function getDadosDoPaciente(Request $request)
    {

        $cidadao = \DB::table('cgm')
            ->join('endereco_cgm', 'endereco_cgm.id', '=', 'cgm.endereco_cgm')
            ->leftJoin('bairros', 'bairros.id', '=', 'endereco_cgm.bairro')
            ->leftJoin('cidades', 'cidades.id', '=', 'bairros.cidades_id')
            ->leftJoin('estados', 'estados.id', '=', 'cidades.estados_id')
            ->where('cgm.id', '=', $request->get('paciente'))
            ->select([
                'cgm.id',
                'cgm.nome',
                'cgm.numero_sus',
                \DB::raw('DATE_FORMAT(cgm.data_nascimento,"%d/%m/%Y") as data_nascimento'),
                'cgm.idade',
                'cgm.fone',
                'cgm.cpf_cnpj',
                'cgm.rg',
                'cgm.numero_nis',
                'endereco_cgm.logradouro',
                'endereco_cgm.numero',
                'bairros.nome as bairro',
                'bairros.id as bairro_id',
                'cidades.nome as cidade',
                'cidades.id as cidade_id',
                'estados.id as estado',
            ])->first();

        #Retorno para view
        return compact('cidadao');
    }

}
