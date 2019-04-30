<?php  
/***************************************************************
*  phpWebSocket: modified PHP-Websockets code to handle websockets
* 
*  original source: https://github.com/ghedipunk/PHP-WebSockets
*  this modified source: http://www.abrandao.com  
*
*/
// Usage: $master=new WebphpWebSocketSocket("localhost",12345);

function probarconexion_mysql(){
  try{
      $mysqli = new mysqli( $GLOBALS['servername'],  $GLOBALS['username'] ,   $GLOBALS['password'],$GLOBALS['db']);
      if ($mysqli->connect_errno) {
          printf("Conexión  falló: %s\n", $mysqli->connect_error);
          exit();
      }
  /* check if server is alive */
      if ($mysqli->ping()) {
          printf ("Conexión mysql ok!\n");
      } else {
          printf ("Error: %s\n", $mysqli->error);
          exit();
      }
     $mysqli->close();
  }
  catch(Exception $ex){
      echo "aca= ". $ex->getMessage();
  }
    


}

class phpWebSocket{
  var $master;
  var $sockets = array(); //create an array of socket objects 
  var $users   = array(); //create an array of users objects to handle discussions with users
  var $debug   = false;



  
  function ascii_banner() //just for old-skool fun...
  {
  $banner="               _    ____             _        _   \n";
  $banner.=" __      _____| |__/ ___|  ___   ___| | _____| |_\n ";
  $banner.="\ \ /\ / / _ \ '_ \___ \ / _ \ / __| |/ / _ \ __|\n";
  $banner.="  \ V  V /  __/ |_) |__) | (_) | (__|   <  __/ |_ \n";
  $banner.="   \_/\_/ \___|_.__/____/ \___/ \___|_|\_\___|\__|\n";
  return $banner;
                                                 
  }
  
  function __construct($address,$port){
  // error_reporting(E_ALL);
    set_time_limit(0);
    ob_implicit_flush();

    $this->master=socket_create(AF_INET, SOCK_STREAM, SOL_TCP)     or die("socket_create() failed");
    socket_set_option($this->master, SOL_SOCKET, SO_REUSEADDR, 1)  or die("socket_option() failed");
    socket_bind($this->master, $address, $port)                    or die("socket_bind() failed");
    socket_listen($this->master,20)                                or die("socket_listen() failed");
    $this->sockets[] = $this->master;

    $this->say($this->ascii_banner() );
    $this->say("PHP WebSocket Servidor Ejecutándose....");
    $this->say("Server Iniciado : ".date('Y-m-d H:i:s'));
    $this->say("Escuchando en   : ".$address." port ".$port);
    $this->say("Master socket  : ".$this->master."\n");
    $this->say(".... Esperando Conexiones ...");


  
  // Main Server processing loop
    while(true)  //server is always listening
    {
      $changed = $this->sockets;
      $write = array();
      $except = array();
      socket_select($changed,$write,$except,NULL);
      $this->say("Escuchando... Conectados:".count($this->users)."\n");
      foreach($changed as $socket)
      {

        if($socket==$this->master){
          $client=socket_accept($this->master);
          if($client<0){ $this->log("socket_accept() failed"); continue; }
          else{ 
            $this->connect($client); ///conectar cliente
          }
        }
        else{///clientes 

          $user = $this->getuserbysocket($socket);
          $this->say("cliente ".$user);
            $bytes = @socket_recv($socket,$buffer,2048,0);
            if($bytes==0)
            { 
                 $this->say("disconnect $user->id");

             $this->disconnect($socket); ///cliente desconectado
            }
            else{
              $user = $this->getuserbysocket($socket);
              if(!$user->handshake)
              { 
                 $this->say("Handshaking $user");
                 $this->dohandshake($user,$buffer);
                //$this->send($socket,date("h:i:s a"));

              }
               else
              { 
                $decode=$this->frame_decode($buffer);
                if($decode=="ping"){
                   $this->disconnect($socket);
                }else{
                  $this->process($user,$decode ); 
                }
              } 
            }
        }
      } //foreach socket
    } //main loop
  } //function  __construct

