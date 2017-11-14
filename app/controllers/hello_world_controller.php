<?php

//require 'app/models/Hoitopyynto.php';

class HelloWorldController extends BaseController {

    public static function index() {
        // make-metodi renderöi app/views-kansiossa sijaitsevia tiedostoja
        View::make('suunnitelmat/login.html');
    }

    public static function sandbox() {
        $antoninPyynto = Hoitopyynto::find(1);
        $kaikkiPyynnot = Hoitopyynto::all();
        
        Kint::dump($antoninPyynto);
        Kint::dump($kaikkiPyynnot);
                
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
