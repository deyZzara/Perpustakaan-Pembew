<?php
include 'db.php';

// Buku paling sering dipinjam
$buku_terpopuler = mysqli_query($conn, "
    SELECT b.judul, COUNT(p.id_buku) AS total_dipinjam
    FROM peminjaman p
    JOIN buku b ON p.id_buku = b.id
    GROUP BY p.id_buku
    ORDER BY total_dipinjam DESC
    LIMIT 5
");

// Anggota dengan pinjaman terbanyak
$anggota_teraktif = mysqli_query($conn, "
    SELECT u.username, COUNT(p.id_user) AS total_pinjam
    FROM peminjaman p
    JOIN users u ON p.id_user = u.id
    WHERE u.role = 'user'
    GROUP BY p.id_user
    ORDER BY total_pinjam DESC
    LIMIT 5
");

// Pinjaman yang belum dikembalikan
$pinjaman_aktif = mysqli_query($conn, "
    SELECT p.*, u.username, b.judul
    FROM peminjaman p
    JOIN users u ON p.id_user = u.id
    JOIN buku b ON p.id_buku = b.id
    WHERE p.status = 'dipinjam'
    ORDER BY p.tanggal_pinjam DESC
");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Laporan Perpustakaan</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body class="container mt-4">

    <h2>Laporan Perpustakaan</h2>

    <!-- Buku Terpopuler -->
    <h4 class="mt-4">📚 Buku Paling Sering Dipinjam</h4>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>No</th>
                <th>Judul Buku</th>
                <th>Jumlah Dipinjam</th>
            </tr>
        </thead>
        <tbody>
            <?php $no=1; while($buku = mysqli_fetch_assoc($buku_terpopuler)) { ?>
                <tr>
                    <td><?= $no++ ?></td>
                    <td><?= $buku['judul'] ?></td>
                    <td><?= $buku['total_dipinjam'] ?></td>
                </tr>
            <?php } ?>
        </tbody>
    </table>

    <!-- Anggota Teraktif -->
    <h4 class="mt-4">👤 Anggota Peminjam Terbanyak</h4>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>No</th>
                <th>Username</th>
                <th>Jumlah Peminjaman</th>
            </tr>
        </thead>
        <tbody>
            <?php $no=1; while($anggota = mysqli_fetch_assoc($anggota_teraktif)) { ?>
                <tr>
                    <td><?= $no++ ?></td>
                    <td><?= $anggota['username'] ?></td>
                    <td><?= $anggota['total_pinjam'] ?></td>
                </tr>
            <?php } ?>
        </tbody>
    </table>

    <!-- Pinjaman Aktif -->
    <h4 class="mt-4">📖 Pinjaman yang Belum Dikembalikan</h4>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>No</th>
                <th>Username</th>
                <th>Judul Buku</th>
                <th>Tanggal Pinjam</th>
                <th>Batas Waktu</th>
            </tr>
        </thead>
        <tbody>
            <?php $no=1; while($row = mysqli_fetch_assoc($pinjaman_aktif)) { ?>
                <tr>
                    <td><?= $no++ ?></td>
                    <td><?= $row['username'] ?></td>
                    <td><?= $row['judul'] ?></td>
                    <td><?= $row['tanggal_pinjam'] ?></td>
                    <td><?= $row['batas_waktu'] ?></td>
                </tr>
            <?php } ?>
        </tbody>
    </table>

</body>
</html>
