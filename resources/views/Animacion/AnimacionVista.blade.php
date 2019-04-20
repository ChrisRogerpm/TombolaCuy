<!DOCTYPE html>
<html lang="en">
	<head>
		<title>Animación</title>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0">
		<link rel="shortcut icon" href="{{asset('images/logoat.jpg')}}">
    <link rel="stylesheet" href="{{asset('../components/toastr/toastr.min.css')}}">

    <link rel="stylesheet" href="{{asset('../css/Animacion/estilos_animacion_cuy.css')}}">
    <script>
    	


    </script>
	</head>
	<body >
		<div style="width:100%;height:100%;position:absolute;z-index: 10;background: 
rgba(0, 0, 0, 0) url(images/imgCuyCargando.jpg) no-repeat scroll center center / 100% 100%

		;z-index:2000;background-repeat: no-repeat;background-position: center center;background.size:100% 100%" 
		 id="imagen_cargando"></div>

		<div id="ImgContainer"></div>
		<div id="img_ganador">
            <div id='texto_ganador' style='font-family:RosewoodStd-Regular;height:50% ; width: 50%; font-size: 60vh;position:relative;left:35%;top:30%;color:black'>
         </div>
        </div>


		<div id="progreso" style="display:none;height: 400px; text-align: left; position: absolute; top: 18%; left: 23%; color: black">
		<img src="images/termo.png" style="width: 75px;height: 300px;position: absolute;">
		<span class="glass">
			<strong class="total" style="bottom: 24%"></strong>
			<span class="amount" id="barra_loading" style="height: 0%"></span>
		</span>
		<div class="bulb">
		</div>
		<span class="red-circle"></span>
		<span class="filler"></span>
		<div class="marks"><div class="line">--<br>--<br>--<br>--<br>--<br>--<br>--<br>--<br>--<br>--<br>--<br>--<br>--<br>--<br>--</div></div>
	</div>


	<div style="" class="wrapper" style="" id="termotetro_para_iniciar">
		<div class="number_" id="contador_para_activar">---</div>
		<div class="loader">
			<div class="inner" id="barra_loading_tpi" style="width: 0%;"></div>
		</div>
	</div>

	<div class="nroevento">
		<h1><span class="smaller">#</span><span class="smaller"></span><span id="idevento_titulo"> </span></h1>
	</div>

	<div id="container"></div>		
	<div id="contenedorEstadistica" class="nuevo_lados">
		<div class="image">
			<img src="images/apuestaTotal.jpg" alt="apuesta total">		
		</div>

		<h2>Estadísticas</h2>
		<h6 class="subtitulo">Números(últimos 120 Eventos)</h6>	
		<div class="contenidos_side">
			<table id="tableEstadistica" style="width:90%">
				<tr>
					<th class="cajaRoja">1</th><th id="1">0</th> <th class="cajaNegra">19</th><th id="19">0</th>
				</tr>
				<tr>
					<th class="cajaNegra">2</th><th id="2">0</th> <th class="cajaRoja">20</th><th id="20">0</th>
				</tr>
				<tr>
					<th class="cajaRoja">3</th><th id="3">0</th> <th class="cajaNegra">21</th><th id="21">0</th>
				</tr>
				<tr>
					<th class="cajaNegra">4</th><th id="4">0</th> <th class="cajaRoja">22</th><th id="22">0</th>
				</tr>
				<tr>
					<th class="cajaRoja">5</th><th id="5">0</th> <th class="cajaNegra">23</th><th id="23">0</th>
				</tr>
				<tr>
					<th class="cajaNegra">6</th><th id="6">0</th> <th class="cajaRoja">24</th><th id="24">0</th>
				</tr>
				<tr>
					<th class="cajaRoja">7</th><th id="7">0</th> <th class="cajaRoja">25</th><th id="25">0</th>
				</tr>
				<tr>
					<th class="cajaNegra">8</th><th id="8">0</th> <th class="cajaNegra">26</th><th id="26">0</th>
				</tr>
				<tr>
					<th class="cajaRoja">9</th><th id="9">0</th> <th class="cajaRoja">27</th><th id="27">0</th>
				</tr>
				<tr>
					<th class="cajaNegra">10</th><th id="10">0</th> <th class="cajaNegra">28</th><th id="28">0</th>
				</tr>
				<tr>
					<th class="cajaNegra">11</th><th id="11">0</th> <th class="cajaRoja">29</th><th id="29">0</th>
				</tr>
				<tr>
					<th class="cajaRoja">12</th><th id="12">0</th> <th class="cajaNegra">30</th><th id="30">0</th>
				</tr>

				<tr>
					<th class="cajaRoja">13</th><th id="13">0</th> <th class="cajaNegra">31</th><th id="31">0</th>
				</tr>
				<tr>
					<th class="cajaRoja">14</th><th id="14">0</th> <th class="cajaNegra">32</th><th id="32">0</th>
				</tr>
				<tr>
					<th class="cajaRoja">15</th><th id="15">0</th> <th class="cajaNegra">33</th><th id="33">0</th>
				</tr>
				<tr>
					<th class="cajaRoja">16</th><th id="16">0</th> <th class="cajaNegra">34</th><th id="34">0</th>
				</tr>
				<tr>
					<th class="cajaRoja">17</th><th id="17">0</th> <th class="cajaNegra">35</th><th id="35">0</th>
				</tr>
				<tr>
					<th class="cajaRoja">18</th><th id="18">0</th> <th class="cajaNegra">36</th><th id="36">0</th>
				</tr>
				<tr>
					<th class="cajaRoja" style="background-color:#3C8A39;width:50%" colspan="2">0</th><th id="0" colspan="2">0</th>
				</tr>
			</table>

		</div>		
	</div>	
	<div id="pagosHistorial" class="nuevo_lados">
		<div class="image">
			<img src="images/figura_lado.jpg"  alt="apuesta total" >		
		</div>
		<h2>Pagos</h2>	

		<div class="contenidos_side">
			<table id="">
				<tr>
					<th rowspan="3" >Color</th><th style="background-color: rgb(22, 39, 125);" >2</th>
				</tr>
				<tr>
					<th style="background-color: rgb(249, 215, 22);">2</th> 
				</tr>
				<tr>
					<th style="background-color:#3C8A39;width:50%" >36</th>
				</tr>
				<tr>
					<th >Docena</th><th>3</th>
				</tr>
				<tr>
					<th>Par / Impar</th><th>2</th>
				</tr>
				<tr>
					<th>Número</th><th>36</th>
				</tr>					
			</table>
		</div>
		
