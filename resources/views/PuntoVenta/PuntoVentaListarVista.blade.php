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
                                                <i class="glyphicon glyphicon-th mr-2"></i> Lista de Punto de Ventas
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
                                <button type="button" id="btnSincronizar" class="btn btn-success btn-sm col-md-12 col-xs-12">
                                    <span class="icon fa fa-fw fa-refresh mr-3"></span> SINCRONIZAR</button>
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




@stop @push('Js')
<script src="{{asset('assets/PuntoVenta/PuntoVentaListar.js')}}"></script>



@endpush