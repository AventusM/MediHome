<?php

class Laakaricontroller extends BaseController {

    public static function getCurrentDoctorID() {
        return $_SESSION['laakari'];
    }

    public static function index() {
        $vapaatHoitopyynnot = Hoitopyynto::findAllFreeForAllDoctors();
        $laakari = Laakari::find(self::getCurrentDoctorID());
        $hyvaksytytHoitopyynnot = Hoitopyynto::findAllAccepterForDoctor(self::getCurrentDoctorID());
        //Hoitoraportit / -ohjeet
        View::make('laakari/index.html', array('pyynnot' => $vapaatHoitopyynnot, 'hyvaksytytHoitopyynnot' => $hyvaksytytHoitopyynnot, 'etunimi' => $laakari->etunimi, 'sukunimi' => $laakari->sukunimi));
    }

    public static function acceptRequest() {
        $params = $_POST;
        $hyvaksyttyHoitopyynto = Hoitopyynto::find($params['pyynto_id']);
        $hyvaksyttyHoitopyynto->laakari_id = self::getCurrentDoctorID();
        $hyvaksyttyHoitopyynto->assignDoctor();
        Redirect::to("/laakari");
    }

    //Ohje perustuu olemassaolevaan hoitopyyntoon / raporttiin
    public static function createInstructions($id) {
        $muokattavaHoitopyynto = Hoitopyynto::find($id);
        View::make('laakari/editinstructions.html', array('pyynto' => $muokattavaHoitopyynto));
    }

    public static function storeNewInstructionsToAcceptedRequest() {
        $params = $_POST;
        $ohje = new Hoitoohje(array(
            //Selvitä, miten potilas id saadaan selville tässä!
            //Varmaankin hidden type taaskin . . .
            'potilas_id' => $params['potilas_id'],
            'laakari_id' => self::getCurrentDoctorID(),
            'luontipvm' => date('Y-m-d'),
            'muokkauspvm' => null,
            'ohje' => $params['ohje']
        ));
        //Muista validoida tyhjä suoritus myöhemmin ...
        $ohje->saveNewInstructions();
        Redirect::to('/laakari');
    }

}
