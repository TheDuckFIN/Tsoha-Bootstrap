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
			$threads = Thread::find_all_by_board($id);
			$starter = array();
			$postcount = array();
			$lastmsg = array();

			foreach ($threads as $thread) {
				$starter[$thread->id] = Member::find($thread->starter_id);
				$postcount[$thread->id] = Thread::postcount($thread->id);
				$lastmsg[$thread->id] = Message::last_message_by_thread_id($thread->id);
			}

			if ($threads == NULL) {
				$empty = true;
			}else {
				$empty = false;
			}

			View::make('board/show.html', array(
				'board' => $board, 
				'threads' => $threads, 
				'empty' => $empty, 
				'postcount' => $postcount,
				'starter' => $starter,
				'lastmsg' => $lastmsg
			));
		}

	}