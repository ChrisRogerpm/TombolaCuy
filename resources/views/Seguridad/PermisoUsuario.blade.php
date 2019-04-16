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
                    <div class="panel-title">Permisos</div>
                    <!-- /Panel Title -->
                    <div class="panel-controls">
                        <ul class="panel-buttons">
                            <li>
                                <select class="form-control" name="txtPerfil" id="txtPerfil" style="margin-top: 7px;">
                                    <option value="">--Perfil--</option>
                                    <option value="0">Administrador</option>
                                    <option value="1">Cajero</option>
                                </select>
                            </li>
                            <li>
                                <a href="#" class="btn btn-primary btn-md" id="btnBuscar"
                                   style="margin-top: 0px;"><i class="fa fa-search pr-2"></i> Permisos</a>
                            </li>
                            <li>
                                <a href="#" class="btn btn-warning btn-md" id="btnBarrido"
                                   style="margin-top: 0px;"><i class="fa fa-cog pr-2"></i> Recorrer</a>
                            </li>
                        </ul>
                    </div>

                </div>

                <div class="panel-body">
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

    <div class="modal fade" id="modalAuditoria" tabindex="-1" role="dialog" aria-labelledby="default-modal-label"
         aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content" data-border-top="multi">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="default-modal-label">Permisos</h4>
                </div>
                <div class="modal-body">
                    <div class="row" id="container-todos"></div>
                    <div class="row" id="bodyModal"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
@endsection


@push('Js')
    <script src="{{asset('components/lodash/lodash.min.js')}}"></script>
    <script src="{{asset('assets/Seguridad/PermisosUsuario.js')}}"></script>
@endpush

