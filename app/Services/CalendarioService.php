<?php

namespace Seracademico\Services;

use Seracademico\Repositories\AgendamentoRepository;
use Seracademico\Repositories\CalendarioRepository;
use Seracademico\Entities\Calendario;
use Seracademico\Repositories\EventoRepository;
use Yajra\Datatables\Datatables;

class CalendarioService
{
    /**
     * @var CalendarioRepository
     */
    private $repository;

    /**
     * @var AgendamentoRepository
     */
    private $repositoryAgendamento;

    /**
     * @var EventoRepository
     */
    private $repoEvento;

    /**
     * @param CalendarioRepository $repository
     */
    public function __construct(CalendarioRepository $repository,
                                AgendamentoRepository $repositoryAgendamento,
                                EventoRepository $repoEvento)
    {
        $this->repository = $repository;
        $this->repositoryAgendamento = $repositoryAgendamento;
        $this->repoEvento = $repoEvento;
    }

    /**
     * @param $id
     * @return mixed
     * @throws \Exception
     */
    public function find($id)
    {
        #Recuperando o registro no banco de dados
        $calendario = $this->repository->find($id);

        #Verificando se o registro foi encontrado
        if(!$calendario) {
            throw new \Exception('Empresa não encontrada!');
        }

        #retorno
        return $calendario;
    }

    /**
     * @param array $data
     * @return array
     */
    public function store(array $data) : Calendario
    {

        #tratamento de dados do aluno
        $data     = $this->tratamentoCampos($data);
        $data     = $this->tratamentoCamposVazio($data);
        
        if($data['mais_mapa'] == '1') {
            $data['qtd_vagas'] = $data['qtd_vagas'] * 2;
        }

        #Salvando o registro pincipal
        $data['status_id'] = '1';
        $calendario =  $this->repository->create($data);

        #Verificando se foi criado no banco de dados
        if(!$calendario) {
            throw new \Exception('Ocorreu um erro ao cadastrar!');
        }

        #Retorno
        return $calendario;
    }

    /**
     * @param array $data
     * @return array
     */
    public function reagendamento(array $data)
    {
        // Tratando os agendamentos dos pacientes
        foreach ($data['pacientes'] as $paciente) {

            // Recupenando o agendamento atual do paciente
            $agendaAtual = $this->repositoryAgendamento->find($paciente);
            $agendaAtual['status_agendamento_id'] = '2';
            $agendaAtual->save();

            // Preenchendo os campos para o novo agendamento do paciente
            $dados['status']                = '1';
            $dados['calendario_id']         = $data['calendario_id'];
            $dados['hora']                  = $data['mapa'];
            $dados['fila_id']               = $agendaAtual['fila_id'];
            $dados['agendamento_id']        = $agendaAtual['id'];
            $dados['status_agendamento_id'] = '1';

            // Registrando o novo agendamento
            $agendamento = $this->repositoryAgendamento->create($dados);

            // Pegando o agendamendo armazenado para cria um evento para o mesmo
            $agendamentoFind = $this->repositoryAgendamento->with(['fila.cgm', 'calendario'])->find($agendamento->id);

            // Setando os dados do evento
            $evento = [
                'title' => $agendamentoFind['fila']['cgm']['nome'],
                'start' => $agendamentoFind['calendario']['data'],
                'agendamento_id' => $agendamento->id,
            ];

            // Salvando o evento
            $this->repoEvento->create($evento);

        }

        #Verificando se foi criado no banco de dados
        if($agendamento) {
            throw new \Exception('Ocorreu um erro ao cadastrar!');
        }

        #Retorno
        return $agendamento;
    }


    /**
     * @param $id
     * @return mixed
     * @throws \Exception
     */
    public function getCalendarioByMedico($id)
    {
        #Recuperando o registro no banco de dados
        $calendarios = $this->repository->findWhere(['especialista_id' => $id]);

        #Verificando se o registro foi encontrado
        if(!$calendarios) {
            throw new \Exception('Empresa não encontrada!');
        }

        #retorno
        return $calendarios;
    }

    /**
     * @param $id
     * @return mixed
     * @throws \Exception
     */
    public function findCalendarioData($data)
    {
        #Recuperando o registro no banco de dados
        $calendario = $this->repository->findWhere(['data' => $data]);

        #Verificando se o registro foi encontrado
        if(count($calendario) <= 0) {
            throw new \Exception('Empresa não encontrada!');
        }

        #retorno
        return $calendario[0];
    }


