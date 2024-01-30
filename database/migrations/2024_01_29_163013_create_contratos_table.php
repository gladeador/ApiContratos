<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('contratos', function (Blueprint $table) {
            // Identificador único del contrato
            $table->id();
    
            // Identificador de la organización relacionada
            $table->unsignedBigInteger('organizacion_id');
    
            // Fecha de inicio y fin del contrato
            $table->date('fecha_inicio');
            $table->date('fecha_fin');
    
            // Descripción del contrato (puede ser nula)
            $table->text('descripcion')->nullable();
    
            // Horas del servicio (inicializado a 0) y monto del contrato
            $table->decimal('horas_servicio', 12, 2)->default(0);
            $table->decimal('monto_contrato', 12, 2);
    
            // Identificador del ejecutivo comercial
            $table->unsignedBigInteger('ejecutivo_id');
    
            // Estado del contrato (Activo, Inactivo, Terminado por defecto: Activo)
            $table->enum('estado_contrato', ['Activo', 'Inactivo', 'Terminado'])->default('Activo');
    
            // Fecha de creación y actualización del registro
            $table->timestamps();
    
           
        });
    }
    

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contratos');
    }
};
