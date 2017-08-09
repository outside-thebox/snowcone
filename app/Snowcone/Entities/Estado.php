<?php
/**
 * Created by PhpStorm.
 * User: damian
 * Date: 09/08/17
 * Time: 18:36
 */
namespace App\Snowcone\Entities;


use Illuminate\Database\Eloquent\Model;

class Estado extends Model {

    protected $table = 'estados';
    protected $fillable = ['descripcion'];
}