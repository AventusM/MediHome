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

// POST
// POST

$routes->post('/potilas/new', function() {
    PotilasController::store();
});
