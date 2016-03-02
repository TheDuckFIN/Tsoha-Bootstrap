<?php
    
    class AchievementController extends BaseController {

        public static function index() {
            $achievements = Achievement::all();

            View::make('achievements/index.html', array('achievements' => $achievements));
        }

        public static function user($id) {
            $user = User::find($id);

            if (!$user) {
                parent::throw_error("Virheellinen käyttäjän ID!");
            }else {
                $achievements = Achievement::user_achievements($id);

                View::make('achievements/user.html', array('user' => $user, 'achievements' => $achievements));
            }
        }

    }