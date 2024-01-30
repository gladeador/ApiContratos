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
        Schema::create('servicios', function (Blueprint $table) {
            // Identificador único del servicio
            $table->id();
    
            // Nombre del servicio
            $table->string('nombre_servicio');
    
            // Indica si el servicio tiene renovación automática al terminar las horas
            $table->boolean('renovacion_automatica')->default(false);
    
            // Fecha de inicio y fin del servicio
            $table->date('fecha_inicio');
            $table->date('fecha_termino');
    
            // Tipo de contrato (Servicio o materia del contrato)
            $table->string('tipo_contrato');
    
            // Tipo de horas a consumir (mensuales, anuales, temporales)
            $table->enum('tipo_horas', ['mensuales', 'anuales', 'temporales']);
    
            // Horas del servicio y horas adicionales (inicializado a 0)
            $table->decimal('horas_servicio', 12, 2);
            $table->decimal('horas_adicionales', 12, 2)->default(0);
    
            // Indica si las horas mensuales son acumulables
            $table->boolean('horas_acumulables')->default(false);
    
            // Texto del contrato (puede ser nulo)
            $table->text('contrato_texto')->nullable();
    
            // Ruta del archivo PDF del contrato (puede ser nulo)
            $table->string('pdf_path')->nullable();
    
            // Clave foránea para la relación con contratos (restricción restrict)
            $table->foreignId('contrato_id')->constrained()->onUpdate('cascade')->onDelete('restrict');

            // Fecha de creación y actualización del registro
            $table->timestamps();
        });
    }
    


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('servicios');
    }
};
