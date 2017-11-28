<?php

// GET 
// GET

function check_potilas_logged_in() {
    BaseController::check_potilas_logged_in();
}

$routes->get('/hiekkalaatikko/', function() {
    HelloWorldController::sandbox();
});

//Potilas
$routes->get('/', function() {
    UserController::login();
});

$routes->get('/potilas/', 'check_potilas_logged_in', function() {
    PotilasController::index();
});

$routes->get('/potilas/new/', 'check_potilas_logged_in', function() {
    PotilasController::createOrder();
});

$routes->get('/potilas/hoitopyynto/:id', 'check_potilas_logged_in', function($id) {
    PotilasController::viewOrder($id);
});

$routes->get('/potilas/hoitopyynto/:id/destroy', 'check_potilas_logged_in', function($id) {
    PotilasController::destroyThisOrder($id);
});

$routes->get('/login/', function() {
    UserController::login();
});

//Lääkäri
$routes->get('/laakari/', function() {
    Laakaricontroller::index();
});

$routes->get('/login/d', function() {
    UserController::doctorLogin();
});

// POST
// POST
//Potilas
$routes->post('/potilas/new', function() {
    PotilasController::store();
});

$routes->post('/potilas/hoitopyynto/:id', function($id) {
    PotilasController::update($id);
});

$routes->post('/potilas/hoitopyynto/:id/destroy', function($id) {
    PotilasController::destroy($id);
});

$routes->post('/login', function() {
    UserController::handle_login();
});

$routes->post('/logout', function() {
    UserController::logout();
});

//Lääkäri
$routes->post('/login/d', function() {
    UserController::handle_doctor_login();
});

$routes->post('/laakari/accept', function() {
    Laakaricontroller::acceptRequest();
});
