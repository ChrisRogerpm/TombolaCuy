@extends('Shared.layout_autenticacion')

@section('content')
<div class="row">
        <div class="col-xs-12 col-sm-6 col-md-4 col-sm-offset-3 col-md-offset-4">

            <!-- PANEL: Authorization -->
            <div class="panel">

                <!-- Panel Body -->
                <div class="panel-body">

                    <div class="image mb text-center">
                        <img src="{{asset('images/logo.png')}}">
                    </div>

                    <form id="frmNuevo">
                        {{ csrf_field() }}
                        <div class="form-group">
                            <label for="login">Usuario</label>
                            <input type="text" id="txtusuario" class="form-control input-sm" placeholder="Ingrese su Usuario" name="usuario" value="test.cajero1">
                        </div>

                        <div class="form-group">
                            <label for="password">Contraseña</label>
                            <input type="password" id="txtpassword" class="form-control input-sm" placeholder="Ingrese su Contraseña" name="password" value="cajero.test">
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
                &copy; Copyright {{now()->year}} <strong>Tombola Cuy</strong> | Todos los derechos reservados
            </p>
            <!-- /Copyright -->

        </div>
    </div>
@endsection

@push('js')
    <script src="{{asset('assets/Autenticacion/Login.js')}}"></script>
@endpush