<?php

namespace Seracademico\Services;

use Seracademico\Repositories\OperacoeRepository;
use Seracademico\Entities\Operacoe;

class OperacoeService
{
    /**
     * @var OperacoeRepository
     */
    private $repository;

    /**
     * @param OperacoeRepository $repository
     */
    public function __construct(OperacoeRepository $repository)
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
        $operacoes = $this->repository->find($id);

        #Verificando se o registro foi encontrado
        if(!$operacoes) {
            throw new \Exception('Empresa não encontrada!');
        }

        #retorno
        return $operacoes;
    }

    /**
     * @param array $data
     * @return array
     */
    public function store(array $data) : Operacoe
    {
        #Salvando o registro pincipal
        $operacoes =  $this->repository->create($data);

        #Verificando se foi criado no banco de dados
        if(!$operacoes) {
            throw new \Exception('Ocorreu um erro ao cadastrar!');
        }

        #Retorno
        return $operacoes;
    }

    /**
     * @param array $data
     * @param int $id
     * @return mixed
     */
    public function update(array $data, int $id) : Operacoe
    {
        #Atualizando no banco de dados
        $operacoes = $this->repository->update($data, $id);


        #Verificando se foi atualizado no banco de dados
        if(!$operacoes) {
            throw new \Exception('Ocorreu um erro ao cadastrar!');
        }

        #Retorno
        return $operacoes;
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
     * @param int $id
     * @return bool
     * @throws \Exception
     */
    public function destroy(int $id)
    {
        #deletando o curso
        $result = $this->repository->delete($id);

        # Verificando se a execução foi bem sucessida
        if(!$result) {
            throw new \Exception('Ocorreu um erro ao tentar remover o curso!');
        }

        #retorno
        return true;
    }
}