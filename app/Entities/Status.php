<?php

namespace Seracademico\Entities;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

class Status extends Model implements Transformable
{
    use TransformableTrait;

    protected $table    = 'age_status';

    protected $fillable = [ 
		'nome',
	];

}