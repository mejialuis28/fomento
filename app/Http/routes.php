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
Route::get('enviarmail','InicioController@enviarmail');

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
Route::post('reservas/buscaritems', 'ReservasController@buscaritems');
Route::post('reservas/create', 'ReservasController@store');
Route::get('reservas/misreservas/', 'ReservasController@misreservas');
Route::get('reservas/misreservas/details/{id}','ReservasController@details');
Route::delete('reservas/misreservas/cancelar/{id}','ReservasController@destroy');
Route::get('reservas','ReservasController@index');
Route::post('reservas/rechazar','ReservasController@rechazar');

// Rutas de préstamos
Route::get('prestamos', 'PrestamosController@index');
Route::get('prestamos/create', 'PrestamosController@create');
Route::post('prestamos/create', 'PrestamosController@store');
Route::get('prestamos/devolucion', 'PrestamosController@devolucion');
Route::post('prestamos/devolucion', 'PrestamosController@devolver');
Route::get('prestamos/details/{id}','PrestamosController@details');
Route::get('prestamos/nuevo', 'PrestamosController@nuevo');
Route::post('prestamos/nuevo', 'PrestamosController@guardar');
Route::post('prestamos/buscarresponsable', 'PrestamosController@buscarResponsable');

// Rutas de préstamos
Route::get('reportes/inventario', 'ReportesController@inventario');
Route::get('reportes/reservas', 'ReportesController@reservas');
Route::get('reportes/prestamos', 'ReportesController@prestamos');
Route::get('reportes/retrasados', 'ReportesController@retrasados');
Route::get('reportes/indicadores', 'ReportesController@indicadores');