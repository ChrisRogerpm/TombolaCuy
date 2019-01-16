@extends('Shared.layout')

@section('content')
    <div class="row">
        <div class="col-xs-12 col-md-12">

            <!-- PANEL: Basic Example -->
            <div class="panel">

                <!-- Panel Heading -->
                <div class="panel-heading">

                    <!-- Panel Title -->
                    <div class="panel-title">Empresa</div>
                    <!-- /Panel Title -->

                </div>
                <!-- /Panel Heading -->

                <!-- Panel Body -->
                <div class="panel-body">

                    <form id="frmNuevo">
                        <div class="row">
                            <input type="hidden" name="idEmpresa" value="{{$empresa->idEmpresa}}">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Razon Social</label>
                                    <input type="text" class="form-control" name="razonSocial" value="{{$empresa->razonSocial}}">
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="">RUC</label>
                                    <input type="text" class="form-control" name="ruc" value="{{$empresa->ruc}}">
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="">Direccion</label>
                                    <input type="text" class="form-control" name="direccion" value="{{$empresa->direccion}}">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="">Telefono</label>
                                    <input type="text" class="form-control" name="telefono" value="{{$empresa->telefono}}">
                                </div>
                            </div>
                        </div>
                        <a href="{{route('Empresa.Listar')}}" class="btn btn-info"><i class="fa fa-arrow-circle-left"></i> Volver</a>
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
    <script src="{{asset('../assets/Empresa/EmpresaEditar.js')}}"></script>
@endpush