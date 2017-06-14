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
		'agendamento_id',
		'status_agendamento_id',
		'data',
		'mapa_id'
	];

	/**
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function fila()
	{
		return $this->belongsTo(Fila::class, 'fila_id');
	}

	/**
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function psf()
	{
		return $this->belongsTo(PostoSaude::class, 'posto_saude_id');
	}

	/**
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function calendario()
	{
		return $this->belongsTo(Calendario::class, 'calendario_id');
	}

	/**
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function mapa()
	{
		return $this->belongsTo(Mapa::class, 'mapa_id');
	}

	/**
	 * @return \Illuminate\Database\Eloquent\Relations\HasMany
	 */
	public function evento()
	{
		return $this->hasMany(Evento::class, 'agendamento_id', 'id');
	}

}