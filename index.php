<?php
require_once 'helper/db.php';
require_once 'helper/table.php';


$db = new db(); // Inizializza la connessione al database
$table = new table($db); // Inizializza la classe table con la connessione al database
$table->crea_utenti();  // Crea la tabella utenti
$table->crea_stati(); // Crea la tabella stati
$table->crea_competizioni(); // Crea la tabella compitizioni
$table->crea_squadre(); // Crea la tabella squadre
?>

<html>

<head>
    <?php
    include_once("head/meta.html");
    include_once("head/style.html");
    include_once("head/script.html");
    ?>
</head>
<body>
    <?php
    include_once("layout/navbar.php");
    ?>
</body>

</html>