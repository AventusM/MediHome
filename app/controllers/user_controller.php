<?php

class UserController extends BaseController {

    public static function login() {
        View::make('user/login.html');
    }

    public static function doctorLogin() {
        View::make('laakari/login.html');
    }

    public static function logout() {
        $_SESSION['potilas'] = null;
        Redirect::to('/login', array('message' => 'Olet kirjautunut ulos'));
    }

    public static function handle_login() {
        $params = $_POST;
        $potilas = Potilas::authenticate($params['username'], $params['password']);

        if (!$potilas) {
            View::make('user/login.html');
        } else {
            $_SESSION['potilas'] = $potilas->id;
            UserController::get_potilas_logged_in();
            Redirect::to('/potilas');
        }
    }

    public static function handle_doctor_login() {
        $params = $_POST;
        $laakari = Laakari::authenticate($params['username'], $params['password']);

        if (!$laakari) {
            View::make('laakari/login.html');
        } else {
            $_SESSION['laakari'] = $laakari->id;
            UserController::get_doctor_logged_in();
            Redirect::to('/laakari');
        }
    }

}
