<?php

namespace App\Http\Controllers;

use Jenssegers;
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

//        DB::table('order_product')->insert(
//            ['id' => $account['id'], 'gamer_id'=>$account['type_id'], 'product_id'=>$product_id]
//        );

        $product = DB::table('product_info')
            ->select('*')
            ->where('product_id','=',$product_id)
            ->get()->first();

        DB::connection('mongodb')
                ->collection('order')
                ->insert(['id' => $account['id'], 'gamer_id'=>$account['type_id'], 'product_id' => $product_id, 'product'=>$product]);

        return redirect()->route('product', ['id' => $product_id]);
    }

    public function remove($product_id)
    {
        global $account;
        $account=unserialize($_COOKIE['account']);
//        DB::table('order_product')
//            ->where('product_id', '=', $product_id)
//            ->where('id','=',$account['id'])
//            ->delete();

        $products_obj = DB::connection('mongodb')
            ->collection('order')
            ->where('product_id','=',$product_id)
            ->where('id','=',$account['id'])
            ->delete();

        return back()->withInput();
    }

    public function removeall()
    {
        global $account;
        $account=unserialize($_COOKIE['account']);
//        DB::table('order_product')
//            ->where('id','=',$account['id'])
//            ->delete();

        $products_obj = DB::connection('mongodb')
            ->collection('order')
            ->where('id','=',$account['id'])
            ->delete();

        return redirect()->route('cart');
    }

    private function time_order($gamer_id)
    {
//        $products = DB::table('product_info')
//            ->join('order_product','product_info.product_id','=','order_product.product_id')
//            ->select('*')
//            ->where('order_product.gamer_id','=',$gamer_id)
//            ->get()->all();

        // db.order.find({ gamer_id: 1}, { product: 1, _id:0})
        $products_obj = DB::connection('mongodb')
            ->collection('order')
            ->where('gamer_id','=',$gamer_id)
            ->get();

        $products=array();
        foreach($products_obj as $product_obj)
        {
            array_push($products,$product_obj['product']);
        }


        //$m = new MongoClient("mongodb://heroku_22pzbd36:ecv6lubl2n0iea0f92u9i314af@ds123956.mlab.com:23956/"); // connect
        //$manager = new MongoDB\Driver\Manager("mongodb://localhost:27017");
//        $manager = new MongoDB\Client\Manager("mongodb://localhost:27017");
//        $db = $$manager->selectDB("order");
//        //$search['$text'] = ['$search' => "foo"];
//        $options["projection"] = ['_id' => 0];
//
//
//        $products = $db->find(['gamer_id' => $gamer_id], ['product' => 1, '_id' => 0]);


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
