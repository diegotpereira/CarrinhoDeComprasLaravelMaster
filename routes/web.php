<?php

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

/*Route::get('/', function () {
    return view('welcome');
});*/

Auth::routes();

// Rotas do carrinho de compras
Route::get('/carrinho', 'CarrinhoController@index')->name('carrinho.index');

Route::post('/carrinho/adicionar', 'CarrinhoController@adicionar')->name('carrinho.adicionar');

//Rotas da loja
Route::get('/', 'HomeController@index')->name('home');
Route::get('/home', 'HomeController@index')->name('home');
Route::get('/{id}/show', 'HomeController@show')->name('home.show');



/*Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home'); */
