<?php

	class UserController extends BaseController {
		public static function index() {
			//käyttäjälistaus?
			echo 'WIP';
		}

		public static function show($id) {
			$user = User::find($id);
			$group = Usergroup::find($user->usergroup_id);

			View::make("user/show.html", array('user' => $user, 'group' => $group));
		}

		public static function logout() {
			$_SESSION['user'] = null;
			Redirect::to('/', array('message' => 'Kirjauduttu ulos onnistuneesti!', 'style' => 'success'));
		}

		public static function login() {
			$user = parent::get_user_logged_in();

			if ($user) {
				Redirect::to('/', array('message' => 'Olet jo kirjautuneena sisään, ' . $user->username . '! Kirjaudu ulos jos haluat kirjautua toiselle käyttäjätunnukselle!', 'style' => 'danger'));
			}else {
				View::make("user/login.html");
			}
		}

		public static function handle_login() {
			$params = $_POST;

			$user = User::authenticate($params['username'], $params['password']);

			if (!$user) {
				View::make('user/login.html', array('error' => 'Väärä käyttäjätunnus tai salasana!', 'username' => $params['username']));
			}else {
				$_SESSION['user'] = $user->id;

				Redirect::to('/', array('message' => 'Tervetuloa takaisin ' . $user->username . '!', 'style' => 'success'));
			}
		}

		public static function register() {
			if (parent::get_user_logged_in()) {
				Redirect::to('/', array('message' => 'Kirjaudu ulos luodaksesi uuden käyttäjätunnuksen!', 'style' => 'danger'));
			}else {
				View::make("user/register.html");
			}
		}

		public static function handle_register() {
			$params = $_POST;
			$valid = User::validateRegister($params['username'], $params['password'], $params['password_confirmation'], $params['email']);

			if (!is_array($valid)) {
				$user = new User(array(
					'username' => $params['username'],
					'password' => $params['password'],
					'email' => $params['email']
				));

				$id = $user->save();

				//kirjaudu automaattisesti sisään
				$_SESSION['user'] = $id;
				//ja ohjaa omaan profiiliin
				Redirect::to('/profile/' . $id, array('message' => 'Käyttäjä luotu onnistuneesti! Tässä uusi profiilisi, voit nyt muokata vapaasti asetuksiasi ja aloittaa keskustelupalstn käytön!'));
			}else {
				View::make('user/register.html', array('errors' => $valid, 'username' => $params['username'], 'email' => $params['email']));
			}
		}
	}