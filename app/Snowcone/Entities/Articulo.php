<?php
/**
 * Created by PhpStorm.
 * User: damian
 * Date: 26/05/17
 * Time: 00:06
 */

namespace App\Snowcone\Entities;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use OwenIt\Auditing\AuditingTrait;


Class Articulo extends Model{

    use Notifiable;
    use SoftDeletes;
    use AuditingTrait;
    protected $table = 'articulos';
    protected $fillable = ['descripcion','cod','unidad_medida_id','precio_sugerido','precio_compra','fecha_ultima_compra','deleted_at','created_at','updated_at'];

    public function unidad_medida()
    {
        return $this->hasOne('App\Snowcone\Entities\UnidadMedida','id','unidad_medida_id');
    }

}
