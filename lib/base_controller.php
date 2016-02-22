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
      return array(
        'edit_message' => self::has_permission('edit_message'),
        'delete_message' => self::has_permission('delete_message'),
        'delete_thread' => self::has_permission('delete_thread'),
        'lock_thread' => self::has_permission('lock_thread'),
        'ban' => self::has_permission('ban'),
        'boardmanagement' => self::has_permission('boardmanagement'),
        'usergroupmanagement' => self::has_permission('usergroupmanagement'),
        'settingsmanagement' => self::has_permission('settingsmanagement'),
        'usermanagement' => self::has_permission('usermanagement')
      );
    }

  }
