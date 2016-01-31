<?php

  $routes->get('/', function() {
    HelloWorldController::index();
  });

  $routes->get('/board/1', function() {
    HelloWorldController::board();
  });

  $routes->get('/login', function() {
    HelloWorldController::login();
  });

  $routes->get('/register', function() {
    HelloWorldController::register();
  });

  $routes->get('/profile/1', function() {
    HelloWorldController::profile();
  });

  $routes->get('/thread/1', function() {
    HelloWorldController::thread();
  });

  $routes->get('/thread/1/newpost', function() {
    HelloWorldController::thread_newpost();
  });

  $routes->get('/board/1/newthread', function() {
    HelloWorldController::newthread();
  });

  $routes->get('/hiekkalaatikko', function() {
    HelloWorldController::sandbox();
  });


