<?php

namespace Seracademico\Services;

use Seracademico\Repositories\CalendarioRepository;
use Seracademico\Entities\Calendario;

class CalendarioService
{
    /**
     * @var CalendarioRepository
     */
    private $repository;

    /**
     * @param CalendarioRepository $repository
     */
    public function __construct(CalendarioRepository $repository)
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
        $calendario = $this->repository->find($id);

        #Verificando se o registro foi encontrado
        if(!$calendario) {
            throw new \Exception('Empresa não encontrada!');
        }

        #retorno
        return $calendario;
    }

    /**
     * @param array $data
     * @return array
     */
    public function store(array $data) : Calendario
    {

        #tratamento de dados do aluno
        $data     = $this->tratamentoCampos($data);

        #Salvando o registro pincipal
        $calendario =  $this->repository->create($data);

        #Verificando se foi criado no banco de dados
        if(!$calendario) {
            throw new \Exception('Ocorreu um erro ao cadastrar!');
        }

        #Retorno
        return $calendario;
    }


    /**
     * @param $id
     * @return mixed
     * @throws \Exception
     */
    public function getCalendarioByMedico($id)
    {
        #Recuperando o registro no banco de dados
        $calendarios = $this->repository->findWhere(['especialista_id' => $id]);

        #Verificando se o registro foi encontrado
        if(!$calendarios) {
            throw new \Exception('Empresa não encontrada!');
        }

        #retorno
        return $calendarios;
    }

    /**
     * @param $id
     * @return mixed
     * @throws \Exception
     */
    public function findCalendarioData($data)
    {
        #Recuperando o registro no banco de dados
        $calendario = $this->repository->findWhere(['data' => $data]);

        #Verificando se o registro foi encontrado
        if(!$calendario) {
            throw new \Exception('Empresa não encontrada!');
        }

        #retorno
        return $calendario;
    }

    /**
     * @param $id
     * @return mixed
     * @throws \Exception
     */
    public function findCalendarioDataMedico($data, $idEspecialista, $idlocalidade)
    {
        #Recuperando o registro no banco de dados
        $calendario = $this->repository->findWhere(['data' => $data, 'especialista_id' => $idEspecialista, 'localidade_id' => $idlocalidade]);

        #Verificando se o registro foi encontrado
        if(count($calendario) <= 0) {
            return false;
        }

        #retorno
        return $calendario;
    }

    /**
     * @param array $data
     * @param int $id
     * @return mixed
     */
    public function update(array $data, int $id) : Calendario
    {

        #tratamento de dados do aluno
        $data     = $this->tratamentoCampos($data);

        #Atualizando no banco de dados
        $calendario = $this->repository->update($data, $id);


        #Verificando se foi atualizado no banco de dados
        if(!$calendario) {
            throw new \Exception('Ocorreu um erro ao cadastrar!');
        }

        #Retorno
        return $calendario;
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
    private function tratamentoCampos($data)
    {
        #tratamento de datas do aluno
        $data['data']     = $this->convertDate($data['data'], 'en');

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
    public function getCGMWithDateFormatPtBr($model)
    {
        #validando as datas
        $model->data   = $model->data == '0000-00-00' ? "" : $model->data;

        #tratando as datas
        $model->data   = $model->data == "" ? "" : date('d/m/Y', strtotime($model->data));

        #return
        return $model;
    }
}