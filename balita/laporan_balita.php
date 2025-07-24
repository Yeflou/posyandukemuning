<?php
include "../includes/db.php";
session_start();
if (!isset($_SESSION["username"])) {
    header("Location: ../auth/login.php");
    exit();
}

// Ambil data balita dari database
$query = "SELECT * FROM data_balita";
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Data Balita</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="../assets/css/dashboard.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>
    <script>
        // Fallback jika html2pdf gagal load
        window.addEventListener('load', function() {
            if (typeof html2pdf === 'undefined') {
                console.warn('html2pdf library tidak tersedia');
            }
        });
    </script>
    <style>
        /* Table scrolling styles */
        .table-container {
            max-height: 70vh;
            overflow-y: auto;
            border: 1px solid #ddd;
            border-radius: 8px;
        }
        
        .table-container table {
            margin: 0;
        }
        
        .table-container thead {
            position: sticky;
            top: 0;
            z-index: 1;
        }
        
        .table-container thead th {
            background-color: #e7d8fb;
            color: #8e2de2;
            border-bottom: 2px solid #ddd;
        }
        
        /* Fixed header styles */
        .header {
            position: fixed !important;
            top: 0 !important;
            left: 0 !important;
            right: 0 !important;
            z-index: 2000 !important;
            background: linear-gradient(to right, #8e2de2, #34c5cb);
            color: white;
            text-align: center;
            padding: 27px 20px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            margin: 0;
        }
        
        .header h1 {
            margin: 0;
            font-size: 24px;
        }
        
        .header small {
            font-size: 13px;
            margin: 0;
        }
        
        /* Fixed sidebar styles */
        .sidebar {
            position: fixed !important;
            top: 90px !important; /* Reduced gap - adjust based on header height */
            left: 0 !important;
            width: 300px !important;
            height: calc(100vh - 90px) !important;
            overflow-y: auto;
            z-index: 1000;
            background-color: #a55eea;
            padding: 20px 10px;
            color: white;
            display: flex;
            flex-direction: column;
            align-items: center;
            box-shadow: 2px 0 10px rgba(0,0,0,0.1);
            scroll-behavior: smooth;
            margin: 0;
        }
        
        .main {
            margin-left: 320px !important; /* Give space for fixed sidebar */
            margin-top: 70px !important; /* Reduced space for fixed header */
            width: calc(100% - 320px) !important;
            padding: 30px;
            text-align: left;
        }
        
        /* Responsive for mobile */
        @media(max-width: 768px) {
            .header {
                position: relative !important;
                padding: 15px;
                margin: 0;
            }
            
            .header h1 {
                font-size: 20px;
                margin: 0;
            }
            
            .header small {
                font-size: 11px;
                margin: 0;
            }
            
            .sidebar {
                position: static !important;
                width: 100% !important;
                height: auto !important;
                top: auto !important;
                left: auto !important;
                margin: 0;
            }
            
            .main {
                margin-left: 0 !important;
                margin-top: 20px !important;
                width: 100% !important;
                padding: 15px;
            }
        }
        
        /* Action buttons horizontal alignment */
        .action-buttons {
            display: flex;
            gap: 5px;
            justify-content: center;
            align-items: center;
        }
        
        .action-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 32px;
            height: 32px;
            border-radius: 50%;
            text-decoration: none;
            transition: all 0.3s ease;
            font-size: 14px;
        }
        
        .action-btn.edit {
            background-color: #ffc107;
            color: #000;
        }
        
        .action-btn.edit:hover {
            background-color: #e0a800;
        }
        
        .action-btn.delete {
            background-color: #dc3545;
            color: white;
        }
        
        .action-btn.delete:hover {
            background-color: #c82333;
        }
        
        /* Filter dropdown styles */
        .filter-container {
            display: flex;
            gap: 10px;
            align-items: center;
            margin-bottom: 20px;
        }
        
        .filter-select {
            padding: 8px 15px;
            border-radius: 20px;
            border: 1px solid #ccc;
            background-color: #e7d8fb;
            font-size: 14px;
        }
        
        /* Print styles for PDF */
        @media print {
            .header, .sidebar, .search-container, .action-buttons {
                display: none !important;
            }
            
            .main {
                padding: 0 !important;
                margin-left: 0 !important;
                margin-top: 0 !important;
                width: 100% !important;
            }
            
            .table-container {
                max-height: none !important;
                overflow: visible !important;
            }
        }
        
        /* Ensure container doesn't interfere with fixed sidebar */
        .container {
            position: relative;
        }
        
        /* Ensure body doesn't have default margins */
        body {
            margin: 0;
            padding: 0;
            overflow-x: hidden;
            scroll-behavior: smooth;
        }
    </style>
