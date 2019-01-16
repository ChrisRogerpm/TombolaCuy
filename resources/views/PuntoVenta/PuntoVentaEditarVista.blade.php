@extends('Shared.layout')

@section('content')
    <div class="row">
        <div class="col-xs-12 col-md-12">

            <!-- PANEL: Basic Example -->
            <div class="panel">

                <!-- Panel Heading -->
                <div class="panel-heading">

                    <!-- Panel Title -->
                    <div class="panel-title">Punto de Venta</div>
                    <!-- /Panel Title -->

                </div>
                <!-- /Panel Heading -->

                <!-- Panel Body -->
                <div class="panel-body">

                    <form id="frmNuevo" autocomplete="off">
                        <div class="row">
                            <input type="hidden" name="idPuntoVenta" value="{{$PuntoVenta->idPuntoVenta}}">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Empresa</label>
                                    <select name="idEmpresa" class="form-control" id="cboEmpresa"></select>
                                    <input type="hidden" id="txtEmpresa" value="{{$PuntoVenta->idEmpresa}}">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Ubigeo</label>
                                    <select name="idUbigeo" class="form-control input-sm" id="cboUbigeo"></select>
                                    <input type="hidden" id="txtUbigeo" value="{{$PuntoVenta->idUbigeo}}">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Nombre</label>
                                    <input type="text" name="nombre" class="form-control input-sm" value="{{$PuntoVenta->nombre}}">
                                </div>
                            </div>

                        </div>
                        <a href="{{route('PuntoVenta.Listar')}}" class="btn btn-info"><i class="fa fa-arrow-circle-left"></i> Volver</a>
                        <button type="button" id="btnGuardar" class="btn btn-success pull-right">Guardar</button>
                    </form>

                </div>
                <!-- /Panel Body -->

            </div>
            <!-- /PANEL: Basic Example -->

        </div>
    </div>
@stop

@push('Js')
    <script src="{{asset('../assets/PuntoVenta/PuntoVentaEditar.js')}}"></script>
@endpush