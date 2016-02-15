<?php
	
	class User extends BaseModel {

		public $id, $usergroup_id, $username, $password, $email, $show_email, $avatar, $info, $registered;

		public function __construct($attributes) {
			parent::__construct($attributes);
		}

		public static function validateRegister($username, $password, $password2, $email) {
			$v = new Valitron\Validator(array(
				'Käyttäjätunnus' => $username,
				'Salasana' => $password,
				'Salasana uudestaan' => $password2,
				'Email' => $email
			));

			$v->rule('required', 'Käyttäjätunnus');
			$v->rule('required', 'Salasana');
			$v->rule('required', 'Salasana uudestaan');
			$v->rule('required', 'Email');
			$v->rule('lengthMin', 'Käyttäjätunnus', 3);
			$v->rule('lengthMax', 'Käyttäjätunnus', 20);
			$v->rule('email', 'Email');
			$v->rule('equals', 'Salasana', 'Salasana uudestaan');
			$v->rule('lengthMin', 'Salasana', 8);

			$v->validate();

			$current_errors = parent::format_errors($v->errors());

			if (self::username_exists($username)) {
				$current_errors[] = 'Käyttäjätunnus on jo olemassa, valitse jokin toinen';
			}

			if (empty($current_errors)) {
				return true;
			}else {
				return $current_errors;
			}
		}

		public static function all() {
			$query = DB::connection()->prepare('SELECT * FROM Member');
			$query->execute();

			$rows = $query->fetchAll();
			$users = array();

			foreach ($rows as $row) {
				$users[] = new User(array(
					'id' => $row['id'],
					'usergroup_id' => $row['usergroup_id'],
					'username' => $row['username'],
					'password' => $row['password'],
					'email' => $row['email'],
					'show_email' => $row['show_email'],
					'registered' => $row['registered'],
					'avatar' => $row['avatar'],
					'info' => $row['info']
				));	
			}

			return $users;
		}

		public static function find($id) {
			$query = DB::connection()->prepare('SELECT * FROM Member WHERE id = :id LIMIT 1');
			$query->execute(array('id' => $id));

			$row = $query->fetch();
			
			if ($row) {
				$user = new User(array(
					'id' => $row['id'],
					'usergroup_id' => $row['usergroup_id'],
					'username' => $row['username'],
					'password' => $row['password'],
					'email' => $row['email'],
					'show_email' => $row['show_email'],
					'registered' => $row['registered'],
					'avatar' => $row['avatar'],
					'info' => $row['info']
				));	

				return $user;
			}

			return null;
		}

		public static function authenticate($username, $password) {
			$query = DB::connection()->prepare('SELECT * FROM Member WHERE username = :username AND password = :password LIMIT 1');
			$query->execute(array('username' => $username, 'password' => $password));
			$row = $query->fetch();

			if($row){
				return new User(array(
					'id' => $row['id'],
					'usergroup_id' => $row['usergroup_id'],
					'username' => $row['username'],
					'password' => $row['password'],
					'email' => $row['email'],
					'show_email' => $row['show_email'],
					'registered' => $row['registered'],
					'avatar' => $row['avatar'],
					'info' => $row['info']
				));	
			}else{
				return null;
			}
		}

		public function save() {
			$query = DB::connection()->prepare('INSERT INTO Member (usergroup_id, username, password, email, show_email, registered) '.
				'VALUES (1, :username, :password, :email, true, CURRENT_TIMESTAMP) RETURNING id');

			$query->execute(array(
				'username' => $this->username, 
				'password' => $this->password, 
				'email' => $this->email
			));

			$row = $query->fetch();

			return $row['id'];
		}

		public static function username_exists($username) {
			$query = DB::connection()->prepare('SELECT * FROM Member WHERE UPPER(username) = UPPER(:username) LIMIT 1');
			$query->execute(array('username' => $username));
			$row = $query->fetch();

			if ($row) {
				return true;
			}else {
				return false;
			}
		}

	}