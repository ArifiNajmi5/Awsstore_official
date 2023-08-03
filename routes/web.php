<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return view('auth.login');
});

/**
 * route for admin
 */

//group route with prefix "admin"
Route::prefix('admin')->group(function () {

    //group route with middleware "auth"
    Route::group(['middleware' => 'auth'], function () {

        //route dashboard
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard.index');

        //route category
        Route::resource('/category', CategoryController::class, ['as' => 'admin']);

        //route product
        Route::resource('/product', ProductController::class, ['as' => 'admin']);

        //route order
        Route::resource('/order', OrderController::class, ['except' => ['create', 'store', 'edit', 'update', 'destroy'], 'as' => 'admin']);

        //route customer
        Route::get('/customer', [CustomerController::class, 'index'])->name('admin.customer.index');

        //route slider
        Route::resource('/slider', SliderController::class, ['except' => ['show', 'create', 'edit', 'update'], 'as' => 'admin']);

        //profile
        Route::get('/profile', [ProfileController::class, 'index'])->name('admin.profile.index');

        // Route::get('/add-variation', [ProductController::class, 'addVariations'])->name('addVariations');

        //route user
        Route::resource('/user', UserController::class, ['except' => ['show'], 'as' => 'admin']);
    });
    Route::group(['middleware' => ['web']], function () {

        Route::group([
            'prefix' => '/admin'
        ], function () {
            Route::get('/', [
                'uses' => 'AdminController@getIndex',
                'as' => 'admin.index'
            ]);

            Route::post('/blog/posts/create', [
                'uses' => 'PostController@getCreatePost',
                'as' => 'admin.blog.create_post'
            ]);

            Route::post('/blog/post/create', [
                'uses' => 'PostController@postCreatePost',
                'as' => 'admin.blog.post.create'
            ]);
        });
    });
});
