<?php


#region [Autenticacion]
Route::get('/', 'AutenticacionController@LoginVista')->name('Login');
Route::post('ValidarLoginJsonFk', 'AutenticacionController@ValidarLoginJson')->name('ValidarLoginJson');
Route::post('CerrarSesionFk', 'AutenticacionController@CerrarSesionJson')->name('CerrarSesion');
#endregion

Route::middleware(['auth', 'permisos'])->group(function () {

#region [Dashboard]
    Route::get('Dashboard', 'HomeController@DashboardVista')->name('Dashboard');
#endregion
#region [Empresa]
    Route::get('EmpresaListar', 'EmpresaController@EmpresaListarVista')->name('Empresa.Listar');
    Route::get('EmpresaInsertar', 'EmpresaController@EmpresaInsertarVista')->name('Empresa.Insertar');
    Route::get('EmpresaEditar/{idEmpresa}', 'EmpresaController@EmpresaEditarVista')->name('Empresa.Editar');
    Route::post('EmpresaInsertarJson', 'EmpresaController@EmpresaInsertarJson');
    Route::post('EmpresaEditarJson', 'EmpresaController@EmpresaEditarJson');
#endregion

#region [Punto Venta]
    Route::get('PuntoVentaListar', 'PuntoVentaController@PuntoVentaListarVista')->name('PuntoVenta.Listar');
    Route::get('PuntoVentaEditar/{idPuntoVenta}', 'PuntoVentaController@PuntoVentaEditarVista')->name('PuntoVenta.Editar');
    Route::post('PuntoVentaEditarJson', 'PuntoVentaController@PuntoVentaEditarJson');
#endregion

#region [Jackpot]
    Route::get('JackpotListar', 'JackpotController@JackpotListarVista')->name('Jackpot.Listar');
    Route::get('JackpotInsertar', 'JackpotController@JackpotInsertarVista')->name('Jackpot.Insertar');
    Route::get('JackpotEditar/{idJackpot}', 'JackpotController@JackpotEditarVista')->name('Jackpot.Editar');
#endregion

#region [Venta]
    Route::get('VentanaCaja', 'VentaController@Index')->name('Venta.Index');
    Route::get('VentanaCaja2', 'VentaController@IndexNuevo')->name('Venta.IndexNuevo');
#endregion

#region [ConfiguracionJackpot]
    Route::get('ConfiguracionJackpotListar', 'ConfiguracionJackpotController@ConfiguracionJackpotListarVista')->name('ConfiguracionJackpot.Listar');
    Route::get('ConfiguracionJackpotInsertar', 'ConfiguracionJackpotController@ConfiguracionJackpotInsertarVista')->name('ConfiguracionJackpot.Insertar');
    Route::get('ConfiguracionJackpotEditar/{idConfiguracionJackpot}', 'ConfiguracionJackpotController@ConfiguracionJackpotEditarVista')->name('ConfiguracionJackpot.Editar');
    Route::post('ConfiguracionJackpotInsertarJson', 'ConfiguracionJackpotController@ConfiguracionJackpotInsertarJson');
    Route::post('ConfiguracionJackpotEditarJson', 'ConfiguracionJackpotController@ConfiguracionJackpotEditarJson');
#endregion

#region [Caja]
    Route::get('CajaListar', 'CajaController@CajaListarVista')->name('Caja.Listar');
    Route::get('CajaInsertar', 'CajaController@CajaInsertarVista')->name('Caja.Insertar');
    Route::get('CajaEditar/{idCaja}', 'CajaController@CajaEditarVista')->name('Caja.Editar');
    Route::post('CajaInsertarJson', 'CajaController@CajaInsertarJson');
    Route::post('CajaEditarJson', 'CajaController@CajaEditarJson');
#endregion

#region [AperturaCaja]
    Route::get('AperturaCajaListar', 'AperturaCajaController@AperturaCajaListarVista')->name('AperturaCaja.Listar');
    Route::get('AperturaCajaInsertar', 'AperturaCajaController@AperturaCajaInsertarVista')->name('AperturaCaja.Insertar');
    Route::get('AperturaCajaEditar/{idAperturaCaja}', 'AperturaCajaController@AperturaCajaEditarVista')->name('AperturaCaja.Editar');
    Route::post('AperturaCajaInsertarJson', 'AperturaCajaController@AperturaCajaInsertarJson');
    Route::post('AperturaCajaEditarJson', 'AperturaCajaController@AperturaCajaEditarJson');
    Route::post('AperturaRevisarJson', 'AperturaCajaController@AperturaRevisarJson');
#endregion

#region [Turno]
    Route::get('TurnoListar', 'TurnoController@TurnoListarVista')->name('Turno.Listar');
    Route::get('TurnoInsertar', 'TurnoController@TurnoInsertarVista')->name('Turno.Insertar');
    Route::get('TurnoEditar/{idTurno}', 'TurnoController@TurnoEditarVista')->name('Turno.Editar');
    Route::post('TurnoInsertarJson', 'TurnoController@TurnoInsertarJson');
    Route::post('TurnoEditarJson', 'TurnoController@TurnoEditarJson');
#endregion

#region [DineroDefault]
    Route::get('DineroDefaultListar', 'DineroDefaultController@DineroDefaultListarVista')->name('DineroDefault.Listar');
    Route::get('DineroDefaultInsertar', 'DineroDefaultController@DineroDefaultInsertarVista')->name('DineroDefault.Insertar');
    Route::get('DineroDefaultEditar/{idDineroDefault}', 'DineroDefaultController@DineroDefaultEditarVista')->name('DineroDefault.Editar');
    Route::post('DineroDefaultInsertarJson', 'DineroDefaultController@DineroDefaultInsertarJson');
    Route::post('DineroDefaultEditarJson', 'DineroDefaultController@DineroDefaultEditarJson');
#endregion

#region [TipoPago]
    Route::get('TipoPagoListar', 'TipoPagoController@TipoPagoListarVista')->name('TipoPago.Listar');
    Route::get('TipoPagoInsertar', 'TipoPagoController@TipoPagoInsertarVista')->name('TipoPago.Insertar');
    Route::get('TipoPagoEditar/{idTipoPago}', 'TipoPagoController@TipoPagoEditarVista')->name('TipoPago.Editar');
    Route::post('TipoPagoInsertarJson', 'TipoPagoController@TipoPagoInsertarJson');
    Route::post('TipoPagoEditarJson', 'TipoPagoController@TipoPagoEditarJson');
#endregion

#region [TipoApuesta]
    Route::get('TipoApuestaListar', 'TipoApuestaController@TipoApuestaListarVista')->name('TipoApuesta.Listar');
    Route::get('TipoApuestaInsertar', 'TipoApuestaController@TipoApuestaInsertarVista')->name('TipoApuesta.Insertar');
    Route::get('TipoApuestaEditar/{idTipoApuesta}', 'TipoApuestaController@TipoApuestaEditarVista')->name('TipoApuesta.Editar');
    Route::post('TipoApuestaInsertarJson', 'TipoApuestaController@TipoApuestaInsertarJson');
    Route::post('TipoApuestaEditarJson', 'TipoApuestaController@TipoApuestaEditarJson');
#endregion

#region [Cliente]
//    Route::get('ClienteListar', 'ClienteController@ClienteListarVista')->name('Cliente.Listar');
//    Route::get('ClienteInsertar', 'ClienteController@ClienteInsertarVista')->name('Cliente.Insertar');
//    Route::get('ClienteEditar/{idCliente}', 'ClienteController@ClienteEditarVista')->name('Cliente.Editar');
//    Route::post('ClienteInsertarJson', 'ClienteController@ClienteInsertarJson');
//    Route::post('ClienteEditarJson', 'ClienteController@ClienteEditarJson');
#endregion

#region [Juego]
    Route::get('JuegoListarVista', 'JuegoController@JuegoListarVista')->name('Juego.Listar');
    Route::get('JuegoEditarVista/{IdJuego}', 'JuegoController@JuegoEditarVista')->name('Juego.Editar');
    Route::post('JuegoEditarJson', 'JuegoController@JuegoEditarJson');
#endregion

#region [Reporte]
    Route::get('ReportedeVentasVista', 'ReporteController@ReporteApuestaVista')->name('Reporte.Ventas');
    Route::get('ReporteVentasEventosVista', 'ReporteController@ReporteVentaVista')->name('Reporte.VentaEvento');
    Route::get('ReporteHistorialEventosVista', 'ReporteController@ReporteVentaJuegoVista')->name('Reporte.VentaJuego');
    Route::get('ReporteCierraVentaVista', 'ReporteController@ReporteCierraVentaVista')->name('Reporte.CierreCaja');
    Route::get('ReporteHistorialTicketVista', 'ReporteController@ReporteHistorialTicketVista')->name('Reporte.HistorialTicket');
    Route::get('ReporteDetalleApuestaEventoVista', 'ReporteController@ReporteHistorialGanadoresVista')->name('Reporte.DetalleApuestaEvento');
    Route::get('ReporteJackPot', 'ReporteController@ReporteJackPotVista')->name('Reporte.JackPot');
    Route::get('ReporteAlertasVista', 'ReporteController@ReporteAlertasVista')->name('Reporte.Alerta');

#endregion
    Route::get('ProgresivoListar', 'ProgresivoController@ProgresivoListarVista')->name('Progresivo.Listar');
    Route::get('ProgresivoInsertar', 'ProgresivoController@ProgresivoInsertarVista')->name('Progresivo.Insertar');
    Route::get('ProgresivoConfiguracion', 'ProgresivoController@ProgresivoConfiguracionVista')->name('Progresivo.Configuracion');
    Route::get('UsuarioPuntoVenta', 'UsuarioPuntoVentaController@UsuarioPuntoVentaListarVista')->name('UsuarioPuntoVenta.Listar');
    Route::get('UsuarioPuntoVentaEditar/{idUsuarioPuntoVenta}', 'UsuarioPuntoVentaController@UsuarioPuntoVentaEditarVista')->name('UsuarioPuntoVenta.Editar');

    Route::get('Auditoria', 'ReporteController@ReporteAuditoriaVista')->name('Auditoria');
    Route::get('TipoAlertaVista', 'SeguridadController@TipoAlertaVista')->name('TipoAlerta.Listar');
    Route::get('TipoAlertaPuntoVenta/{idTipoAlerta}', 'SeguridadController@TipoAlertaPuntoVentaVista');

    Route::post('TipoAlertaPuntoVentaInsertarJson', 'SeguridadController@TipoAlertaPuntoVentaInsertarJson');
});
/*GenerarExcel*/

