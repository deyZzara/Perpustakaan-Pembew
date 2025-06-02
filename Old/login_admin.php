<?php
session_start();
include 'db.php';

// Cek jika sudah login
if (isset($_SESSION['admin'])) {
    header("Location: dashboard.php");
    exit;
}


$error = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Cek user berdasarkan username & password
    $query = "SELECT * FROM users WHERE username = '$username' AND password = '$password' AND is_banned = 0";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) == 1) {
        $data = mysqli_fetch_assoc($result);

        // Simpan session umum
        $_SESSION['id'] = $data['id'];
        $_SESSION['username'] = $data['username'];
        $_SESSION['role'] = $data['role'];

        // Redirect sesuai role
        if ($data['role'] == 'staff') {
            header("Location: dashboard.php");
        } elseif ($data['role'] == 'user') {
            header("Location: user_dashboard.php");
        } else {
            $error = "Role tidak dikenali.";
        }
        exit;
    } else {
        $error = "Login gagal! Username atau password salah, atau akun diblokir.";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #6c5ce7, #a363d9);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .login-container {
            width: 100%;
            max-width: 400px;
            padding: 2rem;
        }

        .login-card {
            background: rgba(255, 255, 255, 0.95);
            border-radius: 15px;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
            overflow: hidden;
            backdrop-filter: blur(10px);
        }

        .login-header {
            background: white;
            padding: 2rem;
            text-align: center;
            border-bottom: 1px solid rgba(0, 0, 0, 0.1);
        }

        .login-icon {
            font-size: 3rem;
            color: #6c5ce7;
            margin-bottom: 1rem;
        }

        .login-title {
            color: #2d3436;
            font-weight: 600;
            margin: 0;
            font-size: 1.5rem;
        }

        .login-body {
            padding: 2rem;
        }

        .form-label {
            color: #2d3436;
            font-weight: 500;
            margin-bottom: 0.5rem;
        }

        .form-control {
            border: 2px solid #e9ecef;
            border-radius: 8px;
            padding: 0.75rem 1rem;
            transition: all 0.3s ease;
        }

        .form-control:focus {
            border-color: #6c5ce7;
            box-shadow: 0 0 0 0.2rem rgba(108, 92, 231, 0.25);
        }

        .input-group-text {
            background: transparent;
            border: 2px solid #e9ecef;
            border-right: none;
            color: #6c5ce7;
        }

        .form-control {
            border-left: none;
        }

        .btn-login {
            background: linear-gradient(135deg, #6c5ce7, #a363d9);
            border: none;
            border-radius: 8px;
            padding: 0.75rem;
            font-weight: 500;
            text-transform: uppercase;
            letter-spacing: 1px;
            transition: all 0.3s ease;
        }

        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(108, 92, 231, 0.4);
        }

        .alert {
            border: none;
            border-radius: 8px;
            font-size: 0.9rem;
        }

        .alert-danger {
            background: #fff5f5;
            color: #c0392b;
            border-left: 4px solid #e74c3c;
        }
    </style>
</head>
<body>
<div class="login-container">
    <div class="login-card">
        <div class="login-header">
            <div class="login-icon">
                <i class="fas fa-book-reader"></i>
            </div>
            <h3 class="login-title">Login</h3>
        </div>
        <div class="login-body">
            <?php if ($error): ?>
                <div class="alert alert-danger">
                    <i class="fas fa-exclamation-circle me-2"></i>
                    <?= $error ?>
                </div>
            <?php endif; ?>
            <form method="post">
                <div class="mb-4">
                    <label class="form-label">Username</label>
                    <div class="input-group">
                        <span class="input-group-text">
                            <i class="fas fa-user"></i>
                        </span>
                        <input type="text" name="username" class="form-control" required autofocus 
                               placeholder="Masukkan username">
                    </div>
                </div>
                <div class="mb-4">
                    <label class="form-label">Password</label>
                    <div class="input-group">
                        <span class="input-group-text">
                            <i class="fas fa-lock"></i>
                        </span>
                        <input type="password" name="password" class="form-control" required 
                               placeholder="Masukkan password">
                    </div>
                </div>
                <button class="btn btn-login btn-primary w-100">
                    <i class="fas fa-sign-in-alt me-2"></i>
                    Login
                </button>
            </form>
        </div>
    </div>
</div>
</body>
</html>