  function process($user,$msg){
    /* Extend and modify this method to suit your needs */
    /* Basic usage is to echo incoming messages back to client */
     $this->send($user->socket,$msg);
  }
  
   function broadcast($msg){
     foreach($this->users as $user){ //send to ALL connected users
       if(isset($user->socket)==true ) //confirm there's still a connection
       $this->send($user->socket,$msg);
     } //end foreach
 }

 
  function send_pong($user)
  {
   $bytesHeader[0] = 138; // 1xA Pong frame (FIN + opcode)
   $msg = implode(array_map("chr", $bytesHeader)) ;
   $this->send($user->socket,$msg);
  }
  
  /**
 * Encode a text for sending to clients via ws://
 * @param $message
 * WebSocket frame 
 
+-+-+-+-+-------+-+-------------+-------------------------------+
0                   1                   2                   3
0 1 2 3 4 5 6 7 8 9 0 1 2 3 4 5 6 7 8 9 0 1 2 3 4 5 6 7 8 9 0 1
+-+-+-+-+-------+-+-------------+-------------------------------+
|F|R|R|R| opcode|M| Payload len |    Extended payload length    |
|I|S|S|S|  (4)  |A|     (7)     |             (16/64)           |
|N|V|V|V|       |S|             |   (if payload len==126/127)   |
| |1|2|3|       |K|             |                               |
+-+-+-+-+-------+-+-------------+ - - - - - - - - - - - - - - - +
|     Extended payload length continued, if payload len == 127  |
+ - - - - - - - - - - - - - - - +-------------------------------+
|                               |Masking-key, if MASK set to 1  |
+-------------------------------+-------------------------------+
| Masking-key (continued)       |          Payload Data         |
+-------------------------------- - - - - - - - - - - - - - - - +
:                     Payload Data continued ...                :
+ - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - +
|                     Payload Data continued ...                |
+---------------------------------------------------------------+
 */
function frame_encode($message) {

    $length = strlen($message);

    $bytesHeader = [];
    $bytesHeader[0] = 129; // 0x1 text frame (FIN + opcode)

    if ($length <= 125) {
            $bytesHeader[1] = $length;
    } else if ($length >= 126 && $length <= 65535) {
            $bytesHeader[1] = 126;
            $bytesHeader[2] = ( $length >> 8 ) & 255;
            $bytesHeader[3] = ( $length      ) & 255;
    } else {
            $bytesHeader[1] = 127;
            $bytesHeader[2] = ( $length >> 56 ) & 255;
            $bytesHeader[3] = ( $length >> 48 ) & 255;
            $bytesHeader[4] = ( $length >> 40 ) & 255;
            $bytesHeader[5] = ( $length >> 32 ) & 255;
            $bytesHeader[6] = ( $length >> 24 ) & 255;
            $bytesHeader[7] = ( $length >> 16 ) & 255;
            $bytesHeader[8] = ( $length >>  8 ) & 255;
            $bytesHeader[9] = ( $length       ) & 255;
    }
   //apply chr against bytesHeader , then prepend to message
    $str = implode(array_map("chr", $bytesHeader)) . $message;
    return $str;
} 
 
 /**
 * frame_decode (decode data frame)  a received payload (websockets)
 * @param $payload  (Refer to: https://tools.ietf.org/html/rfc6455#section-5 )
 */
 function frame_decode($payload) 
 {
  if (!isset($payload))
    return null;  //empty data return nothing

    $length = ord($payload[1]) & 127;

    if($length == 126) {
        $masks = substr($payload, 4, 4);
        $data = substr($payload, 8);
    }
    elseif($length == 127) {
        $masks = substr($payload, 10, 4);
        $data = substr($payload, 14);
    }
    else {
        $masks = substr($payload, 2, 4);
        $data = substr($payload, 6);
    }

  for ($i = 0; $i < strlen($masks); ++$i) {
   // $this->say("header[".$i."] =". ord($masks[$i]). " \n");
  }
   //$this->say(" data:$data \n");
   
   //did we just get a PING frame
   if (strlen($masks)==4 && strlen($data)==0) 
   {
    return "ping";
    }
  
    $text = '';
    for ($i = 0; $i < strlen($data); ++$i) {
        $text .= $data[$i] ^ $masks[$i%4];
    }
    return $text;
}  //end of frame_decode unmask(Received from client)



