<?php

namespace Seracademico\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use Seracademico\Validators\EscolaridadeValidator;
use Seracademico\Repositories\EscolaridadeRepository;
use Seracademico\Entities\Escolaridade;

/**
 * Class EscolaridadeRepositoryEloquent
 * @package namespace App\Repositories;
 */
class EscolaridadeRepositoryEloquent extends BaseRepository implements EscolaridadeRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Escolaridade::class;
    }

    /**
    * Specify Validator class name
    *
    * @return mixed
    */
    public function validator()
    {

         return EscolaridadeValidator::class;
    }



    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
}
