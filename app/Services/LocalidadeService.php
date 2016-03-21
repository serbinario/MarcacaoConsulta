<?php

namespace Seracademico\Services;

use Seracademico\Repositories\LocalidadeRepository;
use Seracademico\Entities\Localidade;

class LocalidadeService
{
    /**
     * @var LocalidadeRepository
     */
    private $repository;

    /**
     * @param LocalidadeRepository $repository
     */
    public function __construct(LocalidadeRepository $repository)
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
        $localidade = $this->repository->find($id);

        #Verificando se o registro foi encontrado
        if(!$localidade) {
            throw new \Exception('Empresa não encontrada!');
        }

        #retorno
        return $localidade;
    }

    /**
     * @param array $data
     * @return array
     */
    public function store(array $data) : Localidade
    {
        #Salvando o registro pincipal
        $localidade =  $this->repository->create($data);

        #Verificando se foi criado no banco de dados
        if(!$localidade) {
            throw new \Exception('Ocorreu um erro ao cadastrar!');
        }

        #Retorno
        return $localidade;
    }

    /**
     * @param array $data
     * @param int $id
     * @return mixed
     */
    public function update(array $data, int $id) : Localidade
    {
        #Atualizando no banco de dados
        $localidade = $this->repository->update($data, $id);


        #Verificando se foi atualizado no banco de dados
        if(!$localidade) {
            throw new \Exception('Ocorreu um erro ao cadastrar!');
        }

        #Retorno
        return $localidade;
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