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

    Route::get('/requests', function(){
        return view('accont.requests');
    })->name('accont.requests');
    Route::get('/requests/{id}', function(){
        return view('accont.request_info');
    })->name('accont.request_info');


    Route::get('/searchstore', function(){
        return view('accont.searchstore');
    })->name('accont.searchstore');

    Route::get('/messages', function(){
        return view('accont.messages');
    })->name('accont.messages');
    Route::get('/messages/{id}', function(){
        return view('accont.message_info');
    })->name('accont.message_info');

    /** Vendedores */
    Route::get('/salesman', function(){
        return view('accont.salesman');
    })->name('accont.salesman');

    Route::get('/products', function(){
        return view('accont.products');
    })->name('accont.salesman.products');

    Route::get('/stores', function(){
        return view('accont.stores');
    })->name('accont.stores');

    Route::get('/sales', function(){
        return view('accont.sales');
    })->name('accont.salesman.sales');

    Route::get('/messages/salesman', function(){
        return view('accont.messages');
    })->name('accont.salesman.messages');

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

    /** Adress */
    Route::post('adresses','Accont\AdressesController@store')->name('accont.adress.store');

    Route::get('adresses/{adress}','Accont\AdressesController@edit')->name('accont.adress.edit');

    Route::put('adresses/{adress}','Accont\AdressesController@update')->name('accont.adress.update');

    Route::delete('adresses/{adress}','Accont\AdressesController@destroy')->name('accont.adress.destroy');

    Route::get('adresses/zip_code/{zip}','Accont\AdressesController@search_cep')->name('accont.adress.zip_code');

});
