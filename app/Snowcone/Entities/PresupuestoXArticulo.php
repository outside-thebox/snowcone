<?php
/**
 * Created by PhpStorm.
 * User: damian
 * Date: 06/08/17
 * Time: 20:32
 */

namespace App\Snowcone\Entities;
use Carbon\Carbon;
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


    public function articulo()
    {
        return $this->belongsTo('App\Snowcone\Entities\Articulo','articulo_id','id')->withTrashed();
    }

    public function presupuesto()
    {
        return $this->hasOne('App\Snowcone\Entities\Presupuesto','id','presupuesto_id');
    }

    public function getCreatedAtAttribute()
    {
        return Carbon::parse($this->attributes['created_at'])->format('d/m/Y H:i:s');
    }

    public function getPrecioUnitarioAttribute()
    {
        return str_replace(".",",",$this->attributes['precio_unitario']);
    }

    public function setPrecioUnitarioAttribute($value)
    {
        $this->attributes['precio_unitario'] = floatval(str_replace(",",".",$value));
    }

    public function getSubtotalAttribute()
    {
        return str_replace(".",",",$this->attributes['subtotal']);
    }

    public function setSubtotalAttribute($value)
    {
        $this->attributes['subtotal'] = floatval(str_replace(",",".",$value));
    }
}