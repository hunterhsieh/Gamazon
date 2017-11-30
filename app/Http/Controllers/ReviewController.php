<?php

namespace App\Http\Controllers;


use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Auth;


class ReviewController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function show($product_id)
    {
        // $id is product_id
        return view('review')
            ->with('product_id', $product_id);
    }

    public function post($product_id)
    {
        global $account;
        $account=unserialize($_COOKIE['account']);
        $review = new \stdClass();
        $review->product_id = $product_id;
        $review->rate = Input::get('rate');
        $review->content = Input::get('content');

        DB::insert('insert into review (product_id, content, rate) values (?, ?, ?)',
            [$review->product_id, $review->content,$review->rate]);

        $review_id = DB::table('review')
            ->select(DB::raw('MAX(review.review_id) AS review_id'))
            ->get();

        DB::insert('insert into write_review (id, gamer_id, review_id) values (?, ?, ?)',
            [$account['id'], $account['type_id'],$review_id['0']->review_id]);

        return redirect()->route('product', ['id' => $product_id]);

    }
    public function like($product_id, $review_id)
    {
        global $account;
        $account=unserialize($_COOKIE['account']);
        $hasLiked = DB::table('like_review')
            ->select(DB::raw('count(*) AS like_num'))
            ->rightJoin('review','review.review_id','=','like_review.review_id')
            ->where('like_review.id','=',$account['id'])
            ->where('like_review.gamer_id','=',$account['type_id'])
            ->where('like_review.review_id','=',$review_id)
            //->groupBy('review.review_id')
            ->get();

        if($hasLiked['0']->like_num > 0)
            DB::table('like_review')
                ->where('like_review.id','=',$account['id'])
                ->where('like_review.gamer_id','=',$account['type_id'])
                ->where('like_review.review_id','=',$review_id)
                ->delete();
        else
            DB::insert('insert into like_review (id, gamer_id, review_id) values (?, ?, ?)',
                [$account['id'], $account['type_id'], $review_id]);

        //return redirect()->route('product', ['id' => $id]);
        return redirect()->route('product', ['id' => $product_id]);
    }

    public function delete($product_id, $review_id)
    {
        global $account;
        $account=unserialize($_COOKIE['account']);
        DB::table('review')
            ->where('review_id','=',$review_id)
            ->delete();

        return redirect()->route('product', ['id' => $product_id]);
    }
}
