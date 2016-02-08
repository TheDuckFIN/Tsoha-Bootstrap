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

		public static function edit($id) {
			View::make('post/index.html');
		}

	}