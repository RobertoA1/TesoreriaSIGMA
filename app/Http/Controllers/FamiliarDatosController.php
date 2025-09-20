<?php

namespace App\Http\Controllers;

use App\Helpers\CRUDTablePage;
use App\Helpers\Home\Familiar\FamiliarSidebarComponent;
use App\Helpers\Tables\CRUDTableComponent;
use App\Helpers\Tables\ViewBasedComponent;
use App\Http\Controllers\Home\Utils;
use Illuminate\Http\Request;

class FamiliarDatosController extends Controller
{
    public static function index(Request $request){
        $requested = $request->session()->get('alumno');

        $alumnoSesion = session('alumno');

        if ($requested == null){
            return redirect(route('principal'));
        }
        
        $header = Utils::crearHeaderConAlumnos($request);

        $page = CRUDTablePage::new()
            ->title("Datos de Alumno")
            ->header($header)
            ->sidebar(new FamiliarSidebarComponent());

        $sexos = [
            ['id' => 'M', 'descripcion' => 'Masculino'],
            ['id' => 'F', 'descripcion' => 'Femenino']
        ];

        $estadosciviles = [
            ['id' => 'C', 'descripcion' => 'Casado'],
            ['id' => 'S', 'descripcion' => 'Soltero'],
            ['id' => 'V', 'descripcion' => 'Viudo'],
            ['id' => 'D', 'descripcion' => 'Divorciado']
        ];

        $escalas = [
            ['id' => 'A', 'descripcion' => 'A'],
            ['id' => 'B', 'descripcion' => 'B'],
            ['id' => 'C', 'descripcion' => 'C'],
            ['id' => 'D', 'descripcion' => 'D'],
            ['id' => 'E', 'descripcion' => 'E'],
        ];

        $lenguasmaternas = [
            ['id' => 'Castellano', 'descripcion' => 'Castellano'],
            ['id' => 'Quechua', 'descripcion' => 'Quechua'],
            ['id' => 'Aymara', 'descripcion' => 'Aymara'],
            ['id' => 'Ashaninka', 'descripcion' => 'Asháninka'],
            ['id' => 'Shipibo-Konibo', 'descripcion' => 'Shipibo-Konibo'],
            ['id' => 'Awajun', 'descripcion' => 'Awajún'],
            ['id' => 'Achuar', 'descripcion' => 'Achuar'],
            ['id' => 'Shawi', 'descripcion' => 'Shawi'],
            ['id' => 'Matsigenka', 'descripcion' => 'Matsigenka'],
            ['id' => 'Yanesha', 'descripcion' => 'Yánesha'],
            ['id' => 'Otro', 'descripcion' => 'Otro']
        ];


        $ubigeo = json_decode(file_get_contents(resource_path('data/ubigeo_peru.json')), true);
        $paises = $ubigeo['paises'];
        $departamentos = $ubigeo['departamentos'];
        $provincias = $ubigeo['provincias'];
        $distritos = $ubigeo['distritos'];

        $data = [
            'return' => route('principal'),
            'id' => $requested->getKey(),
            'sexos' => $sexos,
            'paises' => $paises,
            'provincias' => $provincias,
            'distritos' => $distritos,
            'departamentos' => $departamentos,
            'estadosciviles' => $estadosciviles,
            'lenguasmaternas' => $lenguasmaternas,
            'escalas' => $escalas,
            'default' => [
                'foto_url' => $requested->foto_url,
                'codigo_educando' => $requested->codigo_educando,
                'codigo_modular' => $requested->codigo_modular,
                'año_ingreso' => $requested->año_ingreso,
                'd_n_i' => $requested->dni,
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
                'parroquia_de_bautizo' => $requested->parroquia_bautizo,
                'colegio_de_procedencia' => $requested->colegio_procedencia,
                'direccion' => $requested->direccion,
                'telefono' => $requested->telefono,
                'medio_de_transporte' => $requested->medio_transporte,
                'tiempo_de_demora' => $requested->tiempo_demora,
                'material_vivienda' => $requested->material_vivienda,
                'energia_electrica' => $requested->energia_electrica,
                'agua_potable' => $requested->agua_potable,
                'desague' => $requested->desague,
                's_s__h_h' => $requested->ss_hh,
                'numero_de_habitaciones' => $requested->num_habitaciones,
                'numero_de_habitantes' => $requested->num_habitantes,
                'situacion_de_vivienda' => $requested->situacion_vivienda,
                'escala' => $requested->escala,
            ]
        ];
        $content = new ViewBasedComponent('homev2.familiares.datos_view', compact('data'));
        $page->content($content);
        return $page->render();
    }

