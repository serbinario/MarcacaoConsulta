<?php

namespace Seracademico\Entities;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

class Nacionalidade extends Model implements Transformable
{
    use TransformableTrait;

    protected $table    = 'nacionalidade';

    protected $fillable = [ 
		'nome',
	];

}