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

Route::get('ngon-ngu/{lang}', function ($lang) {
    session()->put('ngon-ngu',$lang);
    return redirect('/');
});

//fontend

Route::get('about', function () {
    echo 'about';
});

Route::get('contact', function () {
    echo 'contact';
});
Route::post('sendmail', 'frontend\HomeController@sendMail');

Route::get('', 'frontend\HomeController@getHome');
//cart
Route::group(['prefix' => 'cart'], function () {
    Route::get('', 'frontend\CartController@getCart');
    Route::get('add', 'frontend\CartController@getAddCart');
    Route::get('del/{rowId}', 'frontend\CartController@getDelCart');
    Route::get('update/{rowId}/{qty}', 'frontend\CartController@getupdateCart');
});
//checkout
Route::group(['prefix' => 'checkout'], function () {
    Route::get('', 'frontend\CheckoutController@getCheckout');
    Route::post('', 'frontend\CheckoutController@postCheckout');
    Route::get('complete/{idOrder}','frontend\CheckoutController@getComplete');
});
//product
Route::group(['prefix' => 'product'], function () {
    Route::get('/detail/{slug_prd}', 'frontend\ProductController@getDetail');
    Route::get('shop', 'frontend\ProductController@getShop');
    Route::get('{slug_cate}.html', 'frontend\ProductController@getProductCate');
});


//login

Route::get('login', 'backend\LoginController@getLogin')->middleware('CheckLogout');
Route::post('login', 'backend\LoginController@postLogin');
Route::get('logout', 'backend\LoginController@getLogout');


//backend


Route::group(['prefix' => 'admin','middleware'=>'CheckLogin'], function () {
    Route::get('', 'backend\AdminController@getAdmin');

    Route::group(['prefix' => 'category'], function () {
        Route::get('', 'backend\CategoryController@getCategory');
        Route::post('', 'backend\CategoryController@postCategory');
        Route::get('edit/{idCate}', 'backend\CategoryController@getEditCategory');
        Route::post('edit/{idCate}', 'backend\CategoryController@postEditCategory');
        Route::get('del/{idCate}', 'backend\CategoryController@getDelCategory');
    });
    Route::group(['prefix' => 'product'], function () {
        Route::get('add', 'backend\ProductController@getAddProduct');
        Route::post('add', 'backend\ProductController@postAddProduct');
        Route::get('edit/{idProduct}', 'backend\ProductController@getEditProduct');
        Route::post('edit/{idProduct}', 'backend\ProductController@postEditProduct');
        Route::get('del/{idProduct}', 'backend\ProductController@delProduct');
        Route::get('', 'backend\ProductController@getProduct');
    });
    Route::group(['prefix' => 'user'], function () {
        Route::get('add', 'backend\UserController@getAddUser');
        Route::post('add', 'backend\UserController@postAddUser');
        Route::get('edit/{idUser}', 'backend\UserController@getEditUser');
        Route::post('edit/{idUser}', 'backend\UserController@postEditUser');
        Route::get('del/{idUser}', 'backend\UserController@DelUser');
        Route::get('', 'backend\UserController@getUser');
    });
    Route::group(['prefix' => 'order'], function () {
        Route::get('detail/{idOrder}', 'backend\OrderController@getDetailOrder');
        Route::get('','backend\OrderController@getOrder');
        Route::get('processed', 'backend\OrderController@getProcessed'); 
        Route::get('process/{idOrder}', 'backend\OrderController@Process');
    });
    
});

