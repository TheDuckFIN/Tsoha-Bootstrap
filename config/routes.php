<?php

  $routes->get('/', function() {
    BoardController::index();
  });

  $routes->get('/board', function() {
    BoardController::index();
  });

  $routes->get('/board/:id', function($id) {
    BoardController::show($id);
  });

  $routes->get('/thread', function() {
    ThreadController::index();  
  });

  $routes->get('/thread/:id', function($id) {
    ThreadController::show($id);  
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

  $routes->get('/thread/1/newpost', function() {
    HelloWorldController::thread_newpost();
  });

  $routes->get('/editpost/1', function() {
    HelloWorldController::thread_editpost();
  });

  $routes->get('/board/1/newthread', function() {
    HelloWorldController::newthread();
  });

  $routes->get('/hiekkalaatikko', function() {
    HelloWorldController::sandbox();
  });


