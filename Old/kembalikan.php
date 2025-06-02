<?php
session_start();
include 'db.php';

if ($_SESSION['role'] !== 'user') {
    exit("Akses ditolak.");
}

$id_user = $_SESSION['id'];
$id_peminjaman = $_GET['id'];
$tanggal_kembali = date('Y-m-d');

// Ambil data pinjaman
$q = mysqli_query($conn, "SELECT id_buku FROM peminjaman WHERE id = $id_peminjaman AND id_user = $id_user AND status = 'dipinjam'");
$data = mysqli_fetch_assoc($q);
if ($data) {
    $id_buku = $data['id_buku'];

    mysqli_query($conn, "UPDATE peminjaman SET status = 'kembali', tanggal_kembali = '$tanggal_kembali' WHERE id = $id_peminjaman");
    mysqli_query($conn, "UPDATE buku SET stok = stok + 1 WHERE id = $id_buku");
}

header("Location: user_dashboard.php#riwayat");
