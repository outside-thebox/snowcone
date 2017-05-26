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

Route::get('/home', 'HomeController@index')->name('home');

Route::group(['middleware' => 'auth'],function(){

    Route::get('master/{id}',['uses' => 'Controller@redirect','as' => 'master']);

    Route::get('tipos_usuarios.getTiposUsuariosWithAdmin',['uses' => 'TiposUsuariosController@getTiposUsuariosWithAdmin','as' => 'tipos_usuarios.getTiposUsuariosWithAdmin']);
    Route::get('tipos_usuarios.getTiposUsuariosWithoutAdmin',['uses' => 'TiposUsuariosController@getTiposUsuariosWithoutAdmin','as' => 'tipos_usuarios.getTiposUsuariosWithoutAdmin']);
    Route::get('tipos_usuarios.all',['uses' => 'TiposUsuariosController@all','as' => 'tipos_usuarios.all']);

    Route::get('users.buscar',['uses' => 'UsersController@buscar','as' => 'users.buscar']);
    Route::get('users.getDataUser',['uses' => 'UsersController@getDataUser','as' => 'users.getDataUser']);
    Route::post("users/activar",array('as' => 'users.activar','uses'  => 'UsersController@activar'));
    Route::post("users/reset_password",array('as' => 'users.reset_password','uses'  => 'UsersController@resetPassword'));
    Route::post("users/desactivar",array('as' => 'users.desactivar','uses'  => 'UsersController@desactivar'));
    Route::resource('users','UsersController');

    Route::get('sucursales.buscar',['uses' => 'SucursalesController@buscar','as' => 'sucursales.buscar']);
    Route::get('sucursal.getData',['uses' => 'SucursalesController@getData','as' => 'sucursal.getData']);
    Route::post("sucursal/activar",array('as' => 'sucursal.activar','uses'  => 'SucursalesController@activar'));
    Route::post("sucursal/desactivar",array('as' => 'sucursal.desactivar','uses'  => 'SucursalesController@desactivar'));
    Route::resource('sucursales','SucursalesController');


    Route::get('unidades_medida.all',['uses' => 'UnidadesMedidaController@all','as' => 'unidades_medida.all']);

    Route::post("articulos/eliminar",array('as' => 'articulos.eliminar','uses'  => 'ArticulosController@eliminar'));
    Route::get('articulos.getDataArticulo',['uses' => 'ArticulosController@getDataArticulo','as' => 'articulos.getDataArticulo']);
    Route::get('articulos.buscar',['uses' => 'ArticulosController@buscar','as' => 'articulos.buscar']);
    Route::resource('articulos','ArticulosController');

});
