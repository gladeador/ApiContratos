<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('tipo_documento', 20)->nullable();
            $table->string('num_documento', 20)->unique();
            $table->string('direccion', 70)->nullable();
            $table->string('telefono', 40)->nullable();
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('imagen')->nullable();
            $table->integer('estado')->default('1');
            $table->string('password');
            $table->integer('profile_id')->unsigned()->default(2);
            $table->foreign('profile_id')->references('id')->on('profiles')->onDelete('restrict');
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}