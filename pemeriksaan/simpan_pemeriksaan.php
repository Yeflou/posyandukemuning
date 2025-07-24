<?php
include "../includes/db.php";
session_start();

// Default redirect
$redirect_page = "laporan_pemeriksaan.php";
$redirect_status = "error";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Ambil data dari form
    $no_register = $_POST['no_register'];
    $id_balita = $_POST['id_balita'];
    $bb_balita = $_POST['bb_balita'];
    $tb_balita = $_POST['tb_balita'];
    $lila_balita = $_POST['lila_balita'];
    $lika_balita = $_POST['lika_balita'];
    $tanggal_pemeriksaan = $_POST['tanggal_pemeriksaan'];

    // Query SQL
    $sql = "INSERT INTO pemeriksaan_balita (
                no_register, id_balita, bb_balita, tb_balita, 
                lila_balita, lika_balita, tanggal_pemeriksaan
            ) VALUES (?, ?, ?, ?, ?, ?, ?)";

    if ($stmt = $conn->prepare($sql)) {
        // 'ssdddss' artinya: 2 string, 3 double, 2 string
        $stmt->bind_param("ssdddss", 
            $no_register, $id_balita, 
            $bb_balita, $tb_balita, $lila_balita,
            $lika_balita, $tanggal_pemeriksaan
        );

        if ($stmt->execute()) {
            $redirect_status = "success";
        }

        $stmt->close();
    }

    $conn->close();
    header("Location: " . $redirect_page . "?status=" . $redirect_status);
    exit();
} else {
    // Jika bukan POST, langsung redirect
    header("Location: " . $redirect_page);
    exit();
}
?>
