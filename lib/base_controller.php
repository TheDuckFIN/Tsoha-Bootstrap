<?php

  class BaseController{

    public static function get_user_logged_in(){
      if (isset($_SESSION['user'])) {
        $user_id = $_SESSION['user'];

        $user = User::find($user_id);

        return $user;
      }

      return null;
    }

    public static function check_logged_in(){
      if (!isset($_SESSION['user'])) {
        Redirect::to('/login', array('error' => 'Toiminto vaatii sisäänkirjautumista!'));
      }
    }

    public static function check_user_achievements($user) {

/*
INSERT INTO Achievement (name, description) VALUES ('Moderaattori', 'Oho, olet saavuttanut selvästi jotain suurta, sillä moderaattoriksi ei pääse ihan joka poika! Pidä hauskaa viestejä poistellessa! :)');
INSERT INTO Achievement (name, description) VALUES ('Ylläpitäjä', 'Olet kingi.');
INSERT INTO Achievement (name, description) VALUES ('Ensimmäinen viesti', 'Woohoo! Olet kirjoittanut ensimmäisen viestisi! Siitä se lähtee :)');
INSERT INTO Achievement (name, description) VALUES ('Kymmenen viestiä', 'Oho, sinäpäs olet vauhdissa! Kymmenen viestiä on jo melko paljon!');
INSERT INTO Achievement (name, description) VALUES ('50 viestiä', 'Jos viestien lähettämisestä palkittaisiin, saisit jo varmasti pronssia! Onnittelut!');
INSERT INTO Achievement (name, description) VALUES ('100 viestiä', 'Tämä alkaa olemaan jo hopeamitalin arvoinen suoritus... Oletko varma etteivät sormesi kulu puhki viestien kirjoittamisesta?');
INSERT INTO Achievement (name, description) VALUES ('200 viestiä', 'KULTAA!!! SE ON SIINÄ!!! Sormesi ovar varmaan jo ihan ruvilla, mutta ei se haittaa, SILLÄ VOITIT KULTAA!!!');
*/

      $achievements = Achievement::user_achievements($user->id);
      $postcount = $user->postcount();

      //Moderaattori
      if (!isset($achievements[1]) && $user->usergroup_id == 2) {
        Achievement::add_achievement(1, $user);
      }

      //Ylläpitäjä
      if (!isset($achievements[2]) && $user->usergroup_id == 3) {
        Achievement::add_achievement(2, $user);
      }

      //1 viesti
      if (!isset($achievements[3]) && $postcount >= 1) {
        Achievement::add_achievement(3, $user);
      }

      //10 viestiä
      if (!isset($achievements[4]) && $postcount >= 10) {
        Achievement::add_achievement(4, $user);
      }

      //50 viestiä
      if (!isset($achievements[5]) && $postcount >= 50) {
        Achievement::add_achievement(5, $user);
      }

      //100 viestiä
      if (!isset($achievements[6]) && $postcount >= 100) {
        Achievement::add_achievement(6, $user);
      }

      //200 viestiä
      if (!isset($achievements[7]) && $postcount >= 200) {
        Achievement::add_achievement(7, $user);
      }
    }

    public static function throw_error($msg) {
      Redirect::to('/', array('message' => $msg, 'style' => 'danger'));
    }

    public static function has_permission($name) {
      $user = self::get_user_logged_in();

      if (!$user) {
        return false;
      }else {
        $usergroup = Usergroup::find($user->usergroup_id);
        $permission = $usergroup->checkPermission($name);

        if ($permission === NULL) {
          exit("Error: Invalid permission: " . $name);
        }else {
          return $permission;
        }
      }
    }

    public static function permission_array() {
      $permissions = array('edit_message', 'delete_message', 'delete_thread', 'lock_thread', 'ban',
          'boardmanagement', 'usergroupmanagement', 'settingsmanagement', 'usermanagement');
      $logged_in = self::get_user_logged_in();

      if (!$logged_in) {
        $ret = array();
        foreach ($permissions as $key) {
          $ret[$key] = false;
        }
        return $ret;
      }else {
        $usergroup_permissions = Permission::find($logged_in->usergroup_id);
        return (array)$usergroup_permissions;
      }
    }

    public static function bbcodeify($text) {
      $text = mb_convert_encoding($text, 'UTF-8', 'UTF-8');
      $text = htmlentities($text, ENT_QUOTES, 'UTF-8');

      $text = nl2br($text);

      $text = str_replace('[b]', '<b>', $text);
      $text = str_replace('[/b]', '</b>', $text);
      $text = str_replace('[i]', '<em>', $text);
      $text = str_replace('[/i]', '</em>', $text);
      $text = str_replace('[u]', '<u>', $text);
      $text = str_replace('[/u]', '</u>', $text);

      return $text;
    }

  }
