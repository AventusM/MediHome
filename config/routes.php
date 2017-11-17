<?php

// GET 
// GET

$routes->get('/hiekkalaatikko/', function() {
    HelloWorldController::sandbox();
});


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

$routes->post('/potilas/', function() {
    PotilasController::updateOrder();
});
