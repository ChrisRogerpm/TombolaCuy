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
		</style>
	</head>
	<body>
		<div id="ImgContainer"></div>
		<div id="container"></div>		

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