@extends('Shared.layout')

@section('body-class')
    sidebar-style loaded
@stop


@section('content')

<style type="text/css">
ul#tab-eval {
    height: 40px;
}
#tab-eval li {
    /* height: 50px; */
    background: #34495e;
    /* width: fit-content; */
    height: 100%;
    text-align: center;
    display: flex;
    justify-content: center;
    align-items: center;
}
#tab-eval li:hover {
    
    background: #293a4a;
    
}
.error{
    color:#ef3a3a;
}

.nav-tabs li a,
li.active a,
.nav-tabs li.active a:hover,
.nav-tabs li.active a:focus {
    color: white;border:none;
    background: #34495e;
}

.nav-tabs li.active a,
.nav-tabs li.active a:hover,
.nav-tabs li.active a:focus {
    color: white;border:none;
    background: #293a4a;
}

.panel-body>.container {
    width: 100%;
}

.dataTables_wrapper {
    width: 100%;
    margin: 0 auto;
}

.tablajack {
    width: 1150px;
    margin-left: 0px;
}

.dataTables_wrapper {
    margin-left: 0;
    margin-right: 0;
}
#tab-eval li.active{
    border-bottom: 2px solid #659ce0;

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
                    <div class="col-md-4 col-sm-4  col-xs-12 pull-right">
                        <div class="row">
                            <div class="col-md-12 col-sm-12 container-btnExcel">
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
                <input type="hidden" id="txtIdJackpot">
                <input type="hidden" id="txtNombreJackpot">
                <form id="frmNuevo" autocomplete="off">
                    {{csrf_field()}}
                    <div class="row">

                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="">Configuracion JackPot</label>
                                <select id="cboConfiguracionJackPot" name="jackPots"
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


                </div>

            </div>
        </div>
    </div>
    @stop

    @push('Js')
    <script src="{{asset('assets/Reporte/ReporteJackPot.js')}}"></script>
    @endpush