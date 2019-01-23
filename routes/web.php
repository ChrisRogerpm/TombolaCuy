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

#region [Jackpot]
Route::get('JackpotListar', 'JackpotController@JackpotListarVista')->name('Jackpot.Listar');
Route::get('JackpotInsertar', 'JackpotController@JackpotInsertarVista')->name('Jackpot.Insertar');
Route::get('JackpotEditar/{idJackpot}', 'JackpotController@JackpotEditarVista')->name('Jackpot.Editar');
#endregion

#region [ConfiguracionJackpot]
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

#region [Caja]
Route::get('CajaListar', 'CajaController@CajaListarVista')->name('Caja.Listar');
Route::get('CajaInsertar', 'CajaController@CajaInsertarVista')->name('Caja.Insertar');
Route::get('CajaEditar/{idCaja}', 'CajaController@CajaEditarVista')->name('Caja.Editar');

Route::post('CajaListarJson', 'CajaController@CajaListarJson');
Route::post('CajaInsertarJson', 'CajaController@CajaInsertarJson');
Route::post('CajaEditarJson', 'CajaController@CajaEditarJson');
#endregion

#region [AperturaCaja]
Route::get('AperturaCajaListar', 'AperturaCajaController@AperturaCajaListarVista')->name('AperturaCaja.Listar');
Route::get('AperturaCajaInsertar', 'AperturaCajaController@AperturaCajaInsertarVista')->name('AperturaCaja.Insertar');
Route::get('AperturaCajaEditar/{idAperturaCaja}', 'AperturaCajaController@AperturaCajaEditarVista')->name('AperturaCaja.Editar');

Route::post('AperturaCajaListarJson', 'AperturaCajaController@AperturaCajaListarJson');
Route::post('AperturaCajaInsertarJson', 'AperturaCajaController@AperturaCajaInsertarJson');
Route::post('AperturaCajaEditarJson', 'AperturaCajaController@AperturaCajaEditarJson');
#endregion

#region [Turno]
Route::get('TurnoListar', 'TurnoController@TurnoListarVista')->name('Turno.Listar');
Route::get('TurnoInsertar', 'TurnoController@TurnoInsertarVista')->name('Turno.Insertar');
Route::get('TurnoEditar/{idTurno}', 'TurnoController@TurnoEditarVista')->name('Turno.Editar');

Route::post('TurnoListarJson', 'TurnoController@TurnoListarJson');
Route::post('TurnoInsertarJson', 'TurnoController@TurnoInsertarJson');
Route::post('TurnoEditarJson', 'TurnoController@TurnoEditarJson');
#endregion

#region [TipoPago]
Route::get('TipoPagoListar', 'TipoPagoController@TipoPagoListarVista')->name('TipoPago.Listar');
Route::get('TipoPagoInsertar', 'TipoPagoController@TipoPagoInsertarVista')->name('TipoPago.Insertar');
Route::get('TipoPagoEditar/{idTipoPago}', 'TipoPagoController@TipoPagoEditarVista')->name('TipoPago.Editar');

Route::post('TipoPagoListarJson', 'TipoPagoController@TipoPagoListarJson');
Route::post('TipoPagoInsertarJson', 'TipoPagoController@TipoPagoInsertarJson');
Route::post('TipoPagoEditarJson', 'TipoPagoController@TipoPagoEditarJson');
#endregion

#region [TipoApuesta]
Route::get('TipoApuestaListar', 'TipoApuestaController@TipoApuestaListarVista')->name('TipoApuesta.Listar');
Route::get('TipoApuestaInsertar', 'TipoApuestaController@TipoApuestaInsertarVista')->name('TipoApuesta.Insertar');
Route::get('TipoApuestaEditar/{idTipoApuesta}', 'TipoApuestaController@TipoApuestaEditarVista')->name('TipoApuesta.Editar');

Route::post('TipoApuestaListarJson', 'TipoApuestaController@TipoApuestaListarJson');
Route::post('TipoApuestaInsertarJson', 'TipoApuestaController@TipoApuestaInsertarJson');
Route::post('TipoApuestaEditarJson', 'TipoApuestaController@TipoApuestaEditarJson');
#endregion

#region [Cliente]
Route::get('ClienteListar', 'ClienteController@ClienteListarVista')->name('Cliente.Listar');
Route::get('ClienteInsertar', 'ClienteController@ClienteInsertarVista')->name('Cliente.Insertar');
Route::get('ClienteEditar/{idCliente}', 'ClienteController@ClienteEditarVista')->name('Cliente.Editar');

Route::post('ClienteListarJson', 'ClienteController@ClienteListarJson');
Route::post('ClienteInsertarJson', 'ClienteController@ClienteInsertarJson');
Route::post('ClienteEditarJson', 'ClienteController@ClienteEditarJson');
#endregion
Route::get('ProgresivoListar', 'ProgresivoController@ProgresivoListarVista')->name('Progresivo.Listar');
Route::get('ProgresivoInsertar', 'ProgresivoController@ProgresivoInsertarVista')->name('Progresivo.Insertar');
Route::get('ProgresivoConfiguracion', 'ProgresivoController@ProgresivoConfiguracionVista')->name('Progresivo.Configuracion');
