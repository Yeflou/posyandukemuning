<?php
include('../includes/db.php'); // pastikan path sesuai
session_start();

// Cek apakah ID dikirim dari URL
if (isset($_GET['id'])) {
    $id_balita = mysqli_real_escape_string($conn, $_GET['id']);

    // Jalankan query hapus
    $query = "DELETE FROM data_balita WHERE id_balita = '$id_balita'";
    $result = mysqli_query($conn, $query);

    if (!$result) {
        die("Gagal menghapus data: " . mysqli_error($conn));
    }

    // Set session untuk notifikasi
    $_SESSION['message'] = "✅ Data balita berhasil dihapus.";
    $_SESSION['message_type'] = "success";

    // Redirect kembali ke laporan
    header("Location: laporan_balita.php");
    exit();
} else {
    // Jika tidak ada ID, kembali tanpa aksi
    header("Location: laporan_balita.php");
    exit();
}
?>