  function send($client,$msg){ 

    $msg = $this->frame_encode($msg);
    socket_write($client, $msg);
   // $this->say("> ".$msg." (".strlen($msg). " bytes) \n");
  } 
    function sendJSON($client,$msg,$tipo){ 

    $msg=json_encode(['id'=>$client->id,'tipo'=>$tipo,'mensaje'=>$msg ]);
    $msg = $this->frame_encode($msg);
    socket_write($client->socket, $msg);
   // $this->say("> ".$msg." (".strlen($msg). " bytes) \n");
  } 

  function connect($socket){
    $user = new User();
    $user->id = uniqid();
    $user->socket = $socket;
    array_push($this->users,$user);
    array_push($this->sockets,$socket);
    $this->say($socket." id=".$user->id." CONECTADO!");

  }

  function disconnect($socket){
    $found=null;
    $n=count($this->users);
    for($i=0;$i<$n;$i++){
      if($this->users[$i]->socket==$socket){ $found=$i; break; }
    }
    if(!is_null($found))
    { 
       array_splice($this->users,$found,1); 
    }
    $index=array_search($socket,$this->sockets);
    $usuario=$this->getuserbysocket($socket);
    socket_close($socket);
    $this->say(" DISCONNECTED!  User count:".count( $this->users));
    if($index>=0)
    { 
       array_splice($this->sockets,$index,1); 
    }
  }

   function calcKey($key1,$ws_magic_string)
   {
    $this->log("\n Calculating sec-key: [".$key1."] \n MagicString:".$ws_magic_string."\n");
    return base64_encode(SHA1($key1.$ws_magic_string,true));
  }
   
  
  function dohandshake($user,$buffer){
    //$this->say("\nWS Requesting handshake...");
    list($resource,$host,$origin,$key1,$key2,$l8b) = $this->getheaders($buffer);
    $ws_magic_string="258EAFA5-E914-47DA-95CA-C5AB0DC85B11";
  //Calculate Accept = base64_encode( SHA1( key1 +attach magic_string ))
   $accept=$this->calcKey($key1,$ws_magic_string);
    
    /*
      Respond only when protocol specified in request header
      "Sec-WebSocket-Protocol: chat" . "\r\n" .
      */
  $upgrade = "HTTP/1.1 101 Switching Protocols\r\n".
                   "Upgrade: websocket\r\n".
                   "Connection: Upgrade\r\n".
            "WebSocket-Location: ws://" . $host . $resource . "\r\n" .
            "Sec-WebSocket-Accept: $accept".
                   "\r\n\r\n";
          
    socket_write($user->socket,$upgrade);
  //$this->say("Issuing websocket Upgrade \n");
    $user->handshake=true;
  
    $this->say("Listo handshaking... usuarios CONECTADOS:".count( $this->users));
    return  $user->handshake;
  }
  

  function getheaders($req){
      $r=$h=$o=null;
      if(preg_match("/GET (.*) HTTP/"               ,$req,$match)){ $r=$match[1]; }
      if(preg_match("/Host: (.*)\r\n/"              ,$req,$match)){ $h=$match[1]; }
      if(preg_match("/Origin: (.*)\r\n/"            ,$req,$match)){ $o=$match[1]; }
      if(preg_match("/Sec-WebSocket-Key: (.*)\r\n/",$req,$match)){ 
          // $this->say("WebSocket-Key: ".$sk1=$match[1]);
           $sk1=$match[1];
      }
      if(preg_match("/Sec-WebSocket-Version: (.*)\r\n/",$req,$match)){ 
        //$this->say("WebSocket-Version: ".$sk2=$match[1]);
        $sk2=$match[1];
         }
      if($match=substr($req,-8)) 
      { $this->log("Last 8 bytes: ".$l8b=$match); }
      return array($r,$h,$o,$sk1,$sk2,$l8b);
  }