</head>
<body>

<div class="header">
    <h1>Sistem Informasi Pendaftaran dan Pemeriksaan Balita di Posyandu Kemuning 13</h1>
    <small>Jl KH Samanhudi No. 186, Jantirejo RT 01 RW 13, Sondakan, Laweyan, Surakarta</small>
</div>

<div class="container">
    <div class="sidebar">
        <a href="../auth/beranda.php"><i class="fas fa-home"></i> Beranda</a>
        <a href="input_balita.php"><i class="fas fa-user-plus"></i> Input Data Balita</a>
        <a href="../pemeriksaan/input_pemeriksaan.php"><i class="fas fa-notes-medical"></i> Input Data Pemeriksaan Balita</a>
        <a href="laporan_balita.php"><i class="fas fa-file-alt"></i> Laporan Data Balita</a>
        <a href="../pemeriksaan/laporan_pemeriksaan.php"><i class="fas fa-shield-alt"></i> Laporan Pemeriksaan Balita</a>
        <a href="../auth/logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a>
    </div>

    <div class="main">
        <h2>Laporan Data Balita</h2>

        <!-- Search dan Filter -->
        <div class="search-container">
            <div class="search-box">
                <input type="text" id="searchInput" placeholder="Cari Data Balita">
                <i class="fas fa-search"></i>
            </div>

            <button onclick="downloadPDF()" class="download-btn">
                <i class="fas fa-download"></i> Download PDF
            </button>
        </div>

        <!-- Filter Options -->
        <div class="filter-container">
            <label for="filterCategory">Filter berdasarkan:</label>
            <select id="filterCategory" class="filter-select">
                <option value="all">Semua Kategori</option>
                <option value="id_balita">ID Balita</option>
                <option value="na_ibu">Nama Ibu Balita</option>
                <option value="na_balita">Nama Balita</option>
                <option value="nik_balita">NIK Balita</option>
                <option value="alamat_balita">Alamat Balita</option>
                <option value="tempat_lahir">Tempat Lahir</option>
                <option value="tanggal_lahir_balita">Tanggal Lahir</option>
                <option value="jenis_kelamin">Jenis Kelamin</option>
                <option value="no_tlp">No. Telp</option>
            </select>
        </div>

        <!-- Tabel dengan scrolling -->
        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Id Balita</th>
                        <th>Nama Ibu Balita</th>
                        <th>Nama Balita</th>
                        <th>NIK Balita</th>
                        <th>Alamat Balita</th>
                        <th>Tempat Lahir</th>
                        <th>Tanggal Lahir</th>
                        <th>Jenis Kelamin</th>
                        <th>No. Telp</th>
                        <th style="width: 80px;">Aksi</th>
                    </tr>
                </thead>
                <tbody id="dataBody">
                    <?php
                    $no = 1;
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo "<tr>";
                        echo "<td>{$no}.</td>";
                        echo "<td data-category='id_balita'>{$row['id_balita']}</td>";
                        echo "<td data-category='na_ibu'>{$row['na_ibu']}</td>";
                        echo "<td data-category='na_balita'>{$row['na_balita']}</td>";
                        echo "<td data-category='nik_balita'>{$row['nik_balita']}</td>";
                        echo "<td data-category='alamat_balita'>{$row['alamat_balita']}</td>";
                        echo "<td data-category='tempat_lahir'>{$row['tempat_lahir']}</td>";
                        echo "<td data-category='tanggal_lahir_balita'>{$row['tanggal_lahir_balita']}</td>";
                        echo "<td data-category='jenis_kelamin'>{$row['jenis_kelamin']}</td>";
                        echo "<td data-category='no_tlp'>{$row['no_tlp']}</td>";
                        echo "<td>
                            <div class='action-buttons'>
                                <a href='edit_balita.php?id={$row['id_balita']}' class='action-btn edit' title='Edit'>
                                    <i class='fas fa-edit'></i>
                                </a>
                                <a href='#' onclick=\"confirmDelete('{$row['id_balita']}', '{$row['na_balita']}')\" class='action-btn delete' title='Hapus'>
                                    <i class='fas fa-trash-alt'></i>
                                </a>
                            </div>
                        </td>";
                        echo "</tr>";
                        $no++;
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>



