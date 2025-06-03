<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Alumno;

class AlumnoController extends Controller
{
    private static function doSearch($sqlColumns, $search, $maxEntriesShow) {
        if (!isset($search)) {
            $query = Alumno::where('estado', '=', '1')->paginate($maxEntriesShow);
        } else {
            $query = Alumno::where('estado', '=', '1')
                ->whereAny($sqlColumns, 'LIKE', "%{$search}%")
                ->paginate($maxEntriesShow);
        }

        return $query;
    }

    public function index(Request $request) {
        $sqlColumns = ['id_alumno','codigo_educando', 'dni', 'apellido_paterno', 'apellido_materno', 'primer_nombre', 'otros_nombres', 'sexo'];
        $resource = 'alumnos';

        $maxEntriesShow = $request->input('showing', 10);
        $paginaActual = $request->input('page', 1);
        $search = $request->input('search');

        if (!is_numeric($paginaActual) || $paginaActual <= 0) $paginaActual = 1;
        if (!is_numeric($maxEntriesShow) || $maxEntriesShow <= 0) $maxEntriesShow = 10;

        $query = AlumnoController::doSearch($sqlColumns, $search, $maxEntriesShow);

        if ($paginaActual > $query->lastPage()) {
            $paginaActual = 1;
            $request['page'] = $paginaActual;
            $query = AlumnoController::doSearch($sqlColumns, $search, $maxEntriesShow);
        }

        $data = [
            'titulo' => 'Alumnos',
            'columnas' => [
                'ID',
                'Código Educando',
                'DNI',
                'Apellidos',
                'Nombres',
                'Sexo',

            ],
            'filas' => [],
            'showing' => $maxEntriesShow,
            'paginaActual' => $paginaActual,
            'totalPaginas' => $query->lastPage(),
            'resource' => $resource,
            'view' => 'alumno_view',
            'create' => 'alumno_create',
            'edit' => 'alumno_edit',
            'delete' => 'alumno_delete',
        ];

        if ($request->input("created", false)) {
            $data['created'] = $request->input('created');
        }

        if ($request->input("edited", false)) {
            $data['edited'] = $request->input('edited');
        }

        if ($request->input("abort", false)) {
            $data['abort'] = $request->input('abort');
        }

        if ($request->input("deleted", false)) {
            $data['deleted'] = $request->input('deleted');
        }

        foreach ($query as $alumno) {
            $apellidos = trim($alumno->apellido_paterno . ' ' . $alumno->apellido_materno);
            $nombres = trim($alumno->primer_nombre. ' '.$alumno->otros_nombres);
            array_push($data['filas'], [
                $alumno->id_alumno,
                $alumno->codigo_educando,
                $alumno->dni,
                $apellidos,
                $nombres,
                $alumno->sexo,
            ]);
        }

        return view('gestiones.alumno.index', compact('data'));
    }

    public function create(Resquest $request) {
        $data = [
            'return' => route('alumno_view', ['abort' => true]),
        ];

        return view('gestiones.alumno.create', compact('data'));
    }

