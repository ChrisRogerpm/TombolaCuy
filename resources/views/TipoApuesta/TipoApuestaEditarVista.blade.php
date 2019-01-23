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
                                                Registro de TipoApuesta
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
                            <a href="{{route('TipoApuesta.Listar')}}"
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
        <div class="panel panel-primary">
            <div class="panel-body">

                <form id="frmNuevo" autocomplete="off">
                    {{csrf_field()}}
                    <input type="hidden" name="idTipoApuesta" value="{{$TipoApuesta->idTipoApuesta}}">
                    <div class="row">
                     
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>idTipoPago</label>
                                <input type="text" class="form-control" name="idTipoPago" value="{{$TipoApuesta->idTipoPago}}">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>valorapuesta</label>
                                <input type="text" class="form-control" name="valorapuesta" value="{{$TipoApuesta->valorapuesta}}">
                            </div>
                        </div>
                        
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Nombre</label>
                                <input type="text" class="form-control" name="nombre" value="{{$TipoApuesta->nombre}}">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Estado</label>
                                <select name="estado" class="form-control">
                                    <option value="1" {{$TipoApuesta->estado == 1 ? 'selected':''}}>Activo</option>
                                    <option value="0" {{$TipoApuesta->estado == 0 ? 'selected':''}}>Inactivo</option>
                                </select>
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
<script src="{{asset('../assets/TipoApuesta/TipoApuestaEditar.js')}}"></script>
@endpush