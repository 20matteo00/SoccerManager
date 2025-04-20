<nav class="navbar navbar-expand-lg navbar-dark bg-dark px-3">
    <div class="container">
        <a class="navbar-brand" href="index.php">
            <img src="images/logo.png" alt="Soccer Manager" class="d-inline-block align-text-top">
        </a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNavbar" aria-controls="mainNavbar" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="mainNavbar">
            <!-- Menu di navigazione principale -->
            <ul class="navbar-nav mx-auto m-0">
                <?php foreach (Config::$principale as $label => $url): ?>
                    <li class="nav-item">
                        <a href="<?= $url ?>" class="nav-link active"><?= $label ?></a>
                    </li>
                <?php endforeach; ?>
            </ul>

            <!-- Sezione destra: auth -->
            <ul class="navbar-nav m-0">
                <?php if (!isset($_SESSION['user'])) : ?>
                    <!-- Login / Registrati -->
                    <?php foreach (Config::$utentenonloggato as $label => $url): ?>
                        <li class="nav-item">
                            <a href="<?= $url ?>" class="nav-link active"><?= $label ?></a>
                        </li>
                    <?php endforeach; ?>
                <?php else: ?>
                    <!-- Logout / Profilo -->
                    <?php foreach (Config::getMenuUtenteloggato() as $label => $url): ?>
                        <li class="nav-item">
                            <a href="<?= $url ?>" class="nav-link active"><?= $label ?></a>
                        </li>
                    <?php endforeach; ?>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>