<?php
    
    class Usergroup extends BaseModel {

        public $id, $name, $color, $locked;

        public function __construct($attributes) {
            parent::__construct($attributes);
        }

        public static function all() {
            $query = DB::connection()->prepare('SELECT * FROM Usergroup');
            $query->execute();

            $rows = $query->fetchAll();
            $usergroups = array();

            foreach ($rows as $row) {
                $usergroups[] = new Usergroup(array(
                    'id' => $row['id'],
                    'name' => $row['name'],
                    'color' => $row['color'],
                    'locked' => $row['locked']
                )); 
            }

            return $usergroups;
        }

        public static function find($id) {
            $query = DB::connection()->prepare('SELECT * FROM Usergroup WHERE id = :id LIMIT 1');
            $query->execute(array('id' => $id));

            $row = $query->fetch();
            
            if ($row) {
                $usergroup = new Usergroup(array(
                    'id' => $row['id'],
                    'name' => $row['name'],
                    'color' => $row['color'],
                    'locked' => $row['locked']
                )); 

                return $usergroup;
            }

            return null;
        }

        public function permissions() {
            return Permission::find($this->id);
        }

        public function checkPermission($name) {
            $all = $this->permissions();
            
            if (property_exists('Permission', $name)) {
                return $all->$name;
            }else {
                return null;
            }
        }

    }