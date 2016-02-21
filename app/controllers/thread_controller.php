<?php
	
	class ThreadController extends BaseController {

		public static function index() {
			View::make('thread/index.html');
		}

		public static function show($id) {
			$thread = Thread::find($id);
			$board = Board::find($thread->board_id);
			$messages = Message::all_by_thread_id($id);
			$sender_info = array();

			foreach ($messages as $msg) {
				$user = User::find($msg->sender_id);

				$sender_info[$msg->id] = array(
					'user' => $user,
					'usergroup' => Usergroup::find($user->usergroup_id)
				);
			}

			View::make('thread/show.html', array(
				'thread' => $thread,
				'board' => $board,
				'messages' => $messages,
				'sender_info' => $sender_info
			));
		}

		public static function create($id) {
			parent::check_logged_in();

			$board = Board::find($id);

			View::make('thread/new.html', array('board' => $board));
		}

		public static function store() {
			parent::check_logged_in();

			$params = $_POST;

			$thread = new Thread(array(
				'board_id' => $params['board_id'],
				'starter_id' => parent::get_user_logged_in()->id,
				'title' => $params['title']	
			));

			$thread_id = $thread->save();

			$message = new Message(array(
				'sender_id' => parent::get_user_logged_in()->id, 
				'thread_id' => $thread_id,
				'message' => $params['message'],
				'firstpost' => true
			));

			$message->save();

			Redirect::to('/thread/' . $thread_id, array('alert_msg' => 'Keskustelu luotu onnistuneesti!'));
		}

	}