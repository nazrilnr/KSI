<?php
include 'config/database.php';
session_start();

$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username'] ?? "");
    $password = $_POST['password'] ?? "";

    $stmt = mysqli_prepare($conn, "SELECT * FROM users WHERE username = ? LIMIT 1");
    mysqli_stmt_bind_param($stmt, "s", $username);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $user = mysqli_fetch_assoc($result);

    $passwordValid = false;
    if ($user) {
        $passwordValid = password_verify($password, $user['password']);

        if (!$passwordValid && hash_equals($user['password'], md5($password))) {
            $passwordValid = true;
            $newHash = password_hash($password, PASSWORD_DEFAULT);

            $update = mysqli_prepare($conn, "UPDATE users SET password = ? WHERE id = ?");
            mysqli_stmt_bind_param($update, "si", $newHash, $user['id']);
            mysqli_stmt_execute($update);
        }
    }

    if ($passwordValid) {
        session_regenerate_id(true);
        $_SESSION['user'] = $user['username'];
        header("Location: dashboard.php");
        exit();
    } else {
        $error = "Login gagal!";
    }
}
?>
<?php if ($error): ?>
    <p><?php echo htmlspecialchars($error, ENT_QUOTES, 'UTF-8'); ?></p>
<?php endif; ?>
<form method="POST">
    Username: <input type="text" name="username" value="<?php echo htmlspecialchars($_POST['username'] ?? '', ENT_QUOTES, 'UTF-8'); ?>"><br>
    Password: <input type="password" name="password"><br>
    <button type="submit">Login</button>
</form>
