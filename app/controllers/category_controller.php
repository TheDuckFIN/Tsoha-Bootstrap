<?php
    
    class CategoryController extends BaseController {

        public static function save() {
            parent::check_logged_in();

            if (parent::has_permission('boardmanagement')) {
                $params = $_POST;

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

        public static function update() {
            parent::check_logged_in();

            if (parent::has_permission('boardmanagement')) {
                $params = $_POST;

                $category = Category::find($params['category_id']);

                if (!$category) {
                    parent::throw_error('Kategorian ID virheellinen!');
                }

                $category->name = $params['name'];
                $valid = $category->validate();

                if ($valid === true) {
                    $category->update();
                    Redirect::to('/settings/arrangement/', array('message' => 'Kategoria päivitetty onnistuneesti!', 'style' => 'success'));
                }else {
                    Redirect::to('/settings/arrangement/', array('message' => $valid, 'style' => 'danger'));
                }
            }else {
                parent::throw_error('Sinulla ei ole oikeuksia hallintapaneeliin!');
            }
        }

        public static function delete($id) {
            parent::check_logged_in();

            if (parent::has_permission('boardmanagement')) {
                $category = Category::find($id);

                if (!$category) {
                    parent::throw_error('Kategorian ID virheellinen!');
                }else {
                    $category->delete();
                    Redirect::to('/settings/arrangement/', array('message' => 'Kategoria poistettu onnistuneesti!', 'style' => 'success'));
                }
            }else {
                parent::throw_error('Sinulla ei ole oikeuksia hallintapaneeliin!');
            }
        }
        
    }