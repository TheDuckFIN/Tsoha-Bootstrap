<?php
    
    class Permission extends BaseModel {

        public $usergroup_id, $delete_thread, $delete_message, $edit_message, $lock_thread, $ban, $boardmanagement, $usergroupmanagement, $settingsmanagement, $usermanagement;

        public function __construct($attributes) {
            parent::__construct($attributes);
        }

        public static function all() {
            $query = DB::connection()->prepare('SELECT * FROM Permission');
            $query->execute();

            $rows = $query->fetchAll();
            $permissions = array();

            foreach ($rows as $row) {
                $permissions[] = new Permission(array(
                    'usergroup_id' => $row['usergroup_id'],
                    'delete_thread' => $row['delete_thread'],
                    'delete_message' => $row['delete_message'],
                    'edit_message' => $row['edit_message'],
                    'lock_thread' => $row['lock_thread'],
                    'ban' => $row['ban'],
                    'boardmanagement' => $row['boardmanagement'],
                    'usergroupmanagement' => $row['usergroupmanagement'],
                    'settingsmanagement' => $row['settingsmanagement'],
                    'usermanagement' => $row['usermanagement']
                )); 
            }

            return $permissions;
        }

        public static function find($id) {
            $query = DB::connection()->prepare('SELECT * FROM Permission WHERE usergroup_id = :id LIMIT 1');
            $query->execute(array('id' => $id));

            $row = $query->fetch();
            
            if ($row) {
                $permission = new Permission(array(
                    'usergroup_id' => $row['usergroup_id'],
                    'delete_thread' => $row['delete_thread'],
                    'delete_message' => $row['delete_message'],
                    'edit_message' => $row['edit_message'],
                    'lock_thread' => $row['lock_thread'],
                    'ban' => $row['ban'],
                    'boardmanagement' => $row['boardmanagement'],
                    'usergroupmanagement' => $row['usergroupmanagement'],
                    'settingsmanagement' => $row['settingsmanagement'],
                    'usermanagement' => $row['usermanagement']
                )); 

                return $permission;
            }

            return null;
        }

        public function save() {
            $query = DB::connection()->prepare('INSERT INTO Permission 
                    (usergroup_id, delete_thread, delete_message, 
                    edit_message, lock_thread, ban, boardmanagement, 
                    usergroupmanagement, settingsmanagement, usermanagement) 
                VALUES
                    (:groupid, :delth, :delm, :edm, :lt, :ban, :bman, :ugman, :setman, :uman)');

            $query->bindValue(':groupid', $this->usergroup_id, PDO::PARAM_INT);
            $query->bindValue(':delth', $this->delete_thread, PDO::PARAM_BOOL);
            $query->bindValue(':delm', $this->delete_message, PDO::PARAM_BOOL);
            $query->bindValue(':edm', $this->edit_message, PDO::PARAM_BOOL);
            $query->bindValue(':lt', $this->lock_thread, PDO::PARAM_BOOL);
            $query->bindValue(':ban', $this->ban, PDO::PARAM_BOOL);
            $query->bindValue(':bman', $this->boardmanagement, PDO::PARAM_BOOL);
            $query->bindValue(':ugman', $this->usergroupmanagement, PDO::PARAM_BOOL);
            $query->bindValue(':setman', $this->settingsmanagement, PDO::PARAM_BOOL);
            $query->bindValue(':uman', $this->usermanagement, PDO::PARAM_BOOL);

            $query->execute();
        }

        public function update() {
            $query = DB::connection()->prepare('UPDATE Permission SET
                    delete_thread = :delth, 
                    delete_message = :delm, 
                    edit_message = :edm, 
                    lock_thread = :lt, 
                    ban = :ban, 
                    boardmanagement = :bman, 
                    usergroupmanagement = :ugman, 
                    settingsmanagement = :setman, 
                    usermanagement = :uman
                    WHERE usergroup_id = :groupid');

            $query->bindValue(':groupid', $this->usergroup_id, PDO::PARAM_INT);
            $query->bindValue(':delth', $this->delete_thread, PDO::PARAM_BOOL);
            $query->bindValue(':delm', $this->delete_message, PDO::PARAM_BOOL);
            $query->bindValue(':edm', $this->edit_message, PDO::PARAM_BOOL);
            $query->bindValue(':lt', $this->lock_thread, PDO::PARAM_BOOL);
            $query->bindValue(':ban', $this->ban, PDO::PARAM_BOOL);
            $query->bindValue(':bman', $this->boardmanagement, PDO::PARAM_BOOL);
            $query->bindValue(':ugman', $this->usergroupmanagement, PDO::PARAM_BOOL);
            $query->bindValue(':setman', $this->settingsmanagement, PDO::PARAM_BOOL);
            $query->bindValue(':uman', $this->usermanagement, PDO::PARAM_BOOL);

            $query->execute();
        }

    }
