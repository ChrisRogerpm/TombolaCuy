var socket;
var url = null;
var host= null;
var port=null;
var path=null;

var logueo_websockets=false;
RECONECTAR_WEBSOCKET=true;
function hora(){
  setInterval(function(){
         // time=ServerDate();
        $("#liveclock").text(ServerDate().getHours()+":"+ServerDate().getMinutes()+":"+ServerDate().getSeconds())
  },1000)
}


function crear_toasr_websockets_error(){
if(typeof toasr_websockets_error=="undefined"){
        toastr.options = {
          timeOut: 0,
          extendedTimeOut: 0,
          tapToDismiss: false
        };
         toastr_errorconexion=toastr.error("Error de Conexión al Servidor");
      }else{toasr_websockets_error.show();}

}


function crear_toastr_eventofinalizo(){
  if(typeof toastr_eventofinalizo=="undefined"){
                                toastr.options = {
                                  timeOut: 0,
                                  extendedTimeOut: 0,
                                  tapToDismiss: false
                                };
                                toastr_eventofinalizo=toastr.error("Evento actual ya finalizó");
                            }
            else{toastr_eventofinalizo.show()}
}
function ocultar_toastr_eventofinalizo(){
    if(typeof toastr_eventofinalizo!="undefined"){
                    toastr_eventofinalizo.hide();
                }
}


