<?php

namespace App\Services;

use Dompdf\Dompdf;
use Dompdf\Options;

class PdfService
{
    public function generarPdfInteres(float $capital, float $tasa, int $anios, float $resultado): void
    {
        $options = new Options();
        $options->set('isHtml5ParserEnabled', true);
        $options->set('defaultFont', 'Arial');

        $dompdf = new Dompdf($options);

        $html = "
        <style>
            body { font-family: Arial, sans-serif; }
            h1 { color: #0056b3; }
            .content { margin: 20px; }
            .item { margin-bottom: 10px; }
            .label { font-weight: bold; }
        </style>
        <div class='content'>
            <h1>Reporte de Interés Compuesto</h1>
            <hr>
            <div class='item'><span class='label'>Capital Inicial:</span> $" . number_format($capital, 2) . "</div>
            <div class='item'><span class='label'>Tasa de Interés Anual:</span> " . ($tasa * 100) . "%</div>
            <div class='item'><span class='label'>Plazo:</span> $anios años</div>
            <h2>Monto Final: $" . number_format($resultado, 2) . "</h2>
        </div>
        ";

        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        $dompdf->stream("reporte-interes-compuesto.pdf", ["Attachment" => true]);
    }
}