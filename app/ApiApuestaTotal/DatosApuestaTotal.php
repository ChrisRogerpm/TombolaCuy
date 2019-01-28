<?php
App\ApiApuestaTotal\Curl;

//Login de tiendas con centro de costo y contrasena
// $request = [
// 	'opt' => 'login',
// 	'source' => 'sorteoElectronico',
//     'cc_id' => '4739',
//     'password' => '0b033074ca'
// ];

//Login de Cajeros con usuario y password encryptado a MD5
// $request = [
// 	'opt' => 'login',
// 	'source' => 'tombolaCuy',
//     'usuario' => 'cajero1',
//     'password' => md5('cajero1')
// ];

//Obtener descripcion de Tienda brindando su unit_id
// $request = [
// 	'opt' => 'data',
// 	'source' => 'unit',
// 	'unit_id' => '81123'
// ];

//Obtener el listado de todas las tiendas del sistema que están activas.
$request = [
	'opt' => 'data',
	'source' => 'locales'
];



$s3k_password = "j3KJ0sdfldsKMmll0965Kwrfdml540QN";

$curl = New Curl($s3k_password);
//echo "<pre>"; var_dump($curl->post($request)); echo "</pre>"; die;
echo json_encode($curl->post($request));


?>