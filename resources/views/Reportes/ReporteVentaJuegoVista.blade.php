@extends('Shared.layout')

@section('body-class')
    sidebar-style loaded
@stop

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
                                                    <i class="glyphicon glyphicon-th mr-2"></i> Reporte Historial de Eventos
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
                                    <button class="btn btn-primary btn-sm col-md-12 col-xs-12" disabled
                                            id="btnBuscar"><span
                                                class="glyphicon glyphicon-search"></span> Buscar
                                    </button>
                                    <input type="hidden" id="ValorIdJuego">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-4  col-xs-12 pull-right">
                            <div class="row">
                                <div class="col-md-12 col-sm-12" id="container-excel"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-3">
            <div class="panel panel-primary widget-panel widget-categories">
                <div class="list-group list-categories">
                    @foreach($juegos as $j)
                        <a href="#" class="list-group-item category btnJuego" data-id="{{$j->idJuego}}" data-nombre="{{$j->nombre}}">
                            <i class="icon-theme icon-primary fa fa-gamepad"></i>{{$j->nombre}}<span
                                    class="small subtitle">{{$j->nombre}}</span>
                        </a>
                    @endforeach

                </div>
            </div>
        </div>
        <div class="col-md-9" id="ContenedorTabla">
            <div class="panel panel-primary"
                 style="padding-top:10px; padding-left:10px;padding-right:10px;display: none" id="PanelTabla">
                <div class="col-md-12">
                    <input type="hidden" id="txtNombreTabla">
                    <form id="frmNuevo" autocomplete="off">
                        {{csrf_field()}}
                        <div class="row">
                            <input type="hidden" name="IdJuego" id="txtIdJuego">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="">Fecha Inicio</label>
                                    <div class="input-group">
                                        <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
                                        <input type="text" class="form-control input-sm Fecha" name="fechaInicio"
                                               required>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="">Fecha Fin</label>
                                    <div class="input-group">
                                        <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
                                        <input type="text" class="form-control input-sm FechaFin" name="fechaFin" required>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="panel-body container-tabla"></div>
            </div>
        </div>
    </div>
@stop

@push('Js')
    <script src="{{asset('assets/Reporte/ReporteVentaJuego.js')}}"></script>
@endpush