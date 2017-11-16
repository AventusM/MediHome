<?php

class PotilasController extends BaseController {

    public static function index() {
        //TODO - toteutettava findAllForPatient($id) - tyylinen metodi. Allaoleva all() tms. menee lääkäreille
        $omatHoitopyynnot = Hoitopyynto::all(); // all - metodi tarvitsee parametriksi $id:n
        View::make('potilas/index.html', array('pyynnot' => $omatHoitopyynnot));
        //TODO - lääkärin hoito-ohjeiden listaaminen . . .
    }

//    public static function show($id) {
//        $haettuHoitoPyynto = Hoitopyynto::find($id);
//        View::make('potilas/edit.html', array('pyynnot' => $haettuHoitoPyynto));
//    }

//    4. viikon juttuja 
//    public static function reCreateOrder() {
//        // Tarkoitus, että etusivun päivitä-nappi antaa post-kutsussa olemassaolevan hoitopyynnon pääavaimen tänne käyttöön
//        $params = $_POST;
//        $id = $params['id'];
//        $muutettavaHoitopyynto = Hoitopyynto::find($id);
//        // Yksialkoinen taulu -> TODO parempi toteutustapa jos tämä ei toimi ollenkaan . . . ajanpuute is real -.-
//        View::make('potilas/edit.html', array('pyynnot' => $muutettavaHoitopyynto));
//    }

    public static function createOrder() {
        View::make('potilas/new.html');
    }

//    4. viikon juttuja
    public static function update() {
        //Hyvin samanlainen kuin store() -> pyyntö päivitetään
    }

    public static function store() {
        $params = $_POST;
        $pyynto = new Hoitopyynto(array(
            'potilas_id' => null,
            'laakari_id' => null,
            'luontipvm' => date("Y-m-d"),
            'kayntipvm' => null,
            'oireet' => $params['oireet'],
            'raportti' => null
        ));

        $pyynto->save();
        Redirect::to('/potilas');
    }

}
