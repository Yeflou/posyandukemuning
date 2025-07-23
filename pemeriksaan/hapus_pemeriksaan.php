<?php
include "includes/db.php";
session_start();

$id = $_GET['id'];
$sql = "DELETE FROM pemeriksaan_balita WHERE no_register='$id'";
if (mysqli_query($conn, $sql)) {
    echo "<script>alert('Data berhasil dihapus'); window.location.href='data_pemeriksaan.php';</script>";
} else {
    echo "Gagal hapus data: " . mysqli_error($conn);
}
