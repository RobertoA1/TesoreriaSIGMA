<?php

namespace App\Http\Controllers;

use App\Models\NivelEducativo;
use DB;
use Illuminate\Http\Request;
use App\Models\Grado;
use Illuminate\Validation\Rule;

class GradoController extends Controller
{
    private static function doSearch($sqlColumns, $search, $pagination){
        if (!isset($search)){
            $grados = Grado::where('estado', '=', '1')->paginate($pagination);
        } else {
            $grados = Grado::where('estado', '=', '1')
                ->whereAny($sqlColumns, 'LIKE', "%{$search}%")
                ->paginate($pagination);
        }

        return $grados;
    }
    public function index(Request $request)
    {
        $sqlColumns = ["id_grado","id_nivel","nombre_grado"];
        $tipoDeRecurso = "academica";

        $pagination = $request->input('showing', 10);
        $paginaActual = $request->input('page', 1);
        $search = $request->input('search');

        if (!is_numeric($paginaActual) || $paginaActual <= 0) $paginaActual = 1;
        if (!is_numeric($pagination) || $pagination <= 0) $pagination = 10;

        $grados = GradoController::doSearch($sqlColumns, $search, $pagination);

        if ($paginaActual > $grados->lastPage()){
            $paginaActual = 1;
            $request['page'] = $paginaActual;
            $grados = GradoController::doSearch($sqlColumns, $search, $pagination);
        }

        $data = [
            'titulo' => 'Grados',
            'columnas' => [
                'ID',
                'Grado',
                'Nivel Educativo'
            ],
            'filas' => [],
            'showing' => $pagination,
            'paginaActual' => $paginaActual,
            'totalPaginas' => $grados->lastPage(),
            'resource' => $tipoDeRecurso,
            'view' => 'grado_view',
            'create' => 'grado_create',
            'edit' => 'grado_edit',
            'delete' => 'grado_delete',
            'show_route' => 'grado_view_details'
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

        foreach ($grados as $itemgrado){
            array_push($data['filas'],
            [
                $itemgrado->id_grado,
                $itemgrado->nombre_grado,
                $itemgrado->nivelEducativo->descripcion
            ]); 
        }
         
        return view('gestiones.grado.index', compact('data'));

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $niveles = NivelEducativo::where('estado', '=', '1')->get();
        $data = [
            'return' => route('grado_view', ['abort' => true]),
            'niveles' => $niveles
        ];

        return view('gestiones.grado.create', compact('data'));
    }

    
    public function createNewEntry(Request $request){

        $request->validate([
            'nombre_del_grado'=>'required|string|max:50|unique:grados,nombre_grado',
            'nivel_educativo'=> 'required|integer|exists:niveles_educativos,id_nivel',
        ],[
            'nombre_del_grado.required' => 'El nombre del grado es obligatorio.',
            'nombre_del_grado.unique' => 'Ya existe un grado con ese nombre.',
            'nombre_del_grado.max' => 'Maximo num de caracteres: 50',
            'nivel_educativo.required' => 'Debes seleccionar un nivel educativo.',
            'nivel_educativo.exists' => 'El nivel educativo seleccionado no es válido.',
        ]);

        Grado::create([
            'id_nivel' => $request->input('nivel_educativo'),
            'nombre_grado' => $request->input('nombre_del_grado')
        ]);

        return redirect(route('grado_view', ['created' => true]));

    }


    public function store(Request $request)
    {
        //
    }


    public function show(string $id)
    {
        //
    }


    public function edit(Request $request, $id)
    {
        if (!isset($id)) {
            return redirect(route('grado_view'));
        }

        $grado = Grado::findOrFail($id);
        $niveles = NivelEducativo::where("estado", "=", "1")->get();
        
        $data = [
            'return' => route('grado_view', ['abort' => true]),
            'id' => $id,
            'niveles' => $niveles,
            'default' => [
                'id_nivel' => $grado->id_nivel,
                'nombre_del_grado' => $grado->nombre_grado
            ]
        ];
        
        return view('gestiones.grado.edit', compact('data'));
    }



    public function editEntry(Request $request, $id)
    {


        if (!isset($id)) {
            return redirect(route('grado_view'));
        }
        $request->validate([
            'nombre_del_grado' => [
                'required','string','max:50',
                function($attribute, $value, $fail) use ($request, $id){
                    $exists = Grado::where('id_nivel', $request->nivel_educativo)
                    ->where('nombre_grado', $value)
                    ->where(
                        function($query) use ($id){
                            $query->where('id_grado', '!=', $id);
                        }
                    )->exists();
                    if ($exists) {
                        $fail('Ya existe un grado con este nombre en el nivel seleccionado.');
                    }
                }
            ],
            'nivel_educativo' => 'required|integer|exists:niveles_educativos,id_nivel',
        ], [
            'nombre_del_grado.required' => 'El nombre del grado es obligatorio.',
            'nombre_del_grado.max' => 'Máximo número de caracteres: 50.',
            'nivel_educativo.required' => 'Debes seleccionar un nivel educativo.',
            'nivel_educativo.exists' => 'El nivel educativo seleccionado no es válido.',
        ]);

        $grado = Grado::findOrFail($id);

        $grado->nombre_grado = $request->input('nombre_del_grado');
        $grado->id_nivel = $request->input('nivel_educativo');
        $grado->save();

        

        return redirect()->route('grado_view', ['edited' => true]);
    }

    public function delete(Request $request)
    {
        $id = $request->input('id');
        $grado = Grado::findOrFail($id);
        $grado->update(['estado' => '0']);

        return redirect(route('grado_view', ['deleted' => true]));
    }

    public function view_details(Request $request, $id)
    {
        $anioActual = date('Y');
        $anio = $request->query('anio', $anioActual);

        $cursoPagination = $request->query('curso_showing', 5);
        $cursoPage = $request->query('curso_page', 1);

        $seccionPagination = $request->query('seccion_showing', 5);
        $seccionPage = $request->query('seccion_page', 1);

        $grado = Grado::with('nivelEducativo')->findOrFail($id);

        $cursosQuery = $grado->cursos()
            ->where('cursos.estado', 1) 
            ->wherePivot('año_escolar', $anio)
            ->paginate($cursoPagination, ['*'], 'curso_page', $cursoPage);

        $seccionesQuery = $grado->secciones()
            ->where('estado', 1)
            ->paginate($seccionPagination, ['*'], 'seccion_page', $seccionPage);

        $aniosDisponibles = DB::table('cursos_grados')
            ->select('año_escolar')
            ->distinct()
            ->orderBy('año_escolar', 'desc')
            ->pluck('año_escolar');

        return view('gestiones.grado.view_details', compact(
            'grado',
            'anio',
            'aniosDisponibles',
            'cursosQuery',
            'seccionesQuery',
            'cursoPagination',
            'seccionPagination'
        ));
    }

}
