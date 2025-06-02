<?php
include 'db.php';
$id = $_GET['id'];
$aksi = $_GET['aksi'];

if ($aksi == 'nonaktifkan') {
    mysqli_query($conn, "UPDATE users SET is_banned = 1 WHERE id = $id AND role = 'user'");
} elseif ($aksi == 'aktifkan') {
    mysqli_query($conn, "UPDATE users SET is_banned = 0 WHERE id = $id AND role = 'user'");
}

header("Location: anggota.php");
?>
