<?php

namespace Seracademico\Entities;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

class Especialista extends Model implements Transformable
{
    use TransformableTrait;

    protected $table    = 'especialista';

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
		return $this->belongsToMany(Especialidade::class, 'especialista_especialidade', 'especialista_id', "especialidade_id");
	}
}