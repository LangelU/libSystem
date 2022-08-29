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

/***** Author endpoints *****/
Route::get('/autores', 'App\Http\Controllers\AuthorController@index')->name('authors');
Route::post('/crear-autor', 'App\Http\Controllers\AuthorController@store')->name('authors');
Route::put('/actualizar-autor/{id}', 'App\Http\Controllers\AuthorController@update')->name('authors');
Route::get('/detalles-autor/{id}', 'App\Http\Controllers\AuthorController@show')->name('authors');
Route::post('/eliminar-autor/{id}', 'App\Http\Controllers\AuthorController@destroy')->name('authors');

/***** Book endpoints *****/
Route::get('/libros', 'App\Http\Controllers\BookController@index')->name('authors');
Route::post('/crear-libro', 'App\Http\Controllers\BookController@store')->name('authors');
Route::put('/actualizar-libro/{id}', 'App\Http\Controllers\BookController@update')->name('authors');
Route::get('/detalles-libro/{id}', 'App\Http\Controllers\BookController@show')->name('authors');
Route::post('/eliminar-libro/{id}', 'App\Http\Controllers\BookController@destroy')->name('authors');

/***** Acknowledgment endpoints *****/
Route::get('/reconocimientos', 'App\Http\Controllers\AcknowledgmentsController@index')->name('authors');
Route::post('/crear-reconocimiento', 'App\Http\Controllers\AcknowledgmentController@store')->name('authors');
Route::put('/actualizar-reconocimiento/{id}', 'App\Http\Controllers\AcknowledgmentController@update')->name('authors');
Route::post('/eliminar-reconocimiento/{id}', 'App\Http\Controllers\AcknowledgmentController@destroy')->name('authors');