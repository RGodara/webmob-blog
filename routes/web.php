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

Route::get('/', function () {
    return view('welcome');
});
Auth::routes();
Route::get('/getHomeScreen','UserController@index')->name('getHomeScreen');
Route::get('/getPosts','PostController@index')->name('getPosts');
Route::post('/registerUser','UserController@create')->name('registerUser');
Route::post('/loginUser','UserController@loginUser')->name('LoginUser');
Route::get('/activateUser/{token}', 'UserController@activateUser')->name('activateUser');
Route::post('/uploadComment','CommentController@create')->name('uploadComment');
Route::get('/getPostDetail/{postId}','CommentController@show');
Route::group(['middleware' => 'auth'], function () {
    Route::get('/userDashboard', 'HomeController@index')->name('userDashboard');
    Route::post('/uploadBlog','PostController@create')->name('uploadBlog');
    Route::get('/signOut','UserController@signOut')->name('signOut');    
});


