<?php

namespace Seracademico\Entities;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

class EnderecoCGM extends Model implements Transformable
{
    use TransformableTrait;

    protected $table    = 'endereco_cgm';

    protected $fillable = [ 
		'logradouro',
		'numero',
		'comp',
		'cep',
		'bairro',
	];

}