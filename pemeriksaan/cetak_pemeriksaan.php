<?php
require_once 'dompdf/autoload.inc.php';
use Dompdf\Dompdf;

include "includes/db.php";

$dompdf = new Dompdf();
$html = '<h2 style="text-align:center;">Laporan Pemeriksaan Balita</h2>';
$html .= '<table border="1" width="100%" cellpadding="5" cellspacing="0">
<tr>
<th>No</th><th>ID Balita</th><th>Nama</th><th>BB</th><th>TB</th><th>LILA</th><th>LIKA</th><th>Tanggal</th>
</tr>';

$result = mysqli_query($conn, "SELECT p.*, d.na_balita FROM pemeriksaan_balita p JOIN data_balita d ON p.id_balita = d.id_balita");
while ($row = mysqli_fetch_assoc($result)) {
    $html .= "<tr>
        <td>{$row['no_register']}</td>
        <td>{$row['id_balita']}</td>
        <td>{$row['na_balita']}</td>
        <td>{$row['bb_balita']} kg</td>
        <td>{$row['tb_balita']} cm</td>
        <td>{$row['lila_balita']} cm</td>
        <td>{$row['lika_balita']} cm</td>
        <td>{$row['tanggal_pemeriksaan']}</td>
    </tr>";
}
$html .= '</table>';

$dompdf->loadHtml($html);
$dompdf->setPaper('A4', 'landscape');
$dompdf->render();
$dompdf->stream('Laporan_Pemeriksaan_Balita.pdf', ['Attachment' => 0]);
?>
