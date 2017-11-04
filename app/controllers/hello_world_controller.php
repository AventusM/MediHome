<?php

class HelloWorldController extends BaseController {

    public static function index() {
        // make-metodi renderöi app/views-kansiossa sijaitsevia tiedostoja
        View::make('suunnitelmat/login.html');
    }

    public static function sandbox() {
        // Testaa koodiasi täällä
        View::make('login.html');
    }

    public static function login() {
        View::make('suunnitelmat/login.html');
    }

    public static function patientIndex() {
        View::make('suunnitelmat/potilaanSivu.html');
    }

    public static function patientHelpRequest() {
        View::make('suunnitelmat/hoitoPyynto.html');
    }

}
