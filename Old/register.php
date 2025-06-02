<?php
require_once 'db.php';

header("Content-Type: text/plain");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = trim($_POST['password'] ?? '');

    if (empty($username) || empty($password)) {
        echo "Username and password are required";
        exit;
    }

    $checkQuery = "SELECT id FROM users WHERE username = ?";
    $stmt = $conn->prepare($checkQuery);

    if (!$stmt) {
        echo "Prepare failed: " . $conn->error;
        exit;
    }

    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        echo "Username already exists";
        $stmt->close();
        exit;
    }
    $stmt->close();

    $insertQuery = "INSERT INTO users (username, password, role, is_banned) VALUES (?, ?, 'user', 1)";
    $insertStmt = $conn->prepare($insertQuery);

    if (!$insertStmt) {
        echo "Insert prepare failed: " . $conn->error;
        exit;
    }

    $insertStmt->bind_param("ss", $username, $password);
    if ($insertStmt->execute()) {
        echo "success";
    } else {
        echo "Registration failed: " . $insertStmt->error;
    }

    $insertStmt->close();
} else {
    echo "Invalid request method";
}
$conn->close();
