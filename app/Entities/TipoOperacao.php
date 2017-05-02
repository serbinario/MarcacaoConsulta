<?php

namespace Seracademico\Entities;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

class TipoOperacao extends Model implements Transformable
{
    use TransformableTrait;

    protected $table    = 'tipo_operacoes';

    protected $fillable = [ 
		'nome',
	];

}