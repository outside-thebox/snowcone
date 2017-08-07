<?php
/**
 * Created by PhpStorm.
 * User: damian
 * Date: 06/08/17
 * Time: 20:30
 */

namespace App\Snowcone\Entities;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use OwenIt\Auditing\AuditingTrait;


Class Presupuesto extends Model{

    use Notifiable;
    use SoftDeletes;
    use AuditingTrait;
    protected $table = 'presupuestos';
    protected $fillable = ['sucursal_id','user_id','precio_total','cliente','deleted_at','created_at','updated_at'];

}