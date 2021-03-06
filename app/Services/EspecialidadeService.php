<?php

namespace Seracademico\Services;

use Seracademico\Repositories\EspecialidadeRepository;
use Seracademico\Entities\Especialidade;

class EspecialidadeService
{
    /**
     * @var EspecialidadeRepository
     */
    private $repository;

    /**
     * @param EspecialidadeRepository $repository
     */
    public function __construct(EspecialidadeRepository $repository)
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
        $relacionamento = [
            'operacao.grupo.tipo'
        ];
        
        #Recuperando o registro no banco de dados
        $especialidade = $this->repository->with($relacionamento)->find($id);

        #Verificando se o registro foi encontrado
        if(!$especialidade) {
            throw new \Exception('Empresa não encontrada!');
        }

        #retorno
        return $especialidade;
    }

    /**
     * @return mixed
     * @throws \Exception
     */
    public function all()
    {
        #Recuperando o registro no banco de dados
        $especialidades = $this->repository->all();

        #Verificando se o registro foi encontrado
        if(!$especialidades) {
            throw new \Exception('Especialidades não encontrada!');
        }

        #retorno
        return $especialidades;
    }

    /**
     * @param array $data
     * @return array
     */
    public function store(array $data) : Especialidade
    {
        #Salvando o registro pincipal
        $especialidade =  $this->repository->create($data);

        #Verificando se foi criado no banco de dados
        if(!$especialidade) {
            throw new \Exception('Ocorreu um erro ao cadastrar!');
        }

        #Retorno
        return $especialidade;
    }

    /**
     * @param array $data
     * @param int $id
     * @return mixed
     */
    public function update(array $data, int $id) : Especialidade
    {
        #Atualizando no banco de dados
        $especialidade = $this->repository->update($data, $id);


        #Verificando se foi atualizado no banco de dados
        if(!$especialidade) {
            throw new \Exception('Ocorreu um erro ao cadastrar!');
        }

        #Retorno
        return $especialidade;
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