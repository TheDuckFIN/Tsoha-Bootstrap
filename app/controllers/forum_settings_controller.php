<?php
    
    class ForumSettingsController extends BaseController {

        public static function index() {
            $settings = ForumSettings::all();
            Kint::dump($settings);          
        }

    }