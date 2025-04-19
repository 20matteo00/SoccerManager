<?php

class Config {
    // Generali
    public static string $nomesito = "Soccer Manager";
    // Percorsi principali (possono essere usati nei menu o nei router)
    public static array $principale = [
        'Stati' => '#',
        'Competizioni' => '#',
        'Squadre' => '#'
    ];
    public static array $utentenonloggato = [
        'Accedi' => '?page=login',
        'Registrati' => '?page=register'
    ];
    public static array $utenteloggato = [
        'Esci' => '?page=login',
        'Benvenuto' => '?page=register'
    ];

    // Impostazioni del database
    public static string $dbHost = 'localhost';
    public static string $dbName = 'soccer_manager';
    public static string $dbUser = 'root';
    public static string $dbPass = 'Matteo00';
}
