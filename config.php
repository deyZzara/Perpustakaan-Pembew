<?php
$host = getenv("MYSQL_ADDON_HOST");
$username = getenv("MYSQL_ADDON_USER");
$password = getenv("MYSQL_ADDON_PASSWORD");
$database = getenv("MYSQL_ADDON_DB");
$port = getenv("MYSQL_ADDON_PORT");
//
$conn = mysqli_connect($host, $username, $password, $database);

if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}
?> 
