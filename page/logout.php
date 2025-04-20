<?php
session_start();
// Sgancia tutte le variabili di sessione
session_unset();
// Distrugge la sessione
session_destroy();
// Rimanda alla pagina di login (o home)
header('Location: index.php');
exit;
