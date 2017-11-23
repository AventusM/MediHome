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

    public static function check_logged_in() {
        // Toteuta kirjautumisen tarkistus tähän.
        // Jos käyttäjä ei ole kirjautunut sisään, ohjaa hänet toiselle sivulle (esim. kirjautumissivulle).
    }

}
