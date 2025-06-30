<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\NivelEducativo;
use Symfony\Component\HttpFoundation\StreamedResponse;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Font;
use Dompdf\Dompdf;
use Dompdf\Options;

class NivelEducativoController extends Controller
{
    private static function doSearch($sqlColumns, $search, $maxEntriesShow, $appliedFilters = []){
        $query = NivelEducativo::where('estado', '=', '1');
        
        // Aplicar búsqueda general si existe
        if (isset($search)) {
            $query->whereAny($sqlColumns, 'LIKE', "%{$search}%");
        }
        
        // Aplicar filtros dinámicos
        foreach ($appliedFilters as $filter) {
            $columnName = $filter['key'];
            $value = $filter['value'];
            
            // Mapear nombres de columnas de la vista a nombres de BD
            $columnMap = [
                'ID' => 'id_nivel',
                'Nivel' => 'nombre_nivel',
                'Descripción' => 'descripcion'
            ];
            
            $dbColumn = $columnMap[$columnName] ?? strtolower($columnName);
            
            // Aplicar filtro según el tipo de columna
            if ($dbColumn === 'id_nivel') {
                // Para ID, usar búsqueda exacta si es numérico
                if (is_numeric($value)) {
                    $query->where($dbColumn, '=', $value);
                } else {
                    $query->where($dbColumn, 'LIKE', "%{$value}%");
                }
            } else {
                // Para texto, usar LIKE
                $query->where($dbColumn, 'LIKE', "%{$value}%");
            }
        }

        return $query->paginate($maxEntriesShow);
    }
    public function index(Request $request){
        $sqlColumns = ['id_nivel', 'nombre_nivel', 'descripcion'];
        $resource = 'academica';

        $maxEntriesShow = $request->input('showing', 10);
        $paginaActual = $request->input('page', 1);
        $search = $request->input('search');
        
        // Obtener filtros aplicados
        $appliedFilters = json_decode($request->input('applied_filters', '[]'), true) ?? [];

        if (!is_numeric($paginaActual) || $paginaActual <= 0) $paginaActual = 1;
        if (!is_numeric($maxEntriesShow) || $maxEntriesShow <= 0) $maxEntriesShow = 10;
        
        $query = NivelEducativoController::doSearch($sqlColumns, $search, $maxEntriesShow, $appliedFilters);

        if ($paginaActual > $query->lastPage()){
            $paginaActual = 1;
            $request['page'] = $paginaActual;
            $query = NivelEducativoController::doSearch($sqlColumns, $search, $maxEntriesShow, $appliedFilters);
        }

        $nivelesExistentes = NivelEducativo::select("nombre_nivel")
            ->distinct()
            ->where("estado", "=", 1)
            ->pluck("nombre_nivel");
        
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
            'filters' => $data['columnas'] ?? [],
            'filterOptions' => [
                'Nivel' => $nivelesExistentes,
            ]
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
    
    public function export(Request $request){
        $format = $request->input('export', 'excel');
        $sqlColumns = ['id_nivel', 'nombre_nivel', 'descripcion'];
        
        // Obtener filtros aplicados
        $appliedFilters = json_decode($request->input('applied_filters', '[]'), true) ?? [];
        $search = $request->input('search');
        
        // Obtener todos los registros con filtros aplicados (sin paginación)
        $query = NivelEducativo::where('estado', '=', '1');
        
        // Aplicar búsqueda general si existe
        if (isset($search)) {
            $query->whereAny($sqlColumns, 'LIKE', "%{$search}%");
        }
        
        // Aplicar filtros dinámicos
        foreach ($appliedFilters as $filter) {
            $columnName = $filter['key'];
            $value = $filter['value'];
            
            // Mapear nombres de columnas de la vista a nombres de BD
            $columnMap = [
                'ID' => 'id_nivel',
                'Nivel' => 'nombre_nivel',
                'Descripción' => 'descripcion'
            ];
            
            $dbColumn = $columnMap[$columnName] ?? strtolower($columnName);
            
            // Aplicar filtro según el tipo de columna
            if ($dbColumn === 'id_nivel') {
                // Para ID, usar búsqueda exacta si es numérico
                if (is_numeric($value)) {
                    $query->where($dbColumn, '=', $value);
                } else {
                    $query->where($dbColumn, 'LIKE', "%{$value}%");
                }
            } else {
                // Para texto, usar LIKE
                $query->where($dbColumn, 'LIKE', "%{$value}%");
            }
        }
        
        $niveles = $query->get();
        
        if ($format === 'excel') {
            return $this->exportExcel($niveles);
        } elseif ($format === 'pdf') {
            return $this->exportPdf($niveles);
        }
        
        return abort(400, 'Formato no válido');
    }

    private function exportExcel($niveles){
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        
        // Configurar propiedades del documento
        $spreadsheet->getProperties()
            ->setCreator('Sistema SIGMA')
            ->setTitle('Niveles Educativos')
            ->setSubject('Exportación de Niveles Educativos')
            ->setDescription('Listado de niveles educativos del sistema');
        
        // Configurar encabezados
        $headers = ['ID', 'Nivel', 'Descripción'];
        $column = 'A';
        foreach ($headers as $header) {
            $sheet->setCellValue($column . '1', $header);
            $column++;
        }
        
        // Estilos para encabezados
        $headerStyle = [
            'font' => [
                'bold' => true,
                'size' => 12,
                'color' => ['rgb' => 'FFFFFF']
            ],
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'startColor' => ['rgb' => '4F46E5'] // Color azul del tema
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER
            ]
        ];
        
        $sheet->getStyle('A1:C1')->applyFromArray($headerStyle);
        
        // Agregar datos
        $row = 2;
        foreach ($niveles as $nivel) {
            $sheet->setCellValue('A' . $row, $nivel->id_nivel);
            $sheet->setCellValue('B' . $row, $nivel->nombre_nivel);
            $sheet->setCellValue('C' . $row, $nivel->descripcion);
            $row++;
        }
        
        // Autoajustar columnas
        foreach (range('A', 'C') as $columnID) {
            $sheet->getColumnDimension($columnID)->setAutoSize(true);
        }
        
        // Agregar bordes a toda la tabla
        $styleArray = [
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    'color' => ['rgb' => '000000'],
                ],
            ],
        ];
        
        $sheet->getStyle('A1:C' . ($row - 1))->applyFromArray($styleArray);
        
        $fileName = 'niveles_educativos_' . date('Y-m-d_H-i-s') . '.xlsx';
        
        $writer = new Xlsx($spreadsheet);
        
        $responseHeaders = [
            'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            'Content-Disposition' => 'attachment;filename="' . $fileName . '"',
            'Cache-Control' => 'max-age=0',
            'Expires' => 'Mon, 26 Jul 1997 05:00:00 GMT',
            'Last-Modified' => gmdate('D, d M Y H:i:s') . ' GMT',
            'Pragma' => 'public',
        ];
        
        return response()->streamDownload(function() use ($writer) {
            $writer->save('php://output');
        }, $fileName, $responseHeaders);
    }

    private function exportPdf($niveles){
        $options = new Options();
        $options->set('defaultFont', 'Arial');
        $options->set('isRemoteEnabled', true);
        $dompdf = new Dompdf($options);
        
        // Generar HTML para el PDF
        $html = $this->generatePdfHtml($niveles);
        
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();
        
        $fileName = 'niveles_educativos_' . date('Y-m-d_H-i-s') . '.pdf';
        
        return response($dompdf->output(), 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'attachment; filename="' . $fileName . '"',
            'Cache-Control' => 'private, max-age=0, must-revalidate',
            'Pragma' => 'public',
        ]);
    }

    private function generatePdfHtml($niveles){
        $fecha = date('d/m/Y H:i:s');
        $totalRegistros = count($niveles);
        
        $html = '
        <!DOCTYPE html>
        <html>
        <head>
            <meta charset="utf-8">
            <title>Niveles Educativos</title>
            <style>
                body { 
                    font-family: Arial, sans-serif; 
                    margin: 20px;
                    font-size: 12px;
                }
                .header {
                    text-align: center;
                    margin-bottom: 30px;
                    border-bottom: 2px solid #4F46E5;
                    padding-bottom: 10px;
                }
                .header h1 {
                    color: #4F46E5;
                    margin: 0;
                    font-size: 24px;
                }
                .header p {
                    margin: 5px 0;
                    color: #666;
                }
                .info-section {
                    margin-bottom: 20px;
                    background-color: #f8f9fa;
                    padding: 10px;
                    border-radius: 5px;
                }
                .info-section p {
                    margin: 5px 0;
                }
                table { 
                    width: 100%; 
                    border-collapse: collapse; 
                    margin-top: 10px;
                }
                th, td { 
                    border: 1px solid #ddd; 
                    padding: 8px; 
                    text-align: left; 
                }
                th { 
                    background-color: #4F46E5; 
                    color: white;
                    font-weight: bold;
                }
                tr:nth-child(even) {
                    background-color: #f2f2f2;
                }
                .footer {
                    margin-top: 30px;
                    text-align: center;
                    font-size: 10px;
                    color: #666;
                    border-top: 1px solid #ddd;
                    padding-top: 10px;
                }
            </style>
        </head>
        <body>
            <div class="header">
                <h1>Sistema SIGMA</h1>
                <h2>Niveles Educativos</h2>
                <p>Reporte generado el ' . $fecha . '</p>
            </div>
            
            <div class="info-section">
                <p><strong>Total de registros:</strong> ' . $totalRegistros . '</p>
                <p><strong>Fecha de generación:</strong> ' . $fecha . '</p>
            </div>
            
            <table>
                <thead>
                    <tr>
                        <th style="width: 10%;">ID</th>
                        <th style="width: 30%;">Nivel</th>
                        <th style="width: 60%;">Descripción</th>
                    </tr>
                </thead>
                <tbody>';
        
        foreach ($niveles as $nivel) {
            $html .= '
                    <tr>
                        <td>' . htmlspecialchars($nivel->id_nivel) . '</td>
                        <td>' . htmlspecialchars($nivel->nombre_nivel) . '</td>
                        <td>' . htmlspecialchars($nivel->descripcion) . '</td>
                    </tr>';
        }
        
        $html .= '
                </tbody>
            </table>
            
            <div class="footer">
                <p>Sistema de Gestión Académica SIGMA - Generado automáticamente</p>
            </div>
        </body>
        </html>';
        
        return $html;
    }
}
