<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTablePresupuestosxarticulos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('presupuestosxarticulos', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('presupuesto_id')->unsigned();
            $table->integer('articulo_id')->unsigned();
            $table->integer('cantidad')->unsigned();
            $table->double('precio_unitario');
            $table->double('subtotal');
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
        Schema::dropIfExists('presupuestosxarticulos');
    }
}
