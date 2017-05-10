<?php

namespace App;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use OwenIt\Auditing\AuditingTrait;

class User extends Authenticatable
{
    use Notifiable;
    use SoftDeletes;
<<<<<<< HEAD
=======
    use AuditingTrait;
>>>>>>> e52a4323afbe6d72c0b93368b69650dfb618b2af

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nombre', 'apellido','dni', 'password','telefono','tipo_usuario_id','deleted_at','created_at','updated_at'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
}
