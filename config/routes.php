<?php

//$routes->get('/', function() {
//    HelloWorldController::index();
//});

$routes->get('/hiekkalaatikko', function() {
    HelloWorldController::sandbox();
});

//$routes->get('/login', function () {
//    HelloWorldController::login();
//});
//
//$routes->get('/register', function() {
//    HelloWorldController::register();
//});

$routes->get('/potilas', function() {
    PotilasController::index();
});

$routes->get('/potilas/new', function() {
    PotilasController::createOrder();
});


//$routes->get('/laakari', function() {
//    HelloWorldController::doctorIndex();
//});
//
//$routes->get('/hoitoohje/50', function() {
//    HelloWorldController::getInstruction();
//});
// POST

$routes->post('potilas/new', function() {
    PotilasController::store();
});
