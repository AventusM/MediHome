<?php

class PotilasController extends BaseController {

    public static function index() {
        $potilasID = $_SESSION['potilas'];
        $omatHoitopyynnot = Hoitopyynto::allForPatient($potilasID); // all - metodi tarvitsee parametriksi $id:n?
        View::make('potilas/index.html', array('pyynnot' => $omatHoitopyynnot));
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
        $potilasID = $_SESSION['potilas'];
        $params = $_POST;
        $pyynto = new Hoitopyynto(array(
            'potilas_id' => $potilasID,
            'laakari_id' => null,
            'luontipvm' => date("Y-m-d"),
            'kayntipvm' => null,
            'oireet' => $params['oireet'],
            'raportti' => null
        ));

        $pyynto->save();
        Redirect::to('/potilas');
    }

    public static function update($id) {
        $potilasID = $_SESSION['potilas'];
        $params = $_POST;
        $attributes = array(
            'id' => $id,
            'potilas_id' => $potilasID,
            'laakari_id' => null,
            'luontipvm' => date("Y-m-d"),
            'kayntipvm' => null,
            'oireet' => $params['oireet'],
            'raportti' => null
        );
        $paivitettavaHoitopyynto = new Hoitopyynto($attributes);
        $paivitettavaHoitopyynto->update();
        Redirect::to('/potilas');
    }

    public static function destroy($id) {
        $poistettavaHoitopyynto = new Hoitopyynto(array('id' => $id));
        $poistettavaHoitopyynto->destroy();
        Redirect::to('/potilas');
    }

}
