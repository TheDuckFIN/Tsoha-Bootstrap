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

    public static function has_permission($name) {
      $user = self::get_user_logged_in();

      if (!$user) {
        Redirect::to('/login', array('error' => 'Toiminto vaatii sisäänkirjautumista!'));
      }else {
        $usergroup = Usergroup::find($user->usergroup_id);
        $permission = $usergroup->checkPermission($name);

        if ($permission == NULL) {
          exit("Error: Invalid permission: " . $name);
        }else {
          return $permission;
        }
      }

    }

  }
