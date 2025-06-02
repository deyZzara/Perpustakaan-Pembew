<?php
require 'db.php';

ob_start(); 
header('Content-Type: application/json');

$response = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    $stmt = $conn->prepare("SELECT * FROM users WHERE username = ? AND password = ?");
    $stmt->bind_param("ss", $username, $password);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($row = $result->fetch_assoc()) {
        if ($row['is_banned'] == 1) {
            $response = [
                'success' => false,
                'message' => 'User is banned'
            ];
        } else {
            $response = [
                'success' => true,
                'message' => 'Login successful',
                'id_user' => $row['id']
            ];
        }
    } else {
        $response = [
            'success' => false,
            'message' => 'Wrong username or password',
        ];
    }

    $stmt->close();
    $conn->close();
} else {
    $response = [
        'success' => false,
        'message' => 'Invalid request'
    ];
}
ob_clean();
echo json_encode($response);
exit;