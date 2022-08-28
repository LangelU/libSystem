<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/autores', 'App\Http\Controllers\AuthorController@index')->name('authors');
Route::post('/autor-crear', 'App\Http\Controllers\AuthorController@store')->name('authors');
Route::put('/autor-actualizar/{id}', 'App\Http\Controllers\AuthorController@update')->name('authors');
Route::get('/autor-detalles/{id}', 'App\Http\Controllers\AuthorController@show')->name('authors');
Route::post('/autor-eliminar/{id}', 'App\Http\Controllers\AuthorController@destroy')->name('authors');