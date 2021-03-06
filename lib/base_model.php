<?php

class BaseModel {

    // "protected"-attribuutti on käytössä vain luokan ja sen perivien luokkien sisällä
    protected $validators;

    public function __construct($attributes = null) {
        // Käydään assosiaatiolistan avaimet läpi
        foreach ($attributes as $attribute => $value) {
            // Jos avaimen niminen attribuutti on olemassa...
            if (property_exists($this, $attribute)) {
                // ... lisätään avaimen nimiseen attribuuttin siihen liittyvä arvo
                $this->{$attribute} = $value;
            }
        }
    }

    public function validate_request($oireet) {
        $errors = array();
        if ($oireet == '' || $oireet == null) {
            $errors[] = 'Älä jätä tekstikenttää tyhjäksi!';
        }
        return $errors;
    }

    //Käyttäjän validointi (duplikaatit yms..)
    public function validate_username($userName) {
        $errors = array();
        if ($userName == '' || $userName == null) {
            $errors[] = 'Nimi ei saa olla tyhjä!';
        }
        $foundUser = Potilas::findByUser($userName);
        if ($foundUser) {
            $errors[] = 'Käyttäjänimi on jo käytössä!';
        }
        return $errors;
    }

    public function validate_password($pwKentta1, $pwKentta2) {
        $errors = array();
        if ($pwKentta1 != $pwKentta2) {
            $errors[] = 'Salasanat eivät täsmää, yritä uudelleen!';
        }
        return $errors;
    }

//    public function errors() {
//        // Lisätään $errors muuttujaan kaikki virheilmoitukset taulukkona
//        $errors = array();
//
//        foreach ($this->validators as $validator) {
//            // Kutsu validointimetodia tässä ja lisää sen palauttamat virheet errors-taulukkoon
//        }
//
//        return $errors;
//    }

}
