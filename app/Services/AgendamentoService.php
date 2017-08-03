<?php

namespace Seracademico\Services;

use Seracademico\Repositories\AgendamentoRepository;
use Seracademico\Entities\Agendamento;
use Seracademico\Repositories\CalendarioRepository;
use Seracademico\Repositories\EspecialidadeRepository;
use Seracademico\Repositories\EventoRepository;
use Seracademico\Repositories\FilaRepository;
use Seracademico\Repositories\LocalidadeRepository;

class AgendamentoService
{
    /**
     * @var AgendamentoRepository
     */
    private $repository;

    /**
     * @var LocalidadeRepository
     */
    private $repoLocalidade;

    /**
     * @var EspecialidadeRepository
     */
    private $repoEspecialidade;

    /**
     * @var EventoRepository
     */
    private $repoEvento;

    /**
     * @var CalendarioRepository
     */
    private $repoCalendario;

    /**
     * @var FilaRepository
     */
    private $filaRepository;

    /**
     * @param AgendamentoRepository $repository
     */
    public function __construct(AgendamentoRepository $repository,
                                LocalidadeRepository $repoLocalidade,
                                EspecialidadeRepository $repoEspecialidade,
                                EventoRepository $repoEvento,
                                CalendarioRepository $repoCalendario,
                                FilaRepository $filaRepository)
    {
        $this->repository           = $repository;
        $this->repoLocalidade       = $repoLocalidade;
        $this->repoEspecialidade    = $repoEspecialidade;
        $this->repoEvento           = $repoEvento;
        $this->repoCalendario       = $repoCalendario;
        $this->filaRepository       = $filaRepository;
    }

    /**
     * @param $id
     * @return mixed
     * @throws \Exception
     */
    public function find($id)
    {
        $relacionamentos = [
            'fila.cgm',
            'psf',
            'calendario.agendamento.mapa',
        ];

        #Recuperando o registro no banco de dados
        $agendamento = $this->repository->with($relacionamentos)->find($id);

        #Verificando se o registro foi encontrado
        if(!$agendamento) {
            throw new \Exception('Empresa não encontrada!');
        }

        #retorno
        return $agendamento;
    }

    /**
     * @param $idMedico
     * @param $idLocal
     * @return mixed
     * @throws \Exception
     */
    public function getCalendarioByMedicoLocal($idMedico, $idLocal)
    {
        #Recuperando o registro no banco de dados
        $calendarios = $this->repoCalendario->with(['especialista', 'agendamento'])
            ->findWhere(['especialista_id' => $idMedico, 'localidade_id' => $idLocal]);

        $eventos = \DB::table('age_evento')
            ->join('age_agendamento', 'age_evento.agendamento_id', '=', 'age_agendamento.id')
            ->join('age_fila', 'age_fila.id', '=', 'age_agendamento.fila_id')
            ->join('gen_cgm', 'gen_cgm.id', '=', 'age_fila.cgm_id')
            ->join('age_calendario', 'age_agendamento.calendario_id', '=', 'age_calendario.id')
            ->join('age_localidade', 'age_calendario.localidade_id', '=', 'age_localidade.id')
            ->join('age_especialista', 'age_calendario.especialista_id', '=', 'age_especialista.id')
            ->where('age_localidade.id', '=', $idLocal)
            ->where('age_especialista.id', '=', $idMedico)
            ->select([
                'age_evento.*',
                'age_calendario.id as calendario_id',
                'gen_cgm.id as cgm_id',
                'age_agendamento.id as agendamento_id',
            ])->get();

        $dados = [
            'calendarios' => $calendarios,
            'eventos'     => $eventos
        ];

        #Verificando se o registro foi encontrado
        if(!$calendarios && !$eventos) {
            throw new \Exception('Empresa não encontrada!');
        }

        #retorno
        return $dados;
    }

    /**
     * @param array $data
     * @return Agendamento
     * @throws \Exception
     */
    public function store(array $data) : Agendamento
    {
        $date = new \DateTime('now');

        #Salvando o registro pincipal
        $data['dados']['status_agendamento_id'] = '1';
        $data['dados']['data'] = $date->format('Y-m-d');
        $agendamento =  $this->repository->create($data['dados']);

        $agendamentoFind = $this->repository->with(['fila.cgm', 'calendario'])->find($agendamento->id);

        $evento = [
            'title' => $agendamentoFind['fila']['cgm']['nome'],
            'start' => $data['dados']['dataEvento'],
            'agendamento_id' => $agendamento->id,
        ];

        $evento = $this->repoEvento->create($evento);

        // Atualizando o status do paciente na fila
        \DB::table('age_fila')->where('id', $data['dados']['fila_id'])->update(['status' => '1']);

        #Verificando se foi criado no banco de dados
        if(!$agendamento && !$evento) {
            throw new \Exception('Ocorreu um erro ao cadastrar!');
        }

        #Retorno
        return $agendamento;
    }

    /**
     * @param array $data
     * @param $id
     * @return Agendamento
     * @throws \Exception
     */
    public function update(array $data, $id) : Agendamento
    {

        #Deletando no banco de dados
        $agendamento = $this->repository->update($data, $id);

        #Verificando se foi atualizado no banco de dados
        if(!$agendamento) {
            throw new \Exception('Ocorreu um erro ao cadastrar!');
        }

        #Retorno
        return $agendamento;
    }

    /**
     * @param $id
     * @return bool
     */
    public function delete($id)
    {
        // Pegando o agendamento
        $agendamento = $this->repository->find($id);

        // Atualizando o status do paciente na fila
        \DB::table('age_fila')->where('id', $agendamento['fila_id'])->update(['status' => '0']);

        // Deletando o evento
        \DB::table('age_evento')->where('agendamento_id', $id)->delete();

        // Deletando agendamento
        $this->repository->delete($id);

        #Retorno
        return true;
    }

    /**
     * @param array $data
     * @param $id
     * @return Agendamento
     * @throws \Exception
     */
    public function InserirNaFila(array $data)
    {

        // Recuperando o registro de agendamento
        $agendamento = $this->repository->find($data['paciente']);

        // Consultando se o paciente já está em fila de espera
        $validandoFila = \DB::table('age_fila')
            ->where('cgm_id', $agendamento->fila->cgm_id)
            ->where('status', '0')->first();

        // Se veio algum registro na consulta, não poderá ser criada uma nova fila para o paciente
        if ($validandoFila) {

            return false;
        }

        // Replicando os dados da fila atual do paciente para uma nova fila
        $fila['cgm_id'] = $agendamento->fila->cgm_id;
        $fila['especialidade_id'] = $agendamento->fila->especialidade_id;
        $fila['data'] = $agendamento->fila->data;
        $fila['prioridade_id'] = $agendamento->fila->prioridade_id;
        $fila['posto_saude_id'] = $agendamento->fila->posto_saude_id;
        $fila['status'] = '0';
        $fila['observacao'] = $agendamento->fila->observacao;

        // Criando uma nova fila
        $novaFila = $this->filaRepository->create($fila);


        #Retorno
        return true;
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
     * @return mixed
     */
    public function getAllLocalidades()
    {
        $localidades = $this->repoLocalidade->all();

        return $localidades;
    }

    /**
     * @return mixed
     */
    public function getAllEspecialidades()
    {
        $especialidades= $this->repoEspecialidade->all();

        return $especialidades;
    }
}