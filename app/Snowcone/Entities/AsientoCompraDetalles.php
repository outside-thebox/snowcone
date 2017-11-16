<?php
/**
 * Created by PhpStorm.
 * User: lucas.sisi
 * Date: 16/11/2017
 * Time: 14:48
 */

namespace App\Snowcone\Entities;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use OwenIt\Auditing\AuditingTrait;


class AsientoCompraDetalles extends Model
{

    use Notifiable;
    use SoftDeletes;
    use AuditingTrait;

    protected $table = 'asiento_compra_detalles';
    protected $fillable = ['id','asiento_compra_id','articulo_id','cantidad','created_at','updated_at'];
}