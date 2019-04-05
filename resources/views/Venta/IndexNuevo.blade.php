@extends('Shared.layout')

@section('body-class')
    sidebar-style loaded
@stop


@section('content')
    @include('Venta.CajaTabla');
@stop

@push('Js')
    <link rel="stylesheet" href="{{asset('../css/caja/estilos_caja.css')}}">
    <!-- <script src="{{asset('../assets/Venta/ServerDate.js')}}"></script> -->
    <script src="{{asset('../assets/Venta/FuncionesCaja.js')}}"></script>
    <script src="{{asset('../assets/Venta/Index.js')}}"></script>
    <script src="{{asset('../assets/Venta/ClaseWebSockets.js')}}"></script>
    <?php if($error!=""){?>
        <script>toastr.error("<?php echo $error;?>")</script>
    <?php }?>

@endpush



