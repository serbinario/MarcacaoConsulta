<?php

namespace Seracademico\Entities;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

class Especialidade extends Model implements Transformable
{
    use TransformableTrait;

    protected $table    = 'especialidade';

    protected $fillable = [ 
		'nome',
	];

}