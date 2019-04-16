@extends('Shared.layout')
@section('content')
    <link rel="stylesheet" href="{{asset('css/Multiselect.css')}}">
    <div class="row">
        <div class="col-xs-12 col-md-12">

            <!-- PANEL: Basic Example -->
            <div class="panel">

                <!-- Panel Heading -->
                <div class="panel-heading">

                    <!-- Panel Title -->
                    <div class="panel-title">Auditoria</div>
                    <!-- /Panel Title -->
                    <div class="panel-controls">
                        <ul class="panel-buttons">
                            {{--<li>--}}
                            {{--<select class="form-control" name="txtPerfil" id="txtPerfil" style="margin-top: 7px;">--}}
                            {{--<option value="">--Perfil--</option>--}}
                            {{--<option value="0">Administrador</option>--}}
                            {{--<option value="1">Cajero</option>--}}
                            {{--</select>--}}
                            {{--</li>--}}
                            <li>
                                <a href="#" class="btn btn-primary btn-md" id="btnBuscar"
                                   style="margin-top: 7px;"><i class="fa fa-search pr-2"></i> Buscar</a>
                            </li>
                        </ul>
                    </div>

                </div>

                <div class="panel-body">
                    <form id="frmNuevo">
                        <div class="row">
                            <div class="col-xs-12 col-sm-4">
                                <div class="form-group">
                                    <label for="">Usuario</label>
                                    <select name="UsuarioId" class="form-control" id="txtUsuario">
                                        {{--<option value="0">Administrador</option>--}}
                                        {{--<option value="1">Cajero</option>--}}
                                    </select>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-4">
                                <div class="form-group">
                                    <label for="exampleInputPassword1">Fecha Inicio</label>
                                    <div class='input-group date' id=''>
                                        <input type='text' class="form-control fechaSorteo" name="txtFechaInicio"
                                               id="txtFechaInicio" readonly/>
                                        <span for="txtFechaInicio" class="input-group-addon">
                                    <span class="glyphicon glyphicon-calendar"></span>
                                </span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-4">
                                <div class="form-group">
                                    <label for="exampleInputPassword1">Fecha Fin</label>
                                    <div class='input-group date' id=''>
                                        <input type='text' class="form-control fechaSorteo" name="txtFechaFin"
                                               id="txtFechaFin" readonly/>
                                        <span for="txtFechaFin" class="input-group-addon">
                                    <span class="glyphicon glyphicon-calendar"></span>
                                </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                    <div class="row">
                        <div class="col-xs-12 col-sm-12">
                            <table id="table" class="table table-bordered table-striped table-condensed"
                                   style="width:100%"></table>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <div class="modal medium-modal  fade" id="modalAuditoria" tabindex="-1" role="dialog" aria-labelledby="default-modal-label" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <input type="hidden" name="hddModal" id="hddmodal" />
            <div class="modal-content" data-border-top="multi">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="default-modal-label">Data</h4>
                </div>
                <div class="modal-body">
                    <div class="row" id="bodyModalAuditoria">

                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>
@endsection


@push('Js')
    <script src="{{asset('components/lodash/lodash.min.js')}}"></script>
    <script src="{{asset('assets/Seguridad/Auditoria.js')}}"></script>
@endpush

