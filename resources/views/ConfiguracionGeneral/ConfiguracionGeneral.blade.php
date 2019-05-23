@extends('Shared.layout')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-primary">
                <div class="panel-body" style="padding-bottom: 10px;">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="block">
                                <div class="block-content-outer">
                                    <div class="block-content-inner">
                                        <div class="row">
                                            <div class="col-md-12 col-xs-12 col-sm-12">
                                                <h6>
                                                    <i class="glyphicon glyphicon-th mr-2"></i>
                                                    Configuración General
                                                </h6>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-12 col-md-6">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <div class="panel-title text-center">Configuración Intervalo Generacion Evento</div>
                </div>
                <div class="panel-body">
                    <form id="frmConfiguracionEvento" autocomplete="off">
                        {{csrf_field()}}
                        <input type="hidden" class="idConfiguracion" name="idConfiguracion">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Hora de Inicio - Intervalo</label>
                                    <input type="time" name="HoraInicioIntervalo"
                                           class="form-control input-sm" id="HoraInicioIntervalo"/>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Hora de Finalización - Intervalo</label>
                                    <input type="time" name="HoraFinIntervalo" class="form-control input-sm"
                                           id="HoraFinIntervalo"/>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="panel-footer">
                    <div class="row">
                        <div class="col-md-4 col-md-offset-8">
                            <button class="btn btn-primary btn-block btn-sm pull-right"
                                    id="btnGuardarConfiguracionEvento">Guardar
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xs-12 col-md-6">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <div class="panel-title text-center">Configuración Cobrar Ticket de Punto de Venta distinto</div>
                </div>
                <div class="panel-body">
                    <form id="frmConfiguracionCobroTicket" autocomplete="off">
                        {{csrf_field()}}
                        <input type="hidden" class="idConfiguracion" name="idConfiguracion">
                        <div class="row">
                            <div class="col-md-4 col-md-offset-4">
                                <div class="form-group">
                                    <label for="">Permitir Cobrar Ticket</label>
                                    <div class="icheck-inline text-center" style="margin-top: 5px;">
                                        <input type="checkbox" id="CheckTicket" data-checkbox="icheckbox_square-blue">
                                    </div>
                                    <input type="hidden" name="CobrarTicket" id="txtCobrarTicket">
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="panel-footer">
                    <div class="row">
                        <div class="col-md-4 col-md-offset-8">
                            <button class="btn btn-primary btn-block btn-sm pull-right"
                                    id="btnGuardarConfiguracionCobrarTicket">Guardar
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xs-12 col-md-12">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <div class="panel-title text-center">Configuración Cuenta de Correo</div>
                </div>
                <div class="panel-body">
                    <form id="frmConfiguracionCuentaCorreo" autocomplete="off">
                        {{csrf_field()}}
                        <input type="hidden" class="idConfiguracion" name="idConfiguracion">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="">Cuenta Correo</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control input-sm" name="CuentaCorreo" id="CuentaCorreo">
                                        <div class="input-group-addon input-group-addon-rounded"><i class="fa fa-envelope-o"></i></div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="">Password Correo</label>
                                    <div class="input-group">
                                        <input type="password" class="form-control input-sm" name="PasswordCorreo" id="PasswordCorreo">
                                        <div class="input-group-addon input-group-addon-rounded"><i class="fa fa-key"></i></div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="">Encriptacion</label>
                                    <div class="input-group">
                                        <select name="Encriptacion" id="Encriptacion" class="form-control">
                                            <option value="tls">TLS</option>
                                            <option value="ssl">SSL</option>
                                        </select>
                                        <div class="input-group-addon input-group-addon-rounded"><i class="fa fa-cog"></i></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="panel-footer">
                    <div class="row">
                        <div class="col-md-2 col-md-offset-10">
                            <button class="btn btn-primary btn-block btn-sm pull-right"
                                    id="btnGuardarConfiguracionCuentaCorreo">Guardar
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
@stop

@push('Js')
    <script src="{{asset('assets/ConfiguracionEvento/Configuracion.js')}}"></script>
@endpush