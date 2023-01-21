<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVehiculosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vehiculos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('tipocliente_id')->unsigned()->index();
            $table->string('placa');
            $table->string('conductor')->nullable();
            $table->boolean('esActivo')->default(true);
            $table->foreign('tipocliente_id')->references('id')->on('tipoclientes');
            $table->bigInteger('user_created')->unsigned()->index();
            $table->bigInteger('user_updated')->unsigned()->index();
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
        Schema::dropIfExists('vehiculos');
    }
}
