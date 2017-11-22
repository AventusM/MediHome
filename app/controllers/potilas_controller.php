<?php

class PotilasController extends BaseController {
    /*
     * HOITOPYYNNÖT TOISTAISEKSI JÄRJESTETTY ID:N MUKAAN
     */

    public static function index() {
        //TODO - toteutettava findAllForPatient($id) - tyylinen metodi. Allaoleva all() tms. menee lääkäreille
        $omatHoitopyynnot = Hoitopyynto::all(); // all - metodi tarvitsee parametriksi $id:n
        View::make('potilas/index.html', array('pyynnot' => $omatHoitopyynnot));
        //TODO - lääkärin hoito-ohjeiden listaaminen . . .
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
            'potilas_id' => null,
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
        $params = $_POST;
        $attributes = array(
            'id' => $id,
            'potilas_id' => null,
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
