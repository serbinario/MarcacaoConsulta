<?php

namespace Seracademico\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use Seracademico\Validators\CategoriaCNHValidator;
use Seracademico\Repositories\CategoriaCNHRepository;
use Seracademico\Entities\CategoriaCNH;

/**
 * Class CategoriaCNHRepositoryEloquent
 * @package namespace App\Repositories;
 */
class CategoriaCNHRepositoryEloquent extends BaseRepository implements CategoriaCNHRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return CategoriaCNH::class;
    }

    /**
    * Specify Validator class name
    *
    * @return mixed
    */
    /*public function validator()
    {

         return CategoriaCNHValidator::class;
    }*/



    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
}
