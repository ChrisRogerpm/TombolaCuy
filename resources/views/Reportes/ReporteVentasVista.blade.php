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
                                                    <i class="glyphicon glyphicon-th mr-2"></i> Reporte de Ventas por Eventos
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
                                    <button class="btn btn-primary btn-sm col-md-12 col-xs-12" id="btnBuscar"><span
                                                class="glyphicon glyphicon-search"></span> Buscar
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-4  col-xs-12 pull-right">
                            <div class="row">
                                <div class="col-md-12 col-sm-12 container-btnExcel">
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
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="">Fecha Inicio</label>
                                    <div class="input-group">
                                        <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
                                        <input type="text" class="form-control input-sm Fecha" name="fechaInicio"
                                               required>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="">Fecha Fin</label>
                                    <div class="input-group">
                                        <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
                                        <input type="text" class="form-control input-sm Fecha" name="fechaFin" required>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="">Zona Comercial</label>
                                    <select id="cboZona" name="ZonaComercial"
                                            class="form-control input-sm" style="width: 100%;">
                                        <option value="0">Todos</option>
                                        <option value="1">Zona Comercial 1</option>
                                        <option value="2">Zona Comercial 2</option>
                                        <option value="3">Zona Comercial 3</option>
                                        <option value="4">Zona Comercial 4</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="">Puntos de Venta</label>
                                    <select multiple id="cboPuntoVenta" name="PuntoVenta"
                                            class="form-control input-sm multiselect" style="width: 100%;">
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
        <div class="col-md-12" id="ContenedorTabla">
            <div class="panel panel-primary"
                 style="padding-top:10px; padding-left:10px;padding-right:10px;display: none"
                 id="PanelTabla">
                <div class="panel-body">
                    <table class="table table-bordered border-1" id="table_panel">
                        <tfoot style="background-color: #CCCCCC">
                        <tr>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th>Total</th>
                            <th id="TotalGanancia">0</th>
                            <th></th>
                        </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
        <div class="modal fade" id="ModalVer" role="dialog">
            <div class="modal-dialog">

                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header bg-success" style="color: #FFFFFF">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title" id="TitleModal"></h4>
                    </div>
                    <div class="modal-body">
                        <table class="table table-bordered border-1">
                            <thead>
                            <tr class="bg-success">
                                <th>Id evento</th>
                                <th colspan="6" class="text-right" id="Codigo_NombreJuego"></th>
                            </tr>
                            <tr>
                                <th>Selección</th>
                                <th>Selección</th>
                                <th></th>
                                <th>Cuota</th>
                                <th>Apta.</th>
                                <th>Ganado</th>
                                <th></th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td>1</td>
                                <td>Ganador</td>
                                <td>W2</td>
                                <td>2</td>
                                <td>0</td>
                                <td>--</td>
                                <td>PEN</td>
                            </tr>
                            </tbody>
                            <tfoot class="bg-success">
                            <tr>
                                <th colspan="5">Tipo jugada</th>
                                <th colspan="2" class="text-right" id="ValorTipoJugada"></th>
                            </tr>
                            <tr>
                                <th colspan="5">Apta.</th>
                                <th colspan="2" class="text-right" id="ValorApta"></th>
                            </tr>
                            <tr>
                                <th colspan="5">Ganado</th>
                                <th colspan="2" class="text-right" id="ValorGanado"></th>
                            </tr>

                            </tfoot>
                        </table>
                    </div>
                    {{--<div class="modal-footer">--}}
                    {{--<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>--}}
                    {{--</div>--}}
                </div>

            </div>
        </div>
    </div>
@stop

@push('Js')
    <script src="{{asset('assets/Reporte/ReporteVenta.js')}}"></script>
@endpush