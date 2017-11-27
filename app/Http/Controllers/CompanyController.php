<?php

namespace App\Http\Controllers;


use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Auth;
use Illuminate\Support\Facades\Input;

class CompanyController extends Controller
{
    public function show($company_id,$order='rate')
    {

        $products = $this->order($order, $company_id);
        $popular = $this->order('pop_rate',$company_id);

        $company = DB::table('users')
            ->join('company','users.id','=','company.id')
            ->select('*')
            ->where('company.company_id', '=', $company_id)
            ->get();

        $rate = DB::table('review')
            ->rightJoin('product','product.product_id','=','review.product_id')
            ->rightJoin('company','company.company_id','=','product.company_id')
            ->select(DB::raw('AVG(rate) AS rate'))
            ->where('company.company_id','=',$company_id)
            ->get();

        $images_obj=DB::table('image')
            ->select('product_id','image')
            ->where('thumb','=',1)
            ->get()->all();

        $images=array();
        foreach ($images_obj as $image_obj)
        {
            $images[$image_obj->product_id]=$image_obj->image;
        }

        return view('company')
            ->with('popular',$popular)
            ->with('products', $products)
            ->with('company',$company['0'])
            ->with('images',$images)
            ->with('rate',$rate['0']->rate);

    }

    private function order($order,$company_id)
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
