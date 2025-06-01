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
        Schema::create('registros_historicos', function (Blueprint $table) {
            $table->increments('id_registro_historico');

            // id_concepto_accion INT FK
            $table->unsignedInteger('id_concepto_accion'); // Se mantiene unsignedInteger porque no es un ID estándar de Laravel por defecto

            // fecha_accion DATETIME
            $table->dateTime('fecha_accion');

            // observacion TEXT
            $table->text('observacion')->nullable();

            // estado TINYINT
            $table->boolean('estado')->default(true);

            // Clave foránea para id_usuario_autor (renombrado a id_autor en la migración por tu request)
            // Esto asume que la PK en 'users' se llama 'id_usuario'.
            // Laravel automáticamente usará 'unsignedBigInteger' para 'id_autor' si tu tabla 'users' usa $table->id().
            // Si 'users' usa 'increments()', ambas deben ser 'unsignedInteger'.
            // Si tu 'id_usuario' en 'users' es BIGINT, entonces 'id_autor' también lo será con foreignId().
            $table->foreignId('id_autor')
                  ->constrained('users', 'id_usuario') // 'users' es el nombre de la tabla, 'id_usuario' es la PK.
                  ->onDelete('cascade'); // Si el usuario autor se elimina, se borran sus registros.

            // Clave foránea para id_concepto_accion
            $table->foreign('id_concepto_accion') // Se usa foreign() aquí porque no es una convención de Laravel 'tabla_id'
                  ->references('id_concepto_accion') // La PK en 'concepto_accion'.
                  ->on('concepto_accion') // Nombre de la tabla referenciada.
                  ->onDelete('restrict'); // Si un concepto se elimina, no se borra el registro.

            // Clave foránea para id_usuario_afectado (renombrado a id_uafectado en la migración por tu request)
            // Asume que la PK en 'users' se llama 'id_usuario'.
            $table->foreignId('id_usuario_afectado')
                  ->constrained('users', 'id_usuario') // 'users' es el nombre de la tabla, 'id_usuario' es la PK.
                  ->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('registros_historicos');
    }
};
