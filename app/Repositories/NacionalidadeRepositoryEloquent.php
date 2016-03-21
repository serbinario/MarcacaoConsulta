<?php

namespace Seracademico\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use Seracademico\Validators\NacionalidadeValidator;
use Seracademico\Repositories\NacionalidadeRepository;
use Seracademico\Entities\Nacionalidade;

/**
 * Class NacionalidadeRepositoryEloquent
 * @package namespace App\Repositories;
 */
class NacionalidadeRepositoryEloquent extends BaseRepository implements NacionalidadeRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Nacionalidade::class;
    }

    /**
    * Specify Validator class name
    *
    * @return mixed
    */
    public function validator()
    {

         return NacionalidadeValidator::class;
    }



    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
}
