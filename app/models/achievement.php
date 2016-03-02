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
                $achievements[] = new Achievement(array(
                    'id' => $row['id'],
                    'name' => $row['name'],
                    'description' => $row['description']
                )); 
            }

            return $achievements;
        }

        public static function member_achievements($id) {
            $query = DB::connection()->prepare('SELECT * FROM Achievement');
            $query->execute();

            $rows = $query->fetchAll();
            $achievements = array();

            foreach ($rows as $row) {
                $achievements[] = new Achievement(array(
                    'id' => $row['id'],
                    'name' => $row['name'],
                    'description' => $row['description']
                )); 
            }

            return $achievements;
        }

    }