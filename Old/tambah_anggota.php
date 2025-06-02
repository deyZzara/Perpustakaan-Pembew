<?php
include 'db.php';

if (isset($_POST['submit'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    
    // Disesuaikan dengan metode penyimpanan password kamu
    $password_hash = $password; // <- ganti ini kalau kamu pakai hash

    $sql = "INSERT INTO users (username, password, role, is_banned) 
            VALUES ('$username', '$password_hash', 'user', 0)";
    mysqli_query($conn, $sql);
    header("Location: anggota.php");
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Tambah Anggota</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body class="container mt-4">
    <h2>Tambah Anggota</h2>
    <form method="POST">
        <div class="mb-3">
            <label>Username</label>
            <input type="text" name="username" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Password</label>
            <input type="text" name="password" class="form-control" required>
        </div>
        <button type="submit" name="submit" class="btn btn-success">Simpan</button>
        <a href="anggota.php" class="btn btn-secondary">Kembali</a>
    </form>
</body>
</html>
