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

            $table->increments('id_detalle');

            $table->unsignedInteger('id_pago');

            $table->primary(['id_detalle', 'id_pago']);

            $table->dateTime('fecha_pago');

            $table->string('monto', 45);
            $table->text('observacion')->nullable();

            $table->foreign('id_pago')
                  ->references('id_pago')
                  ->on('pagos')
                  ->onDelete('cascade'); 

            $table->boolean("estado")->default(true);
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
