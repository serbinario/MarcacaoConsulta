<?php

namespace Seracademico\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use Seracademico\Validators\CGMValidator;
use Seracademico\Repositories\CGMRepository;
use Seracademico\Entities\CGM;

/**
 * Class CGMRepositoryEloquent
 * @package namespace App\Repositories;
 */
class CGMRepositoryEloquent extends BaseRepository implements CGMRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return CGM::class;
    }

    /**
    * Specify Validator class name
    *
    * @return mixed
    */
    public function validator()
    {

         return CGMValidator::class;
    }



    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
}
