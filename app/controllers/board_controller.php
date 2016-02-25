<?php
	
	class BoardController extends BaseController {

		public static function index() {
			$categories = Category::all();
			$boards = Board::all();
			$lastmsg = array();

			foreach ($boards as $board) {
				$lastmsg[$board->id] = Message::last_message_by_board_id($board->id);
			}

			View::make('board/index.html', array(
				'categories' => $categories, 
				'boards' => $boards,
				'lastmsg' => $lastmsg
			));
		}

		public static function show($id) {
			$board = Board::find($id);

			if (!$board) {
				parent::throw_error('Keskustelualueen ID virheellinen!');
			}

			$threads = Thread::find_all_by_board($id);
			$users = User::all();
			$lastmsg = array();

			foreach ($threads as $thread) {
				$lastmsg[$thread->id] = Message::last_message_by_thread_id($thread->id);
			}

			View::make('board/show.html', array(
				'board' => $board, 
				'threads' => $threads, 
				'user' => $users,
				'lastmsg' => $lastmsg
			));
		}

	}