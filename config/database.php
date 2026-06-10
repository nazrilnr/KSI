<?php
$host = "127.0.0.1";
$user = "root";
$pass = "root";
$db   = "meditrust_db";

$conn = mysqli_connect($host, $user, $pass, $db, 8889);

if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}
?>
