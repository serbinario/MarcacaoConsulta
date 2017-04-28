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
            'especialidade.operacao'
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
     * @return array
     */
    public function store(array $data) : Fila
    {
        if(isset($data['cgm_id']) && $data['cgm_id'] != "") {

            $cgmFind = $this->CGMRepository->find($data['cgm_id']);

            if($cgmFind->endereco_cgm) {
                $endereco = $this->enderecoCGMRepository->update($data['cgm']['endereco'], $cgmFind->endereco_cgm);
            } else {
                $endereco = $this->enderecoCGMRepository->create($data['cgm']['endereco']);
            }

            $data['cgm']['endereco_cgm'] = $endereco->id;
            $this->CGMRepository->update($data['cgm'], $cgmFind->id);

            #Salvando o registro pincipal
            $data['status'] = '0';
            $fila =  $this->repository->create($data);

        } else {

            $endereco = $this->enderecoCGMRepository->create($data['cgm']['endereco']);

            $data['cgm']['endereco_cgm'] = $endereco->id;
            unset($data['cgm']['endereco']);
            $cgm = $this->CGMRepository->create($data['cgm']);

            #Salvando o registro pincipal
            $data['cgm_id'] = $cgm->id;
            $data['status'] = '0';
            $fila =  $this->repository->create($data);
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
     * @return mixed
     */
    public function update(array $data, int $id) : Fila
    {

        if(isset($data['cgm_id']) && $data['cgm_id'] != "") {

            $cgmFind = $this->CGMRepository->find($data['cgm_id']);

            if($cgmFind->endereco_cgm) {
                $endereco = $this->enderecoCGMRepository->update($data['cgm']['endereco'], $cgmFind->endereco_cgm);
            } else {
                $endereco = $this->enderecoCGMRepository->create($data['cgm']['endereco']);
            }

            $data['cgm']['endereco_cgm'] = $endereco->id;
            $this->CGMRepository->update($data['cgm'], $cgmFind->id);

            #Salvando o registro pincipal
            $fila = $this->repository->update($data, $id);

        } else {

            $endereco = $this->enderecoCGMRepository->create($data['cgm']['endereco']);

            $data['cgm']['endereco_cgm'] = $endereco->id;
            unset($data['cgm']['endereco']);
            $cgm = $this->CGMRepository->create($data['cgm']);

            #Atualizando no banco de dados
            $data['cgm_id'] = $cgm->id;
            $fila = $this->repository->update($data, $id);
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
}