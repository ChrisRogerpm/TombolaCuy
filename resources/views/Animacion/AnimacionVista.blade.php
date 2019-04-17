<!DOCTYPE html>
<html lang="en">
	<head>
		<title>Animación</title>
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
				z-index:2;
				width: 60vw;
    			height: 100vh;  
				background-image: url("images/fondo_inicio.jpg");  
				background-position: center;
				background-repeat: no-repeat;
				background-size:100% 100%;
				position:absolute;
				left:20%;
			}
            #img_ganador{
              display:none;
				z-index:2;
				width: 60vw;
    			height: 100vh;  
				background-image: url("images/fondo_ganador_nro.jpeg");  
				background-position: center;
				background-repeat: no-repeat;
				background-size:100% 100%;
				position:absolute;
				left:20%;
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
				/*position: absolute;*/
				bottom:0px;				
				height:68%;
				/*width:100%;*/
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
			.nroevento {
				width: 30%;	
				/*margin-right: auto;
				margin-left: auto;
				*/border: 1px solid #424242;
				/*margin-bottom: 10px;*/
				margin:0.5% auto auto;position:absolute;
				background: #2c2e38 url(images/retro.jpg) center center;
				/*margin:auto;
				//margin-top:0.5%;*/
				z-index:1;position:absolute;
				left:35%;
			}

			h1 {
				color: #d7ceb2;	text-shadow: 3px 3px 0px #2c2e38, 5px 5px 0px #5c5f72;
				font-size: 25px;
				letter-spacing: 6px;
				margin-top:10px;margin-bottom:10px;
			}


			.smaller {
				font-size: 23px;
				vertical-align: .2em;
			}


			@font-face {
				font-family: RosewoodStd-Regular;
				src: url("fonts/RosewoodStd-Regular.otf") format("opentype");
			}


/*////////////////////////*/
.glass {
  background: #D8D4D5;
    border-radius: 100px 100px 0 0;
    display: block;
    height: 240px; 
    padding: 7px;
    position: absolute;
    width: 3px;
    margin-top: 16px;
    margin-left: 31px;
    z-index: 4;
}
.amount {
    background: rgb(45, 82, 216) ;
    border-radius: 100px;
    display: block;
    width: 7px;
    position: absolute;
    bottom: -5px;
    margin-left: -2px;
}

.bulb {
    background: #D8D4D5;
    border-radius: 100px;
    display: block;
    height: 28px;
    padding: 5px;
    position: absolute;
    width: 28px;
    margin-top: 247px;
    margin-left: 20px;
    z-index: 3;
}
.red-circle {
  background: rgb(45, 82, 216);
    border-radius: 100px;
    display: block;
    height: 30px;
    width: 30px;
    position: absolute;
    z-index: 8;
    margin-top: 251px;
    margin-left: 24px;
}
.filler {
    background:  rgb(45, 82, 216);
    border-radius: 100px 100px 0 0;
    display: block;
    height: 30px;
    width: 7px;
    position: absolute;
    z-index: 30;
    margin-top: 239px;
    margin-left: 36px;
}

.marks{
  width: 20px;
  height: 90px;
  position: absolute;
  z-index: 40;
  margin-left: 14px;
}

.line{
  line-height: 15px;
    margin-top: 19px;
}




.wrapper {
  width: 300px;
  height: 30px;
  background: #2c2c2c;
  border-radius: 30px;
  position: relative;
  transform: rotate(-90Deg) scale(0.85);
   left: 12%;
  bottom: 20%;
  position:absolute;
}

.wrapper:before {
  content: "";
  position: absolute;
  background: inherit;
  border-radius: 50%;
  width: 45px;
  height: 45px;
  left: -10px;
  top: 50%;
  margin-top: -22px;
  box-shadow: inset 0 1px 0 rgba(255, 255, 255, 0.1), 
              inset 0 -3px 2px rgba(0, 0, 0, 0.12), 
              0 5px 5px rgba(0, 0, 0, 0.4), 
              0 0 5px rgba(0, 0, 0, 0.4), 
              inset 0 -15px 10px rgba(0, 0, 0, 0.25);
}

