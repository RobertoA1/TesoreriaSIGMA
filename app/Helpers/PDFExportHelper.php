<?php

namespace App\Helpers;

use Dompdf\Dompdf;
use Dompdf\Options;

class PDFExportHelper
{
    /**
     * Exporta un PDF con Dompdf y configuración estándar SIGMA.
     * @param string $fileName Nombre del archivo a descargar
     * @param string $html HTML del contenido del PDF
     * @param array $options Opciones adicionales: 'defaultFont', 'paper', 'orientation'
     */
    public static function exportPdf($fileName, $html, $options = [])
    {
        $dompdfOptions = new Options();
        $dompdfOptions->set('defaultFont', $options['defaultFont'] ?? 'Arial');
        $dompdfOptions->set('isRemoteEnabled', true);
        $dompdf = new Dompdf($dompdfOptions);

        $dompdf->loadHtml($html);
        $dompdf->setPaper($options['paper'] ?? 'A4', $options['orientation'] ?? 'portrait');
        $dompdf->render();

        return response($dompdf->output(), 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'attachment; filename="' . $fileName . '"',
            'Cache-Control' => 'private, max-age=0, must-revalidate',
            'Pragma' => 'public',
        ]);
    }

    /**
     * Genera HTML de tabla para PDF con encabezado, subtítulo, filas y footer.
     * @param array $config [title, subtitle, headers, rows, footer]
     * @return string
     */
    public static function generateTableHtml(array $config): string
    {
        $fecha = date('d/m/Y H:i:s');
        $totalRegistros = count($config['rows'] ?? []);
        $title = $config['title'] ?? 'Reporte';
        $subtitle = $config['subtitle'] ?? '';
        $headers = $config['headers'] ?? [];
        $rows = $config['rows'] ?? [];
        $footer = $config['footer'] ?? '';
        $html = '<!DOCTYPE html><html><head><meta charset="utf-8"><title>' . htmlspecialchars($title) . '</title>';
        $html .= '<style>body{font-family:Arial,sans-serif;margin:20px;font-size:12px;}.header{text-align:center;margin-bottom:30px;border-bottom:2px solid #4F46E5;padding-bottom:10px;}.header h1{color:#4F46E5;margin:0;font-size:24px;}.header h2{color:#4F46E5;margin:0;font-size:18px;}.header p{margin:5px 0;color:#666;}.info-section{margin-bottom:20px;background-color:#f8f9fa;padding:10px;border-radius:5px;}.info-section p{margin:5px 0;}table{width:100%;border-collapse:collapse;margin-top:10px;}th,td{border:1px solid #ddd;padding:8px;text-align:left;}th{background-color:#4F46E5;color:white;font-weight:bold;}tr:nth-child(even){background-color:#f2f2f2;}.footer{margin-top:30px;text-align:center;font-size:10px;color:#666;border-top:1px solid #ddd;padding-top:10px;}thead{display:table-header-group;}tfoot{display:table-footer-group;}</style>';
        $html .= '</head><body>';
        $html .= '<div class="header"><h1>Sistema SIGMA</h1>';
        if ($subtitle) $html .= '<h2>' . htmlspecialchars($subtitle) . '</h2>';
        $html .= '<p>Reporte generado el ' . $fecha . '</p></div>';
        $html .= '<div class="info-section"><p><strong>Total de registros:</strong> ' . $totalRegistros . '</p><p><strong>Fecha de generación:</strong> ' . $fecha . '</p></div>';
        $html .= '<table><thead><tr>';
        foreach ($headers as $header) {
            $html .= '<th>' . htmlspecialchars($header) . '</th>';
        }
        $html .= '</tr></thead><tbody>';
        foreach ($rows as $row) {
            $html .= '<tr>';
            foreach ($row as $cell) {
                $html .= '<td>' . htmlspecialchars($cell) . '</td>';
            }
            $html .= '</tr>';
        }
        $html .= '</tbody></table>';
        if ($footer) {
            $html .= '<div class="footer"><p>' . htmlspecialchars($footer) . '</p></div>';
        }
        $html .= '</body></html>';
        return $html;
    }
}
