<?php

class Hoitoohje extends BaseModel {

    public $id, $potilas_id, $laakari_id, $luontipvm, $muokkauspvm, $ohje;

    public function __construct($attributes) {
        parent::__construct($attributes);
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

}
