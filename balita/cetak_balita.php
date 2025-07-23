<?php
require_once 'dompdf/autoload.inc.php';
use Dompdf\Dompdf;

include "includes/db.php";

$dompdf = new Dompdf();
$html = '<h2 style="text-align:center;">Laporan Data Balita</h2>';
$html .= '<table border="1" width="100%" cellpadding="5" cellspacing="0">
<tr>
<th>ID</th><th>Nama</th><th>NIK</th><th>Alamat</th><th>Tempat Lahir</th>
<th>Tgl Lahir</th><th>JK</th><th>Ibu</th><th>NIK Ibu</th><th>Alamat Ibu</th><th>Telp</th>
</tr>';

$result = mysqli_query($conn, "SELECT * FROM data_balita");
while ($row = mysqli_fetch_assoc($result)) {
    $html .= "<tr>
        <td>{$row['id_balita']}</td>
        <td>{$row['na_balita']}</td>
        <td>{$row['nik_balita']}</td>
        <td>{$row['alamat_balita']}</td>
        <td>{$row['tempat_lahir']}</td>
        <td>{$row['tanggal_lahir_balita']}</td>
        <td>{$row['jenis_kelamin']}</td>
        <td>{$row['na_ibu']}</td>
        <td>{$row['nik_ibu']}</td>
        <td>{$row['alamat_ibu']}</td>
        <td>{$row['no_tlp']}</td>
    </tr>";
}
$html .= '</table>';

$dompdf->loadHtml($html);
$dompdf->setPaper('A4', 'landscape');
$dompdf->render();
$dompdf->stream('Laporan_Data_Balita.pdf', ['Attachment' => 0]);
