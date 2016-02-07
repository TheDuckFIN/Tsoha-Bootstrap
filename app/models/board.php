<?php
	
	class Board extends BaseModel {

		public $id, $category_id, $name, $description;

		public function __construct($attributes) {
			parent::__construct($attributes);
		}

		public static function all() {
			$query = DB::connection()->prepare('SELECT * FROM Board');
			$query->execute();

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

	}