<?php

class Language
{
    private $lang = 'it'; // Lingua predefinita
    private $translations = [];

    public function __construct($lang = 'it')
    {
        $this->lang = $lang;
        $this->loadTranslations();
    }

    // Carica il file delle traduzioni per la lingua selezionata
    private function loadTranslations()
    {
        // Torniamo indietro di una cartella
        $parentDir = dirname(realpath(__DIR__));
        // Aggiungiamo il percorso per il file JSON di traduzione
        $langFile = $parentDir . '/language/' . $this->lang . '.json';

        if (file_exists($langFile)) {
            $this->translations = json_decode(file_get_contents($langFile), true);
        } else {
            // Se il file non esiste, fallback alla lingua predefinita
            $this->translations = [];
        }
    }

    public function getLang()
    {
        return $this->lang;
    }

    public function getstring($key)
    {
        // Restituisce la traduzione o la chiave stessa se non trovata
        return $this->translations[$key] ?? $key;
    }

    // Imposta una nuova lingua e ricarica le traduzioni
    public function setLang($lang)
    {
        $this->lang = $lang;
        $this->loadTranslations();
    }
}
