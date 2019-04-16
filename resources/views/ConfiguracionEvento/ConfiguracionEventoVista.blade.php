@extends('Shared.layout')

@section('content')
    <div class="row">
        <div class="col-md-6">
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
                                                    Configuración Generación Evento
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
        <div class="col-md-6">
            <div class="panel panel-primary">
                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-4 col-sm-4  col-xs-12 pull-right">
                            <div class="row">
                                <div class="col-md-12 col-sm-12">
                                    <button type="button" id="btnGuardar"
                                            class="btn btn-primary btn-sm col-md-12 col-xs-12">
                                        <span class="glyphicon glyphicon-file"></span> GUARDAR
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-12 col-md-12">
            <div class="panel panel-primary">
                <div class="panel-body">

                    <form id="frmNuevo" autocomplete="off">
                        {{csrf_field()}}
                        <input type="hidden" name="idConfiguracion" id="idConfiguracion">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Hora de Inicio - Intervalo</label>
                                    <input type="time" name="HoraInicioIntervalo"
                                           class="form-control input-sm" id="HoraInicioIntervalo"/>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Hora de Finalización - Intervalo</label>
                                    <input type="time" name="HoraFinIntervalo" class="form-control input-sm"
                                            id="HoraFinIntervalo" />
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="">Hora de Ejecución - Generar Eventos</label>
                                    <input type="time" class="form-control input-sm" name="HoraEjecucion"
                                           id="HoraEjecucion">
                                </div>
                            </div>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
@stop

@push('Js')
    <script src="{{asset('assets/ConfiguracionEvento/Configuracion.js')}}"></script>
@endpush