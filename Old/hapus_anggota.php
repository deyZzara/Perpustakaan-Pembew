<?php
include 'db.php';
$id = $_GET['id'];

mysqli_query($conn, "DELETE FROM users WHERE id = $id AND role = 'user'");
header("Location: anggota.php");
?>