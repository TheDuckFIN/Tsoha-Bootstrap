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

  $routes->post('/thread/new/', function() {
    ThreadController::store();
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

  $routes->post('/post/edit/', function() {
    PostController::update();
  });

  $routes->get('/post/edit/:id', function($id) {
    PostController::edit($id);
  });  

  $routes->get('/post/new/', function() {
    PostController::index();
  });

  $routes->post('/post/new/', function() {
    PostController::store();
  });

  $routes->get('/post/new/:id', function($id) {
    PostController::create($id);
  });  

  $routes->get('/post/delete/', function() {
    PostController::index();
  });

  $routes->get('/post/delete/:id', function($id) {
    PostController::delete($id);
  });

  $routes->get('/login/', function() {
    UserController::login();
  });

  $routes->post('/login/', function() {
    UserController::handle_login();
  });

  $routes->get('/register', function() {
    UserController::register();
  });

  $routes->post('/register', function() {
    UserController::handle_register();
  });

  $routes->get('/logout/', function() {
    UserController::logout();
  });

  $routes->get('/profile/', function() {
    UserController::index();
  });

  $routes->get('/profile/:id', function($id) {
    UserController::show($id);
  });