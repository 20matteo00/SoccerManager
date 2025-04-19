<?php
session_start();

require_once("helper/config.php");
require_once("helper/db.php");
require_once("helper/table.php");


$db = new db(); // Inizializza la connessione al database
$table = new table($db); // Inizializza la classe table con la connessione al database
if (isset($_GET["page"])) {
    $page = "page/" . $_GET["page"] . ".php";
} else { $page = "index.php"; }
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
    include_once($page);
    include_once("layout/footer.php");
    ?>
</body>

</html>