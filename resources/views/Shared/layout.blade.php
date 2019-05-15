<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Page title -->
    <title>TombolaCuy</title>
    <!-- /Page title -->

    <!-- Meta -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="_token" content="{!! csrf_token() !!}"/>
    <!-- /Meta -->

    <!-- SEO Meta -->
    <meta name="keywords" content="">
    <meta name="description" content="">
    <meta name="author" content="">
    <!-- /SEO Meta -->

    <!-- OpenGraph meta -->
    <meta property="og:image" content="">
    <meta property="og:title" content="og title">
    <meta property="og:description" content="og description">
    <!-- /OpenGraph meta -->

    <!-- Favicon -->
    {{--<link rel="shortcut icon" href="../images/xampp.ico">--}}
    <link rel="shortcut icon" href="{{asset('images/logoat.jpg')}}">
    <!-- /Favicon -->

    <!-- AppleTouch Icons -->
    <link rel="apple-touch-icon" href="#">
    <link rel="apple-touch-icon" href="#" sizes="57x57">
    <link rel="apple-touch-icon" href="#" sizes="72x72">
    <link rel="apple-touch-icon" href="#" sizes="76x76">
    <link rel="apple-touch-icon" href="#" sizes="114x114">
    <link rel="apple-touch-icon" href="#" sizes="120x120">
    <link rel="apple-touch-icon" href="#" sizes="144x144">
    <link rel="apple-touch-icon" href="#" sizes="152x152">
    <link rel="apple-touch-icon" href="#" sizes="180x180">
    <!-- /AppleTouch Icons -->

    <!-- Styles -->


    <link rel="stylesheet" href="{{asset('../css/theme.css')}}">
<!-- <link rel="stylesheet" href="{{asset('../components/datatables/jquery.dataTables.min.css')}}"> -->
    <!-- C:\xampp\htdocs\TombolaCuy\public\assets\DataTables\DataTables-1.10.18\css -->
    <link rel="stylesheet" href="{{asset('../assets/DataTables/DataTables-1.10.18/css/jquery.dataTables.min.css')}}">
<!-- <link rel="stylesheet" href="{{asset('../components/datatables/buttons.dataTables.min.css')}}"> -->
    <link rel="stylesheet" href="{{asset('../assets/DataTables/Buttons-1.5.4/css/buttons.dataTables.min.css')}}">

    <link rel="stylesheet" href="{{asset('../components/toastr/toastr.min.css')}}">
    <link rel="stylesheet"
          href="{{asset('../components/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css')}}">
    <link rel="stylesheet" href="{{asset('../components/select2/select2.min.css')}}" rel="stylesheet"/>
    <link rel="stylesheet" href="{{asset('../css/demo.css')}}">
    <link rel="stylesheet" href="{{asset('../components/icheck/skins/all.css')}}">


<!-- <link rel="stylesheet" href="{{asset('../css/exportar-excel/buttons.dataTables.min.css')}}"> -->

    <!-- /Styles -->

</head>

<body class="@yield('body-class','sidebar-style loaded expanded')">
{{--<body class="sidebar-style loaded">--}}

