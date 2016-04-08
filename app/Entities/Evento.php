<?php

namespace Seracademico\Entities;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

class Evento extends Model implements Transformable
{
    use TransformableTrait;

    protected $table    = 'evento';

    protected $fillable = [ 
		'title',
		'start',
		'end',
		'agendamento_id',
	];

}