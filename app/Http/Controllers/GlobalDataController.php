<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Auth;

class GlobalDataController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function set()
    {
        global $account;

        if(Auth::check()){
            $email = Auth::user()->email;

            $auth = DB::table('users')
                ->where('users.email', '=', $email)
                ->select('*')
                ->get();



            $gamer = DB::table('gamer')
                ->where('gamer.id', '=', $auth['0']->id)
                ->select('*')
                ->get();


            $account['id']=$auth['0']->id;
            $account['name']=$auth['0']->name;
            $account['email']=$auth['0']->email;

            if(sizeof($gamer) != 0) {
                $level = $this->level_check($auth['0']->id);
                $account['type'] = 'gamer';
                $account['type_id'] = $gamer['0']->gamer_id;
                $account['level'] = $level;
            }
            else {
                $company = DB::table('company')
                    ->where('company.id', '=', $auth['0']->id)
                    ->select('*')
                    ->get();

                $account['type'] = 'company';
                $account['type_id'] = $company['0']->company_id;
                //$account['image'] = $company['0']->image;
            }
            unset($GLOBALS['account']);
            unset($_COOKIE['account']);
            setcookie('account',serialize($account));
            return redirect()->route('home');
        }
        return redirect()->route('login');
    }

    private function level_check($id)
    {
        $like_num = DB::table('write_review')
            ->leftJoin('like_review', 'write_review.review_id', '=', 'like_review.review_id')
            ->where('write_review.id', '=', $id)
            ->select(DB::raw('count(like_review.id) AS likes'))
            ->get();

        $write_num = DB::table('write_review')
            ->where('write_review.id', '=', $id)
            ->select(DB::raw('count(write_review.review_id) AS reviews'))
            ->get();

        $gamer = DB::table('gamer')
            ->where('gamer.id', '=', $id)
            ->select('*')
            ->get();

        $redeem = $gamer['0']->redeem_likes;

        // Calculate level and coupons
        if($write_num['0']->reviews == 0)
            return 'bronze';
        if ($like_num['0']->likes >= $write_num['0']->reviews * 15) {
            $level = 'gold';
            if($like_num['0']->likes - $gamer['0']->redeem_likes > 15) {
                for ($i = 0; $i < ($like_num['0']->likes - $gamer['0']->redeem_likes) / 15; $i++) {
                    DB::table('coupon')->insert(
                        ['id' => $id, 'gamer_id' => $gamer['0']->gamer_id, 'content' => 20]
                    );
                }
                $redeem = $like_num['0']->likes;
            }
        }
        else if($like_num['0']->likes >= $write_num['0']->reviews*5) {
            $level = 'silver';
            if($like_num['0']->likes - $gamer['0']->redeem_likes > 5) {
                for ($i = 0; $i < ($like_num['0']->likes - $gamer['0']->redeem_likes) / 5; $i++) {
                    DB::table('coupon')->insert(
                        ['id' => $id, 'gamer_id' => $gamer['0']->gamer_id, 'content' => 10]
                    );
                }
                $redeem = $like_num['0']->likes;
            }
        }
        else {
            $level = 'bronze';
        }

        DB::table('gamer')
            ->where('id', '=',$id)
            ->update(['user_level' => $level, 'redeem_likes' => $redeem]);

        return $level;
    }
}