.wrapper:after {
  content: "";
  height: 100%;
  width: 10px;
  background: #2c2c2c;
  position: absolute;
  left: 28px;
  top: 0;
  box-shadow: inset 0 1px 0 rgba(255, 255, 255, 0.1), 
              inset 0 -3px 2px rgba(0, 0, 0, 0.3), 
              0 5px 2px rgba(0, 0, 0, 0.2), 
              inset 0 -15px 0px rgba(0, 0, 0, 0.25);
}

.loader {
  width: 95%;
  height: 50%;
  position: absolute;
  left: 0;
  top: 50%;
  margin-top: -8px;
  background: #404040;
  border-radius: inherit;
  z-index: 100;
  box-shadow: inset 0 0 7px rgba(0, 0, 0, 0.4), 
              inset 0 3px 3px rgba(0, 0, 0, 0.5), 
              inset 0 -5px 5px rgba(0, 0, 0, 0.4), 
              0 1px 0 rgba(255, 255, 255, 0.1);
}

.inner {
  width: 0%;
  height: 100%;
  background: #2b8095;
  background: linear-gradient(to right, #237686, #34476f, #5b426c, #965666, #ba835c, #d0c746, #e74c3c);
/*animation: loader 5s ease-out infinite;*/
  border-radius: inherit;
  box-shadow: inset 0 1px 0 rgba(255, 255, 255, 0.3), 
              inset 0 8px 1px rgba(255, 255, 255, 0.1), 
              inset 0 -2px 1px rgba(255, 255, 255, 0.1);
}

.inner:after {
  content: "";
  position: absolute;
  width: 30px;
  height: 30px;
  border-radius: 50%;
  background: #2b8095;
  background: linear-gradient(#63b5c0, #146a77);
  left: -3px;
  top: 50%;
  margin-top: -15px;
  box-shadow: inset 0 2px 3px rgba(255, 255, 255, 0.2), 
              inset 0 -4px 2px rgba(255, 255, 255, 0.1);
}

.inner:before {
  content: "";
  position: absolute;
  height: 100%;
  background: linear-gradient(to right, #2b8095, rgba(64, 64, 64, 0));
  width: 20px;
  top: 0;
  left: 25px;
  z-index: 200;
}

		</style>
	</head>
	<body>
		<div id="ImgContainer"></div>
		<div id="img_ganador">
            <div id='texto_ganador' style='font-family: RosewoodStd-Regular;height:50% ; width: 50%; font-size: 60vh;position:relative;left:35%;top:30%;color:black'>
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




<div style="display:none" class="wrapper" style="" id="termotetro_para_iniciar">
  <div class="loader">
    <div class="inner" id="barra_loading_tpi" style="width: 0%;"></div>
  </div>
</div>


		<div class="nroevento">
			<h1><span class="smaller"></span> <span class="smaller">#</span><span class="smaller"></span><span id="idevento_titulo"> --</span> <span class="smaller"></span></h1>
	</div>

		<div id="container"></div>		
		<div id="contenedorEstadistica">
			<img src="images/apuestaTotal.jpg" alt="apuesta total" style="width:75%;margin-top: 5vh;height:18%">
			<h1>Estadísticas</h1>	
			<div id="cajaInteriror">
				<h2 style="margin-top:5px;margin-bottom:5px">Números últimos 120 Eventos</h2>	
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
		<div id="pagosHistorial">
			<img src="images/fondo_inicio.jpg" alt="apuesta total" style="width:90%;margin-top: 2vh;">			
			<div id="cajaInterirorIzquierda">
				<h2 style="margin-top:5px;margin-bottom:5px">Pagos</h2>	
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
				<br />
				<h2 style="margin-top:2px;margin-bottom:8px">Historial</h2>	
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
			
		<script src="{{asset('../components/loadingoverlay/loadingoverlay.min.js')}}"></script>

        <script src="{{asset('../assets/js/three.js')}}"></script>
        <script src="{{asset('../assets/js/WebGL.js')}}"></script>
        <script src="{{asset('../assets/js/stats.min.js')}}"></script>
        <script src="{{asset('../assets/js/GLTFLoader.js')}}"></script>
        <script src="{{asset('../assets/js/dat.gui.min.js')}}"></script>
        <script src="{{asset('../assets/js/OrbitControls.js')}}"></script>
        <script src="{{asset('../assets/js/animacion.js')}}"></script>


        <script src="{{asset('../assets/js/animacion_cuy.js')}}"></script>


	</body>
</html>
