<?php
include 'config/auth.php';
include 'config/database.php';
include 'config/crypto.php';

$name = trim($_GET['q'] ?? '');

$stmt = mysqli_prepare($conn, "SELECT id, name, nik FROM patients WHERE name LIKE ?");
$keyword = "%" . $name . "%";
mysqli_stmt_bind_param($stmt, "s", $keyword);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

echo "<h1>Hasil Pencarian Pasien:</h1>";
while ($row = mysqli_fetch_assoc($result)) {
    echo "Nama: " . htmlspecialchars($row['name'], ENT_QUOTES, 'UTF-8') . " ";
    echo "| NIK: " . htmlspecialchars(decrypt_nik($row['nik']), ENT_QUOTES, 'UTF-8') . "<br>";
}
?>
