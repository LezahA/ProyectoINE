<?php
require 'vendor/autoload.php';
use Dompdf\Dompdf;

$tabla_html = $_POST['tabla_html'] ?? '<p>No se recibió la tabla</p>';

$css = '<style>
table { border-collapse: collapse; width: 100%; font-family: Arial, sans-serif; }
th, td { border: 1px solid #444; padding: 8px; text-align: center; }
th { background: #eee; }
</style>';

$html = '<h2 style="text-align:center;">Reporte</h2>' . $css . $tabla_html;

$dompdf = new Dompdf();
$dompdf->loadHtml($html);
$dompdf->setPaper('A4', 'portrait');
$dompdf->render();
$dompdf->stream('resultados.pdf', ['Attachment' => true]);
exit;
?>
