<?php

$routes->get('/', function() {
    HelloWorldController::index();
});

//$routes->get('/hiekkalaatikko', function() {
//    HelloWorldController::sandbox();
//});

$routes->get('/login', function () {
    HelloWorldController::login();
});

$routes->get('/register', function() {
    HelloWorldController::register();
});

$routes->get('/potilas/1', function() {
    HelloWorldController::patientIndex();
});

$routes->get('/potilas/luohoito', function() {
    HelloWorldController::patientHelpRequest();
});

$routes->get('/laakari/1', function() {
    HelloWorldController::doctorIndex();
});

$routes->get('/hoidonohjeistus/50', function() {
    HelloWorldController::getInstruction();
});
