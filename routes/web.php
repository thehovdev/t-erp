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

// home page
Route::get('/', function () {
    return view('welcome');
});

// routes for login, register and etc
Auth::routes();

// middleware for XSS protection and trim
Route::group(['middleware' => ['XSS_Protection']], function () {
    // home page for registered user
    Route::get('/home', 'HomeController@index')->name('home');
    // index page for our storage
    Route::get('/storage', 'StorageController@index')->name('storage');
    // insert new storage
    Route::get('/storage/store', 'StorageController@store')->name('storage.store');
    // delete storage
    Route::get('/storage/delete', 'StorageController@delete')->name('storage.delete');
    // list product of specific storage
    Route::get('/storage/{id}/list', 'StorageController@list')->name('storage.list');
    // create product in specific storage
    Route::get('/product/create/storage/{id}', 'ProductController@create')->name('product.create');
    // product edit page
    Route::get('/product/edit/{product}/storage/{id}', 'ProductController@edit')->name('product.edit');
    // update existing product
    Route::post('/product/update/{product}/storage/{id}', 'ProductController@update')->name('product.update');
    // form to send product to another user storage
    Route::get('/product/send/storage/{id}', 'ProductController@send')->name('product.send');
    // delete specific product
    Route::get('/products/{id}/delete', 'ProductController@destroy')->name('product.destroy');
    
    // middleware for handle serial number input from user
    Route::group(['middleware' => ['serialnumchecker']], function () {
        // insert product to storage
        Route::post('product/store', 'ProductController@store')->name('product.store');
        // send product to another user storage
        Route::post('/product/sendtoreceiver', 'ProductController@sendtoreceiver')->name('product.sendtoreceiver');
        // return back sended product
        Route::get('/products/{inaction}/returnback', 'ProductController@returnback')->name('product.returnback');
    });

    // incoming products jorunal
    Route::get('/journal/in', 'JournalController@incoming')->name('journal.in');
    // outgoing products jorunal
    Route::get('/journal/out', 'JournalController@outgoing')->name('journal.out');
});