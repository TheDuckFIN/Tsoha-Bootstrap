<?php

  class BaseModel{
    // "protected"-attribuutti on käytössä vain luokan ja sen perivien luokkien sisällä
    //protected $validators;

    public function __construct($attributes = null){
      // Käydään assosiaatiolistan avaimet läpi
      foreach($attributes as $attribute => $value){
        // Jos avaimen niminen attribuutti on olemassa...
        if(property_exists($this, $attribute)){
          // ... lisätään avaimen nimiseen attribuuttin siihen liittyvä arvo
          $this->{$attribute} = $value;
        }
      }
    }

    public static function format_errors($errors) {
      $ret = array();
    
      foreach ($errors as $arr) {
        foreach ($arr as $error) {
          $ret[] = $error;
        }
      }

      return $ret;
    }

    public static function valid_int($var) {
      if ((string)(int)$var == $var) {
        if (((int)$var <= 2147483647) && (int)$var > 0) {
          return true;
        }else {
          return false;
        }
      }else {
        return false;
      }
    }

    /*
    public function errors(){
      // Lisätään $errors muuttujaan kaikki virheilmoitukset taulukkona
      $errors = array();

      foreach($this->validators as $validator){
        // Kutsu validointimetodia tässä ja lisää sen palauttamat virheet errors-taulukkoon
      }

      return $errors;
    }*/

  }
