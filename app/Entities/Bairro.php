<?php

namespace Seracademico\Entities;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

class Bairro extends Model implements Transformable
{
    use TransformableTrait;

    protected $table    = 'bairros';

    protected $fillable = [ 
		'nome',
		'cidades_id',
	];

    public function enderecos()
    {
        return $this->hasMany(EnderecoCGM::class, "bairro");
    }

    public function cidade()
    {
        return $this->belongsTo(Cidade::class, "cidades_id");
    }

}