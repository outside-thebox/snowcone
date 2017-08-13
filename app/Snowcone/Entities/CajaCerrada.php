<?php
/**
 * Created by PhpStorm.
 * User: damian
 * Date: 12/08/17
 * Time: 20:05
 */
namespace App\Snowcone\Entities;


use Illuminate\Database\Eloquent\Model;

class CajaCerrada extends Model {

    protected $table = 'cajas_cerradas';
    protected $fillable = ['sucursal_id','user_id','fecha','created_at','updated_at','deleted_at'];



}