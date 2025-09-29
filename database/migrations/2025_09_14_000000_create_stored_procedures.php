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
            CREATE PROCEDURE IF NOT EXISTS alumnosRetiradosPorAño(IN añoEscolarBase INT, IN añoEscolarSiguiente INT)
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

        DB::unprepared('
            CREATE PROCEDURE IF NOT EXISTS stats_alumnosNuevosVsAntiguosPorAño()
            BEGIN
                DECLARE añoMinimo INT;
                DECLARE añoMaximo INT;
                DECLARE i INT;
                DECLARE total INT;
                DECLARE antiguos INT;
                DECLARE nuevos INT;
                
                SELECT
                    año_escolar INTO añoMinimo
                FROM matriculas
                ORDER BY año_escolar ASC
                LIMIT 1;
                
                SELECT
                    año_escolar INTO añoMaximo
                FROM matriculas
                ORDER BY año_escolar DESC
                LIMIT 1;
                
                CREATE TEMPORARY TABLE antiguosVsNuevos (
                    año_escolar INT,
                    antiguos		INT,
                    nuevos		INT
                );
                
                SET i = añoMinimo;
                WHILE i <= añoMaximo DO
                    SELECT
                        COUNT(*) INTO total
                    FROM matriculas
                    WHERE año_escolar = i;
                                                
                    SELECT 
                        COUNT(*) INTO antiguos
                    FROM matriculas
                    WHERE año_escolar = i
                    AND id_alumno IN (
                        SELECT
                            id_alumno
                        FROM matriculas
                        WHERE año_escolar = i - 1
                    );
                    
                    INSERT INTO antiguosVsNuevos (año_escolar, antiguos, nuevos) VALUES
                    (i, IFNULL(antiguos, 0), IFNULL(total - antiguos, 0));
                    
                    SET i = i + 1;
                END WHILE;
                
                SELECT * FROM antiguosVsNuevos;
                
                DROP TEMPORARY TABLE IF EXISTS antiguosVsNuevos;
            END
        ');
        
        DB::unprepared('
            CREATE PROCEDURE IF NOT EXISTS stats_alumnosNuevosVsAntiguosPorNivelEducativo(añoEvaluado INT)
            BEGIN
                SELECT 
                    ne.nombre_nivel AS "Nivel",
                    SUM(CASE 
                            WHEN m.id_alumno IN (
                                SELECT id_alumno FROM matriculas WHERE año_escolar = añoEvaluado - 1
                            ) THEN 1 ELSE 0 
                        END) AS "Antiguos",
                    SUM(CASE 
                            WHEN m.id_alumno NOT IN (
                                SELECT id_alumno FROM matriculas WHERE año_escolar = añoEvaluado - 1
                            ) THEN 1 ELSE 0 
                        END) AS "Nuevos"
                FROM matriculas AS m
                JOIN grados AS gr ON m.id_grado = gr.id_grado
                JOIN niveles_educativos AS ne ON gr.id_nivel = ne.id_nivel
                WHERE m.año_escolar = añoEvaluado
                GROUP BY ne.nombre_nivel;
            END
        ');

        DB::unprepared('
            CREATE PROCEDURE IF NOT EXISTS stats_alumnosNuevosVsAntiguosPorGrado(añoEvaluado INT, idNivelEvaluado INT)
            BEGIN
                SELECT
                gr.nombre_grado AS "Grado",
                SUM(CASE 
                        WHEN m.id_alumno IN (
                            SELECT id_alumno FROM matriculas WHERE año_escolar = añoEvaluado - 1
                        ) THEN 1 ELSE 0 
                    END) AS "Antiguos",
                SUM(CASE 
                        WHEN m.id_alumno NOT IN (
                            SELECT id_alumno FROM matriculas WHERE año_escolar = añoEvaluado - 1
                        ) THEN 1 ELSE 0 
                    END) AS "Nuevos"
                FROM matriculas AS m
                JOIN grados AS gr ON m.id_grado = gr.id_grado
                JOIN niveles_educativos AS ne ON gr.id_nivel = ne.id_nivel
                WHERE m.año_escolar = añoEvaluado AND ne.id_nivel = idNivelEvaluado
                GROUP BY gr.nombre_grado;
            END
        ');

        DB::unprepared('
            CREATE PROCEDURE IF NOT EXISTS stats_alumnosRetiradosPorAño()
            BEGIN
                DECLARE añoMinimo INT;
                DECLARE añoMaximo INT;
                DECLARE i INT;
                DECLARE retirados INT;
                
                SELECT
                    año_escolar INTO añoMinimo
                FROM matriculas
                ORDER BY año_escolar ASC
                LIMIT 1;
                
                SELECT
                    año_escolar INTO añoMaximo
                FROM matriculas
                ORDER BY año_escolar DESC
                LIMIT 1;
                
                CREATE TEMPORARY TABLE alumnosRetirados (
                    año_escolar INT,
                    retirados		INT
                );
                
                SET i = añoMinimo;
                WHILE i <= añoMaximo DO					
                    SELECT 
                        COUNT(*) INTO retirados
                    FROM matriculas
                    WHERE año_escolar = i - 1
                    AND id_alumno NOT IN (
                        SELECT
                            id_alumno
                        FROM matriculas
                        WHERE año_escolar = i
                    );
                    
                    INSERT INTO alumnosRetirados (año_escolar, retirados) VALUES
                    (i, retirados);
                    
                    SET i = i + 1;
                END WHILE;
                
                SELECT * FROM alumnosRetirados;
                
                DROP TEMPORARY TABLE IF EXISTS alumnosRetirados;
            END
        ');

        DB::unprepared('
            CREATE PROCEDURE IF NOT EXISTS stats_alumnosRetiradosPorNivelEducativo(añoEvaluado INT)
            BEGIN
                SELECT 
                ne.nombre_nivel AS "Nivel",
                SUM(CASE 
                    WHEN m.id_alumno NOT IN (
                        SELECT id_alumno FROM matriculas WHERE año_escolar = añoEvaluado
                    ) THEN 1 ELSE 0 
                END) AS "Retirados"
                FROM matriculas AS m
                JOIN grados AS gr ON m.id_grado = gr.id_grado
                JOIN niveles_educativos AS ne ON gr.id_nivel = ne.id_nivel
                WHERE m.año_escolar = añoEvaluado - 1
                GROUP BY ne.nombre_nivel;
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
        DB::unprepared('DROP PROCEDURE IF EXISTS stats_alumnosNuevosVsAntiguosPorAño');
        DB::unprepared('DROP PROCEDURE IF EXISTS stats_alumnosNuevosVsAntiguosPorNivelEducativo');
        DB::unprepared('DROP PROCEDURE IF EXISTS stats_alumnosNuevosVsAntiguosPorGrado');
        DB::unprepared('DROP PROCEDURE IF EXISTS stats_alumnosRetiradosPorAño');
        DB::unprepared('DROP PROCEDURE IF EXISTS stats_alumnosRetiradosPorNivelEducativo');
    }
};
