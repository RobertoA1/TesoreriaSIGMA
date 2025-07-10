<?php

namespace App\Http\Controllers;

use App\Helpers\FilteredSearchQuery;
use App\Models\ComposicionFamiliar;
use Illuminate\Http\Request;
use App\Models\Alumno;
use App\Helpers\CRUDTablePage;
use App\Helpers\ExcelExportHelper;
use App\Helpers\PDFExportHelper;
use App\Helpers\RequestHelper;
use App\Helpers\TableAction;
use App\Helpers\Tables\AdministrativoHeaderComponent;
use App\Helpers\Tables\AdministrativoSidebarComponent;
use App\Helpers\Tables\CautionModalComponent;
use App\Helpers\Tables\CRUDTableComponent;
use App\Helpers\Tables\FilterConfig;
use App\Helpers\Tables\PaginatorRowsSelectorComponent;
use App\Helpers\Tables\SearchBoxComponent;
use App\Helpers\Tables\TableButtonComponent;
use App\Helpers\Tables\TableComponent;
use App\Helpers\Tables\TablePaginator;
use App\Http\Controllers\Controller;

class AlumnoController extends Controller
{

    private static function doSearch($sqlColumns, $search, $maxEntriesShow, $appliedFilters = []){
        $columnMap = [
            'ID' => 'id_alumno',
            'Código Educando' => 'codigo_educando',
            'DNI' => 'dni',  
            'Apellido Paterno' => 'apellido_paterno',
            'Apellido Materno' => 'apellido_materno',
            'Primer Nombre' => 'primer_nombre',
            'Otros Nombres' => 'otros_nombres',
            'Sexo' => 'sexo'
        ];

        /* Caso especial ya que el sexo debe establecerse según su búsqueda en BD */
        $equiv = [
            'masculino' => 'M',
            'femenino' => 'F',
        ];

        foreach ($appliedFilters as &$appliedFilter){
            if ($appliedFilter["key"] == 'Sexo'){
                $appliedFilter["value"] = $equiv[strtolower($appliedFilter["value"])];
                break;
            }
        }

        $query = Alumno::where('estado', '=', true);

        FilteredSearchQuery::fromQuery($query, $sqlColumns, $search, $appliedFilters, $columnMap);

        if ($maxEntriesShow == null) return $query->get();

        return $query->paginate($maxEntriesShow);
    }
    
