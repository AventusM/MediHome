<?php

class Potilas extends BaseModel {

    public $id, $etunimi, $sukunimi, $hetu, $username, $pass;

    public function __construct($attributes) {
        parent::__construct($attributes);
    }

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