<!-- NAVIGATION: Top Menu -->
<nav class="navbar navbar-fixed-top top-menu">
    <div class="container-fluid">

        <!-- Navigation header -->
        <div class="navbar-header">

            <!-- Collapse button -->
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar"
                    aria-expanded="false"
                    aria-controls="navbar">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <!-- /Collapse button -->

            <!-- Brand -->
            {{--<a href="#" class="navbar-brand navbar-brand-cover">--}}
            {{--<div class="navbar-brand-big">--}}
            {{--<img src="{{asset('images/logo.png')}}" alt="CasperoBoard">--}}
            {{--</div>--}}
            {{--<div class="navbar-brand-small">--}}
            {{--<img src="{{asset('images/logoat.jpg')}}" alt="CasperoBoard">--}}
            {{--</div>--}}
            {{--</a>--}}

            <a href="#" class="navbar-brand navbar-brand-cover">
                <div class="navbar-brand-big" style="text-align: center;width: 100%;">
                    <img src="{{url('../images/logo.png')}}" alt="logo apuesta total"
                         style="height: 40px;padding-top:5px;">
                </div>
                <div class="navbar-brand-small">
                    <img src="{{url('../images/logoat.jpg')}}" alt="logo apuesa total" style="height: 49px;">
                </div>
            </a>

            <!-- /Brand -->

        </div>
        <!-- /Navigation header -->

        <!-- Top Menu (Not Collapsed) -->
        <div class="navbar-top">
            <ul class="nav navbar-nav">
                <li>
                    <a href="#" class="sidebar-collapse">
                        <i class="icon icon-inline fa fa-toggle-left muted"></i>
                    </a>
                </li>
            </ul>
        </div>
        <!-- /Top Menu (Not Collapsed) -->

        <!-- Top menu -->
        <div id="navbar" class="navbar-collapse collapse">

            <!-- Right menu -->
            <ul class="nav navbar-nav navbar-right">

                <!-- Buttons -->
            {{--<li>--}}

            {{--<!-- Search Form -->--}}
            {{--<form class="navbar-search-form">--}}
            {{--<div class="form-group">--}}
            {{--<input type="text" class="form-control" placeholder="Type search here...">--}}
            {{--</div>--}}
            {{--</form>--}}
            {{--<!-- /Search Form -->--}}

            {{--<a href="#" class="navbar-search-toggle hidden-xs">--}}
            {{--<i class="icon icon-inline fa fa-search"></i> <span--}}
            {{--class="hidden-sm hidden-md hidden-lg">Search</span>--}}
            {{--</a>--}}
            {{--</li>--}}
            {{--<li class="dropdown">--}}

            {{--<a href="#" class="dropdown-toggle no-caret nav-notification" data-toggle="dropdown">--}}
            {{--<i class="icon icon-inline fa fa-envelope-open-o"></i>--}}
            {{--<span class="hidden-sm hidden-md hidden-lg">Notifications</span>--}}
            {{--<span class="badge badge-danger badge-notification">7</span>--}}
            {{--</a>--}}

            {{--<ul class="dropdown-menu dropdown-menu-right navbar-notifications-dropdown">--}}

            {{--<li class="title">New Messages</li>--}}

            {{--<li>--}}
            {{--<a href="#" class="notification">--}}
            {{--<div class="avatar avatar-lg image">--}}
            {{--<img src="images/avatar-lori-harrison.jpg" alt="Lori Harrison">--}}
            {{--</div>--}}
            {{--<div class="user-name">Lori Harrison</div>--}}
            {{--<p class="text">--}}
            {{--It is a long established fact that a reader will be distracted by the readable content--}}
            {{--</p>--}}
            {{--<div class="date">today 08:27 PM</div>--}}
            {{--</a>--}}
            {{--</li>--}}

            {{--<li>--}}
            {{--<a href="#" class="notification">--}}
            {{--<span class="notification-status text-warning"><i--}}
            {{--class="icon fa fa-exclamation-triangle"></i></span>--}}
            {{--<div class="avatar avatar-lg image">--}}
            {{--<img src="images/avatar-phillip-cole.jpg" alt="Phillip Cole">--}}
            {{--</div>--}}
            {{--<div class="user-name">Phillip Cole</div>--}}
            {{--<p class="text">--}}
            {{--It is a long established fact that a reader will be distracted by the readable--}}
            {{--content--}}
            {{--</p>--}}
            {{--<div class="date">today 08:27 PM</div>--}}
            {{--</a>--}}
            {{--</li>--}}

            {{--<li>--}}
            {{--<a href="#" class="notification">--}}
            {{--<div class="avatar avatar-lg image">--}}
            {{--<img src="images/avatar-ann-james.jpg" alt="Ann James">--}}
            {{--</div>--}}
            {{--<div class="user-name">Ann James</div>--}}
            {{--<p class="text">--}}
            {{--It is a long established fact that a reader will be distracted by the readable content--}}
            {{--</p>--}}
            {{--<div class="date">today 08:27 PM</div>--}}
            {{--</a>--}}
            {{--</li>--}}


            {{--<li>--}}
            {{--<a href="#" class="btn btn-default btn-block btn-no-border">See All Messages</a>--}}
            {{--</li>--}}

            {{--</ul>--}}

            {{--</li>--}}

            {{--<li>--}}
            {{--<a href="#" class="sidebar-toggle" data-sidebar=".sidebar-users">--}}
            {{--<i class="icon icon-inline fa fa-comments-o"></i> <span class="hidden-sm hidden-md hidden-lg">Users</span>--}}
            {{--</a>--}}
            {{--</li>--}}
            <!-- /Buttons -->

                <!-- Profile -->
                <li class="dropdown">

                    <!-- Profile avatar -->
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <div class="profile-avatar circle">
                            <img src="{{asset('images/userdefault.jpg')}}">
                        </div>
                        <span class="user-name">{{Auth::user()->usuario}}</span>
                    </a>
                    <!-- /Profile avatar -->

                    <!-- Profile dropdown menu -->
                    <ul class="dropdown-menu dropdown-menu-right">

                        {{--<li>--}}
                        {{--<a href="#"><i class="icon icon-inline fa fa-address-card-o"></i> Profile</a>--}}
                        {{--</li>--}}
                        {{--<li>--}}
                        {{--<a href="#" class="has-badge">--}}
                        {{--<i class="icon icon-inline fa fa-envelope-o"></i> Inbox--}}
                        {{--<span class="badge badge-notification badge-danger">3</span>--}}
                        {{--</a>--}}
                        {{--</li>--}}
                        {{--<li><a href="#"><i class="icon icon-inline fa fa-tasks"></i> Tasks</a></li>--}}
                        {{--<li>--}}
                        {{--<a href="#" class="has-badge">--}}
                        {{--<i class="icon icon-inline fa fa-calendar"></i> Calendar--}}
                        {{--<span class="badge badge-notification badge-primary">5</span>--}}
                        {{--</a>--}}
                        {{--</li>--}}

                        {{--<li class="divider"></li>--}}
                        <li><a href="#" id="btnCerrarSesion"
                               onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><i
                                        class="icon icon-inline fa fa-sign-out"></i> Cerrar Sesión</a></li>
                        <form id="logout-form" action="{{ route('CerrarSesion') }}" method="POST"
                              style="display: none;">
                            {{ csrf_field() }}
                        </form>
                    </ul>
                    <!-- /Profile dropdown menu -->

                </li>
                <!-- /Profile -->

            </ul>
            <!-- /Right menu -->

        </div>
        <!-- /Top menu -->

    </div>
