<?php
/**
 * Created by PhpStorm.
 * User: lucas
 * Date: 7/5/2017
 * Time: 11:12
 */

namespace App\Snowcone\Entities;
use Illuminate\Database\Eloquent\Model;


Class Sucursales extends Model{

    protected $table = 'sucursales';
    protected $fillable = ['nombre','direccion','telefono','email'];

}

