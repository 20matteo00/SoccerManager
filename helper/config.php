<?php

class Config {
    // Generali
    public static string $nomesito = "Soccer Manager";

    // Percorsi principali (possono essere usati nei menu o nei router)
    public static array $principale = [
        'states' => '?page=stati',
        'competitions' => '#',
        'teams' => '#'
    ];
    public static array $utentenonloggato = [
        'login' => '?page=login',
        'register' => '?page=register'
    ];

    // Impostazioni del database
    public static string $dbHost = 'localhost';
    public static string $dbName = 'soccer_manager';
    public static string $dbUser = 'root';
    public static string $dbPass = 'Matteo00';



    public static function getBenvenuto($lang): string {
        return isset($_SESSION['user']) 
            ? $lang->getstring("welcome") . " " . $_SESSION['user']['username'] : "welcome";
    }

    public static function getMenuUtenteloggato($lang): array {
        return [
            'logout' => '?page=logout',
            self::getBenvenuto($lang) => '?page=profile'
        ];
    }
    
}
