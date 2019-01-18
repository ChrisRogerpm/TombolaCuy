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
                                                    Registro de Progresivo
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
                                    <button type="button" id="btnBuscar"
                                            class="btn btn-primary btn-sm col-md-12 col-xs-12">
                                        <span class="glyphicon glyphicon-book"></span>
                                        MODIFICAR POZO
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-4  col-xs-12 pull-right">
                            <div class="row">
                                <div class="col-md-12 col-sm-12">
                                    <button type="button" id="btnNuevo"
                                            class="btn btn-success btn-sm col-md-12 col-xs-12">
                                        <span class="glyphicon glyphicon-file"></span>
                                        GRABAR
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-primary">
                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-7">
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped table-nowrap no-mb">
                                    <thead class="bg-danger">
                                    <tr>
                                        <th></th>
                                        <th>
                                            <div class="custom-checkbox custom-checkbox-primary text-white">
                                                <input type="checkbox" id="chkPozoSuperior">
                                                <label for="chkPozoSuperior" class="text-uppercase">Pozo Superior</label>
                                            </div>
                                        </th>
                                        <th>
                                            <div class="custom-checkbox custom-checkbox-primary text-white">
                                                <input type="checkbox" id="chkPozoMedio">
                                                <label for="chkPozoMedio" class="text-uppercase">Pozo Medio</label>
                                            </div>
                                        </th>
                                        <th>
                                            <div class="custom-checkbox custom-checkbox-primary text-white">
                                                <input type="checkbox" id="chkPozoInferior">
                                                <label for="chkPozoInferior" class="text-uppercase">Pozo Inferior</label>
                                            </div>
                                        </th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr>
                                        <td>Premio base</td>
                                        <td><input type="number" step="any" name="txtPSPremioBase" id="txtPSPremioBase" value="" class="form-control input-sm" /></td>
                                        <td><input type="number" step="any" name="txtPMPremioBase" id="txtPMPremioBase" value="" class="form-control input-sm" /></td>
                                        <td><input type="number" step="any" name="txtPIPremioBase" id="txtPIPremioBase" value="" class="form-control input-sm" /></td>
                                    </tr>
                                    <tr>
                                        <td>Premio minimo</td>
                                        <td><input type="number" step="any" name="txtPSPremioMinimo" id="txtPSPremioMinimo" value="" class="form-control input-sm" /></td>
                                        <td><input type="number" step="any" name="txtPMPremioMinimo" id="txtPMPremioMinimo" value="" class="form-control input-sm" /></td>
                                        <td><input type="number" step="any" name="txtPIPremioMinimo" id="txtPIPremioMinimo" value="" class="form-control input-sm" /></td>
                                    </tr>
                                    <tr>
                                        <td>Premio maximo</td>
                                        <td><input type="number" step="any" name="txtPSPremioMaximo" id="txtPSPremioMaximo" value="" class="form-control input-sm" /></td>
                                        <td><input type="number" step="any" name="txtPMPremioMaximo" id="txtPMPremioMaximo" value="" class="form-control input-sm" /></td>
                                        <td><input type="number" step="any" name="txtPIPremioMaximo" id="txtPIPremioMaximo" value="" class="form-control input-sm" /></td>
                                    </tr>
                                    <tr>
                                        <td>Inc. pozo (Ej. 0.01 = 1%)</td>
                                        <td><input type="number" step="any" name="txtPSIncPozoNormal" id="txtPSIncPozoNormal" value="" class="form-control input-sm" /></td>
                                        <td><input type="number" step="any" name="txtPMIncPozoNormal" id="txtPMIncPozoNormal" value="" class="form-control input-sm" /></td>
                                        <td><input type="number" step="any" name="txtPIIncPozoNormal" id="txtPIIncPozoNormal" value="" class="form-control input-sm" /></td>
                                    </tr>
                                    <tr>
                                        <td>Restricción de Apuesta (Créditos)</td>
                                        <td><input type="number" step="any" name="txtPSRsApuesta" id="txtPSRsApuesta" value="" class="form-control input-sm" /></td>
                                        <td><input type="number" step="any" name="txtPMRsApuesta" id="txtPMRsApuesta" value="" class="form-control input-sm" /></td>
                                        <td><input type="number" step="any" name="txtPIRsApuesta" id="txtPIRsApuesta" value="" class="form-control input-sm" /></td>

                                    </tr>
                                    <tr>
                                        <td>Nro de Jugadores</td>
                                        <td><input type="number" name="txtPSRsJugadores" id="txtPSRsJugadores" value="" class="form-control input-sm" /></td>
                                        <td><input type="number" name="txtPMRsJugadores" id="txtPMRsJugadores" value="" class="form-control input-sm" /></td>
                                        <td><input type="number" name="txtPIRsJugadores" id="txtPIRsJugadores" value="" class="form-control input-sm" /></td>
                                    </tr>
                                    <tr>
                                        <td>Monto oculto minimo</td>
                                        <td><input type="number" step="any" name="txtPSMontoOcultoMin" id="txtPSMontoOcultoMin" value="" class="form-control input-sm" /></td>
                                        <td><input type="number" step="any" name="txtPMMontoOcultoMin" id="txtPMMontoOcultoMin" value="" class="form-control input-sm" /></td>
                                        <td><input type="number" step="any" name="txtPIMontoOcultoMin" id="txtPIMontoOcultoMin" value="" class="form-control input-sm" /></td>
                                    </tr>
                                    <tr>
                                        <td>Monto oculto maximo</td>
                                        <td><input type="number" step="any" name="txtPSMontoOcultoMax" id="txtPSMontoOcultoMax" value="" class="form-control input-sm" /></td>
                                        <td><input type="number" step="any" name="txtPMMontoOcultoMax" id="txtPMMontoOcultoMax" value="" class="form-control input-sm" /></td>
                                        <td><input type="number" step="any" name="txtPIMontoOcultoMax" id="txtPIMontoOcultoMax" value="" class="form-control input-sm" /></td>
                                    </tr>
                                    <tr>
                                        <td>Inc. pozo oculto (Ej. 0.01 = 1%)</td>
                                        <td><input type="number" step="any" name="txtPSIncPozoOculto" id="txtPSIncPozoOculto" value="" class="form-control input-sm" /></td>
                                        <td><input type="number" step="any" name="txtPMIncPozoOculto" id="txtPMIncPozoOculto" value="" class="form-control input-sm" /></td>
                                        <td><input type="number" step="any" name="txtPIIncPozoOculto" id="txtPIIncPozoOculto" value="" class="form-control input-sm" /></td>
                                    </tr>
                                    <tr>
                                        <td>Dificultad</td>
                                        <td>
                                            <select id="cboPSDificultad" name="cboPSDificultad" class="form-control input-sm ">
                                                <option value="5">Facil</option>
                                                <option value="6">Normal</option>
                                                <option value="7">Dificil</option>
                                            </select>
                                        </td>
                                        <td>
                                            <select id="cboPMDificultad" name="cboPMDificultad" class="form-control input-sm ">
                                                <option value="5">Facil</option>
                                                <option value="6">Normal</option>
                                                <option value="7">Dificil</option>
                                            </select>
                                        </td>
                                        <td>
                                            <select id="cboPIDificultad" name="cboPIDificultad" class="form-control input-sm ">
                                                <option value="5">Facil</option>
                                                <option value="6">Normal</option>
                                                <option value="7">Dificil</option>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Pozo actual</td>
                                        <td><input type="number" step="any" name="txtPSPozoActual" id="txtPSPozoActual" value="" class="form-control input-sm" /></td>
                                        <td><input type="number" step="any" name="txtPMPozoActual" id="txtPMPozoActual" value="" class="form-control input-sm" /></td>
                                        <td><input type="number" step="any" name="txtPIPozoActual" id="txtPIPozoActual" value="" class="form-control input-sm" /></td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
@stop

@push('Js')
    <script src="{{asset('assets/Progresivo/ProgresivoListar.js')}}"></script>
@endpush