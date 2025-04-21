<?php
if (isset($_SESSION['user'])) {
    header("Location: index.php");
    exit;
}
$errore = '';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    $utente = $db->select("SELECT * FROM utenti WHERE email = ? OR username = ?", [$email, $email]);

    if ($utente && password_verify($password, $utente[0]['password'])) {
        $_SESSION['user'] = $utente[0];
        $_SESSION['username'] = $utente[0]['username'];
        $_SESSION['email'] = $utente[0]['email'];
        $_SESSION['level'] = json_decode($utente[0]['params'])->level;
        header("Location: index.php");
        exit;
    } else {
        $errore = $lang->getstring("incorrect email or password.");
    }
}
?>



<div class="container py-5">
    <?php if ($errore): ?>
        <div class="alert alert-danger"><?= htmlspecialchars($errore) ?></div>
    <?php endif; ?>
    <div class="card">
        <div class="card-header">
            <h2 class="m-0 text-center"><?= $lang->getstring("login") ?></h2>
        </div>
        <form method="POST" class="card shadow-sm">
            <div class="card-body">
                <div class="mb-3">
                    <label><?= $lang->getstring("email or username") ?></label>
                    <input type="text" name="email" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label><?= $lang->getstring("password") ?></label>
                    <input type="password" name="password" class="form-control" required>
                </div>
            </div>
            <div class="card-footer text-center">
                <button type="submit" class="btn btn-primary"><?= $lang->getstring("login") ?></button>
                <p class="mt-3"><?= $lang->getstring("not registered?") ?> <a href="index.php?page=register"><?= $lang->getstring("register") ?></a></p>
            </div>
        </form>
    </div>
</div>