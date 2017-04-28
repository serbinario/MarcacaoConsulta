<?php

namespace Seracademico\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use Seracademico\Validators\OperacoeValidator;
use Seracademico\Repositories\OperacoeRepository;
use Seracademico\Entities\Operacoe;

/**
 * Class OperacoeRepositoryEloquent
 * @package namespace App\Repositories;
 */
class OperacoeRepositoryEloquent extends BaseRepository implements OperacoeRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Operacoe::class;
    }

    /**
    * Specify Validator class name
    *
    * @return mixed
    */
    public function validator()
    {

         return OperacoeValidator::class;
    }



    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
}
