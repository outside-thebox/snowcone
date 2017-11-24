<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAsientosCompraDetallesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('asiento_compra_detalles', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('asiento_compra_id')->unsigned();
            $table->integer('articulo_id')->unsigned();
            $table->integer('cod');
            $table->string('descripcion',250);
            $table->integer('cantidad');
            $table->decimal('precio',10,2);

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
        Schema::dropIfExists('asiento_compra_detalles');
    }
}
