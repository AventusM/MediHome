<?php

class Hoitopyynto extends BaseModel {

    //Tauluattribuutit (huom. kaikki avaimet)
    public $id, $potilas_id, $laakari_id, $luontipvm, $kayntipvm, $oireet, $raportti;

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
                'oireet' => $row['oireet'],
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
                'luontipvm' => $row['luontipvm'],
                'kayntipvm' => $row['kayntipvm'],
                'oireet' => $row['oireet'],
                'raportti' => $row['raportti']
            ));
            return $pyynto;
        }
        return null;
    }

    public function save() {
        $query = DB::connection()->prepare('INSERT INTO Hoitopyynto (potilas_id, laakari_id, luontipvm, kayntipvm, oireet, raportti) VALUES (:potilas_id, :laakari_id, :luontipvm, :kayntipvm, :oireet, :raportti) RETURNING id');
        $query->execute(array('potilas_id' => $this->potilas_id, 'laakari_id' => $this->laakari_id, 'luontipvm' => $this->luontipvm, 'kayntipvm' => $this->kayntipvm, 'oireet' => $this->oireet, 'raportti' => $this->raportti));

        //Ei ole automaattista primary keyn lisäystä...?
        $row = $query->fetch();
        $this->id = $row['id'];
    }

}