    public static function edit(Request $request){

         $requested = $request->session()->get('alumno');

        if ($requested == null){
            return redirect(route('principal'));
        }

        $header = Utils::crearHeaderConAlumnos($request);

        $page = CRUDTablePage::new()
            ->title("Editar Alumno")
            ->header($header)
            ->sidebar(new FamiliarSidebarComponent());

        $sexos = [
            ['id' => 'M', 'descripcion' => 'Masculino'],
            ['id' => 'F', 'descripcion' => 'Femenino']
        ];

        $estadosciviles = [
            ['id' => 'C', 'descripcion' => 'Casado'],
            ['id' => 'S', 'descripcion' => 'Soltero'],
            ['id' => 'V', 'descripcion' => 'Viudo'],
            ['id' => 'D', 'descripcion' => 'Divorciado']
        ];

        $escalas = [
            ['id' => 'A', 'descripcion' => 'A'],
            ['id' => 'B', 'descripcion' => 'B'],
            ['id' => 'C', 'descripcion' => 'C'],
            ['id' => 'D', 'descripcion' => 'D'],
            ['id' => 'E', 'descripcion' => 'E'],
        ];

        $lenguasmaternas = [
            ['id' => 'Castellano', 'descripcion' => 'Castellano'],
            ['id' => 'Quechua', 'descripcion' => 'Quechua'],
            ['id' => 'Aymara', 'descripcion' => 'Aymara'],
            ['id' => 'Ashaninka', 'descripcion' => 'Asháninka'],
            ['id' => 'Shipibo-Konibo', 'descripcion' => 'Shipibo-Konibo'],
            ['id' => 'Awajun', 'descripcion' => 'Awajún'],
            ['id' => 'Achuar', 'descripcion' => 'Achuar'],
            ['id' => 'Shawi', 'descripcion' => 'Shawi'],
            ['id' => 'Matsigenka', 'descripcion' => 'Matsigenka'],
            ['id' => 'Yanesha', 'descripcion' => 'Yánesha'],
            ['id' => 'Otro', 'descripcion' => 'Otro']
        ];


        $ubigeo = json_decode(file_get_contents(resource_path('data/ubigeo_peru.json')), true);
        $paises = $ubigeo['paises'];
        $departamentos = $ubigeo['departamentos'];
        $provincias = $ubigeo['provincias'];
        $distritos = $ubigeo['distritos'];


        $data = [
            'return' => route('familiar_dato_view', ['abort' => true]),
            'id' => $requested->id,
            'sexos' => $sexos,
            'paises' => $paises,
            'provincias' => $provincias,
            'distritos' => $distritos,
            'departamentos' => $departamentos,
            'estadosciviles' => $estadosciviles,
            'lenguasmaternas' => $lenguasmaternas,
            'escalas' => $escalas,
            'default' => [
                'foto_url' => $requested->foto_url,
                'codigo_educando' => $requested->codigo_educando,
                'codigo_modular' => $requested->codigo_modular,
                'año_de_ingreso' => $requested->año_ingreso,
                'd_n_i' => $requested->dni,
                'apellido_paterno' => $requested->apellido_paterno,
                'apellido_materno' => $requested->apellido_materno,
                'primer_nombre' => $requested->primer_nombre,
                'otros_nombres' => $requested->otros_nombres,
                'sexo' => $requested->sexo,
                'fecha_nacimiento' => $requested->fecha_nacimiento,
                'país' => $requested->pais,
                'departamento' => $requested->departamento,
                'provincia' => $requested->provincia,
                'distrito' => $requested->distrito,
                'lengua_materna' => $requested->lengua_materna,
                'estado_civil' => $requested->estado_civil,
                'religion' => $requested->religion,
                'fecha_bautizo' => $requested->fecha_bautizo,
                'parroquia_de_bautizo' => $requested->parroquia_bautizo,
                'colegio_de_procedencia' => $requested->colegio_procedencia,
                'direccion' => $requested->direccion,
                'telefono' => $requested->telefono,
                'medio_de_transporte' => $requested->medio_transporte,
                'tiempo_de_demora' => $requested->tiempo_demora,
                'material_vivienda' => $requested->material_vivienda,
                'energia_electrica' => $requested->energia_electrica,
                'agua_potable' => $requested->agua_potable,
                'desague' => $requested->desague,
                's_s__h_h' => $requested->ss_hh,
                'numero_de_habitaciones' => $requested->num_habitaciones,
                'numero_de_habitantes' => $requested->num_habitantes,
                'situacion_de_vivienda' => $requested->situacion_vivienda,
                'escala' => $requested->escala,
            ]
        ];
        $content = new ViewBasedComponent('homev2.familiares.datos_edit', compact('data'));
        $page->content($content);
        return $page->render();
    }

