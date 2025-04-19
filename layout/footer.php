<footer class="bg-dark text-white py-4">
    <div class="container">
        <div class="row">
            <!-- Colonna 1: Informazioni -->
            <div class="col-12 col-lg-4">
                <a class="navbar-brand" href="#">
                    <img src="images/logo.png" alt="Soccer Manager" class="d-inline-block align-text-top">
                </a>
            </div>
            <!-- Colonna 2: Link utili -->
            <div class="col-12 col-lg-4">
                <h5>Link utili</h5>
                <ul class="list-unstyled">
                    <?php foreach (Config::$principale as $label => $url): ?>
                        <li><a href="<?= $url ?>" class="text-white text-decoration-none"><?= $label ?></a></li>
                    <?php endforeach; ?>
                </ul>
            </div>

            <!-- Colonna 3: Contatti -->
            <div class="col-12 col-lg-4">
                <h5>Contattaci</h5>
                <ul class="list-unstyled">
                    <li><i class="bi bi-telephone-fill"></i> +39 123 456 7890</li>
                    <li><i class="bi bi-envelope-fill"></i> info@tuaazienda.it</li>
                    <li><i class="bi bi-geo-alt-fill"></i> Via Roma 1, 00100 Roma</li>
                </ul>
            </div>
        </div>
    </div>
</footer>