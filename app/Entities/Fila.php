<?php

namespace Seracademico\Entities;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;
use Seracademico\Uteis\SerbinarioDateFormat;

class Fila extends Model implements Transformable
{
    use TransformableTrait;

    protected $table    = 'fila';

    protected $fillable = [ 
		'cgm_id',
		'especialidade_id',
        'data',
        'prioridade_id',
        'status'
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

    public function prioridade()
    {
        return $this->belongsTo(Prioridade::class, 'prioridade_id');
    }

    public function cgm()
    {
        return $this->belongsTo(CGM::class, 'cgm_id');
    }

    public function especialidade()
    {
        return $this->belongsTo(Especialidade::class, 'especialidade_id');
    }
}