</nav>
<!-- /NAVIGATION: Top Menu -->
<!-- MAIN CONTAINER -->
<main class="main-container">

    <!-- SIDEBAR LEFT -->
    <div class="sidebar">

        <!-- Scrollable -->
        <div class="height100p custom-scroll">

            <!-- SIDEBAR PROFILE -->
            <div class="sidebar-profile">

                <!-- Profile Avatar -->
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                    <div class="avatar avatar-lg">
                        <img src="{{asset('images/userdefault.jpg')}}">
                    </div>
                </a>
                <div class="user-info">
                    <div class="name">Bienvenido</div>
                    <div class="post">{{Auth::user()->usuario}}</div>
                </div>
            </div>
            <!-- /SIDEBAR PROFILE -->

            <!-- SIDEBAR NAVIGATION -->

            <ul class="nav-sidebar">
                <li><a href="{{route('Dashboard')}}" data-toggle="tooltip" title="Inicio"><i class="icon icon-inline fa fa-home"></i> <span
                                class="title">Inicio</span></a></li>
                <li><a href="{{route('PuntoVenta.Listar')}}" data-toggle="tooltip" title="Punto Venta"><i class="icon icon-inline fa fa-inbox"></i> <span
                                class="title">Punto Venta</span></a></li>
                <li><a href="{{route('Caja.Listar')}}" data-toggle="tooltip" title="Caja"><i class="icon icon-inline fa fa-shopping-cart"></i> <span
                                class="title">Caja</span></a></li>

                <li><a href="{{route('AperturaCaja.Listar')}}" data-toggle="tooltip" title="Apertura Caja"><i class="icon icon-inline fa fa-cube"></i> <span
                                class="title">Apertura Caja</span></a></li>
                <li><a href="{{route('Caja.Cierre')}}" data-toggle="tooltip" title="Cierre Caja"><i class="icon icon-inline fa fa-cube"></i> <span
                                class="title">Cierre Caja</span></a></li>
                <li><a href="{{route('Juego.Listar')}}" data-toggle="tooltip" title="Juegos"><i class="icon icon-inline fa fa-cube"></i> <span
                                class="title">Juegos</span></a></li>
                <li><a href="{{route('Venta.IndexNuevo')}}" data-toggle="tooltip" title="Venta"><i class="icon icon-inline fa fa-dollar"></i> <span
                                class="title">Venta</span></a></li>
                <li class="sub">
                    <a href="#" class="sub-toggle">
                        <i class="icon icon-inline fa fa-gamepad"></i> <span class="title">Jackpot</span>
                    </a>
                    <ul class="sub-menu collapse" data-menu-title="Jackpot">
                        <li><a href="{{route('ConfiguracionJackpot.Listar')}}"><i
                                        class="icon icon-inline fa fa-circle-thin"></i> <span class="title">Configuracion Jackpot</span></a>
                        </li>
                    </ul>
                </li>
                <li class="sub">
                    <a href="#" class="sub-toggle">
                        <i class="icon icon-inline fa fa-line-chart"></i> <span class="title">Reporte</span>
                    </a>
                    <ul class="sub-menu collapse" data-menu-title="Reporte">
                        <li><a href="{{route('Reporte.Ventas')}}"><i class="icon icon-inline fa fa-circle-thin"></i>
                                <span
                                        class="title">Ventas</span></a></li>
                        <li><a href="{{route('Reporte.DetalleApuestaEvento')}}"><i
                                        class="icon icon-inline fa fa-circle-thin"></i>
                                <span
                                        class="title">Det Apuesta Evento</span></a></li>
                        <li><a href="{{route('Reporte.JackPot')}}"><i class="icon icon-inline fa fa-circle-thin"></i>
                                <span
                                        class="title">JackPot</span></a></li>
                        <li><a href="{{route('Reporte.VentaEvento')}}"><i
                                        class="icon icon-inline fa fa-circle-thin"></i>
                                <span
                                        class="title">Venta por Eventos</span></a></li>
                        <li><a href="{{route('Reporte.VentaJuego')}}"><i class="icon icon-inline fa fa-circle-thin"></i>
                                <span
                                        class="title">Historial de Eventos</span></a></li>
                        {{--<li><a href="{{route('Reporte.CierreCaja')}}"><i class="icon icon-inline fa fa-circle-thin"></i>--}}
                                {{--<span--}}
                                        {{--class="title">Cierre Caja</span></a></li>--}}
                        <li><a href="{{route('Reporte.HistorialTicket')}}"><i
                                        class="icon icon-inline fa fa-circle-thin"></i>
                                <span
                                        class="title">Historial Ticket</span></a></li>

                        <li><a href="{{route('Reporte.Alerta')}}"><i
                                        class="icon icon-inline fa fa-circle-thin"></i>
                                <span
                                        class="title">Alertas</span></a></li>
                    </ul>
                </li>
                <li><a href="{{route('ConfiguracionEvento')}}" data-toggle="tooltip" title="Configuracion General"><i class="icon icon-inline fa fa-cog"></i> <span
                                class="title">Configuración General</span></a></li>
                <li class="sub">
                    <a href="#" class="sub-toggle">
                        <i class="icon icon-inline fa fa-building"></i> <span class="title">Settings Generales</span>
                    </a>
                    <ul class="sub-menu collapse" data-menu-title="Elements">
                        <li><a href="{{route('DineroDefault.Listar')}}"><i class="icon icon-inline fa fa-money"></i>
                                <span
                                        class="title">DineroDefault</span></a></li>
                        <li><a href="{{route('Turno.Listar')}}"><i class="icon icon-inline fa fa-calendar"></i> <span
                                        class="title">Turno</span></a></li>
                        <li><a href="{{route('Empresa.Listar')}}"><i class="icon icon-inline fa fa-building"></i> <span
                                        class="title">Empresa</span></a></li>
                    </ul>
                </li>
                <li class="sub">
                    <a href="#" class="sub-toggle">
                        <i class="icon icon-inline fa fa-shopping-bag"></i> <span class="title">Seguridad</span>
                    </a>
                    <ul class="sub-menu collapse" data-menu-title="Progresivo">
                        <li><a href="{{route('UsuarioPuntoVenta.Listar')}}"><i
                                        class="icon icon-inline fa fa-circle-thin"></i> <span
                                        class="title">Usuario Punto Venta</span></a></li>
                        <li><a href="{{route('Seguridad.PermisosUsuario')}}"><i
                                        class="icon icon-inline fa fa-circle-thin"></i> <span
                                        class="title">Permisos</span></a></li>
                        <li><a href="{{route('Auditoria')}}"><i class="icon icon-inline fa fa-circle-thin"></i> <span
                                        class="title">Auditoria</span></a></li>
                        <li><a href="{{route('TipoAlerta.Listar')}}"><i class="icon icon-inline fa fa-circle-thin"></i> <span
                                        class="title">Tipo Alerta</span></a></li>
                    </ul>
                </li>
            </ul>
        </div>
        <div class="sidebar-fixed-bottom">
            <a href="#" class="btn btn-dark btn-block btn-show-group">
                <i class="icon icon-inline fa fa-angle-right"></i>
            </a>
        </div>
    </div>
    <div class="content container-fluid">
        @yield('content')
    </div>
