<?php

namespace Seracademico\Services;

use Seracademico\Repositories\CGMRepository;
use Seracademico\Entities\CGM;
use Seracademico\Repositories\EnderecoCGMRepository;
use Seracademico\Entities;

class CGMService
{
    /**
     * @var CGMRepository
     */
    private $repository;

    /**
     * @var EnderecoRepository
     */
    private $enderecoRepository;

    /**
     * @param CGMRepository $repository
     */
    public function __construct(CGMRepository $repository, EnderecoCGMRepository $enderecoRepository)
    {
        $this->repository = $repository;
        $this->enderecoRepository = $enderecoRepository;
    }

    /**
     * @param $id
     * @return mixed
     * @throws \Exception
     */
    public function find($id)
    {

        $relacionamentos = [
            'endereco.bairros.cidade.estado',
            'estadoCivil',
            'sexo',
            'escolaridade',
            'nacionalidade',
        ];

        #Recuperando o registro no banco de dados
        $cGM = $this->repository->with($relacionamentos)->find($id);

        #Verificando se o registro foi encontrado
        if(!$cGM) {
            throw new \Exception('Empresa não encontrada!');
        }

        #retorno
        return $cGM;
    }

    /**
     * @param array $data
     * @return array
     */
    public function store(array $data) : CGM
    {
        #tratamento de dados do aluno
        $data  = $this->tratamentoCampos($data);

        #Criando no banco de dados
        $endereco = $this->enderecoRepository->create($data['endereco']);

        #setando o endereco
        $data['endereco_cgm'] = $endereco->id;

        #Salvando o registro pincipal
        $cGM =  $this->repository->create($data);

        #Verificando se foi criado no banco de dados
        if(!$cGM) {
            throw new \Exception('Ocorreu um erro ao cadastrar!');
        }

        #Retorno
        return $cGM;
    }

    /**
     * @param array $data
     * @param int $id
     * @return mixed
     */
    public function update(array $data, int $id) : CGM
    {
        //dd($data);
        #tratamento de dados do aluno
        $data     = $this->tratamentoCampos($data);
        $this->tratamentoCampos($data['endereco']);

        #Atualizando no banco de dados
        $cGM = $this->repository->update($data, $id);
        
        $endereco = $this->enderecoRepository->update($data['endereco'], $cGM->endereco->id);

        #Verificando se foi atualizado no banco de dados
        if(!$cGM || !$endereco) {
            throw new \Exception('Ocorreu um erro ao atualizar!');
        }

        #Retorno
        return $cGM;
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
}