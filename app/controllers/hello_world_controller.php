<?php

  class HelloWorldController extends BaseController{

    public static function index(){
      // make-metodi renderöi app/views-kansiossa sijaitsevia tiedostoja
   	  View::make('suunnitelmat/home.html');
    }

    public static function board(){
      View::make('suunnitelmat/board.html');
    }

    public static function newthread(){
      View::make('suunnitelmat/newthread.html');
    }

    public static function thread(){
      View::make('suunnitelmat/thread.html');
    }

    public static function profile(){
      View::make('suunnitelmat/profile.html');
    }

    public static function login(){
      View::make('suunnitelmat/login.html');
    }

    public static function register(){
      View::make('suunnitelmat/register.html');
    }

    public static function thread_newpost(){
      View::make('suunnitelmat/newpost.html');
    }

    public static function thread_editpost(){
      View::make('suunnitelmat/newpost.html');
    }

    public static function sandbox(){
      $eka = Message::find(1);
      $kaikki = Message::all();

      Kint::dump($eka);
      Kint::dump($kaikki);
    }
  }
