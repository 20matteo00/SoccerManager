<?php
session_start();

require_once("helper/config.php");
require_once("helper/db.php");
require_once("helper/table.php");
require_once("helper/language.php");
require_once("helper/pagination.php");
require_once("helper/squadre.php");

$db = new Db(); // Inizializza la connessione al database
$table = new Table($db); // Inizializza la classe table con la connessione al database
$page = isset($_GET["page"]) ? "page/" . $_GET["page"] . ".php" : "page/home.php"; // Imposta la pagina di default
if (isset($_GET['lang'])) {
    $_SESSION['lang'] = $_GET['lang'];
} 
$lang = new Language($_SESSION['lang'] ?? 'it');
?>

<!DOCTYPE html>
<html lang="<?= $lang->getLang() ?>">

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