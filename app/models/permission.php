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

    }
