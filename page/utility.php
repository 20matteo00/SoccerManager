<?php
// Verifica e gestione azioni
if (isset($_GET['action'])) {
    $action = $_GET['action'];
    $team = $_GET['team'] ?? null;
    $parent = $_GET['parent'] ?? null;
    $pag = $_GET['pag'] ?? null;
    $perPage = $_GET['perPage'] ?? null;

    if ($action === 'edit' && $team) {
        $squadra = $db->select("SELECT * FROM squadre WHERE nome = ?", [$team]);
        if (!$squadra) {
            header('Location: index.php');
            exit;
        }
    } elseif ($action === 'delete' && $team) {
        $db->delete("DELETE FROM squadre WHERE nome = ?", [$team]);
        header('Location: index.php?page=teams' . ($parent ? '&parent=' . $parent : '') . ($pag ? '&pag=' . $pag : '') . ($perPage ? '&perPage=' . $perPage : ''));
        exit;
    } else {
        header('Location: index.php');
        exit;
    }
} else {
    header('Location: index.php');
    exit;
}

// Salvataggio parametri se inviato
if (isset($_POST['invia']) && isset($team)) {
    $params = [
        'colore_sfondo'   => $_POST['colore_sfondo'] ?? '#ffffff',
        'colore_testo'    => $_POST['colore_testo'] ?? '#000000',
        'colore_bordo'    => $_POST['colore_bordo'] ?? '#cccccc',
        'valore_squadra'  => (int)($_POST['valore_squadra'] ?? 0),
        'attacco'         => max(0, min(100, (int)($_POST['attacco'] ?? 50))),
        'difesa'          => max(0, min(100, (int)($_POST['difesa'] ?? 50)))
    ];

    $json = json_encode($params);
    $db->update("UPDATE squadre SET params = ? WHERE nome = ?", [$json, $team]);
    header('Location: index.php?page=teams' . ($parent ? '&parent=' . $parent : '') . ($pag ? '&pag=' . $pag : '') . ($perPage ? '&perPage=' . $perPage : ''));
    exit;
}

// Visualizzazione form
if (isset($squadra) && !empty($squadra)):
    $paramsJson   = $squadra[0]['params'] ?? '{}';
    $params       = json_decode($paramsJson, true);

    $coloreSfondo = $params['colore_sfondo'] ?? '#000000';
    $coloreTesto  = $params['colore_testo'] ?? '#ffffff';
    $coloreBordo  = $params['colore_bordo'] ?? '#ffffff';
    $valore       = $params['valore_squadra'] ?? 0;
    $attacco      = $params['attacco'] ?? 0;
    $difesa       = $params['difesa'] ?? 0;

    $s = new Squadre($team, $db);
?>

<div class="container my-5">
    <div class="mb-4 text-center"><?php $s->creasquadra(); ?></div>
    <form method="post">
        <div class="row g-3 align-items-end">
            <div class="col">
                <label class="form-label">Colore Sfondo</label>
                <input type="color" name="colore_sfondo" class="form-control" value="<?= htmlspecialchars($coloreSfondo) ?>">
            </div>
            <div class="col">
                <label class="form-label">Colore Testo</label>
                <input type="color" name="colore_testo" class="form-control" value="<?= htmlspecialchars($coloreTesto) ?>">
            </div>
            <div class="col">
                <label class="form-label">Colore Bordo</label>
                <input type="color" name="colore_bordo" class="form-control" value="<?= htmlspecialchars($coloreBordo) ?>">
            </div>
            <div class="col">
                <label class="form-label">Valore Squadra</label>
                <input type="number" name="valore_squadra" class="form-control" value="<?= htmlspecialchars($valore) ?>" min="1" max="10000">
            </div>
            <div class="col">
                <label class="form-label">Attacco</label>
                <input type="number" name="attacco" class="form-control" value="<?= htmlspecialchars($attacco) ?>" min="1" max="100">
            </div>
            <div class="col">
                <label class="form-label">Difesa</label>
                <input type="number" name="difesa" class="form-control" value="<?= htmlspecialchars($difesa) ?>" min="1" max="100">
            </div>
        </div>

        <div class="mt-4">
            <button type="submit" name="invia" class="btn btn-success"><?= $lang->getstring("save") ?></button>
        </div>
    </form>
</div>

<?php endif; ?>
