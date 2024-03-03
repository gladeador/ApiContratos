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
        Schema::create('contratos', function (Blueprint $table) {
            // Identificador único del contrato
            $table->increments('id');

            // Identificador de la organización relacionada
            $table->unsignedBigInteger('organizacion_id')->unique();

            // Aqquí se indica si se lleva por contrato o por servicio
            $table->boolean('contrato_o_servicio')->default(false);

            // Fecha de inicio y fin del contrato
            $table->date('fecha_inicio')->nullable();
            $table->date('fecha_fin')->nullable();

            // Descripción del contrato (puede ser nula)
            $table->text('descripcion')->nullable();

            // Tipo de Contrato (mensuales, anuales, temporales)
            $table->enum('tipo_contrato', ['mensuales', 'anuales', 'spot']);

            // Horas del contrato que se dividira en todos los servicios(inicializado a 0)
            $table->decimal('horas_contrato', 12, 2)->default(0);

            // Horas adicionales del contrato que se dividira en todos los servicios(inicializado a 0)
            $table->decimal('horas_adicionales', 12, 2)->default(0);

            // Indica las horas ocupadas del contrato
            $table->decimal('horas_ocupadas', 12, 2)->default(0);

            // Texto del contrato (puede ser nulo)
            $table->text('contrato_texto')->nullable();

            // Ruta del archivo PDF del contrato (puede ser nulo)
            $table->string('pdf_path')->nullable();

            // Indica si el contrato tiene renovación automática al terminar las horas
            $table->boolean('renovacion_automatica')->default(false);

            // Identificador del ejecutivo comercial
            $table->unsignedBigInteger('ejecutivo_id');

            // Estado del contrato (Activo, Inactivo, Terminado por defecto: Activo)
            $table->enum('estado_contrato', ['Activo', 'Inactivo'])->default('Activo');

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
