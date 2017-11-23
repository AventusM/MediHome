<?php

class Potilas extends BaseModel {

    public $id, $etunimi, $sukunimi, $hetu, $username, $pass;

    public function __construct($attributes) {
        parent::__construct($attributes);
    }

    public static function authenticate($kayttajanimi, $salasana) {
        $query = DB::connection()->prepare('SELECT * FROM Potilas WHERE username=:kayttajanimi AND pass=:salasana LIMIT 1');
        $query->execute(array('username' => $kayttajanimi, 'pass' => $salasana));
        $row = $query->fetch();
        if ($row) {
            
        } else {
            return null;
        }
    }

    public static function findByUserPass($kayttajanimi, $salasana) {
        
    }

}
