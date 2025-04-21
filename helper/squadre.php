<?php

class Squadre {

    public $coloreSfondo;
    public $coloreTesto;
    public $coloreBordo;    
    public $team;

    public function __construct($team, $db){
        $squadra = $db->select("SELECT * FROM squadre WHERE nome = ?", [$team]);

        $this->team = $team;
        $paramsJson = $squadra[0]['params'] ?? '{}';
        $params = json_decode($paramsJson, true);
        $this->coloreSfondo = $params['colore_sfondo'] ?? '#000000';
        $this->coloreTesto  = $params['colore_testo'] ?? '#ffffff';
        $this->coloreBordo  = $params['colore_bordo'] ?? '#ffffff';
    }

    public function creasquadra(){
        echo "
        <div class='myteam h1 p-2 fw-bold text-uppercase' style='background-color: ".$this->coloreSfondo."; border-color: ".$this->coloreBordo."; color: ".$this->coloreTesto.";'>
            <span>".$this->team."</span>
        </div>
        ";
    }
}