<?php

	class UserController extends BaseController {
		public static function index() {
			$users = User::all();
			$groups = Usergroup::all();

			View::make("user/index.html", array('users' => $users, 'group' => $groups));
		}

		public static function show($id) {
			$user = User::find($id);

			if (!$user) {
				parent::throw_error('Käyttäjän ID virheellinen!');
			}

			$group = Usergroup::find($user->usergroup_id);

			View::make("user/show.html", array('user' => $user, 'group' => $group));
		}

		public static function edit($id) {
			parent::check_logged_in();

			$user = User::find($id);
			$groups = Usergroup::all();

			if (!$user) {
				parent::throw_error('Käyttäjän ID virheellinen!');
			}else {
				if (($user->id === parent::get_user_logged_in()->id) || parent::has_permission('usermanagement')) {
					View::make("user/edit.html", array('user' => $user, 'groups' => $groups));
				}else {
					parent::throw_error('Sinulla ei ole oikeuksia muokata tämän käyttäjän asetuksia!');	
				}
			}
		}

		public static function delete($id) {
            parent::check_logged_in();

            if (parent::has_permission('usermanagement')) {
    			$user = User::find($id);

				if (!$user) {
					parent::throw_error('Käyttäjän ID virheellinen!');
				}else {
					$logged_in_id = parent::get_user_logged_in()->id;

					$user->delete();

					if ($user->id == $logged_in_id) {
						$_SESSION['user'] = null;
	                    Redirect::to('/', array('message' => 'Poistit itsesi onnistuneesti ja samalla kirjauduit ulos! :)', 'style' => 'success'));
					}

                    Redirect::to('/settings/users/', array('message' => 'Käyttäjä poistettu onnistuneesti!', 'style' => 'success'));
				}
            }else {
                parent::throw_error('Sinulla ei ole oikeuksia hallintapaneeliin!');
            }
		}

		public static function update() {
			parent::check_logged_in();

			$params = $_POST;

			$user = User::find($params['user_id']);

			if (!$user) {
				parent::throw_error('Käyttäjän ID virheellinen!');
			}else {
				if (($user->id === parent::get_user_logged_in()->id) || parent::has_permission('usermanagement')) {
					if ($params['which_form'] == 'basic') {
						$valid = User::validate(null, null, null, $params['email'], $params['description']);

						if (!is_array($valid)) {
							$user->description = $params['description'];
							$user->email = $params['email'];
							if (isset($params['show_email'])) {
								$user->show_email = true;
							}else {
								$user->show_email = false;
							}

							$user->update();

							Redirect::to('/user/' . $user->id, array('message' => 'Asetukset tallennettu!'));
						}else {
							Redirect::to('/user/' . $user->id . '/settings', array(
								'errors' => $valid
							));
						}
					}elseif ($params['which_form'] == 'password') {
						$valid = User::validate(null, $params['password'], $params['password_confirmation'], null, null);
						if (!is_array($valid)) {
							$user->password = $params['password'];
							$user->update_password();

							Redirect::to('/user/' . $user->id, array('message' => 'Salasana vaihdettu!'));
						}else {
							Redirect::to('/user/' . $user->id . '/settings', array(
								'errors' => $valid
							));
						}
					}elseif ($params['which_form'] == 'usergroup') {
						if (!parent::has_permission('usermanagement')) {
							parent::throw_error('Sinulla ei ole oikeuksia muokata käyttäjän käyttäjäryhmää!');	
						}else {
							$user->usergroup_id = $params['usergroup'];
							if ($user->update()) {
								Redirect::to('/user/' . $user->id, array('message' => 'Käyttäjäryhmä asetettu!'));
							}else {
								parent::throw_error('Virheellinen käyttäjäryhmän ID!');
							}
						}
					}else {
						echo 'unknown form type';
					}
				}else {
					parent::throw_error('Sinulla ei ole oikeuksia muokata tämän käyttäjän asetuksia!');	
				}
			}
		}

		public static function logout() {
			$_SESSION['user'] = null;
			Redirect::to('/', array('message' => 'Kirjauduttu ulos onnistuneesti!', 'style' => 'success'));
		}

		public static function login() {
			$user = parent::get_user_logged_in();

			if ($user) {
				parent::throw_error('Olet jo kirjautuneena sisään, ' . $user->username . '! Kirjaudu ulos jos haluat kirjautua toiselle käyttäjätunnukselle!');
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
				parent::throw_error('Kirjaudu ulos luodaksesi uuden käyttäjätunnuksen!');
			}else {
				View::make("user/register.html");
			}
		}

		public static function handle_register() {
			$params = $_POST;
			$valid = User::validate($params['username'], $params['password'], $params['password_confirmation'], $params['email'], null);

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
				Redirect::to('/user/' . $id, array('message' => 'Käyttäjä luotu onnistuneesti! Tässä uusi profiilisi, voit nyt muokata vapaasti asetuksiasi ja aloittaa keskustelupalstn käytön!'));
			}else {
				View::make('user/register.html', array('errors' => $valid, 'username' => $params['username'], 'email' => $params['email']));
			}
		}
	}