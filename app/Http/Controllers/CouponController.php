<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Auth;

class CouponController extends Controller
{
    public function show()
    {
        global $account;
        $account=unserialize($_COOKIE['account']);

        $coupons = DB::table('coupon')
            ->where('id','=',$account['id'])
            ->select('*')
            ->get();

        return view('coupon')
            ->with('coupons',$coupons);
    }

}
