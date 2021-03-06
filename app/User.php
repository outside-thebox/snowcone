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
    use AuditingTrait;

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

    public function tipo_usuario()
    {
        return $this->hasOne('App\Snowcone\Entities\TipoUsuario','id','tipo_usuario_id');
    }
}
