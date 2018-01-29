<?php
/**
 * Created by PhpStorm.
 * User: lucas.sisi
 * Date: 8/8/2017
 * Time: 11:39
 */

namespace App\Snowcone\Entities;

use Carbon\Carbon;
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
        return $this->hasOne('App\Snowcone\Entities\Sucursales','id','sucursal_id');
    }

    public function proveedor()
    {
        return $this->hasOne('App\Snowcone\Entities\Proveedor','id','proveedor_id');
    }

    public function user()
    {
        return $this->hasOne('App\User','id','user_id')->withTrashed();
    }

    public function getCreatedAtAttribute()
    {
        return Carbon::parse($this->attributes['created_at'])->format('d/m/Y H:i:s');
    }


    public function getPrecioCompraAttribute()
    {
        return str_replace(".",",",$this->attributes['precio_compra']);
    }

    public function setPrecioCompraAttribute($value)
    {
        $this->attributes['precio_compra'] = floatval(str_replace(",",".",$value));
    }
}