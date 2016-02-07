<?php
	
	class Member extends BaseModel {

		public $id, $usergroup_id, $username, $password, $email, $show_email, $avatar, $info;

		public function __construct($attributes) {
			parent::__construct($attributes);
		}

		public static function all() {
			$query = DB::connection()->prepare('SELECT * FROM Member');
			$query->execute();

			$rows = $query->fetchAll();
			$members = array();

			foreach ($rows as $row) {
				$members[] = new Member(array(
					'id' => $row['id'],
					'usergroup_id' => $row['usergroup_id'],
					'username' => $row['username'],
					'password' => $row['password'],
					'email' => $row['email'],
					'show_email' => $row['show_email'],
					'avatar' => $row['avatar'],
					'info' => $row['info']
				));	
			}

			return $members;
		}

		public static function find($id) {
			$query = DB::connection()->prepare('SELECT * FROM Member WHERE id = :id LIMIT 1');
			$query->execute(array('id' => $id));

			$row = $query->fetch();
			
			if ($row) {
				$member = new Member(array(
					'id' => $row['id'],
					'usergroup_id' => $row['usergroup_id'],
					'username' => $row['username'],
					'password' => $row['password'],
					'email' => $row['email'],
					'show_email' => $row['show_email'],
					'avatar' => $row['avatar'],
					'info' => $row['info']
				));	

				return $member;
			}

			return null;
		}

	}