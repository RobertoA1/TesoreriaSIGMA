<?php

namespace App\Http\Controllers;

use App\Helpers\ArrayableTableAction;
use App\Helpers\CRUDTablePage;
use App\Helpers\ExcelExportHelper;
use App\Helpers\FilteredSearchQuery;
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
use App\Models\NivelEducativo;
use \Illuminate\Http\Request;


class NivelEducativoController extends Controller
{
    private static function doSearch($sqlColumns, $search, $maxEntriesShow, $appliedFilters = []){
        $columnMap = [
            'ID' => 'id_nivel',
            'Nivel' => 'nombre_nivel',
            'Descripción' => 'descripcion'
        ];

        $query = NivelEducativo::where('estado', '=', true);

        FilteredSearchQuery::fromQuery($query, $sqlColumns, $search, $appliedFilters, $columnMap);

        if ($maxEntriesShow == null) return $query->get();

        return $query->paginate($maxEntriesShow);
    }
    
    public function index(Request $request, $long = false){
        $sqlColumns = ['id_nivel', 'nombre_nivel', 'descripcion'];
        $resource = 'academica';

        $params = RequestHelper::extractSearchParams($request);
        
        $page = CRUDTablePage::new()
            ->title("Niveles Educativos")
            ->sidebar(new AdministrativoSidebarComponent())
            ->header(new AdministrativoHeaderComponent());
        
        $content = CRUDTableComponent::new()
            ->title("Niveles Educativos");

        $filterButton = new TableButtonComponent("tablesv2.buttons.filtros");
        $content->addButton($filterButton);

        /* Definición de botones */

        $descargaButton = new TableButtonComponent("tablesv2.buttons.download");
        $createNewEntryButton = new TableButtonComponent("tablesv2.buttons.createNewEntry", ["redirect" => "nivel_educativo_create"]);

        if (!$long){
            $vermasButton = new TableButtonComponent("tablesv2.buttons.vermas", ["redirect" => "nivel_educativo_viewAll"]);
        } else {
            $vermasButton = new TableButtonComponent("tablesv2.buttons.vermenos", ["redirect" => "nivel_educativo_view"]);
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
            ->action('Estás eliminando el Nivel Educativo')
            ->columns(['Nivel', 'Descripción'])
            ->rows(['nombre', 'descripcion'])
            ->lastWarningMessage('Borrar esto afectará a todo lo que esté vinculado a este Nivel Educativo')
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

        $nivelesExistentes = NivelEducativo::select("nombre_nivel")
            ->distinct()
            ->where("estado", "=", 1)
            ->pluck("nombre_nivel");

        $filterConfig = new FilterConfig();
        $filterConfig->filters = [
            "ID", "Nivel", "Descripción"
        ];
        $filterConfig->filterOptions = [
            "Nivel" => $nivelesExistentes
        ];
        $content->filterConfig = $filterConfig;
        
        $table = new TableComponent();
        $table->columns = ["ID", "Nivel", "Descripción"];
        $table->rows = [];

        foreach ($query as $nivel){
            array_push($table->rows,
            [
                $nivel->id_nivel,
                $nivel->nombre_nivel,
                $nivel->descripcion
            ]); 
        }
        $table->actions = [
            new TableAction('edit', 'nivel_educativo_edit', $resource),
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
    
    public function export(Request $request){
        $format = $request->input('export', 'excel');
        $sqlColumns = ['id_nivel', 'nombre_nivel', 'descripcion'];

        $params = RequestHelper::extractSearchParams($request);
        
        $query = NivelEducativoController::doSearch($sqlColumns, $params->search, $params->showing, $params->applied_filters);

        if ($params->page > $query->lastPage()){
            $params->page = 1;
            $query = NivelEducativoController::doSearch($sqlColumns, $params->search, $params->showing, $params->applied_filters);
        }
        
        if ($format === 'excel') {
            return $this->exportExcel($query);
        } elseif ($format === 'pdf') {
            return $this->exportPdf($query);
        }
        
        return abort(400, 'Formato no válido');
    }

    private function exportExcel($niveles)
    {
        $headers = ['ID', 'Nivel', 'Descripción'];
        $fileName = 'niveles_educativos_' . date('Y-m-d_H-i-s') . '.xlsx';
        $title = 'Niveles Educativos';
        $subject = 'Exportación de Niveles Educativos';
        $description = 'Listado de niveles educativos del sistema';

        return ExcelExportHelper::exportExcel(
            $fileName,
            $headers,
            $niveles,
            function($sheet, $row, $nivel) {
                $sheet->setCellValue('A' . $row, $nivel->id_nivel);
                $sheet->setCellValue('B' . $row, $nivel->nombre_nivel);
                $sheet->setCellValue('C' . $row, $nivel->descripcion);
            },
            $title,
            $subject,
            $description
        );
    }

    private function exportPdf($niveles)
    {
        $fileName = 'niveles_educativos_' . date('Y-m-d_H-i-s') . '.pdf';
        $html = PDFExportHelper::generateTableHtml([
            'title' => 'Niveles Educativos',
            'subtitle' => 'Niveles Educativos',
            'headers' => ['ID', 'Nivel', 'Descripción'],
            'rows' => $niveles->map(function($nivel) {
                return [
                    $nivel->id_nivel,
                    $nivel->nombre_nivel,
                    $nivel->descripcion
                ];
            })->toArray(),
            'footer' => 'Sistema de Gestión Académica SIGMA - Generado automáticamente',
        ]);
        return PDFExportHelper::exportPdf($fileName, $html);
    }
}