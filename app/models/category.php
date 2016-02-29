<?php
	
	class Category extends BaseModel {

		public $id, $name;

		public function __construct($attributes) {
			parent::__construct($attributes);
		}

		public static function all() {
			$query = DB::connection()->prepare('SELECT * FROM Category');
			$query->execute();

			$rows = $query->fetchAll();
			$categories = array();

			foreach ($rows as $row) {
				$categories[] = new Category(array(
					'id' => $row['id'],
					'name' => $row['name']
				));	
			}

			return $categories;
		}

		public function validate() {
			if (!empty($this->name) && strlen($this->name) > 3 && strlen($this->name) < 50) {
				return true;
			}else{
				return "Kategorian nimen tulee olla 3-50 merkkiä pitkä!";
			}
		}

		public static function find($id) {
			$query = DB::connection()->prepare('SELECT * FROM Category WHERE id = :id LIMIT 1');
			$query->execute(array('id' => $id));

			$row = $query->fetch();
			
			if ($row) {
				$category = new Category(array(
					'id' => $row['id'],
					'name' => $row['name']
				));

				return $category;
			}

			return null;
		}

		public function save() {
			$query = DB::connection()->prepare('INSERT INTO Category (name) VALUES (:name)');
			$query->execute(array('name' => $this->name));
		}

	}