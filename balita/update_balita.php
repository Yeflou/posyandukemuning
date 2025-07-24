<?php
include "../includes/db.php";
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id_balita'];
    $na_ibu = $_POST['na_ibu'];
    $nik = $_POST['nik_balita'];
    $na_balita = $_POST['na_balita'];
    $alamat = $_POST['alamat_balita'];
    $tempat = $_POST['tempat_lahir'];
    $tanggal = $_POST['tanggal_lahir_balita'];
    $jk = $_POST['jenis_kelamin'];
    $telp = $_POST['no_tlp'];

    $sql = "UPDATE data_balita SET 
                na_ibu = ?, nik_balita = ?, na_balita = ?, alamat_balita = ?, 
                tempat_lahir = ?, tanggal_lahir_balita = ?, jenis_kelamin = ?, no_tlp = ?
            WHERE id_balita = ?";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssssssss", $na_ibu, $nik, $na_balita, $alamat, $tempat, $tanggal, $jk, $telp, $id);

    if ($stmt->execute()) {
        header("Location: laporan_balita.php?status=updated");
    } else {
        echo "Gagal mengupdate: " . $stmt->error;
    }
}
?>
