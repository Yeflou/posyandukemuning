<?php
include "../includes/db.php";
session_start();

// Cek jika method POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Ambil data dari form
    $id_balita           = $_POST['id_balita'];
    $na_ibu              = $_POST['na_ibu'];
    $nik_balita          = $_POST['nik_balita'];
    $na_balita           = $_POST['na_balita'];
    $alamat_balita       = $_POST['alamat_balita'];
    $tempat_lahir        = $_POST['tempat_lahir'];
    $tanggal_lahir       = $_POST['tanggal_lahir_balita'];
    $jenis_kelamin       = $_POST['jenis_kelamin'];
    $no_tlp              = $_POST['no_tlp'];

    // Siapkan query insert
    $sql = "INSERT INTO data_balita 
        (id_balita, na_ibu, nik_balita, na_balita, alamat_balita, tempat_lahir, tanggal_lahir_balita, jenis_kelamin, no_tlp)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";

    // Proses query
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("sssssssss", $id_balita, $na_ibu, $nik_balita, $na_balita, $alamat_balita, $tempat_lahir, $tanggal_lahir, $jenis_kelamin, $no_tlp);

        if ($stmt->execute()) {
            // ✅ Berhasil simpan
            echo "<script>
                alert('Data berhasil disimpan!');
                window.parent.loadPage('/posyandukemuning/balita/laporan_balita.php');
            </script>";
        } else {
            // ❌ Jika ID sudah digunakan
            if ($conn->errno == 1062) {
                echo "<script>
                    alert('ID Balita sudah digunakan, masukkan ID yang baru!');
                    window.history.back();
                </script>";
            } else {
                echo "<script>
                    alert('Terjadi kesalahan saat menyimpan data!');
                    window.history.back();
                </script>";
            }
        }

        $stmt->close();
    } else {
        // ❌ Jika prepare gagal
        echo "<script>
            alert('Gagal mempersiapkan penyimpanan data!');
            window.history.back();
        </script>";
    }

    $conn->close();
} else {
    // ❌ Jika tidak lewat POST
    echo "<script>
        alert('Akses tidak valid!');
        window.history.back();
    </script>";
}
?>