    public function createNewEntry(Request $request) {
        $request -> validate([
            'codigo_modular' => 'required|string|max:20',
            'codigo_educando' => 'required|string|max:20',
            'año_ingreso' => 'required|integer|min:1900|max:'.date('Y'),
            'dni' => 'required|string|max:8',
            'apellido_paterno' => 'required|string|max:50',
            'apellido_materno' => 'required|string|max:50',
            'primer_nombre' => 'required|string|max:50',
            'otros_nombres' => 'nullable|string|max:50',
            'sexo' => 'required|in:M,F',
            'fecha_nacimiento' => 'required|date',
            'pais' => 'required|string|max:20',
            'departamento' => 'required|string|max:40',
            'provincia' => 'required|string|max:40',
            'distrito' => 'required|string|max:40',
            'lengua_materna' => 'required|string|max:50',
            'estado_civil' => 'required|in:S,C,V,D',
            'religion' => 'nullable|string|max:50',
            'fecha_bautizo' => 'nullable|date',
            'parroquia_bautizo' => 'nullable|string|max:100',
            'colegio_procedencia' => 'nullable|string|max:100',
            'direccion' => 'required|string|max:255',
            'telefono' => 'nullable|string|max:20',
            'medio_transporte' => 'required|string|max:50',
            'tiempo_demora' => 'required|string|max:20',
            'material_vivienda' => 'required|string|max:100',
            'energia_electrica' => 'required|string|max:100',
            'agua_potable' => 'nullable|string|max:100',
            'desague' => 'nullable|string|max:100',
            'ss_hh' => 'nullable|string|max:100',
            'num_habitaciones' => 'nullable|integer|min:1|max:11',
            'num_habitantes' => 'nullable|integer|min:1|max:11',
            'situacion_vivienda' => 'required|string|max:100',
            'escala' => 'nullable|in:A,B,C,D',
        ], [
            'codigo_modular.required' => 'Ingrese un codigo valido.',
            'codigo_educando.required' => 'Ingrese un codigo valido.',
            'año_ingreso.required' => 'El año de ingreso es obligatorio.',
            'dni.required' => 'Ingrese un DNI válido.',
            'apellido_paterno.required' => 'Ingrese un apellido paterno válido.',
            'apellido_materno.required' => 'Ingrese un apellido materno válido.',
            'primer_nombre.required' => 'Ingrese un primer nombre válido.',
            'sexo.required' => 'El campo sexo, es obligatorio.',
            'fecha_nacimiento.required' => 'Ingrese una fecha de nacimiento válida.',
            'pais.required' => 'Ingrese un país válido.',
            'departamento.required' => 'Ingrese un departamento válido.',
            'provincia.required' => 'Ingrese una provincia válida.',
            'distrito.required' => 'Ingrese un distrito válido.',
            'lengua_materna.required' => 'Ingrese una lengua materna válida.',
            'estado_civil.required' => 'El estado civil es obligatorio.',
            'religion.max' => 'La religión no puede superar los 50 caracteres.',
            'fecha_bautizo.date' => 'Ingrese una fecha de bautizo válida.',
            'parroquia_bautizo.max' => 'La parroquia de bautizo no puede superar los 100 caracteres.',
            'colegio_procedencia.max' => 'El colegio de procedencia no puede superar los 100 caracteres.',
            'direccion.required' => 'Ingrese una dirección válida.',
            'telefono.max' => 'El teléfono no puede superar los 20 caracteres.',
            'medio_transporte.required' => 'Ingrese un medio de transporte válido.',
            'tiempo_demora.required' => 'Ingrese un tiempo de demora válido.',
            'material_vivienda.required' => 'Ingrese un material de vivienda válido.',
            'energia_electrica.required' => 'Ingrese una fuente de energía eléctrica válida.',
            'escala.in' => 'La escala debe ser A, B, C o D.',
        ]);

        $codigoModular = $request->input('codigo_modular');
        $codigoEducando = $request->input('codigo_educando');
        $añoIngreso = $request->input('año_ingreso');
        $dni = $request->input('dni');
        $apellidoPaterno = $request->input('apellido_paterno');
        $apellidoMaterno = $request->input('apellido_materno');
        $primerNombre = $request->input('primer_nombre');
        $otrosNombres = $request->input('otros_nombres', '');
        $sexo = $request->input('sexo');
        $fechaNacimiento = $request->input('fecha_nacimiento');
        $pais = $request->input('pais');
        $departamento = $request->input('departamento');
        $provincia = $request->input('provincia');
        $distrito = $request->input('distrito');
        $lenguaMaterna = $request->input('lengua_materna');
        $estadoCivil = $request->input('estado_civil');
        $religion = $request->input('religion', '');
        $fechaBautizo = $request->input('fecha_bautizo', null);
        $parroquiaBautizo = $request->input('parroquia_bautizo', '');
        $colegioProcedencia = $request->input('colegio_procedencia', '');
        $direccion = $request->input('direccion');
        $telefono = $request->input('telefono', '');
        $medioTransporte = $request
            ->input('medio_transporte');
        $tiempoDemora = $request->input('tiempo_demora', '');
        $materialVivienda = $request->input('material_vivienda');
        $energiaElectrica = $request->input('energia_electrica');
        $aguaPotable = $request->input('agua_potable', '');
        $desague = $request->input('desague', '');
        $ss_hh = $request->input('ss_hh', '');
        $numHabitaciones = $request->input('num_habitaciones', null);
        $numHabitantes = $request->input('num_habitantes', null);
        $situacionVivienda = $request->input('situacion_vivienda');
        $escala = $request->input('escala', null);


        Alumno::create([
            'codigo_modular' => $codigoModular,
            'codigo_educando' => $codigoEducando,
            'año_ingreso' => $añoIngreso,
            'dni' => $dni,
            'apellido_paterno' => $apellidoPaterno,
            'apellido_materno' => $apellidoMaterno,
            'primer_nombre' => $primerNombre,
            'otros_nombres' => $otrosNombres,
            'sexo' => $sexo,
            'fecha_nacimiento' => $fechaNacimiento,
            'pais' => $pais,
            'departamento' => $departamento,
            'provincia' => $provincia,
            'distrito' => $distrito,
            'lengua_materna' => $lenguaMaterna,
            'estado_civil' => $estadoCivil,
            'religion' => $religion,
            'fecha_bautizo' => $fechaBautizo,
            'parroquia_bautizo' => $parroquiaBautizo,
            'colegio_procedencia' => $colegioProcedencia,
            'direccion' => $direccion,
            'telefono' => $telefono,
            'medio_transporte' => $medioTransporte,
            'tiempo_demora' => $tiempoDemora,
            'material_vivienda' => $materialVivienda,
            'energia_electrica' => $energiaElectrica,
            'agua_potable' => $aguaPotable,
            'desague' => $desague,
            'ss_hh' => $ss_hh,
            'num_habitaciones' => $numHabitaciones,
            'num_habitantes' => $numHabitantes,
            'situacion_vivienda' => $situacionVivienda,
            'escala' => $escala
        ]);

        return redirect(route('alumno_view', ['created'=>true]));
    }

