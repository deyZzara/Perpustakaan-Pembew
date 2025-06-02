<?php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'staff') {
    header("Location: login_admin.php");
    exit;
}

$admin = $_SESSION['username']; 
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        .navbar {
            background: linear-gradient(135deg, #6c5ce7, #a363d9) !important;
            padding: 1rem;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }

        .navbar-brand {
            font-weight: 600;
            font-size: 1.5rem;
        }

        .admin-info {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .admin-name {
            background: rgba(255,255,255,0.2);
            padding: 0.5rem 1rem;
            border-radius: 50px;
            font-size: 0.9rem;
        }

        .btn-logout {
            background: #ff7675;
            border: none;
            padding: 0.5rem 1.5rem;
            border-radius: 50px;
            transition: all 0.3s ease;
        }

        .btn-logout:hover {
            background: #d63031;
            transform: translateY(-2px);
        }

        .dashboard-container {
            max-width: 1200px;
            margin: 2rem auto;
            padding: 0 1rem;
        }

        .dashboard-header {
            background: white;
            padding: 2rem;
            border-radius: 15px;
            margin-bottom: 2rem;
            box-shadow: 0 4px 6px rgba(0,0,0,0.05);
        }

        .dashboard-header h3 {
            margin: 0;
            color: #2d3436;
            font-weight: 600;
        }

        .menu-card {
            background: white;
            border-radius: 15px;
            overflow: hidden;
            transition: all 0.3s ease;
            box-shadow: 0 4px 6px rgba(0,0,0,0.05);
            height: 100%;
        }

        .menu-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 15px rgba(0,0,0,0.1);
        }

        .menu-link {
            text-decoration: none;
            color: inherit;
            display: block;
            padding: 2rem;
            text-align: center;
        }

        .menu-icon {
            font-size: 2.5rem;
            margin-bottom: 1rem;
            color: #6c5ce7;
        }

        .menu-title {
            font-weight: 500;
            color: #2d3436;
            margin: 0;
        }

        .menu-description {
            color: #636e72;
            font-size: 0.9rem;
            margin-top: 0.5rem;
        }
    </style>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">
            <i class="fas fa-book-reader me-2"></i>
            Perpustakaan Admin
        </a>
        <div class="admin-info">
            <span class="admin-name text-white">
                <i class="fas fa-user me-2"></i>
                <?= $admin ?>
            </span>
            <a href="logout.php" class="btn btn-logout btn-sm text-white">
                <i class="fas fa-sign-out-alt me-2"></i>
                Logout
            </a>
        </div>
    </div>
</nav>

<div class="row g-4">
    <div class="col-md-4">
        <div class="menu-card">
            <a href="laporan.php" class="menu-link">
                <div class="menu-icon">
                    <i class="fas fa-chart-line"></i>
                </div>
                <h4 class="menu-title">Laporan</h4>
                <p class="menu-description">Lihat statistik buku, anggota, dan pinjaman</p>
            </a>
        </div>
    </div>

    <div class="col-md-4">
        <div class="menu-card">
            <a href="users.php" class="menu-link">
                <div class="menu-icon">
                    <i class="fas fa-user-check"></i>
                </div>
                <h4 class="menu-title">Validasi User</h4>
                <p class="menu-description">Kelola dan validasi pengguna perpustakaan</p>
            </a>
        </div>
    </div>

    <div class="col-md-4">
        <div class="menu-card">
            <a href="riwayat.php" class="menu-link">
                <div class="menu-icon">
                    <i class="fas fa-history"></i>
                </div>
                <h4 class="menu-title">Riwayat Peminjaman</h4>
                <p class="menu-description">Pantau semua aktivitas peminjaman</p>
            </a>
        </div>
    </div>

    <div class="col-md-4">
        <div class="menu-card">
            <a href="anggota.php" class="menu-link">
                <div class="menu-icon">
                    <i class="fas fa-users"></i>
                </div>
                <h4 class="menu-title">Manage Anggota</h4>
                <p class="menu-description">Tambah, edit, dan hapus anggota</p>
            </a>
        </div>
    </div>

    <div class="col-md-4">
        <div class="menu-card">
            <a href="buku.php" class="menu-link">
                <div class="menu-icon">
                    <i class="fas fa-book"></i>
                </div>
                <h4 class="menu-title">Kelola Buku</h4>
                <p class="menu-description">Tambah, edit, dan hapus koleksi buku</p>
            </a>
        </div>
    </div>

    <div class="col-md-4">
        <div class="menu-card">
            <a href="peminjaman.php" class="menu-link">
                <div class="menu-icon">
                    <i class="fas fa-clipboard-list"></i>
                </div>
                <h4 class="menu-title">Daftar Peminjaman</h4>
                <p class="menu-description">Pantau status peminjaman buku</p>
            </a>
        </div>
    </div>
</div>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
