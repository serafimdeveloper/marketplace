<?php

/*******************************************************
 * ROTAS DE TESTES
 ******************************************************/
Route::get('/integration/moip/test', 'CheckoutController@order')->name('test.integrationmoip');
Route::get('/progress/log', function(){
    return view('log');
})->name('test.integrationmoip');
/**---------------------------------------------------------------------------------------*/

Auth::routes();
Route::get('auth/facebook', 'Auth\AuthController@redirectToProvider')->name('auth.facebook');
Route::get('auth/facebook/callback', 'Auth\AuthController@handleProviderCallback')->name('auth.facebook.callback');

Route::get('/calculatefreight', 'FreightController@toCalculate')->name('calculatefreight');

Route::get('/contato', 'ContactController@indexGet')->name('pages.contact');
Route::post('/contact/sendmail', 'ContactController@sendMail')->name('pages.sendmail');

Route::get('/logout', 'Auth\LoginController@logout')->name('auth.logout');

//Route::get('/notification/moip/nasp', 'Accont\PaymentMoip@notification')->name('notification_moip');
Route::group(['prefix' => 'accont','namespace' => 'Accont','middleware'=>'auth', 'as' => 'accont.'], function(){
    // Route::get('/payment/callback', 'PaymentMoip@callback')->name('payment_callback');

    /** Clientes */
    Route::get('/', 'Clients\HomeController@index')->name('home');
    Route::post('/', 'Clients\HomeController@store')->name('home.store');

    Route::post('auth/change_password', 'Clients\HomeController@change_password')->name('changepassword.store');

    Route::get('/requests','Clients\RequestsController@index')->name('requests');
    Route::get('/requests/{id}','Clients\RequestsController@show')->name('request_info');
    Route::post('/request/comments/{id}','Clients\RequestsController@comments')->name('request.comments');
    Route::post('/request/shop_valuations/{id}','ShopValuationsController@store')->name('request.shop_valuations');

    Route::get('/searchstore', 'StoresController@search')->name('searchstore');
   // Route::post('/searchstore', 'StoresController@search')->name('search.store');

    /** Vendedores */
    Route::get('/appmoip/connect', 'ConnectAppMoipController@show')->name('appmoip_connect');
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
        Route::get('products/change/{product}','Salesmans\ProductsController@desactive')->name('producta.desactive');
        Route::get('products/remove/image/{image}','Salesmans\ProductsController@removeImage')->name('products.image.remove');

        Route::get('sales', 'Salesmans\SalesController@index')->name('sales');

        Route::get('sale/{id}', 'Salesmans\SalesController@edit')->name('sale_info');
        Route::post('sale/tracking_code/{id}','Salesmans\SalesController@tracking_code')->name('request.tracking_code');

        Route::get('etiqueta/{id}', 'Salesmans\SalesController@tag')->name('etiqueta');

    });

    Route::get('/messages/{type}/{box}', 'MessagesController@index')->name('messages.box');
    Route::get('/message/{type}/{id}', 'MessagesController@show')->name('message.info');
    Route::post('/messages/answer/{id}', 'MessagesController@answer')->name('message.answer');
    Route::post('/message/comments/{type}/{id}', 'MessagesController@comments')->name('message.comments');
    Route::post('/messages/destroy', 'MessagesController@destroy')->name('message.destroy');

    /** Administrador */
    Route::get('/report/users', 'Admin\AdminController@list_users')->name('report.users');

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
    Route::get('adresses/destroy/{adress}','AdressesController@destroy')->name('adress.destroy');
    Route::get('adresses/zip_code/{zip}','AdressesController@search_cep')->name('adress.zip_code');
    Route::post('adresses/{action}','AdressesController@store')->name('adress.store');
    Route::get('adresses/{action}/{adress}','AdressesController@edit')->name('adress.edit');
    Route::post('adresses/{action}/{adress}','AdressesController@update')->name('adress.update');
});

Route::get('/pagina/{page}', 'PageController@with_pay')->name('pagina');

Route::get('imagem/{path}','ImageController@show')->where('path', '.+');

/*Route::get('imagem/{path}', function(League\Glide\Server $server, Illuminate\Http\Request $request, $path){
    $server->outputImage($path, $request->input());
})->where('path', '.+');*/

/** Rotas de páginas */
Route::get('/', 'HomeController@index')->name('homepage');

Route::get('/categoria/{category}', 'HomeController@category')->name('pages.products.categoria');

Route::get('/pesquisa/{search}', 'HomeController@search')->name('pages.products.pesquisa');

Route::group(['middleware' => 'auth'], function(){
    Route::get('/favoritos', 'FavoritesController@index')->name('pages.favorites');
    Route::post('/favoritos/adicionar/carrinho', 'FavoritesController@add_cart')->name('pages.favorites.cart');
    Route::get('/favoritos/{product}/adicionar', 'FavoritesController@store')->name('pages.favorites.add');
    Route::get('/favoritos/{product}/deletar', 'FavoritesController@destroy')->name('pages.favorites.delete');
});

Route::group(['as'=>'pages.', 'prefix' => 'carrinho'], function(){
    Route::get('/', 'CartController@index')->name('cart');
    Route::get('/add_product/{id}', 'CartController@add_product')->name('cart.add_product');
    Route::post('/update_qtd', 'CartController@update_qtd')->name('cart.update_qtd');
    Route::get('/remove_product/{id}', 'CartController@remove_product')->name('cart.remove_product');
    Route::post('/observation', 'CartController@add_obs')->name('cart.observation');
    Route::post('/add_address', 'CartController@add_address')->name('cart.add_address');
    Route::post('/type_freight', 'CartController@type_freight')->name('cart.type_freight');

    Route::group(['prefix' => 'checkout', 'middleware' => 'auth'], function(){
        Route::get('/order/{order_key}', 'CheckoutController@order')->name('cart.cart_order');
        Route::get('/payment/{token}', 'CheckoutController@payment')->name('cart.cart_order_payment_payment');
        Route::post('/status/{status}', 'CheckoutController@status')->name('cart.cart_order_payment_status');
        Route::post('/updateorder', 'CheckoutController@updateOrder')->name('cart.cart_update_order');
        Route::get('/confirmaddress/{sha1}', 'CheckoutController@confirmAddress')->name('cart.cart_address');
        Route::post('/confirmaddress/{sha1}', 'CheckoutController@confirmPostAddress')->name('cart.cart_address.post');
        Route::get('/', 'CheckoutController@checkout')->name('cart.cart_checkout');
    });
});
Route::get('/appmoip/connect', 'Accont\ConnectAppMoipController@show')->name('appmoip_connect');
Route::get('/{store}', 'HomeController@stores')->name('pages.store');

Route::get('/{store}/{category}/{product}', 'HomeController@single_page')->name('pages.product');