//---Lý thuyết----
//SCHEMA
Route::group(['prefix' => 'schema'], function () {
    //tạo bảng
    Route::get('create', function () {
        Schema::create('users', function ($table) {
            $table->bigIncrements('id'); //Khóa chính tự tăng, bigInt, unsigned
            $table->string('name');     //varchar
            $table->string('address', 100)->nullable();     //có thể null
            $table->timestamps();  // trường thời gian create_at
        });
        Schema::create('post', function ($table) {
            $table->bigIncrements('id');
            $table->string('name', 100)->nullable();
            $table->bigInteger('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->timestamps();
        });
    });
    //sửa tên bảng
    Route::get('edit', function () {
        Schema::rename('users', 'thanh-vien');

    //xóa cột trong bảng
    Schema::table('thanh-vien', function ($table) {
        $table->dropColumn('address');
    });

    });
    
    //xóa bảng
    Route::get('del', function () {
        Schema::dropIfExists('users');
    });

    //tương tác cột trong bảng
        //cần cập nhận thư viện doctrine: composer require doctrine/dbal

        Route::get('edit-col', function () {
            //sửa cột
            Schema::table('users', function ($table) {
                $table->string('name',50)->nullable()->change();
                //thêm cột
                // $table->boolean('level')->default(0);
                //thêm cột ở vị trí xác định
                $table->boolean('demo')->default(0)->after('name');
            });
        });
   

});


//Query builder
Route::group(['prefix' => 'query'], function () {
    //thêm dữ liệu cho bảng
    Route::get('insert', function () {
        // DB::table('users')->insert([
        //     'email'=>'A@gamil.com',
        //     'password'=>'123456',
        //     'full'=>'nguyen van a',
        //     'address'=>'ha noi',
        //     'phone'=>'123456789',
        //     'level'=>'1'
        // ]);
         //thêm nhiều bản ghi
        DB::table('users')->insert([
            [
                'email'=>'B@gamil.com',
            'password'=>'1234567',
            'full'=>'nguyen van b',
            'address'=>'ha noi 2',
            'phone'=>'1234567890',
            'level'=>'1'
            ],
            [
                'email'=>'C@gamil.com',
            'password'=>'123456',
            'full'=>'nguyen van C',
            'address'=>'ha noi',
            'phone'=>'123456789',
            'level'=>'1'
            ],
            [
                'email'=>'D@gamil.com',
                'password'=>'123456',
                'full'=>'nguyen van D',
                'address'=>'ha noi',
                'phone'=>'123456789',
                'level'=>'1'
            ]
        ]);

    });
   
    //sửa dữ liệu
    Route::get('update', function () {
        DB::table('users')->where('id',1)->update([
            'address'=>'hai phong'
        ]);
    });

    //xóa dữ liệu
    Route::get('del', function () {
        //xóa 1 bản ghi
        DB::table('users')->where('id',1)->delete();
        //xóa tất cả bản ghi
        DB::table('users')->delete();
    });


    //Query tương tác với dữ liệu
        //lấy bản ghi
        Route::get('get', function () {
            //lấy tất cả bản ghi 
            // $user=DB::table('users')->get();
            // dd($user->all());

            //lấy bản ghi đầu tiên
            // $user=DB::table('users')->first();
            // dd($user);

            //lấy bản ghi theo điều kiện
            //tìm theo id
            // $user=DB::table('users')->find(3);
            // dd($user);
            //where
            // $user=DB::table('users')->where('phone','123456789')->get();
            // $user=DB::table('users')->where('id','>','3')->get();
            // dd($user);
            //where-and
            // $user=DB::table('users')->where('id','>','2')->where('id','<','4')->get();
            // dd($user);
            //where-or
            // $user=DB::table('users')->where('id','>','2')->orwhere('password','1234567')->get();
            // dd($user);
            //where-between
            // $user=DB::table('users')->whereBetween('id',[2,3])->get();
            // dd($user);
            

            //lấy 1 số bản ghi nhất định
            // $user=DB::table('users')->take(2)->get();
            // dd($user);
            //skip
            // $user=DB::table('users')->skip(2)->take(2)->get();
            // dd($user);
            //sắp xếp orderby
            $user=DB::table('users')->orderby('id','desc')->get();
            dd($user);
        });
                

});

//Relationship
    //Bảng chính là bảng chứa khóa chính trong liên kết
    //bảng phụ là bảng chứa khóa ngoại trong liên kết

    //liên kết 1-1 xuôi: return $this->hasOne();
    //liên kết 1-1-ngược: return $this->belongsTo();
    //liên kết 1-n: return $this->hasMany();

    // liên kết 1-1 xuôi
    Route::get('lien-ket-1-1', function () {
        $users = App\User::find(5);
        $info = $users->info()->first();
        dd($info ->toArray());
    });
    // liên kết 1-1 ngược
    Route::get('lien-ket-1-1-n', function () {
       $info = App\models\Info::find(5);
       $users = $info->user()->first();
       dd($users ->toArray());
   });
   //liên kết 1-n
   Route::get('lien-ket-1-n', function () {
    $cate = App\models\Category::find(2);
    $pro = $cate->product()->get();
    dd($pro ->toArray());
});
    //liên kết n-n
    //return $this->belongsToMany('table_2', 'table_trung_gian', 'key_1', 'key_2');