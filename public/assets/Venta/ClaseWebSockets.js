var socket;
var url = null;
var host= null;
var port=null;
var path=null;

RECONECTAR_WEBSOCKET=true;

// var fiveMinutes = 60 * 5,
//     display = $('#time');
// startTimer(fiveMinutes, display);


 // timeMiliSecond = new Date(serverTime).getTime();
 // callRepeatedly() {
 //    setTimeout(() => {
 //         timeMiliSecond = timeMiliSecond+1000;         
 //         serverTime=moment(newDate(timeMiliSecond)).format('MM-DD-YYYY HH:mm:ss');
 //         this.callRepeatedly();
 //      }, 1000)  
 //  }

function hora(){
  setInterval(function(){
         // time=ServerDate();
        $("#liveclock").text(ServerDate().getHours()+":"+ServerDate().getMinutes()+":"+ServerDate().getSeconds())
  },1000)
}

function connectarWebSockets(ipservidor,puerto)
{
  host=ipservidor;
  port=puerto;
   init(host,port);
}

function init(host,port){

  host="ws://"+host+":"+port;
  url=host;
  console.info("CONECTANDO A "+host);
  try{
    socket = new WebSocket(host);
    //log('WebSocket - status '+socket.readyState);
    socket.onopen    = function(msg){
                logwarn("Conectado a "+url +" ; estado= "+this.readyState);
                setTimeout(function(){
                    pedir_hora_server();
                },50)
                // if(typeof intervalohora!="undefined"){
                //  clearInterval(intervalohora);
                // }
                // intervalohora=setInterval(function(){
                //        pedir_hora_server();     
                //    },1000);
     };
    socket.onmessage = function(msg){ 
      aaaaa=msg;
           mensaje=msg.data;
          if(mensaje=="ACTUALIZAR"){
          }
          else{
             reloj_websockets(msg.data,eventoactual.fechaFinEvento,eventoactual.segBloqueoAntesEvento);
          }

          //  var proxima_fecha=moment(eventoactual.fechaFinEvento, "YYYY-MM-DD HH:mm:ss a");
          //  var ahora=moment(msg.data, "YYYY-MM-DD HH:mm:ss a");
          //  var minutos=proxima_fecha.diff(ahora,'minutes');
          //  var segundos=proxima_fecha.diff(ahora.add(minutos,"minutes"),'seconds');
          //  log("Servidor>: "+msg.data + " Próximo en:" +minutos+":"+segundos);

          //  var horaserv=moment(msg.data, "YYYY-MM-DD HH:mm:ss a").format("hh:mm:ss a");
          //  $("#liveclock").text(horaserv);
          //   if(segundos< 0) { segundos=59; }
          //  if(segundos<10){segundos="0"+segundos;}
          //  $("#proximo_en").text(minutos+":"+segundos);

          // if(parseInt(minutos)<0 ){
          //    $("#proximo_en").text("--");
          // }
          //  // ///////segundos bloqueo
          //             segantesdebloque=eventoactual.segBloqueoAntesEvento;
          //             if(minutos==0 && segundos==segantesdebloque){
          //                $.LoadingOverlay("show",{image:basePath+"img/loading/load.gif"})
          //             }
          //             else{
          //                segundostotales= parseInt((parseInt(minutos)*60))+parseInt(segundos);
          //               if(segundostotales==segantesdebloque){
          //                  $.LoadingOverlay("show",{image:basePath+"img/loading/load.gif"})

          //               }

          //             }
          //             if(minutos==0 && segundos==1){
          //               setTimeout(function(){
          //                 $.LoadingOverlay("hide");
          //                 location.reload(true)
          //               },2000)
          //             }
            //fin segundos bloqueo


	 };
  socket.onerror=function(msg){
        logwarn("error sockets");
   };
  socket.onclose   = function(msg){ 
       if(typeof intervalohora!="undefined"){
            clearInterval(intervalohora);
        }
        if(RECONECTAR_WEBSOCKET){
          logwarn("Desconectado - status "+this.readyState+" ;Reintentando conectar en 2 segundos");
          setTimeout(function(){
            connectarWebSockets(IPSERVIDOR_WEBSOCKETS,PUERTO_WEBSOCKETS)
          },400);
        }

                         
     };
                 
  }
  catch(ex){ 
    logerror(ex); 
  }
}


function pedir_hora_server(){
  msg = "date";
  try
  {
      socket.send(msg); 
  } 
  catch(ex)
  { 
    logerror(ex);  
  }
}

function quit(){
  log("Goodbye! "+url);
  socket.close();
  socket=null;
}

// Utilities
function log(msg){ 
  console.info(msg);
}
function logwarn(msg){ 
  console.warn(msg);
}
function logerror(msg){ 
   console.error(msg);
}
  
//function onkey(event){ if(event.keyCode==13){ send(); } }