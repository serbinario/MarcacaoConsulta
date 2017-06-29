<?php

namespace Seracademico\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use Seracademico\Validators\SubOperacaoValidator;
use Seracademico\Repositories\SubOperacaoRepository;
use Seracademico\Entities\SubOperacao;

/**
 * Class AgendamentoRepositoryEloquent
 * @package namespace App\Repositories;
 */
class SubOperacaoRepositoryEloquent extends BaseRepository implements SubOperacaoRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return SubOperacao::class;
    }


    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
}