    public function edit(Request $request, $id) {
        if (!isset($id)) {
            return redirect(route('alumno_view'));
        }

        $requested = Alumno::findOrFail($id);

        $data = [
            'return' => route('alumno_view', ['abort' => true]),
            'id' => $id,
            'default' => [
                'codigo_modular' => $requested->codigo_modular,
                'codigo_educando' => $requested->codigo_educando,
                'año_ingreso' => $requested->año_ingreso,
                'dni' => $requested->dni,
                'apellido_paterno' => $requested->apellido_paterno,
                'apellido_materno' => $requested->apellido_materno,
                'primer_nombre' => $requested->primer_nombre,
                'otros_nombres' => $requested->otros_nombres,
                'sexo' => $requested->sexo,
                'fecha_nacimiento' => $requested->fecha_nacimiento,
                'pais' => $requested->pais,
                'departamento' => $requested->departamento,
                'provincia' => $requested->provincia,
                'distrito' => $requested->distrito,
                'lengua_materna' => $requested->lengua_materna,
                'estado_civil' => $requested->estado_civil,
                'religion' => $requested->religion,
                'fecha_bautizo' => $requested->fecha_bautizo,
                'parroquia_bautizo' => $requested->parroquia_bautizo,
                'colegio_procedencia' => $requested->colegio_procedencia,
                'direccion' => $requested->direccion,
                'telefono' => $requested->telefono,
                'medio_transporte' => $requested->medio_transporte,
                'tiempo_demora' => $requested->tiempo_demora,
                'material_vivienda' => $requested->material_vivienda,
                'energia_electrica' => $requested->energia_electrica,
                'agua_potable' => $requested->agua_potable,
                'desague' => $requested->desague,
                'ss_hh' => $requested->ss_hh,
                'num_habitaciones' => $requested->num_habitaciones,
                'num_habitantes' => $requested->num_habitantes,
                'situacion_vivienda' => $requested->situacion_vivienda,
                'escala' => $requested->escala,
            ]
        ];
        return view('gestiones.alumno.edit', compact('data'));
    }

