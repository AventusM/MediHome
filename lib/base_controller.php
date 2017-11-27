<?php

class BaseController {

    public static function get_potilas_logged_in() {
        if (isset($_SESSION['potilas'])) {
            $potilas_id = $_SESSION['potilas'];
            $potilas = Potilas::find($potilas_id);
            return $potilas;
        }
        return null;
    }

    public static function get_doctor_logged_in() {
        if (isset($_SESSION['laakari'])) {
            $laakari_id = $_SESSION['laakari'];
            $laakari = Laakari::find($laakari_id);
            return $laakari;
        }
        return null;
    }

    public static function check_potilas_logged_in() {
        if (!isset($_SESSION['potilas'])) {
            Redirect::to('/login', array('message' => 'Kirjaudu ensin sisään!'));
        }
    }

    public static function check_doctor_logged_in() {
        if (!isset($_SESSION['laakari'])) {
            Redirect::to('/login/d', array('message' => 'Kirjaudu ensin sisään'));
        }
    }

}
