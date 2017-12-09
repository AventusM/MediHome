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

    public static function authenticateLogin($inputUsr, $inputPwd) {
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
     * Käyttäjän rekisteröinnin authentikointi
     */

    public function validate_username($userName) {
        return parent::validate_username($userName);
    }

    public function validate_password($pwKentta1, $pwKentta2) {
        return parent::validate_password($pwKentta1, $pwKentta2);
    }

    public static function findByUser($userName) {
        $query = DB::connection()->prepare('SELECT * FROM Potilas WHERE username=:username LIMIT 1');
        $query->execute(array('username' => $userName));
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

    /*
     * Uuden käyttäjän rekisteröinti
     */

    public function saveNewPatient() {
        $query = DB::connection()->prepare('INSERT INTO Potilas (etunimi, sukunimi, hetu, username, pass) VALUES (:etunimi, :sukunimi, :hetu, :username, :pass) RETURNING id');
        $query->execute(array('etunimi' => $this->etunimi, 'sukunimi' => $this->sukunimi, 'hetu' => $this->hetu, 'username' => $this->username, 'pass' => $this->pass));
        $row = $query->fetch();
        $this->id = $row['id'];
    }

    /*
     * Olemassaolevan käyttäjän tietojen muutos
     * TODO
     * TODO
     * TODO
     */
}
