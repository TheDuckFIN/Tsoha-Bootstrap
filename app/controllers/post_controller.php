<?php
	
	class PostController extends BaseController {

		public static function index() {
			View::make('post/index.html');
		}

		public static function create($id) {
			$thread = Thread::find($id);
			$board = Board::find($thread->board_id);

			View::make('post/new.html', array(
				'thread' => $thread,
				'board' => $board
			));
		}

		public static function store() {
			$params = $_POST;

			$message = new Message(array(
				'sender_id' => 2, //KOVAKOODATTU JORMA!!!
				'thread_id' => $params['thread'],
				'message' => $params['message']
			));

			$message->save();

			Redirect::to('/thread/' . $message->thread_id, array('alert_msg' => 'Viesti lähetetty onnistuneesti!'));
		}

		public static function edit($id) {
			$message = Message::find($id);
			$thread = Thread::find($message->thread_id);
			$board = Board::find($thread->board_id);

			View::make('post/edit.html', array(
				'thread' => $thread,
				'board' => $board,
				'message' => $message
			));
		}

		public static function delete($id) {
			$message = Message::find($id);

			if ($message == NULL) {
				View::make('post/index.html');
			}else {
				$message->delete();
				Redirect::to('/thread/' . $message->thread_id, array('alert_msg' => 'Viesti poistettu onnistuneesti!'));
			}
		}

	}