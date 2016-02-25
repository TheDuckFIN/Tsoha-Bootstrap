<?php
    
    class SettingsController extends BaseController {

        public static function index() {
            $settings = ForumSettings::all();
            
            View::make("settings/index.html"); 
        }

    }