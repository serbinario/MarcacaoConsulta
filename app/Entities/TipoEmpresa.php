<?php

namespace Seracademico\Entities;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

class TipoEmpresa extends Model implements Transformable
{
    use TransformableTrait;

    protected $table    = 'gen_tipo_empresa';

    protected $fillable = [ 
		'nome',
	];

}