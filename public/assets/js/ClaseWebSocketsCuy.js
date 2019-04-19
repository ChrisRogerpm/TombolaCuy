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
                        segundos_finevento=FECHA_FIN_EVENTO.diff(ahora,'seconds');

                        FECHA_ANIMACION=EVENTO_ACTUAL.fecha_animacion;
                        FECHA_ANIMACION=moment(FECHA_ANIMACION, "YYYY-MM-DD HH:mm:ss a");
                        console.info("ACTIVAR  =  "+moment(FECHA_ANIMACION).format("YYYY-MM-DD HH:mm:ss a"));
                        console.info("ACTUAL   =  "+ moment(ahora).format("YYYY-MM-DD HH:mm:ss a"));
                        segundos_total=FECHA_ANIMACION.diff(ahora,'seconds');
                        console.info(segundos_total);
                      
                       if(segundos_total>0){ ///EN rango animacion
                             // con_segundos=0;
                             //   //$("#barra_loading_tpi").css("width","14%");
                             //   intervalo_loading_inicio=setInterval(function(){
                             //        porcentaje=(con_segundos*100)/segundos_total;
                             //     //   $("#barra_loading_tpi").css("width",(porcentaje)+"%");
                             //        if(porcentaje==100){
                             //            clearInterval(intervalo_loading_inicio);
                             //            $("#idevento_titulo").text(EVENTO_ID);
                             //           // $("#barra_loading").css("height","100%");
                             //            $("#termotetro_para_iniciar").hide();
                             //            buscando_evento=false;
                             //            GANADOR_DE_EVENTO = EVENTO_ACTUAL.evento_valor_ganador;
                             //            TIEMPO_GIRO_CAJA=4500;
                             //            TIEMPO_CUY = 20000;
                             //            INICIO_ANIMACION_CUY();////////////////////////////////////////
                             //        }
                             //        con_segundos=con_segundos+1;
                             //   },1000);
                            setTimeout(function(){
                                  $("#barra_loading_tpi").animate(
                                     {width:"100%"}
                                    ,(segundos_total)*1000
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
                            },1000);


                        // segundos_inicioevento_animacion=FECHA_ANIMACION.diff(FECHA_INICIO_EVENTO,'seconds');

                        // segundo_actual=segundos_total;
                        // inicio_porcentaje=segundo_actual/segundos_inicioevento_animacion;
                        // setInterval(function(){
                        // },300)


                       }else{
                        console.log("esperando fecha fin evento actual,para recargar " +FECHA_FIN_EVENTO);
                            iii=0;
                            intervalo_fin_evento=setInterval(function(){
                                if(iii>segundos_finevento){
                                    CargarEstadistica(1);
                                    clearInterval(intervalo_fin_evento);
                                }
                                iii++;
                           },1000);
                       
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
