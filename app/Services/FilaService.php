<?php

namespace Seracademico\Services;

use Seracademico\Repositories\FilaRepository;
use Seracademico\Repositories\CGMRepository;
use Seracademico\Repositories\EnderecoCGMRepository;
use Seracademico\Entities\Fila;

class FilaService
{
    /**
     * @var FilaRepository
     */
    private $repository;

    /**
     * @var CGMRepository
     */
    private $CGMRepository;

    /**
     * @var EnderecoCGMRepository
     */
    private $enderecoCGMRepository;

    /**
     * @param FilaRepository $repository
     */
    public function __construct(FilaRepository $repository,
                                CGMRepository $CGMRepository,
                                EnderecoCGMRepository $enderecoCGMRepository)
    {
        $this->repository = $repository;
        $this->CGMRepository = $CGMRepository;
        $this->enderecoCGMRepository = $enderecoCGMRepository;
    }

    /**
     * @param $id
     * @return mixed
     * @throws \Exception
     */
    public function find($id)
    {
        $relacionamentos = [
            'cgm.endereco.bairros.cidade.estado',
            'prioridade',
            'especialidade.operacao.grupo.tipo',
            'suboperacoes'
        ];

        #Recuperando o registro no banco de dados
        $fila = $this->repository->with($relacionamentos)->find($id);

        #Verificando se o registro foi encontrado
        if(!$fila) {
            throw new \Exception('Empresa não encontrada!');
        }

        #retorno
        return $fila;
    }

    /**
     * @param array $data
     * @return Fila
     * @throws \Exception
     */
    public function store(array $data) : Fila
    {

        $data = $this->tratamentoCampos($data);

        if(isset($data['cgm_id']) && $data['cgm_id'] != "") {

            $cgmFind = $this->CGMRepository->find($data['cgm_id']);

            if($cgmFind->endereco_id) {
                $endereco = $this->enderecoCGMRepository->update($data['cgm']['endereco'], $cgmFind->endereco_id);
            } else {
                $endereco = $this->enderecoCGMRepository->create($data['cgm']['endereco']);
            }

            $data['cgm']['endereco_id'] = $endereco->id;
            $this->CGMRepository->update($data['cgm'], $cgmFind->id);

            #Salvando o registro pincipal
            $data['status'] = '0';
            $fila =  $this->repository->create($data);

        } else {

            $endereco = $this->enderecoCGMRepository->create($data['cgm']['endereco']);

            $data['cgm']['endereco_id'] = $endereco->id;
            unset($data['cgm']['endereco']);
            $cgm = $this->CGMRepository->create($data['cgm']);

            #Salvando o registro pincipal
            $data['cgm_id'] = $cgm->id;
            $data['status'] = '0';
            $fila =  $this->repository->create($data);
        }

        // Inserindo as suboperações da fila
        if(isset($data['sub_operacoes'])){
            $fila->suboperacoes()->attach($data['sub_operacoes']);
        }

        #Verificando se foi criado no banco de dados
        if(!$fila) {
            throw new \Exception('Ocorreu um erro ao cadastrar!');
        }

        #Retorno
        return $fila;
    }

    /**
     * @param array $data
     * @param int $id
     * @return Fila
     * @throws \Exception
     */
    public function update(array $data, int $id) : Fila
    {

        $data = $this->tratamentoCampos($data);

        //dd($data);

        // Edita a fila
        $fila = $this->repository->update($data, $id);

        // Recupera o cgm dessa fila
        $cgmFind = $this->CGMRepository->find($fila->cgm_id);

        // Atualizando ou creando um endereço
        if($cgmFind->endereco_id) {
            $endereco = $this->enderecoCGMRepository->update($data['cgm']['endereco'], $cgmFind->endereco_id);
        } else {
            $endereco = $this->enderecoCGMRepository->create($data['cgm']['endereco']);
        }

        // Update cgm
        $data['cgm']['endereco_id'] = $endereco->id;
        unset($data['cgm']['endereco']);
        $this->CGMRepository->update($data['cgm'], $cgmFind->id);

        // Inserindo as suboperações da fila
        if(isset($data['sub_operacoes'])){
            $fila->suboperacoes()->detach();
            $fila->suboperacoes()->attach($data['sub_operacoes']);
        }


        #Verificando se foi atualizado no banco de dados
        if(!$fila) {
            throw new \Exception('Ocorreu um erro ao cadastrar!');
        }

        #Retorno
        return $fila;
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
     * @param array $data
     * @return array
     */
    public function tratamentoCampos(array &$data)
    {
        # Tratamento de campos de chaves estrangeira
        foreach ($data as $key => $value) {
            $explodeKey = explode("_", $key);

            if ($explodeKey[count($explodeKey) -1] == "id" && $value == null ) {
                unset($data[$key]);
            }
        }
        #Retorno
        return $data;
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