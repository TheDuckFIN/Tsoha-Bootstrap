<?php
    
    class CategoryController extends BaseController {

        public static function save() {
            parent::check_logged_in();

            if (parent::has_permission('boardmanagement')) {
                $params = $_POST

                $category = new Category(array('name' => $params['name']));
                $valid = $category->validate();

                if ($valid === true) {
                    $category->save();
                    Redirect::to('/settings/arrangement/', array('message' => 'Kategoria luotu onnistuneesti!', 'style' => 'success'));
                }else {
                    Redirect::to('/settings/arrangement/', array('message' => $valid, 'style' => 'danger'));
                }
            }else {
                parent::throw_error('Sinulla ei ole oikeuksia hallintapaneeliin!');
            }
        }
        
    }