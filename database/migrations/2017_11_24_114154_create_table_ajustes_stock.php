<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableAjustesStock extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ajustes_stock', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('sucursal_id')->unsigned();
            $table->integer('articulo_id')->unsigned();
            $table->integer('cod');
            $table->string('descripcion',250);
            $table->decimal('precio_compra_anterior',10,2);
            $table->decimal('precio_compra_nuevo',10,2);
            $table->decimal('precio_sugerido_anterior',10,2);
            $table->decimal('precio_sugerido_nuevo',10,2);
            $table->integer('stock_anterior')->unsigned();
            $table->integer('stock_nuevo')->unsigned();
            $table->integer('user_id')->unsigned();
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
        Schema::dropIfExists('ajustes_stock');
    }
}
