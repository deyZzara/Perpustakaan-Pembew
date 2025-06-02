<?php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'staff') {
    header("Location: login_admin.php");
    exit;
}

include 'db.php';

// Proses validasi/penolakan
if (isset($_GET['action']) && isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $action = $_GET['action'];

    if ($action === 'terima') {
        mysqli_query($conn, "UPDATE users SET is_banned = 0 WHERE id = $id");
    } elseif ($action === 'tolak') {
        mysqli_query($conn, "UPDATE users SET is_banned = 1 WHERE id = $id");
    }
    header("Location: users.php");
    exit;
}

// Ambil semua user
$users = mysqli_query($conn, "SELECT * FROM users WHERE role = 'user' ORDER BY id DESC");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Validasi User</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-4">
    <h3 class="mb-4">Validasi User</h3>
    <a href="dashboard.php" class="btn btn-secondary mb-3">← Kembali ke Dashboard</a>
    <table class="table table-bordered bg-white">
        <thead>
            <tr>
                <th>ID</th>
                <th>Username</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
        <?php while ($row = mysqli_fetch_assoc($users)) : ?>
            <tr>
                <td><?= $row['id'] ?></td>
                <td><?= htmlspecialchars($row['username']) ?></td>
                <td>
                    <?= $row['is_banned'] == 1 ? "<span class='badge bg-danger'>Belum Aktif</span>" : "<span class='badge bg-success'>Aktif</span>" ?>
                </td>
                <td>
                    <?php if ($row['is_banned'] == 1): ?>
                        <a href="?action=terima&id=<?= $row['id'] ?>" class="btn btn-sm btn-primary">Terima</a>
                    <?php else: ?>
                        <a href="?action=tolak&id=<?= $row['id'] ?>" class="btn btn-sm btn-warning">Tolak</a>
                    <?php endif; ?>
                </td>
            </tr>
        <?php endwhile; ?>
        </tbody>
    </table>
</div>
</body>
</html>
