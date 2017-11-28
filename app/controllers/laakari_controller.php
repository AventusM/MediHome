<?php

class Laakaricontroller extends BaseController {

    public static function getCurrentDoctorID() {
        return $_SESSION['laakari'];
    }

    public static function index() {
        $vapaatHoitopyynnot = Hoitopyynto::findAllFreeForAllDoctors();
        $laakari = Laakari::find(self::getCurrentDoctorID());
        //Hoito-ohjeet
        //omatHoitoRaportit = Hoitoohje::findAllForSelf(); . . . jotain tuon tapaista
        View::make('laakari/index.html', array('pyynnot' => $vapaatHoitopyynnot, 'etunimi' => $laakari->etunimi, 'sukunimi' => $laakari->sukunimi));
    }

    public static function acceptRequest() {
        $params = $_POST;
        $hyvaksyttyHoitopyynto = Hoitopyynto::find($params['pyynto_id']);
        $hyvaksyttyHoitopyynto->laakari_id = self::getCurrentDoctorID();
        $hyvaksyttyHoitopyynto->assignDoctor();
        Redirect::to("/laakari");
    }

}
