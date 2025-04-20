<?php
$competizioni = $db->select("SELECT * FROM competizioni ORDER BY id");
if (isset($_GET['competition'])) {
    $c = $_GET['competition'];
    echo htmlspecialchars($c); // Sanitize input to prevent XSS
}
?>

<div class="container py-5">
    <h1 class="mb-4 text-center"><?= $lang->getstring('competitions') ?></h1>

    <table class="table table-striped table-bordered">
        <thead class="table-dark">
            <tr>
                <th scope="col"><?= $lang->getstring('name') ?></th>
                <th scope="col"><?= $lang->getstring('description') ?></th>
                <th scope="col"><?= $lang->getstring('state') ?></th>
                <th scope="col"><?= $lang->getstring('teams') ?></th> <!-- Nuova colonna per le squadre -->
            </tr>
        </thead>
        <tbody>
            <?php foreach ($competizioni as $competizione): ?>
                <?php
                // Recupera le squadre associate alla competizione
                $squadre = $db->select("
                    SELECT squadra_nome FROM squadre_competizioni 
                    WHERE competizione_nome = ? AND competizione_stato = ?
                ", [$competizione['nome'], $competizione['stato']]);

                $squadre_lista = '';
                foreach ($squadre as $squadra) {
                    $squadre_lista .= '<a href="index.php?page=teams&team=' . urlencode($squadra['squadra_nome']) . '">' . htmlspecialchars($squadra['squadra_nome']) . '</a>, ';
                }
                // Rimuove l'ultima virgola e spazio
                $squadre_lista = rtrim($squadre_lista, ', ');
                ?>
                <tr>
                    <td><a href="index.php?page=competitions&competition=<?= $competizione['nome'] ?>"><?= htmlspecialchars($competizione['nome']) ?></a></td>
                    <td><?= htmlspecialchars($competizione['descrizione'] ?? '-') ?></td>
                    <td><a href="index.php?page=states&state=<?= $competizione['stato'] ?>"><?= htmlspecialchars($competizione['stato']) ?></a></td>
                    <td><?= $squadre_lista ?></td> <!-- Lista delle squadre -->
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>