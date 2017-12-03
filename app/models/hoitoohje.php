<?php

class Hoitoohje extends BaseModel {

    public $id, $hoitopyynto_id, $luontipvm, $muokkauspvm, $ohje;

    public function __construct($attributes) {
        parent::__construct($attributes);
    }

    /*
     * Varmistustapa sille, ettei kirjautunut käyttäjä pääse toisen käyttäjän
     * tietoihin käsiksi urlia muokkaamalla
     */

    public static function indexBoundsCheck($potilasID, $hoitoohjeID) {
        return $potilasID === $hoitoohjeID;
    }

    /*
     * Potilaalle näytettävä yksittäinen ohje, kun hän valitsee sellaisen etusivultaan  
     */

    public static function find($id) {
        $query = DB::connection()->prepare('SELECT * FROM Hoitoohje WHERE id = :id LIMIT 1');
        $query->execute(array('id' => $id));
        $row = $query->fetch();

        if ($row) {
            $ohje = new Hoitoohje(array(
                'id' => $row['id'],
                'hoitopyynto_id' => $row['hoitopyynto_id'],
                'luontipvm' => $row['luontipvm'],
                'muokkauspvm' => $row['muokkauspvm'],
                'ohje' => $row['ohje']
            ));
            return $ohje;
        }
        return null;
    }

    /*
     * Potilaalle taulukkomuodossa näytettävät hoito-ohjeet. Lääkäri on siis tässä 
     * vaiheessa suorittanut kotikäynnin ja mahdollisesti raportoinut siitä omalla
     * etusivullaan
     */

    public static function findAllForPatient($id) {
        $query = DB::connection()->prepare(
                'SELECT Hoitoohje.id, Hoitoohje.hoitopyynto_id, Hoitoohje.luontipvm, muokkauspvm, ohje'
                . ' FROM Hoitopyynto, Hoitoohje'
                . ' WHERE Hoitopyynto.potilas_id=:id'
                . ' AND Hoitoohje.hoitopyynto_id = Hoitopyynto.id');
        $query->execute(array('id' => $id));
        $rows = $query->fetchAll();
        $ohjeet = array();

        foreach ($rows as $row) {
            $ohjeet[] = new Hoitoohje(array(
                'id' => $row['id'],
                'hoitopyynto_id' => $row['hoitopyynto_id'],
                'luontipvm' => $row['luontipvm'],
                'muokkauspvm' => $row['muokkauspvm'],
                'ohje' => $row['ohje'],
            ));
        }
        return $ohjeet;
    }

    /*
     * Funktio tallentaa Lääkäricontroller - luokan antamat tiedot uudesta hoito-ohjeesta
     * tietokantaan
     */

    public function saveNewInstructions() {
        $query = DB::connection()->prepare('INSERT INTO Hoitoohje (hoitopyynto_id, luontipvm, muokkauspvm, ohje) VALUES (:hoitopyynto_id, :luontipvm, :muokkauspvm, :ohje) RETURNING id');
        $query->execute(array('hoitopyynto_id' => $this->hoitopyynto_id, 'luontipvm' => $this->luontipvm, 'muokkauspvm' => $this->muokkauspvm, 'ohje' => $this->ohje));
        $row = $query->fetch();
        $this->id = $row['id'];
    }

}
