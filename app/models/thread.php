<?php

	class Thread extends BaseModel {

		public $id, $board_id, $starter_id, $title, $locked;

		public function __construct($attributes) {
			parent::__construct($attributes);
		}

		public function validate() {
			$v = new Valitron\Validator(array(
				'otsikko' => $this->title
			));

			$v->rule('required', 'otsikko');
			$v->rule('lengthMax', 'otsikko', 50);

			$v->validate();

			$current_errors = parent::format_errors($v->errors());

			if (empty($current_errors)) {
				return true;
			}else {
				return $current_errors;
			}

		}

		public static function all() {
			$query = DB::connection()->prepare('SELECT * FROM Thread');
			$query->execute();

			$rows = $query->fetchAll();
			$threads = array();

			foreach ($rows as $row) {
				$threads[] = new Thread(array(
					'id' => $row['id'],
					'board_id' => $row['board_id'],
					'starter_id' => $row['starter_id'],
					'title' => $row['title'],
					'locked' => $row['locked']
				));	
			}

			return $threads;
		}

		public static function find($id) {
			if (!parent::valid_int($id)) return null;

			$query = DB::connection()->prepare('SELECT * FROM Thread WHERE id = :id LIMIT 1');
			$query->execute(array('id' => $id));

			$row = $query->fetch();
			
			if ($row) {
				$thread = new Thread(array(
					'id' => $row['id'],
					'board_id' => $row['board_id'],
					'starter_id' => $row['starter_id'],
					'title' => $row['title'],
					'locked' => $row['locked']
				));	

				return $thread;
			}

			return null;
		}

		public static function postcount($thread_id) {
			if (!parent::valid_int($thread_id)) return null;

			$query = DB::connection()->prepare('SELECT COUNT(*) FROM Message WHERE thread_id = :id');
			$query->execute(array('id' => $thread_id));

			$result = $query->fetch();

			return $result['count'];
		}

		public static function find_all_by_board($board_id) {
			if (!parent::valid_int($board_id)) return null;

			$query = DB::connection()->prepare('SELECT t.id, t.board_id, t.starter_id, t.title, t.locked FROM Thread t INNER JOIN Message m ON m.id = (SELECT msg.id FROM Message msg WHERE msg.thread_id = t.id ORDER BY msg.time 
                 DESC LIMIT 1) WHERE t.board_id = :id ORDER BY m.time DESC');
			$query->execute(array('id' => $board_id));

			$rows = $query->fetchAll();
			$threads = array();

			foreach ($rows as $row) {
				$threads[] = new Thread(array(
					'id' => $row['id'],
					'board_id' => $row['board_id'],
					'starter_id' => $row['starter_id'],
					'title' => $row['title'],
					'locked' => $row['locked']
				));	
			}

			return $threads;
		}

		public function save() {
			$query = DB::connection()->prepare('INSERT INTO Thread (board_id, starter_id, title, locked) VALUES (:board_id, :starter_id, :title, false) RETURNING id');
			$query->execute(array(
				'board_id' => $this->board_id,
				'starter_id' => $this->starter_id,
				'title' => $this->title
		    ));

			$row = $query->fetch();

			return $row['id'];
		}

		public function delete() {
			$thread_messages = Message::all_by_thread_id($this->id);

			foreach ($thread_messages as $msg) {
				$msg->delete();
			}

			$delete_thread = DB::connection()->prepare('DELETE FROM Thread WHERE id = :id');
			$delete_thread->execute(array('id' => $this->id));
		}

	}