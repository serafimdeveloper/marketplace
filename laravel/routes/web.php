<?php
/** Rotas de páginas */
Route::get('/', 'HomeController@index')->name('homepage');

Route::get('/carrinho', function () {
    return view('pages.cart');
})->name('pages.cart');

Route::get('/contato', function () {
    return view('pages.contact');
})->name('pages.contact');

Auth::routes();
Route::get('/logout', 'Auth\LoginController@logout')->name('auth.logout');

Route::group(['prefix' => 'accont','namespace' => 'Accont','middleware'=>'auth', 'as' => 'accont.'], function(){

    /** Clientes */
    Route::get('/', 'Clients\HomeController@index')->name('home');
    Route::post('/', 'Clients\HomeController@store')->name('home.store');

    Route::post('auth/change_password', 'Clients\HomeController@change_password')->name('changepassword.store');

    Route::get('/requests','Clients\RequestsController@index')->name('requests');
    Route::get('/requests/{id}','Clients\RequestsController@show')->name('request_info');
    Route::post('/request/comments/{id}','Clients/RequestsController@comments')->name('request.comments');

    Route::get('/searchstore', 'StoresController@searchstore')->name('searchstore');
    Route::post('/searchstore', 'StoresController@search')->name('search.store');

    /** Vendedores */
    Route::group(['as'=>'salesman.', 'prefix' => 'salesman'], function(){

        Route::get('create','Salesmans\SalesmanController@create')->name('create');
        Route::post('update','Salesmans\SalesmanController@update')->name('update');
        Route::post('store','Salesmans\SalesmanController@store')->name('store');
        Route::get('info','Salesmans\SalesmanController@edit')->name('info');

        Route::get('stores', 'StoresController@create')->name('stores');
        Route::post('stores', 'StoresController@store')->name('stores.store');
        Route::post('stores/update', 'StoresController@update')->name('stores.update');
        Route::get('stores/block', 'StoresController@blocked')->name('stores.blocked');

        Route::resource('products', 'Salesmans\ProductsController');
        Route::get('products/change/{product}','Salesman\ProductsController@desactive')->name('producta.desactive');
        Route::get('products/remove/image/{image}','Salesmans\ProductsController@removeImage')->name('products.image.remove');

        Route::get('sales', 'Salesmans\SalesController@index')->name('sales');

        Route::get('sale/{id}', 'Salesmans\SalesController@edit')->name('sale_info');
        Route::post('sale/tracking_code/{id}','Salesmans\SalesController@tracking_code')->name('request.tracking_code');

        Route::get('etiqueta/{id}', 'Salesmans\SalesController@tag')->name('etiqueta');

    });

    Route::get('/messages/{type}/all', 'MessagesController@index')->name('messages.all');
    Route::get('/messages/{id}', 'MessagesController@show')->name('message.info');
    Route::post('/messages/{type}/answer/{id}', 'MessagesController@answer')->name('message.answer');
    Route::post('/messages/destroy', 'MessagesController@destroy')->name('message.destroy');

    /** Administrador */
    Route::get('/report/users', function(){
        return view('accont.report.users');
    })->name('report.users');

    Route::get('/report/salesmans', function(){
        return view('accont.report.salesman');
    })->name('report.salesman');

    Route::get('/report/products', function(){
        return view('accont.report.products');
    })->name('report.products');

    Route::resource('categories', 'CategoriesController');
    Route::get('categories/subcategories/{category}','CategoriesController@subcategories')->name('categories.subcategories');
    Route::resource('type_movements','TypeMovementsStocksController');
    Route::post('movement_stock/{type}', 'MovementStocksController@store')->name('movement_stocks.store');

    Route::get('/report/sales', function(){
        return view('accont.report.sales');
    })->name('report.sales');

    Route::get('/report/notifications', function(){
        return view('accont.report.notifications');
    })->name('report.notifications');

    Route::get('/pages', function(){
        return view('accont.pages');
    })->name('pages');

    Route::get('/page', function(){
        return view('accont.page');
    })->name('page.create');

    Route::get('/page/{id}', function(){
        return view('accont.page');
    })->name('page.update');

    Route::get('/banners', function(){
        return view('accont.banners');
    })->name('banners');

    /**
     * PROCESSO DE REQUISIÇÕES VIA AJAX DO SISTEMA
     */

    /** Adress */
    Route::get('/adresses/zip_code/{zip}','AdressesController@search_cep')->name('adress.zip_code');
    Route::post('/adresses/{action}','AdressesController@store')->name('adress.store');
    Route::get('/adresses/{action}/{adress}','AdressesController@edit')->name('adress.edit');
    Route::post('/adresses/{action}/{adress}','AdressesController@update')->name('adress.update');
    Route::delete('/adresses/destroy/{adress}','AdressesController@destroy')->name('adress.destroy');
});
Route::get('/info/{page}', function ($title) {
    $data['title'] = $title;
    return view('pages.dinamic', $data);
})->name('pages.dinamic');

Route::get('imagem/{path}','ImageController@show')->where('path', '.+');

/*Route::get('imagem/{path}', function(League\Glide\Server $server, Illuminate\Http\Request $request, $path){
    $server->outputImage($path, $request->input());
})->where('path', '.+');*/


Route::get('/categoria/{category}', function(){
    return view('pages.products');
})->name('pages.products.categoria');

Route::get('/pesquisa/{search}', function(){
    return view('pages.products');
})->name('pages.products.pesquisa');

Route::get('/favoritos', function(){
    return view('pages.favorites');
})->name('pages.favorites');

Route::get('/{store}', function(){
    return view('pages.store');
})->name('pages.store');

Route::get('/{store}/{category}/{product}', function(){
    return view('pages.product');
})->name('pages.product');