Route::post('GenerarExcelFk', 'HomeController@GenerarExcel');
Route::post('GenerarArchivoExcelJackpotFk', 'HomeController@GenerarArchivoExcelJackpot');

/*Juego*/
Route::post('JuegoListarJsonFk', 'JuegoController@JuegoListarJson');

/*Ventana Caja*/
Route::post('VentaDatosJsonFk', 'VentaController@VentaDatosJson');
Route::post('VentaDatosJsonFk', 'VentaController@VentaDatosJson');
Route::post('GuardarTicketFk', 'VentaController@GuardarTicket');
Route::post('BuscarTicketFk', 'VentaController@BuscarTicket');
Route::post('EventoDatosJsonFk', 'VentaController@EventoDatosJson');
Route::post('HistorialJackpotDatosJsonFk', 'VentaController@HistorialJackpotDatosJson');
Route::post('HistorialDatosJsonFk', 'VentaController@HistorialDatosJson');
Route::post('JackpotDatosJsonFk', 'VentaController@JackpotDatosJson');
Route::post('ImprimirDatosJsonFk', 'VentaController@ImprimirDatosJson');
Route::post('GuardarGanadorEventoFk', 'VentaController@GuardarGanadorEvento');
Route::post('JugadoresDatosJsonFk', 'VentaController@JugadoresDatosJson');
Route::post('CajaTablaFk', 'VentaController@CajaTablaFk');


