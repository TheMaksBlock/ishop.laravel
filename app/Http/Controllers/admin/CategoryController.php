<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Services\CategoriesMenuService;
use Illuminate\Http\Request;


class CategoryController extends Controller {

    public function __construct() {

    }

    public function index() {
        $categoriesMenuService = new CategoriesMenuService(['tpl' => 'templates.adminCategoriesMenu_tpl',
            "prepend" => "",
            'class' => 'list-group list-group-root well',
            'container' => 'div',
            'cachekey' => 'admin_cat']);
        $category_menu = $categoriesMenuService->get();
        return view('admin.category.index', compact('category_menu'));
    }

    public function delete(Request $request) {

    }

    public function edit() {

    }


    /* public function deleteAction()
     {
         $id = $this->getID();

         $childs = R::count('category', 'parent_id = ?',[$id]);

         $errors = '';

         if($childs){
             $errors .= '<li>Вы не можете удалить категорию, которая содержит другие категории</li>';
         }

         $products = R::count('product', 'category_id = ?',[$id]);

         if($products){
             $errors .= '<li>Вы не можете удалить категорию, которая содержит товары</li>';
         }

         if($errors){
             $_SESSION['error'] = "<ul>".$errors."</ul>";
             redirect();
         }

         $category = R::load('category', $id);
         R::trash($category);

         $_SESSION['success'] = 'Категория удалена';
         redirect();
     }

     public function addAction(){
         if(!empty($_POST))
         {
             $categrory = new Category();
             $data = $_POST;
             $categrory->load($data);

             if(!$categrory->validate($data)){
                 $categrory->getErrors();
                 redirect();
             }
             if($id = $categrory->save('category')){
                 $alias = AppModel::createAlias('category', 'alias', $data['title'], $id);
                 $cat = R::load('category', $id);
                 $cat->alias = $alias;
                 R::store($cat);
                 $_SESSION['success'] = 'Категория добавлена';

             }
             redirect();
         }
         $this->setMeta("Новая категорий");
     }

     public function editAction(){
         if(!empty($_POST)){
             $id = $this->getID(false);

             $categrory = new Category();
             $data = $_POST;

             $categrory->load($data);
             if(!$categrory->validate($data)){
                 $categrory->getErrors();
                 redirect();
             }

             if($categrory->update("category", $id)){
                 $alias = AppModel::createAlias('category', 'alias', $data['title'], $id);
                 $cat = R::load('category', $id);
                 $cat->alias = $alias;
                 R::store($cat);
                 $_SESSION['success'] = 'Категория отредактирована';
             }

             redirect();
         }


         $id = $this->getID();
         $category = R::load('category', $id);
         $this->setMeta("Редактирование категории {$category->title}");
         App::$app->setProperty("parent_id", $category->parent_id );
         $this->set(compact('category'));
     }*/
}
