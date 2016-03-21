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
            'endereco',
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
        $data     = $this->tratamentoCamposAluno($data);

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

        #tratamento de dados do aluno
        $data     = $this->tratamentoCamposAluno($data);

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
     * @param $data
     * @return mixed
     */
    private function tratamentoCamposAluno($data)
    {
        #tratamento de datas do aluno
        $data['data_expedicao']     = $this->convertDate($data['data_expedicao'], 'en');
        $data['data_nascimento']    = $this->convertDate($data['data_nascimento'], 'en');
        $data['data_falecimento']   = $this->convertDate($data['data_falecimento'], 'en');
        $data['venci_cnh']          = $this->convertDate($data['venci_cnh'], 'en');

        #retorno
        return $data;
    }

    /**
     * @param $date
     * @return bool|string
     */
    public function convertDate($date, $format)
    {
        #declarando variável de retorno
        $result = "";

        #convertendo a data
        if (!empty($date) && !empty($format)) {
            #Fazendo o tratamento por idioma
            switch ($format) {
                case 'pt-BR' : $result = date_create_from_format('Y-m-d', $date); break;
                case 'en'    : $result = date_create_from_format('d/m/Y', $date); break;
            }
        }

        #retorno
        return $result;
    }

    /**
     * @param Aluno $aluno
     */
    public function getCGMWithDateFormatPtBr(CGM $model)
    {
        #validando as datas
        $model->data_expedicao   = $model->data_expedicao == '0000-00-00' ? "" : $model->data_expedicao;
        $model->data_nascimento  = $model->data_nascimento == '0000-00-00' ? "" : $model->data_nascimento;
        $model->data_falecimento = $model->data_falecimento == '0000-00-00' ? "" : $model->data_falecimento;
        $model->venci_cnh        = $model->venci_cnh == '0000-00-00' ? "" : $model->venci_cnh;

        #tratando as datas
        $model->data_expedicao      = $model->data_expedicao == "" ? "" : date('d/m/Y', strtotime($model->data_expedicao));
        $model->data_nascimento     = $model->data_nascimento == "" ? "" : date('d/m/Y', strtotime($model->data_nascimento));
        $model->data_falecimento    = $model->data_falecimento == "" ? "" : date('d/m/Y', strtotime($model->data_falecimento));
        $model->venci_cnh           = $model->venci_cnh == "" ? "" : date('d/m/Y', strtotime($model->venci_cnh));

        #return
        return $model;
    }
}