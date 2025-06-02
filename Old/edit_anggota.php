<?php
include 'db.php';
$id = $_GET['id'];

$result = mysqli_query($conn, "SELECT * FROM users WHERE id = $id");
$data = mysqli_fetch_assoc($result);

if (isset($_POST['submit'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $query = "UPDATE users SET username = '$username', password = '$password' WHERE id = $id";
    mysqli_query($conn, $query);

    header("Location: anggota.php");
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Anggota</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body class="container mt-4">
    <h2>Edit Anggota</h2>
    <form method="POST">
        <div class="mb-3">
            <label>Username</label>
            <input type="text" name="username" value="<?= $data['username'] ?>" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Password</label>
            <input type="text" name="password" value="<?= $data['password'] ?>" class="form-control" required>
        </div>
        <button type="submit" name="submit" class="btn btn-primary">Update</button>
        <a href="anggota.php" class="btn btn-secondary">Kembali</a>
    </form>
</body>
</html>
