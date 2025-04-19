<?php
if (isset($_SESSION['user'])) {
    header("Location: index.php");
    exit;
}
$errore = '';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $esiste = $db->select("SELECT * FROM utenti WHERE username = ?", [$username]);

    if ($esiste) {
        $errore = "Utente già registrato!";
    } else {
        $db->insert("INSERT INTO utenti (username, email, password) VALUES (?, ?, ?)", [$username, $email, $password]);
        $_SESSION['user'] = $username;
        header("Location: index.php");
        exit;
    }
}
?>


<div class="container mt-5">
    <h2 class="mb-4 text-center">Registrazione</h2>

    <?php if ($errore): ?>
        <div class="alert alert-danger"><?= $errore ?></div>
    <?php endif; ?>

    <form method="POST" class="card p-4 shadow-sm">
        <div class="mb-3">
            <label>Username</label>
            <input type="text" name="username" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Email</label>
            <input type="email" name="email" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Password</label>
            <input type="password" name="password" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary w-100">Registrati</button>
        <p class="mt-3 text-center">Hai già un account? <a href="login.php">Accedi</a></p>
    </form>
</div>