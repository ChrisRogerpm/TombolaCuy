var socket;
var url = null;
var host= null;
var port=null;
var path=null;

RECONECTAR_WEBSOCKET=true;
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
            if(typeof toastr_errorconexion!="undefined"){
                toastr_errorconexion.hide();  
            }
                logwarn("Conectado a "+url +" ; estado= "+this.readyState);
                setTimeout(function(){
                    pedir_hora_server();
                },50)
     };
    socket.onmessage = function(msg){ 
      aaaaa=msg;
           mensaje=msg.data;
          if(mensaje=="ACTUALIZAR"){
          }
          else{
                        ahora=moment(msg.data);//.format("YYYY-MM-DD HH:mm:ss a");
                        FECHA_INICIO_EVENTO=EVENTO_ACTUAL.fecha_evento_ini_actual;
                        FECHA_INICIO_EVENTO=moment(FECHA_INICIO_EVENTO, "YYYY-MM-DD HH:mm:ss a");

                        FECHA_FIN_EVENTO=EVENTO_ACTUAL.fecha_evento_fin_actual;
                        FECHA_FIN_EVENTO=moment(FECHA_FIN_EVENTO, "YYYY-MM-DD HH:mm:ss a");
                        segundos_para_fin_evento=FECHA_FIN_EVENTO.diff(ahora,'seconds');

                        FECHA_ANIMACION=EVENTO_ACTUAL.fecha_animacion;
                        FECHA_ANIMACION=moment(FECHA_ANIMACION, "YYYY-MM-DD HH:mm:ss a");
                        console.info("F.ANIMACIÓN  =  "+moment(FECHA_ANIMACION).format("YYYY-MM-DD HH:mm:ss a"));
                        console.info("F.FIN EVENTO  =  "+moment(FECHA_FIN_EVENTO).format("YYYY-MM-DD HH:mm:ss a"));
                        console.info("F.ACTUAL   =  "+ moment(ahora).format("YYYY-MM-DD HH:mm:ss a"));
                        segundos_para_animacion=FECHA_ANIMACION.diff(ahora,'seconds');
                        console.info(segundos_para_animacion);
                        seg_animacion=segundos_para_animacion*1000;
                       if(segundos_para_animacion>0){ ///EN rango animacion
                            setTimeout(function(){
                                  $("#barra_loading_tpi").animate(
                                     {width:"100%"}
                                    ,(segundos_para_animacion)*1000
                                    ,function(){
                                              $("#idevento_titulo").text(EVENTO_ID);
                                                $("#termotetro_para_iniciar").hide();
                                                buscando_evento=false;
                                                GANADOR_DE_EVENTO = EVENTO_ACTUAL.evento_valor_ganador;
                                                //TIEMPO_GIRO_CAJA=TIEMPO_GIRO_CAJA;
                                                //TIEMPO_CUY = 20000;
                                                  INICIO_ANIMACION_CUY();////////////////////////////////////////
                                    }
                                  );

                                  var conta=segundos_para_animacion-1;
                                  conteo_=setInterval(function(){
                                    $("#contador_para_activar").text(conta);
                                    if(conta<1){clearInterval(conteo_);}
                                    conta=parseInt(conta)-1;
                                  },1000);

                            },1000);
                       }else{
                        toastr.options = {
                        timeOut: 0,
                        extendedTimeOut: 0,
                        tapToDismiss: false
                    };
                        console.log("esperando fecha fin evento actual,para recargar " +FECHA_FIN_EVENTO.format("YYYY-MM-DD HH:mm:ss a")) ;
                              if(segundos_para_fin_evento>0){

                                toast_eventoterminar=toastr.error("Esperando que termine evento actual");
                                 $("#barra_loading_tpi").animate(
                                     {width:"100%"}
                                    ,(segundos_para_fin_evento)*1000
                                    ,function(){
                                      $("#barra_loading_tpi").css("width","0%");
                                          toast_eventoterminar.hide();
                                          CargarEstadistica(1);
                                    }
                                  );
                                     var conta=(segundos_para_fin_evento)-1;
                                  conteo_=setInterval(function(){
                                    $("#contador_para_activar").text(conta);
                                    if(conta<1){clearInterval(conteo_);}
                                    conta=parseInt(conta)-1;
                                  },1000);


                              }else{
                                toastr_eventofinalizo=toastr.error("Evento actual ya finalizó")
                                  iii=0;
                                  intervalo_fin_evento=setInterval(function(){
                                      if(iii>segundos_para_fin_evento){
                                          toastr_eventofinalizo.hide();
                                          CargarEstadistica(1);
                                          clearInterval(intervalo_fin_evento);
                                      }
                                      iii++;
                                 },1000);

                              }

                           // iii=0;
                           //  intervalo_fin_evento=setInterval(function(){
                           //      if(iii>segundos_para_fin_evento){
                           //          CargarEstadistica(1);
                           //          clearInterval(intervalo_fin_evento);
                           //      }
                           //      iii++;
                           // },1000);
                       
                    }
             //reloj_websockets(msg.data,eventoactual.fechaFinEvento,eventoactual.segBloqueoAntesEvento);
          }

	 };
  socket.onerror=function(msg){
        logwarn("error sockets");
   };
  socket.onclose   = function(msg){ 
       if(typeof intervalohora!="undefined"){
            clearInterval(intervalohora);
        }
        if(RECONECTAR_WEBSOCKET){
          if(typeof toastr_errorconexion!="undefined"){
            toastr_errorconexion=toastr.error("Error de Conexión al Servidor");
          }
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
