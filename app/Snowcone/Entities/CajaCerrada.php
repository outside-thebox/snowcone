<?php
/**
 * Created by PhpStorm.
 * User: damian
 * Date: 12/08/17
 * Time: 20:05
 */
namespace App\Snowcone\Entities;


use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use OwenIt\Auditing\AuditingTrait;

class CajaCerrada extends Model {

    use Notifiable;
    use SoftDeletes;
    use AuditingTrait;

    protected $table = 'cajas_cerradas';
    protected $fillable = ['sucursal_id','user_id','fecha','created_at','updated_at','deleted_at'];


    public function user()
    {
        return $this->hasOne('App\User','id','user_id');
    }

    public function getFechaAttribute()
    {
        return Carbon::parse($this->attribute['fecha'])->format('d/m/Y');
    }

    public function presupuesto()
    {
        return $this->hasMany('App\Snowcone\Entities\Presupuesto','caja_cerrada','id');
    }



}