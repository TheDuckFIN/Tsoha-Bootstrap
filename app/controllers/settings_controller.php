<?php
    
    class SettingsController extends BaseController {

        public static function index() {
            self::check_permission("settingsmanagement", "Yleiset asetukset");

            $settings = ForumSettings::all();

            View::make("settings/general.html", array('settings' => $settings));          
        }

        public static function update() {
            parent::check_logged_in();

            if (parent::has_permission('settingsmanagement')) {
                $params = $_POST;

                $settings = ForumSettings::all();

                $settings->name = $params['name'];
                $settings->msg_size = $params['msg_size'];

                $valid = $settings->validate();

                if ($valid === true) {
                    $settings->update();
                    Redirect::to('/settings/', array('message' => 'Asetukset tallennettu onnistuneesti!', 'style' => 'success'));
                }else {
                    Redirect::to('/settings/', array('errors' => $valid));
                }
            }else {
                parent::throw_error('Sinulla ei ole oikeuksia hallintapaneeliin!');
            }
        }

        public static function usergroups_index() {
            self::check_permission("usergroupmanagement", "Käyttäjäryhmien hallinta");

            $groups = Usergroup::all();

            View::make("settings/usergroups.html", array('groups' => $groups)); 
        }

        public static function users_index() {
            self::check_permission("usermanagement", "Käyttäjien hallinta");

            $users = User::all();
            $groups = Usergroup::all();

            View::make("settings/users.html", array('users' => $users, 'group' => $groups)); 
        }

        public static function arrangement_index() {
            self::check_permission("boardmanagement", "Kategorioiden ja keskustelualueiden hallinta");
        
            $categories = Category::all();
            $boards = Board::all();

            View::make("settings/arrangement.html", array('categories' => $categories, 'boards' => $boards)); 
        }

        private static function check_permission($permission, $title) {
            parent::check_logged_in();

            if (!parent::has_permission($permission)) {
                if (parent::has_permission('boardmanagement') || parent::has_permission('usermanagement') || parent::has_permission('usergroupmanagement') || parent::has_permission('settingsmanagement')) {
                    View::make("settings/nopermission.html", array('title' => $title));
                }else {
                    parent::throw_error('Sinulla ei ole oikeuksia hallintapaneeliin!');
                }
            }
        }

    }