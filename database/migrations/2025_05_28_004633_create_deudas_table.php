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
        Schema::create('deudas', function (Blueprint $table) {
            $table->increments('id_deuda');

            $table->unsignedInteger('id_alumno');

            $table->unsignedInteger('id_concepto');

            $table->date('fecha_limite')->nullable(); 

            $table->integer('monto_total');

            $table->string('periodo', 25)->nullable();

            $table->integer('monto_a_cuenta')->default(0); 

            $table->integer('monto_adelantado')->default(0); 

            $table->text('observacion')->nullable();
   
            $table->boolean('estado')->default(true); 

            $table->foreign('id_alumno')
                  ->references('id_alumno')
                  ->on('alumnos')
                  ->onDelete('cascade'); 

            $table->foreign('id_concepto')
                  ->references('id_concepto')
                  ->on('conceptos_pago')
                  ->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('deudas');
    }
};
