<?php

namespace App\Services;

use App\Models\Product;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Builder;
use function PHPUnit\Framework\isEmpty;

class FilterService {
    public $groups;
    public $attrs;
    public string $tpl;

    public function __construct() {
        $this->tpl = "templates.filter_tpl";
        $this->getFilterGroups();
        $this->getFilterAttributes();
    }

    private function getFilterGroups(): void {
        $this->groups = Cache::get('filter_groups');
        if(!$this->groups){
            $this->groups = $this->getGroups();
            Cache::put('filter_groups', $this->groups, now()->addHours(24));
        }
    }

    private function getFilterAttributes(): void {
        $this->attrs = Cache::get('filter_attrs');
        if(!$this->attrs)
        {
            $this->attrs = $this->getAttrs();
            Cache::put('filter_attrs', $this->attrs, now()->addHours(24));
        }
    }

    public function getFilterHTML($filter){
        if(!is_array($filter)){
            $filter=explode(',',$this->getFilter($filter));
        }

        $groups = $this->groups;
        $attrs = $this->attrs;
        return view($this->tpl, compact("groups", "attrs","filter"));
    }

    protected function getGroups(){
        return DB::table("attribute_group")->select('id', 'title')->get()->keyBy('id')->toArray();
    }

    protected function getAttrs() {
        $data = DB::table("attribute_value")->get()->keyBy('id')->toArray();
        $attrs = array();
        foreach ($data as $key => $value) {
            $attrs[$value->attr_group_id][$key] = $value->value;
        }
        return $attrs;
    }

    public function attributesFilter($filterIds,$query=null){
        if(empty($filterIds)){
            return null;
        }

        if($query == null){
            $query = Product::query();
        }

        $filter = $this->getFilter($filterIds);
        $cnt = $this->getCountGroups($filter);

        $sql = "SELECT product_id
                FROM attribute_product
                WHERE attr_id IN ($filter)
                GROUP BY product_id
                HAVING COUNT(product_id) = $cnt";

        return $query->whereIn('id', function ($query) use ($sql) {
            $query->select('product_id')
                ->from(DB::raw("($sql) as filtered_products"));
        });
    }

    public function searchFilter($filter, $query=null){
        if($query == null){
            $query = Product::query();
        }

        return $query->where('title','LIKE', "%{$filter}%");
    }
    public function getFilter($filterIds): ?string {
        $filter = null;
        if(!empty($filterIds)){
            $filter = preg_replace("#[^\d,]+#", '', $filterIds);
            $filter = rtrim($filter, ',');
        }
        return $filter;
    }

    public function getCountGroups($filter){
        $filters = explode(',', $filter);
        $data = [];

        foreach ($this->attrs as $key => $value){
            foreach ($value as $k => $v){
                if(in_array($k, $filters) && !in_array($key,$data)){
                    $data[] = $key;
                    break;
                }
            }
        }

        return count($data);
    }
}
