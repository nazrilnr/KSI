<?php
include 'config/auth.php';
include 'config/database.php';
include 'config/crypto.php';

$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
if (!$id) {
    http_response_code(400);
    exit('ID pasien tidak valid.');
}

$stmt = mysqli_prepare($conn, "SELECT id, name, nik, diagnosis FROM patients WHERE id = ? LIMIT 1");
mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$row = mysqli_fetch_assoc($result);

if (!$row) {
    http_response_code(404);
    exit('Data pasien tidak ditemukan.');
}
?>

<h1>Detail Rekam Medis</h1>
<p>Nama: <?php echo htmlspecialchars($row['name'], ENT_QUOTES, 'UTF-8'); ?></p>
<p>NIK: <?php echo htmlspecialchars(decrypt_nik($row['nik']), ENT_QUOTES, 'UTF-8'); ?></p>
<p>Diagnosis: <?php echo htmlspecialchars($row['diagnosis'], ENT_QUOTES, 'UTF-8'); ?></p>

<a href="dashboard.php">Kembali</a>
