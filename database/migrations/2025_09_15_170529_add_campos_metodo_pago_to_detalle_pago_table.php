<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('detalle_pago', function (Blueprint $table) {
            $table->string('metodo_pago')->nullable()->after('estado'); 
            $table->string('voucher_path')->nullable()->after('metodo_pago'); 
            $table->text('voucher_texto')->nullable()->after('voucher_path'); 
            $table->enum('estado_validacion', ['pendiente', 'revisado'])
                  ->default('pendiente')
                  ->after('voucher_texto'); 
        });
    }

    public function down(): void
    {
        Schema::table('detalle_pago', function (Blueprint $table) {
            $table->dropColumn(['metodo_pago', 'voucher_path', 'voucher_texto', 'estado_validacion']);
        });
    }
};