<!-- Filter Search JS -->
<script>
document.addEventListener("DOMContentLoaded", function () {
    const searchInput = document.getElementById("searchInput");
    const filterCategory = document.getElementById("filterCategory");
    const dataBody = document.getElementById("dataBody");

    function performSearch() {
        const filter = searchInput.value.toLowerCase();
        const category = filterCategory.value;
        const rows = dataBody.querySelectorAll("tr");

        rows.forEach(row => {
            let text = "";
            
            if (category === "all") {
                // Search in all columns
                text = row.innerText.toLowerCase();
            } else {
                // Search in specific category
                const categoryCell = row.querySelector(`td[data-category="${category}"]`);
                if (categoryCell) {
                    text = categoryCell.textContent.toLowerCase();
                }
            }
            
            row.style.display = text.includes(filter) ? "" : "none";
        });
    }

    if (searchInput && dataBody) {
        searchInput.addEventListener("keyup", performSearch);
    }

    if (filterCategory) {
        filterCategory.addEventListener("change", performSearch);
    }
    
    // Add event listener for download button
    const downloadBtn = document.querySelector('.download-btn');
    if (downloadBtn) {
        downloadBtn.addEventListener('click', function(e) {
            e.preventDefault();
            console.log('Download button clicked');
            downloadPDF();
        });
    }
});

// Fungsi download PDF yang hanya mengambil data tabel
function downloadPDF() {
    console.log('downloadPDF function called');
    
    try {
        // Check if html2pdf is available
        if (typeof html2pdf === 'undefined') {
            console.error('html2pdf is not defined');
            alert('Library PDF tidak tersedia. Silakan refresh halaman dan coba lagi.');
            return;
        }

        console.log('html2pdf is available');

        // Clone the table for PDF
        const originalTable = document.querySelector('.table-container table');
        if (!originalTable) {
            console.error('Table not found');
            alert('Tabel tidak ditemukan. Silakan refresh halaman dan coba lagi.');
            return;
        }

        console.log('Table found:', originalTable);

        // Check if there's data in the table
        const rows = originalTable.querySelectorAll('tbody tr');
        if (rows.length === 0) {
            console.error('No data rows found');
            alert('Tidak ada data untuk di-download.');
            return;
        }

        console.log(`Found ${rows.length} rows of data for PDF`);

        const pdfTable = originalTable.cloneNode(true);
        
        // Remove action buttons from PDF table
        const actionCells = pdfTable.querySelectorAll('td:last-child');
        actionCells.forEach(cell => {
            cell.innerHTML = '';
        });
        
        // Remove the last header (Aksi)
        const headerRow = pdfTable.querySelector('thead tr');
        if (headerRow) {
            const lastHeader = headerRow.querySelector('th:last-child');
            if (lastHeader) {
                lastHeader.remove();
            }
        }
        
        // Remove the last cell from each row
        const tableRows = pdfTable.querySelectorAll('tbody tr');
        tableRows.forEach(row => {
            const lastCell = row.querySelector('td:last-child');
            if (lastCell) {
                lastCell.remove();
            }
        });

        // Create PDF content dynamically
        const pdfContent = document.createElement('div');
        pdfContent.style.padding = '20px';
        pdfContent.style.fontFamily = 'Arial, sans-serif';
        
        // Add header
        const header = document.createElement('div');
        header.style.textAlign = 'center';
        header.style.marginBottom = '20px';
        header.innerHTML = `
            <h2 style="color: #8e2de2; margin: 0; font-size: 18px;">Laporan Data Balita</h2>
            <p style="margin: 5px 0; color: #666; font-size: 12px;">Sistem Informasi Posyandu Kemuning 13</p>
            <p style="margin: 5px 0; color: #666; font-size: 12px;">Jl KH Samanhudi No. 186, Jantirejo RT 01 RW 13, Sondakan, Laweyan, Surakarta</p>
            <hr style="border: 1px solid #ddd; margin: 20px 0;">
        `;
        
        // Add table with proper styling
        const tableContainer = document.createElement('div');
        tableContainer.style.overflowX = 'auto';
        
        // Style the table for PDF
        pdfTable.style.width = '100%';
        pdfTable.style.borderCollapse = 'collapse';
        pdfTable.style.fontSize = '8px'; // Smaller font for more data
        pdfTable.style.tableLayout = 'fixed';
        
        // Style table headers
        const headers = pdfTable.querySelectorAll('th');
        headers.forEach(header => {
            header.style.backgroundColor = '#e7d8fb';
            header.style.color = '#8e2de2';
            header.style.padding = '4px';
            header.style.border = '1px solid #ddd';
            header.style.fontWeight = 'bold';
            header.style.fontSize = '8px';
            header.style.wordWrap = 'break-word';
        });
        
        // Style table cells
        const cells = pdfTable.querySelectorAll('td');
        cells.forEach(cell => {
            cell.style.padding = '3px';
            cell.style.border = '1px solid #ddd';
            cell.style.textAlign = 'left';
            cell.style.fontSize = '7px';
            cell.style.wordWrap = 'break-word';
            cell.style.overflow = 'hidden';
        });
        
        tableContainer.appendChild(pdfTable);
        pdfContent.appendChild(header);
        pdfContent.appendChild(tableContainer);
        
        // PDF options
        const opt = {
            margin: [0.3, 0.3, 0.3, 0.3], // Smaller margins
            filename: 'laporan_data_balita.pdf',
            image: { type: 'jpeg', quality: 0.98 },
            html2canvas: { 
                scale: 1.5, // Reduced scale for better performance
                useCORS: true,
                allowTaint: true,
                scrollY: 0,
                scrollX: 0
            },
            jsPDF: { 
                unit: 'in', 
                format: 'a4', 
                orientation: 'landscape',
                compress: true
            },
            pagebreak: { mode: ['avoid-all', 'css', 'legacy'] }
        };
        
        console.log('PDF content created, starting generation...');
        
        // Show loading message
        Swal.fire({
            title: 'Membuat PDF...',
            text: 'Mohon tunggu sebentar',
            allowOutsideClick: false,
            didOpen: () => {
                Swal.showLoading();
            }
        });
        
        // Generate PDF with better error handling
        console.log('Calling html2pdf...');
        html2pdf().set(opt).from(pdfContent).save().then(() => {
            console.log('PDF generated successfully');
            Swal.close();
        }).catch((error) => {
            console.error('PDF generation error:', error);
            Swal.close();
            Swal.fire({
                icon: 'error',
                title: 'Gagal membuat PDF',
                text: 'Terjadi kesalahan saat membuat PDF. Silakan coba lagi.',
                confirmButtonText: 'OK'
            });
        });
        
    } catch (error) {
        console.error('Error in downloadPDF:', error);
        Swal.fire({
            icon: 'error',
            title: 'Gagal membuat PDF',
            text: 'Terjadi kesalahan: ' + error.message,
            confirmButtonText: 'OK'
        });
    }
}

