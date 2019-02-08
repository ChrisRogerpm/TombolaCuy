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
                                                <i class="glyphicon glyphicon-th mr-2"></i> Reporte de Apuestas/Pagos/Ventas
                                                Por Tienda.
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
                                <button class="btn btn-primary btn-sm col-md-12 col-xs-12" id="btnBuscar"><span
                                                class="glyphicon glyphicon-search"></span> Buscar
                                    </button>
                            </div>
                        </div>
                    </div>
                    {{--
                    <div class="col-md-4 col-sm-4  col-xs-12 pull-right">
                        <div class="row">
                            <div class="col-md-12 col-sm-12">
                                <a href="#" class="btn btn-success btn-sm col-md-12 col-xs-12" id="btnExcel" onclick="event.preventDefault(); document.getElementById('frmNuevo').submit();">
                                            <span
                                            class="icon fa fa-fw fa-file-excel-o"></span> Excel
                                    </a>
                            </div>
                        </div>
                    </div> --}}
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-xs-12 col-md-12">
        <div class="panel panel-primary">
            <div class="panel-body">
                <form id="frmNuevo" autocomplete="off" action="{{route('Exportar')}}" method="POST">
                    {{csrf_field()}}
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="">Fecha Inicio</label>
                                <div class="input-group">
                                    <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
                                    <input type="text" class="form-control input-sm Fecha" name="fechaInicio" required>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="">Fecha Fin</label>
                                <div class="input-group">
                                    <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
                                    <input type="text" class="form-control input-sm Fecha" name="fechaFin" required>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="">Tiendas</label>
                                <select class="form-control input-sm select2" required name="tiendas" style="width: 100%;" id="cboTienda" multiple="multiple">
                                        <option value="0">--Seleccione--</option>
                                    </select>
                            </div>
                        </div>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-xs-12 col-md-12">
        <div class="panel panel-primary" id="PanelTabla" style="display:none;">
            <div class="panel-body">
                {{--
                <table id="table" class="table table-bordered table-striped" style="width:100%"></table> --}}
            </div>
        </div>
    </div>

    <div class="col-md-12">
        <div class="panel panel-primary" id="PanelTabla">
            <div class="panel-body">
                <table class="table">
                    <thead>
                        <tr>
                            <th class="text-center btn btn-primary" data-toggle="pill" href="#menu1" style="margin-right:2px; color:white;">Tienda #1</th>
                            <th class="text-center btn btn-primary" data-toggle="pill" href="#menu2" style="margin-right:2px; color:white;">Tienda #2</th>
                            <th class="text-center btn btn-primary" data-toggle="pill" href="#menu3" style="margin-right:2px; color:white;">Tienda #3</th>
                            <th class="text-center btn btn-primary" data-toggle="pill" href="#menu4" style="margin-right:2px; color:white;">Tienda #4</th>
                        </tr>
                    </thead>
                </table>
                <div class="tab-content">
                    <div id="home" class="tab-pane fade"> {{-- in active --}}
                        <h3>HOME</h3>
                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore
                            et dolore magna aliqua.</p>
                    </div>
                    <div id="menu1" class="tab-pane fade">
                        <h3>Menu 1</h3>
                        <p>Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
                            consequat.
                        </p>
                    </div>
                    <div id="menu2" class="tab-pane fade">
                        <h3>Menu 2</h3>
                        <p>Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium,
                            totam rem aperiam.</p>
                    </div>
                    <div id="menu3" class="tab-pane fade">
                        <h3>Menu 3</h3>
                        <p>Eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo.</p>
                    </div>
                </div>
            </div>
        </div>


    </div>
</div>









@stop @push('Js')
<script src="{{asset('../assets/Reporte/ReporteApuestas.js')}}"></script>









@endpush