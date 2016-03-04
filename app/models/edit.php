<?php
    
    class Edit extends BaseModel {

        public $id, $message_id, $editor_id, $time, $description;

        public function __construct($attributes) {
            parent::__construct($attributes);
        }

        public static function all_by_msg($msg_id) {
            if (!parent::valid_int($msg_id)) return null;

            $query = DB::connection()->prepare('SELECT * FROM Edit WHERE message_id = :id');
            $query->execute(array('id' => $msg_id));

            $rows = $query->fetchAll();
            $edits = array();

            foreach ($rows as $row) {
                $time = date_create($row['time']);

                $edits[] = new Edit(array(
                    'id' => $row['id'],
                    'message_id' => $row['message_id'],
                    'editor_id' => $row['editor_id'],
                    'time' => date_format($time, "d.m.Y H:i:s"),
                    'description' => $row['description']
                ));
            }

            return $edits;
        }

        public static function all_by_thread($thread_id) {
            if (!parent::valid_int($thread_id)) return null;

            $query = DB::connection()->prepare('SELECT e.id, e.message_id, e.editor_id, e.time, e.description 
                FROM Edit e 
                INNER JOIN Message m 
                    ON e.message_id = m.id 
                WHERE m.thread_id = :id
                ORDER BY e.time DESC');

            $query->execute(array('id' => $thread_id));

            $rows = $query->fetchAll();
            $edits = array();

            foreach ($rows as $row) {
                if (!isset($edits[$row['message_id']])) $edits[$row['message_id']] = array();

                $time = date_create($row['time']);

                $edits[$row['message_id']][] = new Edit(array(
                    'id' => $row['id'],
                    'message_id' => $row['message_id'],
                    'editor_id' => $row['editor_id'],
                    'time' => date_format($time, "d.m.Y H:i:s"),
                    'description' => $row['description']
                ));
            }

            return $edits;
        }

        public function validate() {
            if (strlen($this->description) <= 100) {
                return true;
            }else {
                return null;
            }
        }

        public function save() {
            $query = DB::connection()->prepare('INSERT INTO Edit (message_id, editor_id, time, description) 
                VALUES (:message_id, :editor_id, CURRENT_TIMESTAMP, :description)');

            $query->execute(array(
                'message_id' => $this->message_id,
                'editor_id' => $this->editor_id,
                'description' => $this->description
            ));
        }

    }