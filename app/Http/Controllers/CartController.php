<?php

namespace App\Http\Controllers;


use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Auth;
use Illuminate\Support\Facades\Input;

class CartController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function show()
    {
         global $account;
        $account=unserialize($_COOKIE['account']);

        $products = $this->time_order($account['type_id']);

//        $order_products = DB::table('order_product')
//            ->join('product', 'product.product_id', '=', 'order_product.product_id')
//            ->select('*')
//            ->where('order_product.id', '=', $account['id'])
//            ->where('order_product.gamer_id', '=', $account['type_id'])
//            ->get();

        $images_obj=DB::table('image')
            ->select('product_id','image')
            ->where('thumb','=',1)
            ->get()->all();

        $images=array();
        foreach ($images_obj as $image_obj)
        {
            $images[$image_obj->product_id]=$image_obj->image;
        }

        return view('cart')
            ->with('products', $products)
            ->with('images',$images);

    }

    public function add($product_id)
    {
        global $account;
        $account=unserialize($_COOKIE['account']);
        DB::table('order_product')->insert(
            ['id' => $account['id'], 'gamer_id'=>$account['type_id'], 'product_id'=>$product_id]
        );

        return redirect()->route('product', ['id' => $product_id]);
    }

    public function remove($product_id)
    {
        global $account;
        $account=unserialize($_COOKIE['account']);
        DB::table('order_product')
            ->where('product_id', '=', $product_id)
            ->where('id','=',$account['id'])
            ->delete();

        return back()->withInput();
    }

    public function removeall()
    {
        global $account;
        $account=unserialize($_COOKIE['account']);
        DB::table('order_product')
            ->where('id','=',$account['id'])
            ->delete();

        return redirect()->route('cart');
    }

    private function time_order($gamer_id)
    {
        $products = DB::table('product_info')
            ->join('order_product','product_info.product_id','=','order_product.product_id')
            ->select('*')
            ->where('order_product.gamer_id','=',$gamer_id)
            ->get()->all();

        usort($products, function($productsA, $productsB){
            if($productsA->rate > $productsB->rate)
                return -1;
            else if ($productsA->rate == $productsB->rate)
                return 0;
            else
                return 1;
        });


        return $products;
    }
}
