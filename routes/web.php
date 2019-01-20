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

#region [Empresa]
Route::get('EmpresaListar', 'EmpresaController@EmpresaListarVista')->name('Empresa.Listar');
Route::get('EmpresaInsertar', 'EmpresaController@EmpresaInsertarVista')->name('Empresa.Insertar');
Route::get('EmpresaEditar/{idEmpresa}', 'EmpresaController@EmpresaEditarVista')->name('Empresa.Editar');

Route::post('EmpresaListarJson', 'EmpresaController@EmpresaListarJson');
Route::post('EmpresaInsertarJson', 'EmpresaController@EmpresaInsertarJson');
Route::post('EmpresaEditarJson', 'EmpresaController@EmpresaEditarJson');
#endregion

#region [Punto Venta]
Route::get('PuntoVentaListar', 'PuntoVentaController@PuntoVentaListarVista')->name('PuntoVenta.Listar');
Route::get('PuntoVentaInsertar', 'PuntoVentaController@PuntoVentaInsertarVista')->name('PuntoVenta.Insertar');
Route::get('PuntoVentaEditar/{idPuntoVenta}', 'PuntoVentaController@PuntoVentaEditarVista')->name('PuntoVenta.Editar');

Route::post('PuntoVentaListarJson', 'PuntoVentaController@PuntoVentaListarJson');
Route::post('PuntoVentaInsertarJson', 'PuntoVentaController@PuntoVentaInsertarJson');
Route::post('PuntoVentaEditarJson', 'PuntoVentaController@PuntoVentaEditarJson');
Route::post('UbigeoListarJson', 'UbigeoController@UbigeoListarJson');
#endregion

#region Jackpot
Route::get('JackpotListar', 'JackpotController@JackpotListarVista')->name('Jackpot.Listar');
Route::get('JackpotInsertar', 'JackpotController@JackpotInsertarVista')->name('Jackpot.Insertar');
Route::get('JackpotEditar/{idJackpot}', 'JackpotController@JackpotEditarVista')->name('Jackpot.Editar');
#endregion

#region ConfiguracionJackpot
Route::get('ConfiguracionJackpotListar', 'ConfiguracionJackpotController@ConfiguracionJackpotListarVista')->name('ConfiguracionJackpot.Listar');
Route::get('ConfiguracionJackpotInsertar', 'ConfiguracionJackpotController@ConfiguracionJackpotInsertarVista')->name('ConfiguracionJackpot.Insertar');
Route::get('ConfiguracionJackpotEditar/{idConfiguracionJackpot}', 'ConfiguracionJackpotController@ConfiguracionJackpotEditarVista')->name('ConfiguracionJackpot.Editar');

Route::post('ConfiguracionJackpotListarJson','ConfiguracionJackpotController@ConfiguracionJackpotListarJson');
Route::post('ConfiguracionJackpotInsertarJson','ConfiguracionJackpotController@ConfiguracionJackpotInsertarJson');
Route::post('ConfiguracionJackpotEditarJson','ConfiguracionJackpotController@ConfiguracionJackpotEditarJson');
Route::post('ConfiguracionPozoListarJson','ConfiguracionPozoController@ConfiguracionPozoListarJson');
Route::post('ConfiguracionPozoEliminarJson','ConfiguracionPozoController@ConfiguracionPozoEliminarJson');
Route::post('CambiarEstadoConfiguracionPozoJson','ConfiguracionPozoController@CambiarEstadoConfiguracionPozoJson');
#endregion

Route::get('ProgresivoListar', 'ProgresivoController@ProgresivoListarVista')->name('Progresivo.Listar');
Route::get('ProgresivoInsertar', 'ProgresivoController@ProgresivoInsertarVista')->name('Progresivo.Insertar');
Route::get('ProgresivoConfiguracion', 'ProgresivoController@ProgresivoConfiguracionVista')->name('Progresivo.Configuracion');
