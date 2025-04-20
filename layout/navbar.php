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
                        <a href="<?= $url ?>" class="nav-link active"><?= $lang->getstring($label) ?></a>
                    </li>
                <?php endforeach; ?>
            </ul>

            <!-- Sezione destra: auth -->
            <ul class="navbar-nav m-0">

                <?php if (!isset($_SESSION['user'])) : ?>
                    <!-- Login / Registrati -->
                    <?php foreach (Config::$utentenonloggato as $label => $url): ?>
                        <li class="nav-item">
                            <a href="<?= $url ?>" class="nav-link active"><?= $lang->getstring($label) ?></a>
                        </li>
                    <?php endforeach; ?>
                <?php else: ?>
                    <!-- Logout / Profilo -->
                    <?php foreach (Config::getMenuUtenteloggato($lang) as $label => $url): ?>
                        <li class="nav-item">
                            <a href="<?= $url ?>" class="nav-link active"><?= $lang->getstring($label) ?></a>
                        </li>
                    <?php endforeach; ?>
                <?php endif; ?>
            </ul>

            <!-- Switcher -->
            <div class="language-switcher ms-3">
                <form method="get" onchange="this.submit()" style="display: inline;">
                    <!-- Campo nascosto per mantenere il parametro 'page' -->
                    <?php if (isset($_GET['page'])): ?>
                        <input type="hidden" name="page" value="<?= $_GET['page'] ?>">
                    <?php endif; ?>
                    <select name="lang">
                        <option value="it" <?= ($_SESSION['lang'] ?? 'it') === 'it' ? 'selected' : '' ?>>🇮🇹</option>
                        <option value="en" <?= ($_SESSION['lang'] ?? 'it') === 'en' ? 'selected' : '' ?>>🇬🇧</option>
                    </select>
                </form>
            </div>

        </div>
    </div>
</nav>