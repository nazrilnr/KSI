<?php
include 'config/database.php';
session_start();

if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}

include 'includes/header.php';
?>

<h2>Dashboard Dokter</h2>

<p>
    Selamat bekerja,
    <?php echo htmlspecialchars($_SESSION['user'], ENT_QUOTES, 'UTF-8'); ?>!
</p>

<h3>Daftar Pasien Terbaru:</h3>

<ul>
    <?php
    $query = "SELECT id, name FROM patients";
    $result = mysqli_query($conn, $query);

    while ($row = mysqli_fetch_assoc($result)) {
        echo "<li>"
            . htmlspecialchars($row['name'], ENT_QUOTES, 'UTF-8')
            . " - <a href='detail_pasien.php?id="
            . (int) $row['id']
            . "'>Lihat Detail</a></li>";
    }
    ?>
</ul>

<?php include 'includes/footer.php'; ?>