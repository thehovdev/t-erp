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


Route::group(['middleware' => ['XSS_Protection']], function () {
    Route::get('/home', 'HomeController@index')->name('home');

    Route::get('/storage', 'StorageController@index')->name('storage');
    Route::get('/storage/store', 'StorageController@store')->name('storage.store');
    Route::get('/storage/delete', 'StorageController@delete')->name('storage.delete');
    Route::get('/storage/{id}/list', 'StorageController@list')->name('storage.list');

    Route::get('/product/create/storage/{id}', 'ProductController@create')->name('product.create');
    Route::get('/product/edit/{product}/storage/{id}', 'ProductController@edit')->name('product.edit');
    Route::post('/product/update/{product}/storage/{id}', 'ProductController@update')->name('product.update');
    Route::get('/product/send/storage/{id}', 'ProductController@send')->name('product.send');
    Route::get('/products/{id}/delete', 'ProductController@destroy')->name('product.destroy');
    
    Route::group(['middleware' => ['serialnumchecker']], function () {
        Route::post('product/store', 'ProductController@store')->name('product.store');
        Route::post('/product/sendtoreceiver', 'ProductController@sendtoreceiver')->name('product.sendtoreceiver');
        Route::get('/products/{inaction}/returnback', 'ProductController@returnback')->name('product.returnback');

    });


    Route::get('/journal/in', 'JournalController@incoming')->name('journal.in');
    Route::get('/journal/out', 'JournalController@outgoing')->name('journal.out');
    Route::get('/send', 'SendController@index')->name('send');
});