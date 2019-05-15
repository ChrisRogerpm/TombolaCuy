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
                                                    <i class="glyphicon glyphicon-th mr-2"></i> Alerta por Puntos de
                                                    Venta
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
                                    <input type="hidden" id="txtIdTipoAlerta" value="{{$idTipoAlerta}}">
                                    <button type="button" id="btnNuevo" data-id="{{$idTipoAlerta}}"
                                            class="btn btn-primary btn-sm col-md-12 col-xs-12"><span
                                                class="glyphicon glyphicon-file"></span> NUEVO
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-4  col-xs-12 pull-right">
                            <div class="row">
                                <div class="col-md-12 col-sm-12">
                                    <a href="{{route('TipoAlerta.Listar')}}"
                                       class="btn btn-success btn-sm col-md-12 col-xs-12">
                                        <span
                                                class="fa fa-arrow-circle-left"></span> Volver
                                    </a>
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
                    <table id="table" class="table table-bordered table-striped" style="width:100%"></table>
                </div>
            </div>

        </div>
    </div>

    <div class="modal fade" tabindex="-1" role="dialog" id="ModalNuevoAlertaPuntoVenta">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title text-center">Nueva Alerta por Tipo Venta</h4>
                </div>
                <div class="modal-body">
                    <form id="frmNuevo" autocomplete="off">
                        <div class="row">
                            <input type="hidden" id="idTipoAlerta" name="idTipoAlerta">
                            <div class="col-md-6 container-table-punto"></div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">Correo</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control" id="txtCorreo"
                                               placeholder="Ingrese correo">
                                        <span class="input-group-btn"><button class="btn btn-success"
                                                                              id="btnAgregarCorreo" type="button"><i
                                                        class="fa fa-plus"></i></button></span>
                                    </div>
                                </div>
                                <table id="table_correo" class="table table-bordered table-striped" style="width:100%">
                                    <thead>
                                    <tr>
                                        <th>Correo</th>
                                        <th class="text-center">Accion</th>
                                    </tr>
                                    </thead>
                                    <tbody></tbody>
                                </table>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" id="btnGuardar">Guardar</button>
                    <button type="button" class="btn btn-warning" data-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>
@stop

@push('Js')
    <script src="{{asset('assets/TipoAlerta/TipoAlertaPuntoVentaVista.js')}}"></script>
@endpush