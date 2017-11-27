<?php

namespace App\Http\Controllers;


use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Auth;
use Illuminate\Support\Facades\Input;

class SearchController extends Controller
{

    public function show($products=array(), $images=array())
    {
        $company_obj=DB::table('search')
            ->selectRaw('distinct(company)')
            ->get();

        $company_names=array();
        $company_names['%']='';
        foreach ($company_obj as $obj)
        {
            $company_names[$obj->company]=$obj->company;
        }
        return view('search')
            ->with('products', $products)
            ->with('images', $images)
            ->with('company_names',$company_names);
    }

    public function search()
    {
        $search_company = Input::get('company');
        if($search_company == '0')$search_company='%';
        $search_category = Input::get('category');
        if($search_category == null)$search_category='%';
        $search_keyword = Input::get('keyword');
        if($search_keyword == null)$search_keyword='%';
        $search_price_l = (int)Input::get('price_low');
        if($search_price_l == "0")$search_price_l=0;
        $search_price_h = (int)Input::get('price_high');
        if($search_price_h == "0")$search_price_h=1000000;

        $products=DB::table('search')
            ->join('product_info','product_info.product_id','=','search.product_id')
            ->select('*')
            ->where('search.company', 'LIKE', '%' . $search_company . '%')
            ->where('search.category', 'LIKE', '%' . $search_category . '%')
            ->where('search.price','<=',$search_price_h)
            ->where('search.price','>=',$search_price_l)
            ->Where('search.name','LIKE','%' . $search_keyword . '%')
            ->get()->all();

        $images_obj=DB::table('image')
            ->select('product_id','image')
            ->where('thumb','=',1)
            ->get()->all();

        $images=array();
        foreach ($images_obj as $image_obj)
        {
            $images[$image_obj->product_id]=$image_obj->image;
        }

        return $this->show($products, $images);

    }
}