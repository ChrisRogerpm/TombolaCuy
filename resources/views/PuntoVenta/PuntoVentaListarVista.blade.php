@extends('Shared.layout')

@section('content')

    <div class="col-xs-12 col-md-12">

        <!-- PANEL: Basic Example -->
        <div class="panel">

            <!-- Panel Heading -->
            <div class="panel-heading">

                <!-- Panel Title -->
                <div class="panel-title">Punto Venta</div>
                <!-- /Panel Title -->
                <div class="panel-controls">
                    <ul class="panel-buttons">
                        <li>
                            <a href="{{route('PuntoVenta.Insertar')}}" class="btn btn-primary btn-sm"
                               style="margin-top: 10px;"><i class="fa fa-file pr-2"></i> NUEVO</a>
                        </li>
                    </ul>
                </div>

            </div>

            <div class="panel-body">

                <table id="table" class="table table-bordered table-striped" style="width:100%"></table>

            </div>

        </div>

    </div>
@stop

@push('Js')
    <script src="{{asset('../assets/PuntoVenta/PuntoVentaListar.js')}}"></script>
@endpush