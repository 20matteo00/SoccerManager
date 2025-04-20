<?php
$squadre = $db->select("SELECT * FROM squadre ORDER BY id");
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

                // Crea una lista di nomi delle competizioni separati da virgola
                $competizioni_nomi = array_column($competizioni, 'competizione_nome');
                $competizioni_lista = implode(', ', $competizioni_nomi);
                ?>
                <tr>
                    <td><?= htmlspecialchars($squadra['nome']) ?></td>
                    <td><?= htmlspecialchars($squadra['descrizione'] ?? '-') ?></td>
                    <td><?= htmlspecialchars($squadra['stato'] ?? '-') ?></td>
                    <td><?= htmlspecialchars($competizioni_lista ?? '-') ?></td> <!-- Lista delle competizioni -->
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>