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

    // Cek apakah ID balita sudah ada
    $check_sql = "SELECT id_balita FROM data_balita WHERE id_balita = ?";
    $check_stmt = $conn->prepare($check_sql);
    $check_stmt->bind_param("s", $id_balita);
    $check_stmt->execute();
    $check_result = $check_stmt->get_result();
    
    if ($check_result->num_rows > 0) {
        // ID sudah ada, tampilkan SweetAlert2 error
        echo "<!DOCTYPE html>
        <html>
        <head>
            <title>Error - Duplicate ID</title>
            <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
        </head>
        <body>
            <script>
                Swal.fire({
                    icon: 'error',
                    title: 'ID Balita Sudah Digunakan!',
                    text: 'ID Balita \"$id_balita\" sudah terdaftar dalam sistem. Silakan gunakan ID yang berbeda.',
                    confirmButtonText: 'OK',
                    confirmButtonColor: '#8e2de2'
                }).then((result) => {
                    window.location.href = 'input_balita.php';
                });
            </script>
        </body>
        </html>";
        exit();
    }

    // Cek apakah NIK sudah ada
    $check_nik_sql = "SELECT nik_balita FROM data_balita WHERE nik_balita = ?";
    $check_nik_stmt = $conn->prepare($check_nik_sql);
    $check_nik_stmt->bind_param("s", $nik_balita);
    $check_nik_stmt->execute();
    $check_nik_result = $check_nik_stmt->get_result();
    
    if ($check_nik_result->num_rows > 0) {
        // NIK sudah ada, tampilkan SweetAlert2 error
        echo "<!DOCTYPE html>
        <html>
        <head>
            <title>Error - Duplicate NIK</title>
            <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
        </head>
        <body>
            <script>
                Swal.fire({
                    icon: 'error',
                    title: 'NIK Balita Sudah Terdaftar!',
                    text: 'NIK \"$nik_balita\" sudah terdaftar dalam sistem. Silakan periksa kembali data yang dimasukkan.',
                    confirmButtonText: 'OK',
                    confirmButtonColor: '#8e2de2'
                }).then((result) => {
                    window.location.href = 'input_balita.php';
                });
            </script>
        </body>
        </html>";
        exit();
    }

    // Siapkan query insert
    $sql = "INSERT INTO data_balita 
        (id_balita, na_ibu, nik_balita, na_balita, alamat_balita, tempat_lahir, tanggal_lahir_balita, jenis_kelamin, no_tlp)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";

    // Proses query
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("sssssssss", $id_balita, $na_ibu, $nik_balita, $na_balita, $alamat_balita, $tempat_lahir, $tanggal_lahir, $jenis_kelamin, $no_tlp);

        if ($stmt->execute()) {
            // ✅ Berhasil simpan
            echo "<!DOCTYPE html>
            <html>
            <head>
                <title>Success - Data Saved</title>
                <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
            </head>
            <body>
                <script>
                    Swal.fire({
                        icon: 'success',
                        title: 'Data Berhasil Disimpan!',
                        text: 'Data balita \"$na_balita\" telah berhasil ditambahkan ke sistem.',
                        confirmButtonText: 'Lihat Laporan',
                        confirmButtonColor: '#8e2de2',
                        showCancelButton: true,
                        cancelButtonText: 'Tambah Data Lagi',
                        cancelButtonColor: '#6c757d'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.href = 'laporan_balita.php';
                        } else {
                            window.location.href = 'input_balita.php';
                        }
                    });
                </script>
            </body>
            </html>";
        } else {
            // ❌ Error saat menyimpan
            echo "<!DOCTYPE html>
            <html>
            <head>
                <title>Error - Save Failed</title>
                <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
            </head>
            <body>
                <script>
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal Menyimpan Data!',
                        text: 'Terjadi kesalahan saat menyimpan data. Silakan coba lagi.',
                        confirmButtonText: 'OK',
                        confirmButtonColor: '#8e2de2'
                    }).then((result) => {
                        window.location.href = 'input_balita.php';
                    });
                </script>
            </body>
            </html>";
        }

        $stmt->close();
    } else {
        // ❌ Jika prepare gagal
        echo "<!DOCTYPE html>
        <html>
        <head>
            <title>Error - Prepare Failed</title>
            <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
        </head>
        <body>
            <script>
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal Mempersiapkan Data!',
                    text: 'Terjadi kesalahan saat mempersiapkan penyimpanan data.',
                    confirmButtonText: 'OK',
                    confirmButtonColor: '#8e2de2'
                }).then((result) => {
                    window.location.href = 'input_balita.php';
                });
            </script>
        </body>
        </html>";
    }

    $conn->close();
} else {
    // ❌ Jika tidak lewat POST
    echo "<!DOCTYPE html>
    <html>
    <head>
        <title>Error - Invalid Access</title>
        <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
    </head>
    <body>
        <script>
            Swal.fire({
                icon: 'warning',
                title: 'Akses Tidak Valid!',
                text: 'Halaman ini hanya dapat diakses melalui form input data.',
                confirmButtonText: 'OK',
                confirmButtonColor: '#8e2de2'
            }).then((result) => {
                window.location.href = 'input_balita.php';
            });
        </script>
    </body>
    </html>";
}
?>
