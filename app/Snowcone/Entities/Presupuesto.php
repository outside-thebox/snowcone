<?php
/**
 * Created by PhpStorm.
 * User: damian
 * Date: 06/08/17
 * Time: 20:30
 */

namespace App\Snowcone\Entities;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use OwenIt\Auditing\AuditingTrait;


Class Presupuesto extends Model{

    use Notifiable;
    use SoftDeletes;
    use AuditingTrait;
    protected $table = 'presupuestos';
    protected $fillable = ['sucursal_id','user_id','precio_total','cliente','estado_id','deleted_at','created_at','updated_at'];


    public function getPrecioTotalAttribute()
    {
        return str_replace(".",",",$this->attributes['precio_total']);
    }

    public function setPrecioTotalAttribute($value)
    {
        $this->attributes['precio_total'] = floatval(str_replace(",",".",$value));
    }

    public function getCreatedAtAttribute()
    {
        return Carbon::parse($this->attributes['created_at'])->format('d/m/Y H:i:s');
    }
//
//    public function getCreatedAtAttribute()
//    {
//        return date_format($this->attributes['created_at'],"d/m/Y H:i:s");
//    }


    public function presupuestoxarticulo()
    {
        return $this->hasMany('App\Snowcone\Entities\PresupuestoXArticulo','presupuesto_id','id');
    }

    public function estado()
    {
        return $this->hasOne('App\Snowcone\Entities\Estado','id','estado_id');
    }

    public function user()
    {
        return $this->belongsTo('App\User')->withTrashed();
    }
}