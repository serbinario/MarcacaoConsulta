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
     * @return mixed
     * @throws \Exception
     */
    public function all()
    {
        #Recuperando o registro no banco de dados
        $psfs = $this->repository->all();

        #Verificando se o registro foi encontrado
        if(!$psfs) {
            throw new \Exception('Especialidades não encontrada!');
        }

        #retorno
        return $psfs;
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
    public function load(array $models, $ajax = false) : array
    {
        #Declarando variáveis de uso
        $result    = [];
        $expressao = [];

        #Criando e executando as consultas
        foreach ($models as $model) {
            # separando as strings
            $explode   = explode("|", $model);

            # verificando a condição
            if(count($explode) > 1) {
                $model     = $explode[0];
                $expressao = explode(",", $explode[1]);
            }

            #qualificando o namespace
            $nameModel = "\\Seracademico\\Entities\\$model";

            #Verificando se existe sobrescrita do nome do model
            //$model     = isset($expressao[2]) ? $expressao[2] : $model;

            if ($ajax) {
                if(count($expressao) > 0) {
                    switch (count($expressao)) {
                        case 1 :
                            #Recuperando o registro e armazenando no array
                            $result[strtolower($model)] = $nameModel::{$expressao[0]}()->orderBy('nome', 'asc')->get(['nome', 'id', 'codigo']);
                            break;
                        case 2 :
                            #Recuperando o registro e armazenando no array
                            $result[strtolower($model)] = $nameModel::{$expressao[0]}($expressao[1])->orderBy('nome', 'asc')->get(['nome', 'id', 'codigo']);
                            break;
                        case 3 :
                            #Recuperando o registro e armazenando no array
                            $result[strtolower($model)] = $nameModel::{$expressao[0]}($expressao[1], $expressao[2])->orderBy('nome', 'asc')->get(['nome', 'id', 'codigo']);
                            break;
                    }

                } else {
                    #Recuperando o registro e armazenando no array
                    $result[strtolower($model)] = $nameModel::orderBy('nome', 'asc')->get(['nome', 'id']);
                }
            } else {
                if(count($expressao) > 0) {
                    switch (count($expressao)) {
                        case 1 :
                            #Recuperando o registro e armazenando no array
                            $result[strtolower($model)] = $nameModel::{$expressao[0]}()->orderBy('nome', 'asc')->lists('nome', 'id');
                            break;
                        case 2 :
                            #Recuperando o registro e armazenando no array
                            $result[strtolower($model)] = $nameModel::{$expressao[0]}($expressao[1])->orderBy('nome', 'asc')->lists('nome', 'id');
                            break;
                        case 3 :
                            #Recuperando o registro e armazenando no array
                            $result[strtolower($model)] = $nameModel::{$expressao[0]}($expressao[1], $expressao[2])->orderBy('nome', 'asc')->lists('nome', 'id');
                            break;
                    }
                } else {
                    #Recuperando o registro e armazenando no array
                    $result[strtolower($model)] = $nameModel::lists('nome', 'id');
                }
            }

            # Limpando a expressão
            $expressao = [];
        }

        #retorno
        return $result;
    }
}