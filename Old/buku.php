<?php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'staff') {
    header("Location: login_admin.php");
    exit;
}
include 'db.php';

// Tambah buku
if (isset($_POST['tambah'])) {
    $judul = $_POST['judul'];
    $penulis = $_POST['penulis'];
    $usia = $_POST['rekomendasi_usia'];
    $cover = $_POST['cover'];
    $deskripsi = $_POST['deskripsi'];

    mysqli_query($conn, "INSERT INTO buku (judul, penulis, rekomendasi_usia, cover, deskripsi) 
                        VALUES ('$judul', '$penulis', '$usia', '$cover', '$deskripsi')");
    header("Location: buku.php");
    exit;
}

// Edit buku
if (isset($_POST['edit'])) {
    $id = $_POST['id'];
    $judul = $_POST['judul'];
    $penulis = $_POST['penulis'];
    $usia = $_POST['rekomendasi_usia'];
    $cover = $_POST['cover'];
    $deskripsi = $_POST['deskripsi'];

    mysqli_query($conn, "UPDATE buku SET judul='$judul', penulis='$penulis', rekomendasi_usia='$usia', cover='$cover', deskripsi='$deskripsi' WHERE id=$id");
    header("Location: buku.php");
    exit;
}

// Hapus buku
if (isset($_GET['hapus'])) {
    $id = intval($_GET['hapus']);
    mysqli_query($conn, "DELETE FROM buku WHERE id = $id");
    header("Location: buku.php");
    exit;
}

// Ambil semua buku
$buku = mysqli_query($conn, "SELECT * FROM buku ORDER BY id DESC");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Buku</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 2rem;
        }
        .page-header {
            background: linear-gradient(135deg, #6c5ce7, #a363d9);
            color: white;
            padding: 2rem;
            border-radius: 10px;
            margin-bottom: 2rem;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        .btn {
            border-radius: 5px;
            padding: 0.5rem 1rem;
            font-weight: 500;
            transition: all 0.3s ease;
        }
        .btn-success {
            background: #00b894;
            border: none;
        }
        .btn-success:hover {
            background: #00a187;
            transform: translateY(-2px);
        }
        .btn-warning {
            background: #fdcb6e;
            border: none;
        }
        .btn-danger {
            background: #d63031;
            border: none;
        }
        .table {
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        .table thead {
            background: #6c5ce7;
            color: white;
        }
        .table th {
            font-weight: 500;
            padding: 1rem;
        }
        .table td {
            padding: 1rem;
            vertical-align: middle;
        }
        .table img {
            border-radius: 5px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
        .modal-content {
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        .modal-header {
            background: linear-gradient(135deg, #6c5ce7, #a363d9);
            color: white;
            border-bottom: none;
        }
        .modal-title {
            font-weight: 600;
        }
        .form-control {
            border-radius: 5px;
            padding: 0.7rem;
            border: 1px solid #ddd;
            margin-bottom: 1rem;
        }
        .form-control:focus {
            border-color: #6c5ce7;
            box-shadow: 0 0 0 0.2rem rgba(108, 92, 231, 0.25);
        }
        .btn-close {
            color: white;
        }
        .back-button {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            margin-bottom: 1rem;
        }
        .action-buttons {
            display: flex;
            gap: 0.5rem;
        }
    </style>
</head>
<body>
<div class="container">
    <div class="page-header">
        <h3 class="mb-0">Kelola Buku</h3>
    </div>

    <a href="dashboard.php" class="btn btn-secondary back-button mb-3">
        <i class="fas fa-arrow-left"></i> Kembali ke Dashboard
    </a>

    <button class="btn btn-success mb-3" data-bs-toggle="modal" data-bs-target="#modalTambah">
        <i class="fas fa-plus"></i> Tambah Buku
    </button>

    <div class="table-responsive">
        <table class="table table-hover bg-white">
            <thead>
                <tr>
                    <th>Judul</th>
                    <th>Penulis</th>
                    <th>Usia</th>
                    <th>Cover</th>
                    <th>Deskripsi</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
<?php 
$modals = ''; // Tempat menyimpan semua modal yang akan ditaruh di bawah tabel
while ($row = mysqli_fetch_assoc($buku)) : 
?>
    <tr>
        <td><?= htmlspecialchars($row['judul']) ?></td>
        <td><?= htmlspecialchars($row['penulis']) ?></td>
        <td><?= $row['rekomendasi_usia'] ?>+</td>
        <td><img src="<?= $row['cover'] ?>" width="50" height="50" style="object-fit: cover;"></td>
        <td><?= substr($row['deskripsi'], 0, 50) ?>...</td>
        <td class="action-buttons">
            <button class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#modalEdit<?= $row['id'] ?>">
                <i class="fas fa-edit"></i> Edit
            </button>
            <a href="?hapus=<?= $row['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Yakin ingin menghapus?')">
                <i class="fas fa-trash"></i> Hapus
            </a>
        </td>
    </tr>

<?php
// Simpan modal edit ke dalam variabel untuk ditaruh di bawah setelah table
$modals .= '
<div class="modal fade" id="modalEdit'.$row['id'].'" tabindex="-1">
    <div class="modal-dialog">
        <form method="post" class="modal-content">
            <input type="hidden" name="id" value="'.$row['id'].'">
            <div class="modal-header">
                <h5 class="modal-title">Edit Buku</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label class="form-label">Judul</label>
                    <input type="text" name="judul" class="form-control" value="'.htmlspecialchars($row['judul']).'" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Penulis</label>
                    <input type="text" name="penulis" class="form-control" value="'.htmlspecialchars($row['penulis']).'" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Rekomendasi Usia</label>
                    <input type="number" name="rekomendasi_usia" class="form-control" value="'.$row['rekomendasi_usia'].'" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">URL Cover</label>
                    <input type="text" name="cover" class="form-control" value="'.htmlspecialchars($row['cover']).'">
                </div>
                <div class="mb-3">
                    <label class="form-label">Deskripsi</label>
                    <textarea name="deskripsi" class="form-control" rows="4">'.htmlspecialchars($row['deskripsi']).'</textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="submit" name="edit" class="btn btn-warning">
                    <i class="fas fa-save"></i> Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>
';
endwhile;
?>
</tbody>

        </table>
    </div>
</div>

<!-- Modal Tambah Buku -->
<div class="modal fade" id="modalTambah" tabindex="-1">
    <div class="modal-dialog">
        <form method="post" class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Buku</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label class="form-label">Judul</label>
                    <input type="text" name="judul" class="form-control" placeholder="Masukkan judul buku" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Penulis</label>
                    <input type="text" name="penulis" class="form-control" placeholder="Masukkan nama penulis" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Rekomendasi Usia</label>
                    <input type="number" name="rekomendasi_usia" class="form-control" placeholder="Masukkan rekomendasi usia" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">URL Cover</label>
                    <input type="text" name="cover" class="form-control" placeholder="Masukkan URL gambar cover">
                </div>
                <div class="mb-3">
                    <label class="form-label">Deskripsi</label>
                    <textarea name="deskripsi" class="form-control" rows="4" placeholder="Masukkan deskripsi buku"></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="submit" name="tambah" class="btn btn-success">
                    <i class="fas fa-save"></i> Simpan
                </button>
            </div>
        </form>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<?= $modals ?>

</body>
</html>
