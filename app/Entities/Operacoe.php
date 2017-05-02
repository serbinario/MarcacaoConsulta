<?php

namespace Seracademico\Entities;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

class Operacoe extends Model implements Transformable
{
    use TransformableTrait;

    protected $table    = 'operacoes';

    protected $fillable = [ 
		'nome',
		'grupo_operaco_id',
	];

	public function grupo()
	{
		return $this->belongsTo(GrupoOperacao::class, "grupo_operaco_id");
	}

}