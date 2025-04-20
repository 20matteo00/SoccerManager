<?php
$stati = $db->select("SELECT * FROM stati ORDER BY id");
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
                    <td><?= htmlspecialchars($stato['nome']) ?></td>
                    <td><?= htmlspecialchars($stato['descrizione'] ?? '-') ?></td>
                    <td><?= htmlspecialchars($stato['parent_id'] ?? '-') ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
