<?php
    
    class EditController extends BaseController {

        public static function show($id) {
            $message = Message::find($id);

            if (!$message) {
                parent::throw_error('Virheellinen viestin ID!');
            }

            $thread = Thread::find($message->thread_id);
            $board = Board::find($thread->board_id);
            $edits = Edit::all_by_msg($id);
            $groups = Usergroup::all();
            $users = User::all();

            View::make('edit/show.html', array(
                'msg' => $message, 
                'thread' => $thread,
                'board' => $board,
                'user' => $users,
                'group' => $groups,
                'edits' => $edits
            ));
        }

    }