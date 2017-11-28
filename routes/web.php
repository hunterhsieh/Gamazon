<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
use App\User;
use Illuminate\Support\Facades\Input;
use Illuminate\Http\Request;

global $account;
if(isset($_COOKIE['account'])){
    $account=unserialize($_COOKIE['account']);
}

Route::get('/', function () {
//    	return view('welcome');
    return Redirect::route('home');
});
//Route::get('/', 'HomeController@index')->name('home');
Route::get('/home', 'HomeController@index')->name('home');
Route::get('/home/order/{order}', 'HomeController@index')->name('home_order');

Route::get('/product/add', 'ProductController@showadd')->name('add_product');
Route::post('/product/add', 'ProductController@add');
Route::get('/product/{id}/{img}', 'ProductController@show')->name('product');
Route::get('/product/{id}', 'ProductController@show')->name('product');

Route::get('/product/review/post/{product_id}', 'ReviewController@show');
Route::post('/product/review/post/{product_id}', 'ReviewController@post');
Route::get('/product/review/like/{product_id}/{review_id}', 'ReviewController@like');
Route::get('/product/review/delete/{product_id}/{review_id}', 'ReviewController@delete');

Route::get('/cart', 'CartController@show')->name('cart');
Route::get('/cart/add/{id}', 'CartController@add')->name('add_cart');
Route::get('/cart/remove/all', 'CartController@removeall')->name('remove_cart');
Route::get('/cart/remove/{id}', 'CartController@remove')->name('removeall_cart');

Route::get('/company/order/{id}/{order}', 'CompanyController@show')->name('company_order');
Route::get('/company/{id}', 'CompanyController@show')->name('company');

Route::get('/coupon', 'CouponController@show')->name('coupon');

Route::get('/search', 'SearchController@show')->name('search');
Route::post('/search', 'SearchController@search');

//Route::get('/login',function()
//{
//    return view('auth.login');
//});

Route::get('/global_data','GlobalDataController@set')->name('global_data');

Route::post('/register/next',function()
{
    $type=Input::get('type');
    return redirect()->route('register_type', ['type' => $type]);
});
Route::get('/register/type/{type}',function($type)
{
    if($type == 'gamer')
        return view('auth.gamer_register');
    else
        return view('auth.company_register');
})->name('register_type');
Route::post('/register/finish',function(Request $request)
{
    $request->validate([
        'name' => 'bail|required',
        'email' => 'bail|required|unique:users',
        'password' => 'required',
    ]);
    $type=Input::get('type');
    $user = new User;
    $user->name=Input::get('name');
    $user->email=Input::get('email');
    $user->password=Hash::make(Input::get('password'));
    $user->save();

    $auth_id = DB::table('users')
        ->where('users.email','=',$user->email)
        ->select('users.id')
        ->get();

    if($type == 'gamer') {

        DB::table('gamer')->insert(
            ['id' => $auth_id['0']->id, 'user_level' => 'bronze']
        );

    }
    else{
        //$filepath=Input::file('image')->store('public');
        $img_file = Input::file('image');
        $img_content = file_get_contents($img_file);
        $img_type = Input::file('image')->getMimeType();
        $imgData = base64_encode($img_content);
        $src = 'data:'.$img_type.';base64, '.$imgData;

        $description = Input::get('description');

        DB::table('company')->insert(
            ['id' => $auth_id['0']->id, 'image' => $src, 'description'=>$description]
        );
    }
    return Redirect::to('/login');
});

Route::get('/logout',function()
{
    unset($GLOBALS['account']);
    unset($_COOKIE['account']);
    Auth::logout();
    return view('auth.logout');
});

//Route::group(['middleware' => 'auth'], function () {


//});

Auth::routes();


