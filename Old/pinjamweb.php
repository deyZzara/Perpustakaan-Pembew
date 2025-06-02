<?php
session_start();
include 'db.php';

if ($_SESSION['role'] !== 'user') {
    exit("Akses ditolak.");
}

$id_user = $_SESSION['id'];
$id_buku = $_GET['id_buku'];
$tanggal_pinjam = date('Y-m-d');
$batas_waktu = date('Y-m-d', strtotime('+7 days'));

$buku = mysqli_query($conn, "SELECT stok FROM buku WHERE id = $id_buku");
$data = mysqli_fetch_assoc($buku);

if ($data['stok'] > 0) {
    mysqli_query($conn, "INSERT INTO peminjaman (id_user, id_buku, tanggal_pinjam, batas_waktu, status) VALUES ($id_user, $id_buku, '$tanggal_pinjam', '$batas_waktu', 'dipinjam')");
    mysqli_query($conn, "UPDATE buku SET stok = stok - 1 WHERE id = $id_buku");
}

header("Location: user_dashboard.php#aktif");
