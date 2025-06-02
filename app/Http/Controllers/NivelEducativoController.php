<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\NivelEducativo;

class NivelEducativoController extends Controller
{
    public function index(Request $request){
        $sqlColumns = ['nombre_nivel', 'descripcion'];
        $resource = 'academica';

        $maxEntriesShow = $request->input('showing') ?? 10;
        $paginaActual = $request->input('page') ?? 1;
        $search = $request->input('search');

        if (!is_numeric($paginaActual)) $paginaActual = 1;
        if (!is_numeric($maxEntriesShow)) $maxEntriesShow = 10;

        if (!isset($search)){
            $query = NivelEducativo::where('estado', '=', '1')->paginate($maxEntriesShow);
        } else {
            $query = NivelEducativo::where('estado', '=', '1')
                ->whereAny($sqlColumns, 'LIKE', "%{$search}%")
                ->paginate($maxEntriesShow);
        }
        
        $data = [
            'titulo' => 'Niveles Educativos',
            'columnas' => [
                'Nivel',
                'Descripción'
            ],
            'filas' => [],
            'showing' => $maxEntriesShow,
            'paginaActual' => $paginaActual,
            'totalPaginas' => $query->lastPage(),
            'resource' => $resource,
            'view' => route('nivel_educativo_view'),
            'create' => route('nivel_educativo_create'),
            'edit' => route('nivel_educativo_edit'),
            'delete' => route('nivel_educativo_delete'),
        ];

        foreach ($query as $nivel){
            array_push($data['filas'],
            [
                $nivel->nombre_nivel,
                $nivel->descripcion
            ]); 
        }
        return view('gestiones.nivel_educativo.index', compact('data'));
    }

    public function create(Request $request){
        $data = [
            'titulo' => 'Niveles Educativos | Crear',
            'columnas' => [
                'Nivel',
                'Descripción'
            ],
            'filas' => [],
        ];
        return view('gestiones.nivel_educativo.create', compact('data'));
    }
}
