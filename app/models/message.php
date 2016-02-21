<?php
	
	class Message extends BaseModel {

		public $id, $sender_id, $thread_id, $time, $message, $firstpost;

		public function __construct($attributes) {
			parent::__construct($attributes);
		}

		public function validate() {
			$thread = Thread::find($this->thread_id);

			$v = new Valitron\Validator(array(
				'message' => $this->message,
				'thread_locked' => $thread->locked
			));

			$v->rule('required', 'message');
			$v->rule('lengthMax', 'message', 25000);


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
					'message' => $row['message'],
					'firstpost' => $row['firstpost']
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
					'message' => $row['message'],
					'firstpost' => $row['firstpost']
				));	
			}

			return $messages;
		}

		public static function last_message_by_board_id($board_id) {
			$query = DB::connection()->prepare('SELECT m.id, m.thread_id, m.sender_id, m.time, m.message, m.firstpost FROM Message m INNER JOIN Thread t ON t.id = m.thread_id INNER JOIN Board b ON b.id = t.board_id WHERE b.id = :id ORDER BY m.id DESC LIMIT 1');
			$query->execute(array('id' => $board_id));

			$result = $query->fetch();

			if ($result) {
				return array(
					'msg' => new Message(array(
								'id' => $result['id'],
								'sender_id' => $result['sender_id'],
								'time' => $result['time'],
								'message' => $result['message'],
								'firstpost' => $result['firstpost']
							)),
					'user' => User::find($result['sender_id']),
					'thread' => Thread::find($result['thread_id'])
				);
			} else {
				return null;
			}
		}

		public static function last_message_by_thread_id($thread_id) {
			$query = DB::connection()->prepare('SELECT m.id, m.sender_id, m.time, m.message, m.firstpost FROM Message m INNER JOIN Thread t ON t.id = m.thread_id WHERE t.id = :id ORDER BY m.id DESC LIMIT 1');
			$query->execute(array('id' => $thread_id));

			$result = $query->fetch();

			if ($result) {
				return array(
					'msg' => new Message(array(
								'id' => $result['id'],
								'sender_id' => $result['sender_id'],
								'time' => $result['time'],
								'message' => $result['message'],
								'firstpost' => $result['firstpost']
							)),
					'user' => User::find($result['sender_id'])
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
					'message' => $row['message'],
					'firstpost' => $row['firstpost']
				));	

				return $message;
			}

			return null;
		}

		public function save() {
			$query = DB::connection()->prepare('INSERT INTO Message (sender_id, thread_id, time, message, firstpost) VALUES (:sender_id, :thread_id, CURRENT_TIMESTAMP, :message, :firstpost)');
			
			$query->bindValue(':firstpost', $this->firstpost, PDO::PARAM_BOOL);
			$query->bindValue(':sender_id', $this->sender_id, PDO::PARAM_INT);
			$query->bindValue(':thread_id', $this->thread_id, PDO::PARAM_INT);
			$query->bindValue(':message', $this->message, PDO::PARAM_STR);

			$query->execute();
		}

		public function update() {
			$query = DB::connection()->prepare('UPDATE Message SET message = :message WHERE id = :id');
			$query->execute(array('message' => $this->message, 'id' => $this->id));
		}

		public function delete() {
			$delete_msg = DB::connection()->prepare('DELETE FROM Message WHERE id = :id');
			$delete_msg->execute(array('id' => $this->id));

			$delete_edits = DB::connection()->prepare('DELETE FROM Edit WHERE message_id = :id');
			$delete_edits->execute(array('id' => $this->id));
		}

	}