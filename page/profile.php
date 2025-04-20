<?php
if (!isset($_SESSION['user'])) {
    header('Location: index.php?page=login');
    exit;
}

// Chiave corrente
$oldUsername = $_SESSION['user']['username'];
$errors = [];

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
        $errors[] = 'Username già in uso!';
    }

    // Prelevo l'hash della password corrente
    $rows = $db->select(
        "SELECT password FROM utenti WHERE username = ?",
        [$oldUsername]
    );
    if (empty($rows)) {
        $errors[] = 'Utente non trovato.';
    } else {
        $hashOld = $rows[0]['password'];
    }

    // Se ho inserito una nuova password, verifiche aggiuntive
    if ($newPassword !== '' || $confirmPassword !== '') {
        if (!password_verify($currentPassword, $hashOld)) {
            $errors[] = 'Password corrente errata.';
        }
        if ($newPassword !== $confirmPassword) {
            $errors[] = 'Le nuove password non coincidono.';
        }
    }

    // Se non ci sono errori procedo all’aggiornamento
    if (empty($errors)) {
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
            $errors[] = 'Errore durante l\'aggiornamento: ' . $e->getMessage();
        }
    }
}
?>
<div class="container">
    <h1>Il mio profilo</h1>

    <?php if ($errors): ?>
        <div class="alert alert-danger">
            <ul>
                <?php foreach ($errors as $e): ?>
                    <li><?= htmlspecialchars($e) ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <form action="index.php?page=profile" method="post">
        <!-- Username -->
        <div class="form-group">
            <label for="username">Username</label>
            <input
                type="text" id="username" name="username"
                class="form-control"
                value="<?= htmlspecialchars($oldUsername) ?>"
                required>
        </div>

        <!-- Email -->
        <div class="form-group">
            <label for="email">Email</label>
            <input
                type="email" id="email" name="email"
                class="form-control"
                value="<?= htmlspecialchars($_SESSION['user']['email']) ?>"
                required>
        </div>

        <hr>
        <h3>Cambia password</h3>

        <div class="form-group">
            <label for="current_password">Password corrente</label>
            <input
                type="password" id="current_password"
                name="current_password" class="form-control">
        </div>

        <div class="form-group">
            <label for="new_password">Nuova password</label>
            <input
                type="password" id="new_password"
                name="new_password" class="form-control">
        </div>

        <div class="form-group">
            <label for="confirm_password">Conferma nuova password</label>
            <input
                type="password" id="confirm_password"
                name="confirm_password" class="form-control">
        </div>

        <button type="submit" class="btn btn-primary">Salva modifiche</button>
    </form>
</div>