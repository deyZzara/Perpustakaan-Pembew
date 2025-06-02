<?php
require 'db.php';

header('Content-Type: application/json');

$response = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_user = $_POST['id_user'] ?? '';
    $id_buku = $_POST['id_buku'] ?? '';

    if (!$id_user || !$id_buku) {
        echo json_encode(['success' => false, 'message' => 'Missing user or book ID']);
        exit;
    }

    $tanggal_pinjam = date('Y-m-d');
    $batas_waktu = date('Y-m-d', strtotime('+30 days'));

    $stmt = $conn->prepare("INSERT INTO peminjaman (id_user, id_buku, tanggal_pinjam, batas_waktu, status) VALUES (?, ?, ?, ?, 'menunggu')");
    $stmt->bind_param("iiss", $id_user, $id_buku, $tanggal_pinjam, $batas_waktu);

    if ($stmt->execute()) {
        $response = ['success' => true, 'message' => 'Peminjaman berhasil ditambahkan'];
    } else {
        $response = ['success' => false, 'message' => 'Gagal menyimpan peminjaman'];
    }

    $stmt->close();
    $conn->close();
} else {
    $response = ['success' => false, 'message' => 'Invalid request method'];
}

echo json_encode($response);
exit;
