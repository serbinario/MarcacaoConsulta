<?php

namespace Seracademico\Services;

use Seracademico\Repositories\EventoRepository;
use Seracademico\Entities\Evento;

class EventoService
{
    /**
     * @var EventoRepository
     */
    private $repository;

    /**
     * @param EventoRepository $repository
     */
    public function __construct(EventoRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param $id
     * @return mixed
     * @throws \Exception
     */
    public function find($id)
    {
        #Recuperando o registro no banco de dados
        $evento = $this->repository->find($id);

        #Verificando se o registro foi encontrado
        if(!$evento) {
            throw new \Exception('Empresa não encontrada!');
        }

        #retorno
        return $evento;
    }

    /**
     * @param array $data
     * @return array
     */
    public function store(array $data) : Evento
    {
        #Salvando o registro pincipal
        $evento =  $this->repository->create($data);

        #Verificando se foi criado no banco de dados
        if(!$evento) {
            throw new \Exception('Ocorreu um erro ao cadastrar!');
        }

        #Retorno
        return $evento;
    }

    /**
     * @param array $data
     * @param int $id
     * @return mixed
     */
    public function update(array $data, int $id) : Evento
    {
        #Atualizando no banco de dados
        $evento = $this->repository->update($data, $id);


        #Verificando se foi atualizado no banco de dados
        if(!$evento) {
            throw new \Exception('Ocorreu um erro ao cadastrar!');
        }

        #Retorno
        return $evento;
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
}