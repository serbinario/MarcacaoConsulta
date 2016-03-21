<?php

namespace Seracademico\Services;

use Seracademico\Repositories\EnderecoCGMRepository;
use Seracademico\Entities\EnderecoCGM;

class EnderecoCGMService
{
    /**
     * @var EnderecoCGMRepository
     */
    private $repository;

    /**
     * @param EnderecoCGMRepository $repository
     */
    public function __construct(EnderecoCGMRepository $repository)
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
        $enderecoCGM = $this->repository->find($id);

        #Verificando se o registro foi encontrado
        if(!$enderecoCGM) {
            throw new \Exception('Empresa não encontrada!');
        }

        #retorno
        return $enderecoCGM;
    }

    /**
     * @param array $data
     * @return array
     */
    public function store(array $data) : EnderecoCGM
    {
        #Salvando o registro pincipal
        $enderecoCGM =  $this->repository->create($data);

        #Verificando se foi criado no banco de dados
        if(!$enderecoCGM) {
            throw new \Exception('Ocorreu um erro ao cadastrar!');
        }

        #Retorno
        return $enderecoCGM;
    }

    /**
     * @param array $data
     * @param int $id
     * @return mixed
     */
    public function update(array $data, int $id) : EnderecoCGM
    {
        #Atualizando no banco de dados
        $enderecoCGM = $this->repository->update($data, $id);


        #Verificando se foi atualizado no banco de dados
        if(!$enderecoCGM) {
            throw new \Exception('Ocorreu um erro ao cadastrar!');
        }

        #Retorno
        return $enderecoCGM;
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