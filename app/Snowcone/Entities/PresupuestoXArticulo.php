<?php
/**
 * Created by PhpStorm.
 * User: damian
 * Date: 06/08/17
 * Time: 20:32
 */

namespace App\Snowcone\Entities;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use OwenIt\Auditing\AuditingTrait;


Class PresupuestoXArticulo extends Model{

    use Notifiable;
    use SoftDeletes;
    use AuditingTrait;
    protected $table = 'presupuestosxarticulos';
    protected $fillable = ['presupuesto_id','articulo_id','cantidad','precio_unitario','subtotal','deleted_at','created_at','updated_at'];

}