</main>
<!-- SCRIPTS -->
<script src="{{asset('../js/jquery-2.2.4.min.js')}}"></script>
<script src="{{asset('../components/jquery-ui/jquery-ui.min.js')}}"></script>
<script src="{{asset('../js/bootstrap.min.js')}}"></script>
<script src="{{asset('../js/moment-with-locales.js')}}"></script>
<script src="{{asset('../js/jquery.mCustomScrollbar.concat.min.js')}}"></script>
<script src="{{asset('../js/jquery.stellar.min.js')}}"></script>
<script src="{{asset('../js/jquery.magnific-popup.min.js')}}"></script>
<script src="{{asset('../js/pnotify.custom.min.js')}}"></script>
<script src="{{asset('../js/owl.carousel.min.js')}}"></script>
<script src="{{asset('../js/jquery.validate.min.js')}}"></script>
<script src="{{asset('../js/jquery.animateNumber.min.js')}}"></script>
<script src="{{asset('../js/Chart.min.js')}}"></script>
<script src="{{asset('../js/sweetalert.min.js')}}"></script>
<script src="{{asset('../js/circle-progress.min.js')}}"></script>
<script src="{{asset('../components/jstree/jstree.min.js')}}"></script>
<script src="{{asset('../js/fullcalendar.min.js')}}"></script>
<script src="{{asset('../js/general.js')}}"></script>
<script src="{{asset('../components/toastr/toastr.min.js')}}"></script>
<script src="{{asset('../components/jquery-validation/jquery.validate.js')}}"></script>
<script src="{{asset('../components/loadingoverlay/loadingoverlay.min.js')}}"></script>
<script src="{{asset('../components/select2/select2.min.js')}}"></script>
<script src="{{asset('../components/icheck/icheck.min.js')}}"></script>
<script src="{{asset('../components/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js')}}"></script>
<script src="{{asset('../components/momentjs/moment_locales.min.js')}}"></script>
<script src="{{asset('../assets/js/funciones.js')}}"></script>
<script src="{{asset('../components/datatables/jquery.dataTables.min.js')}}"></script>