/*Reportes*/
Route::post('ReporteHistorialTicketJsonFk', 'ReporteController@ReporteHistorialTicketJson');
Route::post('ReporteVentaJsonFk', 'ReporteController@ReporteVentaJson');
Route::post('ReporteVentaJuegoFk', 'ReporteController@ReporteVentaJuegoJson');
Route::post('ReporteApuestaJsonFk', 'ReporteController@ReporteApuestaJson');
Route::post('ObtenerPuntosVentaZonaComercialJsonFk', 'ReporteController@ObtenerPuntosVentaZonaComercialJson');

/*ConfiguracionJackpot*/
Route::post('ConfiguracionPozoSegunConfJackPotFk', 'ReporteController@ConfiguracionPozoSegunConfJackPot');
Route::post('PozoJackPotSegunJackPotIdFk', 'ReporteController@PozoJackPotSegunJackPotId');
Route::post('JackPotSegunidJackpotFk', 'ReporteController@JackPotSegunidJackpot');

/*Auditoria*/
Route::post('ReporteAuditoriaJsonFk', 'ReporteController@ReporteAuditoriaJson');

/*Usuario Punto Venta*/
Route::post('UsuarioPuntoVentaListarJsonFk', 'UsuarioPuntoVentaController@UsuarioPuntoVentaListarJson');
Route::post('UsuarioPuntoVentaListaObtenerFk', 'UsuarioPuntoVentaController@UsuarioPuntoVentaListaObtener');
Route::post('AgregarPuntoVentaUsuarioJsonFk', 'UsuarioPuntoVentaController@AgregarPuntoVentaUsuarioJson');
Route::post('QuitarPuntoVentaUsuarioJsonFk', 'UsuarioPuntoVentaController@QuitarPuntoVentaUsuarioJson');

/*Animacion*/
Route::get('AnimacionVista', 'AnimacionController@AnimacionVista')->name('AnimacionVista');

