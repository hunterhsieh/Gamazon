<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Auth;

class HomeController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($order='rate')
    {
        $products = $this->order($order);
//
//        return view('home')
//            ->with('products', $products);
//
//        $popular = DB::table('review')
//            ->rightJoin('product','review.product_id','=','product.product_id')
//            ->select('product.product_id','product.name','product.description',
//                DB::raw('IFNULL(count(review.review_id) * AVG(review.rate), 0) AS pop_rate'))
//            ->groupBy('product.product_id','product.name','product.description')
//            ->get()->all();

        $popular = $this->order('pop_rate');

        $images_obj=DB::table('image')
            ->select('product_id','image')
            ->where('thumb','=',1)
            ->get()->all();

        $images=array();
        foreach ($images_obj as $image_obj)
        {
            $images[$image_obj->product_id]=$image_obj->image;
        }

        usort($popular, array($this, "cmp"));

        return view('home')
            ->with('popular',$popular)
            ->with('products', $products)
            ->with('images',$images);

    }
    private function cmp($popularA,$popularB)
    {
        if($popularA->pop_rate > $popularB->pop_rate)
            return -1;
        else if ($popularA->pop_rate == $popularB->pop_rate)
            return 0;
        else
            return 1;
    }

    private function order($order)
    {
        $products = DB::table('product_info')
            ->select('*')
            ->get()->all();

        switch ($order) {
            case 'rate':
                usort($products, function($productsA, $productsB){
                    if($productsA->rate > $productsB->rate)
                        return -1;
                    else if ($productsA->rate == $productsB->rate)
                        return 0;
                    else
                        return 1;
                });
                break;
            case 'review':
                usort($products, function($productsA, $productsB){
                    if($productsA->review > $productsB->review)
                        return -1;
                    else if ($productsA->review == $productsB->review)
                        return 0;
                    else
                        return 1;
                });
                break;
            case 'visit':
                usort($products, function($productsA, $productsB){
                    if($productsA->visit > $productsB->visit)
                        return -1;
                    else if ($productsA->visit == $productsB->visit)
                        return 0;
                    else
                        return 1;
                });
                break;
            case 'pop_rate':
                usort($products, function($productsA, $productsB){
                    if($productsA->pop_rate > $productsB->pop_rate)
                        return -1;
                    else if ($productsA->pop_rate == $productsB->pop_rate)
                        return 0;
                    else
                        return 1;
                });
                break;
            default:
                break;
        }

        return $products;
    }
}
