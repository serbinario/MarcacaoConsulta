<?php

namespace Seracademico\Entities;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

class Sexo extends Model implements Transformable
{
    use TransformableTrait;

    protected $table    = 'sexo';

    protected $fillable = [ 
		'nome',
	];

}