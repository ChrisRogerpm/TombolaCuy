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
                                                    Registro de Configuración Jackpot
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
                                    <a href="{{route('ConfiguracionJackpot.Listar')}}"
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
                    <div class="row">
                        <div class="col-md-8">
                            <div class="form-group">
                                <label>Nombre MegaJackpot</label>
                                <input type="text" class="form-control input-sm" name="nombre">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>MegaJackpot</label>
                                <div class="icheck-inline" style="margin-top: 5px;">
                                    <input type="checkbox" name="superjackpot" value="1" data-checkbox="icheckbox_square-blue">
                                    <input type="hidden" id="txtsuperjackpot">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <table id="table" class="table table-bordered border-1">
                                <thead>
                                <tr>
                                    <th rowspan="2" class="text-center">Nro Pozo</th>
                                    <th colspan="3" class="text-center">Jackpot</th>
                                    <th colspan="3" class="text-center">Pozo Oculto</th>
                                    <th rowspan="2" class="text-center"><button type="button" id="btnAgregar" class="btn-primary btn-sm"><i class="fa fa-plus-circle"></i></button></th>
                                </tr>
                                <tr>
                                    {{--<th class="text-center">Monto Base</th>--}}
                                    <th class="text-center">Incr. Jackpot</th>
                                    <th class="text-center">Limite Inferior</th>
                                    <th class="text-center">Limite Superior</th>
                                    {{--<th class="text-center">Monto Base</th>--}}
                                    <th class="text-center">Incr. Pozo Oculto</th>
                                    <th class="text-center">Limite Inferior</th>
                                    <th class="text-center">Limite Superior</th>
                                </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@stop

@push('Js')
    <script src="{{asset('assets/Jackpot/JackpotConfiguracion/ConfiguracionJackpotInsertar.js')}}"></script>
@endpush
