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
                                                    Reporte de Historial de Ganadores Por Tienda.
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
                                    <a href="#"
                                       class="btn btn-primary btn-sm col-md-12 col-xs-12"><span
                                                class="glyphicon glyphicon-search"></span> Buscar</a>
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
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="form-label">Fecha Inicio</label>
                                    <div class="prepend-icon">
                                        <input type="text" name="datepicker" class="date-picker form-control hasDatepicker" placeholder="Fecha Inicio"  id="fechaInicio">
                                        <i class="icon-calendar"></i>
                                    </div>
                                </div>

                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                <label class="form-label">Fecha Fin</label>
                                <div class="prepend-icon">
                                    <input type="text" name="datepicker" class="date-picker form-control hasDatepicker" placeholder="Fecha Fin" id="fechaFin">
                                    
                                    <i class="icon-calendar"></i>
                                </div>
                            </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="">Tiendas</label>
                                    <select class="form-control input-sm select2" style="width: 100%;">
                                        <option value="0">--Seleccione--</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-12 col-md-12">
            <div class="panel panel-primary">
                <div class="panel-body">
                    <table id="table" class="table table-bordered table-striped" style="width:100%"></table>
                </div>
            </div>
        </div>
    </div>
@stop

@push('Js')
    <script src="{{asset('../assets/Reporte/ReporteHistorialGanadores.js')}}"></script>
@endpush