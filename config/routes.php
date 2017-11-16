<?php

//$routes->get('/', function() {
//    HelloWorldController::index();
//});

$routes->get('/hiekkalaatikko/', function() {
    HelloWorldController::sandbox();
});

//$routes->get('/login', function () {
//    HelloWorldController::login();
//});
//
//$routes->get('/register', function() {
//    HelloWorldController::register();
//});


$routes->get('/potilas/', function() {
    PotilasController::index();
});

$routes->get('/potilas/new/', function() {
    PotilasController::createOrder();
});

//$routes->get('/potilas/hoitopyynto/:id', function($id) {
//    PotilasController::show($id);
//});


//$routes->get('/potilas/edit/', function() {
//    PotilasController::reCreateOrder();
//});
//$routes->get('/laakari/', function() {
//    Laakaricontroller::index();
//});
// POST
// POST

$routes->post('/potilas/new', function() {
    PotilasController::store();
});

//$routes->post('/potilas/edit', function() {
//    PotilasController::update();
//});
