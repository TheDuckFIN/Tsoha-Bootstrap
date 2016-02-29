<?php
    
    class Usergroup extends BaseModel {

        public $id, $name, $color, $locked;

        public function __construct($attributes) {
            parent::__construct($attributes);
        }

        public function validate() {
            $v = new Valitron\Validator(array(
                'nimi' => $this->name,
                'väri' => $this->color,
                'lukittu' => $this->locked
            ));

            $v->rule('required', 'nimi');
            $v->rule('lengthMax', 'nimi', 50);
            $v->rule('required', 'väri');
            $v->rule('regex', 'väri', '/^#([A-Fa-f0-9]{6}|[A-Fa-f0-9]{3})$/');
            $v->rule('required', 'lukittu');

            $v->validate();

            $current_errors = parent::format_errors($v->errors());

            if (empty($current_errors)) {
                return true;
            }else {
                return $current_errors;
            }
        }

        public static function all() {
            $query = DB::connection()->prepare('SELECT * FROM Usergroup');
            $query->execute();

            $rows = $query->fetchAll();
            $usergroups = array();

            foreach ($rows as $row) {
                $usergroups[$row['id']] = new Usergroup(array(
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

        public function members_count() {
            $query = DB::connection()->prepare('SELECT COUNT(*) AS count FROM Member WHERE usergroup_id = :id');
            $query->execute(array('id' => $this->id));

            $row = $query->fetch();

            if ($row) {
                return $row['count'];
            }else {
                return null;
            }
        }

        public function permissions() {
            return Permission::find($this->id);
        }

        public function checkPermission($name) {
            $all = $this->permissions();

            if (property_exists('Permission', $name)) {
                return $all->{$name};
            }else {
                return null;
            }
        }

        public function save() {
            $query = DB::connection()->prepare('INSERT INTO Usergroup (name, color, locked) VALUES (:name, :color, false) RETURNING id');
            $query->execute(array('name' => $this->name, 'color' => $this->color));

            $row = $query->fetch();

            return $row['id'];
        }

        public function update() {
            $query = DB::connection()->prepare('UPDATE Usergroup SET
                name = :name,
                color = :color,
                locked = :locked
                WHERE id = :id');

            $query->bindValue(':name', $this->name, PDO::PARAM_STR);
            $query->bindValue(':color', $this->color, PDO::PARAM_STR);
            $query->bindValue(':locked', $this->locked, PDO::PARAM_BOOL);
            $query->bindValue(':id', $this->id, PDO::PARAM_INT);

            $query->execute();
        }

        public function delete() {
            $move_users = DB::connection()->prepare('UPDATE Member SET usergroup_id = 1 WHERE usergroup_id = :id');
            $move_users->execute(array('id' => $this->id));

            $delete_permissions = DB::connection()->prepare('DELETE FROM Permission WHERE usergroup_id = :id');
            $delete_permissions->execute(array('id' => $this->id));
            
            $delete_group = DB::connection()->prepare('DELETE FROM Usergroup WHERE id = :id');
            $delete_group->execute(array('id' => $this->id));
        }

    }