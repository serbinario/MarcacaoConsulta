<?php

namespace Seracademico\Entities;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

class CGMMunicipio extends Model implements Transformable
{
    use TransformableTrait;

    protected $table    = 'cgmmunicipio';

    protected $fillable = [ 
		'nome',
	];

}