<?php
$competizioni = $db->select("SELECT * FROM competizioni ORDER BY id");
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

                // Crea una lista di nomi delle squadre separati da virgola
                $squadre_nomi = array_column($squadre, 'squadra_nome');
                $squadre_lista = implode(', ', $squadre_nomi);
                ?>
                <tr>
                    <td><?= htmlspecialchars($competizione['nome']) ?></td>
                    <td><?= htmlspecialchars($competizione['descrizione'] ?? '-') ?></td>
                    <td><?= htmlspecialchars($competizione['stato'] ?? '-') ?></td>
                    <td><?= htmlspecialchars($squadre_lista ?? '-') ?></td> <!-- Lista delle squadre -->
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>