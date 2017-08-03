<?php

namespace Seracademico\Entities;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

class GrupoOperacao extends Model implements Transformable
{
    use TransformableTrait;

    protected $table    = 'age_grupo_operacoes';

    protected $fillable = [
		'nome',
        'tipo_operacao_id',
	];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     * 
     */
    public function tipo()
    {
        return $this->belongsTo(TipoOperacao::class, "tipo_operacao_id");
    }
}