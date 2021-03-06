<?php

namespace Seracademico\Services;

use Seracademico\Repositories\AgendamentoRepository;
use Seracademico\Repositories\CalendarioRepository;
use Seracademico\Entities\Calendario;
use Seracademico\Repositories\EventoRepository;
use Seracademico\Repositories\FilaRepository;
use Seracademico\Repositories\MapaRepository;
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
     * @var EventoRepository
     */
    private $repoFila;

    /**
     * @var EventoRepository
     */
    private $mapaRepository;

    /**
     * @param CalendarioRepository $repository
     */
    public function __construct(CalendarioRepository $repository,
                                AgendamentoRepository $repositoryAgendamento,
                                EventoRepository $repoEvento,
                                FilaRepository $repoFila,
                                MapaRepository $mapaRepository)
    {
        $this->repository               = $repository;
        $this->repositoryAgendamento    = $repositoryAgendamento;
        $this->repoEvento               = $repoEvento;
        $this->repoFila                 = $repoFila;
        $this->mapaRepository           = $mapaRepository;
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
     * @return Calendario
     * @throws \Exception
     */
    public function store(array $data) : Calendario
    {

        #tratamento de dados do aluno
        $data     = $this->tratamentoCampos($data);
        $data     = $this->tratamentoCamposVazio($data);

        #Salvando o registro principal
        $data['status_id'] = '1';
        $calendario =  $this->repository->create($data);

        // Salvando os mapas
        foreach ($data['mapas'] as $mapa) {
            $mapa['calendario_id'] = $calendario->id;
            $this->mapaRepository->create($mapa);
        }

        #Verificando se foi criado no banco de dados
        if(!$calendario) {
            throw new \Exception('Ocorreu um erro ao cadastrar!');
        }

        #Retorno
        return $calendario;
    }

    /**
     * @param array $data
     * @param int $id
     * @return Calendario
     * @throws \Exception
     */
    public function update(array $data, int $id) : Calendario
    {

        #tratamento de dados do aluno
        $data     = $this->tratamentoCampos($data);
        $data     = $this->tratamentoCamposVazio($data);

        #Atualizando no banco de dados
        $calendario = $this->repository->update($data, $id);

        // Editando os mapas
        foreach ($data['mapas'] as $mapa) {
            $mapa['calendario_id'] = $calendario->id;
            if ($mapa['id']) {
                $this->mapaRepository->update($mapa, $mapa['id']);
            } else {
                $this->mapaRepository->create($mapa);
            }
        }

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
     * @param array $data
     * @return mixed
     * @throws \Exception
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
            $dados['mapa_id']                  = $data['mapa'];
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
     * @param array $data
     * @return mixed
     * @throws \Exception
     */
    public function agendamento(array $data)
    {

        $date = new \DateTime('now');

        // Tratando os agendamentos dos pacientes
        foreach ($data['pacientes'] as $paciente) {

            // Recupenando o agendamento atual do paciente
            $fila = $this->repoFila->with(['especialidade.operacao'])->find($paciente);
            $fila['status'] = '1';
            $fila->save();

            // Preenchendo os campos para o novo agendamento do paciente
            $dados['status']                = '1';
            $dados['calendario_id']         = $data['calendario_id'];
            $dados['mapa_id']               = $data['mapa'];
            $dados['fila_id']               = $paciente;
            $dados['data']                  = $date->format('Y-m-d');
            $dados['status_agendamento_id'] = '1';

            // Valida se o paciente irá para fazer exame de ultrassonografia
            if ($fila->especialidade->operacao->id == '7') {

                // Registra os agendamentos do paciente de acordo com a quantidade de tipo de ultrossonografia
                // Que o mesmo irá fazer
                foreach ($fila->suboperacoes as $suboperacao) {

                    // Registrando o novo agendamento
                    $dados['sub_operacao_id'] = $suboperacao->id;
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

            } else {

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
     * @param $data
     * @return mixed
     * @throws \Exception
     */
    public function findCalendarioData($data)
    {
        #Recuperando o registro no banco de dados
        $calendario = $this->repository->with(['agendamento', 'mapas.especialidadeMapa'])->findWhere(['data' => $data['data'], 'especialista_id' => $data['especialista']]);

        #Verificando se o registro foi encontrado
        if(count($calendario) <= 0) {
            throw new \Exception('Empresa não encontrada!');
        }

        #retorno
        return $calendario[0];
    }

    /**
     * @param $data
     * @param $idEspecialista
     * @param $idlocalidade
     * @return array
     */
    public function findCalendarioDataMedico($data, $idEspecialista, $idlocalidade)
    {
        #Recuperando o registro no banco de dados
        //$calendario = $this->repository->with(['especialista', 'agendamento'])->findWhere(['data' => $data, 'especialista_id' => $idEspecialista, 'localidade_id' => $idlocalidade]);

        $calendario = \DB::table('age_calendario')
            ->join('age_especialista', 'age_especialista.id', '=', 'age_calendario.especialista_id')
            ->leftJoin('age_agendamento', 'age_agendamento.calendario_id', '=', 'age_calendario.id')
            ->leftJoin('age_status', 'age_status.id', '=', 'age_calendario.status_id')
            ->where('age_calendario.especialista_id', '=', $idEspecialista)
            ->where('age_calendario.localidade_id', '=', $idlocalidade)
            ->where('age_calendario.data', '=', $data)
            ->where('age_calendario.status_id', '=', '1')
            ->select([
                'age_calendario.id',
                'age_calendario.qtd_vagas',
                'age_calendario.mais_mapa',
                'age_status.id as status',
                'age_status.nome as status_nome',
                'age_calendario.data',
            ])->first();

        if($calendario) {

            // Seleciona os mapas
            $mapas = \DB::table('age_mapas')
                ->join('age_especialista_especialidade', 'age_especialista_especialidade.id', '=', 'age_mapas.especialidade_id')
                ->join('age_especialidade', 'age_especialidade.id', '=', 'age_especialista_especialidade.especialidade_id')
                ->join('age_operacoes', 'age_operacoes.id', '=', 'age_especialidade.operacao_id')
                ->where('age_mapas.calendario_id', '=', $calendario->id)
                ->select([
                    'age_mapas.horario',
                    'age_mapas.vagas',
                    'age_mapas.id',
                    'age_operacoes.nome as especialidade',
                ])->get();

            // Montando as informações dos mapas
            foreach ($mapas as $chave => $mapa) {

                //Pegando a quantidade de agendamentos por mapa
                $agendamentos = \DB::table('age_agendamento')
                    ->join('age_mapas', 'age_mapas.id', '=', 'age_agendamento.mapa_id')
                    ->where('age_agendamento.mapa_id', '=', $mapa->id)
                    ->select([
                        \DB::raw('count(age_agendamento.id) as qtdAgendados'),
                    ])->first();

                $arrayTemp = (array) $mapas[$chave];
                $mapas[$chave] = (object) array_merge($arrayTemp, ['qtdAgendados' => $agendamentos->qtdAgendados]);
            }

            $retorno = [
                'calendario' => $calendario,
                'mapas' => $mapas,
            ];

        } else {
            $retorno = [
                'calendario' => $calendario,
                'mapas' => "",
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
     * @param array $models
     * @return mixed
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
     * @param $model
     * @return mixed
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