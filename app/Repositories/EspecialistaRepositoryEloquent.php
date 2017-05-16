<?php

namespace Seracademico\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use Seracademico\Validators\EspecialistaValidator;
use Seracademico\Repositories\EspecialistaRepository;
use Seracademico\Entities\Especialista;

/**
 * Class EspecialistaRepositoryEloquent
 * @package namespace App\Repositories;
 */
class EspecialistaRepositoryEloquent extends BaseRepository implements EspecialistaRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Especialista::class;
    }

    /**
    * Specify Validator class name
    *
    * @return mixed
    */
    /*public function validator()
    {

         return EspecialistaValidator::class;
    }*/



    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
}
