<?php
	
	class ThreadController extends BaseController {

		public static function index() {
			View::make('thread/index.html');
		}

		public static function show($id) {
			$thread = Thread::find($id);
			$board = Board::find($thread->board_id);
			$messages = Message::all_by_thread_id($id);
			$sender = array();

			foreach ($messages as $msg) {
				$sender[$msg->id] = Member::find($msg->sender_id);
			}


			View::make('thread/show.html', array(
				'thread' => $thread,
				'board' => $board,
				'messages' => $messages,
				'sender' => $sender
			));
		}

		public static function create($id) {
			View::make('thread/index.html');
		}

	}