<?php

namespace Seracademico\Entities;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

class EspecialistaEspecialidade extends Model implements Transformable
{
    use TransformableTrait;

    protected $table    = 'especialista_especialidade';

    protected $fillable = [ 
		'especialista_id',
		'especialidade_id',
	];

    public function calendarioUm()
    {
        return $this->hasMany(Calendario::class, "especialidade_id_um");
    }

    public function calendarioDois()
    {
        return $this->hasMany(Calendario::class, "especialidade_id_dois");
    }

    public function especialista()
    {
        return $this->belongsTo(Especialista::class, "especialista_id");
    }

    public function especialidade()
    {
        return $this->belongsTo(Especialidade::class, "especialidade_id");
    }
}