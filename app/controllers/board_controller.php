<?php
	
	class BoardController extends BaseController {

		public static function index() {
			$categories = Category::all();
			$boards = Board::all();

			View::make('board/index.html', array('categories' => $categories, 'boards' => $boards));
		}

		public static function show($id) {
			$board = Board::find($id);
			$threads = Thread::find_all_by_board($id);
			$starter = array();
			$postcount = array();

			foreach ($threads as $thread) {
				$starter[$thread->id] = Member::find($thread->starter_id);
				$postcount[$thread->id] = Thread::postcount($thread->id);
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
				'starter' => $starter
			));
		}

	}