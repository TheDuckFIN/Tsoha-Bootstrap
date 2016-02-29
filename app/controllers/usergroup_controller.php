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

        public static function create() {
            parent::check_logged_in();

            if (parent::has_permission('usergroupmanagement')) {
                View::make("usergroup/new.html"); 
            }else {
                parent::throw_error('Sinulla ei ole oikeuksia hallintapaneeliin!');
            }
        }

        public static function save() {
            parent::check_logged_in();

            if (parent::has_permission('usergroupmanagement')) {
                $params = $_POST;

                $usergroup = new Usergroup(array(
                    'name' => $params['name'],
                    'color' => $params['color'],
                    'locked' => false
                ));

                $valid = $usergroup->validate();

                if ($valid === true) {
                    $id = $usergroup->save();

                    $permissions = new Permission(array(
                        'usergroup_id' => $id,
                        'delete_thread' => isset($params['delete_thread']),
                        'delete_message' => isset($params['delete_message']),
                        'edit_message' => isset($params['edit_message']),
                        'lock_thread' => isset($params['lock_thread']),
                        'ban' => isset($params['ban']),
                        'boardmanagement' => isset($params['boardmanagement']),
                        'usergroupmanagement' => isset($params['usergroupmanagement']),
                        'settingsmanagement' => isset($params['settingsmanagement']),
                        'usermanagement' => isset($params['usermanagement'])
                    ));

                    $permissions->save();

                    Redirect::to('/settings/usergroups/', array('message' => 'Käyttäjäryhmä luotu onnistuneesti!', 'style' => 'success'));
                }else {
                    Redirect::to('/settings/usergroups/new', array('errors' => $valid, 'name' => $params['name'], 'color' => $params['color']));
                }


            }else {
                parent::throw_error('Sinulla ei ole oikeuksia hallintapaneeliin!');
            }
        }

        public static function delete($id) {
            
        }

    }