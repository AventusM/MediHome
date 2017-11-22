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

$routes->get('/potilas/hoitopyynto/:id', function($id) {
    PotilasController::viewOrder($id);
});

$routes->get('/potilas/hoitopyynto/:id/destroy', function($id) {
    PotilasController::destroyThisOrder($id);
});

// POST
// POST

$routes->post('/potilas/new', function() {
    PotilasController::store();
});

$routes->post('/potilas/hoitopyynto/:id', function($id) {
    PotilasController::update($id);
});

$routes->post('/potilas/hoitopyynto/:id/destroy', function($id) {
    PotilasController::destroy($id);
});