// Fungsi konfirmasi hapus dengan SweetAlert2
function confirmDelete(idBalita, namaBalita) {
    Swal.fire({
        icon: 'warning',
        title: 'Hapus Data Balita?',
        html: `Apakah Anda yakin ingin menghapus data balita <strong>${namaBalita}</strong> (ID: ${idBalita})?<br><br><small style="color: #dc3545;">Tindakan ini tidak dapat dibatalkan!</small>`,
        showCancelButton: true,
        confirmButtonText: 'Ya, Hapus',
        cancelButtonText: 'Batal',
        confirmButtonColor: '#dc3545',
        cancelButtonColor: '#6c757d',
        reverseButtons: true
    }).then((result) => {
        if (result.isConfirmed) {
            // Redirect ke halaman hapus
            window.location.href = `hapus_balita.php?id=${idBalita}`;
        }
    });
}

// Tampilkan notifikasi jika ada parameter status di URL
document.addEventListener("DOMContentLoaded", function() {
    const urlParams = new URLSearchParams(window.location.search);
    const status = urlParams.get('status');
    const message = urlParams.get('message');
    
    if (status === 'success' && message) {
        Swal.fire({
            icon: 'success',
            title: 'Berhasil!',
            text: message,
            confirmButtonText: 'OK',
            confirmButtonColor: '#8e2de2'
        });
    } else if (status === 'error' && message) {
        Swal.fire({
            icon: 'error',
            title: 'Gagal!',
            text: message,
            confirmButtonText: 'OK',
            confirmButtonColor: '#8e2de2'
        });
    }
});
</script>

</body>
</html>
