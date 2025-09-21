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
            CREATE PROCEDURE IF NOT EXISTS alumnosPorSexo(IN añoBuscado INT, IN idGradoBuscado INT)
            BEGIN
                SELECT a.sexo as "Sexo", COUNT(*) AS "Cantidad" FROM matriculas AS m
                LEFT JOIN alumnos AS a ON m.id_alumno = a.id_alumno
                WHERE m.estado=1
                    AND m.id_grado=idGradoBuscado
                    AND m.año_escolar=añoBuscado
                GROUP BY a.sexo;
            END
        ');

        DB::unprepared('
            CREATE PROCEDURE IF NOT EXISTS alumnosRetirados(IN añoEscolarBase INT, IN añoEscolarSiguiente INT)
            BEGIN
            SELECT COUNT(*) AS "retirados" FROM matriculas
                WHERE año_escolar = añoEscolarBase AND id_alumno NOT IN (SELECT id_alumno FROM MATRICULAS WHERE año_escolar = añoEscolarSiguiente);
            END
        ');

        DB::unprepared('
            CREATE PROCEDURE IF NOT EXISTS obtenerRangoEdadesEnUnGrado(IN idGrado INT)
            BEGIN
                SELECT 
                    TIMESTAMPDIFF(YEAR, a.fecha_nacimiento, CURDATE()) AS Edad,
                    COUNT(*) AS Cantidad
                FROM matriculas AS m
                JOIN alumnos AS a ON m.id_alumno = a.id_alumno
                WHERE m.id_grado = idGrado
                GROUP BY Edad
                ORDER BY Edad ASC;
            END
        ');

        DB::unprepared('
            CREATE PROCEDURE IF NOT EXISTS stats_alumnosMatriculadosEnAñoEspecifico(IN añoBuscado INT)
            BEGIN
                SELECT
                    m.año_escolar AS "Año Escolar",
                    ne.nombre_nivel AS "Nivel Educativo",
                    COUNT(*) AS "Cantidad"
                FROM matriculas AS m
                JOIN grados AS gr ON m.id_grado = gr.id_grado
                JOIN niveles_educativos AS ne ON ne.id_nivel = gr.id_nivel
                WHERE m.año_escolar = añoBuscado
                GROUP BY m.año_escolar, gr.id_nivel
                ORDER BY m.año_escolar ASC, gr.id_nivel ASC;
            END
        ');

        DB::unprepared('
            CREATE PROCEDURE IF NOT EXISTS stats_alumnosMatriculadosEnNivelEducativoEspecifico(IN añoBuscado INT, IN nivelBuscado VARCHAR(50))
            BEGIN
                SELECT
                    m.año_escolar AS "Año Escolar",
                    ne.nombre_nivel AS "Nivel Educativo",
                    gr.nombre_grado AS "Grado",
                    m.nombreSeccion AS "Sección",
                    COUNT(*) AS "Cantidad"
                FROM matriculas AS m
                JOIN grados AS gr ON m.id_grado = gr.id_grado
                JOIN niveles_educativos AS ne ON ne.id_nivel = gr.id_nivel
                WHERE m.año_escolar = añoBuscado AND ne.nombre_nivel = nivelBuscado
                GROUP BY m.año_escolar, ne.nombre_nivel, gr.nombre_grado, m.nombreSeccion;
            END
        ');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::unprepared('DROP PROCEDURE IF EXISTS alumnosPorSexo');
        DB::unprepared('DROP PROCEDURE IF EXISTS alumnosRetirados');
        DB::unprepared('DROP PROCEDURE IF EXISTS obtenerRangoEdadesEnUnGrado');
        DB::unprepared('DROP PROCEDURE IF EXISTS stats_alumnosMatriculadosEnAñoEspecifico');
        DB::unprepared('DROP PROCEDURE IF EXISTS stats_alumnosMatriculadosEnNivelEducativoEspecifico');
    }
};
