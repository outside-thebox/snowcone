<?php
/**
 * Created by PhpStorm.
 * User: lucas.sisi
 * Date: 15/11/2017
 * Time: 15:56
 */

namespace App\Snowcone\Entities;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use OwenIt\Auditing\AuditingTrait;

class AsientoCompra extends Model
{
    use Notifiable;
    use SoftDeletes;
    use AuditingTrait;


}