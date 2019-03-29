<!DOCTYPE html>
<html lang="en">

<!-- Mirrored from vtdes.ru/demo/caspero/xp-login.html by HTTrack Website Copier/3.x [XR&CO'2014], Wed, 16 Jan 2019 14:13:31 GMT -->
<head>

    <!-- Page title -->
    <title>Tombola Cuy</title>
    <!-- /Page title -->

    <!-- Meta -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
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

    <link rel="stylesheet" href="{{asset('css/theme.css')}}">
    <link rel="stylesheet" href="{{asset('css/demo.css')}}">
    <link rel="stylesheet" href="{{asset('components/toastr/toastr.min.css')}}">

    <!-- /Styles -->

</head>
<body class="">

<!-- MAIN CONTAINER -->
<main class="main-container no-margin no-padding">

    <!-- FULLSCREEN -->
    <div class="fullscreen">

        <!-- VERTICAL MIDDLE -->
        <div class="vertical-middle">

            <!-- CONTENT AREA -->
            <div class="content container">

                @yield('content')

            </div>
            <!-- /CONTENT AREA -->

        </div>
        <!-- /VERTICAL MIDDLE -->

    </div>
    <!-- /FULLSCREEN -->

</main>
<!-- /MAIN CONTAINER -->


<!-- SCRIPTS -->

<script src="{{asset('js/jquery-2.2.4.min.js')}}"></script>
<script src="{{asset('components/jquery-ui/jquery-ui.min.js')}}"></script>
<script src="{{asset('js/bootstrap.min.js')}}"></script>
<script src="{{asset('js/moment-with-locales.js')}}"></script>
<script src="{{asset('js/jquery.mCustomScrollbar.concat.min.js')}}"></script>
<script src="{{asset('js/jquery.stellar.min.js')}}"></script>
<script src="{{asset('js/jquery.magnific-popup.min.js')}}"></script>
<script src="{{asset('js/pnotify.custom.min.js')}}"></script>
<script src="{{asset('js/owl.carousel.min.js')}}"></script>
<script src="{{asset('js/jquery.validate.min.js')}}"></script>
<script src="{{asset('js/jquery.animateNumber.min.js')}}"></script>
<script src="{{asset('js/Chart.min.js')}}"></script>
<script src="{{asset('js/sweetalert.min.js')}}"></script>
<script src="{{asset('js/circle-progress.min.js')}}"></script>
<script src="{{asset('components/jstree/jstree.min.js')}}"></script>
<script src="{{asset('js/fullcalendar.min.js')}}"></script>
<script src="{{asset('js/general.js')}}"></script>
<script src="{{asset('js/demo.js')}}"></script>
<script src="{{asset('components/toastr/toastr.min.js')}}"></script>
<script src="{{asset('components/jquery-validation/jquery.validate.js')}}"></script>
<script src="{{asset('components/loadingoverlay/loadingoverlay.min.js')}}"></script>
<script src="{{asset('assets/js/funciones.js')}}"></script>
@stack('js')
</body>

<!-- Mirrored from vtdes.ru/demo/caspero/xp-login.html by HTTrack Website Copier/3.x [XR&CO'2014], Wed, 16 Jan 2019 14:13:32 GMT -->
</html>