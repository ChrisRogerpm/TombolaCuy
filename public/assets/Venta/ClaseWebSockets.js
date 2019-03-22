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
  console.log("Connecting to "+host+" url:"+url);
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

	 };
    socket.onclose   = function(msg){ log("Disconnected - status "+this.readyState); };
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