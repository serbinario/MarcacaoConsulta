<?php

namespace Seracademico\Entities;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

class PostoSaude extends Model implements Transformable
{
    use TransformableTrait;

    protected $table    = 'age_posto_saude';

    protected $fillable = [ 
		'nome',
        'cnes',
        'endereco',
        'numero',
        'bairro_id',
	];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function fila()
    {
        return $this->hasMany(Fila::class, 'posto_saude_id', 'id');
    }
}