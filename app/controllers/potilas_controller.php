<?php

class PotilasController extends BaseController {

    public static function index() {
        $hoitopyynnot = Hoitopyynto::all();
        View::make('potilas/index.html', array('pyynnot' => $hoitopyynnot));
        //TODO - lääkärin hoito-ohjeiden listaaminen . . .
    }

    public static function createOrder() {
        View::make('potilas/new.html');
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

}
