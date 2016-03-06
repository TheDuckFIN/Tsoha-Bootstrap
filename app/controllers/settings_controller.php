<?php
    
    class SettingsController extends BaseController {

        public static function index() {
            parent::check_permission("settingsmanagement", "Yleiset asetukset");

            $settings = ForumSettings::all();

            View::make("settings/general.html", array('settings' => $settings));          
        }

        public static function update() {
            parent::check_permission("settingsmanagement");

            $params = $_POST;

            $settings = ForumSettings::all();

            $settings->name = $params['name'];
            $settings->msg_size = $params['msg_size'];

            $valid = $settings->validate();

            if ($valid === true) {
                $settings->update();
                Redirect::to('/settings/', array('message' => 'Asetukset tallennettu onnistuneesti!', 'style' => 'success'));
            }else {
                View::make('settings/general.html', array('errors' => $valid, 'settings' => $settings));
            }
        }

        public static function usergroups_index() {
            parent::check_permission("usergroupmanagement", "Käyttäjäryhmien hallinta");

            $groups = Usergroup::all();

            View::make("settings/usergroups.html", array('groups' => $groups)); 
        }

        public static function users_index() {
            parent::check_permission("usermanagement", "Käyttäjien hallinta");

            $users = User::all();
            $groups = Usergroup::all();

            View::make("settings/users.html", array('users' => $users, 'group' => $groups)); 
        }

        public static function arrangement_index() {
            parent::check_permission("boardmanagement", "Kategorioiden ja keskustelualueiden hallinta");
        
            $categories = Category::all();
            $boards = Board::all();

            View::make("settings/arrangement.html", array('categories' => $categories, 'boards' => $boards)); 
        }

    }