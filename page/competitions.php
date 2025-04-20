<?php
// 1) Conteggio totale
$totalRecords = $db->select("SELECT COUNT(*) as count FROM competizioni")[0]['count'];

// 2) Routing e paginazione
//   - 'page' è per il routing (competition)
//   - 'pag' è per la pagina di paginazione
$currentRouterPage = $_GET['page'] ?? 'competitions';    // per il router
$pagina    = isset($_GET['pag'])     ? (int)$_GET['pag']     : 1;   // pagina di paginazione
$perPage   = isset($_GET['perPage']) ? (int)$_GET['perPage'] : 10;  // risultati per pagina

// 3) Istanza di Pagination (4° argomento = nome del parametro pagina)
$pagination = new Pagination($totalRecords, $perPage, $pagina, 'pag');

// 4) Calcolo offset
$offset = $pagination->getLimit();

// 5) Query paginata
$competizioni = $db->select(
    "SELECT * FROM competizioni ORDER BY id LIMIT ? OFFSET ?",
    [$perPage, $offset]
);

// 6) Genera i link di paginazione
$baseUrl = "index.php?page=competitions";
$paginationLinks = $pagination->generatePagination($baseUrl);

// 7) Se hai selezionato una competizione da dettagliare
if (isset($_GET['competition'])) {
    echo '<div class="alert alert-info">Dettaglio: '
        . htmlspecialchars($_GET['competition'])
        . '</div>';
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
    
    <!-- Paginazione -->
    <nav aria-label="Page navigation">
        <ul class="pagination justify-content-center">
            <?= $paginationLinks ?>
        </ul>
    </nav>
</div>