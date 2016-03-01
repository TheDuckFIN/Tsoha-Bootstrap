<?php
	
	class Board extends BaseModel {

		public $id, $category_id, $name, $description;

		public function __construct($attributes) {
			parent::__construct($attributes);
		}

		public function validate() {
			$v = new Valitron\Validator(array(
				'nimi' => $this->name,
				'kuvaus' => $this->description
			));

			$v->rule('required', 'nimi');
			$v->rule('lengthMax', 'nimi', 50);
			$v->rule('lengthMin', 'nimi', 3);

			$v->rule('required', 'kuvaus');
			$v->rule('lengthMax', 'kuvaus', 150);

			$v->validate();

			$current_errors = parent::format_errors($v->errors());

			if (empty($current_errors)) {
				return true;
			}else {
				return $current_errors;
			}
		}

		public static function all($category = null) {
			if (!$category) {
				$query = DB::connection()->prepare('SELECT * FROM Board ORDER BY id');
				$query->execute();
			}else {
				$query = DB::connection()->prepare('SELECT * FROM Board WHERE category_id = :id ORDER BY id');
				$query->execute(array('id' => $category));
			}

			$rows = $query->fetchAll();
			$boards = array();

			foreach ($rows as $row) {
				$boards[] = new Board(array(
					'id' => $row['id'],
					'category_id' => $row['category_id'],
					'name' => $row['name'],
					'description' => $row['description']
				));	
			}

			return $boards;
		}

		public static function find($id) {
			if (!parent::valid_int($id)) return null;

			$query = DB::connection()->prepare('SELECT * FROM Board WHERE id = :id LIMIT 1');
			$query->execute(array('id' => $id));

			$row = $query->fetch();
			
			if ($row) {
				$board = new Board(array(
					'id' => $row['id'],
					'category_id' => $row['category_id'],
					'name' => $row['name'],
					'description' => $row['description']
				));	

				return $board;
			}

			return null;
		}

		public function save() {
			$query = DB::connection()->prepare('INSERT INTO Board (category_id, name, description) VALUES (:cat_id, :name, :description)');
			$query->execute(array(
				'cat_id' => $this->category_id, 
				'name' => $this->name, 
				'description' => $this->description
			));
		}

		public function update() {
			$query = DB::connection()->prepare('UPDATE Board SET name = :name, description = :description WHERE id = :id');
			$query->execute(array('name' => $this->name, 'description' => $this->description, 'id' => $this->id));
		}

		public function delete() {
			$threads = Thread::find_all_by_board($this->id);

			foreach ($threads as $thread) {
				$thread->delete();
			}

			$query = DB::connection()->prepare('DELETE FROM Board WHERE id = :id');
			$query->execute(array('id' => $this->id));
		}

	}