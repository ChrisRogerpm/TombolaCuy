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
                                                    Editar Empresa
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
                        <div class="col-md-4 col-sm-4  col-xs-12 pull-right">
                            <div class="row">
                                <div class="col-md-12 col-sm-12">
                                    <a href="{{route('Empresa.Listar')}}"
                                       class="btn btn-success btn-sm col-md-12 col-xs-12"><span
                                                class="fa fa-arrow-circle-left"></span> VOLVER</a>
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

            <!-- PANEL: Basic Example -->
            <div class="panel panel-primary">
                <!-- Panel Body -->
                <div class="panel-body">

                    <form id="frmNuevo" autocomplete="off">
                        {{csrf_field()}}
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