<?php
	
	class User extends BaseModel {

		public $id, $usergroup_id, $username, $password, $email, $show_email, $avatar, $description, $registered;

		public function __construct($attributes) {
			parent::__construct($attributes);
		}

		public static function validate($username, $password, $password2, $email, $description) {
			$v = new Valitron\Validator(array(
				'Käyttäjätunnus' => $username,
				'Salasana' => $password,
				'Salasana uudestaan' => $password2,
				'Email' => $email,
				'Kuvaus' => $description
			));

			if (isset($username)) {
				$v->rule('required', 'Käyttäjätunnus');
				$v->rule('lengthMin', 'Käyttäjätunnus', 3);
				$v->rule('lengthMax', 'Käyttäjätunnus', 20);
				$v->rule('regex', 'Käyttäjätunnus', '/^(?![_.])(?!.*[_.]{2})[a-zA-Z0-9._ÄäÅåÖö]+(?<![_.])$/');
			} 

			if (isset($password)) {
				$v->rule('required', 'Salasana');
				$v->rule('required', 'Salasana uudestaan');
				$v->rule('equals', 'Salasana', 'Salasana uudestaan');
				$v->rule('lengthMin', 'Salasana', 8);
			}

			if (isset($email)) {
				$v->rule('required', 'Email');
				$v->rule('email', 'Email');
			}

			if (isset($description)) {
				$v->rule('lengthMax', 'Kuvaus', 400);
			}

			$v->validate();

			$current_errors = parent::format_errors($v->errors());

			if (isset($username) && self::username_exists($username)) {
				$current_errors[] = 'Käyttäjätunnus on jo olemassa, valitse jokin toinen';
			}

			if (empty($current_errors)) {
				return true;
			}else {
				return $current_errors;
			}
		}

		public static function find($id) {
			if (!parent::valid_int($id)) return null;

			$query = DB::connection()->prepare('SELECT * FROM Member WHERE id = :id LIMIT 1');
			$query->execute(array('id' => $id));

			$row = $query->fetch();
			
			if ($row) {
				$time = date_create($row['registered']);

				$user = new User(array(
					'id' => $row['id'],
					'usergroup_id' => $row['usergroup_id'],
					'username' => $row['username'],
					'password' => $row['password'],
					'email' => $row['email'],
					'show_email' => $row['show_email'],
					'registered' => date_format($time, "d.m.Y H:i:s"),
					'avatar' => $row['avatar'],
					'description' => $row['description']
				));	

				return $user;
			}

			return null;
		}

		public static function all() {
			$query = DB::connection()->prepare('SELECT * FROM Member ORDER BY id');
			$query->execute();

			$rows = $query->fetchAll();
			$users = array();

			foreach ($rows as $row) {
				$time = date_create($row['registered']);
				
				$users[$row['id']] = new User(array(
					'id' => $row['id'],
					'usergroup_id' => $row['usergroup_id'],
					'username' => $row['username'],
					'password' => $row['password'],
					'email' => $row['email'],
					'show_email' => $row['show_email'],
					'registered' => date_format($time, "d.m.Y H:i:s"),
					'avatar' => $row['avatar'],
					'description' => $row['description']
				));	
			}

			return $users;
		}

		public function postcount() {
			$query = DB::connection()->prepare('SELECT COUNT(*) AS posts FROM Message WHERE sender_id = :id');
			$query->execute(array('id' => $this->id));

			$result = $query->fetch();

			if ($result) {
				return $result['posts'];
			}else {
				return null;
			}
		}

		public static function authenticate($username, $password) {
			$query = DB::connection()->prepare('SELECT * FROM Member WHERE UPPER(username) = UPPER(:username) LIMIT 1');
			$query->execute(array('username' => $username));
			$row = $query->fetch();

			if($row){
				if ($row['password'] === crypt($password, $row['password'])) {				
					return new User(array(
						'id' => $row['id'],
						'usergroup_id' => $row['usergroup_id'],
						'username' => $row['username'],
						'password' => $row['password'],
						'email' => $row['email'],
						'show_email' => $row['show_email'],
						'registered' => $row['registered'],
						'avatar' => $row['avatar'],
						'description' => $row['description']
					));	
				}else {
					return null;
				}
			}else{
				return null;
			}
		}

		public function update() {
			if (!parent::valid_int($this->usergroup_id)) return null;
			if (Usergroup::find($this->usergroup_id) === null) return null;

			$query = DB::connection()->prepare('UPDATE Member 
				SET show_email = :show_email, 
					email = :email, 
					description = :description,
					usergroup_id = :group 
				WHERE id = :id');

			$query->bindValue(':show_email', $this->show_email, PDO::PARAM_BOOL);
			$query->bindValue(':email', $this->email, PDO::PARAM_STR);
			$query->bindValue(':description', $this->description, PDO::PARAM_STR);
			$query->bindValue(':group', $this->usergroup_id, PDO::PARAM_INT);
			$query->bindValue(':id', $this->id, PDO::PARAM_INT);

			$query->execute();

			return true;
		}

		public function update_password() {
			$query = DB::connection()->prepare('UPDATE Member SET password = :password WHERE id = :id');
			$query->execute(array('password' => crypt($this->password), 'id' => $this->id));
		}

		public function save() {
			$query = DB::connection()->prepare('INSERT INTO Member (usergroup_id, username, password, email, show_email, registered) 
				VALUES (1, :username, :password, :email, true, CURRENT_TIMESTAMP) RETURNING id');

			$query->execute(array(
				'username' => $this->username, 
				'password' => crypt($this->password), 
				'email' => $this->email
			));

			$row = $query->fetch();

			return $row['id'];
		}

		public function delete() {
			$query = DB::connection()->prepare('UPDATE Thread SET starter_id = null WHERE starter_id = :id');
			$query->execute(array('id' => $this->id));

			$query = DB::connection()->prepare('UPDATE Message SET sender_id = null WHERE sender_id = :id');
			$query->execute(array('id' => $this->id));

			$query = DB::connection()->prepare('UPDATE Edit SET editor_id = null WHERE editor_id = :id');
			$query->execute(array('id' => $this->id));

			$query = DB::connection()->prepare('DELETE FROM Member_achievement WHERE member_id = :id');
			$query->execute(array('id' => $this->id));

			$query = DB::connection()->prepare('DELETE FROM Member WHERE id = :id');
			$query->execute(array('id' => $this->id));
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