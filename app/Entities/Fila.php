<?php

namespace Seracademico\Entities;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;
use Seracademico\Uteis\SerbinarioDateFormat;

class Fila extends Model implements Transformable
{
    use TransformableTrait;

    protected $table    = 'age_fila';

    protected $fillable = [ 
		'cgm_id',
		'especialidade_id',
        'data',
        'prioridade_id',
        'status',
        'posto_saude_id',
        'observacao'
	];

    /**
     * @return string
     */
    public function getDataAttribute()
    {
        return SerbinarioDateFormat::toBrazil($this->attributes['data']);
    }

    /**
     *
     * @return \DateTime
     */
    public function setDataAttribute($value)
    {
        $this->attributes['data'] = SerbinarioDateFormat::toUsa($value);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function prioridade()
    {
        return $this->belongsTo(Prioridade::class, 'prioridade_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function nunCgmLocalidade()
    {
        return $this->hasMany(NunCgmLocalidade::class, 'fila_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function cgm()
    {
        return $this->belongsTo(CGM::class, 'cgm_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function especialidade()
    {
        return $this->belongsTo(Especialidade::class, 'especialidade_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function psf()
    {
        return $this->belongsTo(PostoSaude::class, 'posto_saude_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function agendamento()
    {
        return $this->hasMany(Agendamento::class, 'fila_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function suboperacoes()
    {
        return $this->belongsToMany(SubOperacao::class, 'age_sub_operacoes_fila', 'fila_id', "sub_operacoes_id")
            ->withPivot([ 'fila_id', 'sub_operacoes_id']);
    }
}