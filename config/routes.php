<?php

  $routes->get('/', function() {
    BoardController::index();
  });

  $routes->get('/board/', function() {
    BoardController::index();
  });

  $routes->get('/board/:id', function($id) {
    BoardController::show($id);
  });

  $routes->get('/thread/', function() {
    ThreadController::index();  
  });

  $routes->get('/thread/new/', function() {
    ThreadController::index();
  });

  $routes->get('/thread/new/:id', function($id) {
    ThreadController::create($id);
  });

  $routes->get('/thread/:id', function($id) {
    ThreadController::show($id);  
  });

  $routes->get('/post/', function() {
    PostController::index();
  });

  $routes->get('/post/edit/', function() {
    PostController::index();
  });

  $routes->get('/post/edit/:id', function($id) {
    PostController::edit($id);
  });  

  $routes->get('/post/new/', function() {
    PostController::index();
  });

  $routes->get('/post/new/:id', function($id) {
    PostController::create($id);
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

  $routes->get('/hiekkalaatikko', function() {
    HelloWorldController::sandbox();
  });


