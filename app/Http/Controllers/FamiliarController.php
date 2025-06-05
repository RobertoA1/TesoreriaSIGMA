<?php
namespace App\Http\Controllers;

use App\Models\Familiar;
use App\Models\User;

use App\Models\Alumno;
use Illuminate\Http\Request;

class FamiliarController extends Controller
{
    private static function doSearch($sqlColumns, $search, $maxEntriesShow){
        if (!isset($search)){
            $query = Familiar::where('estado', '=', '1')->paginate($maxEntriesShow);
        } else {
            $query = Familiar::where('estado', '=', '1')
                ->whereAny($sqlColumns, 'LIKE', "%{$search}%")
                ->paginate($maxEntriesShow);    
        }
        return $query;
    }


    public function index(Request $request){
        $sqlColumns = ['idFamiliar','dni','apellido_paterno','apellido_materno', 'primer_nombre', 'otros_nombres','numero_contacto','correo_electronico'];
        $resource = 'alumnos';

        $maxEntriesShow = $request->input('showing', 10);
        $paginaActual = $request->input('page', 1);
        $search = $request->input('search');

        if (!is_numeric($paginaActual) || $paginaActual <= 0) $paginaActual = 1;
        if (!is_numeric($maxEntriesShow) || $maxEntriesShow <= 0) $maxEntriesShow = 10;

        $query = FamiliarController::doSearch($sqlColumns, $search, $maxEntriesShow);

        if ($paginaActual > $query->lastPage()){
            $paginaActual = 1;
            $request['page'] = $paginaActual;
            $query = FamiliarController::doSearch($sqlColumns, $search, $maxEntriesShow);
        }

        $data = [
            'titulo' => 'Familiares',
            'columnas' => [
                'ID',
                'DNI',
                'Apellidos',
                'Nombres',
                'Contacto',
                'Correo',
            ],
            'filas' => [],
            'showing' => $maxEntriesShow,
            'paginaActual' => $paginaActual,
            'totalPaginas' => $query->lastPage(),
            'resource' => $resource,
            'view' => 'familiar_view',
            'create' => 'familiar_create',
            'edit' => 'familiar_edit',
            'delete' => 'familiar_delete',
            'show_route' => 'familiar_detalles',
            'show_text' => 'Ver Alumnos',
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

        foreach ($query as $familiar){
            $familiar = Familiar::findOrFail($familiar->idFamiliar);
 

            array_push($data['filas'],
            [
                $familiar->idFamiliar,  
                $familiar->dni,
                $familiar->apellido_paterno . ' ' . $familiar->apellido_materno,
                $familiar->primer_nombre . ' ' . $familiar->otros_nombres,
                $familiar->numero_contacto,
                $familiar->correo_electronico,
            ]);
        }

        return view('gestiones.familiar.index', compact('data'));

    }

    public function create(Request $request){
        $usuarios = User::all();
        $alumnos = Alumno::all();
        $data = [
            'return' => route('familiar_view', ['abort' => true]),
            'usuarios' => $usuarios,
            'alumnos' => $alumnos,
        ];
        return view('gestiones.familiar.create', compact('data'));
    }

    public function createNewEntry(Request $request)
    {
        $request->validate([
        'dni' => 'required|string|max:20',
        'apellido_paterno' => 'required|string|max:50',
        'apellido_materno' => 'required|string|max:50',
        'primer_nombre' => 'required|string|max:50',
        'otros_nombres' => 'nullable|string|max:100',
        'numero_contacto' => 'nullable|string|max:20',
        'correo_electronico' => 'nullable|email|max:100',
    ], [
        'dni.required' => 'Ingrese un DNI válido.',
        'apellido_paterno.required' => 'Ingrese el apellido paterno.',
        'apellido_materno.required' => 'Ingrese el apellido materno.',
        'primer_nombre.required' => 'Ingrese el primer nombre.',
    ]);

    $id_usuario = null;

    if ($request->has('crear_usuario')) {
        $user = User::create([
            'name' => $request->primer_nombre . ' ' . $request->apellido_paterno,
            'username' => $request->dni, 
            'tipo' => 'Familiar',
            'email' => $request->correo_electronico ?? uniqid('familiar')."@mail.com",
            'password' => bcrypt('12345678'),
        ]);
        $id_usuario = $user->id_usuario;
    }

    $familiar = Familiar::create($request->only([
        'id_usuario' => $id_usuario,
        'dni',
        'apellido_paterno',
        'apellido_materno',
        'primer_nombre',
        'otros_nombres',
        'numero_contacto',
        'correo_electronico',
    ]));

    // Sincroniza alumnos y parentesco si se envían
    if ($request->has('alumnos')) {
        $syncData = [];
        foreach ($request->input('alumnos') as $id_alumno => $parentesco) {
            $syncData[$id_alumno] = ['parentesco' => $parentesco];
        }
        $familiar->alumnos()->sync($syncData);
    }

    return redirect(route('familiar_view', ['created' => true]));

    }

    public function edit(Request $request, $id)
    {
        if (!isset($id)) {
            return redirect(route('familiar_view'));
        }

        $familiar = Familiar::findOrFail($id);
        $usuarios = User::all();

        $data = [
            'return' => route('familiar_view', ['abort' => true]),
            'id' => $id,
            'familiar' => $familiar,
            'usuarios' => $usuarios,
        ];

        return view('gestiones.familiar.edit', compact('data'));
    }

    public function editEntry(Request $request, $id)
        {
            if (!isset($id)) {
                return redirect(route('familiar_view'));
            }



        $familiar = Familiar::findOrFail($id);
        $familiar->update($request->only([
            'apellido_paterno',
            'apellido_materno',
            'primer_nombre',
            'otros_nombres',
            'numero_contacto',
            'correo_electronico',
        ]));

        if ($request->has('alumnos')) {
            $syncData = [];
            foreach ($request->input('alumnos') as $id_alumno => $parentesco) {
                $syncData[$id_alumno] = ['parentesco' => $parentesco];
            }
            $familiar->alumnos()->sync($syncData);
        }

        return redirect(route('familiar_view', ['edited' => true]));
    }

    public function delete(Request $request)
    {
        $id = $request->input('id');
        $familiar = Familiar::where('idFamiliar', $id)->firstOrFail();
        $familiar->alumnos()->detach();
        $familiar->delete();

        return redirect(route('familiar_view', ['deleted' => true]));
    }


    public function viewDetalles($id)
        {
            if (!isset($id)){
                return redirect(route('familiar_view'));
            }

            $familiar = Familiar::with(['alumnos'])->findOrFail($id);

            // Prepara los datos para la tabla de alumnos asociados
            $titulo = "Alumnos asociados";
            $columnas = ['ID', 'Nombres', 'Apellidos', 'DNI', 'Parentesco'];
            $filas = [];
            foreach($familiar->alumnos as $alumno) {
                $filas[] = [
                    $alumno->id_alumno,
                    $alumno->primer_nombre . ' ' . $alumno->otros_nombres,
                    $alumno->apellido_paterno . ' ' . $alumno->apellido_materno,
                    $alumno->dni,
                    $alumno->pivot->parentesco, // <-- parentesco desde la tabla pivote
                ];
            }
            $resource = 'alumnos';
            $create = null;
            $showing = 10;
            $paginaActual = 1;
            $totalPaginas = 1;

            return view('gestiones.familiar.detalles', compact(
                'familiar', 'titulo', 'columnas', 'filas', 'resource', 'create', 'showing', 'paginaActual', 'totalPaginas'
            ));
        }

}