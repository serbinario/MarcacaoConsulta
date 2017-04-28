<?php

namespace Seracademico\Services;

use Seracademico\Repositories\AgendamentoRepository;
use Seracademico\Entities\Agendamento;
use Seracademico\Repositories\CalendarioRepository;
use Seracademico\Repositories\EspecialidadeRepository;
use Seracademico\Repositories\EventoRepository;
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
     * @param AgendamentoRepository $repository
     */
    public function __construct(AgendamentoRepository $repository,
                                LocalidadeRepository $repoLocalidade,
                                EspecialidadeRepository $repoEspecialidade,
                                EventoRepository $repoEvento, CalendarioRepository $repoCalendario)
    {
        $this->repository = $repository;
        $this->repoLocalidade = $repoLocalidade;
        $this->repoEspecialidade = $repoEspecialidade;
        $this->repoEvento = $repoEvento;
        $this->repoCalendario = $repoCalendario;
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
            'calendario.agendamento',
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
        $calendarios = $this->repoCalendario->with(['especialista', 'agendamento'])->findWhere(['especialista_id' => $idMedico, 'localidade_id' => $idLocal]);

        $eventos = \DB::table('evento')
            ->join('agendamento', 'evento.agendamento_id', '=', 'agendamento.id')
            ->join('fila', 'fila.id', '=', 'agendamento.fila_id')
            ->join('cgm', 'cgm.id', '=', 'fila.cgm_id')
            ->join('calendario', 'agendamento.calendario_id', '=', 'calendario.id')
            ->join('localidade', 'calendario.localidade_id', '=', 'localidade.id')
            ->join('especialista', 'calendario.especialista_id', '=', 'especialista.id')
            ->select('evento.*', 'calendario.id as calendario_id', 'cgm.id as cgm_id', 'agendamento.id as agendamento_id')
            ->where('localidade.id', '=', $idLocal)
            ->where('especialista.id', '=', $idMedico)
            ->get();

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
     * @return array
     */
    public function store(array $data) : Agendamento
    {
        #Salvando o registro pincipal
        $agendamento =  $this->repository->create($data['dados']);

        $agendamentoFind = $this->repository->with(['fila.cgm', 'calendario'])->find($agendamento->id);

        $evento = [
            'title' => $agendamentoFind['fila']['cgm']['nome'],
            'start' => $data['dados']['dataEvento'],
            'agendamento_id' => $agendamento->id,
        ];

        $evento = $this->repoEvento->create($evento);

        // Atualizando o status do paciente na fila
        \DB::table('fila')->where('id', $data['dados']['fila_id'])->update(['status' => '1']);

        #Verificando se foi criado no banco de dados
        if(!$agendamento && !$evento) {
            throw new \Exception('Ocorreu um erro ao cadastrar!');
        }

        #Retorno
        return $agendamento;
    }

    /**
     * @param array $data
     * @param int $id
     * @return mixed
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
     * @param array $data
     * @param int $id
     * @return mixed
     */
    public function delete($id)
    {
        // Pegando o agendamento
        $agendamento = $this->repository->find($id);

        // Atualizando o status do paciente na fila
        \DB::table('fila')->where('id', $agendamento['fila_id'])->update(['status' => '0']);

        #Deletando no banco de dados
        // Deletando o evento
        \DB::table('evento')->where('agendamento_id', $id)->delete();
        // Deletando agendamento
        $this->repository->delete($id);

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