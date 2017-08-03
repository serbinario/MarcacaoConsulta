<?php

namespace Seracademico\Entities;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

class Mapa extends Model implements Transformable
{
    use TransformableTrait;

    protected $table    = 'age_mapas';

    protected $fillable = [ 
		'horario',
		'especialidade_id',
		'calendario_id',
		'vagas',
		'reservas',
	];

	/**
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function especialidadeMapa()
	{
		return $this->belongsTo(EspecialistaEspecialidade::class, 'especialidade_id');
	}

	/**
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function calendario()
	{
		return $this->belongsTo(Calendario::class, 'calendario_id');
	}

}