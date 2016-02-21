<?php
    
    class ForumSettings extends BaseModel {

        public $name, $msg_size;

        public function __construct($attributes) {
            parent::__construct($attributes);
        }

        public static function all() {
            $query = DB::connection()->prepare('SELECT * FROM Forum_settings WHERE id = 1');
            $query->execute();

            $settings = $query->fetch();

            return new ForumSettings(array(
                'name' => $settings['name'],
                'msg_size' => $settings['msg_size']
            ));
        }

        public static function get($field) {
            $query = DB::connection()->prepare('SELECT * FROM Forum_settings WHERE id = 1');
            $query->execute();

            $settings = $query->fetch();

            if (array_key_exists($field, $settings)) {
                return $settings[$field];
            }else {
                return null;
            }
        }

        public function update() {
            $query = DB::connection()->prepare('UPDATE Forum_settings SET name = :name, msg_size = :msg_size WHERE id = 1');
            $query->execute(array(
                'name' => $this->name, 
                'msg_size' => $this->msg_size
            ));
        }

    }
