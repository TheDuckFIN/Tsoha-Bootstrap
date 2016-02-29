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

        public function validate() {
            $v = new Valitron\Validator(array(
                'palstan otsikko' => $this->name,
                'viestin pituus' => $this->msg_size
            ));

            $v->rule('required', 'palstan otsikko');
            $v->rule('lengthMax', 'palstan otsikko', 50);
            $v->rule('required', 'viestin pituus');
            $v->rule('numeric', 'viestin pituus');
            $v->rule('min', 'viestin pituus', 1);

            $v->validate();

            $current_errors = parent::format_errors($v->errors());

            if (empty($current_errors)) {
                return true;
            }else {
                return $current_errors;
            }
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
