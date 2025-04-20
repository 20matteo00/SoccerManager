<?php
$stati = $db->select("SELECT * FROM stati ORDER BY id");

if (isset($_GET['state'])) {
    $s = $_GET['state'];
    echo htmlspecialchars($s); // Sanitize input to prevent XSS
}
?>

<div class="container py-5">
    <h1 class="mb-4 text-center"><?= $lang->getstring('states') ?></h1>

    <table class="table table-striped table-bordered">
        <thead class="table-dark">
            <tr>
                <th scope="col"><?= $lang->getstring('name') ?></th>
                <th scope="col"><?= $lang->getstring('description') ?></th>
                <th scope="col"><?= $lang->getstring('parent') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($stati as $stato): ?>
                <tr>
                    <td><a href="index.php?page=states&state=<?= $stato['nome'] ?>"><?= htmlspecialchars($stato['nome']) ?></a></td>
                    <td><?= htmlspecialchars($stato['descrizione'] ?? '-') ?></td>
                    <td><a href="index.php?page=states&state=<?= isset($stato['parent_id']) ? $stato['parent_id'] : '' ?>"><?= isset($stato['parent_id']) ? htmlspecialchars($stato['parent_id']) : '' ?></a></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>