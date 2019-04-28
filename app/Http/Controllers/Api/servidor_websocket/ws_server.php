#!/php -q
<?php  
// Run from command prompt > php -q ws_server.php
include "phpwebsocket.php";

$server_ip="192.168.1.66";  //what is the IP of your server
$puerto=50051;



$GLOBALS['servername'] = "192.168.1.66";
$GLOBALS['username'] = "sa";
$GLOBALS['password'] = "";
$GLOBALS['db'] = "bd_s3k_tombolacuy_limpia";


// Extended basic WebSocket as ws_server
class ws_server extends phpWebSocket{
  //Overridden process function from websocket.class.php
  function process($user,$msg){
    $c=0;
  	$this->say("(user: ".$user->id.") msg> ".$msg);
    //$this->say("< ".$msg);
	  date_default_timezone_set('America/Lima');
    switch($msg){
	   case "enviar_todos" : $this->broadcast(date("Y-m-d H:i:s"),'enviar_todos'); break; //
     case "date"  : $this->send($user->socket,date("Y-m-d H:i:s"));    break;
     case "dateJSON"  : $this->sendJSON($user->socket,date("Y-m-d H:i:s"),"date");    break;
     case "hora"  : $this->send($user->socket,date("h:i:s a"),"hora");           			break;
     case "time"  : $this->send($user->socket,"server time is ".date("H:i:s"),"time");     break;
	   case "id" : 	$this->send($user->socket,"Id: ".$user." \r\n","id");    break;
	   case "conectados" : 	$this->send($user->socket,"Usuarios Conectados: ".count($this->users));    break;
	   case "users":  $list=" \r\nUsuarios: \r\n";
						foreach($this->users as $u)
						   $list.=" #".++$c.".- $u \r\n";
						$this->send($user->socket,$list,"users"); 
					 break;
					
     
     case "eventoJSON":  $evento_actual=$this->getEventoActual(1);$this->send($user->socket,$evento_actual,"evento"); break;
      default      : $this->sendJSON($user->socket,$msg." not understood - ".date("H:i:s") ,"notunderstood");              break;
    }
  }
}  //end class

$master = new ws_server($server_ip,$puerto);
