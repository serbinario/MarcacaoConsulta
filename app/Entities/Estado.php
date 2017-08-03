<?php

namespace Seracademico\Entities;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

class Estado extends Model implements Transformable
{
    use TransformableTrait;

    protected $table    = 'gen_estados';

    protected $fillable = [ 
		'nome',
		'sigla',
	];

}