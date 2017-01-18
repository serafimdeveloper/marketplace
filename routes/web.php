<?php
Route::get('/', function () {
    return view('welcome');
});

Auth::routes();
Route::get('/logout', 'Auth\LoginController@logout');
Route::get('/home', 'HomeController@index');
Route::group(['prefix' => 'accont'], function(){

    /** Clientes */
    Route::get('/', function(){
        return view('accont.home');
    });

    Route::get('/requests', function(){
        return view('accont.requests');
    });

    Route::get('/searchstore', function(){
        return view('accont.searchstore');
    });

    Route::get('/messages', function(){
        return view('accont.messages');
    });

    /** Vendedores */
    Route::get('/salesman', function(){
        return view('accont.salesman');
    });
    Route::get('/products', function(){
        return view('accont.products');
    });
    Route::get('/sales', function(){
        return view('accont.sales');
    });
    Route::get('/messages/salesman', function(){
        return view('accont.messages');
    });

    /** Administrador */
    Route::get('/report/users', function(){
        return view('accont.report.users');
    });
    Route::get('/report/salesmans', function(){
        return view('accont.report.salesman');
    });
    Route::get('/report/products', function(){
        return view('accont.report.products');
    });
    Route::get('/categories', function(){
        return view('accont.categories');
    });
    Route::get('/report/sales', function(){
        return view('accont.report.sales');
    });
    Route::get('/report/notifications', function(){
        return view('accont.report.notifications');
    });

});
