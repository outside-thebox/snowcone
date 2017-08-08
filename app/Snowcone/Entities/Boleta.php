<?php
/**
 * Created by PhpStorm.
 * User: lucas.sisi
 * Date: 8/8/2017
 * Time: 11:39
 */

namespace App\Snowcone\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use OwenIt\Auditing\AuditingTrait;

class Boleta extends Model
{
    use Notifiable;
    use SoftDeletes;
    use AuditingTrait;

    protected $table = 'boletas';
    protected $fillable = ['nro_factura','proveedor_id', 'articulo_id', 'sucursal_id', 'cantidad', 'precio_compra', 'user_id', 'deleted_at', 'created_at', 'updated_at'];

    public function articulo()
    {
        return $this->hasOne('App\Snowcone\Entities\Articulo','id','articulo_id');
    }

    public function sucursal()
    {
        return $this->hasOne('App\Snowcone\Entities\Sucursal','id','sucursal_id');
    }

    public function proveedor()
    {
        return $this->hasOne('App\Snowcone\Entities\Proveedor','id','proveedor_id');
    }
}