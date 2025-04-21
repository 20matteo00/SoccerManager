<?php
$whereClause = '';
$params      = [];
if (isset($_GET['parent'])) {
    // Bind del parent_id (è una stringa, quindi lo passiamo come parametro)
    $whereClause = "WHERE parent_id = ?";
    $params[]    = $_GET['parent'];
}
// 1) Conteggio totale
$totalRow     = $db->select(
    "SELECT COUNT(*) AS count FROM stati $whereClause",
    $params
);
$totalRecords = $totalRow[0]['count'];

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
$queryParams = array_merge(
    $params,
    [$perPage, $offset]
);

$stati = $db->select(
    "SELECT * 
     FROM stati 
     $whereClause 
     ORDER BY id 
     LIMIT ? OFFSET ?",
    $queryParams
);

// 6) Genera i link di paginazione
$baseUrl = "index.php?page=states";
$paginationLinks = $pagination->generatePagination($baseUrl);
$continenti = $db->select("SELECT parent_id FROM stati WHERE parent_id IS NOT NULL GROUP BY parent_id");
?>

<div class="container py-5">
    <h1 class="mb-4 text-center">
        <?php 
        echo $lang->getstring('states');
        if (isset($_GET['parent'])) {
            echo ' -> ' . htmlspecialchars($_GET['parent']);
        } ?>
    </h1>
    <?php $pagination->generatefilter($continenti, "states"); ?>
    <table class="table table-striped table-bordered">
        <thead class="table-dark">
            <tr>
                <th class="text-center align-middle"><?= $lang->getstring('flag') ?></th>
                <th class="text-center align-middle"><?= $lang->getstring('name') ?></th>
                <th class="text-center align-middle"><?= $lang->getstring('parent') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($stati as $stato): ?>
                <?php
                $iso = json_decode($stato['params'])->isocode;
                if (empty($iso)) {
                    $url = 'images/Continenti/' . $stato["nome"] . '.png'; // codice ISO di fallback
                } else {
                    $url  = "https://flagcdn.com/256x192/{$iso}.png";
                }
                ?>
                <tr>
                    <td class="text-center align-middle"><img src="<?= $url ?>" alt="Bandiera <?= $stato['nome'] ?>" class="img-fluid myimg"></td>
                    <td class="text-center align-middle">
                        <a href="index.php?page=details&state=<?= urlencode($stato['nome']) ?>">
                            <?= htmlspecialchars($stato['nome']) ?>
                        </a>
                    </td>
                    <td class="text-center align-middle">
                        <?php if (!empty($stato['parent_id'])): ?>
                            <a href="index.php?page=details&state=<?= urlencode($stato['parent_id']) ?>">
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