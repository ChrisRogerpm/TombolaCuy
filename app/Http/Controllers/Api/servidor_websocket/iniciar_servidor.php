#!/php -q
<?php  
// Run from command prompt > php -q ws_server.php
include "clase_phpwebsocket.php";

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
    case "ping" :    $this->send($user->socket,"pong"); break; //heartbeat frame reply with pong
      case "hello" : $this->send($user->socket,"hello human");                       break;
      case "name"  : $this->send($user->socket,"My Name is".php_uname("n") );     break;
      case "date"  : $this->send($user->socket,date("Y-m-d H:i:s"));    break;
      case "dateJSON"  : $this->sendJSON($user,date("Y-m-d H:i:s"),"dateJSON");    break;
      case "time"  : $this->send($user->socket,"server time is ".date("H:i:s"));     break;
      case "thanks": $this->send($user->socket,"you're welcome");                    break;
    case "id" :   $this->send($user->socket,"You are user: ".$user." \r\n");    break;
     case "eventoJSON":  $evento_actual=$this->getEventoActual(1);$this->send($user->socket,$evento_actual,"evento"); break;
    case "users":  $list="User's List \r\n";
            foreach($this->users as $u)
               $list.="user #".++$c.". $u \r\n";
               
            $this->send($user->socket,$list); 
           break;
          
      case "bye"   : $this->send($user->socket,"bye");                               
            $this->disconnect($user->socket);
            break;
      default      : $this->send($user->socket,$msg." not understood - ".date("H:i:s") );              break;
    }
  }
  


  
}  //end class

$master = new ws_server($server_ip,$puerto);
