<?php

namespace App\Services;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class CategoriesMenuService {

    protected $data;
    protected $tree;
    protected $menuHtml;
    protected $tpl = 'templates.menu_tpl';
    protected $container = 'ul';
    protected $class = 'menu';
    protected $table = 'category';
    protected $cache = 3600;
    protected $cachekey = 'ishop_menu';
    protected $attrs = [];
    protected $prepend;

    public function __construct($options = []) {
        $this->prepend = "<li> <a href=\"". route('catalog.index') . "\">Все товары</a>      </li>";
        $this->getOptions($options);
        $this->run();
    }

    public function getOptions($options) {
        foreach ($options as $key => $v) {
            if (property_exists($this, $key)) {
                $this->$key = $v;
            }
        }
    }

    public function run() {
        $this->menuHtml = Cache::get($this->cachekey);
        if (!$this->menuHtml) {
            $this->data = Cache::get('cats');
            if (!$this->data) {
                $this->data = DB::table($this->table)->get()->keyBy('id')->toArray();
            }
            $this->tree = $this->getTree();
            $this->menuHtml = $this->getMenuHtml($this->tree);
            if ($this->cache) {
                Cache::put($this->cachekey, $this->menuHtml, $this->cache);
            }
        }
    }

    public function get() {
        $attrs = '';
        if (!empty($this->attrs)) {
            foreach ($this->attrs as $key => $v) {
                $attrs .= " $key=$v";
            }
        }

        return "<{$this->container} class='{$this->class}' $attrs>\n".
                $this->prepend."\n".
                $this->menuHtml."\n".
                "</{$this->container}>";
    }

    protected function getTree() {
        $tree = [];
        $data = $this->data;
        foreach ($data as $id => &$node) {
            if (!$node->parent_id) {
                $tree[$id] = &$node;
            } else {
                $data[$node->parent_id]->childs[$id] = &$node;
            }
        }
        return $tree;
    }

    protected function getMenuHtml($tree, $tab = '') {
        $str = '';
        foreach ($tree as $id => $category) {
            $str .= $this->catToTemplate($category, $tab, $id);
        }

        return $str;
    }

    protected function catToTemplate($category, $tab, $id) {
        return view($this->tpl, compact('category', 'tab', 'id'))->render();
    }
}
