<?php
/**
 * Created by PhpStorm.
 * User: damian
 * Date: 26/05/17
 * Time: 00:01
 */


namespace App\Snowcone\Entities;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use OwenIt\Auditing\AuditingTrait;


Class UnidadMedida extends Model{

    use Notifiable;
    use SoftDeletes;
    use AuditingTrait;
    protected $table = 'unidades_medida';
    protected $fillable = ['descripcion','deleted_at','created_at','updated_at'];

}