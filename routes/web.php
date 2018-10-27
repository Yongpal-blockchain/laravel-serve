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

Route::get('/', 'PageController@index')->name('main');

Route::get('signin', 'Auth\SignController@getSignin')->name('login');
Route::post('signin', 'Auth\SignController@postSignin')->name('post.signin');
Route::get('signup', 'Auth\SignController@getSignup')->name('get.signup');
Route::post('signup', 'Auth\SignController@postSignup')->name('post.signup');

Route::group(['middleware' => 'web', 'auth'], function() {
    Route::get('logout', 'Auth\SignController@logout')->name('logout');
    Route::get('product/store', 'ProductController@add')->name('get.product.add');
    Route::post('product/store', 'ProductController@store')->name('post.product.add');

    Route::post('product/payment', 'ProductController@payment')->name('post.product.payment');

    Route::get('product/check', 'ProductController@getCheck')->name('get.product.check');
    Route::post('product/check', 'PageController@productPaymentCheck')->name('post.product.payment.check');
});

Route::get('products', 'PageController@products')->name('get.product.index');
Route::get('product/{xid}', 'PageController@show')->name('get.product.show');