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


Route::get('EmpresaListar', 'EmpresaController@EmpresaListarVista')->name('Empresa.Listar');
Route::get('EmpresaInsertar', 'EmpresaController@EmpresaInsertarVista')->name('Empresa.Insertar');
Route::get('EmpresaEditar/{idEmpresa}', 'EmpresaController@EmpresaEditarVista')->name('Empresa.Editar');

Route::post('EmpresaListarJson','EmpresaController@EmpresaListarJson');
Route::post('EmpresaInsertarJson','EmpresaController@EmpresaInsertarJson');
Route::post('EmpresaEditarJson','EmpresaController@EmpresaEditarJson');



Route::get('PuntoVentaListar', 'PuntoVentaController@PuntoVentaListarVista')->name('PuntoVenta.Listar');
Route::get('PuntoVentaInsertar', 'PuntoVentaController@PuntoVentaInsertarVista')->name('PuntoVenta.Insertar');
Route::get('PuntoVentaEditar/{idPuntoVenta}', 'PuntoVentaController@PuntoVentaEditarVista')->name('PuntoVenta.Editar');

Route::post('PuntoVentaListarJson','PuntoVentaController@PuntoVentaListarJson');
Route::post('PuntoVentaInsertarJson','PuntoVentaController@PuntoVentaInsertarJson');
Route::post('PuntoVentaEditarJson','PuntoVentaController@PuntoVentaEditarJson');
Route::post('UbigeoListarJson','UbigeoController@UbigeoListarJson');