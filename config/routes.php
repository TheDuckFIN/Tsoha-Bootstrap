<?php

  $routes->get('/', function() {
    HelloWorldController::index();
  });

  $routes->get('/board/1', function() {
    HelloWorldController::board();
  });

  $routes->get('/thread/1', function() {
    HelloWorldController::thread();
  });

  $routes->get('/board/1/newthread', function() {
    HelloWorldController::newthread();
  });

  $routes->get('/hiekkalaatikko', function() {
    HelloWorldController::sandbox();
  });


