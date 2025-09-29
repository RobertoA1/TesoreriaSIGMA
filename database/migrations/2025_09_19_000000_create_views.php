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
        DB::unprepared('
            CREATE VIEW stats_alumnosMatriculadosTodosLosGradosEnAñosEscolares AS
                SELECT
                    m.año_escolar AS "Año Escolar",
                    ne.nombre_nivel AS "Nivel Educativo",
                    gr.nombre_grado AS "Grado",
                    COUNT(*) AS "Cantidad"
                FROM matriculas AS m
                JOIN grados AS gr ON m.id_grado = gr.id_grado
                JOIN niveles_educativos AS ne ON ne.id_nivel = gr.id_nivel
                GROUP BY m.año_escolar, gr.id_nivel, gr.id_grado
                ORDER BY m.año_escolar ASC, gr.id_nivel ASC, gr.id_grado ASC;
        ');

        DB::unprepared('
            CREATE VIEW stats_alumnosMatriculadosPorNivelesEducativosEnAñosEscolares AS
                SELECT
                    m.año_escolar AS "Año Escolar",
                    ne.nombre_nivel AS "Nivel Educativo",
                    COUNT(*) AS "Cantidad"
                FROM matriculas AS m
                JOIN grados AS gr ON m.id_grado = gr.id_grado
                JOIN niveles_educativos AS ne ON ne.id_nivel = gr.id_nivel
                GROUP BY m.año_escolar, gr.id_nivel
                ORDER BY m.año_escolar ASC, gr.id_nivel ASC;
        ');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::unprepared('DROP VIEW stats_alumnosMatriculadosTodosLosGradosEnAñosEscolares');
        DB::unprepared('DROP VIEW stats_alumnosMatriculadosPorNivelesEducativosEnAñosEscolares');
    }
};
