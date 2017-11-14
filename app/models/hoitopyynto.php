<?php

class Hoitopyynto extends BaseModel {

    //Tauluattribuutit (huom. kaikki avaimet)
    public $id, $potilas_id, $laakari_id, $luontipvm, $kayntipvm, $raportti;

    //Konstruktori
    public function __construct($attributes) {
        parent::__construct($attributes);
    }

    public static function all() {
        $query = DB::connection()->prepare('SELECT * FROM Hoitopyynto');
        $query->execute();
        $rows = $query->fetchAll();
        $pyynnot = array();

        foreach ($rows as $row) {
            $pyynnot[] = new Hoitopyynto(array(
                'id' => $row['id'],
                'potilas_id' => $row['potilas_id'],
                'laakari_id' => $row['laakari_id'],
                'luontipvm' => $row['luontipvm'],
                'kayntipvm' => $row['kayntipvm'],
                'raportti' => $row['raportti']
            ));
        }
        return $pyynnot;
    }

    public static function find($id) {
        $query = DB::connection()->prepare('SELECT * FROM Hoitopyynto WHERE id = :id LIMIT 1');
        $query->execute(array('id' => $id));
        $row = $query->fetch();

        if ($row) {
            $pyynto = new Hoitopyynto(array(
                'id' => $row['id'],
                'potilas_id' => $row['potilas_id'],
                'laakari_id' => $row['laakari_id'],
                'kayntipvm' => $row['kayntipvm'],
                'luontipvm' => $row['luontipvm'],
                'raportti' => $row['raportti']
            ));
            return $pyynto;
        }
        return null;
    }

}
