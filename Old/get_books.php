<?php
header('Content-Type: application/json');
require_once 'db.php';

if (!$conn) {
    http_response_code(500);
    echo json_encode(["error" => "Database connection failed"]);
    exit();
}

$sql = "SELECT id, judul, penulis, cover, deskripsi FROM buku";
$result = $conn->query($sql);

$books = [];

if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $books[] = [
            "id" => $row["id"],
            "title" => $row["judul"],
            "author" => $row["penulis"],
            "gambar" => $row["cover"],
            "description" => $row["deskripsi"]
        ];
    }
}

echo json_encode($books);
?>
