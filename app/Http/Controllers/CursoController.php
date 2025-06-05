<?php

namespace App\Http\Controllers;

use App\Models\Curso;
use App\Models\NivelEducativo;
use Illuminate\Http\Request;

class CursoController extends Controller
{
    private static function doSearch($sqlColumns, $search, $maxEntriesShow){
        if (!isset($search)){
            $query = Curso::where('estado', '=', '1')->paginate($maxEntriesShow);
        } else {
            $query = Curso::where('estado', '=', '1')
                ->whereAny($sqlColumns, 'LIKE', "%{$search}%")
                ->paginate($maxEntriesShow);    
        }

        return $query;
    }
    public function index(Request $request){
        $sqlColumns = ['id_curso', 'codigo_curso', 'nombre_curso'];
        $resource = 'academica';

        $maxEntriesShow = $request->input('showing', 10);
        $paginaActual = $request->input('page', 1);
        $search = $request->input('search');

        if (!is_numeric($paginaActual) || $paginaActual <= 0) $paginaActual = 1;
        if (!is_numeric($maxEntriesShow) || $maxEntriesShow <= 0) $maxEntriesShow = 10;
        
        $query = CursoController::doSearch($sqlColumns, $search, $maxEntriesShow);

        if ($paginaActual > $query->lastPage()){
            $paginaActual = 1;
            $request['page'] = $paginaActual;
            $query = CursoController::doSearch($sqlColumns, $search, $maxEntriesShow);
        }
        
        $data = [
            'titulo' => 'Cursos',
            'columnas' => [
                'ID',
                'Código del curso',
                'Pertenece al nivel',
                'Nombre del curso'
            ],
            'filas' => [],
            'showing' => $maxEntriesShow,
            'paginaActual' => $paginaActual,
            'totalPaginas' => $query->lastPage(),
            'resource' => $resource,
            'view' => 'curso_view',
            'create' => 'curso_create',
            'edit' => 'curso_edit',
            'delete' => 'curso_delete',
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

        

        foreach ($query as $curso){
            $nivel = NivelEducativo::findOrFail($curso->id_nivel);

            array_push($data['filas'],
            [
                $curso->id_curso,
                $curso->codigo_curso,
                $nivel->nombre_nivel,
                $curso->nombre_curso,
            ]); 
        }
        return view('gestiones.curso.index', compact('data'));
    }

    public function create(Request $request){
        $query = NivelEducativo::where('estado', '=', '1')->get();

        $valores = [];
        $niveles = []; 
        foreach($query as $nivel){
            array_push($valores, $nivel->id_nivel);
            array_push($niveles, $nivel->nombre_nivel);
        }

        $data = [
            'niveles' => $niveles,
            'valores' => $valores,
            'return' => route('curso_view', ['abort' => true]),
        ];

        return view('gestiones.curso.create', compact('data'));
    }

    public function createNewEntry(Request $request){

        $nivel = $request->input('nivel_educativo');
        $codigoCurso = $request->input('código_del_curso');
        $nombreCurso = $request->input('nombre_del_curso');
        
        $request->validate([
            'nivel_educativo' => 'required|max:10',
            'código_del_curso' => 'required|max:10',
            'nombre_del_curso' => 'required|max:100'
        ],[
            'nivel_educativo.required' => 'Seleccione un nivel educativo válido.',
            'código_del_curso.required' => 'Ingrese un código del curso válido.',
            'nombre_del_curso.required' => 'Ingrese un nombre del curso válido.',
            'nivel_educativo.max' => 'El ID del nivel educativo no puede superar los 10 dígitos.',
            'código_del_curso.max' => 'El código del curso no puede superar los 10 dígitos.',
            'nombre_del_curso.max' => 'El nombre del curso no puede superar los 100 caracteres.'
        ]);

        Curso::create(
            [
            'id_nivel' => $nivel,
            'codigo_curso' => $codigoCurso,
            'nombre_curso' => $nombreCurso
        ]);

        return redirect(route('curso_view', ['created' => true]));
    }

    public function edit(Request $request, $id){
        if (!isset($id)){
            return redirect(route('curso_view'));
        }

        $requested = Curso::findOrFail($id);

        $query = NivelEducativo::where('estado', '=', '1')->get();

        $valores = [];
        $niveles = []; 
        foreach($query as $nivel){
            array_push($valores, $nivel->id_nivel);
            array_push($niveles, $nivel->nombre_nivel);
        }

        $data = [
            'return' => route('curso_view', ['abort' => true]),
            'id' => $id,
            'niveles' => $niveles,
            'valores' => $valores,
            'default' => [
                'nivel_educativo' => $requested->id_nivel,
                'código_del_curso' => $requested->codigo_curso,
                'nombre_del_curso' => $requested->nombre_curso
            ]
        ];
        return view('gestiones.curso.edit', compact('data'));
    }

    public function editEntry(Request $request, $id){
        if (!isset($id)){
            return redirect(route('nivel_educativo_view'));
        }

        $request->validate([
            'nivel_educativo' => 'required|max:10',
            'código_del_curso' => 'required|max:10',
            'nombre_del_curso' => 'required|max:100'
        ],[
            'nivel_educativo.required' => 'Seleccione un nivel educativo válido.',
            'código_del_curso.required' => 'Ingrese un código del curso válido.',
            'nombre_del_curso.required' => 'Ingrese un nombre del curso válido.',
            'nivel_educativo.max' => 'El ID del nivel educativo no puede superar los 10 dígitos.',
            'código_del_curso.max' => 'El código del curso no puede superar los 10 dígitos.',
            'nombre_del_curso.max' => 'El nombre del curso no puede superar los 100 caracteres.'
        ]);

        $requested = Curso::where('id_curso', '=', $id);

        if (isset($requested)){
            $newNivelEducativo = $request->input('nivel_educativo');
            $newCodigoCurso = $request->input('código_del_curso');
            $newNombreCurso = $request->input('nombre_del_curso');

            $requested->update(['id_nivel' => $newNivelEducativo, 'codigo_curso' => $newCodigoCurso, 'nombre_curso' => $newNombreCurso]);
        }

        return redirect(route('curso_view', ['edited' => true]));
    }

    public function delete(Request $request){
        $id = $request->input('id');

        $requested = Curso::where('id_curso', '=', $id);
        $requested->delete();

        return redirect(route('curso_view', ['deleted' => true]));
    }
}

