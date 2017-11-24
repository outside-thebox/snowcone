<?php
/**
 * Created by PhpStorm.
 * User: damian
 * Date: 26/07/17
 * Time: 23:46
 */

namespace App\Snowcone\Entities;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use OwenIt\Auditing\AuditingTrait;


Class StockXArticulo extends Model{

    use Notifiable;
    use SoftDeletes;
    use AuditingTrait;
    protected $table = 'stockxarticulos';
    protected $fillable = ['id','articulo_id','sucursal_id','stock','precio_compra','precio_sugerido','deleted_at','created_at','updated_at'];

    public function articulo()
    {
        return $this->hasOne('App\Snowcone\Entities\Articulo','id','articulo_id');
    }

    public function sucursal()
    {
        return $this->hasOne('App\Snowcone\Entities\Sucursal','id','sucursal_id');
    }

    public function getPrecioCompraAttribute()
    {
        return str_replace(".",",",$this->attributes['precio_compra']);
    }

    public function getPrecioSugeridoAttribute()
    {
        return str_replace(".",",",$this->attributes['precio_sugerido']);
    }

    public function setPrecioCompraAttribute($value)
    {
        $this->attributes['precio_compra'] = floatval(str_replace(",",".",$value));
    }

    public function setPrecioSugeridoAttribute($value)
    {
        $this->attributes['precio_sugerido'] = floatval(str_replace(",",".",$value));
    }

}
