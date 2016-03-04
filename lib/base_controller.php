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

    public static function check_permission($permission, $title = null) {
      self::check_logged_in();

      if (!self::has_permission($permission)) {
        if (!$title) {
          self::throw_error('Sinulla ei ole oikeuksia toimintoon!');
        }else {
          if (self::has_permission('boardmanagement') || self::has_permission('usermanagement') || self::has_permission('usergroupmanagement') || self::has_permission('settingsmanagement')) {
            View::make("settings/nopermission.html", array('title' => $title));
          }else {
            self::throw_error('Sinulla ei ole oikeuksia toimintoon!');
          }        
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
