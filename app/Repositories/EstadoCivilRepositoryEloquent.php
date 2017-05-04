<?php

namespace Seracademico\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use Seracademico\Validators\EstadoCivilValidator;
use Seracademico\Repositories\EstadoCivilRepository;
use Seracademico\Entities\EstadoCivil;

/**
 * Class EstadoCivilRepositoryEloquent
 * @package namespace App\Repositories;
 */
class EstadoCivilRepositoryEloquent extends BaseRepository implements EstadoCivilRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return EstadoCivil::class;
    }

    /**
    * Specify Validator class name
    *
    * @return mixed
    */
    public function validator()
    {

         return EstadoCivilValidator::class;
    }



    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
}
