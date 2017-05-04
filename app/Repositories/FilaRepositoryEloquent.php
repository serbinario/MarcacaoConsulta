<?php

namespace Seracademico\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use Seracademico\Entities\Fila;
use Seracademico\Validators\FilaValidator;

/**
 * Class EspecialidadeRepositoryEloquent
 * @package namespace App\Repositories;
 */
class FilaRepositoryEloquent extends BaseRepository implements FilaRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Fila::class;
    }

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
}
