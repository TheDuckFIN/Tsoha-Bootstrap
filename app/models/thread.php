<?php

	class Thread extends BaseModel {

		public $id, $board_id, $starter_id, $title, $locked;

		public function __construct($attributes) {
			parent::__construct($attributes);
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
			$query = DB::connection()->prepare('SELECT COUNT(*) FROM Message WHERE thread_id = :id');
			$query->execute(array('id' => $thread_id));

			$result = $query->fetch();

			return $result['count'];
		}

		public static function find_all_by_board($board_id) {
			$query = DB::connection()->prepare('SELECT * FROM Thread WHERE board_id = :id');
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

	}