    public function editEntry(Request $request) {

        $requested = $request->session()->get('alumno');

        if ($requested == null){
            return redirect(route('principal'));
        }

        $request -> validate([
            'codigo_modular' => 'required|string|max:20',
            'codigo_educando' => 'required|string|max:20',
            'año_de_ingreso' => 'required|integer|min:1900|max:2100',
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
            'parroquia_de_bautizo' => 'nullable|string|max:100',
            'colegio_de_procedencia' => 'nullable|string|max:100',
            'direccion' => 'required|string|max:255',
            'telefono' => 'nullable|string|max:20',
            'medio_de_transporte' => 'required|string|max:50',
            'tiempo_de_demora' => 'required|string|max:20',
            'material_vivienda' => 'required|string|max:100',
            'energia_electrica' => 'required|string|max:100',
            'agua_potable' => 'nullable|string|max:100',
            'desague' => 'nullable|string|max:100',
            's_s__h_h' => 'nullable|string|max:100',
            'numero_de_habitaciones' => 'nullable|integer|min:1|max:20',
            'numero_de_habitantes' => 'nullable|integer|min:1|max:20',
            'situacion_de_vivienda' => 'required|string|max:100',
            'escala' => 'nullable|in:A,B,C,D',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ], [
            'codigo_modular.required' => 'Ingrese un código modular válido.',
            'codigo_modular.max' => 'El código modular no puede superar los 20 caracteres.',
            'codigo_educando.required' => 'Ingrese un código educando válido.',
            'codigo_educando.max' => 'El código educando no puede superar los 20 caracteres.',
            'año_de_ingreso.required' => 'El año de ingreso es obligatorio.',
            'año_de_ingreso.integer' => 'El año de ingreso debe ser un número.',
            'año_de_ingreso.min' => 'El año de ingreso debe ser mayor o igual a 1900.',
            'año_de_ingreso.max' => 'El año de ingreso debe ser menor o igual a 2100.',
            'apellido_paterno.required' => 'Ingrese un apellido paterno válido.',
            'apellido_paterno.max' => 'El apellido paterno no puede superar los 50 caracteres.',
            'apellido_materno.required' => 'Ingrese un apellido materno válido.',
            'apellido_materno.max' => 'El apellido materno no puede superar los 50 caracteres.',
            'primer_nombre.required' => 'Ingrese un primer nombre válido.',
            'primer_nombre.max' => 'El primer nombre no puede superar los 50 caracteres.',
            'otros_nombres.max' => 'Los otros nombres no pueden superar los 50 caracteres.',
            'sexo.required' => 'El campo sexo es obligatorio.',
            'sexo.in' => 'El sexo debe ser Masculino (M) o Femenino (F).',
            'fecha_nacimiento.required' => 'Ingrese una fecha de nacimiento válida.',
            'fecha_nacimiento.date' => 'La fecha de nacimiento debe ser una fecha válida.',
            'pais.required' => 'Ingrese un país válido.',
            'pais.max' => 'El país no puede superar los 20 caracteres.',
            'departamento.required' => 'Ingrese un departamento válido.',
            'departamento.max' => 'El departamento no puede superar los 40 caracteres.',
            'provincia.required' => 'Ingrese una provincia válida.',
            'provincia.max' => 'La provincia no puede superar los 40 caracteres.',
            'distrito.required' => 'Ingrese un distrito válido.',
            'distrito.max' => 'El distrito no puede superar los 40 caracteres.',
            'lengua_materna.required' => 'Ingrese una lengua materna válida.',
            'lengua_materna.max' => 'La lengua materna no puede superar los 50 caracteres.',
            'estado_civil.required' => 'El estado civil es obligatorio.',
            'estado_civil.in' => 'El estado civil debe ser S, C, V o D.',
            'religion.max' => 'La religión no puede superar los 50 caracteres.',
            'fecha_bautizo.date' => 'Ingrese una fecha de bautizo válida.',
            'parroquia_de_bautizo.max' => 'La parroquia de bautizo no puede superar los 100 caracteres.',
            'colegio_de_procedencia.max' => 'El colegio de procedencia no puede superar los 100 caracteres.',
            'direccion.required' => 'Ingrese una dirección válida.',
            'direccion.max' => 'La dirección no puede superar los 255 caracteres.',
            'telefono.max' => 'El teléfono no puede superar los 20 caracteres.',
            'medio_de_transporte.required' => 'Ingrese un medio de transporte válido.',
            'medio_de_transporte.max' => 'El medio de transporte no puede superar los 50 caracteres.',
            'tiempo_de_demora.required' => 'Ingrese un tiempo de demora válido.',
            'tiempo_de_demora.max' => 'El tiempo de demora no puede superar los 20 caracteres.',
            'material_vivienda.required' => 'Ingrese un material de vivienda válido.',
            'material_vivienda.max' => 'El material de vivienda no puede superar los 100 caracteres.',
            'energia_electrica.required' => 'Ingrese una fuente de energía eléctrica válida.',
            'energia_electrica.max' => 'La energía eléctrica no puede superar los 100 caracteres.',
            'agua_potable.max' => 'El campo agua potable no puede superar los 100 caracteres.',
            'desague.max' => 'El campo desagüe no puede superar los 100 caracteres.',
            's_s__h_h.max' => 'El campo S.S.H.H. no puede superar los 100 caracteres.',
            'numero_de_habitaciones.max' => 'Máximo número de habitaciones = 20.',
            'numero_de_habitaciones.min' => 'Mínimo número de habitaciones = 1.',
            'numero_de_habitantes.max' => 'Máximo número de habitantes = 20.',
            'numero_de_habitantes.min' => 'Mínimo número de habitantes = 1.',
            'situacion_de_vivienda.required' => 'Ingrese una situación de vivienda válida.',
            'situacion_de_vivienda.max' => 'La situación de vivienda no puede superar los 100 caracteres.',
            'escala.in' => 'La escala debe ser A, B, C o D.',
        ]);

        if (isset($requested)) {
            $newCodigoEducando = $request->input('codigo_educando');
            $newCodigoModular = $request->input('codigo_modular');
            $newAñoIngreso = $request->input('año_de_ingreso');
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
            $newParroquiaBautizo = $request->input('parroquia_de_bautizo', '');
            $newColegioProcedencia = $request->input('colegio_de_procedencia', '');
            $newDireccion = $request->input('direccion');
            $newTelefono = $request->input('telefono', '');
            $newMedioTransporte = 	$request->input('medio_de_transporte');
            $newTiempoDemora = 	$request->input('tiempo_de_demora', '');
            $newMaterialVivienda = 	$request->input('material_vivienda');
            $newEnergiaElectrica = 	$request->input('energia_electrica');
            $newAguaPotable = 	$request->input('agua_potable', '');
            $newDesague = $request->input('desague', '');
            $newSs_hh = $request->input('s_s__h_h', '');
            $newNumHabitaciones = $request->input('numero_de_habitaciones', null);
            $newNumHabitantes = $request->input('numero_de_habitantes', null);
            $newSituacionVivienda = $request->input('situacion_de_vivienda');
            $newEscala = $request->input('escala', null);

            if ($request->hasFile('foto')) {
                if ($requested->foto && $requested->foto != 'default.jpg') {
                    \Storage::disk('public')->delete('alumnos/' . $user->foto);
                }

                $filename = time() . '_' . $request->foto->getClientOriginalName();
                $request->foto->storeAs('alumnos', $filename, 'public');
                $newFoto = $filename;
            }

            $requested -> update(['codigo_modular' => $newCodigoModular,
            'foto' => $newFoto,
                'codigo_educando' => $newCodigoEducando,
                'año_ingreso' => $newAñoIngreso,
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

        return redirect(route('familiar_dato_view', ['edited' => true]));
    }

}
