<?php

namespace Seracademico\Services;

use Seracademico\Entities\EspecialistaEspecialidade;
use Seracademico\Repositories\EspecialistaRepository;
use Seracademico\Repositories\EspecialistaEspecialidadeRepository;
use Seracademico\Entities\Especialista;

class EspecialistaService
{
    /**
     * @var EspecialistaRepository
     */
    private $repository;

    /**
     * @var EspecialistaEspecialidadeRepository
     */
    private $repositoryEspecialistaEspecialidade;

    /**
     * @param EspecialistaRepository $repository
     * @param EspecialistaEspecialidadeRepository $repositoryEspecialistaEspecialidade
     */
    public function __construct(EspecialistaRepository $repository,
                                EspecialistaEspecialidadeRepository $repositoryEspecialistaEspecialidade)
    {
        $this->repository = $repository;
        $this->repositoryEspecialistaEspecialidade = $repositoryEspecialistaEspecialidade;
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
            'especialistaEspecialidade.operacao.grupo.tipo',
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
     * @param $id
     * @return mixed
     * @throws \Exception
     */
    public function findByEspecialidade($id)
    {

        #Recuperando o registro no banco de dados
        $especialista = \DB::table('especialista')
            ->join('cgm', 'cgm.id', '=', 'especialista.cgm')
            ->join('especialista_especialidade', 'especialista_especialidade.especialista_id', '=', 'especialista.id')
            ->where('especialista_especialidade.especialidade_id', '=', $id)
            ->select([
                'especialista.id',
                'cgm.nome'
            ])->get();

        #retorno
        return $especialista;
    }

    /**
     * @param $id
     * @return mixed
     * @throws \Exception
     */
    public function findEspecialidades($idEspecialista)
    {

        #Recuperando o registro no banco de dados
        $especialidades = \DB::table('especialidade')
            ->join('especialista_especialidade', 'especialidade.id', '=', 'especialista_especialidade.especialidade_id')
            ->join('operacoes', 'operacoes.id', '=', 'especialidade.operacao_id')
            ->where('especialista_especialidade.especialista_id', '=', $idEspecialista)
            ->select([
                'especialista_especialidade.id',
                'operacoes.nome'
            ])->get();

        #retorno
        return $especialidades;
    }

    /**
     * @param $id
     * @return mixed
     * @throws \Exception
     */
    public function findEspecialidadesEspecificas($idEspecialista, $idEspecialidade)
    {

        #Recuperando o registro no banco de dados
        $especialidades = \DB::table('especialidade')
            ->join('especialista_especialidade', 'especialidade.id', '=', 'especialista_especialidade.especialidade_id')
            ->join('operacoes', 'operacoes.id', '=', 'especialidade.operacao_id')
            ->where('especialista_especialidade.especialista_id', '=', $idEspecialista)
            ->where('especialista_especialidade.especialidade_id', '=', $idEspecialidade)
            ->select([
                'especialista_especialidade.id',
                'operacoes.nome'
            ])->get();

        #retorno
        return $especialidades;
    }

    /**
     * @param array $data
     * @return array
     */
    public function store(array $data) : Especialista
    {
        #Salvando o registro pincipal
        $especialista =  $this->repository->create($data);
        //$especialista->especialistaEspecialidade()->attach($data['operacoes']);

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
        //$especialista->especialistaEspecialidade()->detach();
        //$especialista->especialistaEspecialidade()->attach($data['operacoes']);

        #Verificando se foi atualizado no banco de dados
        if(!$especialista) {
            throw new \Exception('Ocorreu um erro ao cadastrar!');
        }

        #Retorno
        return $especialista;
    }

    /**
     * @param array $data
     * @return array
     */
    public function storeEspecialidade(array $data) : EspecialistaEspecialidade
    {

        //dd($data);
        #Salvando o registro pincipal
        $especialidade =  $this->repositoryEspecialistaEspecialidade->create($data);

        #Verificando se foi criado no banco de dados
        if(!$especialidade) {
            throw new \Exception('Ocorreu um erro ao cadastrar!');
        }

        #Retorno
        return $especialidade;
    }

    /**
     * @param int $id
     * @return bool
     * @throws \Exception
     */
    public function destroyEspecialidade(int $id)
    {
        #deletando o curso
        $result = $this->repositoryEspecialistaEspecialidade->delete($id);

        # Verificando se a execução foi bem sucessida
        if(!$result) {
            throw new \Exception('Ocorreu um erro ao tentar remover a especialidade!');
        }

        #retorno
        return true;
    }

    /**
     * @param $id
     * @return mixed
     * @throws \Exception
     */
    public function findEspecialistaEspecialidade($id)
    {

        $relacionamentos = [
            'mapas',
        ];

        #Recuperando o registro no banco de dados
        $especialidade = $this->repositoryEspecialistaEspecialidade->with($relacionamentos)->find($id);

        #Verificando se o registro foi encontrado
        if(!$especialidade) {
            throw new \Exception('Empresa não encontrada!');
        }

        #retorno
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

        // Deletando as especialidades do especialista
        \DB::table('especialista_especialidade')->where('especialista_id', $id)->delete();

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