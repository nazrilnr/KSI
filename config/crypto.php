<?php
const NIK_ENCRYPTION_PREFIX = 'enc:v1:';
const NIK_ENCRYPTION_KEY = 'MediTrust-Lab-Key-Change-This-In-Production';

function nik_key()
{
    return hash('sha256', NIK_ENCRYPTION_KEY, true);
}

function encrypt_nik($nik)
{
    if ($nik === null || $nik === '') {
        return $nik;
    }

    if (str_starts_with($nik, NIK_ENCRYPTION_PREFIX)) {
        return $nik;
    }

    $iv = random_bytes(12);
    $tag = '';
    $ciphertext = openssl_encrypt((string) $nik, 'aes-256-gcm', nik_key(), OPENSSL_RAW_DATA, $iv, $tag);

    if ($ciphertext === false) {
        throw new RuntimeException('Gagal mengenkripsi NIK.');
    }

    return NIK_ENCRYPTION_PREFIX . base64_encode($iv . $tag . $ciphertext);
}

function decrypt_nik($storedNik)
{
    if ($storedNik === null || $storedNik === '') {
        return $storedNik;
    }

    if (!str_starts_with($storedNik, NIK_ENCRYPTION_PREFIX)) {
        return $storedNik;
    }

    $payload = base64_decode(substr($storedNik, strlen(NIK_ENCRYPTION_PREFIX)), true);
    if ($payload === false || strlen($payload) < 29) {
        return '[NIK tidak valid]';
    }

    $iv = substr($payload, 0, 12);
    $tag = substr($payload, 12, 16);
    $ciphertext = substr($payload, 28);
    $plaintext = openssl_decrypt($ciphertext, 'aes-256-gcm', nik_key(), OPENSSL_RAW_DATA, $iv, $tag);

    return $plaintext === false ? '[NIK tidak valid]' : $plaintext;
}
?>
