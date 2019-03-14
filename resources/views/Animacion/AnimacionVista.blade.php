<!DOCTYPE html>
<html lang="en">
	<head>
		<title>Animacion</title>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0">
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
				background-image: url("imgCuyInicio.jpg");  
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
				background-color:green;
				height:100vh;
				width:20vw;
			}
			#cajaInteriror{
				position: absolute;
				height:90%;
				width:95%;
				margin: auto;			
				overflow: auto;
				top: 5vh; left: 0; bottom: 0; right: 0;
				border: solid black;
			}
			#tableEstadistica{				
				width:90%;
				margin:auto;
			}
			table {
				border-collapse: collapse;
			}
			table, th, td {
				border: 3px solid;
			}
			.cajaRoja{
				background-color:red;
			}
			.cajaNegra{
				background-color:white;
				color:black;			
			}
		</style>
	</head>
	<body>
		<div id="ImgContainer"></div>
		<div id="container"></div>		
		<div id="contenedorEstadistica">
			<h1>Estadisticas</h1>	
			<div id="cajaInteriror">
				<h2>Numeros (ultimos 120 Eventos)</h2>	
				<table id="tableEstadistica">
					<tr>
						<th class="cajaRoja">1</th><th>3</th> <th class="cajaNegra">13</th><th>2</th>
					</tr>
					<tr>
						<th class="cajaNegra">2</th><th>3</th> <th class="cajaRoja">14</th><th>2</th>
					</tr>
					<tr>
						<th class="cajaRoja">3</th><th>3</th> <th class="cajaNegra">15</th><th>2</th>
					</tr>
					<tr>
						<th class="cajaNegra">4</th><th>3</th> <th class="cajaRoja">16</th><th>2</th>
					</tr>
					<tr>
						<th class="cajaRoja">5</th><th>3</th> <th class="cajaNegra">17</th><th>2</th>
					</tr>
					<tr>
						<th class="cajaNegra">6</th><th>3</th> <th class="cajaRoja">18</th><th>2</th>
					</tr>
					<tr>
						<th class="cajaRoja">7</th><th>3</th> <th class="cajaRoja">19</th><th>2</th>
					</tr>
					<tr>
						<th class="cajaNegra">8</th><th>3</th> <th class="cajaNegra">20</th><th>2</th>
					</tr>
					<tr>
						<th class="cajaRoja">9</th><th>3</th> <th class="cajaRoja">21</th><th>2</th>
					</tr>
					<tr>
						<th class="cajaNegra">10</th><th>3</th> <th class="cajaNegra">22</th><th>2</th>
					</tr>
					<tr>
						<th class="cajaNegra">11</th><th>3</th> <th class="cajaRoja">23</th><th>2</th>
					</tr>
					<tr>
						<th class="cajaRoja">12</th><th>3</th> <th class="cajaNegra">24</th><th>2</th>
					</tr>
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