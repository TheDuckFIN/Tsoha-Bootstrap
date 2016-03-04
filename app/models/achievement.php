<?php
    
    class Achievement extends BaseModel {

        public $id, $name, $description;

        public function __construct($attributes) {
            parent::__construct($attributes);
        }

        public static function all() {
            $query = DB::connection()->prepare('SELECT * FROM Achievement');
            $query->execute();

            $rows = $query->fetchAll();
            $achievements = array();

            foreach ($rows as $row) {
                $achievements[$row['id']] = new Achievement(array(
                    'id' => $row['id'],
                    'name' => $row['name'],
                    'description' => $row['description']
                )); 
            }

            return $achievements;
        }

        public static function user_achievements($id) {
            if (!parent::valid_int($id)) return null;

            $query = DB::connection()->prepare('SELECT a.id, a.name, a.description 
                FROM Member_achievement ma 
                INNER JOIN Achievement a 
                    ON a.id = ma.achievement_id 
                WHERE ma.member_id = :id;');

            $query->execute(array('id' => $id));

            $rows = $query->fetchAll();
            $achievements = array();

            foreach ($rows as $row) {
                $achievements[$row['id']] = new Achievement(array(
                    'id' => $row['id'],
                    'name' => $row['name'],
                    'description' => $row['description']
                )); 
            }

            return $achievements;
        }

        public static function add_achievement($id, $user) {
            $query = DB::connection()->prepare('INSERT INTO Member_achievement (member_id, achievement_id) VALUES (:user, :achievement)');
            $query->execute(array('achievement' => $id, 'user' => $user->id));
        }


    }