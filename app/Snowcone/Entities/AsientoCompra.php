<?php
/**
 * Created by PhpStorm.
 * User: lucas.sisi
 * Date: 15/11/2017
 * Time: 15:56
 */

namespace App\Snowcone\Entities;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use OwenIt\Auditing\AuditingTrait;

class AsientoCompra extends Model
{
    use Notifiable;
    use SoftDeletes;
    use AuditingTrait;

    protected $table = 'asiento_compras';
    protected $fillable = ['id','proveedor_id','sucursal_id','nro_factura','user_id','created_at','updated_at'];

    public function proveedor()
    {
        return $this->hasOne('App\Snowcone\Entities\Proveedor','id','proveedor_id');
    }

    public function sucursal()
    {
        return $this->hasOne('App\Snowcone\Entities\Sucursales','id','sucursal_id');
    }

}