<?php
include __DIR__ . '/../config/database.php';
include __DIR__ . '/../config/crypto.php';

$alter = mysqli_query($conn, "ALTER TABLE patients MODIFY nik VARCHAR(255)");
if (!$alter) {
    die("Gagal memperbarui skema kolom NIK: " . mysqli_error($conn) . "\n");
}

$result = mysqli_query($conn, "SELECT id, nik FROM patients");
while ($row = mysqli_fetch_assoc($result)) {
    $encryptedNik = encrypt_nik($row['nik']);
    $id = (int) $row['id'];

    $stmt = mysqli_prepare($conn, "UPDATE patients SET nik = ? WHERE id = ?");
    mysqli_stmt_bind_param($stmt, "si", $encryptedNik, $id);
    mysqli_stmt_execute($stmt);
}

echo "Migrasi NIK selesai.\n";
?>
