<?php

namespace App\Http\Controllers\Reportes;

use App\Helpers\GraphJS\GraphJSDataAdapter;
use App\Helpers\GraphJS\GraphJSDataset;
use App\Models\Grado;
use App\Models\Matricula;
use App\Models\NivelEducativo;
use App\Models\Seccion;
use DB;
use App\Helpers\GraphJS\GraphJSOptions;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ReportesAcademicosController extends Controller
{
    public static function index()
    {
        return view('gestiones.estadisticas.reportes_academicos.index');
    }

    private static function obtenerCantidadAlumnosMatriculadosEnAñosEscolares($matriculados, $añosEscolares){
        $cantidadEnAñosEscolares = [];
        foreach ($añosEscolares as $añoEscolar) {
            array_push(
            $cantidadEnAñosEscolares, 
            $matriculados->where('año_escolar', '=', $añoEscolar)->count()
            );
        }
        return $cantidadEnAñosEscolares;
    }
    private static function obtenerAñosEscolares($matriculados){
        return $matriculados
            ->unique("año_escolar")
            ->pluck("año_escolar")
            ->sort()
            ->values();
    }

    private static function obtenerMatriculados(){
        return Matricula::whereEstado(True)->get();
    }

    private static function alumnosMatriculadosTodosLosGradosEnAñosEscolares(){
        $datos = DB::table('stats_alumnosMatriculadosTodosLosGradosEnAñosEscolares')->get();

        $añosEscolares = $datos->unique("Año Escolar")->pluck("Año Escolar")->values();
        $nivelesEducativos = $datos->unique("Nivel Educativo")->pluck("Nivel Educativo")->values();
        $grados = Grado::where('estado', '=', true)->get();

        $options = new GraphJSOptions();
        $options->setOption('scales', [
            "x" => [
                "stacked" => true
            ],
            "y" => [
                "stacked" => true,
            ],
        ]);

        $graphJSData = new GraphJSDataAdapter();
        $graphJSData->type("bar");
        $graphJSData->labels($añosEscolares->toArray());
        $graphJSData->options($options);

        foreach ($grados as $grado){
            $dataset = new GraphJSDataset();
            $dataset->label($grado->nombre_grado . " de " . $grado->nivelEducativo->nombre_nivel);
            
            $datosSet = [];
            foreach ($añosEscolares as $año){
                $gradoEncontrado = $datos->first(function($item) use ($grado, $año) {
                    return $item->Grado == $grado->nombre_grado
                        && $item->{'Nivel Educativo'} == $grado->nivelEducativo->nombre_nivel
                        && $item->{'Año Escolar'} == $año;
                });

                array_push($datosSet, $gradoEncontrado ? $gradoEncontrado->Cantidad : 0);
            }
            
            $dataset->data($datosSet);
            $graphJSData->addDataset($dataset);
        }
  
        return response()->json($graphJSData->chartData());
    }

    private static function alumnosMatriculadosEnNivelEducativoEspecifico(Request $request){
        $añosEscolares = self::obtenerAñosEscolares(self::obtenerMatriculados());
        $nivelesEducativos = self::obtenerNivelesEducativos();
        $secciones = Seccion::where('estado', '=', true)->distinct()->pluck('nombreSeccion');

        $añoEvaluado = $request->input('añoEscolar');
        if (!in_array($añoEvaluado, $añosEscolares->toArray())){
            $añoEvaluado = $añosEscolares->last();
        }

        $nivelEducativoEvaluado = $request->input('nivelEducativo');
        if (!in_array($nivelEducativoEvaluado, $nivelesEducativos->pluck('nombre_nivel')->toArray())){
            $nivelEducativoEvaluado = $nivelesEducativos->first();
        }

        $datos = DB::select('CALL stats_alumnosMatriculadosEnNivelEducativoEspecifico(?, ?)', [$añoEvaluado, $nivelEducativoEvaluado]);

        $options = new GraphJSOptions();
        $options->setOption('scales', [
            "x" => [
                "stacked" => true
            ],
            "y" => [
                "stacked" => true,
            ],
        ]);

        $grados = Grado::where('estado', '=', true)
            ->whereIdNivel($nivelesEducativos->firstWhere('nombre_nivel', '=', $nivelEducativoEvaluado)->getKey())
            ->get();

        $graphJSData = new GraphJSDataAdapter();
        $graphJSData->type("bar");
        $graphJSData->labels($grados->pluck('nombre_grado')->toArray());
        $graphJSData->options($options);

        foreach ($secciones as $seccion){
            $dataset = new GraphJSDataset();
            $dataset->label("Sección " . $seccion);

            $datosSet = [];
            foreach ($grados as $grado){
                $gradoEncontrado = collect($datos)->first(function($item) use ($grado, $seccion) {
                    return $item->{'Grado'} == $grado->nombre_grado
                        && $item->{'Sección'} == $seccion;

                });

                array_push($datosSet, $gradoEncontrado ? $gradoEncontrado->Cantidad : 0);
            }
            
            $dataset->data($datosSet);
            $graphJSData->addDataset($dataset);
        }

        $data = $graphJSData->chartData();
        $data["extra"] = [
            "añosEscolares" => $añosEscolares,
            "nivelesEducativos" => $nivelesEducativos->pluck('nombre_nivel'),
            "grados" => $grados->pluck('nombre_grado'),
        ];
  
        return response()->json($data);
    }

    private static function alumnosMatriculadosEnAñoEspecifico(Request $request){
        $añosEscolares = self::obtenerAñosEscolares(self::obtenerMatriculados());

        $añoEvaluado = $request->input('añoEscolar');
        if (!in_array($añoEvaluado, $añosEscolares->toArray())){
            $añoEvaluado = $añosEscolares->last();
        }

        $nivelesEducativos = NivelEducativo::where('estado', '=', true)->get();

        $datos = DB::select('CALL stats_alumnosMatriculadosEnAñoEspecifico(?)', [$añoEvaluado]);
        $cantidades = [];

        foreach ($nivelesEducativos as $nivel){
            $nivelEncontrado = collect($datos)->first(function($item) use ($nivel) {
                return $item->{'Nivel Educativo'} == $nivel->nombre_nivel;
            });

            array_push($cantidades, $nivelEncontrado ? $nivelEncontrado->Cantidad : 0);
        }

        $dataset = new GraphJSDataset();
        $dataset->label("Matriculados");
        $dataset->data($cantidades);

        $graphJSData = new GraphJSDataAdapter();
        $graphJSData->type("pie");
        $graphJSData->labels($nivelesEducativos->pluck('nombre_nivel')->toArray());
        $graphJSData->addDataset($dataset);

        $data = $graphJSData->chartData();
        $data["extra"] = [
            "añosEscolares" => $añosEscolares,
            "nivelesEducativos" => $nivelesEducativos->pluck('nombre_nivel'),
        ];
  
        return response()->json($data);
    }

    private static function alumnosMatriculadosSinEspecificar(Request $request){
        $datos = DB::table('stats_alumnosMatriculadosPorNivelesEducativosEnAñosEscolares')->get();

        $añosEscolares = $datos->unique("Año Escolar")->pluck("Año Escolar")->values();
        $nivelesEducativos = NivelEducativo::where('estado', '=', true)->get();

        $options = new GraphJSOptions();
        $options->setOption('scales', [
            "x" => [
                "stacked" => true
            ],
            "y" => [
                "stacked" => true,
            ],
        ]);

        $graphJSData = new GraphJSDataAdapter();
        $graphJSData->type("bar");
        $graphJSData->labels($añosEscolares->toArray());
        $graphJSData->options($options);

        foreach ($nivelesEducativos as $nivel){
            $dataset = new GraphJSDataset();
            $dataset->label($nivel->nombre_nivel);
            
            $datosSet = [];
            foreach ($añosEscolares as $año){
                $nivelEncontrado = $datos->first(function($item) use ($nivel, $año) {
                    return $item->{'Nivel Educativo'} == $nivel->nombre_nivel
                        && $item->{'Año Escolar'} == $año;
                });

                array_push($datosSet, $nivelEncontrado ? $nivelEncontrado->Cantidad : 0);
            }
            
            $dataset->data($datosSet);
            $graphJSData->addDataset($dataset);
        }

        $data = $graphJSData->chartData();
        $data["extra"] = [
            "añosEscolares" => $añosEscolares,
            "nivelesEducativos" => $nivelesEducativos->pluck('nombre_nivel'),
        ];
  
        return response()->json($data);
    }

    public static function alumnosMatriculados(Request $request){
        if ($request->input('añoEscolar') == null) return self::alumnosMatriculadosSinEspecificar($request);
        if ($request->input('nivelEducativo') == null) return self::alumnosMatriculadosEnAñoEspecifico($request);
        if ($request->input('grado') == null) return self::alumnosMatriculadosEnNivelEducativoEspecifico($request);

        return null;
    }

    private static function obtenerAlumnosEnGrado($añoEscolar, $idGrado){
        return Matricula::whereEstado(true)
            ->where('año_escolar', '=', $añoEscolar)
            ->where('id_grado', '=', $idGrado)
            ->get();
    }

    private static function obtenerMatriculadosEnUnAño($añoEscolar){
        return Matricula::whereEstado(true)
            ->whereAñoEscolar($añoEscolar)
            ->get();
    }

    private static function obtenerNivelEducativoPorNombre($nombreNivelEducativo): NivelEducativo | null{
        $nivelEducativo = NivelEducativo::where('estado', '=', true)
            ->whereNombreNivel($nombreNivelEducativo)
            ->first();

        return $nivelEducativo;
    }

    private static function alumnosNuevosVsAntiguosPorAño(Request $request){
        $matriculados = self::obtenerMatriculados();
        $añosEscolares = self::obtenerAñosEscolares($matriculados);

        $datos = DB::select('CALL stats_alumnosNuevosVsAntiguosPorAño()');

        $años = collect($datos)->pluck('año_escolar')->toArray();
        $alumnosNuevos = collect($datos)->pluck('nuevos')->toArray();
        $alumnosAntiguos = collect($datos)->pluck('antiguos')->toArray();

        $nuevosDataset = new GraphJSDataset();
        $nuevosDataset->label("Alumnos Nuevos");
        $nuevosDataset->data($alumnosNuevos);

        $antiguosDataset = new GraphJSDataset();
        $antiguosDataset->label("Alumnos Antiguos");
        $antiguosDataset->data($alumnosAntiguos);

        $graphJSData = new GraphJSDataAdapter();
        $graphJSData->type("bar");
        $graphJSData->labels($años);
        $graphJSData->addDataset($nuevosDataset);
        $graphJSData->addDataset($antiguosDataset);

        $data = $graphJSData->chartData();
        $data["extra"] = [
            "añosEscolares" => $añosEscolares,
            "nivelesEducativos" => NivelEducativo::where('estado', '=', true)->pluck('nombre_nivel'),
        ];

        return response()->json($data);
    }

    private static function alumnosNuevosVsAntiguosPorNivelEducativo(Request $request){
        $matriculados = self::obtenerMatriculados();
        $añosEscolares = self::obtenerAñosEscolares($matriculados);

        $añoEscolarEvaluado = $request->input('añoEscolar') ?? self::obtenerAñosEscolares(self::obtenerMatriculados())->last();

        if ($añoEscolarEvaluado == null){
            $añoEscolarEvaluado = $añosEscolares->last();
        }

        $datos = DB::select('CALL stats_alumnosNuevosVsAntiguosPorNivelEducativo(?)', [
            $añoEscolarEvaluado
        ]);

        $nivelesEducativos = collect($datos)->pluck('Nivel')->toArray();
        $alumnosNuevos = collect($datos)->pluck('Nuevos')->toArray();
        $alumnosAntiguos = collect($datos)->pluck('Antiguos')->toArray();

        $nuevosDataset = new GraphJSDataset();
        $nuevosDataset->label("Alumnos Nuevos");
        $nuevosDataset->data($alumnosNuevos);

        $antiguosDataset = new GraphJSDataset();
        $antiguosDataset->label("Alumnos Antiguos");
        $antiguosDataset->data($alumnosAntiguos);

        $graphJSData = new GraphJSDataAdapter();
        $graphJSData->type("bar");
        $graphJSData->labels($nivelesEducativos);
        $graphJSData->addDataset($nuevosDataset);
        $graphJSData->addDataset($antiguosDataset);

        $data = $graphJSData->chartData();
        $data["extra"] = [
            "añosEscolares" => $añosEscolares,
            "actualAñoEscolar" => $añoEscolarEvaluado,
            "nivelesEducativos" => NivelEducativo::where('estado', '=', true)->pluck('nombre_nivel'),
        ];

        return response()->json($data);
    }

    private static function alumnosNuevosVsAntiguosPorGrado(Request $request){
        $matriculados = self::obtenerMatriculados();
        $añosEscolares = self::obtenerAñosEscolares($matriculados);
        $nivelesEducativos = self::obtenerNivelesEducativos();

        $añoEscolarEvaluado = $request->input('añoEscolar') ?? self::obtenerAñosEscolares(self::obtenerMatriculados())->last();

        if ($añoEscolarEvaluado == null){
            $añoEscolarEvaluado = $añosEscolares->last();
        }

        $nivelEducativoEvaluado = self::obtenerNivelEducativoPorNombre($request->input('nivelEducativo')) ?? self::obtenerNivelesEducativos()->first();

        $datos = DB::select('CALL stats_alumnosNuevosVsAntiguosPorGrado(?, ?)', [
            $añoEscolarEvaluado,
            $nivelEducativoEvaluado->getKey()
        ]);

        $grados = collect($datos)->pluck('Grado')->toArray();
        $alumnosNuevos = collect($datos)->pluck('Nuevos')->toArray();
        $alumnosAntiguos = collect($datos)->pluck('Antiguos')->toArray();

        $nuevosDataset = new GraphJSDataset();
        $nuevosDataset->label("Alumnos Nuevos");
        $nuevosDataset->data($alumnosNuevos);

        $antiguosDataset = new GraphJSDataset();
        $antiguosDataset->label("Alumnos Antiguos");
        $antiguosDataset->data($alumnosAntiguos);

        $graphJSData = new GraphJSDataAdapter();
        $graphJSData->type("bar");
        $graphJSData->labels($grados);
        $graphJSData->addDataset($nuevosDataset);
        $graphJSData->addDataset($antiguosDataset);

        $data = $graphJSData->chartData();
        $data["extra"] = [
            "añosEscolares" => $añosEscolares,
            "actualAñoEscolar" => $añoEscolarEvaluado,
            "nivelesEducativos" => NivelEducativo::where('estado', '=', true)->pluck('nombre_nivel'),
            "actualNivelEducativo" => $nivelEducativoEvaluado->nombre_nivel,
            "grados" => Grado::where('estado', '=', true)
                ->whereIdNivel($nivelEducativoEvaluado->getKey())
                ->pluck('nombre_grado')
        ];

        return response()->json($data);

    }

    public static function alumnosNuevosVsAntiguos(Request $request){
        if ($request->input('añoEscolar') == null) return self::alumnosNuevosVsAntiguosPorAño($request);
        if ($request->input('nivelEducativo') == null) return self::alumnosNuevosVsAntiguosPorNivelEducativo($request);
        if ($request->input('grado') == null) return self::alumnosNuevosVsAntiguosPorGrado($request);
        return null;
    }

    private static function obtenerNivelesEducativos(){
        return NivelEducativo::where('estado', '=', true);
    }

    public static function alumnosPorGenero(Request $request){
        $matriculados = self::obtenerMatriculados();
        $añosEscolares = self::obtenerAñosEscolares($matriculados);

        $añoEscolarEvaluado = $request->input('añoEvaluado') ?? self::obtenerAñosEscolares(self::obtenerMatriculados())->last();

        if ($añoEscolarEvaluado == null){
            $añoEscolarEvaluado = $añosEscolares->last();
        }

        $nivelEducativoEvaluado = self::obtenerNivelEducativoPorNombre($request->input('nivelEducativo')) ?? self::obtenerNivelesEducativos()->first();

        $grados = Grado::where('estado', '=', true)
            ->whereIdNivel($nivelEducativoEvaluado->getKey())
            ->get();

        $alumnosHombres = array_fill(0, $grados->count(), 0);
        $alumnosMujeres = array_fill(0, $grados->count(), 0);

        for ($i = 0; $i < $grados->count(); $i++){
            $idGrado = $grados[$i]->getKey();

            $resultado = DB::select('CALL alumnosPorSexo(?, ?)', [
                $añoEscolarEvaluado,
                $idGrado
            ]);

            array_walk($resultado, function ($fila) use ($i, &$alumnosHombres, &$alumnosMujeres){
                if ($fila->Sexo == 'M') $alumnosHombres[$i] = $fila->Cantidad;
                else if ($fila->Sexo == 'F') $alumnosMujeres[$i] = $fila->Cantidad;
            });
        }

        $hombresDataset = new GraphJSDataset();
        $hombresDataset->label("Alumnos Hombres");
        $hombresDataset->data($alumnosHombres);

        $mujeresDataset = new GraphJSDataset();
        $mujeresDataset->label("Alumnos Mujeres");
        $mujeresDataset->data($alumnosMujeres);

        $graphJSData = new GraphJSDataAdapter();
        $graphJSData->type("bar");
        $graphJSData->labels($grados->pluck('nombre_grado')->toArray());
        $graphJSData->addDataset($hombresDataset);
        $graphJSData->addDataset($mujeresDataset);

        $data = $graphJSData->chartData();
        $data["extra"] = [
            "añosEscolares" => $añosEscolares,
            "nivelesEducativos" => NivelEducativo::where('estado', '=', true)->pluck('nombre_nivel'),
            "actualNivelEducativo" => "Inicial",
            "actualAñoEscolar" => $añoEscolarEvaluado,
        ];

        return response()->json($data); 
    }

    private static function alumnosRetiradosPorAño(Request $request){
        $datos = DB::select('CALL stats_alumnosRetiradosPorAño()');

        $añosEscolares = collect($datos)->pluck('año_escolar')->toArray();
        $cantidades = collect($datos)->pluck('retirados')->toArray();

        $dataset = new GraphJSDataset();
        $dataset->label("Alumnos Retirados");
        $dataset->data($cantidades);

        $graphJSData = new GraphJSDataAdapter();
        $graphJSData->type("bar");
        $graphJSData->labels($añosEscolares);
        $graphJSData->addDataset($dataset);

        $data = $graphJSData->chartData();
        $data["extra"] = [
            "añosEscolares" => $añosEscolares,
            "nivelesEducativos" => [],
        ];

        return response()->json($data); 
    }

    private static function alumnosRetiradosPorNivelEducativo(Request $request){
        $añosEscolares = self::obtenerAñosEscolares(self::obtenerMatriculados());

        $añoEscolarEvaluado = $request->input('añoEscolar') ?? self::obtenerAñosEscolares(self::obtenerMatriculados())->last();

        if ($añoEscolarEvaluado == null){
            $añoEscolarEvaluado = $añosEscolares->last();
        }

        $datos = DB::select('CALL stats_alumnosRetiradosPorNivelEducativo(?)', [
            $añoEscolarEvaluado
        ]);

        $nivelesEducativos = collect($datos)->pluck('Nivel')->toArray();
        $cantidades = collect($datos)->pluck('Retirados')->toArray();

        $dataset = new GraphJSDataset();
        $dataset->label("Alumnos Retirados");
        $dataset->data($cantidades);

        $graphJSData = new GraphJSDataAdapter();
        $graphJSData->type("bar");
        $graphJSData->labels($nivelesEducativos);
        $graphJSData->addDataset($dataset);

        $data = $graphJSData->chartData();
        $data["extra"] = [
            "añosEscolares" => $añosEscolares,
            "actualAñoEscolar" => $añoEscolarEvaluado,
            "nivelesEducativos" => [],
        ];

        return response()->json($data); 
    }

    public static function alumnosRetirados(Request $request){
        if ($request->input('añoEscolar') == null) return self::alumnosRetiradosPorAño($request);
        if ($request->input('nivelEducativo') == null) return self::alumnosRetiradosPorNivelEducativo($request);
        return null;
    }

    private static function obtenerIdGradoPorNombre($nombreGrado){
        $grado = Grado::where('estado', '=', true)
            ->where('nombre_grado', '=', $nombreGrado)
            ->first();

        return $grado?->getKey();
    }

    public static function alumnosPorGradoDeEdad(Request $request){
        $nombreGrado = $request->input('grado') ?? Grado::where('estado', '=', true)->orderBy('id_nivel')->first()->nombre_grado;

        $idGrado = self::obtenerIdGradoPorNombre($nombreGrado);

        $resultado = DB::select('CALL obtenerRangoEdadesEnUnGrado(?)', [
            $idGrado
        ]);

        $labelsEdades = [];
        $cantidades = [];
        
        foreach ($resultado as $fila) {
            array_push($labelsEdades, $fila->Edad . " años");
            array_push($cantidades, $fila->Cantidad);
        }

        $options = new GraphJSOptions();
        $options->setOption('plugins', [
            "title" => [
                "display" => true,
                "text" => "Distribución de edades de todos los matriculados"
            ]
        ]);

        $dataset = new GraphJSDataset();
        $dataset->label("Alumnos");
        $dataset->data($cantidades);

        $graphJSData = new GraphJSDataAdapter();
        $graphJSData->type("doughnut");
        $graphJSData->labels($labelsEdades); // [10, 18, 20, 22]
        $graphJSData->addDataset($dataset);


        $graphJSData->options($options);

        return response()->json($graphJSData->chartData());
    }
}