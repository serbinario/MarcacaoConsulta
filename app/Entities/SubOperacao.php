<?php

namespace Seracademico\Entities;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

class SubOperacao extends Model implements Transformable
{
    use TransformableTrait;

    protected $table    = 'sub_operacoes';

    protected $fillable = [ 
		'nome',
        'operacao_id'
	];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function operacao()
    {
        return $this->belongsTo(Operacoe::class, 'operacao_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function agendamento()
    {
        return $this->hasMany(Agendamento::class, 'sub_operacao_id', 'id');
    }
}