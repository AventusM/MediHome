<?php

//require 'app/models/Hoitopyynto.php';

class HelloWorldController extends BaseController {

    public static function index() {
        // make-metodi renderöi app/views-kansiossa sijaitsevia tiedostoja
        View::make('suunnitelmat/login.html');
    }

    public static function sandbox() {
        $pyynto = new Hoitopyynto(array(
            'id' => 20,
            'potilas_id' => 1,
            'laakari_id' => 1,
            'luontipvm' => null,
            'kayntipvm' => null,
            'oireet' => 'ASD',
            'rapotti' => null
        ));
        $errors = $pyynto->validate_request($pyynto->oireet);
        Kint::dump($pyynto);
        Kint::dump($errors);
    }

    public static function login() {
        View::make('suunnitelmat/login.html');
    }

    public static function register() {
        View::make('suunnitelmat/register.html');
    }

    public static function patientIndex() {
        View::make('suunnitelmat/potilaanetusivu.html');
    }

    public static function patientHelpRequest() {
        View::make('suunnitelmat/hoitopyynto.html');
    }

    public static function doctorIndex() {
        View::make('suunnitelmat/laakarinetusivu.html');
    }

    public static function doctorReport() {
        View::make('suunnitelmat/laakarinraportti');
    }

    public static function getInstruction() {
        View::make('suunnitelmat/hoidonohjeistus.html');
    }

}
