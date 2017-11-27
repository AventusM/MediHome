<?php

class Laakaricontroller extends BaseController {

    public static function getCurrentDoctorID() {
        return $_SESSION['laakari'];
    }

    public static function index() {
        $vapaatHoitopyynnot = Hoitopyynto::findAllFreeForAllDoctors();
        $laakari = Laakari::find(self::getCurrentDoctorID());
        //Hoito-ohjeet
        View::make('laakari/index.html', array('pyynnot' => $vapaatHoitopyynnot, 'etunimi' => $laakari->etunimi, 'sukunimi' => $laakari->sukunimi));
    }

}
