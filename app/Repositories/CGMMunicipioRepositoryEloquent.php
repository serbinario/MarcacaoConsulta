<?php

namespace Seracademico\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use Seracademico\Validators\CGMMunicipioValidator;
use Seracademico\Repositories\CGMMunicipioRepository;
use Seracademico\Entities\CGMMunicipio;

/**
 * Class CGMMunicipioRepositoryEloquent
 * @package namespace App\Repositories;
 */
class CGMMunicipioRepositoryEloquent extends BaseRepository implements CGMMunicipioRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return CGMMunicipio::class;
    }

    /**
    * Specify Validator class name
    *
    * @return mixed
    */
    /*public function validator()
    {

         return CGMMunicipioValidator::class;
    }*/



    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
}
