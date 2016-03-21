<?php

namespace Seracademico\Services;

use Seracademico\Repositories\PostoSaudeRepository;
use Seracademico\Entities\PostoSaude;

class PostoSaudeService
{
    /**
     * @var PostoSaudeRepository
     */
    private $repository;

    /**
     * @param PostoSaudeRepository $repository
     */
    public function __construct(PostoSaudeRepository $repository)
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
        $postoSaude = $this->repository->find($id);

        #Verificando se o registro foi encontrado
        if(!$postoSaude) {
            throw new \Exception('Empresa não encontrada!');
        }

        #retorno
        return $postoSaude;
    }

    /**
     * @param array $data
     * @return array
     */
    public function store(array $data) : PostoSaude
    {
        #Salvando o registro pincipal
        $postoSaude =  $this->repository->create($data);

        #Verificando se foi criado no banco de dados
        if(!$postoSaude) {
            throw new \Exception('Ocorreu um erro ao cadastrar!');
        }

        #Retorno
        return $postoSaude;
    }

    /**
     * @param array $data
     * @param int $id
     * @return mixed
     */
    public function update(array $data, int $id) : PostoSaude
    {
        #Atualizando no banco de dados
        $postoSaude = $this->repository->update($data, $id);


        #Verificando se foi atualizado no banco de dados
        if(!$postoSaude) {
            throw new \Exception('Ocorreu um erro ao cadastrar!');
        }

        #Retorno
        return $postoSaude;
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