<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('horas_contrato_x_ticket', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('ticket_id');
            $table->integer('contrato_id');
            $table->integer('organizacion_id');
            $table->decimal('horas_ocupadas');
            $table->date('created_at_ticket');
            $table->date('updated_at_ticket');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('horas_contrato_x_ticket');
    }
};
