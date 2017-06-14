<?php

namespace Seracademico\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use Seracademico\Validators\AgendamentoValidator;
use Seracademico\Repositories\AgendamentoRepository;
use Seracademico\Entities\Agendamento;

/**
 * Class AgendamentoRepositoryEloquent
 * @package namespace App\Repositories;
 */
class AgendamentoRepositoryEloquent extends BaseRepository implements AgendamentoRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Agendamento::class;
    }



    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
}
