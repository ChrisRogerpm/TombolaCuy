@extends('Shared.layout')

@section('content')

<style type="text/css">
    .nav-tabs li a, li.active a, .nav-tabs li.active a:hover, .nav-tabs li.active a:focus {
        
        color: white; 
    }
    .nav-tabs li.active a, .nav-tabs li.active a:hover, .nav-tabs li.active a:focus {
    color: white;

    }

    .panel-body > .container {
        width:100%;
    }
     div.dataTables_wrapper {
        width: 890px;
        margin: 0 auto;
    } 
    /**/
    
    /**/
</style>

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
                                                Reporte de JackPot.
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
                                <a id="btnBuscar" href="#" class="btn btn-primary btn-sm col-md-12 col-xs-12"><span
                                        class="glyphicon glyphicon-search"></span> Buscar</a>


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
                    <div class="row">

                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="">Configuracion JackPot</label>
                                <select  id="cboConfiguracionJackPot" name="jackPots"
                                    class="form-control input-sm multiselect" style="width: 100%;">
                                    
                                </select>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="">Tiendas</label>
                                <select multiple="multiple" id="cboTienda" name="tiendas"
                                    class="form-control input-sm multiselect" style="width: 100%;">

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
        <div class="panel panel-primary">
            <div class="panel-body">
                <div class="container">
                    <h3 id="subtituloTabsGeneral"></h3>
                    <ul id="tab-eval" class="nav nav-tabs">
                        

                    </ul>

                    <div class="tab-content" id="tabContenido">
                        
                    </div>

                    <table id="table" class="table table-bordered table-striped" style="width:100%">
                    </table>

                    <table id="table3" class="table table-bordered table-striped" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th colspan="3">Pozo 1 (1)</th>
                                            <th colspan="3">Pozo 2 (2)</th>
                                            <th colspan="3">Pozo 3 (9)</th>
                                            <th colspan="3">Pozo Oculto 1 (1)</th>
                                            <th colspan="3">Pozo Oculto 2 (2)</th>
                                            <th colspan="3">Pozo Oculto 3 (9)</th>
                                        </tr>
                                            <tr>
                                            <th style="display:none;">f</th>
                                            <th style="display:none;">f</th>
                                            <th style="display:none;">f</th>
                                            <th style="display:none;">f</th>
                                            <th style="display:none;">f</th>
                                            <th style="display:none;">f</th>
                                            <th style="display:none;">f</th>
                                            <th style="display:none;">f</th>
                                            <th style="display:none;">f</th>
                                            <th style="display:none;">f</th>
                                            <th style="display:none;">f</th>
                                            <th style="display:none;">f</th>
                                            <th style="display:none;">f</th>
                                            <th style="display:none;">f</th>
                                            <th style="display:none;">f</th>
                                            <th style="display:none;">f</th>
                                            <th style="display:none;">f</th>
                                            <th style="display:none;">f</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            
                                            <td style="font-weight: 600;color:black">Incremento</td>
                                            <td style="font-weight: 600;color:black">Límite Inferior</td>
                                            <td style="font-weight: 600;color:black">Límite Superior</td>
                                            <td style="font-weight: 600;color:black">Incremento</td>
                                            <td style="font-weight: 600;color:black">Límite Inferior</td>
                                            <td style="font-weight: 600;color:black">Límite Superior</td>
                                            <td style="font-weight: 600;color:black">Incremento</td>
                                            <td style="font-weight: 600;color:black">Límite Inferior</td>
                                            <td style="font-weight: 600;color:black">Límite Superior</td>
                                            <td style="font-weight: 600;color:black">OcultoIncremento</td>
                                            <td style="font-weight: 600;color:black">OcultoLímite Inferior</td>
                                            <td style="font-weight: 600;color:black">OcultoLímite Superior</td>
                                            <td style="font-weight: 600;color:black">OcultoIncremento</td>
                                            <td style="font-weight: 600;color:black">OcultoLímite Inferior</td>
                                            <td style="font-weight: 600;color:black">OcultoLímite Superior</td>
                                            <td style="font-weight: 600;color:black">OcultoIncremento</td>
                                            <td style="font-weight: 600;color:black">OcultoLímite Inferior</td>
                                            <td style="font-weight: 600;color:black">OcultoLímite Superior</td>
                                        </tr>
                                    </tbody>
                                </table>
                </div>
            </div>
        </div>
    </div>
    @stop

    @push('Js')
    <script src="{{asset('../assets/Reporte/ReporteJackPot.js')}}"></script>
    @endpush