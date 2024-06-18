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
        $categoriesMenuService = new CategoriesMenuService(['tpl' => 'admin.templates.adminCategoriesMenu_tpl',
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

        if (!$category) {
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
            ['tpl' => 'admin.templates.adminSelectCategory_tpl',
                'container' => 'select',
                'cachekey' => 'admin_select',
                'class' => 'form-control',
                'prepend' => '<option value="0">Самостоятельная категория</option>',
                'cache' => 0,
                "attrs" => ["name" => "parent_id"]],

            ["parent_id" => $category->parent_id,
                'currentId' => $category->id]);
        $category_menu = $categoriesMenuService->get();

        return view('admin.category.edit', compact('category', 'category_menu'));
    }

    public function update(Category $category, Request $request) {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'parent_id' => "required",
            'keywords' => 'nullable|string|max:255',
            'description' => 'nullable|string|max:255'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        if ($category->title != $request->get('title')) {
            $alias = AliasService::createAlias('category', 'alias', $request->get('title'));
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

    public function create() {
        $categoriesMenuService = new CategoriesMenuService(
            ['tpl' => 'templates.adminSelectCategory_tpl',
                'container' => 'select',
                'cachekey' => 'admin_select',
                'class' => 'form-control',
                'prepend' => '<option value="0">Самостоятельная категория</option>',
                'cache' => 0,
                "attrs" => ["name" => "parent_id"]]);
        $category_menu = $categoriesMenuService->get();

        return view('admin.category.create', compact('category_menu'));
    }

    public function store(Request $request) {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'parent_id' => "required",
            'keywords' => 'nullable|string|max:255',
            'description' => 'nullable|string|max:255'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $category = Category::create([
            'title' => $request->get('title'),
            'parent_id' => $request->get('parent_id'),
            'keywords' => $request->get('keywords'),
            'description' => $request->get('description'),
            'alias' => AliasService::createAlias('category', 'alias', $request->get('title'))
        ]);


        if ($category) {
            CacheService::forgetGroup("Категории");
            return redirect()->route('admin.category.index')->with('success', "Категория успешно добавлена");
        }

        return redirect()->route('admin.category.index')
            ->withErrors("Произошла ошибка при создании категории")
            ->withInput();
    }
}