function connectarWebSockets(ipservidor,puerto)
{
  console.log("tiempo = "+performance.now());
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
             
                detener_timeout_conexionwebsockets()                
                if(typeof toasr_websockets_error!="undefined"){
                        toasr_websockets_error.hide();
                    }

                logwarn("Conectado a "+url +" ; estado= "+this.readyState); /////3  => desconectado    0  no conectado,   1  conectado
               // setTimeout(function(){
                  //pedir_evento()
                  console.info("pidiendo horaaaaaaaaaaaaaaaaaaaaaaaa despues de onopen");
                  intentando_conectarwebsocket=false;
                  CONECTADO__A_SERVIDORWEBSOCKET=true;
                     pedir_hora_server();
      //          },1)
     };
    socket.onmessage = function(msg){ 
      aaaaa=msg;
      console.log("aaaaaa ---------------------------------------------------------");
      try{
      jsondecode=JSON.parse(msg.data);
      id=jsondecode.id;
      mensaje=jsondecode.mensaje;
      tipo=jsondecode.tipo;
      console.log("ID SOCKET  =========="+ id);
        
      }
      catch(ex){
        mensaje=msg.data;
        tipo="date";

      }
          // mensaje=msg.data;

      if(typeof toastr_errorconexion!="undefined"){
                            toastr_errorconexion.hide();  
        }
           if(typeof toasr_websockets_error!="undefined"){
            toasr_websockets_error  .hide();  
        }

           switch(tipo){
               case "date":
                        pedir_hora=false;
                        // ahora=moment(msg.data);//.format("YYYY-MM-DD HH:mm:ss a");
                        ahora=moment(mensaje);//.format("YYYY-MM-DD HH:mm:ss a");
                        FECHA_INICIO_EVENTO=EVENTO_ACTUAL.fecha_evento_ini_actual;
                        FECHA_INICIO_EVENTO=moment(FECHA_INICIO_EVENTO, "YYYY-MM-DD HH:mm:ss a");

                        FECHA_FIN_EVENTO=EVENTO_ACTUAL.fecha_evento_fin_actual;
                        FECHA_FIN_EVENTO=moment(FECHA_FIN_EVENTO, "YYYY-MM-DD HH:mm:ss a");

                        segundos_para_fin_evento=FECHA_FIN_EVENTO.diff(ahora,'seconds');

                        FECHA_ANIMACION=EVENTO_ACTUAL.fecha_animacion;
                        FECHA_ANIMACION=moment(FECHA_ANIMACION, "YYYY-MM-DD HH:mm:ss a");


                        // console.info("F.ACTUAL   =  "+ ahora.format("YYYY-MM-DD HH:mm:ss a")+" -  F.ANIMACIÓN  = "+moment(FECHA_ANIMACION).format("YYYY-MM-DD HH:mm:ss a"));
                        segundos_para_animacion=FECHA_ANIMACION.diff(ahora,'seconds');
                        if(logueo_websockets){
                            console.info("INI=  "+FECHA_INICIO_EVENTO.format("YYYY-MM-DD HH:mm:ss a") + " -  FIN= "+FECHA_FIN_EVENTO.format("YYYY-MM-DD HH:mm:ss a")
                                    +"ACTUAL=  "+ ahora.format("YYYY-MM-DD HH:mm:ss a")+" - ANIMACIÓN= "+moment(FECHA_ANIMACION).format("YYYY-MM-DD HH:mm:ss a")
                                    +"--SEG. PARA ANIMACIÓN= "+segundos_para_animacion

                          );
                        }
                        // console.warn("SEG. PARA ANIMACIÓN= "+segundos_para_animacion);
                        seg_animacion=segundos_para_animacion*1000;

                        // segundos_para_animacion=1;///
                       if(segundos_para_animacion>0){ ///EN rango animacion
                            setTimeout(function(){
                                ///barra carga cuy
                                  $("#barra_loading_tpi").animate(
                                     {width:"100%"}
                                    ,(segundos_para_animacion)*1000
                                    ,function(){
                                              $("#idevento_titulo").text(EVENTO_ID);
                                              $("#termotetro_para_iniciar").hide();
                                              buscando_evento=false;
                                              INICIO_ANIMACION_CUY();////////////////////////////////////////
                                    }
                                   ); 
                                ///fin barra cuy
                                  ///contador inicio cuy
                                  $("#contador_para_activar").text(segundos_para_animacion);
                                  var conta=segundos_para_animacion-1;
                                  conteo_=setInterval(function(){
                                      $("#contador_para_activar").text(conta);
                                      if(conta<1){clearInterval(conteo_);}
                                      conta=parseInt(conta)-1;
                                  },1000);
                                  ////fin contador inicio cuy

                            },1000);
                       }else{
                          toastr.options = {
                          timeOut: 0,
                          extendedTimeOut: 0,
                          tapToDismiss: false
                          };
                        if(logueo_websockets){
                          console.log("esperando fecha fin evento "+EVENTO_ID+" actual,para recargar " +FECHA_FIN_EVENTO.format("YYYY-MM-DD HH:mm:ss a")) ;
                        }
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
                                 $("#contador_para_activar").text(segundos_para_fin_evento);
                                     var conta=(segundos_para_fin_evento)-1;
                                  conteo_=setInterval(function(){
                                    $("#contador_para_activar").text(conta);
                                    if(conta<1){clearInterval(conteo_);}
                                    conta=parseInt(conta)-1;
                                  },1000);


                              }else{
                                  
                                  if(!CONSULTADO_EVENTO){
                                        // toastr_eventofinalizo=toastr.error("Evento actual ya finalizó");
                                        crear_toastr_eventofinalizo();
                                        if(typeof timeout_consultar_evento!="undefined"){
                                            clearTimeout(timeout_consultar_evento);
                                        }
                                        timeout_consultar_evento=setTimeout(function(){
                                                  ocultar_toastr_eventofinalizo()
                                                  detener_timeout_conexionwebsockets();
                                                      console.log(segundos_para_fin_evento+ " CargarEstadistica ev ac ya finlai");
                                                      CargarEstadistica(1);
                                                  
                                        },4000);
                                  }
                                 //  iii=0;
                                 //  intervalo_fin_evento=setInterval(function(){
                                 //      if(iii>segundos_para_fin_evento){
                                 //          toastr_eventofinalizo.hide();
                                 //          detener_timeout_conexionwebsockets();
                                 //          console.log(segundos_para_fin_evento+ " CargarEstadistica ev ac ya finlai");
                                 //          if(!CONSULTADO_EVENTO){
                                 //              CargarEstadistica(1);
                                 //          }
                                 //          clearInterval(intervalo_fin_evento);
                                 //      }
                                 //      iii++;
                                 // },1000);

                              }

                          }//fin else

                      break;
                      // case "dateJSON":
                      //   console.info(jsondecode);
                      //   EVENTO_DATOS=JSON.parse(jsondecode.mensaje);
                      //   // EVENTO_=EVENTO_DATOS.evento;
                      //   accion_evento(EVENTO_DATOS);/////////////////////////////////////////******//////////////////
                      // break;
                      case "evento":
                        console.info(jsondecode);
                        EVENTO_DATOS=JSON.parse(jsondecode.mensaje);
                        // EVENTO_=EVENTO_DATOS.evento;
                        accion_evento(EVENTO_DATOS);/////////////////////////////////////////******//////////////////
                      break;
             //reloj_websockets(msg.data,eventoactual.fechaFinEvento,eventoactual.segBloqueoAntesEvento);
          }

        
        

	 };
  socket.onerror=function(msg){
     intentando_conectarwebsocket=false; 
  socket=null;

        CONECTADO__A_SERVIDORWEBSOCKET=false;
        // logwarn("on error sockets");
   };
  socket.onclose   = function(msg){
    socket=null;
     setTimeout(function(){

      intentando_conectarwebsocket=false; 
           CONECTADO__A_SERVIDORWEBSOCKET=false;
        
            if(RECONECTAR_WEBSOCKET){
              crear_toasr_websockets_error();
              logwarn("Desconectado - status "+this.readyState+" ;Reintentando conectar en 2 segundos");
              // setTimeout(function(){
                        //if(socket!=null && socket.readyState==3 && !intentando_conectarwebsocket){////SOCKET no conectado
                          console.log("reconectar socket ");//+socket.readyState);
                          intentando_conectarwebsocket=true;
                          socket=null;
                          connectarWebSockets(IPSERVIDOR_WEBSOCKETS,PUERTO_WEBSOCKETS);
                          timeout_conexionwebsockets();
                        //}
              // },1000);
            }

      },5000);
                             
     };///fin on close
  } //fin try
  catch(ex){ 
    CONECTADO__A_SERVIDORWEBSOCKET=false;
    console.warn("try catch error")
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

function pedir_eventoJSON(){
    msg = "eventoJSON";
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




function accion_evento(DATOS){

EVENTO_ACTUAL=DATOS.evento;
hora_servidor=DATOS.hora_servidor;
                if(EVENTO_ACTUAL.evento_id_actual!=""){
                    EVENTO_ACTUAL=EVENTO_ACTUAL;
                    EVENTO_ID= EVENTO_ACTUAL.evento_id_actual;
                    GANADOR_DE_EVENTO =EVENTO_ACTUAL.evento_valor_ganador;
                    TIEMPO_GIRO_CAJA=(EVENTO_ACTUAL.segCajaGirando)*1000;
                   TIEMPO_CUY = (EVENTO_ACTUAL.segBloqueoAntesAnimacion*1000)-TIEMPO_GIRO_CAJA;//EVENTO_ACTUAL.tiempo_cuy_moviendo;

                    PUNTOS_CUY=JSON.parse(EVENTO_ACTUAL.puntos_cuy);
                    $("#termotetro_para_iniciar").show();
accion_cuy(DATOS);
 
                }
                else{

                    crear_toasr_nohay_evento();
               
                  console.warn("No hay evento activo");
                  setTimeout(function(){
                    CargarEstadistica(1);
                  },1000)
                }


}


 function accion_cuy(DATOS){

  EVENTO_ACTUAL=DATOS.evento;
hora_servidor=DATOS.hora_servidor;
                        pedir_hora=false;
                        // ahora=moment(msg.data);//.format("YYYY-MM-DD HH:mm:ss a");
                        ahora=moment(hora_servidor);//.format("YYYY-MM-DD HH:mm:ss a");
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
                        // segundos_para_animacion=1;///
                       if(segundos_para_animacion>0){ ///EN rango animacion
                            setTimeout(function(){
                                ///barra carga cuy
                                  $("#barra_loading_tpi").animate(
                                     {width:"100%"}
                                    ,(segundos_para_animacion)*1000
                                    ,function(){
                                              $("#idevento_titulo").text(EVENTO_ID);
                                              $("#termotetro_para_iniciar").hide();
                                              buscando_evento=false;
                                              INICIO_ANIMACION_CUY();////////////////////////////////////////
                                    }
                                   ); 
                                ///fin barra cuy
                                  ///contador inicio cuy
                                  $("#contador_para_activar").text(segundos_para_animacion);
                                  var conta=segundos_para_animacion-1;
                                  conteo_=setInterval(function(){
                                      $("#contador_para_activar").text(conta);
                                      if(conta<1){clearInterval(conteo_);}
                                      conta=parseInt(conta)-1;
                                  },1000);
                                  ////fin contador inicio cuy
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
                                 $("#contador_para_activar").text(segundos_para_fin_evento);
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

                          }//fin else


}///fin accion cuy


