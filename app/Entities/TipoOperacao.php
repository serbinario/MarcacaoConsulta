<?php

namespace Seracademico\Entities;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

class TipoOperacao extends Model implements Transformable
{
    use TransformableTrait;

    protected $table    = 'age_tipo_operacoes';

    protected $fillable = [ 
		'nome',
	];

}