<?php

namespace Seracademico\Entities;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

class Localidade extends Model implements Transformable
{
    use TransformableTrait;

    protected $table    = 'localidade';

    protected $fillable = [ 
		'nome',
	];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function calendario()
    {
        return $this->hasMany(Calendario::class, 'localidade_id', 'id');
    }

}