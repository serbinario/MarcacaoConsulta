<?php

namespace Seracademico\Entities;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

class CategoriaCNH extends Model implements Transformable
{
    use TransformableTrait;

    protected $table    = 'gen_categoria_cnh';

    protected $fillable = [ 
		'nome',
	];

}