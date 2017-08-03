<?php

namespace Seracademico\Entities;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

class EnderecoCGM extends Model implements Transformable
{
    use TransformableTrait;

    protected $table    = 'gen_endereco';

    protected $fillable = [ 
		'logradouro',
		'numero',
		'complemento',
		'cep',
		'bairro_id',
	];

	public function bairros()
	{
		return $this->belongsTo(Bairro::class, 'bairro_id');
	}
}