<?php
	
	class PostController extends BaseController {

		public static function index() {
			View::make('post/index.html');
		}

		public static function create($id) {
			parent::check_logged_in();

			$thread = Thread::find($id);

			if (!$thread) {
				Redirect::to('/', array('message' => 'Keskustelun ID virheellinen!', 'style' => 'danger'));
			}

			$board = Board::find($thread->board_id);

			View::make('post/new.html', array(
				'thread' => $thread,
				'board' => $board
			));
		}

		public static function store() {
			parent::check_logged_in();

			$params = $_POST;

			if (!Thread::find($params['thread'])) {
				Redirect::to('/', array('message' => 'Keskustelun ID virheellinen!', 'style' => 'danger'));
			}

			$message = new Message(array(
				'sender_id' => parent::get_user_logged_in()->id, 
				'thread_id' => $params['thread'],
				'message' => $params['message'],
				'firstpost' => false
			));

			$valid = $message->validate(false);

			if (!is_array($valid)) {
				$message->save();

				Redirect::to('/thread/' . $message->thread_id, array('alert_msg' => 'Viesti lähetetty onnistuneesti!'));		
			}else {
				$thread = Thread::find($params['thread']);
				$board = Board::find($thread->board_id);

				View::make('post/new.html', array(
					'errors' => $valid, 
					'message' => $params['message'], 
					'thread' => $thread,
					'board' => $board
				));
			}
		}

		public static function edit($id) {
			parent::check_logged_in();

			$message = Message::find($id);

			if (!$message) {
				Redirect::to('/', array('message' => 'Viestin ID virheellinen!', 'style' => 'danger'));
			}

			$thread = Thread::find($message->thread_id);
			$board = Board::find($thread->board_id);

			if ((parent::get_user_logged_in()->id == $message->sender_id) || parent::has_permission('edit_message')) {
				View::make('post/edit.html', array(
					'thread' => $thread,
					'board' => $board,
					'message' => $message
				));
			}else {
				Redirect::to('/', array('message' => 'Sinulla ei ole oikeuksia muokata tätä viestiä! Älä yritä huijata :(', 'style' => 'danger'));
			}
		}

		public static function update() {
			parent::check_logged_in();

			$params = $_POST;

			$message = Message::find($params['msg_id']);

			if (!$message) {
				Redirect::to('/', array('message' => 'Viestin ID virheellinen!', 'style' => 'danger'));
			}

			$message->message = $params['message'];

			if ((parent::get_user_logged_in()->id == $message->sender_id) || parent::has_permission('edit_message')) {
				$valid = $message->validate(false);

				if (!is_array($valid)) {
					$message->update();

					Redirect::to('/thread/' . $message->thread_id, array('alert_msg' => 'Muokkaukset tallennettu!'));
				}else {
					$thread = Thread::find($message->thread_id);
					$board = Board::find($thread->board_id);

					View::make('post/edit.html', array(
						'errors' => $valid, 
						'message' => $message, 
						'thread' => $thread,
						'board' => $board
					));
				}
			}else {
				Redirect::to('/', array('message' => 'Sinulla ei ole oikeuksia muokata tätä viestiä! Älä yritä huijata :(', 'style' => 'danger'));
			}
		}

		public static function delete($id) {
			parent::check_logged_in();

			$message = Message::find($id);

			if ($message == NULL) {
				Redirect::to('/', array('message' => 'Viestin ID virheellinen!', 'style' => 'danger'));
			}elseif ($message->firstpost) {
				Redirect::to('/', array('message' => 'Et voi poistaa keskstelun ensimmäistä viestiä! Älä yritä huijata :(', 'style' => 'danger'));
			}else {
				if (parent::has_permission('delete_message')) {
					$message->delete();
					Redirect::to('/thread/' . $message->thread_id, array('alert_msg' => 'Viesti poistettu onnistuneesti!'));
				}else {
					Redirect::to('/', array('message' => 'Sinulla ei ole oikeuksia poistaa viestejä! Älä yritä huijata :(', 'style' => 'danger'));
				}
			}
		}

	}