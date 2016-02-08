<?php
	
	class Message extends BaseModel {

		public $id, $sender_id, $thread_id, $time, $message;

		public function __construct($attributes) {
			parent::__construct($attributes);
		}

		public static function all() {
			$query = DB::connection()->prepare('SELECT * FROM Message');
			$query->execute();

			$rows = $query->fetchAll();
			$messages = array();

			foreach ($rows as $row) {
				$messages[] = new Message(array(
					'id' => $row['id'],
					'sender_id' => $row['sender_id'],
					'thread_id' => $row['thread_id'],
					'time' => $row['time'],
					'message' => $row['message']
				));	
			}

			return $messages;
		}

		public static function all_by_thread_id($thread_id) {
			$query = DB::connection()->prepare('SELECT * FROM Message WHERE thread_id = :id');
			$query->execute(array('id' => $thread_id));

			$rows = $query->fetchAll();
			$messages = array();

			foreach ($rows as $row) {
				$messages[] = new Message(array(
					'id' => $row['id'],
					'sender_id' => $row['sender_id'],
					'thread_id' => $row['thread_id'],
					'time' => $row['time'],
					'message' => $row['message']
				));	
			}

			return $messages;
		}

		public static function last_message_by_board_id($board_id) {
			$query = DB::connection()->prepare('SELECT m.id, m.thread_id, m.sender_id, m.time, m.message FROM Message m INNER JOIN Thread t ON t.id = m.thread_id INNER JOIN Board b ON b.id = t.board_id WHERE b.id = :id ORDER BY m.id DESC LIMIT 1');
			$query->execute(array('id' => $board_id));

			$result = $query->fetch();

			if ($result) {
				return array(
					'msg' => new Message(array(
								'id' => $result['id'],
								'sender_id' => $result['sender_id'],
								'time' => $result['time'],
								'message' => $result['message']
							)),
					'user' => Member::find($result['sender_id']),
					'thread' => Thread::find($result['thread_id'])
				);
			} else {
				return null;
			}
		}

		public static function last_message_by_thread_id($thread_id) {
			$query = DB::connection()->prepare('SELECT m.id, m.sender_id, m.time, m.message FROM Message m INNER JOIN Thread t ON t.id = m.thread_id WHERE t.id = :id ORDER BY m.id DESC LIMIT 1');
			$query->execute(array('id' => $thread_id));

			$result = $query->fetch();

			if ($result) {
				return array(
					'msg' => new Message(array(
								'id' => $result['id'],
								'sender_id' => $result['sender_id'],
								'time' => $result['time'],
								'message' => $result['message']
							)),
					'user' => Member::find($result['sender_id'])
				);
			} else {
				return null;
			}
		}

		public static function find($id) {
			$query = DB::connection()->prepare('SELECT * FROM Message WHERE id = :id LIMIT 1');
			$query->execute(array('id' => $id));

			$row = $query->fetch();
			
			if ($row) {
				$message = new Message(array(
					'id' => $row['id'],
					'sender_id' => $row['sender_id'],
					'thread_id' => $row['thread_id'],
					'time' => $row['time'],
					'message' => $row['message']
				));	

				return $message;
			}

			return null;
		}

		public function save() {
			$query = DB::connection()->prepare('INSERT INTO Message (sender_id, thread_id, time, message) VALUES (:sender_id, :thread_id, CURRENT_TIMESTAMP, :message)');
			$query->execute(array('sender_id' => $this->sender_id, 'thread_id' => $this->thread_id, 'message' => $this->message));
		}

		public function delete() {
			$delete_msg = DB::connection()->prepare('DELETE FROM Message WHERE id = :id');
			$delete_msg->execute(array('id' => $this->id));

			$delete_edits = DB::connection()->prepare('DELETE FROM Edit WHERE message_id = :id');
			$delete_edits->execute(array('id' => $this->id));
		}

	}