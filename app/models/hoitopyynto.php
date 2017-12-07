<?php

class Hoitopyynto extends BaseModel {

    public $id, $potilas_id, $laakari_id, $luontipvm, $kayntipvm, $oireet, $raportti, $ohje;

    public function __construct($attributes) {
        parent::__construct($attributes);
        $this->validators = array('validate_request');
    }

    public function validate_request($paramOireet) {
        return parent::validate_request($paramOireet);
    }

    public static function indexBoundsCheck($potilasID, $hoitopyyntoID) {
        return $potilasID === $hoitopyyntoID;
    }

    public static function findAllForPatient($inputPotilasID) {
        $query = DB::connection()->prepare('SELECT * FROM Hoitopyynto WHERE potilas_id=:potilas_id');
        $query->execute(array('potilas_id' => $inputPotilasID));
        $rows = $query->fetchAll();
        $potilaanPyynnot = array();
        foreach ($rows as $row) {
//            $etunimi = Laakari::find($row['laakari_id'])->etunimi;
//            $sukunimi = Laakari::find($row['laakari_id'])->sukunimi;
            $potilaanPyynnot[] = new Hoitopyynto(array(
                'id' => $row['id'],
                'potilas_id' => $row['potilas_id'],
                'laakari_id' => $row['laakari_id'],
                'luontipvm' => $row['luontipvm'],
                'kayntipvm' => $row['kayntipvm'],
                'oireet' => $row['oireet'],
                'raportti' => $row['raportti'],
                'ohje' => $row['ohje']
//                'etunimi' => Laakari::find($row['laakari_id'])->etunimi,
//                'sukunimi' => Laakari::find($row['laakari_id'])->sukunimi,
            ));
//            array_push($potilaanPyynnot, $row)
        }
//        $yhdistettyTaulu = array_merge($potilaanPyynnot, $laakaritPerPyynto);
        return $potilaanPyynnot;
    }

    public static function findAllAcceptedForDoctor($inputDoctorID) {
        $query = DB::connection()->prepare('SELECT * FROM Hoitopyynto WHERE laakari_id=:laakari_id');
        $query->execute(array('laakari_id' => $inputDoctorID));
        $rows = $query->fetchAll();
        $laakarinHyvaksymatPyynnot = array();

        foreach ($rows as $row) {
            $laakarinHyvaksymatPyynnot[] = new Hoitopyynto(array(
                'id' => $row['id'],
                'potilas_id' => $row['potilas_id'],
                'laakari_id' => $row['laakari_id'],
                'luontipvm' => $row['luontipvm'],
                'kayntipvm' => $row['kayntipvm'],
                'oireet' => $row['oireet'],
                'raportti' => $row['raportti'],
                'ohje' => $row['ohje']
            ));
        }
        return $laakarinHyvaksymatPyynnot;
    }

    public static function findAllFreeForAllDoctors() {
        $query = DB::connection()->prepare('SELECT * FROM Hoitopyynto WHERE laakari_id IS NULL');
        $query->execute();
        $rows = $query->fetchAll();
        $vapaatPyynnot = array();
        foreach ($rows as $row) {
            $vapaatPyynnot[] = new Hoitopyynto(array(
                'id' => $row['id'],
                'potilas_id' => $row['potilas_id'],
                'laakari_id' => $row['laakari_id'],
                'luontipvm' => $row['luontipvm'],
                'kayntipvm' => $row['kayntipvm'],
                'oireet' => $row['oireet'],
                'raportti' => $row['raportti'],
                'ohje' => $row['ohje']
            ));
        }
        return $vapaatPyynnot;
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
                'raportti' => $row['raportti'],
                'ohje' => $row['ohje'],
            ));
            return $pyynto;
        }
        return null;
    }

    public function saveNewRequest() {
        $query = DB::connection()->prepare('INSERT INTO Hoitopyynto (potilas_id, laakari_id, luontipvm, kayntipvm, oireet, raportti) VALUES (:potilas_id, :laakari_id, :luontipvm, :kayntipvm, :oireet, :raportti) RETURNING id');
        $query->execute(array('potilas_id' => $this->potilas_id, 'laakari_id' => $this->laakari_id, 'luontipvm' => $this->luontipvm, 'kayntipvm' => $this->kayntipvm, 'oireet' => $this->oireet, 'raportti' => $this->raportti));

        //Ei ole automaattista primary keyn lisäystä...?
        $row = $query->fetch();
        $this->id = $row['id'];
    }

    public function updateSymptoms() {
        $query = DB::connection()->prepare('UPDATE Hoitopyynto SET oireet=:oireet WHERE id=:id');
        $query->execute(array('id' => $this->id, 'oireet' => $this->oireet));
    }

    public function updateReport() {
        $query = DB::connection()->prepare('UPDATE Hoitopyynto SET raportti=:raportti WHERE id=:id');
        $query->execute(array('id' => $this->id, 'raportti' => $this->raportti));
    }

    public function updateInstruction() {
        $query = DB::connection()->prepare('UPDATE Hoitopyynto SET ohje=:ohje WHERE id=:id');
        $query->execute(array('id' => $this->id, 'ohje' => $this->ohje));
    }

    public function assignDoctor() {
        $query = DB::connection()->prepare('UPDATE Hoitopyynto SET laakari_id=:laakari_id, kayntipvm=:kayntipvm WHERE id=:id');
        $query->execute(array('id' => $this->id, 'laakari_id' => $this->laakari_id, 'kayntipvm' => date("d-m-Y")));
    }

    public function destroy() {
        $query = DB::connection()->prepare('DELETE FROM Hoitopyynto WHERE id=:id');
        $query->execute(array('id' => $this->id));
    }

}
