<?php
/**
 * Created by PhpStorm.
 * User: damian
 * Date: 24/11/17
 * Time: 11:46
 */

namespace App\Snowcone\Entities;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use OwenIt\Auditing\AuditingTrait;


Class AjusteStock extends Model{

    use Notifiable;
    use SoftDeletes;
    use AuditingTrait;
    protected $table = 'ajustes_stock';
    protected $fillable = ['sucursal_id','articulo_id','cod','descripcion','precio_compra_anterior','precio_compra_nuevo','precio_sugerido_anterior','precio_sugerido_nuevo','stock_anterior','stock_nuevo','user_id','deleted_at','created_at','updated_at'];

    public function sucursal()
    {
        return $this->hasOne('App\Snowcone\Entities\Sucursales','id','sucursal_id');
    }

    public function user()
    {
        return $this->belongsTo('App\User')->withTrashed();
    }

    public function getCreatedAtAttribute()
    {
        return Carbon::parse($this->attributes['created_at'])->format('d/m/Y H:i:s');
    }



}
