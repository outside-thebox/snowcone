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
<<<<<<< HEAD
=======
use OwenIt\Auditing\AuditingTrait;
>>>>>>> e52a4323afbe6d72c0b93368b69650dfb618b2af


Class Sucursales extends Model{

    use Notifiable;
    use SoftDeletes;
<<<<<<< HEAD
=======
    use AuditingTrait;
>>>>>>> e52a4323afbe6d72c0b93368b69650dfb618b2af
    protected $table = 'sucursales';
    protected $fillable = ['nombre','direccion','telefono','email','deleted_at','created_at','updated_at'];

}

