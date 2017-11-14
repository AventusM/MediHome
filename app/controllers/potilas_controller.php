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
        Redirect::to('/potilas/index.html');
    }

}
