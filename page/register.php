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
        $errore = $lang->getstring("passwords do not match!");
    } else {
        // Hash solo se le password corrispondono
        $passwordHash = password_hash($password, PASSWORD_DEFAULT);

        // Verifico esistenza utente
        $esiste = $db->select(
            "SELECT * FROM utenti WHERE username = ? OR email = ?",
            [$username, $email]
        );

        if ($esiste) {
            $errore = $lang->getstring("username or email already in use!");
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

<div class="container py-5">
    <?php if ($errore): ?>
        <div class="alert alert-danger"><?= htmlspecialchars($errore) ?></div>
    <?php endif; ?>
    <div class="card">
        <div class="card-header">
            <h2 class="m-0 text-center"><?= $lang->getstring("register") ?></h2>
        </div>
        <form method="POST" class="card shadow-sm">
            <div class="card-body">
                <div class="mb-3">
                    <label for="username"><?= $lang->getstring("username") ?></label>
                    <input
                        type="text" id="username" name="username"
                        class="form-control" required
                        value="<?= isset($_POST['username']) ? htmlspecialchars($_POST['username']) : '' ?>">
                </div>
                <div class="mb-3">
                    <label for="email"><?= $lang->getstring("email") ?></label>
                    <input
                        type="email" id="email" name="email"
                        class="form-control" required
                        value="<?= isset($_POST['email']) ? htmlspecialchars($_POST['email']) : '' ?>">
                </div>
                <div class="mb-3">
                    <label for="password"><?= $lang->getstring("password") ?></label>
                    <input
                        type="password" id="password" name="password"
                        class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="confirm_password"><?= $lang->getstring("confirm password") ?></label>
                    <input
                        type="password" id="confirm_password" name="confirm_password"
                        class="form-control" required>
                </div>
            </div>
            <div class="card-footer text-center">
                <button type="submit" class="btn btn-primary"><?= $lang->getstring("register") ?></button>
                <p class="mt-3">
                    <?= $lang->getstring("do you already have an account?") ?> <a href="index.php?page=login"><?= $lang->getstring("login") ?></a>
                </p>
            </div>
        </form>
    </div>
</div>