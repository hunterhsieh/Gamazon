<?php

namespace App\Http\Controllers;


use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Auth;
use Illuminate\Support\Facades\Input;
use Image;

class ProductController extends Controller
{
    public function show($product_id,$image_no=0)
    {
        global $account;
        $account=unserialize($_COOKIE['account']);

        $product = DB::select('select * from product where product_id = :id', ['id' => $product_id]);
        $reviews = DB::table('write_review')
            ->join('users', 'users.id', '=', 'write_review.id')
            ->join('review','review.review_id','=','write_review.review_id')
            ->leftJoin('like_review', 'review.review_id','=','like_review.review_id')
            ->select('review.review_id','users.name', 'users.id AS id','review.content','review.rate',DB::raw('count(like_review.review_id) AS like_num'))
            ->where('review.product_id', '=', $product_id)
            ->groupBy('review.review_id','users.name','users.id','review.content','review.rate','like_review.review_id')
            ->get();

        $company = DB::table('users')
            ->join('company','company.id','=','users.id')
            ->select('*')
            ->where('users.id', '=', $product['0']->id)
            ->get();

        if(Auth::check()) {
            if($account['type']=='gamer') {
                DB::table('visit_product')->insert(
                    ['id' => $account['id'], 'gamer_id' => $account['type_id'], 'product_id' => $product_id]
                );
            }
        }

        $visit = DB::table('visit_product')
            ->select(DB::raw('count(*) AS visited_num'))
            ->where('product_id', '=', $product_id)
            ->get();

        $rates = DB::table('review')
            ->select(DB::raw('AVG(rate) AS rate'))
            ->where('product_id','=',$product_id)
            ->get();

        $images=DB::table('image')
            ->select('product_id','image')
            ->where('product_id','=',$product_id)
            ->get()->all();

        $has_reviewed=false;

        foreach($reviews as $review)
        {
            if($review->id == $account['id'])
                $has_reviewed=true;
        }

        if(sizeof($rates)==0 || $rates['0']->rate==null)
            $rate=0;
        else
            $rate=$rates['0']->rate;

        $in_cart=false;

        if(Auth::check()) {

            if($account['type']=='gamer') {

                $cart = DB::table('order_product')
                    ->select('*')
                    ->where('order_product.product_id', '=', $product_id)
                    ->where('order_product.id', '=', $account['id'])
                    ->get();

                if (sizeof($cart) > 0)
                    $in_cart = true;
            }
        }
        return view('product')
            ->with('product', $product['0'])
            ->with('reviews',$reviews)
            ->with('company',$company['0'])
            ->with('in_cart', $in_cart)
            ->with('rate',$rate)
            ->with('has_reviewed',$has_reviewed)
            ->with('images',$images)
            ->with('image_no',$image_no)
            ->with('visit',$visit['0']);

    }

    public function showadd()
    {
        return view('add_product');
    }

    public function add(Request $request)
    {
        global $account;
        $account=unserialize($_COOKIE['account']);

        $request->validate([
            'name' => 'bail|required|unique:product',
            'category' => 'required',
            'image1'=> 'required',
            'price' => 'required|numeric|between:0,1000000'
        ]);

        $name = Input::get('name');
        $description = Input::get('description');
        $category =  Input::get('category');
        $video = Input::get('video');
        $price = Input::get('price');

        $filepaths=array();
        if(Input::file('image1') != null){
//            $image = Input::file('image1');
//            $filename  = time() . '.' . $image->getClientOriginalExtension();
//            $path = public_path('uploads/' . $filename);
//            Image::make($image->getRealPath())->resize(100, 100)->save($path);
            $filepaths[0]=Input::file('image1')->store('/');
        }

        if(Input::file('image2') != null) {
//            $image = Input::file('image2');
//            $filename  = time() . '.' . $image->getClientOriginalExtension();
//            $path = public_path('uploads/' . $filename);
//            Image::make($image->getRealPath())->resize(100, 100)->save($path);
            $filepaths[1] = Input::file('image2')->store('/');
        }
        if(Input::file('image3') != null) {
//            $image = Input::file('image3');
//            $filename  = time() . '.' . $image->getClientOriginalExtension();
//            $path = public_path('uploads/' . $filename);
//            Image::make($image->getRealPath())->resize(100, 100)->save($path);
            $filepaths[2] = Input::file('image3')->store('/');
        }


        DB::table('product')->insert(
            ['id' => $account['id'], 'company_id'=>$account['type_id'],
                'name'=>$name,'video'=>$video,'description'=>$description, 'category'=>$category,'price'=>$price]
        );

        $product_id = DB::table('product')
            ->where('name','=',$name)
            ->select('product_id')
            ->get();

        $thumb=1;
        for ($i=0;$i<sizeof($filepaths);$i++) {
            if($filepaths[$i] == null)
                continue;
            DB::table('image')->insert(
                ['product_id' => $product_id['0']->product_id, 'image' => $filepaths[$i], 'thumb' => $thumb]
            );
            $thumb = 0;
        }
        return redirect()->route('company', ['id' => $account['type_id']]);
    }
}
