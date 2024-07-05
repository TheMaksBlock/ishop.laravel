<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Services\admin\AliasService;
use App\Services\admin\ImageService;
use App\Services\CategoriesMenuService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;

class ProductsController extends Controller {
    private $imageService;
    private $perpage = 10;

    public function __construct(ImageService $imageService) {
        $this->imageService = $imageService;
    }

    public function index() {
        $products = Product::with('category')->orderBy('title')->paginate($this->perpage);
        return view('admin.products.index', compact('products'));
    }

    public function create() {
        $this->imageService->clear();

        $categoriesMenuService = new CategoriesMenuService(
            ['tpl' => 'admin.templates.adminSelectCategory_tpl',
                'container' => 'select',
                'cachekey' => 'product_category',
                'class' => 'form-control',
                'prepend' => '<option>Выберите категорию</option>',
                "attrs" => ["name" => "category_id"]]);

        $category_menu = $categoriesMenuService->get();

        return view('admin.products.create', compact('category_menu'));
    }

    public function store(Request $request) {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'category_id' => 'required|exists:category,id',
            'keywords' => 'nullable|string|max:255',
            'description' => 'nullable|string|max:255',
            'price' => 'required|numeric',
            'old_price' => 'nullable|numeric',
            'content' => 'nullable|string',
            'related' => 'nullable|array',
            'related.*' => 'exists:products,id',
            'single' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'multi.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $product = new Product();
        $product->title = $request->input('title');
        $product->category_id = $request->input('category_id');
        $product->keywords = $request->input('keywords');
        $product->description = $request->input('description');
        $product->price = $request->input('price');
        $product->old_price = $request->input('old_price')??0;
        $product->content = $request->input('content');
        $product->status = $request->has('status')?'1':'0';
        $product->hit = $request->has('hit')?'1':'0';
        $product->alias = AliasService::createAlias('product', 'alias', $request->get('title'));
        $product->save();

        $this->imageService->insetrGalery($product->id);
        return redirect()->route('admin.products.index')->with('success', 'Товар успешно добавлен');
    }

    public function addImage(Request $request){
        if($name = $request->get('name')){
            if($name){
                $params = Config::get('params.single');
            }else{
                $params = Config::get('params.multi');
            }
            $wmax = $params['width'];
            $hmax = $params['height'];

            return  $this->imageService->uploadImg($name, $wmax, $hmax,$request->file($name));
        }
        return Response::json(['error' => 'Ошибка загрузки файла!'], 400);
    }
}
