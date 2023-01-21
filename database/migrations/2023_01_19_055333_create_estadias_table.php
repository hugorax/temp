<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEstadiasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('estadias', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('vehiculo_id')->unsigned()->index();
            $table->datetime('ingreso');
            $table->datetime('egreso')->nullable();
            $table->double('valorEstadia', 8, 2)->nullable();
            $table->string('observacion')->nullable();
            $table->boolean('esActivo')->default(true);
            $table->boolean('finalizado')->default(false);
            $table->bigInteger('user_created')->unsigned()->index();
            $table->bigInteger('user_updated')->unsigned()->index();
            $table->foreign('vehiculo_id')->references('id')->on('vehiculos');
            $table->foreign('user_updated')->references('id')->on('users');
            $table->timestamps();
            $table->engine = "InnoDB";
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('estadias');
    }
}
