<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Services\admin\AliasService;
use App\Services\admin\CacheService;
use App\Services\CategoriesMenuService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


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
        $id = $request->get('id');
        $category = Category::find($id);

        if ($category) {
            abort(404);
        }

        $childs = $category->childs();

        $errors = '';
        if ($childs->count() > 0) {
            $errors .= 'Вы не можете удалить категорию, которая содержит другие категории';
        }

        $products = $category->products();
        if ($products->count() > 0) {
            $errors .= 'Вы не можете удалить категорию, которая содержит товары';
        }

        if ($errors) {
            return redirect()->route('admin.category.index')->withErrors($errors);
        }

        $category->delete();
        CacheService::forgetGroup("Категории");
        return redirect()->route('admin.category.index')->with(["success" => "Категория удалена"]);
    }

    public function edit(Category $category) {
        $categoriesMenuService = new CategoriesMenuService(
            ['tpl' => 'templates.adminCategoriesMenu_tpl',
                'tpl' => 'templates.adminSelectCategory_tpl',
                'container' => 'select',
                'cachekey' => 'admin_select',
                'class' => 'form-control',
                'prepend' => '<option value="0">Самостоятельная категория</option>',
                'cache' => 0,
                "attrs" => ["name"=>"parent_id"]],

            ["parent_id" => $category->parent_id,
                'currentId' => $category->id]);
        $category_menu = $categoriesMenuService->get();

        return view('admin.category.edit', compact('category', 'category_menu'));
    }

    public function update(Category $category, Request $request) {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'parent_id' => "required",
            'keywords' => 'string|max:255',
            'description' => 'string|max:255'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        if ($category->title != $request->get('title')) {
            $alias = AliasService::createAlias('category', 'alias', $request->get('title'), $category->id);
        } else {
            $alias = $category->alias;
        }

        $category->title = $request->get('title');
        $category->parent_id = $request->get('parent_id');
        $category->keywords = $request->get('keywords');
        $category->description = $request->get('description');
        $category->alias = $alias;

        $category->save();

        CacheService::forgetGroup("Категории");
        return redirect()->route('admin.category.edit', ['category' => $category->id])->with('success', 'Категория отредактирована');
    }


    /* public function deleteAction()

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
     }*/
}
