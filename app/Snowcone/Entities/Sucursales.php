<?php
/**
 * Created by PhpStorm.
 * User: lucas
 * Date: 7/5/2017
 * Time: 11:12
 */

namespace App\Snowcone\Entities;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use OwenIt\Auditing\AuditingTrait;


Class Sucursales extends Model{

    use Notifiable;
    use SoftDeletes;
    use AuditingTrait;
    protected $table = 'sucursales';
    protected $fillable = ['nombre','direccion','telefono','email','ip','conexion','deleted_at','created_at','updated_at'];

}

