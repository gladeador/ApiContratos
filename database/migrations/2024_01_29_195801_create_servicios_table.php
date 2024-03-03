<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('servicios', function (Blueprint $table) {
            // Identificador único del servicio
            $table->increments('id');

            // identificador del servicio
            $table->string('servicio_tree_select')->nullable();

            // Fecha de inicio y fin del contrato
            $table->date('fecha_inicio');
            $table->date('fecha_fin');

            // Tipo de horas a consumir (mensuales, anuales, temporales)
            $table->enum('tipo_servicio', ['mensual', 'anual', 'spot']);

            // Horas del servicio y horas adicionales (inicializado a 0)
            $table->decimal('horas_servicio', 12, 2);
            $table->decimal('horas_adicionales', 12, 2)->default(0);

            // Indica las horas ocupadas del servicio
            $table->decimal('horas_ocupadas', 12, 2)->default(0);

            // Texto del contrato (puede ser nulo)
            $table->text('servicio_texto')->nullable();

            // Ruta del archivo PDF del contrato (puede ser nulo)
            $table->string('pdf_path')->nullable();
            
            // Indica si el contrato tiene renovación automática al terminar las horas
            $table->boolean('renovacion_automatica')->default(false);

            // Estado del servicio (Activo, Inactivo, Terminado por defecto: Activo)
            $table->enum('estado_servicio', ['Activo', 'Inactivo', 'Terminado'])->default('Activo');

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
