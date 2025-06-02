<?php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'staff') {
    header("Location: login_admin.php");
    exit;
}
include 'db.php';

// Ubah status peminjaman
if (isset($_POST['ubah_status'])) {
    $id = $_POST['id'];
    $status = $_POST['status'];
    $id_buku = $_POST['id_buku'];
    $status_lama = $_POST['status_lama'];
    
    // Mulai transaction
    mysqli_begin_transaction($conn);
    
    try {
        // Update status peminjaman
        mysqli_query($conn, "UPDATE peminjaman SET status='$status' WHERE id=$id");
        
        // Update stok buku berdasarkan perubahan status
        if ($status_lama == 'dibatalkan' && $status == 'bisa_diambil') {
            // Jika status berubah dari dibatalkan ke bisa diambil, kurangi stok
            mysqli_query($conn, "UPDATE buku SET stok = stok - 1 WHERE id = $id_buku AND stok > 0");
        } 
        else if ($status_lama == 'bisa_diambil' && $status == 'dibatalkan') {
            // Jika status berubah ke dibatalkan, tambah stok
            mysqli_query($conn, "UPDATE buku SET stok = stok + 1 WHERE id = $id_buku");
        }
        else if ($status == 'dikembalikan' && $status_lama != 'dikembalikan') {
            // Jika buku dikembalikan, tambah stok
            mysqli_query($conn, "UPDATE buku SET stok = stok + 1 WHERE id = $id_buku");
        }
        
        mysqli_commit($conn);
        header("Location: peminjaman.php");
        exit;
    } catch (Exception $e) {
        mysqli_rollback($conn);
        echo "Terjadi kesalahan: " . $e->getMessage();
    }
}

// Join data dengan informasi stok
$peminjaman = mysqli_query($conn, "
    SELECT p.*, u.username, b.judul, b.stok 
    FROM peminjaman p
    JOIN users u ON p.id_user = u.id
    JOIN buku b ON p.id_buku = b.id
    ORDER BY p.id DESC
");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Peminjaman</title>
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
        .back-button {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            margin-bottom: 1rem;
            transition: all 0.3s ease;
        }
        .back-button:hover {
            transform: translateX(-5px);
        }
        .table {
            background: white;
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
            border: none;
        }
        .table td {
            padding: 1rem;
            vertical-align: middle;
            border-color: #f1f1f1;
        }
        .badge {
            padding: 0.5rem 1rem;
            border-radius: 50px;
            font-weight: 500;
            text-transform: capitalize;
        }
        .badge.bg-menunggu {
            background-color: #ffeaa7 !important;
            color: #fdcb6e !important;
        }
        .badge.bg-bisa_diambil {
            background-color: #55efc4 !important;
            color: #00b894 !important;
        }
        .badge.bg-dipinjam {
            background-color: #74b9ff !important;
            color: #0984e3 !important;
        }
        .badge.bg-dikembalikan {
            background-color: #a8e6cf !important;
            color: #3d8168 !important;
        }
        .badge.bg-dibatalkan {
            background-color: #ff7675 !important;
            color: white !important;
        }
        .form-select {
            border: 2px solid #e9ecef;
            border-radius: 5px;
            padding: 0.5rem;
            font-size: 0.9rem;
            width: auto;
            cursor: pointer;
        }
        .form-select:focus {
            border-color: #6c5ce7;
            box-shadow: 0 0 0 0.2rem rgba(108, 92, 231, 0.25);
        }
        .btn-update {
            background: #6c5ce7;
            border: none;
            padding: 0.5rem 1rem;
            color: white;
            border-radius: 5px;
            transition: all 0.3s ease;
        }
        .btn-update:hover {
            background: #5b4cc4;
            transform: translateY(-2px);
        }
        .status-form {
            display: flex;
            gap: 0.5rem;
            align-items: center;
        }
    </style>
</head>
<body>
<div class="container">
    <div class="page-header">
        <h3 class="mb-0">Daftar Peminjaman Buku</h3>
    </div>

    <a href="dashboard.php" class="btn btn-secondary back-button">
        <i class="fas fa-arrow-left"></i> Kembali ke Dashboard
    </a>

    <div class="table-responsive">
        <table class="table">
            <thead>
                <tr>
                    <th>User</th>
                    <th>Judul Buku</th>
                    <th>Tgl Pinjam</th>
                    <th>Batas Waktu</th>
                    <th>Status</th>
                    <th>Ubah Status</th>
                </tr>
            </thead>
            <tbody>
            <?php while ($row = mysqli_fetch_assoc($peminjaman)) : ?>
                <tr>
                    <td>
                        <i class="fas fa-user me-2"></i>
                        <?= htmlspecialchars($row['username']) ?>
                    </td>
                    <td>
                        <i class="fas fa-book me-2"></i>
                        <?= htmlspecialchars($row['judul']) ?>
                    </td>
                    <td>
                        <i class="fas fa-calendar me-2"></i>
                        <?= $row['tanggal_pinjam'] ?>
                    </td>
                    <td>
                        <i class="fas fa-clock me-2"></i>
                        <?= $row['batas_waktu'] ?>
                    </td>
                    <td>
                        <span class="badge bg-<?= $row['status'] ?>">
                            <?= $row['status'] ?>
                        </span>
                    </td>
                    <td>
                        <form method="post" class="status-form">
                            <input type="hidden" name="id" value="<?= $row['id'] ?>">
                            <select name="status" class="form-select">
                                <?php
                                $opsi = ['menunggu','bisa_diambil','dipinjam','dikembalikan','dibatalkan'];
                                foreach ($opsi as $s) {
                                    $selected = $row['status'] == $s ? 'selected' : '';
                                    echo "<option value='$s' $selected>$s</option>";
                                }
                                ?>
                            </select>
                            <button name="ubah_status" class="btn btn-update">
                                <i class="fas fa-check"></i>
                            </button>
                        </form>
                    </td>
                </tr>
            <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
