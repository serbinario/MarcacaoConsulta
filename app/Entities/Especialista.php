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
		'especialidade',
		'cgm',
		'qtd_vagas',
		'crm',
	];

	public function getCgm()
	{
		return $this->belongsTo(CGM::class, 'cgm');
	}

	public function getEspecialidade()
	{
		return $this->belongsTo(Especialidade::class, 'especialidade');
	}
}