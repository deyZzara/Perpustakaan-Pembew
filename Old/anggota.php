<?php
// Koneksi database
include 'db.php'; // pastikan file ini menghubungkan ke database

// Ambil data user role 'user' (anggota)
$result = mysqli_query($conn, "SELECT * FROM users WHERE role = 'user'");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Manajemen Anggota</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body class="container mt-4">

    <h2>Manajemen Anggota</h2>
    <a href="tambah_anggota.php" class="btn btn-success mb-3">+ Tambah Anggota</a>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>No</th>
                <th>Username</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php $no=1; while ($row = mysqli_fetch_assoc($result)) { ?>
                <tr>
                    <td><?= $no++ ?></td>
                    <td><?= $row['username'] ?></td>
                    <td>
                        <?= $row['is_banned'] ? '<span class="text-danger">Nonaktif</span>' : '<span class="text-success">Aktif</span>' ?>
                    </td>
                    <td>
                        <a href="edit_anggota.php?id=<?= $row['id'] ?>" class="btn btn-primary btn-sm">Edit</a>
                        <a href="hapus_anggota.php?id=<?= $row['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus?')">Hapus</a>
                        <?php if ($row['is_banned']) { ?>
                            <a href="toggle_status.php?id=<?= $row['id'] ?>&aksi=aktifkan" class="btn btn-success btn-sm">Aktifkan</a>
                        <?php } else { ?>
                            <a href="toggle_status.php?id=<?= $row['id'] ?>&aksi=nonaktifkan" class="btn btn-warning btn-sm">Nonaktifkan</a>
                        <?php } ?>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>

</body>
</html>
