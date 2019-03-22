var socket;
var url = null;
var host= null;
var port=null;
var path=null;

function connectarWebSockets(ipservidor,puerto)
{
  host=ipservidor;
  port=puerto;
  console.log("Connecting to "+host+":"+port);
   init(host,port);
}

function init(host,port){

  host="ws://"+host+":"+port;
  url=host;
  console.log("CONECTANDO A "+host+" url:"+url);
      log('trying WebSocket - : '+url);
  try{
    socket = new WebSocket(host);
    log('WebSocket - status '+socket.readyState);
    socket.onopen    = function(msg){ log("Welcome - status "+this.readyState); };
    socket.onmessage = function(msg){ 
	       //console.log("Ws-data"+msg);

           var proxima_fecha=moment(eventoactual.fechaFinEvento, "YYYY-MM-DD HH:mm:ss a");
           var ahora=moment(msg.data, "YYYY-MM-DD HH:mm:ss a");
           var minutos=proxima_fecha.diff(ahora,'minutes');
           var segundos=proxima_fecha.diff(ahora.add(minutos,"minutes"),'seconds');
           log("Server>: "+msg.data + " Próximo en:" +minutos+":"+segundos);

           var horaserv=moment(msg.data, "YYYY-MM-DD HH:mm:ss a").format("hh:mm:ss a");
           $("#liveclock").text(horaserv);
            if(segundos< 0) { segundos=59; }
           if(segundos<10){segundos="0"+segundos;}
           $("#proximo_en").text(minutos+":"+segundos);

          if(parseInt(minutos)<0 ){
             $("#proximo_en").text("--");
          }
           // ///////segundos bloqueo
                      segantesdebloque=eventoactual.segBloqueoAntesEvento;
                      if(minutos==0 && segundos==segantesdebloque){
                         $.LoadingOverlay("show");
                      }
                      else{
                         segundostotales= parseInt((parseInt(minutos)*60))+parseInt(segundos);
                        if(segundostotales==segantesdebloque){
                            $.LoadingOverlay("show");
                        }

                      }
                      if(minutos==0 && segundos==1){
                        setTimeout(function(){
                          $.LoadingOverlay("hide");
                          location.reload(true)
                        },2000)
                      }
            //fin segundos bloqueo


	 };
    socket.onclose   = function(msg){ 
                                    log("Desconectado - status "+this.readyState+" ;Reintentando conectar en 2 segundos");
                                     };
                                     setTimeout(function(){
                                      connectarWebSockets(IPSERVIDOR_WEBSOCKETS,PUERTO_WEBSOCKETS)
                                     },2000)
  }
  catch(ex){ log(ex); }
  $("msg").focus();
}

function send(){
  var txt,msg;
  txt = $("msg");
  msg = txt.value;
  if(!msg){ alert("Message can not be empty"); return; }
  txt.value="";
  txt.focus();
  try
    {
 	socket.send(msg); 
	log('>>: '+msg); } 
	catch(ex)
	{ log(ex); 	}
}

function pedir_hora_server(){
  msg = "date";
  try
  {
      socket.send(msg); 
      //log('>>: '+msg);
  } 
  catch(ex)
  { 
    log(ex);  
  }
}

function quit(){
  log("Goodbye! "+url);
  socket.close();
  socket=null;
}

// Utilities
  
function log(msg){ 
  //$("log").innerHTML+="<br>"+msg; 
  console.info(msg);
  }
  
//function onkey(event){ if(event.keyCode==13){ send(); } }