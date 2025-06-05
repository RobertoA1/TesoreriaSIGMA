<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\NivelEducativo;

class NivelEducativoController extends Controller
{
    private static function doSearch($sqlColumns, $search, $maxEntriesShow){
        if (!isset($search)){
            $query = NivelEducativo::where('estado', '=', '1')->paginate($maxEntriesShow);
        } else {
            $query = NivelEducativo::where('estado', '=', '1')
                ->whereAny($sqlColumns, 'LIKE', "%{$search}%")
                ->paginate($maxEntriesShow);    
        }

        return $query;
    }
    public function index(Request $request){
        $sqlColumns = ['id_nivel', 'nombre_nivel', 'descripcion'];
        $resource = 'academica';

        $maxEntriesShow = $request->input('showing', 10);
        $paginaActual = $request->input('page', 1);
        $search = $request->input('search');

        if (!is_numeric($paginaActual) || $paginaActual <= 0) $paginaActual = 1;
        if (!is_numeric($maxEntriesShow) || $maxEntriesShow <= 0) $maxEntriesShow = 10;
        
        $query = NivelEducativoController::doSearch($sqlColumns, $search, $maxEntriesShow);

        if ($paginaActual > $query->lastPage()){
            $paginaActual = 1;
            $request['page'] = $paginaActual;
            $query = NivelEducativoController::doSearch($sqlColumns, $search, $maxEntriesShow);
        }
        
        $data = [
            'titulo' => 'Niveles Educativos',
            'columnas' => [
                'ID',
                'Nivel',
                'Descripción'
            ],
            'filas' => [],
            'showing' => $maxEntriesShow,
            'paginaActual' => $paginaActual,
            'totalPaginas' => $query->lastPage(),
            'resource' => $resource,
            'view' => 'nivel_educativo_view',
            'create' => 'nivel_educativo_create',
            'edit' => 'nivel_educativo_edit',
            'delete' => 'nivel_educativo_delete',
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

        foreach ($query as $nivel){
            array_push($data['filas'],
            [
                $nivel->id_nivel,
                $nivel->nombre_nivel,
                $nivel->descripcion
            ]); 
        }
        return view('gestiones.nivel_educativo.index', compact('data'));
    }

    public function create(Request $request){
        $data = [
            'return' => route('nivel_educativo_view', ['abort' => true]),
        ];

        return view('gestiones.nivel_educativo.create', compact('data'));
    }

    public function createNewEntry(Request $request){
        $request->validate([
            'nombre' => 'required|max:50',
            'descripción' => 'required|max:255'
        ],[
            'nombre.required' => 'Ingrese un nombre válido.',
            'descripción.required' => 'Ingrese una descripción válida.',
            'nombre.max' => 'El nombre no puede superar los 50 caracteres.',
            'descripción.max' => 'La descripción no puede superar los 255 caracteres.'
        ]);

        $nombre = $request->input('nombre');
        $descripcion = $request->input('descripción');

        NivelEducativo::create([
            'nombre_nivel' => $nombre,
            'descripcion' => $descripcion
        ]);

        return redirect(route('nivel_educativo_view', ['created' => true]));
    }

    public function edit(Request $request, $id){
        if (!isset($id)){
            return redirect(route('nivel_educativo_view'));
        }

        $requested = NivelEducativo::find($id);

        $data = [
            'return' => route('nivel_educativo_view', ['abort' => true]),
            'id' => $id,
            'default' => [
                'nombre' => $requested->nombre_nivel,
                'descripción' => $requested->descripcion,
            ]
        ];
        return view('gestiones.nivel_educativo.edit', compact('data'));
    }

    public function editEntry(Request $request, $id){
        if (!isset($id)){
            return redirect(route('nivel_educativo_view'));
        }

        $requested = NivelEducativo::find($id);

        if (isset($requested)){
            $newNombre = $request->input('nombre');
            $newDescripcion = $request->input('descripción');

            $requested->update(['nombre_nivel' => $newNombre, 'descripcion' => $newDescripcion]);
        }

        return redirect(route('nivel_educativo_view', ['edited' => true]));
    }

    public function delete(Request $request){
        $id = $request->input('id');

        $requested = NivelEducativo::find($id);
        $requested->delete();

        return redirect(route('nivel_educativo_view', ['deleted' => true]));
    }
}
