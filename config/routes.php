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

$routes->get('/potilas/hoitopyynto/:id', 'check_potilas_logged_in', function($orderId) {
    PotilasController::reviewOrder($orderId);
});

$routes->get('/potilas/hoitopyynto/:id/destroy', 'check_potilas_logged_in', function($orderId) {
    PotilasController::destroyThisOrder($orderId);
});
$routes->get('/potilas/hoitopyynto/:id/read', 'check_potilas_logged_in', function($orderId) {
    PotilasController::readInstructions($orderId);
});

$routes->get('/login/', function() {
    UserController::login();
});

//Lääkäri

$routes->get('/login/d', function() {
    UserController::doctorLogin();
});
$routes->get('/laakari/', function() {
    Laakaricontroller::index();
});

$routes->get('/laakari/hoitopyynto/:id', function($id) {
    Laakaricontroller::createInstructions($id);
});

$routes->get('/laakari/hoitopyynto/raportti/:id', function($id) {
    Laakaricontroller::reviewReport($id);
});

// POST
// POST
//Potilas
$routes->post('/potilas/new', function() {
    PotilasController::store();
});

$routes->post('/potilas/hoitopyynto/:id', function($orderId) {
    PotilasController::update($orderId);
});

$routes->post('/potilas/hoitopyynto/:id/destroy', function($orderId) {
    PotilasController::destroy($orderId);
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

$routes->post('/laakari/updatereport', function() {
    Laakaricontroller::updateReport();
});

//$routes->post('/laakari/luohoitoohje', function() {
//    Laakaricontroller::storeNewInstructionsToAcceptedRequest();
//});