    public function editEntry(Request $request, $id) {
        if (!isset($id)) {
            return redirect(route('alumno_view'));
        }

        $requested = Alumno::where('id_alumno', '=', $id);

        if (isset($requested)) {
            $newCodigoModular = $request->input('codigo_modular');
            $newCodigoEducando = $request->input('codigo_educando');
            $newAñoIngreso = $request->input('año_ingreso');
            $newDni = $request->input('dni');
            $newApellidoPaterno = $request->input('apellido_paterno');
            $newApellidoMaterno = $request->input('apellido_materno');
            $newPrimerNombre = $request->input('primer_nombre');
            $newOtrosNombres = $request->input('otros_nombres', '');
            $newSexo = $request->input('sexo');
            $newFechaNacimiento = $request->input('fecha_nacimiento');
            $newPais = $request->input('pais');
            $newDepartamento = $request->input('departamento');
            $newProvincia = $request->input('provincia');
            $newDistrito = $request->input('distrito');
            $newLenguaMaterna = $request->input('lengua_materna');
            $newEstadoCivil = $request->input('estado_civil');
            $newReligion = $request->input('religion', '');
            $newFechaBautizo = $request->input('fecha_bautizo', null);
            $newParroquiaBautizo = $request->input('parroquia_bautizo', '');
            $newColegioProcedencia = $request->input('colegio_procedencia', '');
            $newDireccion = $request->input('direccion');
            $newTelefono = $request->input('telefono', '');
            $newMedioTransporte = 	$request->input('medio_transporte');
            $newTiempoDemora = 	$request->input('tiempo_demora', '');
            $newMaterialVivienda = 	$request->input('material_vivienda');
            $newEnergiaElectrica = 	$request->input('energia_electrica');
            $newAguaPotable = 	$request->input('agua_potable', '');
            $newDesague = $request->input('desague', '');
            $newSs_hh = $request->input('ss_hh', '');
            $newNumHabitaciones = $request->input('num_habitaciones', null);
            $newNumHabitantes = $request->input('num_habitantes', null);
            $newSituacionVivienda = $request->input('situacion_vivienda');
            $newEscala = $request->input('escala', null);

            $requested -> update(['codigo_modular' => $newCodigoModular,
                'codigo_educando' => $newCodigoEducando,
                'año_ingreso' => $newAñoIngreso,
                'dni' => $newDni,
                'apellido_paterno' => $newApellidoPaterno,
                'apellido_materno' => $newApellidoMaterno,
                'primer_nombre' => $newPrimerNombre,
                'otros_nombres' => $newOtrosNombres,
                'sexo' => $newSexo,
                'fecha_nacimiento' => $newFechaNacimiento,
                'pais' => $newPais,
                'departamento' => $newDepartamento,
                'provincia' => $newProvincia,
                'distrito' => $newDistrito,
                'lengua_materna' => $newLenguaMaterna,
                'estado_civil' => $newEstadoCivil,
                'religion' => $newReligion,
                'fecha_bautizo' => $newFechaBautizo,
                'parroquia_bautizo' => $newParroquiaBautizo,
                'colegio_procedencia' => $newColegioProcedencia,
                'direccion' => $newDireccion,
                'telefono' => $newTelefono,
                'medio_transporte' => $newMedioTransporte,
                'tiempo_demora' => $newTiempoDemora,
                'material_vivienda' => $newMaterialVivienda,
                'energia_electrica' => $newEnergiaElectrica,
                'agua_potable' => $newAguaPotable,
                'desague' => $newDesague,
                'ss_hh' => $newSs_hh,
                'num_habitaciones' => $newNumHabitaciones,
                'num_habitantes' => $newNumHabitantes,
                'situacion_vivienda' => $newSituacionVivienda,
                'escala' => $newEscala]);

        }

        return redirect(route('alumno_view', ['edited' => true]));
    }


    public function delete(Request $request) {
        $id = $request->input('id');

        $requested = Alumno::where('id_alumno', '=', $id);
        $requested->delete();

        return redirect(route('alumno_view', ['deleted' => true]));
    }


}
