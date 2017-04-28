<?php

namespace Seracademico\Entities;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

class Agendamento extends Model implements Transformable
{
    use TransformableTrait;

    protected $table    = 'agendamento';

    protected $fillable = [ 
		'status',
		'obs',
		'posto_saude_id',
		'calendario_id',
		'fila_id',
		'hora',
	];

	public function fila()
	{
		return $this->belongsTo(Fila::class, 'fila_id');
	}

	public function psf()
	{
		return $this->belongsTo(PostoSaude::class, 'posto_saude_id');
	}

	public function calendario()
	{
		return $this->belongsTo(Calendario::class, 'calendario_id');
	}

	public function evento()
	{
		return $this->hasMany(Evento::class, 'agendamento_id', 'id');
	}

}