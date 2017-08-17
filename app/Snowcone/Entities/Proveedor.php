<?php
/**
 * Created by PhpStorm.
 * User: damian
 * Date: 03/07/17
 * Time: 09:49
 */

namespace App\Snowcone\Entities;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use OwenIt\Auditing\AuditingTrait;


Class Proveedor extends Model{

    use Notifiable;
    use SoftDeletes;
    use AuditingTrait;
    protected $table = 'proveedores';
    protected $fillable = ['descripcion','deleted_at','created_at','updated_at'];


    public function articulos()
    {
        return $this->hasMany('App\Snowcone\Entities\Articulo','proveedor_id','id');
    }



}