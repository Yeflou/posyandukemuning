<?php
include "../includes/db.php";
session_start();

// Cek session
if (!isset($_SESSION["username"])) {
    http_response_code(401);
    echo json_encode(['error' => 'Unauthorized']);
    exit();
}

// Cek method POST
if ($_SERVER["REQUEST_METHOD"] != "POST") {
    http_response_code(405);
    echo json_encode(['error' => 'Method not allowed']);
    exit();
}

// Ambil data dari request
$type = $_POST['type'] ?? '';
$value = $_POST['value'] ?? '';

if (empty($type) || empty($value)) {
    http_response_code(400);
    echo json_encode(['error' => 'Missing required parameters']);
    exit();
}

// Validasi tipe yang diperbolehkan
if (!in_array($type, ['no_register'])) {
    http_response_code(400);
    echo json_encode(['error' => 'Invalid type parameter']);
    exit();
}

try {
    // Siapkan query untuk mengecek duplikasi
    $sql = "SELECT COUNT(*) as count FROM pemeriksaan_balita WHERE $type = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $value);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    
    // Set header JSON
    header('Content-Type: application/json');
    
    // Return response
    echo json_encode([
        'exists' => $row['count'] > 0,
        'count' => $row['count']
    ]);
    
    $stmt->close();
    
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Database error: ' . $e->getMessage()]);
}

$conn->close();
?> 