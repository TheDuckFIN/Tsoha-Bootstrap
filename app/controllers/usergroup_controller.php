<?php

    class UsergroupController extends BaseController {

        public static function edit($id) {
            parent::check_permission('usergroupmanagement');

            $usergroup = Usergroup::find($id);

            if (!$usergroup) {
                parent::throw_error("Käyttäjäryhmän ID virheellinen!");
            }else {
                $permissions = Permission::find($id);

                View::make("usergroup/edit.html", array('group' => $usergroup, 'group_perm' => $permissions)); 
            }
        }

        public static function update() {
            parent::check_permission('usergroupmanagement');

            $params = $_POST;

            $usergroup = Usergroup::find($params['group_id']);

            if (!$usergroup) {
                parent::throw_error("Käyttäjäryhmän ID virheellinen!");
            }else {
                $usergroup->name = $params['name'];
                $usergroup->color = $params['color'];

                $permissions = Permission::find($usergroup->id);

                $permissions->delete_thread = isset($params['delete_thread']);
                $permissions->delete_message = isset($params['delete_message']);
                $permissions->edit_message = isset($params['edit_message']);
                $permissions->lock_thread = isset($params['lock_thread']);
                $permissions->ban = isset($params['ban']);
                $permissions->boardmanagement = isset($params['boardmanagement']);
                $permissions->usergroupmanagement = isset($params['usergroupmanagement']);
                $permissions->settingsmanagement = isset($params['settingsmanagement']);
                $permissions->usermanagement = isset($params['usermanagement']);
                
                $valid = $usergroup->validate();

                if ($valid === true) {
                    $usergroup->update();

                    $permissions->update();

                    Redirect::to('/settings/usergroups/', array('message' => 'Muokkaukset tallennettu onnistuneesti!', 'style' => 'success'));
                }else {
                    View::make("usergroup/edit.html", array('errors' => $valid, 'group' => $usergroup, 'group_perm' => $permissions));
                }

            }
        }

        public static function create() {
            parent::check_permission('usergroupmanagement');

            View::make("usergroup/new.html"); 
        }

        public static function save() {
            parent::check_permission('usergroupmanagement');

            $params = $_POST;

            $usergroup = new Usergroup(array(
                'name' => $params['name'],
                'color' => $params['color'],
                'locked' => false
            ));

            $permissions = new Permission(array(
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

            $valid = $usergroup->validate();

            if ($valid === true) {
                $permissions->usergroup_id = $usergroup->save();

                $permissions->save();

                Redirect::to('/settings/usergroups/', array('message' => 'Käyttäjäryhmä luotu onnistuneesti!', 'style' => 'success'));
            }else {
                View::make('usergroup/new.html', array('errors' => $valid, 'group' => $usergroup, 'group_perm' => $permissions));
            }
        }

        public static function delete($id) {
            parent::check_permission('usergroupmanagement');

            $usergroup = Usergroup::find($id);

            if (!$usergroup) {
                parent::throw_error("Käyttäjäryhmän ID virheellinen!");
            }else {
                $usergroup->delete();
                Redirect::to('/settings/usergroups/', array('message' => 'Käyttäjäryhmä poistettu onnistuneesti!', 'style' => 'success'));
            }
        }

    }