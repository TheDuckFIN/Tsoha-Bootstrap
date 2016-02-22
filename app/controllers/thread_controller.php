<?php
	
	class ThreadController extends BaseController {

		public static function index() {
			Redirect::to('/', array('message' => 'Keskustelun ID virheellinen!', 'style' => 'danger'));
		}

		public static function show($id) {
			$thread = Thread::find((int)$id);
			if (!$thread) {
				Redirect::to('/', array('message' => 'Keskustelun ID virheellinen!', 'style' => 'danger'));
			}

			$board = Board::find($thread->board_id);
			$messages = Message::all_by_thread_id($id);
			$users = array();
			$groups = Usergroup::all();

			foreach ($messages as $msg) {
				$users[$msg->id] = User::find($msg->sender_id);
			}

			View::make('thread/show.html', array(
				'thread' => $thread,
				'board' => $board,
				'messages' => $messages,
				'user' => $users,
				'group' => $groups
			));
		}

		public static function create($id) {
			parent::check_logged_in();

			$board = Board::find((int)$id);
			if (!$board) {
				Redirect::to('/thread/');
			}else {
				View::make('thread/new.html', array('board' => $board));
			}
		}

		public static function store() {
			parent::check_logged_in();

			$params = $_POST;

			if (!Board::find((int)$params['board_id'])) {
				Redirect::to('/', array('message' => 'Keskustelun ID virheellinen!', 'style' => 'danger'));
			}

			$thread = new Thread(array(
				'board_id' => $params['board_id'],
				'starter_id' => parent::get_user_logged_in()->id,
				'title' => $params['title']	
			));

			$thread_valid = $thread->validate();

			if (!is_array($thread_valid)) {			
				$message = new Message(array(
					'sender_id' => parent::get_user_logged_in()->id, 
					'message' => $params['message'],
					'firstpost' => true
				));

				$message_valid = $message->validate(true);

				if (!is_array($message_valid)) {
					$thread_id = $thread->save();
					$message->thread_id = $thread_id;
					$message->save();

					Redirect::to('/thread/' . $thread_id, array('alert_msg' => 'Keskustelu luotu onnistuneesti!'));
				}else {
					$board = Board::find($params['board_id']);

					View::make('thread/new.html', array(
						'errors' => $message_valid, 
						'board' => $board,
						'message' => $params['message'], 
						'title' => $params['title']
					));
				}

			}else {
				$board = Board::find($params['board_id']);

				View::make('thread/new.html', array(
					'errors' => $thread_valid, 
					'board' => $board,
					'message' => $params['message'], 
					'title' => $params['title']
				));
			}
		}

		public static function delete($id) {
			parent::check_logged_in();

			$thread = Thread::find($id);

			if ($thread == NULL) {
				Redirect::to('/', array('message' => 'Keskustelun ID virheellinen!', 'style' => 'danger'));
			}else {
				if (parent::has_permission('delete_thread')) {
					$thread->delete();
					Redirect::to('/board/' . $thread->board_id, array('alert_msg' => 'Keskustelu poistettu onnistuneesti!'));
				}else {
					Redirect::to('/', array('message' => 'Sinulla ei ole oikeuksia poistaa Keskusteluja! Älä yritä huijata :(', 'style' => 'danger'));
				}
			}
		}

	}