<?php
$stato = $competizione = $squadra = null;
if (isset($_GET['state'])) {
    $stato = $_GET['state'];
} elseif (isset($_GET['competition'])) {
    $competizione = $_GET['competition'];
} elseif (isset($_GET['team'])) {
    $squadra = $_GET['team'];
} else {
    header("Location: index.php");
    exit;
}

?>