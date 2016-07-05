<?php

namespace Seracademico\Entities;

use Bican\Roles\Contracts\RoleHasRelations;
use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;
use Bican\Roles\Traits\RoleHasRelations as TraintRoleHasRelations;

class Role extends Model implements Transformable, RoleHasRelations
{
    use TransformableTrait, TraintRoleHasRelations;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'level'
    ];

    public function permissions()
    {
        return $this->belongsToMany(Permission ::class);
    }
}
