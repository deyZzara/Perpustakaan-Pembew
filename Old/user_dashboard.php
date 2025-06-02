<?php
session_start();
include 'db.php';
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'user') {
    header("Location: login.php");
    exit;
}

$id_user = $_SESSION['id'];
?>
<!DOCTYPE html>
<html>
<head>
    <title>Dashboard User</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container mt-4">
    <h2>Halo, <?= $_SESSION['username'] ?>!</h2>
    <a href="logout.php" class="btn btn-danger mb-3 float-end">Logout</a>
    <p>Selamat datang di Dashboard Perpustakaan.</p>
    <ul class="nav nav-tabs mb-3">
        <li class="nav-item">
            <a class="nav-link active" href="#buku" data-bs-toggle="tab">Daftar Buku</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#aktif" data-bs-toggle="tab">Pinjaman Aktif</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#riwayat" data-bs-toggle="tab">Riwayat Peminjaman</a>
        </li>
    </ul>

    <div class="tab-content">
        <!-- Daftar Buku -->
        <div class="tab-pane fade show active" id="buku">
            <h4>📘 Daftar Buku</h4>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Judul</th>
                        <th>Penulis</th>
                        <th>Stok</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $buku = mysqli_query($conn, "SELECT * FROM buku WHERE stok > 0");
                    while ($row = mysqli_fetch_assoc($buku)) {
                        echo "<tr>
                                <td>{$row['judul']}</td>
                                <td>{$row['penulis']}</td>
                                <td>{$row['stok']}</td>
                                <td>
                                    <a href='pinjamweb.php?id_buku={$row['id']}' class='btn btn-sm btn-success'>Pinjam</a>
                                </td>
                            </tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>

        <!-- Pinjaman Aktif -->
        <div class="tab-pane fade" id="aktif">
            <h4>🕓 Pinjaman Aktif</h4>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Judul</th>
                        <th>Tgl Pinjam</th>
                        <th>Batas Waktu</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $aktif = mysqli_query($conn, "
                        SELECT p.id, b.judul, p.tanggal_pinjam, p.batas_waktu 
                        FROM peminjaman p 
                        JOIN buku b ON p.id_buku = b.id 
                        WHERE p.id_user = $id_user AND p.status = 'dipinjam'
                    ");
                    while ($row = mysqli_fetch_assoc($aktif)) {
                        echo "<tr>
                                <td>{$row['judul']}</td>
                                <td>{$row['tanggal_pinjam']}</td>
                                <td>{$row['batas_waktu']}</td>
                                <td>
                                    <a href='kembalikan.php?id={$row['id']}' class='btn btn-sm btn-warning'>Kembalikan</a>
                                </td>
                              </tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>

        <!-- Riwayat Peminjaman -->
        <div class="tab-pane fade" id="riwayat">
            <h4>📖 Riwayat Peminjaman</h4>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Judul</th>
                        <th>Tgl Pinjam</th>
                        <th>Tgl Kembali</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $riwayat = mysqli_query($conn, "
                        SELECT b.judul, p.tanggal_pinjam, p.tanggal_kembali, p.status 
                        FROM peminjaman p 
                        JOIN buku b ON p.id_buku = b.id 
                        WHERE p.id_user = $id_user
                    ");
                    while ($row = mysqli_fetch_assoc($riwayat)) {
                        echo "<tr>
                                <td>{$row['judul']}</td>
                                <td>{$row['tanggal_pinjam']}</td>
                                <td>" . ($row['tanggal_kembali'] ?: '-') . "</td>
                                <td>{$row['status']}</td>
                              </tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