    /**
     * @param $idEspecialista
     * @return array
     */
    public function quadroCalendario($idEspecialista)
    {
        $calendarios = \DB::table('calendario')
            ->join('especialista', 'especialista.id', '=', 'calendario.especialista_id')
            ->join('cgm', 'cgm.id', '=', 'especialista.cgm')
            ->join('localidade', 'localidade.id', '=', 'calendario.localidade_id')
            ->leftJoin('agendamento', 'agendamento.calendario_id', '=', 'calendario.id')
            ->leftJoin('status', 'status.id', '=', 'calendario.status_id')
            ->where('calendario.especialista_id', '=', $idEspecialista)
            ->select([
                'calendario.id',
                'calendario.hora',
                'calendario.hora2',
                'calendario.qtd_vagas',
                'calendario.mais_mapa',
                'status.nome as status',
                \DB::raw('DATE_FORMAT(calendario.data,"%d/%m/%Y") as data'),
                'cgm.nome',
                'localidade.nome as localidade',
            ])->get();

        if(count($calendarios)) {

            foreach ($calendarios as $chave => $valor) {

                //Select dados mapa 1
                $mapa1 = \DB::table('agendamento')
                    ->join('calendario', 'calendario.id', '=', 'agendamento.calendario_id')
                    ->leftJoin('especialista_especialidade', 'especialista_especialidade.id', '=', 'calendario.especialidade_id_um')
                    ->leftJoin('especialidade', 'especialidade.id', '=', 'especialista_especialidade.especialidade_id')
                    ->leftJoin('operacoes', 'operacoes.id', '=', 'especialidade.operacao_id')
                    ->where('agendamento.hora', '=', $valor->hora)
                    ->where('calendario.id', '=', $valor->id)
                    ->select([
                        \DB::raw('count(agendamento.id) as qtdAgendados'),
                        'operacoes.nome as especialidade'
                    ])->first();

                //Select dados mapa 2
                $mapa2 = \DB::table('agendamento')
                    ->join('calendario', 'calendario.id', '=', 'agendamento.calendario_id')
                    ->leftJoin('especialista_especialidade', 'especialista_especialidade.id', '=', 'calendario.especialidade_id_dois')
                    ->leftJoin('especialidade', 'especialidade.id', '=', 'especialista_especialidade.especialidade_id')
                    ->leftJoin('operacoes', 'operacoes.id', '=', 'especialidade.operacao_id')
                    ->where('agendamento.hora', '=', $valor->hora2)
                    ->where('calendario.id', '=', $valor->id)
                    ->select([
                        \DB::raw('count(agendamento.id) as qtdAgendados'),
                        'operacoes.nome as especialidade'
                    ])->first();

                $arrayTemp = (array) $calendarios[$chave];
                $calendarios[$chave] = (object) array_merge($arrayTemp, ['mapa1' => $mapa1, 'mapa2' => $mapa2]);
            }

        }


        #retorno
        return $calendarios;
    }

    /**
     * @param $id
     * @return mixed
     * @throws \Exception
     */
    public function findCalendarioDataMedico($data, $idEspecialista, $idlocalidade)
    {
        #Recuperando o registro no banco de dados
        //$calendario = $this->repository->with(['especialista', 'agendamento'])->findWhere(['data' => $data, 'especialista_id' => $idEspecialista, 'localidade_id' => $idlocalidade]);

        $calendario = \DB::table('calendario')
            ->join('especialista', 'especialista.id', '=', 'calendario.especialista_id')
            ->leftJoin('agendamento', 'agendamento.calendario_id', '=', 'calendario.id')
            ->leftJoin('status', 'status.id', '=', 'calendario.status_id')
            ->where('calendario.especialista_id', '=', $idEspecialista)
            ->where('calendario.localidade_id', '=', $idlocalidade)
            ->where('calendario.data', '=', $data)
            ->where('calendario.status_id', '=', '1')
            ->select([
                'calendario.id',
                'calendario.hora',
                'calendario.hora2',
                'calendario.qtd_vagas',
                'calendario.mais_mapa',
                'status.id as status',
                'status.nome as status_nome',
                'calendario.data',
            ])->first()
        ;

        if($calendario) {
            //Select dados mapa 1
            $mapa1 = \DB::table('agendamento')
                ->join('calendario', 'calendario.id', '=', 'agendamento.calendario_id')
                ->leftJoin('especialista_especialidade', 'especialista_especialidade.id', '=', 'calendario.especialidade_id_um')
                ->leftJoin('especialidade', 'especialidade.id', '=', 'especialista_especialidade.especialidade_id')
                ->leftJoin('operacoes', 'operacoes.id', '=', 'especialidade.operacao_id')
                ->where('agendamento.hora', '=', $calendario->hora)
                ->where('calendario.id', '=', $calendario->id)
                ->select([
                    \DB::raw('count(agendamento.id) as qtdAgendados'),
                    'operacoes.nome as especialidade'
                ])->first();

            //Select dados mapa 2
            $mapa2 = \DB::table('agendamento')
                ->join('calendario', 'calendario.id', '=', 'agendamento.calendario_id')
                ->leftJoin('especialista_especialidade', 'especialista_especialidade.id', '=', 'calendario.especialidade_id_dois')
                ->leftJoin('especialidade', 'especialidade.id', '=', 'especialista_especialidade.especialidade_id')
                ->leftJoin('operacoes', 'operacoes.id', '=', 'especialidade.operacao_id')
                ->where('agendamento.hora', '=', $calendario->hora2)
                ->where('calendario.id', '=', $calendario->id)
                ->select([
                    \DB::raw('count(agendamento.id) as qtdAgendados'),
                    'operacoes.nome as especialidade'
                ])->first();

            $retorno = [
                'calendario' => $calendario,
                'mapa1' => $mapa1,
                'mapa2' => $mapa2,
            ];
        } else {
            $retorno = [
                'calendario' => $calendario,
                'mapa1' => "",
                'mapa2' => "",
            ];
        }

        
        #Verificando se o registro foi encontrado
        if(!$calendario) {
            $retorno['status'] = false;
            return $retorno;
        } else {
            $retorno['status'] = true;
        }

        #retorno
        return $retorno;
    }

