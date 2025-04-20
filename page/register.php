<?php
if (isset($_SESSION['user'])) {
    header("Location: index.php");
    exit;
}
$errore = '';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $username        = trim($_POST['username']);
    $email           = trim($_POST['email']);
    $password        = $_POST['password'];
    $confirmPassword = $_POST['confirm_password'];

    // Controllo conferma password
    if ($password !== $confirmPassword) {
        $errore = "Le password non corrispondono!";
    } else {
        // Hash solo se le password corrispondono
        $passwordHash = password_hash($password, PASSWORD_DEFAULT);

        // Verifico esistenza utente
        $esiste = $db->select(
            "SELECT * FROM utenti WHERE username = ? OR email = ?",
            [$username, $email]
        );

        if ($esiste) {
            $errore = "Username o email già in uso!";
        } else {
            // Inserisco nuovo utente
            $db->insert(
                "INSERT INTO utenti (username, email, password) VALUES (?, ?, ?)",
                [$username, $email, $passwordHash]
            );

            // Imposto sessione
            $_SESSION['user']['username'] = $username;
            $_SESSION['user']['email']    = $email;

            header("Location: index.php");
            exit;
        }
    }
}
?>

<div class="container mt-5">
    <h2 class="mb-4 text-center">Registrazione</h2>

    <?php if ($errore): ?>
        <div class="alert alert-danger"><?= htmlspecialchars($errore) ?></div>
    <?php endif; ?>

    <form method="POST" class="card p-4 shadow-sm">
        <div class="mb-3">
            <label for="username">Username</label>
            <input
                type="text" id="username" name="username"
                class="form-control" required
                value="<?= isset($_POST['username']) ? htmlspecialchars($_POST['username']) : '' ?>">
        </div>
        <div class="mb-3">
            <label for="email">Email</label>
            <input
                type="email" id="email" name="email"
                class="form-control" required
                value="<?= isset($_POST['email']) ? htmlspecialchars($_POST['email']) : '' ?>">
        </div>
        <div class="mb-3">
            <label for="password">Password</label>
            <input
                type="password" id="password" name="password"
                class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="confirm_password">Conferma Password</label>
            <input
                type="password" id="confirm_password" name="confirm_password"
                class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary w-100">Registrati</button>
        <p class="mt-3 text-center">
            Hai già un account? <a href="index.php?page=login">Accedi</a>
        </p>
    </form>
</div>