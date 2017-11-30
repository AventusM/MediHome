<?php

class Hoitoohje extends BaseModel {

    public $id, $potilas_id, $laakari_id, $luontipvm, $muokkauspvm, $ohje;

    public function __construct($attributes) {
        parent::__construct($attributes);
    }

    public static function indexBoundsCheck($potilasID, $hoitopyyntoID) {
        return $potilasID === $hoitopyyntoID;
    }

    public static function find($id) {
        $query = DB::connection()->prepare('SELECT * FROM Hoitoohje WHERE id = :id LIMIT 1');
        $query->execute(array('id' => $id));
        $row = $query->fetch();

        if ($row) {
            $ohje = new Hoitoohje(array(
                'id' => $row['id'],
                'potilas_id' => $row['potilas_id'],
                'laakari_id' => $row['laakari_id'],
                'luontipvm' => $row['luontipvm'],
                'muokkauspvm' => $row['muokkauspvm'],
                'ohje' => $row['ohje']
            ));
            return $ohje;
        }
        return null;
    }

    public static function findAllForPatient($id) {
        $query = DB::connection()->prepare('SELECT * FROM Hoitoohje WHERE potilas_id=:id');
        $query->execute(array('id' => $id));
        $rows = $query->fetchAll();
        $ohjeet = array();

        foreach ($rows as $row) {
            $ohjeet[] = new Hoitoohje(array(
                'id' => $row['id'],
                'potilas_id' => $row['potilas_id'],
                'laakari_id' => $row['laakari_id'],
                'luontipvm' => $row['luontipvm'],
                'muokkauspvm' => $row['muokkauspvm'],
                'ohje' => $row['ohje'],
            ));
        }
        return $ohjeet;
    }

    public function saveNewInstructions() {
        $query = DB::connection()->prepare('INSERT INTO Hoitoohje (potilas_id, laakari_id, luontipvm, muokkauspvm, ohje) VALUES (:potilas_id, :laakari_id, :luontipvm, :muokkauspvm, :ohje) RETURNING id');
        $query->execute(array('potilas_id' => $this->potilas_id, 'laakari_id' => $this->laakari_id, 'luontipvm' => $this->luontipvm, 'muokkauspvm' => $this->muokkauspvm, 'ohje' => $this->ohje));
        $row = $query->fetch();
        $this->id = $row['id'];
    }

}