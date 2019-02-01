@extends('Shared.layout_autenticacion')

@section('content')
<div class="row">
        <div class="col-xs-12 col-sm-6 col-md-4 col-sm-offset-3 col-md-offset-4">

            <!-- PANEL: Authorization -->
            <div class="panel">

                <!-- Panel Body -->
                <div class="panel-body">

                    <div class="image mb text-center">
                        <img src="images/logo-big-dark.png" alt="CasperoBoard">
                    </div>

                    <form id="frmNuevo">
                        {{ csrf_field() }}
                        <div class="form-group">
                            <label for="login">Usuario</label>
                            <input type="text" class="form-control input-sm" placeholder="Ingrese su Usuario" name="usuario" value="test.cajero1">
                        </div>

                        <div class="form-group">
                            <label for="password">Contraseña</label>
                            <input type="password" class="form-control input-sm" placeholder="Ingrese su Contraseña" name="password" value="cajero.test">
                        </div>

                        <div class="form-group pull-right">
                            <button type="button" id="btnEntrar" class="btn btn-primary"><i class="fa fa-fw fa-sign-in"></i> Entrar</button>
                        </div>

                    </form>

                </div>
                <!-- /Panel Body -->

            </div>
            <!-- /PANEL: Authorization -->

            <!-- Copyright -->
            <p class="text-muted text-center">
                &copy; Copyright 2017 <strong>Valery Timofeev</strong> | All Rights Reserved
            </p>
            <!-- /Copyright -->

        </div>
    </div>
@endsection

@push('js')
    <script src="assets/Autenticacion/Login.js"></script>
@endpush