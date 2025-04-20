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
                // LOGIN
                'welcome' => 'Benvenuto',
                'login' => 'Accedi',
                'register' => 'Registrati',
                'logout' => 'Esci',
                'profile' => 'Profilo',
                'email or username' => 'Email o nome utente',
                'password' => 'Password',
                'confirm password' => 'Conferma password',
                'username' => 'Nome utente',
                'email' => 'Email',
                'not registered?' => 'Non sei registrato?',
                'do you already have an account?' => 'Hai già un account?',
                'change password' => 'Cambia password',
                'current password' => 'Password attuale',
                'new password' => 'Nuova password',
                'confirm new password' => 'Conferma nuova password',
                'save' => 'Salva',
                'delete' => 'Elimina',

                'settings' => 'Impostazioni',
                'states' => 'Stati',
                'competitions' => 'Competizioni',
                'teams' => 'Squadre',

                // ERRORI
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
                // LOGIN
                'welcome' => 'Welcome',
                'login' => 'Login',
                'register' => 'Register',
                'logout' => 'Logout',
                'profile' => 'Profile',
                'email or username' => 'Email or Username',
                'password' => 'Password',
                'confirm password' => 'Confirm Password',
                'username' => 'Username',
                'email' => 'Email',
                'not registered?' => 'Not registered?',
                'do you already have an account?' => 'Do you already have an account?',
                'change password' => 'Change Password',
                'current password' => 'Current Password',
                'new password' => 'New Password',
                'confirm new password' => 'Confirm New Password',
                'save' => 'Save',
                'delete' => 'Delete',

                'settings' => 'Settings',
                'states' => 'States',
                'competitions' => 'Competitions',
                'teams' => 'Teams',

                // ERRORI
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
