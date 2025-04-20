<?php
if (!isset($_SESSION['user'])) {
    header('Location: index.php?page=login');
    exit;
}

// Chiave corrente
$oldUsername = $_SESSION['user']['username'];
$errore = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Sanitizzo input
    $username        = trim($_POST['username']);
    $email           = trim($_POST['email']);
    $currentPassword = $_POST['current_password']  ?? '';
    $newPassword     = $_POST['new_password']      ?? '';
    $confirmPassword = $_POST['confirm_password']  ?? '';

    // Controllo unicità del nuovo username (escludendo il vecchio)
    $exists = $db->select(
        "SELECT 1 FROM utenti WHERE username = ? AND username != ? LIMIT 1",
        [$username, $oldUsername]
    );
    if (!empty($exists)) {
        $errore = $lang->getstring("username already in use!");
    }

    // Prelevo l'hash della password corrente
    $rows = $db->select(
        "SELECT password FROM utenti WHERE username = ?",
        [$oldUsername]
    );
    if (empty($rows)) {
        $errore = $lang->getstring("username not found!");
    } else {
        $hashOld = $rows[0]['password'];
    }

    // Se ho inserito una nuova password, verifiche aggiuntive
    if ($newPassword !== '' || $confirmPassword !== '') {
        if (!password_verify($currentPassword, $hashOld)) {
            $errore = $lang->getstring("incorrect current password!");
        }
        if ($newPassword !== $confirmPassword) {
            $errore = $lang->getstring("passwords do not match!");
        }
    }

    // Se non ci sono errori procedo all’aggiornamento
    if (empty($errore)) {
        try {
            // Inizio transazione
            $db->exec('START TRANSACTION');

            // 1) Aggiorno username + email
            $db->update(
                "UPDATE utenti
                 SET username = ?, email = ?
                 WHERE username = ?",
                [$username, $email, $oldUsername]
            );

            // 2) Se cambio password, aggiorno anche quella
            if ($newPassword !== '') {
                $newHash = password_hash($newPassword, PASSWORD_DEFAULT);
                $db->update(
                    "UPDATE utenti
                     SET password = ?
                     WHERE username = ?",
                    [$newHash, $username]
                );
            }

            // Commit
            $db->exec('COMMIT');

            // Aggiorno sessione
            $_SESSION['user']['username'] = $username;
            $_SESSION['user']['email']    = $email;

            // Aggiorno chiave per ridisegnare il form
            $oldUsername = $username;

            header('Location: index.php');
            exit;
        } catch (Exception $e) {
            $db->exec('ROLLBACK');
            $errore = $lang->getstring("error while updating") . $e->getMessage();
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
            <h2 class="m-0 text-center"><?= $lang->getstring("profile") ?></h2>
        </div>
        <form method="POST" class="card shadow-sm">
            <div class="card-body">
                <div class="mb-3">
                    <label for="username"><?= $lang->getstring(key: "username") ?></label>
                    <input
                        type="text" id="username" name="username"
                        class="form-control"
                        value="<?= htmlspecialchars($oldUsername) ?>"
                        required>
                </div>
                <div class="mb-3">
                    <label for="email"><?= $lang->getstring("email") ?></label>
                    <input
                        type="email" id="email" name="email"
                        class="form-control"
                        value="<?= htmlspecialchars($_SESSION['user']['email']) ?>"
                        required>
                </div>
                <hr>
                <h3><?= $lang->getstring("change password") ?></h3>
                <div class="mb-3">
                    <label for="current_password"><?= $lang->getstring("current password") ?></label>
                    <input
                        type="password" id="current_password"
                        name="current_password" class="form-control">
                </div>

                <div class="mb-3">
                    <label for="new_password"><?= $lang->getstring("new password") ?></label>
                    <input
                        type="password" id="new_password"
                        name="new_password" class="form-control">
                </div>

                <div class="mb-3">
                    <label for="confirm_password"><?= $lang->getstring("confirm new password") ?></label>
                    <input
                        type="password" id="confirm_password"
                        name="confirm_password" class="form-control">
                </div>
            </div>
            <div class="card-footer text-center">
                <button type="submit" class="btn btn-primary"><?= $lang->getstring("save") ?></button>
            </div>
        </form>
    </div>
</div>