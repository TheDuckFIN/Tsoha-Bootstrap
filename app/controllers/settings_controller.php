<?php
    
    class SettingsController extends BaseController {

        public static function index() {
            parent::check_logged_in();

            if (parent::has_permission('boardmanagement')) {
                $settings = ForumSettings::all();

                View::make("settings/index.html", array('settings' => $settings)); 
            }else {
                parent::throw_error('Sinulla ei ole oikeuksia hallintapaneeliin!');
            }

        }

    }