    public function index(Request $request, $long = false){
        $sqlColumns = ['id_alumno', 'codigo_educando', 'dni', 'apellido_paterno', 'apellido_materno', 'primer_nombre', 'otros_nombres', 'sexo'];
        $resource = 'alumnos';

        $params = RequestHelper::extractSearchParams($request);
        
        $page = CRUDTablePage::new()
            ->title("Alumnos")
            ->sidebar(new AdministrativoSidebarComponent())
            ->header(new AdministrativoHeaderComponent());
        
        $content = CRUDTableComponent::new()
            ->title("Alumnos");

        $filterButton = new TableButtonComponent("tablesv2.buttons.filtros");
        $content->addButton($filterButton);

        /* Definición de botones */

        $descargaButton = new TableButtonComponent("tablesv2.buttons.download");
        $createNewEntryButton = new TableButtonComponent("tablesv2.buttons.createNewEntry", ["redirect" => "alumno_create"]);

        if (!$long){
            $vermasButton = new TableButtonComponent("tablesv2.buttons.vermas", ["redirect" => "alumno_viewAll"]);
        } else {
            $vermasButton = new TableButtonComponent("tablesv2.buttons.vermenos", ["redirect" => "alumno_view"]);
            $params->showing = 100;
        }

        $content->addButton($vermasButton);
        $content->addButton($descargaButton);
        $content->addButton($createNewEntryButton);

        /* Paginador */
        $paginatorRowsSelector = new PaginatorRowsSelectorComponent();
        if ($long) $paginatorRowsSelector = new PaginatorRowsSelectorComponent([100]);
        $paginatorRowsSelector->valueSelected = $params->showing;
        $content->paginatorRowsSelector($paginatorRowsSelector);

        /* Searchbox */
        $searchBox = new SearchBoxComponent();
        $searchBox->placeholder = "Buscar...";
        $searchBox->value = $params->search;
        $content->searchBox($searchBox);

        /* Modales usados */
        $cautionModal = CautionModalComponent::new()
            ->cautionMessage('¿Estás seguro?')
            ->action('Estás eliminando el Alumno')
            ->columns(['Código Educando', 'DNI', 'Apellidos', 'Nombres', 'Sexo'])
            ->rows(['', '', '', '', ''])
            ->lastWarningMessage('Borrar esto afectará a todo lo que esté vinculado a este Alumno.')
            ->confirmButton('Sí, bórralo')
            ->cancelButton('Cancelar')
            ->isForm(true)
            ->dataInputName('id')
            ->build();

        $page->modals([$cautionModal]);

        /* Lógica del controller */
        
        $query = static::doSearch($sqlColumns, $params->search, $params->showing, $params->applied_filters);

        if ($params->page > $query->lastPage()){
            $params->page = 1;
            $query = static::doSearch($sqlColumns, $params->search, $params->showing, $params->applied_filters);
        }

        $filterConfig = new FilterConfig();
        $filterConfig->filters = [
            "ID", "Código Educando", "DNI", "Apellido Paterno", "Apellido Materno", "Primer Nombre", "Otros Nombres", "Sexo"
        ];
        $filterConfig->filterOptions = [
            "Sexo" => ["Masculino", "Femenino"]
        ];
        $content->filterConfig = $filterConfig;
        
        $table = new TableComponent();
        $table->columns = ["ID", "Código Educando", "DNI", "Apellidos", "Nombres", "Sexo"];
        $table->rows = [];

        foreach ($query as $alumno){
            array_push($table->rows,
            [
                $alumno->id_alumno,
                $alumno->codigo_educando,
                $alumno->dni,
                $alumno->apellido_paterno . " " . $alumno->apellido_materno,
                $alumno->primer_nombre . " " . $alumno->otros_nombres,
                $alumno->sexo,
            ]); 
        }
        $table->actions = [
            new TableAction('edit', 'alumno_edit', $resource),
            new TableAction('delete', '', $resource),
        ];

        $paginator = new TablePaginator($params->page, $query->lastPage(), []);
        $table->paginator = $paginator;

        $content->tableComponent($table);

        $page->content($content->build());

        return $page->render();
    }

    public function viewAll(Request $request){
        return static::index($request, true);
    }


    private static function fallbackDoSearch($sqlColumns, $search, $maxEntriesShow) {
        if (!isset($search)) {
            $query = Alumno::where('estado', '=', '1')->paginate($maxEntriesShow);
        } else {
            $query = Alumno::where('estado', '=', '1')
                ->whereAny($sqlColumns, 'LIKE', "%{$search}%")
                ->paginate($maxEntriesShow);
        }

        return $query;
    }

