<?php

    class UsergroupController extends BaseController {

        public static function index() {
            $usergroups = Usergroup::all();
            $single = Usergroup::find(2);
            $permissions = $single->permissions();

            Kint::dump($usergroups);
            Kint::dump($single);
            Kint::dump($permissions);

            echo 'Delete thread: ' . var_dump($single->checkPermission('delete_thread')) . '<br>';
            echo 'User management: ' . var_dump($single->checkPermission('usermanagement')) . '<br>';
            echo 'Wrong: ' . var_dump($single->checkPermission('wrong')) . '<br>';
        }

    }