<!-- https://skywarriorthemes.com/orizon/blue/
 -->		<h2>Historial</h2>	
		<div class="contenidos_side">
			<table id="tablaUltimos">
			{{--<tr>--}}
				{{--<th class="caja">#123wqw1</th><th class="caja1">1</th>--}}
			{{--</tr>--}}
			{{--<tr>--}}
				{{--<th class="caja">#123wqw1</th><th class="caja1">2</th>--}}
			{{--</tr>--}}
			{{--<tr>--}}
				{{--<th class="caja">#123wqw1</th><th class="caja1">3</th>--}}
			{{--</tr>--}}
			{{--<tr>--}}
				{{--<th class="caja">#123wqw1</th><th class="caja1">4</th>--}}
			{{--</tr>--}}
			{{--<tr>--}}
				{{--<th class="caja">#123wqw1</th><th class="caja2">5</th>--}}
			{{--</tr>--}}
			{{--<tr>--}}
				{{--<th class="caja">#123wqw1</th><th class="caja2">6</th>--}}
			{{--</tr>--}}
			{{--<tr>--}}
				{{--<th class="caja">#123wqw1</th><th class="caja1">7</th>--}}
			{{--</tr>--}}
			{{--<tr>--}}
				{{--<th class="caja">#123wqw1</th><th class="caja2">8</th>--}}
			{{--</tr>--}}
			{{--<tr>--}}
				{{--<th class="caja">#123wqw1</th><th class="caja1">9</th>--}}
			{{--</tr>--}}
			{{--<tr>--}}
				{{--<th class="caja">#123wqw1</th><th class="caja2">10</th>--}}
			{{--</tr>--}}
			{{--<tr>--}}
				{{--<th class="caja">#123wqw1</th><th class="caja1">11</th>--}}
			{{--</tr>--}}
			{{--<tr>--}}
				{{--<th class="caja">#123wqw1</th><th class="caja2">12</th>--}}
			{{--</tr>					--}}
		</table>	
		</div>
			
	</div>	

	<script src="{{asset('../assets/js/jquery3_3_1.min.js')}}"></script>
	<script src="{{asset('../components/toastr/toastr.min.js')}}"></script>
	<script src="{{asset('../components/loadingoverlay/loadingoverlay.min.js')}}"></script>

	<script src="{{asset('../js/moment-with-locales.js')}}"></script>
	<script src="{{asset('../components/momentjs/moment_locales.min.js')}}"></script>
	<script src="{{asset('../js/moment.js')}}"></script>

	<script src="{{asset('../assets/js/three.js')}}"></script>
	<script src="{{asset('../assets/js/WebGL.js')}}"></script>
	<script src="{{asset('../assets/js/stats.min.js')}}"></script>
	<script src="{{asset('../assets/js/GLTFLoader.js')}}"></script>
	<script src="{{asset('../assets/js/dat.gui.min.js')}}"></script>
	<script src="{{asset('../assets/js/OrbitControls.js')}}"></script>
	<script src="{{asset('../assets/js/animacion.js')}}"></script>
	<script src="{{asset('../assets/js/animacion_cuy.js')}}"></script>



	<script src="{{asset('../assets/js/ClaseWebSocketsCuy.js')}}"></script>


</body>
</html>
