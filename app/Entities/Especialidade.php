<?php

namespace Seracademico\Entities;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

class Especialidade extends Model implements Transformable
{
    use TransformableTrait;

    protected $table = 'age_especialidade';

    protected $fillable = [
        'operacao_id',
        'preparo'
	];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function operacao()
    {
        return $this->belongsTo(Operacoe::class, "operacao_id");
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function fila()
    {
        return $this->hasMany(Fila::class, 'especialidade_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function especialistaEspecialidade()
    {
        return $this->belongsToMany(Especialista::class, 'age_especialista_especialidade', 'especialidade_id', "especialista_id");
    }
}