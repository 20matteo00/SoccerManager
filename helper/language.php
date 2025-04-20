<?php

class Language
{
    private $lang = 'it'; // Lingua predefinita

    public function __construct($lang = 'it')
    {
        $this->lang = $lang;
    }

    public function getLang()
    {
        return $this->lang;
    }

    public function getstring($key)
    {
        $translations = [
            'it' => [
                /* MENU */
                //MENU PRINCIPALE
                'states' => 'Stati',
                'competitions' => 'Competizioni',
                'teams' => 'Squadre',

                //MENU NON LOGGATO
                'login' => 'Accedi',
                'register' => 'Registrati',

                //MENU LOGGATO
                'welcome' => 'Benvenuto',
                'logout' => 'Esci',

                /* AUTENTICAZIONE E PROFILO */
                // CAMPI
                'username' => 'Nome Utente',
                'email' => 'Email',
                'email or username' => 'Email o Nome Utente',
                'password' => 'Password',
                'confirm password' => 'Conferma password',
                'current password' => 'Password attuale',
                'new password' => 'Nuova password',
                'confirm new password' => 'Conferma nuova password',

                // PULSANTI
                'save' => 'Salva',

                // FRASI
                'profile' => 'Profilo',
                'change password' => 'Cambia password',
                'not registered?' => 'Non sei registrato?',
                'do you already have an account?' => 'Hai già un account?',

                /* STATI */
                // CAMPI
                'name' => 'Nome',
                'description' => 'Descrizione',
                'parent' => 'Gruppo',
                'state' => 'Stato',

                /* ERRORI */
                // ERRORI AUTENTICAZIONE E PROFILO
                'incorrect email or password.' => 'Email o password errati.',
                'username or email already in use!' => 'Nome utente o email già in uso!',
                'username already in use!' => 'Nome utente già in uso!',
                'username not found!' => 'Nome utente non trovato!',
                'incorrect current password!' => 'Password attuale errata!',
                'passwords do not match!' => 'Le password non corrispondono!',
                'error while updating!' => 'Errore durante l\'aggiornamento!',
                // Aggiungi altre traduzioni qui
            ],
            'en' => [
                /* MENU */
                //MENU PRINCIPALE
                'states' => 'States',
                'competitions' => 'Competitions',
                'teams' => 'Teams',

                //MENU NON LOGGATO
                'login' => 'Login',
                'register' => 'Register',

                //MENU LOGGATO
                'welcome' => 'Welcome',
                'logout' => 'Logout',

                /* AUTENTICAZIONE E PROFILO */
                // CAMPI
                'username' => 'Username',
                'email' => 'Email',
                'email or username' => 'Email or Username',
                'password' => 'Password',
                'confirm password' => 'Confirm Password',
                'current password' => 'Current Password',
                'new password' => 'New Password',
                'confirm new password' => 'Confirm New Password',

                // PULSANTI
                'save' => 'Save',

                // FRASI
                'profile' => 'Profile',
                'change password' => 'Change Password',
                'not registered?' => 'Not registered?',
                'do you already have an account?' => 'Do you already have an account?',

                /* STATI */
                // CAMPI
                'name' => 'Name',
                'description' => 'Description',
                'parent' => 'Group',
                'state' => 'State',

                /* ERRORI */
                // ERRORI AUTENTICAZIONE E PROFILO                
                'incorrect email or password.' => 'Incorrect email or password.',
                'username or email already in use!' => 'Username or email already in use!',
                'username already in use!' => 'Username already in use!',
                'username not found!' => 'Username not found!',
                'incorrect current password!' => 'Incorrect current password!',
                'passwords do not match!' => 'Passwords do not match!',
                'error while updating!' => 'Error while updating!',
                // Aggiungi altre traduzioni qui
            ]
        ];

        return $translations[$this->lang][$key] ?? $key; // Restituisce la traduzione o la chiave se non trovata
    }
}
