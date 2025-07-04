<?php

namespace App\Http\Controllers;

use App\Models\Grado;
use App\Models\Matricula;
use App\Models\Seccion;
use Carbon\Carbon;
use Illuminate\Http\Request;

class SeccionController extends Controller
{
    
    private static function doSearch($sqlColumns, $search, $pagination){
        if (!isset($search)){
            $secciones = Seccion::where('estado', '=', '1')->paginate($pagination);
        } else {
            $secciones = Seccion::where('estado', '=', '1')
                ->whereAny($sqlColumns, 'LIKE', "%{$search}%")
                ->paginate($pagination);
        }

        return $secciones;
    }


    public function index(Request $request)
    {
        $sqlColumns = ["id_grado","nombreSeccion"];
        $tipoDeRecurso = "academica";

        $pagination = $request->input('showing', 10);
        $paginaActual = $request->input('page', 1);
        $search = $request->input('search');

        if (!is_numeric($paginaActual) || $paginaActual <= 0) $paginaActual = 1;
        if (!is_numeric($pagination) || $pagination <= 0) $pagination = 10;

        $secciones = SeccionController::doSearch($sqlColumns, $search, $pagination);

        if ($paginaActual > $secciones->lastPage()){
            $paginaActual = 1;
            $request['page'] = $paginaActual;
            $secciones = SeccionController::doSearch($sqlColumns, $search, $pagination);
        }

        $data = [
            'titulo' => 'Secciones',
            'columnas' => [
                '#',
                'Nivel Educativo',
                'Grado',
                'Seccion'
            ],
            'filas' => [],
            'showing' => $pagination,
            'paginaActual' => $paginaActual,
            'totalPaginas' => $secciones->lastPage(),
            'resource' => $tipoDeRecurso,
            'view' => 'seccion_view',
            'create' => 'seccion_create',
            'edit' => 'seccion_edit',
            'delete' => 'seccion_delete',
            'show_route' => 'seccion_view_details'
        ];

        if ($request->input("created", false)){
            $data['created'] = $request->input('created');
        }

        if ($request->input("edited", false)){
            $data['edited'] = $request->input('edited');
        }

        if ($request->input("abort", false)){
            $data['abort'] = $request->input('abort');
        }

        if ($request->input("deleted", false)){
            $data['deleted'] = $request->input('deleted');
        }

        foreach ($secciones as $key => $itemseccion) {
            $data['filas'][] = [
                $key + 1 + $pagination*($paginaActual-1),
                $itemseccion->grado->nivelEducativo->nombre_nivel,  
                $itemseccion->grado->nombre_grado,        
                $itemseccion->nombreSeccion,              
                $itemseccion->id_grado                    
            ];
        }
         
        return view('gestiones.seccion.index', compact('data'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $grados = Grado::where('estado', '=', '1')->get();
        $data = [
            'return' => route('seccion_view', ['abort' => true]),
            'grados' => $grados
        ];

        return view('gestiones.seccion.create', compact('data'));
    }
    /**
     * Store a newly created resource in storage.
     */

    public function createNewEntry(Request $request){

        $request->validate([
            'grado'=>'required|integer',
            'seccion'=> 'required|string|max:2',
        ],[
            'grado.required'=> 'El grado es requerido',
            'grado.integer'=> 'El id del grado tiene que ser entero',
            'seccion.required'=> 'Es necesario ingresar un nombre para la seccion',
            'seccion.max'=> 'El nombre de la seccion es muy largo, max = 2 caracteres'
        ]);

        Seccion::create([
            'id_grado' => $request->input('grado'),
            'nombreSeccion' => $request->input('seccion')
        ]);

        return redirect(route('seccion_view', ['created' => true]));

    }


    public function edit(Request $request, $nombreGrado, $nombreSeccion)
    {
        if (!isset($nombreGrado) || !isset($nombreSeccion)) {
            return redirect(route('seccion_view'));
        }

        $grado = Grado::where('nombre_grado', $nombreGrado)->firstOrFail();

        $seccion = Seccion::where('id_grado', $grado->id_grado)
                        ->where('nombreSeccion', $nombreSeccion)
                        ->firstOrFail();

        $grados = Grado::where("estado", "=", "1")->get();

        $data = [
            'return' => route('seccion_view', ['abort' => true]),
            'id' => ['nombreGrado' => $nombreGrado, 'nombreSeccion' => $nombreSeccion],
            'grados' => $grados,
            'default' => [
                'grado' => $seccion->id_grado,
                'seccion' => $seccion->nombreSeccion
            ]
        ];

        return view('gestiones.seccion.edit', compact('data'));
    }

    public function editEntry(Request $request, $nombreGrado, $nombreSeccion)
    {
        if (!isset($nombreGrado) || !isset($nombreSeccion)) {
            return redirect(route('seccion_view'));
        }

        $request->validate([
            'grado'   => 'required|integer',
            'seccion' => 'required|string|max:2',
        ], [
            'grado.required'   => 'El grado es requerido',
            'grado.integer'    => 'El id del grado tiene que ser entero',
            'seccion.required' => 'Es necesario ingresar un nombre para la seccion',
            'seccion.max'      => 'El nombre de la seccion es muy largo, max = 2 caracteres',
        ]);

        $grado = Grado::where('nombre_grado', $nombreGrado)->firstOrFail();

        $seccion = Seccion::where('id_grado', $grado->id_grado)
                        ->where('nombreSeccion', $nombreSeccion)
                        ->firstOrFail();

        $seccion->id_grado = $request->input('grado');
        $seccion->nombreSeccion = $request->input('seccion');
        $seccion->save();

        return redirect()->route('seccion_view', ['edited' => true]);
    }

    public function view_details(Request $request, $id_grado, $nombreSeccion)
    {
        $seccion = Seccion::where('id_grado', $id_grado)
            ->where('nombreSeccion', $nombreSeccion)
            ->firstOrFail();

        $anioEscolar = $request->input('año_escolar', Carbon::now()->year);

        $Pagination = $request->query('showing', 5);
        $Page = $request->query('page', 1);


        $matriculas = Matricula::with('alumno')
            ->where('id_grado', $id_grado)
            ->where('nombreSeccion', $nombreSeccion)
            ->where('año_escolar', $anioEscolar)
            ->orderBy('fecha_matricula', 'desc')
            ->paginate(10, ['*'], 'matricula_page');

        $añosDisponibles = Matricula::where('id_grado', $id_grado)
            ->where('nombreSeccion', $nombreSeccion)
            ->distinct()
            ->pluck('año_escolar');

        return view('gestiones.seccion.view_details', compact(
            'seccion',
            'matriculas',
            'anioEscolar',
            'añosDisponibles',
            'Pagination',
            'Page'
        ));
    }




}