<script src="{{asset('../js/moment.js')}}"></script>

<!-- <script src="{{asset('../assets/js/exportar-excel/dataTables.buttons.min.js')}}"></script> -->
<script src="{{asset('../assets/DataTables/Buttons-1.5.4/js/dataTables.buttons.min.js')}}"></script>
<!-- <script src="{{asset('../assets/js/exportar-excel/buttons.flash.min.js')}}"></script> -->
<script src="{{asset('../assets/DataTables/Buttons-1.5.4/js/buttons.flash.min.js')}}"></script>
<!-- <script src="{{asset('../assets/js/exportar-excel/jszip.min.js')}}"></script> -->
<script src="{{asset('../assets/DataTables/JSZip-2.5.0/jszip.js')}}"></script>
<script src="{{asset('../assets/js/exportar-excel/pdfmake.min.js')}}"></script>
<script src="{{asset('../assets/js/exportar-excel/vfs_fonts.js')}}"></script>
<!-- <script src="{{asset('../assets/js/exportar-excel/buttons.html5.min.js')}}"></script> -->
<script src="{{asset('../assets/DataTables/Buttons-1.5.4/js/buttons.html5.js')}}"></script>
<!-- C:\xampp\htdocs\TombolaCuy\public\assets\DataTables\Buttons-1.5.4\js\buttons.html5 -->
<script src="{{asset('../assets/js/exportar-excel/buttons.print.min.js')}}"></script>


<!-- C:\xampp\htdocs\TombolaCuy\public\assets\DataTables\JSZip-2.5.0

C:/xampp/htdocs/TombolaCuy/public/assets/js/exportar-excel -->
@stack('Js')
</body>

</html>