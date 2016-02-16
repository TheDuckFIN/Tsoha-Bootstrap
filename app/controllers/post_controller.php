<?php
	
	class PostController extends BaseController {

		public static function index() {
			View::make('post/index.html');
		}

		public static function create($id) {
			parent::check_logged_in();

			$thread = Thread::find($id);
			$board = Board::find($thread->board_id);

			View::make('post/new.html', array(
				'thread' => $thread,
				'board' => $board
			));
		}

		public static function store() {
			parent::check_logged_in();

			$params = $_POST;

			$message = new Message(array(
				'sender_id' => parent::get_user_logged_in()->id, 
				'thread_id' => $params['thread'],
				'message' => $params['message']
			));

			$message->save();

			Redirect::to('/thread/' . $message->thread_id, array('alert_msg' => 'Viesti lähetetty onnistuneesti!'));
		}

		public static function edit($id) {
			parent::check_logged_in();

			$message = Message::find($id);
			$thread = Thread::find($message->thread_id);
			$board = Board::find($thread->board_id);

			View::make('post/edit.html', array(
				'thread' => $thread,
				'board' => $board,
				'message' => $message
			));
		}

		public static function update() {
			parent::check_logged_in();

			$params = $_POST;

			$message = Message::find($params['msg_id']);
			$message->message = $params['message'];
			$message->update();

			Redirect::to('/thread/' . $message->thread_id, array('alert_msg' => 'Muokkaukset tallennettu!'));
		}

		public static function delete($id) {
			parent::check_logged_in();

			$message = Message::find($id);

			if ($message == NULL) {
				View::make('post/index.html');
			}else {
				$message->delete();
				Redirect::to('/thread/' . $message->thread_id, array('alert_msg' => 'Viesti poistettu onnistuneesti!'));
			}
		}

	}