<?php

namespace Seracademico\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use Seracademico\Repositories\EspecialistaEspecialidadeRepository;
use Seracademico\Entities\EspecialistaEspecialidade;

/**
 * Class AgendamentoRepositoryEloquent
 * @package namespace App\Repositories;
 */
class EspecialistaEspecialidadeRepositoryEloquent extends BaseRepository implements EspecialistaEspecialidadeRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return EspecialistaEspecialidade::class;
    }

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
}
