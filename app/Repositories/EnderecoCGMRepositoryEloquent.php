<?php

namespace Seracademico\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use Seracademico\Validators\EnderecoCGMValidator;
use Seracademico\Repositories\EnderecoCGMRepository;
use Seracademico\Entities\EnderecoCGM;

/**
 * Class EnderecoCGMRepositoryEloquent
 * @package namespace App\Repositories;
 */
class EnderecoCGMRepositoryEloquent extends BaseRepository implements EnderecoCGMRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return EnderecoCGM::class;
    }

    /**
    * Specify Validator class name
    *
    * @return mixed
    */
    public function validator()
    {

         return EnderecoCGMValidator::class;
    }



    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
}
