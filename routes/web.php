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

use Illuminate\Support\Facades\Auth;

Auth::routes();

Route::get('/', 'HomeController@index')
     ->name('index');

Route::get('/logout', function () {
    Auth::logout();
    return redirect()->back();
})
     ->name('logout');

Route::get('/specs', 'HomeController@specs');
Route::post('/email', 'HomeController@email');
Route::get('/sitemap.xml', 'HomeController@sitemapXml');
Route::get('/contacts', 'HomeController@contacts');
Route::get('/search', 'HomeController@search');
Route::get('/catalog/{category?}', 'HomeController@catalog');
Route::get('/about', 'HomeController@about');
Route::get('/news', 'HomeController@news');
Route::get('/news/{id}-{title}', 'HomeController@newPage');
Route::get('/product/{id}-{title}', 'HomeController@product')
     ->where('id', '\d+')
     ->where('title', '[^/]+');
