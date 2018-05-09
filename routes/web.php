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

Route::get('/', 'Home\IndexController@index');
Route::get('/category/{id}', 'Home\IndexController@category');
Route::get('/a/{id}', 'Home\IndexController@article');

Route::group(['prefix' => 'admin', 'namespace' => 'Admin'], function () {
    Route::any('login', 'LoginController@login');
    Route::get('code', 'LoginController@code');
});

Route::group(['middleware' => 'admin.login', 'prefix' => 'admin', 'namespace' => 'Admin'], function () {
    Route::get('/', 'IndexController@index');
    Route::get('info', 'IndexController@info');
    Route::get('quit', 'LoginController@quit');
    Route::any('pass', 'IndexController@pass');

    Route::resource('category', 'CategoryController');//分类资源路由
    Route::resource('article', 'ArticleController');//文章资源路由
    Route::resource('links', 'LinksController');//友情链接资源路由
    Route::resource('navs', 'NavsController');//自定义导航资源路由
    Route::resource('config', 'ConfigController');//配置项资源路由

    Route::post('cate/changOrder', 'CategoryController@changOrder');//Ajax改变分类排序
    Route::post('link/changOrder', 'LinksController@changOrder');//Ajax改变链接排序
    Route::post('nav/changOrder', 'NavsController@changOrder');//Ajax改变导航排序
    Route::post('conf/changOrder', 'ConfigController@changOrder');//Ajax改变配置项排序

    Route::post('conf/changContent', 'ConfigController@changContent');//配置项改变内容
    Route::get('conf/putFile', 'ConfigController@putFile');//生成网站配置文件

    Route::any('upload', 'CommonController@upload');
});

