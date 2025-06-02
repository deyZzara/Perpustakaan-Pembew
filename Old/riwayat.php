<?php
include 'db.php';

$query = "
SELECT p.*, u.username, b.judul 
FROM peminjaman p
JOIN users u ON p.id_user = u.id
JOIN buku b ON p.id_buku = b.id
ORDER BY p.tanggal_pinjam DESC
";

$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Riwayat Peminjaman</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body class="container mt-4">

    <h2>Riwayat Peminjaman Buku</h2>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>No</th>
                <th>Username</th>
                <th>Judul Buku</th>
                <th>Tanggal Pinjam</th>
                <th>Batas Waktu</th>
                <th>Tanggal Kembali</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            <?php $no=1; while ($row = mysqli_fetch_assoc($result)) { ?>
                <tr>
                    <td><?= $no++ ?></td>
                    <td><?= $row['username'] ?></td>
                    <td><?= $row['judul'] ?></td>
                    <td><?= $row['tanggal_pinjam'] ?></td>
                    <td><?= $row['batas_waktu'] ?></td>
                    <td><?= $row['tanggal_kembali'] ? $row['tanggal_kembali'] : '-' ?></td>
                    <td>
                        <?php
                            if ($row['status'] == 'dipinjam') {
                                echo '<span class="badge bg-warning text-dark">Dipinjam</span>';
                            } else {
                                echo '<span class="badge bg-success">Kembali</span>';
                            }
                        ?>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>

</body>
</html>
