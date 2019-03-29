<!DOCTYPE html>
<html lang="en">
	<head>
		<title>Animacion</title>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0">
		<link rel="shortcut icon" href="{{asset('images/logoat.jpg')}}">
		<style>
			body {
				color: #fff;
				font-family:Monospace;
				font-size:13px;
				text-align:center;
				background-color: #fff;
				margin: 0px;
				overflow: hidden;
			}			
			a {
				color: #ff0000;
			}
			.ac {  /* prevent dat-gui from being selected */
				-webkit-user-select: none;
				-moz-user-select: none;
				-ms-user-select: none;
				user-select: none;
			}
			.no-pointer-events {
				pointer-events: none;
			}
			.control-disabled {
				color: #888;
				text-decoration: line-through;
			}
			#ImgContainer{
				width: 100vw;
    			height: 100vh;  
				background-image: url("images/imgCuyInicio.jpg");  
				background-position: center;
				background-repeat: no-repeat;
			}
			#container{
				z-index:10;
			}
			#contenedorEstadistica{
				z-index:1000;
				position:absolute;
				top:0;
				right:0;
				background-color:#13502e;
				height:100vh;
				width:20vw;
			}
			#pagosHistorial{
				z-index:1000;
				position:absolute;
				top:0;
				left:0;
				background-color:#13502e;
				height:100vh;
				width:20vw;
			}
			#cajaInteriror{
				position: absolute;
				bottom:0px;				
				height:48%;
				width:100%;
				margin: auto;		
				background-color:#303e5a;
				overflow: auto;
				/* top: 5vh; left: 0; bottom: 0; right: 0; */
				border: solid white;
			}
			#cajaInterirorIzquierda{
				position: absolute;
				bottom:0px;				
				height:70%;
				width:98%;
				margin: auto;		
				background-color:#303e5a;
				overflow: auto;
				border: solid white;
			}
			table{				
				width:90%;
				margin:auto;
			}
			table {
				border-collapse: collapse;
			}
			table, th, td {
				border: 2px solid white;				
			}
			tr{
				height: 3vh;
			}
			.cajaRoja{
				background-color:#DC2525;
				width:20%;
			}
			.cajaNegra{
				background-color:#C3C3C3;
				color:black;			
				width:20%;
			}
			.caja{							
				width:50%;
			}
			.caja1{							
				background-color:#C3C3C3;
				width:50%;
			}
			.caja2{							
				background-color:#DC2525;
				width:50%;
			}
			.caja0{							
				background-color:#3C8A39;
				width:50%;
			}
		</style>
	</head>
	<body>
		<div id="ImgContainer"></div>
		<div id="container"></div>		
		<div id="contenedorEstadistica">
			<img src="images/apuestaTotal.jpg" alt="apuesta total" style="width:90%;margin-top: 5vh;">
			<h1>Estadisticas</h1>	
			<div id="cajaInteriror">
				<h2>Numeros (ultimos 120 Eventos)</h2>	
				<table id="tableEstadistica">
					<tr>
						<th class="cajaRoja">1</th><th id="1">0</th> <th class="cajaNegra">13</th><th id="13">0</th>
					</tr>
					<tr>
						<th class="cajaNegra">2</th><th id="2">0</th> <th class="cajaRoja">14</th><th id="14">0</th>
					</tr>
					<tr>
						<th class="cajaRoja">3</th><th id="3">0</th> <th class="cajaNegra">15</th><th id="15">0</th>
					</tr>
					<tr>
						<th class="cajaNegra">4</th><th id="4">0</th> <th class="cajaRoja">16</th><th id="16">0</th>
					</tr>
					<tr>
						<th class="cajaRoja">5</th><th id="5">0</th> <th class="cajaNegra">17</th><th id="17">0</th>
					</tr>
					<tr>
						<th class="cajaNegra">6</th><th id="6">0</th> <th class="cajaRoja">18</th><th id="18">0</th>
					</tr>
					<tr>
						<th class="cajaRoja">7</th><th id="7">0</th> <th class="cajaRoja">19</th><th id="19">0</th>
					</tr>
					<tr>
						<th class="cajaNegra">8</th><th id="8">0</th> <th class="cajaNegra">20</th><th id="20">0</th>
					</tr>
					<tr>
						<th class="cajaRoja">9</th><th id="9">0</th> <th class="cajaRoja">21</th><th id="21">0</th>
					</tr>
					<tr>
						<th class="cajaNegra">10</th><th id="10">0</th> <th class="cajaNegra">22</th><th id="22">0</th>
					</tr>
					<tr>
						<th class="cajaNegra">11</th><th id="11">0</th> <th class="cajaRoja">23</th><th id="23">0</th>
					</tr>
					<tr>
						<th class="cajaRoja">12</th><th id="12">0</th> <th class="cajaNegra">24</th><th id="24">0</th>
					</tr>
					<tr>
						<th class="cajaRoja" style="background-color:#3C8A39;width:50%" colspan="2">0</th><th id="0" colspan="2">0</th>
					</tr>
				</table>
			</div>			
		</div>	
		<div id="pagosHistorial">
			<img src="images/imgCuyInicio.jpg" alt="apuesta total" style="width:90%;margin-top: 2vh;">			
			<div id="cajaInterirorIzquierda">
				<h2>Pagos</h2>	
				<table id="">
					<tr>
						<th rowspan="3" >Color</th><th class="cajaRoja">2</th>
					</tr>
					<tr>
						<th class="cajaNegra">2</th> 
					</tr>
					<tr>
						<th style="background-color:#3C8A39;width:50%" >24</th>
					</tr>
					<tr>
						<th >1/2 Docena</th><th>2</th>
					</tr>
					<tr>
						<th>Par / Impar</th><th>2</th>
					</tr>
					<tr>
						<th>Número</th><th>24</th>
					</tr>					
				</table>
				<br />
				<h2>Historial</h2>	
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

		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>	
			
		
        <script src="{{asset('../assets/js/three.js')}}"></script>
        <script src="{{asset('../assets/js/WebGL.js')}}"></script>
        <script src="{{asset('../assets/js/stats.min.js')}}"></script>
        <script src="{{asset('../assets/js/GLTFLoader.js')}}"></script>
        <script src="{{asset('../assets/js/dat.gui.min.js')}}"></script>
        <script src="{{asset('../assets/js/OrbitControls.js')}}"></script>
        <script src="{{asset('../assets/js/animacion.js')}}"></script>

	</body>
</html>