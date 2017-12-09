<?php

class UserController extends BaseController {
    /*
     * Tyypilliselle käyttäjälle näytettävä kirjautumisnäkymä
     */

    public static function login() {
        View::make('user/login.html');
    }

    /*
     * Uudelle käyttäjälle näyttävä rekisteröitysnäkymä
     */

    public static function register() {
        View::make('user/register.html');
    }

    /*
     * Lääkärille näytettävä kirjautumisnäkymä
     */

    public static function doctorLogin() {
        View::make('laakari/login.html');
    }

    /*
     * Käyttäjän rekisteröitymisen validointia
     */

    public static function handle_register() {
        $params = $_POST;
        $uusiPotilas = new Potilas(array(
            'etunimi' => $params['etunimi'],
            'sukunimi' => $params['sukunimi'],
            'hetu' => $params['hetu'],
            'username' => $params['username'],
            'pass' => $params['password']
        ));
        $pwError = $uusiPotilas->validate_password($uusiPotilas->pass, $params['passwordcopy']);
        $userError = $uusiPotilas->validate_username($uusiPotilas->username);
        if (count($pwError) == 0 && count($userError) == 0) {
            $uusiPotilas->saveNewPatient();
            Redirect::to('/login', array('success' => 'Rekisteröityminen onnistui!'));
        } else {
            $errors = array_merge($pwError, $userError);
            Redirect::to('/login', array('errors' => $errors));
        }
    }

    /*
     * Käyttäjän toimesta suoritettava uloskirjautuminen navigaatiopalkin 'kirjaudu ulos' 
     * linkkiä painamalla.
     */

    public static function logout() {
        $_SESSION['potilas'] = null;
        Redirect::to('/login', array('message' => 'Olet kirjautunut ulos'));
    }

    /*
     * Uloskirjautumisominaisuus lääkärille
     */

    public static function doctorLogout() {
        $_SESSION['laakari'] = null;
        Redirect::to('/login/d', array('message' => 'Huomenna jatketaan!'));
    }

    /*
     * Todennetaan käyttäjän antaneen oikeat tunnustiedot järjestelmään
     */

    public static function handle_login() {
        $params = $_POST;
        $potilas = Potilas::authenticateLogin($params['username'], $params['password']);

        if (!$potilas) {
            View::make('user/login.html', array('message' => 'Väärä käyttäjätunnus tai salasana'));
        } else {
            $_SESSION['potilas'] = $potilas->id;
            UserController::get_potilas_logged_in();
            Redirect::to('/potilas');
        }
    }

    /*
     * Kuin ylläoleva, mutta lääkärille
     */

    public static function handle_doctor_login() {
        $params = $_POST;
        $laakari = Laakari::authenticateLogin($params['username'], $params['password']);

        if (!$laakari) {
            View::make('laakari/login.html');
        } else {
            $_SESSION['laakari'] = $laakari->id;
            UserController::get_doctor_logged_in();
            Redirect::to('/laakari');
        }
    }

}
