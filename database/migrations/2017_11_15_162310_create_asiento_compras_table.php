<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAsientoComprasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('asiento_compras', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('nro_factura')->unsigned();
            $table->integer('proveedor_id')->unsigned();
            $table->integer('articulo_id')->unsigned();
            $table->integer('sucursal_id')->unsigned();
            $table->integer('cantidad_anterior');
            $table->integer('cantidad_ingresada');
            $table->decimal('precio_compra',10,2);
            $table->integer('user_id');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
