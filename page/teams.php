<?php
$squadre = $db->select("SELECT * FROM squadre ORDER BY id");
if (isset($_GET['team'])) {
    $t = $_GET['team'];
    echo htmlspecialchars($t); // Sanitize input to prevent XSS
}
?>

<div class="container py-5">
    <h1 class="mb-4 text-center"><?= $lang->getstring('teams') ?></h1>

    <table class="table table-striped table-bordered">
        <thead class="table-dark">
            <tr>
                <th scope="col"><?= $lang->getstring('name') ?></th>
                <th scope="col"><?= $lang->getstring('description') ?></th>
                <th scope="col"><?= $lang->getstring('state') ?></th>
                <th scope="col"><?= $lang->getstring('competitions') ?></th> <!-- Nuova colonna per le competizioni -->
            </tr>
        </thead>
        <tbody>
            <?php foreach ($squadre as $squadra): ?>
                <?php
                // Recupera le squadre associate alla competizione
                $competizioni = $db->select("
                    SELECT competizione_nome FROM squadre_competizioni 
                    WHERE squadra_nome = ? AND squadra_stato = ?
                ", [$squadra['nome'], $squadra['stato']]);

                $competizioni_lista = '';
                foreach ($competizioni as $competizione) {
                    $competizioni_lista .= '<a href="index.php?page=competitions&competition=' . urlencode($competizione['competizione_nome']) . '">' . htmlspecialchars($competizione['competizione_nome']) . '</a>, ';
                }
                // Rimuove l'ultima virgola e spazio
                $competizioni_lista = rtrim($competizioni_lista, ', ');
                ?>
                <tr>
                    <td><a href="index.php?page=teams&team=<?= $squadra['nome'] ?>"><?= htmlspecialchars($squadra['nome']) ?></a></td>
                    <td><?= htmlspecialchars($squadra['descrizione'] ?? '-') ?></td>
                    <td><a href="index.php?page=states&state=<?= $squadra['stato'] ?>"><?= htmlspecialchars($squadra['stato']) ?></a></td>
                    <td><?= $competizioni_lista ?></td> <!-- Lista delle competizioni -->
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>