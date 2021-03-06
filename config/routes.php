<?php

  $routes->get('/', function() {
    BoardController::index();
  });

  $routes->get('/board/', function() {
    BoardController::index();
  });

  $routes->post('/board/delete/:id', function($id) {
    BoardController::delete($id);
  });

  $routes->get('/board/:id', function($id) {
    BoardController::show($id);
  });

  $routes->get('/thread/new/:id', function($id) {
    ThreadController::create($id);
  });

  $routes->post('/thread/new/', function() {
    ThreadController::store();
  });

  $routes->post('/thread/delete/:id', function($id) {
    ThreadController::delete($id);
  });

  $routes->post('/thread/toggle_locked/:id', function($id) {
    ThreadController::toggle_locked($id);
  });

  $routes->get('/thread/:id', function($id) {
    ThreadController::show($id);  
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

  $routes->post('/post/delete/:id', function($id) {
    PostController::delete($id);
  });

  $routes->get('/login/', function() {
    UserController::login();
  });

  $routes->post('/login/', function() {
    UserController::handle_login();
  });

  $routes->get('/register/', function() {
    UserController::register();
  });

  $routes->post('/register/', function() {
    UserController::handle_register();
  });

  $routes->get('/logout/', function() {
    UserController::logout();
  });

  $routes->get('/user/', function() {
    UserController::index();
  });

  $routes->post('/user/delete/:id', function($id) {
    UserController::delete($id);
  });

  $routes->get('/user/:id/', function($id) {
    UserController::show($id);
  });

  $routes->get('/user/:id/settings/', function($id) {
    UserController::edit($id);
  });

  $routes->post('/user/:id/settings/', function($id) {
    UserController::update();
  });

  $routes->get('/users/', function() {
    UserController::index();
  });

  $routes->post('/usergroups/delete/:id', function($id) {
    UsergroupController::delete($id);
  });

  $routes->get('/settings/', function() {
    SettingsController::index();
  });

  $routes->post('/settings/', function() {
    SettingsController::update();
  });

  $routes->get('/settings/usergroups/', function() {
    SettingsController::usergroups_index();
  });

  $routes->get('/settings/usergroups/new/', function() {
    UsergroupController::create();
  });

  $routes->post('/settings/usergroups/new/', function() {
    UsergroupController::save();
  });

  $routes->get('/settings/usergroups/edit/:id', function($id) {
    UsergroupController::edit($id);
  });

  $routes->post('/settings/usergroups/edit/:id', function($id) {
    UsergroupController::update();
  });

  $routes->get('/settings/users/', function() {
    SettingsController::users_index();
  });

  $routes->get('/settings/arrangement/', function() {
    SettingsController::arrangement_index();
  });

  $routes->post('/category/delete/:id', function($id) {
    CategoryController::delete($id);
  });

  $routes->post('/settings/arrangement/category/new/', function() {
    CategoryController::save();
  });

  $routes->post('/settings/arrangement/category/edit/', function() {
    CategoryController::update();
  });

  $routes->get('/settings/arrangement/board/new/:id', function($id) {
    BoardController::create($id);
  });

  $routes->post('/settings/arrangement/board/new/', function() {
    BoardController::save();
  });

  $routes->post('/settings/arrangement/board/edit/:id', function($id) {
    BoardController::update();
  });

  $routes->get('/settings/arrangement/board/edit/:id', function($id) {
    BoardController::edit($id);
  });

  $routes->get('/achievements/', function() {
    AchievementController::index();
  });

  $routes->get('/achievements/:id', function($id) {
    AchievementController::user($id);
  });

  $routes->get('/edits/:id', function($id) {
    EditController::show($id);
  });