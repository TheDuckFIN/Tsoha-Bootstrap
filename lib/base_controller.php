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
