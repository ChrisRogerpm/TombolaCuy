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
                                                    Editar AperturaCaja
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
                                    <a href="{{route('AperturaCaja.Listar')}}"
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
                        <input type="hidden" name="idAperturaCaja" value="{{$AperturaCaja->idAperturaCaja}}">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Caja</label>
                                    <select name="idCaja" class="form-control input-sm" id="cboCaja"></select>
                                    <input type="hidden" id="txtidCaja" value="{{$AperturaCaja->idCaja}}">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Turno</label>
                                    <select name="idTurno" class="form-control input-sm" id="cboTurno"></select>
                                    <input type="hidden" id="txtidTurno" value="{{$AperturaCaja->idTurno}}">
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="">Usuario</label>
                                    <!-- <input type="hidden" class="form-control input-sm" name="usuario" value="{{$AperturaCaja->usuario}}" readonly> -->
                                    <input type="hidden" class="form-control input-sm" name="usuario" value="{{$AperturaCaja->usuario}}" readonly>
                                    <input type="text" class="form-control input-sm" name="usuarionombre" value="{{$AperturaCaja->usuarionombre}}" readonly>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="">fechaOperacion</label>
                                    <div class="input-group">
                                        <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
                                        <input type="text" class="form-control input-sm" id="txtfechaOperacion" name="fechaOperacion" value="{{$AperturaCaja->fechaOperacion}}">
                                    </div>
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
    <script src="{{asset('../assets/AperturaCaja/AperturaCajaEditar.js')}}"></script>
@endpush