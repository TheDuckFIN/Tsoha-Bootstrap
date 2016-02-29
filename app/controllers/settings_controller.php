<?php
    
    class SettingsController extends BaseController {

        public static function index() {
            parent::check_logged_in();

            if (parent::has_permission('settingsmanagement')) {
                $settings = ForumSettings::all();

                View::make("settings/general.html", array('settings' => $settings)); 
            }else {
                self::no_access("Yleiset asetukset");
            }
        }

        public static function usergroups_index() {
            parent::check_logged_in();

            if (parent::has_permission('usergroupmanagement')) {
                $groups = Usergroup::all();

                View::make("settings/usergroups.html", array('groups' => $groups)); 
            }else {
                self::no_access("Käyttäjäryhmien hallinta");
            }
        }

        public static function users_index() {
            parent::check_logged_in();

            if (parent::has_permission('usermanagement')) {
                $users = User::all();
                $groups = Usergroup::all();

                View::make("settings/users.html", array('users' => $users, 'group' => $groups)); 
            }else {
                self::no_access("Käyttäjien hallinta");
            }
        }

        public static function categories_index() {
            parent::check_logged_in();

            if (parent::has_permission('boardmanagement')) {
                //View::make("settings/general.html", array('settings' => $settings)); 
            }else {
                self::no_access("Kategorioiden hallinta");
            }
        }

        public static function boards_index() {
            parent::check_logged_in();

            if (parent::has_permission('boardmanagement')) {
                //View::make("settings/general.html", array('settings' => $settings)); 
            }else {
                self::no_access("Keskustelualueiden hallinta");
            }
        }

        private static function no_access($title) {
            if (parent::has_permission('boardmanagement') || parent::has_permission('usermanagement') || parent::has_permission('usergroupmanagement') || parent::has_permission('settingsmanagement')) {
                View::make("settings/nopermission.html", array('title' => $title));
            }else {
                parent::throw_error('Sinulla ei ole oikeuksia hallintapaneeliin!');
            }
        }


    }