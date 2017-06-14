<?php

namespace Seracademico\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use Seracademico\Validators\EspecialidadeValidator;
use Seracademico\Repositories\EspecialidadeRepository;
use Seracademico\Entities\Especialidade;

/**
 * Class EspecialidadeRepositoryEloquent
 * @package namespace App\Repositories;
 */
class EspecialidadeRepositoryEloquent extends BaseRepository implements EspecialidadeRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Especialidade::class;
    }


    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
}
