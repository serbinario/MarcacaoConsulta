<?php

namespace Seracademico\Entities;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

class Bairro extends Model implements Transformable
{
    use TransformableTrait;

    protected $table    = 'gen_bairros';

    protected $fillable = [ 
		'nome',
		'cidades_id',
	];

    public function enderecos()
    {
        return $this->hasMany(EnderecoCGM::class, "bairro_id");
    }

    public function cidade()
    {
        return $this->belongsTo(Cidade::class, "cidades_id");
    }

    /**
     * @param $query
     * @param $value
     * @return mixed
     */
    public function scopeByBairroLocal($query, $value)
    {
        return $query->select('gen_bairros.nome', 'gen_bairros.id')
            ->where('cidades_id', $value);
    }
}