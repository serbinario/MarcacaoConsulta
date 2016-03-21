<?php

namespace Seracademico\Services;

use Seracademico\Repositories\EspecialistaRepository;
use Seracademico\Entities\Especialista;

class EspecialistaService
{
    /**
     * @var EspecialistaRepository
     */
    private $repository;

    /**
     * @param EspecialistaRepository $repository
     */
    public function __construct(EspecialistaRepository $repository)
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

        $relacionamentos = [
            'getCgm',
            'getEspecialidade',
        ];

        #Recuperando o registro no banco de dados
        $especialista = $this->repository->with($relacionamentos)->find($id);

        #Verificando se o registro foi encontrado
        if(!$especialista) {
            throw new \Exception('Empresa não encontrada!');
        }

        #retorno
        return $especialista;
    }

    /**
     * @param array $data
     * @return array
     */
    public function store(array $data) : Especialista
    {
        #Salvando o registro pincipal
        $especialista =  $this->repository->create($data);

        #Verificando se foi criado no banco de dados
        if(!$especialista) {
            throw new \Exception('Ocorreu um erro ao cadastrar!');
        }

        #Retorno
        return $especialista;
    }

    /**
     * @param array $data
     * @param int $id
     * @return mixed
     */
    public function update(array $data, int $id) : Especialista
    {
        #Atualizando no banco de dados
        $especialista = $this->repository->update($data, $id);


        #Verificando se foi atualizado no banco de dados
        if(!$especialista) {
            throw new \Exception('Ocorreu um erro ao cadastrar!');
        }

        #Retorno
        return $especialista;
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