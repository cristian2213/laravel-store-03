<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

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
    return redirect()->route('main');
});

Route::get('/welcome', 'MainController@index')->name('main');

//Route::get('/products', 'ProductController@index')->name('products.index');

//Route::get('/products/create', 'ProductController@create')->name('products.create');

//Route::post('/products', 'ProductController@store')->name('products.store');

//Route::get('/products/{product}', 'ProductController@show')->name('products.show');

// Route::get('/products/{product:title}', 'ProductController@show')->name('products.show'); //* accediendo por medio del titulo y no por el id

//Route::get('/products/{product}/edit', 'ProductController@edit')->name('products.edit');

// la rutas atiende a cualquiera de los dos verbos
//Route::match(['put', 'patch'], '/products/{product}', 'ProductController@update')->name('products.update');

//Route::delete('/products/{product}', 'ProductController@destroy')->name('products.destroy');

/* 
Route::resource('products', 'ProductController')->only(['index', 'show', 'create']);
Route::resource('products', 'ProductController')->except(['index', 'show', 'create']);
 */

//* ruta de controlador aninado (simpre en plural)
Route::resource('products.carts', 'ProductCartController')->only(['store', 'destroy']);

Route::resource('carts', 'CartController')->only(['index']);

Route::resource('orders', 'OrderController')->only(['create', 'store'])->middleware(['verified']);

Route::resource('orders.payments', 'OrderPaymentController')->only(['create', 'store'])->middleware(['verified']);

//* Rutas perfil
Route::get('profile', 'ProfileController@edit')->name('profile.edit');

Route::put('profile', 'ProfileController@update')->name('profile.update');

Auth::routes([
    'verify' => true,
    // 'reset' => false 
]);

//Route::get('/home', 'HomeController@index')->name('home');
