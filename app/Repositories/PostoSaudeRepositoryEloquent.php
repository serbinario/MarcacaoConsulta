<?php

namespace Seracademico\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use Seracademico\Validators\PostoSaudeValidator;
use Seracademico\Repositories\PostoSaudeRepository;
use Seracademico\Entities\PostoSaude;

/**
 * Class PostoSaudeRepositoryEloquent
 * @package namespace App\Repositories;
 */
class PostoSaudeRepositoryEloquent extends BaseRepository implements PostoSaudeRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return PostoSaude::class;
    }

    /**
    * Specify Validator class name
    *
    * @return mixed
    */
    public function validator()
    {

         return PostoSaudeValidator::class;
    }



    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
}
