<?php
include "includes/db.php";
session_start();

$id = $_GET['id'];
$sql = "DELETE FROM data_balita WHERE id_balita='$id'";
if (mysqli_query($conn, $sql)) {
    echo "<script>alert('Data berhasil dihapus'); window.location.href='data_balita.php';</script>";
} else {
    echo "Gagal hapus data: " . mysqli_error($conn);
}