  //Search for a particular user's socket
  function getuserbysocket($socket){
    $found=null;
    foreach($this->users as $user){
      if($user->socket==$socket)
      { 
        $found=$user; 
        break; 
      }
    }
    return $found;
  }
////////////CONSULTAS

  public function ResultadoEvento($idJuego){
   $conn = new mysqli(  $GLOBALS['servername'],  $GLOBALS['username'] ,   $GLOBALS['password'],   $GLOBALS['db']);
    if ($conn->connect_error) {
      die("Connection failed: " . $conn->connect_error);
    }
    $cantidad=12;
    $consulta=" select e.idEvento, re.valorGanador,tipoapuesta.rgb,tipoapuesta.rgbLetra 
                    from resultado_evento  as re
                    left join evento as e  on e.idEvento=re.idEvento
                    left join tipo_apuesta as tipoapuesta on tipoapuesta.idTipoApuesta=re.idTipoApuesta
                      where e.idJuego=".$idJuego." and re.estado=1 and tipoapuesta.idTipoPago in (1,6)
                       and e.estadoevento=2  
                      order by re.idEvento desc limit ".$cantidad;
    $result = $conn->query($consulta);
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $array_resultado[] = $row;
        }
    } else {
        echo "No hay Datos ";
    }
    $conn->close();
     if(isset($array_resultado)){
        $rpta=$array_resultado;
     }else{
      $rpta=null;
     }
      return $rpta;
  }
  public function Estadistica($idJuego){
   $conn = new mysqli(  $GLOBALS['servername'],  $GLOBALS['username'] ,   $GLOBALS['password'],   $GLOBALS['db']);
    if ($conn->connect_error) {
      die("Connection failed: " . $conn->connect_error);
    }
    $ultimoseventos_a_contar=120;
    $consulta=" select ta.idTipoApuesta,
                     ta.valorapuesta,
                    (
                     select    count(rev.valorGanador)
                              FROM resultado_evento rev
                              where rev.idTipoApuesta=ta.idTipoApuesta
                              and rev.idEvento in 
                              (
                                select eventos.idEvento from
                                    (
                                    select eventosub.idEvento from  evento as eventosub where eventosub.estadoEvento=2 
                                    and eventosub.idJuego=".$idJuego. " 
                                    order by eventosub.idEvento desc limit ".$ultimoseventos_a_contar."
                                    )
                                as eventos 
                              )
                     ) as Repetidos,
                     
                      ta.rgb, ta.rgbLetra 
                     from tipo_apuesta as ta
                      where ta.idTipoPago in (1,6) 
                      order by ta.valorapuesta desc";
                      
    $result = $conn->query($consulta);
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $array_resultado[] = $row;
        }
    } else {
        echo "No hay Datos ";
    }
    $conn->close();

      return $array_resultado;
  }
  public function GanadorEvento($idEvento){
      try{
          $conn = new mysqli(  $GLOBALS['servername'],  $GLOBALS['username'] ,   $GLOBALS['password'],   $GLOBALS['db']);
          if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
          }
          $sql_resultado="select valorGanador from resultado_evento as res where res.idEvento=".$idEvento." group by valorGanador";
          $result = $conn->query($sql_resultado);
          if ($result->num_rows > 0) {
              while($row = $result->fetch_assoc()) {
                  $resultados_evento[] = $row;
              }
          } else {
              echo "No hay Resultado de Evento ".$idEvento;
          }
          $conn->close();
      }catch(Exception $ex){
            echo $ex->getMessage();
      }
      if(isset($resultados_evento)){
          $resultados = $resultados_evento;
        }else{
           $resultados=null;
        }
      return $resultados;
  }
   public function getEventoActual($idJuego)
    {

        $IdJuego = $idJuego;
        try{
              $conn = new mysqli($GLOBALS['servername'],  $GLOBALS['username'] ,   $GLOBALS['password'],   $GLOBALS['db']);
              if ($conn->connect_error) {
                  die("Connection failed: " . $conn->connect_error);
              }
              $sql = "select * from evento as ev left join juego as j on j.idJuego = ev.idJuego    where j.idJuego=".$idJuego." and ev.EstadoEvento=1";
              ///////select evento  con idJuego y estadoevento=1
              $result = $conn->query($sql);
              if ($result->num_rows > 0) {
                  while($row = $result->fetch_assoc()) {
                      $evento_activo[] = $row;
                  }
                  $idEvento=$evento_activo[0]["idEvento"];
              } else {
                  echo "No hay eventos de Juego Tipo ".$idJuego." activos";
              }
              $conn->close();
        }catch(Exception $ex){
             echo $ex->getMessage();
             $evento_activo=null;
        }

        if(isset($evento_activo)){
          $evento_actual = $evento_activo[0];
        }
        else{
            $evento_actual=null;          
        }
        $resultado_evento=$this->ResultadoEvento($IdJuego);
        $estadistica= $this->Estadistica($IdJuego);
        if ($evento_actual != null) {
            $ganador=$this->GanadorEvento($idEvento);
            echo " - ";
            $ganador=$ganador[0];
            echo $ganador;
          // print_r($evento_actual);
           // print_r($ganador);
            $fecha_ini_actual = $evento_actual["fechaEvento"];
            $fecha_fin_actual = $evento_actual["fechaFinEvento"];
            $segundos_agregados = $evento_actual["segBloqueoAntesAnimacion"];
            $fecha_animacion = date("Y-m-d H:i:s a", strtotime('-'.$segundos_agregados.' seconds', strtotime($fecha_fin_actual)));
            //animacion=>fechafin-segBloqueoAntesAnimacion
     
           
            $array_evento = [
                'resultado_evento' => $resultado_evento,
                'estadistica' => $estadistica,
                'fecha_evento_ini_actual' => $fecha_ini_actual,
                'fecha_evento_fin_actual' => $fecha_fin_actual,
                'fecha_animacion' => $fecha_animacion,
                'evento_id_actual' => $evento_actual["idEvento"],
                'evento_valor_ganador' => $ganador["valorGanador"],
                'segBloqueoAntesAnimacion' => $segundos_agregados,
                'segCajaGirando' => $evento_actual["segCajaGirando"],
                'puntos_cuy'=> $evento_actual["puntosCuy"]// $this->generar_posiciones_random()
            ];
            return json_encode([
                'evento' => $array_evento, 'hora_servidor'=>date("Y-m-d H:i:s")
            ]);
        } else {
            $array_evento = [
                  'resultado_evento' => $resultado_evento,
                'estadistica' => $estadistica,
                'estado_animacion' => '',
                'fecha_evento_ini_actual' => '',
                'fecha_evento_fin_actual' => '',
                'fecha_animacion' => '',
                'evento_id_actual' => '',
                'evento_valor_ganador' => '',
                'segBloqueoAntesAnimacion' => '',
                'segCajaGirando' => ''

            ];
            return json_encode([
                'evento' => $array_evento, 'hora_servidor'=>date("Y-m-d H:i:s")
            ]);
        }
    }


   //utility functions
  function say($msg=""){ echo $msg."\n"; } //display server console messages
  function log($msg=""){ if($this->debug){ echo $msg."\n"; } }

}  //end class WebSocket

//User class holds basic user identifying information
class User{
  var $id;
  var $socket;
  var $handshake;
  
   function __construct()
   {    //do stuff to initialize each user  
   }
  
  public function __toString()
  {  return "(User: ". $this->id." )";  }
  
  
}  //end of class User

?>