    /**
     * @param array $data
     * @param int $id
     * @return mixed
     */
    public function update(array $data, int $id) : Calendario
    {

        #tratamento de dados do aluno
        $data     = $this->tratamentoCampos($data);
        $data     = $this->tratamentoCamposVazio($data);

        if($data['mais_mapa'] == '1') {
            $data['qtd_vagas'] = $data['qtd_vagas'] * 2;
        } 

        if(!isset($data['hora2'])) {
            $data['hora2'] = null;
        }

        #Atualizando no banco de dados
        $calendario = $this->repository->update($data, $id);

        $calendarioFind = $this->repository->with(['agendamento.evento'])->find($id);
        //Atualizando os agendamentos conforme a data atual do calendário
        foreach ($calendarioFind->agendamento as $agendamento) {
            foreach ($agendamento->evento as $evento) {
                $evento->start = $calendario->data;
                $evento->save();
            }
        }

        #Verificando se foi atualizado no banco de dados
        if(!$calendario) {
            throw new \Exception('Ocorreu um erro ao cadastrar!');
        }

        #Retorno
        return $calendario;
    }

    /**
     * @param array $models
     * @return array
     */
    public function load(array $models) : array
    {
        #Declarando variáveis de uso
        $result = [];

        #Criando e executando as consultas
        foreach ($models as $model) {
            #qualificando o namespace
            $nameModel = "Seracademico\\Entities\\$model";

            #Recuperando o registro e armazenando no array
            $result[strtolower($model)] = $nameModel::lists('nome', 'id');
        }

        #retorno
        return $result;
    }

    /**
     * @param $data
     * @return mixed
     */
    private function tratamentoCampos($data)
    {
        #tratamento de datas do aluno
        $data['data']     = $this->convertDate($data['data'], 'en');

        #retorno
        return $data;
    }

    /**
     * @param $date
     * @return bool|string
     */
    public function convertDate($date, $format)
    {
        #declarando variável de retorno
        $result = "";

        #convertendo a data
        if (!empty($date) && !empty($format)) {
            #Fazendo o tratamento por idioma
            switch ($format) {
                case 'pt-BR' : $result = date_create_from_format('Y-m-d', $date); break;
                case 'en'    : $result = date_create_from_format('d/m/Y', $date); break;
            }
        }

        #retorno
        return $result;
    }

    /**
     * @param Aluno $aluno
     */
    public function getCGMWithDateFormatPtBr($model)
    {
        #validando as datas
        $model->data   = $model->data == '0000-00-00' ? "" : $model->data;

        #tratando as datas
        $model->data   = $model->data == "" ? "" : date('d/m/Y', strtotime($model->data));

        #return
        return $model;
    }

    /**
     * @param array $data
     * @return array
     */
    public function tratamentoCamposVazio(array &$data)
    {
        # Tratamento de campos de chaves estrangeira
        foreach ($data as $key => $value) {

            if ($value == null) {
                unset($data[$key]);
            }
        }
        #Retorno
        return $data;
    }
}