<?php

namespace Seracademico\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\App;
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
        'TipoOperacao',
        'SubOperacao'
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
        $rows = \DB::table('age_fila')
            ->join('gen_cgm', 'gen_cgm.id', '=', 'age_fila.cgm_id')
            ->join('age_especialidade', 'age_especialidade.id', '=', 'age_fila.especialidade_id')
            ->join('age_operacoes', 'age_operacoes.id', '=', 'age_especialidade.operacao_id')
            ->join('age_prioridade', 'age_prioridade.id', '=', 'age_fila.prioridade_id')
            ->leftJoin('age_posto_saude', 'age_posto_saude.id', '=', 'age_fila.posto_saude_id')
            ->where('age_fila.status', 0)
            ->select([
                'age_fila.id',
                'gen_cgm.nome',
                'gen_cgm.numero_sus',
                'gen_cgm.id as cgm_id',
                'age_operacoes.nome as especialidade',
                'age_prioridade.nome as prioridade',
                'age_posto_saude.nome as psf',
                \DB::raw('DATE_FORMAT(age_fila.data,"%d/%m/%Y") as data_cadastro'),
                'age_especialidade.id as exame'
            ]);

        if($dataIni && $dataFim) {
            $rows->whereBetween('age_fila.data', array($dataIni, $dataFim));
        }

        if($request->has('exame') && $request->get('exame') != "") {
            $rows->where('age_especialidade.id', $request->get('exame'));
        }

        if($request->has('prioridade') && $request->get('prioridade') != "") {
            $rows->where('age_prioridade.id', $request->get('prioridade'));
        }

        if($request->has('psf') && $request->get('psf') != "") {
            $rows->where('age_posto_saude.id', $request->get('psf'));
        }

        #Editando a grid
        return Datatables::of($rows)->filter(function ($query) use ($request) {
            // Filtrando Global
            if ($request->has('globalSearch')) {
                # recuperando o valor da requisição
                $search = $request->get('globalSearch');

                #condição
                $query->where(function ($where) use ($search) {
                    $where->orWhere('gen_cgm.numero_sus', 'like', "%$search%")
                        ->orWhere('gen_cgm.nome', 'like', "%$search%")
                    ;
                });

            }
        })->addColumn('action', function ($row) {

            # Recuperando a calendario
            $fila = $this->service->find($row->id);

            $html  = "";
            $html .= '<a href="edit/'.$row->id.'" class="btn btn-xs btn-primary"><i class="glyphicon glyphicon-edit"></i></a> ';
            $html .= '<a title="Histórico de Atendimento" id="historicoAtendimento" class="btn btn-xs btn-success"><i class="glyphicon glyphicon-list-alt"></i></a> ';
            $html .= '<a title="Protocolo" target="_blank" href="reportPdfProtocolo/'.$row->id.'" class="btn btn-xs btn-success"><i class="glyphicon glyphicon-export"></i> </a>';


            if (count($fila->agendamento) == 0) {
                $html .= '<a href="destroy/'.$row->id.'" class="btn btn-xs btn-danger excluir"><i class="glyphicon glyphicon-remove"></i> </a>';
            }

            return $html;

        })->addColumn('supoperacoes', function ($row) {

            // Selecioando as suboperações
            $suboperacoes = \DB::table('age_sub_operacoes_fila')
                ->join('age_sub_operacoes', 'age_sub_operacoes.id', '=', 'age_sub_operacoes_fila.sub_operacoes_id')
                ->where('age_sub_operacoes_fila.fila_id', $row->id)
                ->select([
                    'age_sub_operacoes.nome'
                ])->get();

            return $suboperacoes;

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

            //Adiciono o id do usuario
            $data = array_merge($data, array("user_id" => \Auth::user()->id));
            //dd($data);

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
            //dd($model);
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
     * @param Request $request
     * @return array
     */
    public function getDadosDoPaciente(Request $request)
    {

        $cidadao = \DB::table('gen_cgm')
            ->leftJoin('gen_endereco', 'gen_endereco.id', '=', 'gen_cgm.endereco_id')
            ->leftJoin('gen_bairros', 'gen_bairros.id', '=', 'gen_endereco.bairro_id')
            ->leftJoin('gen_cidades', 'gen_cidades.id', '=', 'gen_bairros.cidades_id')
            ->leftJoin('gen_estados', 'gen_estados.id', '=', 'gen_cidades.estados_id')
            ->where('gen_cgm.id', '=', $request->get('paciente'))
            ->select([
                'gen_cgm.id',
                'gen_cgm.nome',
                'gen_cgm.numero_sus',
                \DB::raw('DATE_FORMAT(gen_cgm.data_nascimento,"%d/%m/%Y") as data_nascimento'),
                'gen_cgm.idade',
                'gen_cgm.fone',
                'gen_cgm.fone2',
                'gen_cgm.cpf_cnpj',
                'gen_cgm.rg',
                'gen_cgm.numero_nis',
                'gen_endereco.logradouro',
                'gen_endereco.numero',
                'gen_endereco.cep',
                'gen_bairros.nome as bairro',
                'gen_bairros.id as bairro_id',
                'gen_cidades.nome as cidade',
                'gen_cidades.id as cidade_id',
                'gen_estados.id as estado',
            ])->first();

        #Retorno para view
        return compact('cidadao');
    }

    /**
     * @param Request $request
     * @return array
     */
    public function historicoAtendimento(Request $request, $id)
    {

        $rows = \DB::table('age_fila')
            ->join('gen_cgm', 'gen_cgm.id', '=', 'age_fila.cgm_id')
            ->join('age_especialidade', 'age_especialidade.id', '=', 'age_fila.especialidade_id')
            ->join('age_operacoes', 'age_operacoes.id', '=', 'age_especialidade.operacao_id')
            ->join('age_prioridade', 'age_prioridade.id', '=', 'age_fila.prioridade_id')
            ->leftJoin('age_posto_saude', 'age_posto_saude.id', '=', 'age_fila.posto_saude_id')
            ->where('gen_cgm.id', $id)
            ->select([
                'age_fila.id',
                'gen_cgm.nome',
                'gen_cgm.numero_sus',
                'gen_cgm.id as cgm_id',
                'age_operacoes.nome as especialidade',
                'age_prioridade.nome as prioridade',
                'age_posto_saude.nome as psf',
                \DB::raw('DATE_FORMAT(age_fila.data,"%d/%m/%Y") as data_cadastro'),
                'age_especialidade.id as exame'
            ]);

        #Editando a grid
        return Datatables::of($rows)->addColumn('agendamentos', function ($row) {

            $agendamentos = \DB::table('age_agendamento')
                ->join('age_fila', 'age_fila.id', '=', 'age_agendamento.fila_id')
                ->join('age_especialidade', 'age_especialidade.id', '=', 'age_fila.especialidade_id')
                ->join('age_operacoes', 'age_operacoes.id', '=', 'age_especialidade.operacao_id')
                ->join('age_prioridade', 'age_prioridade.id', '=', 'age_fila.prioridade_id')
                ->join('age_calendario', 'age_calendario.id', '=', 'age_agendamento.calendario_id')
                ->join('age_localidade', 'age_localidade.id', '=', 'age_calendario.localidade_id')
                ->join('age_especialista', 'age_especialista.id', '=', 'age_calendario.especialista_id')
                ->join('gen_cgm as cgm_especialista', 'cgm_especialista.id', '=', 'age_especialista.cgm')
                ->join('age_status_agendamento', 'age_status_agendamento.id', '=', 'age_agendamento.status_agendamento_id')
                ->join('age_mapas', 'age_mapas.id', '=', 'age_agendamento.mapa_id')
                ->where('age_fila.id', $row->id)
                ->select([
                    'age_operacoes.nome as especialidade',
                    \DB::raw('DATE_FORMAT(age_calendario.data,"%d/%m/%Y") as data'),
                    'age_mapas.horario',
                    'cgm_especialista.nome as especialista',
                    'age_status_agendamento.nome as status',
                    'age_especialidade.id as exame',
                    'age_agendamento.obs_atendimento',
                    'age_localidade.nome as localidade'
                ])->get();

            return $agendamentos;

        })->make(true);

    }


    /**
     * @param Request $request
     * @return array
     */
    public function getIdadePaciente(Request $request)
    {

        // Declara a data! :P
        $data = $request->get('data');

        // Separa em dia, mês e ano
        list($dia, $mes, $ano) = explode('/', $data);

        // Descobre que dia é hoje e retorna a unix timestamp
        $hoje = mktime(0, 0, 0, date('m'), date('d'), date('Y'));
        // Descobre a unix timestamp da data de nascimento do fulano
        $nascimento = mktime( 0, 0, 0, $mes, $dia, $ano);

        // Depois apenas fazemos o cálculo já citado :)
        $idade = floor((((($hoje - $nascimento) / 60) / 60) / 24) / 365.25);

        #Retorno para view
        return compact('idade');
    }

    /**
     *  Dados que irão preencher o relatório gerado em pdf
     *  Menu > relatorios > por agenda > gerar pdf
     */
    public function reportPdfProtocolo(Request $request, $id)
    {

        try {
            //dd($id);

            #Criando a consulta
            $pacientes = \DB::table('age_fila')
                ->join('users', 'users.id', '=', 'age_fila.user_id')
                ->join('gen_cgm', 'gen_cgm.id', '=', 'age_fila.cgm_id')
                ->join('age_especialidade', 'age_especialidade.id', '=', 'age_fila.especialidade_id')
                ->join('age_operacoes', 'age_operacoes.id', '=', 'age_especialidade.operacao_id')
                ->where('age_fila.id', '=', $id)
                ->select([
                    '*',
                    'gen_cgm.nome',
                    \DB::raw('DATE_FORMAT(gen_cgm.data_nascimento,"%d/%m/%Y") as data_nascimento'),
                    \DB::raw('DATE_FORMAT(age_fila.data,"%d/%m/%Y") as data'),
                    'age_operacoes.nome as operacao_nome',
                    'age_fila.observacao',
                    'age_fila.id as fila_id',
                    'users.name',
                    'age_fila.hipotese_diagnostica'
            ])

                ->first();
            //dd($pacientes);
            //$pacientes = $rows->get();

            # Recuperando o serviço de pdf / dompdf
            //$PDF = App::make('dompdf.wrapper');

            # Carregando a página
            //$PDF->loadView('reports.viewPdfReportProtocolo', ['pacientes' => $pacientes]);
            //dd("sss");

            return \PDF::loadView('reports.viewPdfReportProtocolo', compact('pacientes'))->setOrientation('landscape')->stream();
            # Retornando para página
            // return $PDF->stream();

        } catch (\Throwable $e) {
            return $e->getMessage();
        }
    }
}
