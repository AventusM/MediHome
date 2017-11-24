<?php

class PotilasController extends BaseController {

    public static function getCurrentPatientID() {
        return $_SESSION['potilas'];
    }

    public static function index() {
        $omatHoitopyynnot = Hoitopyynto::findAllForPatient(self::getCurrentPatientID());
        $potilas = Potilas::find(self::getCurrentPatientID());
        View::make('potilas/index.html', array('pyynnot' => $omatHoitopyynnot, 'etunimi' => $potilas->etunimi, 'sukunimi' => $potilas->sukunimi));
    }

    public static function createOrder() {
        View::make('potilas/new.html');
    }

    public static function viewOrder($id) {
        $hoitopyynto = Hoitopyynto::find($id);
        View::make('potilas/edit.html', array('pyynto' => $hoitopyynto));
    }

    public static function destroyThisOrder($id) {
        $hoitopyynto = Hoitopyynto::find($id);
        View::make('potilas/destroy.html', array('pyynto' => $hoitopyynto));
    }

    public static function store() {
        $params = $_POST;
        $pyynto = new Hoitopyynto(array(
            'potilas_id' => self::getCurrentPatientID(),
            'laakari_id' => null,
            'luontipvm' => date("Y-m-d"),
            'kayntipvm' => null,
            'oireet' => $params['oireet'],
            'raportti' => null
        ));
        $errors = $pyynto->validate_request($pyynto->oireet);
        if (count($errors) == 0) {
            $pyynto->save();
            Redirect::to('/potilas');
        } else {
            View::make('potilas/new.html', array('errors' => $errors));
        }
    }

    public static function update($id) {
        $params = $_POST;
        $attributes = array(
            'id' => $id,
            'potilas_id' => self::getCurrentPatientID(),
            'laakari_id' => null,
            'luontipvm' => date("Y-m-d"),
            'kayntipvm' => null,
            'oireet' => $params['oireet'],
            'raportti' => null
        );
        $paivitettavaHoitopyynto = new Hoitopyynto($attributes);
        $errors = $paivitettavaHoitopyynto->validate_request($paivitettavaHoitopyynto->oireet);
        if (count($errors) == 0) {
            $paivitettavaHoitopyynto->update();
            Redirect::to('/potilas');
        } else {
            //Joudutaan hakemaan hoitopyyntö erikseen -> muuten placeholderit tms. elementtien sisällöt katoavat kokonaan
            $hoitopyynto = Hoitopyynto::find($paivitettavaHoitopyynto->id);
            View::make('potilas/edit.html', array('errors' => $errors, 'pyynto' => $hoitopyynto));
        }
    }

    public static function destroy($id) {
        $poistettavaHoitopyynto = new Hoitopyynto(array('id' => $id));
        $poistettavaHoitopyynto->destroy();
        Redirect::to('/potilas');
    }

}
