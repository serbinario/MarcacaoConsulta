<?php

namespace Seracademico\Entities;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

class Especialista extends Model implements Transformable
{
    use TransformableTrait;

    protected $table    = 'age_especialista';

    protected $fillable = [
		'cgm',
		'qtd_vagas',
		'crm',
	];

	public function getCgm()
	{
		return $this->belongsTo(CGM::class, 'cgm');
	}

	/**
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
	 */
	public function especialistaEspecialidade()
	{
		return $this->belongsToMany(Especialidade::class, 'age_especialista_especialidade', 'especialista_id', "especialidade_id");
	}

	/**
	 * @return \Illuminate\Database\Eloquent\Relations\HasMany
	 *
	 */
	public function calendario()
	{
		return $this->hasMany(Calendario::class, 'especialista_id', 'id');
	}
}