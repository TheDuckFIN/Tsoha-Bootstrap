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

    public static function sandbox(){
      // Testaa koodiasi täällä
      View::make('helloworld.html');
    }
  }
