<?php
/**
 * Created by PhpStorm.
 * User: damian
 * Date: 03/05/17
 * Time: 11:16
 */
namespace App\Snowcone\Entities;


use Illuminate\Database\Eloquent\Model;

class TipoUsuario extends Model {

    protected $table = 'tipos_usuarios';
    protected $fillable = ['descripcion'];
}