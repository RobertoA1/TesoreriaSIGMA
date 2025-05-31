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
        Schema::create('detalle_pago', function (Blueprint $table) {
            $table->unsignedInteger('id_pago');

            $table->unsignedInteger('id_deuda');

            $table->primary(['id_pago', 'id_deuda']);

            $table->unsignedInteger('id_concepto');

            $table->dateTime('fecha_pago');

            $table->string('monto', 45);
            $table->string('observacion', 45)->nullable();

            $table->boolean('estado')->default(true); 
            $table->foreign('id_pago')
                  ->references('id_pago')
                  ->on('pagos')
                  ->onDelete('cascade'); 

            $table->foreign('id_deuda')
                  ->references('id_deuda')
                  ->on('deudas')
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
        Schema::dropIfExists('detalle_pago');
    }
};
