<?php
// 1) Conteggio totale
$totalRecords = $db->select("SELECT COUNT(*) as count FROM stati")[0]['count'];

// 2) Routing e paginazione
//   - 'page' è per il routing (states)
//   - 'pag' è per la pagina di paginazione
$currentRouterPage = $_GET['page'] ?? 'states';    // per il router
$pagina    = isset($_GET['pag'])     ? (int)$_GET['pag']     : 1;   // pagina di paginazione
$perPage   = isset($_GET['perPage']) ? (int)$_GET['perPage'] : 10;  // risultati per pagina

// 3) Istanza di Pagination (4° argomento = nome del parametro pagina)
$pagination = new Pagination($totalRecords, $perPage, $pagina, 'pag');

// 4) Calcolo offset
$offset = $pagination->getLimit();

// 5) Query paginata
$stati = $db->select(
    "SELECT * FROM stati ORDER BY id LIMIT ? OFFSET ?",
    [$perPage, $offset]
);

// 6) Genera i link di paginazione
$baseUrl = "index.php?page=states";
$paginationLinks = $pagination->generatePagination($baseUrl);

// 7) Se hai selezionato uno stato da dettagliare
if (isset($_GET['state'])) {
    echo '<div class="alert alert-info">Dettaglio: '
        . htmlspecialchars($_GET['state'])
        . '</div>';
}
?>

<div class="container py-5">
    <h1 class="mb-4 text-center"><?= $lang->getstring('states') ?></h1>

    <table class="table table-striped table-bordered">
        <thead class="table-dark">
            <tr>
                <th><?= $lang->getstring('name') ?></th>
                <th><?= $lang->getstring('description') ?></th>
                <th><?= $lang->getstring('parent') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($stati as $stato): ?>
                <tr>
                    <td>
                        <a href="index.php?page=states&state=<?= urlencode($stato['nome']) ?>">
                            <?= htmlspecialchars($stato['nome']) ?>
                        </a>
                    </td>
                    <td><?= htmlspecialchars($stato['descrizione'] ?? '-') ?></td>
                    <td>
                        <?php if (!empty($stato['parent_id'])): ?>
                            <a href="index.php?page=states&state=<?= urlencode($stato['parent_id']) ?>">
                                <?= htmlspecialchars($stato['parent_id']) ?>
                            </a>
                        <?php endif; ?>
                    </td>
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