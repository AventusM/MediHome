<?php

class Laakari extends BaseModel {

    public $id, $etunimi, $sukunimi, $sv, $username, $pass;

    public function __construct($attributes) {
        parent::__construct($attributes);
    }

    /*
     * Sisäänkirjautumisen yhteydessä suoritettava funktio, missä palautetetaan annetuista tiedoista
     * riippuen lääkäriolio
     */

    public static function authenticate($inputDoc, $inputPwd) {
        $query = DB::connection()->prepare('SELECT * FROM Laakari WHERE username=:user AND pass=:pwd LIMIT 1');
        $query->execute(array('user' => $inputDoc, 'pwd' => $inputPwd));
        $row = $query->fetch();
        if ($row) {
            $laakari = new Laakari(array(
                'id' => $row['id'],
                'etunimi' => $row['etunimi'],
                'sukunimi' => $row['sukunimi'],
                'sv' => $row['sv'],
                'username' => $row['username'],
                'pass' => $row['pass'],
            ));
            return $laakari;
        } else {
            return null;
        }
    }

    /*
     * Hakee yksittäisen lääkärin tiedot parametristä riippuen. Funktiota käytetään ainakin etusivulla
     * oikean lääkärin tietoihin hakemiseen
     */

    public static function find($id) {
        $query = DB::connection()->prepare('SELECT * FROM Laakari WHERE id=:inputId LIMIT 1');
        $query->execute(array('inputId' => $id));
        $row = $query->fetch();
        if ($row) {
            $laakari = new Laakari(array(
                'id' => $row['id'],
                'etunimi' => $row['etunimi'],
                'sukunimi' => $row['sukunimi'],
                'sv' => $row['sv'],
                'username' => $row['username'],
                'pass' => $row['pass'],
            ));
            return $laakari;
        }
        return null;
    }

}
