<?php

class Potilas extends BaseModel {

    public $id, $etunimi, $sukunimi, $hetu, $username, $pass;

    public function __construct($attributes) {
        parent::__construct($attributes);
    }

    /*
     * Tavallisen käyttäjän kirjautumisen yhteydessä suoritettava funktio, joka palauttaa
     * joko löydetyn käyttäjän oikein annettujen tunnusten perusteella tai null, jolloin
     * järjestelmä myöhemmin ilmoittaa (tai) ei käyttäjälle virheellisestä suorituksesta
     */

    public static function authenticate($inputUsr, $inputPwd) {
        $query = DB::connection()->prepare('SELECT * FROM Potilas WHERE username=:user AND pass=:pwd LIMIT 1');
        $query->execute(array('user' => $inputUsr, 'pwd' => $inputPwd));
        $row = $query->fetch();
        if ($row) {
            $potilas = new Potilas(array(
                'id' => $row['id'],
                'etunimi' => $row['etunimi'],
                'sukunimi' => $row['sukunimi'],
                'hetu' => $row['hetu'],
                'username' => $row['username'],
                'pass' => $row['pass'],
            ));
            return $potilas;
        } else {
            return null;
        }
    }

    /*
     * Sisäänkirjautuneen käyttäjän identifiointi etusivulla (ks. Lääkäriluokan vastaava)
     */

    public static function find($id) {
        $query = DB::connection()->prepare('SELECT * FROM Potilas WHERE id=:inputId LIMIT 1');
        $query->execute(array('inputId' => $id));
        $row = $query->fetch();
        if ($row) {
            $potilas = new Potilas(array(
                'id' => $row['id'],
                'etunimi' => $row['etunimi'],
                'sukunimi' => $row['sukunimi'],
                'hetu' => $row['hetu'],
                'username' => $row['username'],
                'pass' => $row['pass'],
            ));
            return $potilas;
        }
        return null;
    }

}
