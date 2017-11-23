<?php

class UserController extends BaseController {

    public static function login() {
        View::make('user/login.html');
    }

    public static function handle_login() {
        $params = $_POST;
        $potilas = Potilas::authenticate($params['username'], $params['password']);

        if (!$potilas) {
            View::make('user/login.html');
        } else {
            $_SESSION['potilas'] = $potilas->id;
            UserController::get_potilas_logged_in();
            Redirect::to('/potilas', array('potilasid' => $potilas->id, 'etunimi' => $potilas->etunimi, 'sukunimi' => $potilas->sukunimi));
        }
    }

}
