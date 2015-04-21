<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Aqui es donde están definias todas las rutas a las que la aplicación va a responder.
|
*/

// Rutas del usuario no autenticado.
Route::get('/', 'InicioController@index');
Route::get('login', 'InicioController@login');
Route::post('login', 'InicioController@autenticar');
Route::get('logout', 'InicioController@logout');

// Rutas del inventario
Route::get('inventario', 'InventarioController@index');
Route::get('inventario/create', 'InventarioController@create');
Route::post('inventario/create', 'InventarioController@store');
Route::get('inventario/details/{id}', 'InventarioController@show');
Route::get('inventario/edit/{id}', 'InventarioController@edit');
Route::post('inventario/edit/{id}', 'InventarioController@update');
Route::delete('inventario/delete/{id}', 'InventarioController@destroy');

// Rutas de categorías
Route::get('admin/categorias', 'CategoriasController@index');
Route::post('admin/categorias/create', 'CategoriasController@store');
Route::delete('admin/categorias/delete/{id}', 'CategoriasController@destroy');
Route::put('admin/categorias/edit/{id}', 'CategoriasController@update');

// Rutas de estados
Route::get('admin/estados', 'EstadosArticuloController@index');
Route::post('admin/estados/create', 'EstadosArticuloController@store');
Route::delete('admin/estados/delete/{id}', 'EstadosArticuloController@destroy');
Route::put('admin/estados/edit/{id}', 'EstadosArticuloController@update');

// Rutas de administradores
Route::get('admin/administradores', 'AdministradoresController@index');
Route::post('admin/administradores/create', 'AdministradoresController@store');
Route::delete('admin/administradores/delete/{id}', 'AdministradoresController@destroy');
Route::post('admin/administradores/buscarusuario', 'AdministradoresController@buscar');

// Rutas de reservas
Route::get('reservas/create', 'ReservasController@create');
Route::post('inventario/create', 'InventarioController@store');