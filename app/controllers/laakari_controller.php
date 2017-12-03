<?php

class Laakaricontroller extends BaseController {
    /*
     * Copy-pasten eliminointia
     */

    public static function getCurrentDoctorID() {
        return $_SESSION['laakari'];
    }

    /*
     * Lääkärin etusivun toteuttava funktio
     * Funktio listaa lääkärin hyväksymät hoitopyynnöt sekä kaikki hyväksymättömät
     * lisäksi näytetään lääkärin omat raportit suoritetuista kotikäynneistä
     */

    public static function index() {
        $vapaatHoitopyynnot = Hoitopyynto::findAllFreeForAllDoctors();
        $laakari = Laakari::find(self::getCurrentDoctorID());
        $hyvaksytytHoitopyynnot = Hoitopyynto::findAllAccepterForDoctor(self::getCurrentDoctorID());
        //Hoitoraportit / -ohjeet
        View::make('laakari/index.html', array('pyynnot' => $vapaatHoitopyynnot, 'hyvaksytytHoitopyynnot' => $hyvaksytytHoitopyynnot, 'etunimi' => $laakari->etunimi, 'sukunimi' => $laakari->sukunimi));
    }

    /*
     * Funktio suoritetaan, kun lääkäri painaa 'suorita' nappia kaikille lääkäreille vapaissa hoitopyynnöissä
     */

    public static function acceptRequest() {
        $params = $_POST;
        $hyvaksyttyHoitopyynto = Hoitopyynto::find($params['pyynto_id']);
        $hyvaksyttyHoitopyynto->laakari_id = self::getCurrentDoctorID();
        $hyvaksyttyHoitopyynto->assignDoctor();
        Redirect::to("/laakari");
    }

    /*
     * Lääkärille näytettävä sivu, kun hän haluaa luoda hoito-ohjeen jo olemassaolevasta
     * hoitopyynnöstä, jonka hän itse on hyväksynyt
     */

    public static function createInstructions($id) {
        $muokattavaHoitopyynto = Hoitopyynto::find($id);
        View::make('laakari/editinstructions.html', array('pyynto' => $muokattavaHoitopyynto));
    }

    /*
     * Funktio luo uuden hoito-ohjeen perustuen createInstructions($id) - metodin sekä täytetyn tekstikentän (ohje) tietoihin
     */

//    public static function storeNewInstructionsToAcceptedRequest() {
//        $params = $_POST;
//        $ohje = new Hoitoohje(array(
//            'potilas_id' => $params['potilas_id'],
//            'laakari_id' => self::getCurrentDoctorID(),
//            'luontipvm' => date('Y-m-d'),
//            'muokkauspvm' => null,
//            'ohje' => $params['ohje']
//        ));
//        //Muista validoida tyhjä suoritus myöhemmin ...
//        $ohje->saveNewInstructions();
//        Redirect::to('/laakari');
//    }

    /*
     * Funktio päivittää Hoitopyynto-taulua lisäämällä tekstiä Raportti-kenttään
     */

    public static function reviewReport($id) {
        if (Hoitopyynto::find($id) != null) {
            $hoitopyynto = Hoitopyynto::find($id);
            $idMatch = Hoitopyynto::indexBoundsCheck(self::getCurrentDoctorID(), $hoitopyynto->laakari_id);
            if ($idMatch) {
                View::make('laakari/editOrder.html', array('pyynto' => $hoitopyynto));
            }
        } else {
            //Paluu indeksiin toistaiseksi ainoa varma tie pois ikuisista rekursiopinoista...
            self::index();
        }
    }

    /*
     * reviewReport - metodin POST - osa
     */

    public static function updateReport() {
        $params = $_POST;
        $hoitopyynto = Hoitopyynto::find($params['pyynto_id']);
        $hoitopyynto->raportti = $params['raportti'];
        $hoitopyynto->updateReport();
        Redirect::to('/laakari');
    }

}
