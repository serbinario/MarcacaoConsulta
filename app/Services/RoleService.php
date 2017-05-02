<?php

namespace Seracademico\Services;

use Seracademico\Repositories\PermissionRepository;
use Seracademico\Repositories\RoleRepository;
use Seracademico\Entities\Role;

class RoleService
{
    /**
     * @var RoleRepository
     */
    private $repository;

    /**
     * @var PermissionRepository
     */
    private $permissionRepository;

    /**
     * @param RoleRepository $repository
     * @param PermissionRepository $permissionRepository
     */
    public function __construct(RoleRepository $repository, PermissionRepository $permissionRepository)
    {
        $this->repository           = $repository;
        $this->permissionRepository = $permissionRepository;
    }

    /**
     * @param $id
     * @return mixed
     * @throws \Exception
     */
    public function find($id)
    {
        #Recuperando o registro no banco de dados
        $role = $this->repository->find($id);

        #Verificando se o registro foi encontrado
        if(!$role) {
            throw new \Exception('Perfil não encontrada!');
        }

        #retorno
        return $role;
    }

    /**
     * @param array $data
     * @return array
     */
    public function store(array $data) : Role
    {
        #tratando o slug
        $data['slug'] = $data['name'];

        #Salvando o registro pincipal
        $role =  $this->repository->create($data);

        #Verificando se foi criado no banco de dados
        if(!$role) {
            throw new \Exception('Ocorreu um erro ao cadastrar!');
        }

        #Recupernado as permissions
        $permissions = $data['permission'] ?? [];

        #Tratando as permissões
        foreach ($permissions as $permission) {
            #Recuperando os papéis
            $permissionObj = $this->permissionRepository->find($permission);

            #Verificando se o registro foi recuperado
            if(!$permissionObj) {
                throw new \Exception('Ocorreu um erro ao cadastrar as permissões!');
            }

            #Vinculando ao role
            $role->attachPermission($permissionObj);
        }

        #Retorno
        return $role;
    }

    /**
     * @param array $data
     * @param int $id
     * @return mixed
     */
    public function update(array $data, int $id) : Role
    {
        #tratando o slug
        $data['slug'] = $data['name'];

        #Atualizando no banco de dados
        $role = $this->repository->update($data, $id);

        #Verificando se foi atualizado no banco de dados
        if(!$role) {
            throw new \Exception('Ocorreu um erro ao cadastrar!');
        }

        #deletando as permissions
        $role->detachAllPermissions();

        #Recupernado as permissions
        $permissions = $data['permission'] ?? [];

        #Tratando as permissões
        foreach ($permissions as $permission) {
            #Recuperando os papéis
            $permissionObj = $this->permissionRepository->find($permission);

            #Verificando se o registro foi recuperado
            if(!$permissionObj) {
                throw new \Exception('Ocorreu um erro ao cadastrar as permissões!');
            }

            #Vinculando ao role
            $role->attachPermission($permissionObj);
        }

        #Retorno
        return $role;
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
            $result[strtolower($model)] = $nameModel::lists('name', 'id');
        }

        #retorno
        return $result;
    }
}