    public function fallback(Request $request) {
        $sqlColumns = ['id_alumno','codigo_educando', 'dni', 'apellido_paterno', 'apellido_materno', 'primer_nombre', 'otros_nombres', 'sexo'];
        $resource = 'alumnos';

        $maxEntriesShow = $request->input('showing', 10);
        $paginaActual = $request->input('page', 1);
        $search = $request->input('search');

        if (!is_numeric($paginaActual) || $paginaActual <= 0) $paginaActual = 1;
        if (!is_numeric($maxEntriesShow) || $maxEntriesShow <= 0) $maxEntriesShow = 10;

        $query = AlumnoController::fallbackDoSearch($sqlColumns, $search, $maxEntriesShow);

        if ($paginaActual > $query->lastPage()) {
            $paginaActual = 1;
            $request['page'] = $paginaActual;
            $query = AlumnoController::fallbackDoSearch($sqlColumns, $search, $maxEntriesShow);
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
            'add_familiar' => 'alumno_add_familiar',
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

    public function create(Request $request) {
        $sexos = [
            ['id' => 'M', 'descripcion' => 'Masculino'],
            ['id' => 'F', 'descripcion' => 'Femenino']
        ];

        $escalas = [
            ['id' => 'A', 'descripcion' => 'A'],
            ['id' => 'B', 'descripcion' => 'B'],
            ['id' => 'C', 'descripcion' => 'C'],
            ['id' => 'D', 'descripcion' => 'D'],
            ['id' => 'E', 'descripcion' => 'E'],
        ];

        $estadosciviles = [
            ['id' => 'C', 'descripcion' => 'Casado'],
            ['id' => 'S', 'descripcion' => 'Soltero'],
            ['id' => 'V', 'descripcion' => 'Viudo'],
            ['id' => 'D', 'descripcion' => 'Divorciado']
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
            'return' => route('alumno_view', ['abort' => true]),
            'sexos' => $sexos,
            'paises' => $paises,
            'provincias' => $provincias,
            'distritos' => $distritos,
            'estadosciviles' => $estadosciviles,
            'departamentos' => $departamentos,
            'lenguasmaternas' => $lenguasmaternas,
            'escalas' => $escalas
        ];

        return view('gestiones.alumno.create', compact('data'));
    }

    public function createNewEntry(Request $request) {
        $request -> validate([
            'código_modular' => 'required|string|max:20',
            'código_educando' => 'required|string|max:20',
            'año_de_ingreso' => 'required|integer|min:1900|max:2100',
            'd_n_i' => 'required|string|max:8|unique:alumnos,dni',
            'apellido_paterno' => 'required|string|max:50',
            'apellido_materno' => 'required|string|max:50',
            'primer_nombre' => 'required|string|max:50',
            'otros_nombres' => 'nullable|string|max:50',
            'sexo' => 'required|in:M,F',
            'fecha_nacimiento' => 'required|date',
            'país' => 'required|string|max:20',
            'departamento' => 'required|string|max:40',
            'provincia' => 'required|string|max:40',
            'distrito' => 'required|string|max:40',
            'lengua_materna' => 'required|string|max:50',
            'estado_civil' => 'required|in:S,C,V,D',
            'religión' => 'nullable|string|max:50',
            'fecha_bautizo' => 'nullable|date',
            'parroquia_de_bautizo' => 'nullable|string|max:100',
            'colegio_de_procedencia' => 'nullable|string|max:100',
            'dirección' => 'required|string|max:255',
            'teléfono' => 'nullable|string|max:20',
            'medio_de_transporte' => 'required|string|max:50',
            'tiempo_de_demora' => 'required|string|max:20',
            'material_vivienda' => 'required|string|max:100',
            'energía_eléctrica' => 'required|string|max:100',
            'agua_potable' => 'nullable|string|max:100',
            'desagüe' => 'nullable|string|max:100',
            'servicios_higiénicos' => 'nullable|string|max:100',
            'número_de_habitaciones' => 'nullable|integer|min:1|max:20',
            'número_de_habitantes' => 'nullable|integer|min:1|max:20',
            'situación_de_vivienda' => 'required|string|max:100',
            'escala' => 'required|in:A,B,C,D,E',
        ], [
            'código_modular.required' => 'Ingrese un código modular válido.',
            'código_modular.max' => 'El código modular no puede superar los 20 caracteres.',
            'código_educando.required' => 'Ingrese un código educando válido.',
            'código_educando.max' => 'El código educando no puede superar los 20 caracteres.',
            'año_de_ingreso.required' => 'El año de ingreso es obligatorio.',
            'año_de_ingreso.integer' => 'El año de ingreso debe ser un número.',
            'año_de_ingreso.min' => 'El año de ingreso debe ser mayor o igual a 1900.',
            'año_de_ingreso.max' => 'El año de ingreso debe ser menor o igual a 2100.',
            'd_n_i.required' => 'Ingrese un DNI válido.',
            'd_n_i.max' => 'El DNI no puede superar los 8 caracteres.',
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
            'religión.max' => 'La religión no puede superar los 50 caracteres.',
            'fecha_bautizo.date' => 'Ingrese una fecha de bautizo válida.',
            'parroquia_de_bautizo.max' => 'La parroquia de bautizo no puede superar los 100 caracteres.',
            'colegio_de_procedencia.max' => 'El colegio de procedencia no puede superar los 100 caracteres.',
            'dirección.required' => 'Ingrese una dirección válida.',
            'dirección.max' => 'La dirección no puede superar los 255 caracteres.',
            'teléfono.max' => 'El teléfono no puede superar los 20 caracteres.',
            'medio_de_transporte.required' => 'Ingrese un medio de transporte válido.',
            'medio_de_transporte.max' => 'El medio de transporte no puede superar los 50 caracteres.',
            'tiempo_de_demora.required' => 'Ingrese un tiempo de demora válido.',
            'tiempo_de_demora.max' => 'El tiempo de demora no puede superar los 20 caracteres.',
            'material_vivienda.required' => 'Ingrese un material de vivienda válido.',
            'material_vivienda.max' => 'El material de vivienda no puede superar los 100 caracteres.',
            'energía_eléctrica.required' => 'Ingrese una fuente de energía eléctrica válida.',
            'energía_eléctrica.max' => 'La energía eléctrica no puede superar los 100 caracteres.',
            'agua_potable.max' => 'El campo agua potable no puede superar los 100 caracteres.',
            'desagüe.max' => 'El campo desagüe no puede superar los 100 caracteres.',
            'servicios_higiénicos.max' => 'El campo S.S.H.H. no puede superar los 100 caracteres.',
            'número_de_habitaciones.max' => 'Máximo número de habitaciones = 20.',
            'número_de_habitaciones.min' => 'Mínimo número de habitaciones = 1.',
            'número_de_habitaciones.integer' => 'El número de habitaciones debe ser un número válido.',
            'número_de_habitantes.max' => 'Máximo número de habitantes = 20.',
            'número_de_habitantes.min' => 'Mínimo número de habitantes = 1.',
            'número_de_habitantes.integer' => 'El número de habitantes debe ser un número válido.',
            'situación_de_vivienda.required' => 'Ingrese una situación de vivienda válida.',
            'situación_de_vivienda.max' => 'La situación de vivienda no puede superar los 100 caracteres.',
            'escala.in' => 'La escala debe ser A, B, C, D o E.'
        ]);

        $codigoModular = $request->input('código_modular');
        $codigoEducando = $request->input('código_educando');
        $añoIngreso = $request->input('año_ingreso');
        $dni = $request->input('d_n_i');
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
        $religion = $request->input('religión', '');
        $fechaBautizo = $request->input('fecha_bautizo', null);
        $parroquia_bautizo = $request->input('parroquia_de_bautizo', '');
        $colegioProcedencia = $request->input('colegio_de_procedencia', '');
        $direccion = $request->input('dirección');
        $telefono = $request->input('teléfono', '');
        $medioTransporte = $request
            ->input('medio_de_transporte');
        $tiempoDemora = $request->input('tiempo_de_demora', '');
        $materialVivienda = $request->input('material_vivienda');
        $energiaElectrica = $request->input('energía_eléctrica');
        $aguaPotable = $request->input('agua_potable', '');
        $desague = $request->input('desagüe', '');
        $ss_hh = $request->input('servicios_higiénicos', '');
        $numHabitaciones = $request->input('número_de_habitaciones', null);
        $numHabitantes = $request->input('número_de_habitantes', null);
        $situacionVivienda = $request->input('situación_de_vivienda');
        $escala = $request->input('escala', null);


        $alumno  = new Alumno([
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
            'parroquia_bautizo' => $parroquia_bautizo,
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

        $alumno->save();

        if ($request->input('definir_familiares') == '1'){
            return redirect()->route('alumno_add_familiares', [
                'id' => $alumno->id_alumno, // o el campo que sea tu PK
                'created' => true
            ]);
        }

        return redirect()->route('alumno_view', [
            'created' => true
        ]);
    }

    public function add_familiares($id){
        $alumno = Alumno::findOrFail($id);
        $data = [
            'return' => route('alumno_view', ['abort' => true]),
            'id' => $id,
            'default' => [
                'codigo_educando' => $alumno->codigo_educando,
                'codigo_modular' => $alumno->codigo_modular,
                'año_ingreso' => $alumno->año_ingreso,
                'd_n_i' => $alumno->dni,
                'apellido_paterno' => $alumno->apellido_paterno,
                'apellido_materno' => $alumno->apellido_materno,
                'primer_nombre' => $alumno->primer_nombre,
                'otros_nombres' => $alumno->otros_nombres,
            ]
        ];
        
        return view('gestiones.alumno.add_familiares', compact('data'));
    }

    public function guardarFamiliares(Request $request, $id) {
        
        $request->validate([
            'dni' => 'required|string|max:20',
            'apellido_paterno' => 'required|string|max:50',
            'apellido_materno' => 'required|string|max:50',
            'primer_nombre' => 'required|string|max:50',
            'otros_nombres' => 'nullable|string|max:100',
            'parentesco' => 'required',
            'numero_contacto' => 'nullable|string|max:20',
            'correo_electronico' => 'nullable|email|max:100',
        ], [
            'dni.required' => 'Ingrese un DNI válido.',
            'apellido_paterno.required' => 'Ingrese el apellido paterno.',
            'apellido_materno.required' => 'Ingrese el apellido materno.',
            'primer_nombre.required' => 'Ingrese el primer nombre.',
            'parentesco.required' => 'Ingrese el parentesco'
        ]);


        $familiarController = new FamiliarController();
        $familiar = $familiarController->createNewEntry($request, true);


        ComposicionFamiliar::create([
            'id_alumno' => $id,
            'id_familiar' => $familiar->idFamiliar, 
            'parentesco' => $request->parentesco
        ]);

        return redirect()->route('alumno_view', ['edited' => true]);
    }






    public function edit(Request $request, $id) {
        if (!isset($id)) {
            return redirect(route('alumno_view'));
        }

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
        

        $requested = Alumno::findOrFail($id);

        $data = [
            'return' => route('alumno_view', ['abort' => true]),
            'id' => $id,
            'sexos' => $sexos,
            'paises' => $paises,
            'provincias' => $provincias,
            'distritos' => $distritos,
            'departamentos' => $departamentos,
            'estadosciviles' => $estadosciviles,
            'lenguasmaternas' => $lenguasmaternas,
            'escalas' => $escalas,
            'default' => [
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
        return view('gestiones.alumno.edit', compact('data'));
    }

    public function editEntry(Request $request, $id) {
        if (!isset($id)) {
            return redirect(route('alumno_view'));
        }

        $request -> validate([
            'codigo_modular' => 'required|string|max:20',
            'codigo_educando' => 'required|string|max:20',
            'año_de_ingreso' => 'required|integer|min:1900|max:2100',
            'd_n_i' => 'required|string|max:8',
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
        ], [
            'codigo_modular.required' => 'Ingrese un código modular válido.',
            'codigo_modular.max' => 'El código modular no puede superar los 20 caracteres.',
            'codigo_educando.required' => 'Ingrese un código educando válido.',
            'codigo_educando.max' => 'El código educando no puede superar los 20 caracteres.',
            'año_de_ingreso.required' => 'El año de ingreso es obligatorio.',
            'año_de_ingreso.integer' => 'El año de ingreso debe ser un número.',
            'año_de_ingreso.min' => 'El año de ingreso debe ser mayor o igual a 1900.',
            'año_de_ingreso.max' => 'El año de ingreso debe ser menor o igual a 2100.',
            'd_n_i.required' => 'Ingrese un DNI válido.',
            'd_n_i.max' => 'El DNI no puede superar los 8 caracteres.',
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


        $requested = Alumno::find($id);

        if (isset($requested)) {
            $newCodigoEducando = $request->input('codigo_educando');
            $newCodigoModular = $request->input('codigo_modular');
            $newAñoIngreso = $request->input('año_ingreso');
            $newDni = $request->input('d_n_i');
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

        $requested = Alumno::findOrFail($id);

        $requested->update(['estado' => '0']);

        return redirect(route('alumno_view', ['deleted' => true]));
    }

}
