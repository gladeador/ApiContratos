<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMenuTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('menu', function (Blueprint $table) {
            $table->increments('id');
            $table->string('descripcion', 100)->unique();
            $table->integer('orden')->nullable();
            $table->string('icono', 100)->nullable();
            $table->integer('hijo')->nullable();
            $table->string('ruta', 100)->nullable();
            $table->integer('estado')->default(1);
            $table->longtext('observaciones')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('menu');
    }
}