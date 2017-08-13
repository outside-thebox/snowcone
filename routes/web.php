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
    return redirect(route('login'));
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');


Route::group(['middleware' => 'auth'],function(){

    Route::get('master/{id}',['uses' => 'Controller@redirect','as' => 'master']);
    Route::get('unidades_medida.all',['uses' => 'UnidadesMedidaController@all','as' => 'unidades_medida.all']);
    Route::get('proveedores.all',['uses' => 'ProveedoresController@all','as' => 'proveedores.all']);
    Route::get('sucursales.buscar', ['uses' => 'SucursalesController@buscar', 'as' => 'sucursales.buscar']);
    Route::get('articulosxstock.buscarxstock', ['uses' => 'ArticulosXStockController@buscarxstock', 'as' => 'articulos.buscarxstock']);
    Route::post('presupuesto.buscar', ['uses' => 'PresupuestoController@buscar', 'as' => 'presupuesto.buscar']);
    Route::get('articulos.buscar', ['uses' => 'ArticulosController@buscar', 'as' => 'articulos.buscar']);
    Route::get('articulosxstock.buscarxstockall', ['uses' => 'ArticulosXStockController@buscarxstockall', 'as' => 'articulos.buscarxstockall']);
    Route::post('presupuesto.buscar',['uses' => 'PresupuestoController@buscar','as' => 'presupuesto.buscar']);
    Route::post('presupuesto.updateEstado',['uses' => 'PresupuestoController@updateEstado','as' => 'presupuesto.updateEstado']);

    Route::group(['middleware' => 'tipousuarios: 1'],function() {

        Route::get('sucursal.getData', ['uses' => 'SucursalesController@getData', 'as' => 'sucursal.getData']);
        Route::post("sucursal/activar", array('as' => 'sucursal.activar', 'uses' => 'SucursalesController@activar'));
        Route::post("sucursal/desactivar", array('as' => 'sucursal.desactivar', 'uses' => 'SucursalesController@desactivar'));
        Route::resource('sucursales', 'SucursalesController');
    });

    Route::group(['middleware' => 'tipousuarios: 1|2'],function() {

        Route::get('tipos_usuarios.getTiposUsuariosWithAdmin', ['uses' => 'TiposUsuariosController@getTiposUsuariosWithAdmin', 'as' => 'tipos_usuarios.getTiposUsuariosWithAdmin']);
        Route::get('tipos_usuarios.getTiposUsuariosWithoutAdmin', ['uses' => 'TiposUsuariosController@getTiposUsuariosWithoutAdmin', 'as' => 'tipos_usuarios.getTiposUsuariosWithoutAdmin']);
        Route::get('tipos_usuarios.all', ['uses' => 'TiposUsuariosController@all', 'as' => 'tipos_usuarios.all']);
        Route::get('users.buscar', ['uses' => 'UsersController@buscar', 'as' => 'users.buscar']);
        Route::get('users.getDataUser', ['uses' => 'UsersController@getDataUser', 'as' => 'users.getDataUser']);
        Route::post("users/activar", array('as' => 'users.activar', 'uses' => 'UsersController@activar'));
        Route::post("users/reset_password", array('as' => 'users.reset_password', 'uses' => 'UsersController@resetPassword'));
        Route::post("users/desactivar", array('as' => 'users.desactivar', 'uses' => 'UsersController@desactivar'));
        Route::resource('users', 'UsersController');
    });

    Route::group(['middleware' => 'tipousuarios: 1|2'],function() {

        Route::post("articulos/eliminar", array('as' => 'articulos.eliminar', 'uses' => 'ArticulosController@eliminar'));
        Route::get('articulos.getDataArticulo', ['uses' => 'ArticulosController@getDataArticulo', 'as' => 'articulos.getDataArticulo']);
        Route::resource('articulos', 'ArticulosController');
    });

    Route::group(['middleware' => 'tipousuarios:1|2|3'], function () {

        Route::resource('boleta', 'BoletasController');
        Route::get('boleta.buscar', ['uses' => 'BoletasController@buscarAgrupadoBoleta', 'as' => 'boleta.buscarAgrupadoBoleta']);
        Route::get('boleta.exportarPDF', ['uses' => 'BoletasController@exportarPDF', 'as' => 'boleta.exportarPDF']);
        Route::get('articulosxstock.prices', ['uses' => 'ArticulosXStockController@prices', 'as' => 'articulos.prices']);
        Route::post('articulosxstock.updatePrices', ['uses' => 'ArticulosXStockController@updatePrices', 'as' => 'articulosxstock.updatePrices']);
        Route::get('articulosxstock.addBoleta', ['uses' => 'ArticulosXStockController@addBoleta', 'as' => 'articulosxstock.addBoleta']);
        Route::post('articulosxstock.updateBoleta', ['uses' => 'ArticulosXStockController@updateBoleta', 'as' => 'articulosxstock.updateBoleta']);
        Route::post('articulosxstock.datosinput', ['uses' => 'ArticulosXStockController@datosinput', 'as' => 'articulosxstock.datosinput']);

    });

    Route::group(['middleware' => 'tipousuarios:4|3|2'], function () {

        Route::get('presupuesto/exportarPDF/{ID}',['uses' => 'PresupuestoController@exportarPDF','as' => 'presupuesto/exportarPDF']);
        Route::resource('presupuesto','PresupuestoController');
    });

    Route::group(['middleware' => 'tipousuarios:2|3|5'], function () {
        Route::resource('caja', 'CajaController');
        Route::post('caja.cerrarCaja',['uses' => 'CajaController@cerrarCaja','as' => 'caja.cerrarCaja']);
    });



});
