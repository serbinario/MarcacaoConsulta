<?php

namespace Seracademico\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use Seracademico\Validators\LocalidadeValidator;
use Seracademico\Repositories\LocalidadeRepository;
use Seracademico\Entities\Localidade;

/**
 * Class LocalidadeRepositoryEloquent
 * @package namespace App\Repositories;
 */
class LocalidadeRepositoryEloquent extends BaseRepository implements LocalidadeRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Localidade::class;
    }

    /**
    * Specify Validator class name
    *
    * @return mixed
    */
    public function validator()
    {

         return LocalidadeValidator::class;
    }



    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
}
