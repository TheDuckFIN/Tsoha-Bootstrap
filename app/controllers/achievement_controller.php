<?php
    
    class AchievementController extends BaseController {

        public static function index() {
            $achievements = Achievement::all();

            View::make('achievements/index.html', array('achievements' => $achievements));
        }

    }