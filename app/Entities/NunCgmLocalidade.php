<?php

namespace Seracademico\Entities;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

class NunCgmLocalidade extends Model implements Transformable
{
    use TransformableTrait;

    protected $table    = 'age_num_cgm_localidade';

    protected $fillable = [ 
		'nome',
		'fila_id',
		'localidade_id',
	];

}