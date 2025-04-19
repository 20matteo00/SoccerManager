<?php
if (isset($_SESSION['user'])) {
    header("Location: index.php");
    exit;
}
$errore = '';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    $utente = $db->select("SELECT * FROM utenti WHERE email = ?", [$email]);

    if ($utente && password_verify($password, $utente[0]['password'])) {
        $_SESSION['user'] = $utente[0];
        $_SESSION['username'] = $utente[0]['username'];
        header("Location: index.php");
        exit;
    } else {
        $errore = "Email o password errati.";
    }
}
?>



<div class="container mt-5">
    <h2 class="mb-4 text-center">Accedi</h2>

    <?php if ($errore): ?>
        <div class="alert alert-danger"><?= $errore ?></div>
    <?php endif; ?>

    <form method="POST" class="card p-4 shadow-sm">
        <div class="mb-3">
            <label>Email</label>
            <input type="email" name="email" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Password</label>
            <input type="password" name="password" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-success w-100">Accedi</button>
        <p class="mt-3 text-center">Non sei registrato? <a href="register.php">Registrati</a></p>
    </form>
</div>