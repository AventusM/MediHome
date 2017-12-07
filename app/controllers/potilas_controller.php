<?php

class PotilasController extends BaseController {
    /*
     * Copy-pasten eliminointia
     */

    public static function getCurrentPatientID() {
        return $_SESSION['potilas'];
    }

    /*
     * Potilaalle näytettävä etusivu. Se sisältää potilaskohtaiset hoitopyynnöt sekä -ohjeet
     */

    public static function index() {
        $omatHoitopyynnot = Hoitopyynto::findAllForPatient(self::getCurrentPatientID());
        $potilas = Potilas::find(self::getCurrentPatientID());
//        $potilaanOhjeet = Hoitoohje::findAllForPatient(self::getCurrentPatientID());
        View::make('potilas/index.html', array('pyynnot' => $omatHoitopyynnot, 'petunimi' => $potilas->etunimi, 'psukunimi' => $potilas->sukunimi));
    }

    /*
     * Näkymä johon siirrytään, kun potilas painaa navigaatiopalkin linkkiä 'Pyydä kotikäyntiä'
     */

    public static function createOrder() {
        View::make('potilas/new.html');
    }

    /* Metodia muutettu 5. viikolla -> halutaan
     * varmistaa ettei päästä käsiksi toisten
     * hoitopyyntöihin tms.
     * 
     * Metodi vie erilliseen näkymään, jossa potilas voi muokata vielä
     * lääkärin hyväksymätöntä hoitopyyntöä.
     */

    public static function reviewOrder($id) {
        if (Hoitopyynto::find($id) != null) {
            $hoitopyynto = Hoitopyynto::find($id);
            $idMatch = Hoitopyynto::indexBoundsCheck(self::getCurrentPatientID(), $hoitopyynto->potilas_id);
            if ($idMatch) {
                View::make('potilas/edit.html', array('pyynto' => $hoitopyynto));
            }
        } else {
            //Paluu indeksiin toistaiseksi ainoa varma tie pois ikuisista rekursiopinoista...
            self::index();
        }
    }

    /*
     * Samantyyppinen kuin reviewOrder($id), mutta tässä potilas voi vain
     * lukea lääkärin luomat hoito-ohjeet.
     */

    public static function readInstructions($id) {
        if (Hoitopyynto::find($id) != null) {
            $hoitopyynto = Hoitopyynto::find($id);
            $idMatch = Hoitopyynto::indexBoundsCheck(self::getCurrentPatientID(), $hoitopyynto->potilas_id);
            if ($idMatch) {
                View::make('potilas/readinstructions.html', array('hoitopyynto' => $hoitopyynto));
            }
        } else {
            self::index();
        }
    }

    /*
     * Potilas voi tuhota sen hoitopyynnön, johon lääkäri ei ole vielä vastannut painamalla
     * "X" - painiketta halutussa hoitopyyntönäkymässä etusivulla
     */

    public static function destroyThisOrder($id) {
        $hoitopyynto = Hoitopyynto::find($id);
        View::make('potilas/destroy.html', array('pyynto' => $hoitopyynto));
    }

    /*
     * Talletettava osa funktiosta createOrder(), mistä ohjataan tähän funktioon,
     * jos potilas tekee hoitopyyntösuorituksen loppuun. Funktiossa luodaan uusi olio
     * sekä varmistetaan, ettei pyyntöä suoriteta tyhjällä tekstikentällä.
     */

    public static function store() {
        $params = $_POST;
        $pyynto = new Hoitopyynto(array(
            'potilas_id' => self::getCurrentPatientID(),
            'laakari_id' => null,
            'luontipvm' => date("d-m-Y"),
            'kayntipvm' => null,
            'oireet' => $params['oireet'],
            'raportti' => null,
            'ohje' => null
        ));
        $errors = $pyynto->validate_request($pyynto->oireet);
        if (count($errors) == 0) {
            $pyynto->saveNewRequest();
            Redirect::to('/potilas');
        } else {
            View::make('potilas/new.html', array('errors' => $errors));
        }
    }

    /*
     * Lähes store() - funktion kaltainen tapahtuma, kun potilas haluaa päivittää jo
     * olemassaolevaa, vielä hyväksymätöntä hoitopyyntöä.
     */

    public static function update($id) {
        $params = $_POST;
        $attributes = array(
            'id' => $id,
            'potilas_id' => self::getCurrentPatientID(),
            'laakari_id' => null,
            'luontipvm' => date("d-m-Y"),
            'kayntipvm' => null,
            'oireet' => $params['oireet'],
            'raportti' => null,
            'ohje' => null
        );
        $paivitettavaHoitopyynto = new Hoitopyynto($attributes);
        $errors = $paivitettavaHoitopyynto->validate_request($paivitettavaHoitopyynto->oireet);
        if (count($errors) == 0) {
            $paivitettavaHoitopyynto->updateSymptoms();
            Redirect::to('/potilas');
        } else {
            //Joudutaan hakemaan hoitopyyntö erikseen -> muuten placeholderit tms. elementtien sisällöt katoavat kokonaan
            $hoitopyynto = Hoitopyynto::find($paivitettavaHoitopyynto->id);
            View::make('potilas/edit.html', array('errors' => $errors, 'pyynto' => $hoitopyynto));
        }
    }

    /*
     * Hoitopyynnön poiston varmistusnäkymässä suoritettava funktio
     */

    public static function destroy($id) {
        $poistettavaHoitopyynto = new Hoitopyynto(array('id' => $id));
        $poistettavaHoitopyynto->destroy();
        Redirect::to('/potilas');
    }

}