Route::post('ReporteJackPotListarJson', 'ReporteController@ReporteJackPotListarJson');
Route::post('ConfiguracionJackpotListarJson', 'ConfiguracionJackpotController@ConfiguracionJackpotListarJson');


Route::post('ReporteHistorialGanadoresListarJsonFk', 'ReporteController@ReporteHistorialGanadoresListarJson');
Route::post('ReporteCierreCajaFk', 'ReporteController@ReporteCierreCajaFk');

/*Configuracion Evento*/
Route::get('ConfiguracionGeneral', 'ConfiguracionGeneralController@ConfiguracionGeneralVista')->name('ConfiguracionEvento');
Route::post('ConfiguracionEventoJsonFk', 'ConfiguracionGeneralController@ConfiguracionEventoInsertarJson');
Route::post('ConfiguracionCobrarTicketJsonFk', 'ConfiguracionGeneralController@ConfiguracionCobrarTicketJson');
Route::post('ConfiguracionCuentaCorreoJsonFk', 'ConfiguracionGeneralController@ConfiguracionCuentaCorreoJson');
Route::post('ConfiguracionEventoMostrarFk', 'ConfiguracionGeneralController@ConfiguracionEventoMostrar');


Route::post('ConfiguracionPozoListarJsonFk', 'ConfiguracionPozoController@ConfiguracionPozoListarJson');

/*Caja*/
Route::post('CajaListarJsonFk', 'CajaController@CajaListarJson');
Route::post('CajaPuntoVentaUsuarioJsonFk', 'CajaController@CajaPuntoVentaUsuarioJson');
Route::post('AperturaCajaListarJsonFk', 'AperturaCajaController@AperturaCajaListarJson');
Route::post('TurnoListarJsonFk', 'TurnoController@TurnoListarJson');

Route::post('DineroDefaultListarJsonFk', 'DineroDefaultController@DineroDefaultListarJson');
Route::post('TipoPagoListarJsonFk', 'TipoPagoController@TipoPagoListarJson');
Route::post('EmpresaListarJsonFk', 'EmpresaController@EmpresaListarJson');
Route::post('PuntoVentaListarJsonFk', 'PuntoVentaController@PuntoVentaListarJson');
Route::post('UbigeoListarJsonFk', 'UbigeoController@UbigeoListarJson');
Route::post('TipoApuestaListarJsonFk', 'TipoApuestaController@TipoApuestaListarJson');
//Route::post('ClienteListarJsonFk', 'ClienteController@ClienteListarJson');
Route::post('SincronizarPuntoVentaFk', 'PuntoVentaController@SincronizarPuntoVentaAPI');
Route::post('ConfiguracionPozoEliminarJsonFk', 'ConfiguracionPozoController@ConfiguracionPozoEliminarJson');
Route::post('CambiarEstadoConfiguracionPozoJsonFk', 'ConfiguracionPozoController@CambiarEstadoConfiguracionPozoJson');

Route::post('ListdoUsuariosSelectFk', 'SeguridadController@UsuarioListarJson');
Route::post('CambiarPerfilUsuarioFk', 'SeguridadController@ActualizarPerfilUsuario');
Route::post('PermisoPerfilCheckFk', 'SeguridadController@PermisoPerfilJson');
Route::get('BarridoPermisosFk', 'SeguridadController@BarridoPermisos');
Route::post('ListdoPermisosPerfilFk', 'SeguridadController@PermisoPerfilListarJson');
Route::get('Seguridad', 'SeguridadController@PermisosUsuarioVista')->name('Seguridad.PermisosUsuario');
Route::post('DataAuditoriaRegistroFk', 'SeguridadController@DataAuditoriaJson');
Route::post('AperturaCajaCerrarFk', 'AperturaCajaController@AperturaCajaCerrarFk');
Route::post('AperturaCajaListarActivaFk', 'AperturaCajaController@AperturaCajaListarActiva');

Route::post('PuntoVentaListarUsuarioJsonFk', 'PuntoVentaController@PuntoVentaListarUsuarioJson');
Route::post('PuntoVentaListaGeneralFk', 'PuntoVentaController@PuntoVentaListaGeneralJson');
Route::post('TipoAlertaListarJsonFk', 'SeguridadController@TipoAlertaListarJson');
Route::post('PuntoVentaUsuarioAlertaJsonFk', 'PuntoVentaController@PuntoVentaUsuarioAlertaJson');
Route::post('TipoAlertaPuntoVentaJsonFk', 'SeguridadController@TipoAlertaPuntoVentaJson');

/*Seguridad*/
Route::post('AgregarTodoPermisosJsonFk', 'SeguridadController@AgregarTodoPermisosJson');
Route::post('QuitarTodoPermisosJsonFk', 'SeguridadController@QuitarTodoPermisosJson');