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
		'status_id',
		'qtd_vagas',
		'especialista_id',
		'localidade_id',
		'mais_mapa',
		'hora2',
	];

	/**
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function especialista()
	{
		return $this->belongsTo(Especialista::class, 'especialista_id');
	}

	/**
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function localidade()
	{
		return $this->belongsTo(Localidade::class, 'localidade_id');
	}

	/**
	 * @return \Illuminate\Database\Eloquent\Relations\HasMany
	 */
	public function agendamento()
	{
		return $this->hasMany(Agendamento::class, 'calendario_id', 'id');
	}

	/**
	 * @return \Illuminate\Database\Eloquent\Relations\HasMany
	 */
	public function mapas()
	{
		return $this->hasMany(Mapa::class, 'calendario_id', 'id');
	}

}