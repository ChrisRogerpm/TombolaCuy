#!/php -q
<?php  
// Run from command prompt > php -q ws_server.php
include "clase_phpwebsocket.php";

$server_ip="192.168.1.60";  //what is the IP of your server
$puerto=50051;



$GLOBALS['servername'] = "192.168.1.60";
$GLOBALS['username'] = "sa";
$GLOBALS['password'] = "123123";
$GLOBALS['db'] = "bd_s3k_tombolacuy_limpia";

probarconexion_mysql();
// Extended basic WebSocket as ws_server
class ws_server extends phpWebSocket{
  //Overridden process function from websocket.class.php
  function process($user,$msg){
    $c=0;
    $this->say("(user: ".$user->id.") msg> ".$msg);
    //$this->say("< ".$msg);
    date_default_timezone_set('America/Lima');
    switch($msg){
     case "enviar_todos" : $this->broadcast(date("Y-m-d H:i:s")); break; //
     case "ping" :  $this->send($user->socket,"pong"); break; //heartbeat frame reply with pong
     case "hello" : $this->send($user->socket,"hello human");                       break;
     case "name"  : $this->send($user->socket,"My Name is".php_uname("n") );    break;
     case "date"  : $this->send($user->socket,date("Y-m-d H:i:s"));    break;
     case "dateJSON"  : $this->sendJSON($user,date("Y-m-d H:i:s"),"dateJSON");    break;
     case "hora"  : $this->send($user->socket,date("h:i:s a"));                 break;
     case "time"  : $this->send($user->socket,"server time is ".date("H:i:s"));     break;
     case "id" :  $this->send($user->socket,"Id: ".$user." \r\n","id");    break;
     case "conectados" :  $this->send($user->socket,"Usuarios Conectados: ".count($this->users));    break;
     case "users":  $list=" \r\nUsuarios: \r\n";
            foreach($this->users as $u)
               $list.=" #".++$c.".- $u \r\n";
            $this->send($user->socket,$list); 
           break;
          
     case "bye"   : $this->send($user->socket,"bye");                               
            $this->disconnect($user->socket);
            break;

     case "eventoJSON":  $evento_actual=$this->getEventoActual(1);$this->sendJSON($user,$evento_actual,"eventoJSON"); break;

      default      : $this->send($user->socket,$msg." not understood - ".date("H:i:s") );              break;
    }
  }
}  //end class

$master = new ws_server($server_ip,$puerto);
