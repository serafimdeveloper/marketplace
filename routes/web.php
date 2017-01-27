<?php
Route::get('/', function () {
    return view('welcome');
});

Auth::routes();
Route::get('/logout', 'Auth\LoginController@logout')->name('auth.logout');
Route::get('/home', 'HomeController@index')->name('home');
Route::group(['prefix' => 'accont','middleware'=>'auth'], function(){

    /** Clientes */
    Route::get('/', 'Accont\Clients\HomeController@index')->name('accont.home');

    Route::post('/', 'Accont\Clients\HomeController@store')->name('account.home.store');

    Route::post('auth/change_password', 'Accont\Clients\HomeController@change_password')->name('changepassword.store');

    Route::get('/requests','Accont\Clients\RequestsController@index')->name('accont.requests');
    Route::get('/requests/{id}','Accont\Clients\RequestsController@show')->name('accont.request_info');


    Route::get('/searchstore', 'Accont\StoresController@searchstore')->name('accont.searchstore');
    Route::post('/searchstore', 'Accont\StoresController@search')->name('accont.search.store');

    Route::get('/messages', function(){
        return view('accont.messages');
    })->name('accont.messages');
    Route::get('/messages/{id}', function(){
        return view('accont.message_info');
    })->name('accont.message_info');

    /** Vendedores */
    Route::get('/salesman/create','Accont\Salesmans\SalesmanController@create')->name('accont.salesman.create');
    Route::post('/salesman/store','Accont\Salesmans\SalesmanController@store')->name('accont.salesman.store');
    Route::get('/salesman/info','Accont\Salesmans\SalesmanController@edit')->name('accont.salesman.info');
    Route::put('/salesman/update','Accont\Salesmans\SalesmanController@update')->name('accont.salesman.update');

    Route::get('/salesman/products', function(){
        return view('accont.products');
    })->name('accont.salesman.products');

    Route::get('/salesman/product', function(){
        return view('accont.product_info');
    })->name('accont.salesman.product_create');

    Route::get('/salesman/product/{id}', function(){
        return view('accont.product_info');
    })->name('accont.salesman.product_info');

    Route::get('/salesman/stores', function(){
        return view('accont.stores');
    })->name('accont.salesman.stores');

    Route::get('/salesman/sales', function(){
        return view('accont.sales');
    })->name('accont.salesman.sales');

    Route::get('/salesman/sale/{id}', function(){
        return view('accont.sale_info');
    })->name('accont.salesman.sale_info');

    Route::get('/salesman/messages', function(){
        return view('accont.messages');
    })->name('accont.salesman.messages');

    Route::get('/salesman/message/{id}', function(){
        return view('accont.message_info');
    })->name('accont.salesman.messages_info');

    Route::get('/etiqueta', function(){
        return view('layouts.parties.etiqueta');
    })->name('layouts.parties.etiqueta');


    /** Administrador */
    Route::get('/report/users', function(){
        return view('accont.report.users');
    })->name('accont.report.users');

    Route::get('/report/salesmans', function(){
        return view('accont.report.salesman');
    })->name('accont.report.salesman');

    Route::get('/report/products', function(){
        return view('accont.report.products');
    })->name('accont.report.products');


    Route::get('/categories', function(){
        return view('accont.categories');
    })->name('account.categories');

    Route::get('/report/sales', function(){
        return view('accont.report.sales');
    })->name('accont.report.sales');

    Route::get('/report/notifications', function(){
        return view('accont.report.notifications');
    })->name('accont.report.notifications');



    /**
     * PROCESSO DE REQUISIÇÕES VIA AJAX DO SISTEMA
     */

    /** Adress */
    Route::post('adresses','Accont\AdressesController@store')->name('accont.adress.store');

    Route::get('adresses/{adress}','Accont\AdressesController@edit')->name('accont.adress.edit');

    Route::put('adresses/{adress}','Accont\AdressesController@update')->name('accont.adress.update');

    Route::delete('adresses/{adress}','Accont\AdressesController@destroy')->name('accont.adress.destroy');

    Route::get('adresses/zip_code/{zip}','Accont\AdressesController@search_cep')->name('accont.adress.zip_code');

});
