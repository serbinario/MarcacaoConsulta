<?php

namespace Seracademico\Http\Controllers;

use Illuminate\Http\Request;

use Seracademico\Http\Requests;
use Seracademico\Services\FilaService;
use Yajra\Datatables\Datatables;
use Prettus\Validator\Exceptions\ValidatorException;
use Prettus\Validator\Contracts\ValidatorInterface;
use Seracademico\Validators\FilaValidator;
use Seracademico\Uteis\SerbinarioDateFormat;

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
        'CGM',
        'PostoSaude',
        'TipoOperacao'
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

        #Carregando os dados para o cadastro
        $loadFields = $this->service->load($this->loadFields);

        return view('fila.index', compact('loadFields'));
    }

    /**
     * @return mixed
     */
    public function grid(Request $request)
    {

        //Tratando as datas
        $dataIni = SerbinarioDateFormat::toUsa($request->get('data_inicio'));
        $dataFim = SerbinarioDateFormat::toUsa($request->get('data_fim'));

        #Criando a consulta
        $rows = \DB::table('fila')
            ->join('cgm', 'cgm.id', '=', 'fila.cgm_id')
            ->join('especialidade', 'especialidade.id', '=', 'fila.especialidade_id')
            ->join('operacoes', 'operacoes.id', '=', 'especialidade.operacao_id')
            ->join('prioridade', 'prioridade.id', '=', 'fila.prioridade_id')
            ->leftJoin('posto_saude', 'posto_saude.id', '=', 'fila.posto_saude_id')
            ->where('fila.status', 0)
            ->select([
                'fila.id',
                'cgm.nome',
                'cgm.numero_sus',
                'operacoes.nome as especialidade',
                'prioridade.nome as prioridade',
                'posto_saude.nome as psf',
                \DB::raw('DATE_FORMAT(fila.data,"%d/%m/%Y") as data_cadastro'),
                'especialidade.id as exame'
            ]);

        if($dataIni && $dataFim) {
            $rows->whereBetween('fila.data', array($dataIni, $dataFim));
        }

        if($request->has('exame') && $request->get('exame') != "") {
            $rows->where('especialidade.id', $request->get('exame'));
        }

        if($request->has('prioridade') && $request->get('prioridade') != "") {
            $rows->where('prioridade.id', $request->get('prioridade'));
        }

        if($request->has('psf') && $request->get('psf') != "") {
            $rows->where('posto_saude.id', $request->get('psf'));
        }

        #Editando a grid
        return Datatables::of($rows)->filter(function ($query) use ($request) {
            // Filtrando Global
            if ($request->has('globalSearch')) {
                # recuperando o valor da requisição
                $search = $request->get('globalSearch');

                #condição
                $query->where(function ($where) use ($search) {
                    $where->orWhere('cgm.numero_sus', 'like', "%$search%")
                        ->orWhere('cgm.nome', 'like', "%$search%")
                    ;
                });

            }
        })->addColumn('action', function ($row) {

            # Recuperando a calendario
            $fila = $this->service->find($row->id);

            $html = "";
            $html .= '<a href="edit/'.$row->id.'" class="btn btn-xs btn-primary"><i class="glyphicon glyphicon-edit"></i> Editar</a> ';

            if(count($fila->agendamento) == 0) {
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
            ->leftJoin('endereco_cgm', 'endereco_cgm.id', '=', 'cgm.endereco_cgm')
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
