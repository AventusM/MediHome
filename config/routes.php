<?php

$routes->get('/', function() {
    HelloWorldController::index();
});

$routes->get('/hiekkalaatikko', function() {
    HelloWorldController::sandbox();
});

$routes->get('/login', function () {
    HelloWorldController::login();
});

$routes->get('/potilaanSivu', function() {
    HelloWorldController::patientIndex();
});

$routes->get('/potilaanSivu/pyynto', function() {
    HelloWorldController::patientHelpRequest();
});
