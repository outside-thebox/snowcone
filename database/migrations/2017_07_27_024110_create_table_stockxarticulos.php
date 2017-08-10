<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableStockxarticulos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stockxarticulos', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('articulo_id')->unsigned();
            $table->integer('sucursal_id')->unsigned();
            $table->integer('stock');
            $table->integer('precio_compra');
            $table->integer('precio_sugerido');
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
        Schema::dropIfExists('stockxarticulos');
    }
}
