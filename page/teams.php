<?php
// 1) Conteggio totale
$totalRecords = $db->select("SELECT COUNT(*) as count FROM squadre")[0]['count'];

// 2) Routing e paginazione
//   - 'page' è per il routing (teams)
//   - 'pag' è per la pagina di paginazione
$currentRouterPage = $_GET['page'] ?? 'teams';    // per il router
$pagina    = isset($_GET['pag'])     ? (int)$_GET['pag']     : 1;   // pagina di paginazione
$perPage   = isset($_GET['perPage']) ? (int)$_GET['perPage'] : 10;  // risultati per pagina

// 3) Istanza di Pagination (4° argomento = nome del parametro pagina)
$pagination = new Pagination($totalRecords, $perPage, $pagina, 'pag');

// 4) Calcolo offset
$offset = $pagination->getLimit();

// 5) Query paginata
$squadre = $db->select(
    "SELECT * FROM squadre ORDER BY id LIMIT ? OFFSET ?",
    [$perPage, $offset]
);

// 6) Genera i link di paginazione
$baseUrl = "index.php?page=teams";
$paginationLinks = $pagination->generatePagination($baseUrl);

// 7) Se hai selezionato una competizione da dettagliare
if (isset($_GET['team'])) {
    echo '<div class="alert alert-info">Dettaglio: '
        . htmlspecialchars($_GET['team'])
        . '</div>';
}
?>

<div class="container py-5">
    <h1 class="mb-4 text-center"><?= $lang->getstring('teams') ?></h1>

    <table class="table table-striped table-bordered">
        <thead class="table-dark">
            <tr>
                <th class="text-center align-middle"><?= $lang->getstring('name') ?></th>
                <th class="text-center align-middle"><?= $lang->getstring('description') ?></th>
                <th class="text-center align-middle"><?= $lang->getstring('state') ?></th>
                <th class="text-center align-middle"><?= $lang->getstring('competitions') ?></th> <!-- Nuova colonna per le competizioni -->
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
                    $competizioni_lista .= '<a href="index.php?page=details&competition=' . urlencode($competizione['competizione_nome']) . '">' . htmlspecialchars($competizione['competizione_nome']) . '</a>, ';
                }
                // Rimuove l'ultima virgola e spazio
                $competizioni_lista = rtrim($competizioni_lista, ', ');
                ?>
                <tr>
                    <td class="text-center align-middle"><a href="index.php?page=details&team=<?= $squadra['nome'] ?>"><?= htmlspecialchars($squadra['nome']) ?></a></td>
                    <td class="text-center align-middle"><?= htmlspecialchars($squadra['descrizione'] ?? '-') ?></td>
                    <td class="text-center align-middle"><a href="index.php?page=details&state=<?= $squadra['stato'] ?>"><?= htmlspecialchars($squadra['stato']) ?></a></td>
                    <td class="text-center align-middle"><?= $competizioni_lista ?></td> <!-- Lista delle competizioni -->
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