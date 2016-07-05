<?php

namespace Seracademico\Entities;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

class Calendario extends Model implements Transformable
{
    use TransformableTrait;

    protected $table    = 'calendario';

    protected $fillable = [ 
		'data',
		'hora',
		'status',
		'qtd_vagas',
		'especialista_id',
		'localidade_id',
	];

	public function especialista()
	{
		return $this->belongsTo(Especialista::class, 'especialista_id');
	}

	public function localidade()
	{
		return $this->belongsTo(Localidade::class, 'localidade_id');
	}

	public function agendamento()
	{
		return $this->hasMany(Agendamento::class, 'calendario_id', 'id');
	}

}