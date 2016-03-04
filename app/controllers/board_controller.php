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

        public static function edit($id) {
            parent::check_permission('boardmanagement');

            $board = Board::find($id);

            if (!$board) {
                parent::throw_error('Keskustelualueen ID virheellinen!');
            }else {
                View::make('board/edit.html', array('board' => $board));
            }
        }

        public static function update() {
            parent::check_permission('boardmanagement');

            $params = $_POST;

            $board = Board::find($params['board_id']);

            if (!$board) {
            	parent::throw_error('Keskustelualueen ID virheellinen');
            }

            $board->name = $params['name'];
            $board->description = $params['description'];

            $valid = $board->validate();

            if ($valid === true) {
                $board->update();
                Redirect::to('/settings/arrangement/', array('message' => 'Keskustelualue päivitetty onnistuneesti!', 'style' => 'success'));
            }else {
                Redirect::to('/settings/arrangement/board/edit/' . $board->id, array('errors' => $valid));
            }
        }

        public static function create($id) {
            parent::check_permission('boardmanagement');

            $category = Category::find($id);

            if (!$category) {
                parent::throw_error('Kategorian ID virheellinen!');
            }else {
                View::make('board/new.html', array('category' => $category));
            }
        }

        public static function save() {
            parent::check_permission('boardmanagement');
                
            $params = $_POST;

            if (!Category::find($params['category_id'])) {
            	parent::throw_error('Kategorian ID virheellinen');
            }

            $board = new Board(array(
            	'name' => $params['name'],
            	'description' => $params['description'],
            	'category_id' => $params['category_id']
        	));

            $valid = $board->validate();

            if ($valid === true) {
                $board->save();
                Redirect::to('/settings/arrangement/', array('message' => 'Keskustelualue luotu onnistuneesti!', 'style' => 'success'));
            }else {
                Redirect::to('/settings/arrangement/board/new/' . $board->category_id, array('errors' => $valid, 'name' => $params['name'], 'description' => $params['description']));
            }
        }

        public static function delete($id) {
            parent::check_permission('boardmanagement');

            $board = Board::find($id);

            if (!$board) {
                parent::throw_error('Keskustelualueen ID virheellinen!');
            }else {
                $board->delete();
                Redirect::to('/settings/arrangement/', array('message' => 'Keskustelualue poistettu onnistuneesti!', 'style' => 'success'));
            }
        }

	}