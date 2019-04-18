////BUSCARTICKET   E  IMPRIMIR PAGO
function BuscarTicket(ticketobjeto){
    $.ajax({
        type: 'POST',
        //async:false,
        url: basePath + 'BuscarTicketFk',
         data: {
            '_token': $('input[name=_token]').val(),
            'datos':ticketobjeto
        },
        success: function (response) {
            $("#btn_buscar_ticket").LoadingOverlay("hide");
                $("#btn_buscar_ticket").attr("disabled",false);


                $("#modal_imprimir_pago #imagen_apuestatotal").attr("src",basePath+"img/logo.png")

            ticketbuscado=response.ticketbuscado;
            ticketsganadores=response.tickets;
            resultados_evento=response.resultados_evento;
            apuestasticket=response.apuestas_ticket;
            
             ganadores="";
             if(apuestasticket.length==0){
                toastr.error("Ticket "+ ticketbuscado +" no está registrado");return;
             }
             if(ticketsganadores.length>0){

                if(ticketsganadores[0].estadoTicket==0){toastr.error("Ticket"+ ticketbuscado+ " Anulado");return false;}
                if(ticketsganadores[0].estadoTicket==2){toastr.error("Ticket "+ ticketbuscado+" Pagado");return false;}
                if(ticketsganadores[0].estadoTicket==3){toastr.error("Ticket "+ ticketbuscado+" Suspendido");return false;}

                GuardarGanadorEvento(ticketsganadores,ticketsganadores[0].idTicket);

                TICKET_IMPRIMIR_pago={};
                TICKET_IMPRIMIR_pago.ImagenSrc=eventoactual.Imagen
                TICKET_IMPRIMIR_pago.Id_Ticket=ticketsganadores[0].idTicket;
                TICKET_IMPRIMIR_pago.Id_Unidad=CC_ID //eventoactual.IdEvento;
                TICKET_IMPRIMIR_pago.Nro_Evento=ticketsganadores[0].idEvento;
                TICKET_IMPRIMIR_pago.Desc=ticketsganadores[0].EventoNombre;
                totales=sacar_totales_y_maximo();
                TICKET_IMPRIMIR_pago.ImpresoEn=moment(new Date()).format("DD-MM-YYYY HH:mm a");//new Date().toLocaleString();
                TICKET_IMPRIMIR_pago.ImpresoPor=USUARIO;
                // TICKET_IMPRIMIR_pago.PremioMaximoAPagar=parseFloat(totales.maximo).toFixed(2)+" "+divisa;
                TICKET_IMPRIMIR_pago.PremioMaximoAPagar=ticketsganadores[0].apuestaMaxima ;
                TICKET_IMPRIMIR_pago.CantidadGanada=0;
                apuestas=[];
                totalticket=0;
                $(ticketsganadores).each(function(i,e){
                        fila_apuesta={};
                        var tr=e;
                            fila_apuesta.evento=e.idEvento;//evento;
                            fila_apuesta.descripcion=e.TipoApuestaNombre;
                            var apuestafila=(parseFloat(e.multiplicadorApuestaGanada)*parseFloat(e.montoApostado));
                            fila_apuesta.apuesta=apuestafila.toFixed(2);
                            totalticket=totalticket+apuestafila;
                            apuestas.push(fila_apuesta);
                })
                TICKET_IMPRIMIR_pago.TotalTicket=parseFloat(totalticket).toFixed(2);
                TICKET_IMPRIMIR_pago.apuestas=apuestas;

                $("#modal_imprimir_pago #divimpresion_pago #IDTique").text(TICKET_IMPRIMIR_pago.Id_Ticket)
                $("#modal_imprimir_pago #divimpresion_pago #IDUnidad").text(TICKET_IMPRIMIR_pago.Id_Unidad)
                $("#modal_imprimir_pago #divimpresion_pago #NroEvento").text(TICKET_IMPRIMIR_pago.Nro_Evento)
                $("#modal_imprimir_pago #divimpresion_pago #descripcion").text(TICKET_IMPRIMIR_pago.Desc)
                $("#modal_imprimir_pago #divimpresion_pago #datos_filas").empty();
                $(TICKET_IMPRIMIR_pago.apuestas).each(function(i,e){
                    $("#modal_imprimir_pago #divimpresion_pago #datos_filas").append($("<div>").attr("style","width:100%;display:table")
                            .append(
                            $("<div>").attr("style","width:38%;float:LEFT;text-align:left").text(e.evento)
                                )
                            .append(
                            $("<div>").attr("style","width:47%;float:LEFT;text-align:left").text(e.descripcion)
                                )
                              .append(
                            $("<div>").attr("style","width:15%;float:LEFT;text-align:left").text(e.apuesta)
                                )
                    )
                })
                $("#modal_imprimir_pago #divimpresion_pago #total_ticket").text(TICKET_IMPRIMIR_pago.TotalTicket+ " "+divisa)
                $("#modal_imprimir_pago #divimpresion_pago #impreso_en").text(moment(new Date()).format("YYYY-MM-DD HH:mm:ss"));
                $("#modal_imprimir_pago #divimpresion_pago #impreso_por").text(TICKET_IMPRIMIR_pago.ImpresoPor)
                $("#modal_imprimir_pago #divimpresion_pago #PremioMaximoAPagar").text(parseFloat(TICKET_IMPRIMIR_pago.PremioMaximoAPagar).toFixed(2)+" "+divisa)
                $("#modal_imprimir_pago #divimpresion_pago .imagen img").attr("src",TICKET_IMPRIMIR_pago.ImagenSrc)

                $("#modal_imprimir_pago #btnimprimir").off("click").on("click",function(){
                     Imprimir("divimpresion_pago");
                })
                setTimeout(function(){
                    $("#modal_imprimir_pago #btnimprimir").click()
                },1000)

                $("#modal_imprimir_pago").modal("show");

                // $(ticketsganadores).each(function(i,e){
                //      ganadores=ganadores+"<br> "+e.TipoPagoNombre+" "+e.TipoApuestaValor;
                // })
                // toastr.success(" Ticket "+ticketbuscado +" Evento "+ticketobjeto.nombre+" <br>Apuestas Ganadoras:" +ganadores);
                 toastr.success(" Ticket "+ticketbuscado +" Evento "+ticketobjeto.nombre);
             }
             else{
                toastr.error("Ticket "+ticketbuscado+ " Evento "+ticketobjeto.nombre+"<br>No hay Apuestas Ganadoras");
             }

           
        },
    })

}

function GuardarGanadorEvento(apuestas_ganadoras,idTicket){/////GuardarGanadorEvento EN tabla Ganador_Evento
 $.ajax({
        type: 'POST',
        async:false,
        url: basePath + 'GuardarGanadorEventoFk',
         data: {
            '_token': $('input[name=_token]').val(),
            'apuestas':apuestas_ganadoras,
            'idTicket':idTicket,
            'idAperturaCaja':$("#idAperturaCaja").val()
        },
        success: function (response) {
            if(response.respuesta){
                toastr.success("Ticket Pagado");
            }
        },
    })

}

function GuardarTicket(ticketobjeto_imprimir){/////GUARDATICKET EN TICKET Y APUESTAS , ABRE MODAL
    TicketObjeto={};
    TicketObjeto.idAperturaCaja=IDAPERTURACAJA;
    TicketObjeto.idEvento=eventoactual.IdEvento;
    TicketObjeto.codigoQR=eventoactual.IdEvento;
    TicketObjeto.nroTicketParticipante=eventoactual.IdEvento
    TicketObjeto.ganador=0;
    TicketObjeto.estadoTicket=1;

    Apuestas=[];
    $(ticketobjeto_imprimir.apuestas).each(function(i,e){
        ApuestaObjeto={}
        ApuestaObjeto.idTicket=null;
        ApuestaObjeto.idTipoApuesta=e.idtipoapuesta;
        ApuestaObjeto.idTipoPago=e.idtipopago;
        ApuestaObjeto.idMoneda=eventoactual.idMoneda;
        ApuestaObjeto.montoApostado=e.apuesta;
        ApuestaObjeto.montoAPagar=0;
        ApuestaObjeto.ganador=0;
        Apuestas.push(ApuestaObjeto);
    })

    datosobjeto={};
    datosobjeto.TicketObjeto=TicketObjeto;
    datosobjeto.Apuestas=Apuestas;
    var totales_maximo=sacar_totales_y_maximo();
    TicketObjeto.montoTotal=totales_maximo.total;

    $.ajax({
        type: 'POST',
       // async:false,
        url: basePath + 'GuardarTicketFk',
         data: {
            '_token': $('input[name=_token]').val(),
            'datos':datosobjeto
        },
        beforeSend:function(){
            modalguardarticket=toastr.info("...Guardando Ticket")
        },
        success: function (response) {
            ticketdata=response.id_ticketinsertado;
            idticket=ticketdata.idTicket;
                ImprimirJson(ticketobjeto_imprimir,idticket);

            $("#divimpresion #IDTique").text(idticket);
            $("#modal_imprimir").modal("show");
            // TICKET_IMPRIMIR={}
            toastr.success("Ticket Guardado");
            JugadoresJson(eventoactual.IdEvento);///actualizar JUGADOR 

            $("#div_botones .cerrar").click();
        },
    })
}

/////IMPRIMIR DEL NAVEGADOR
function Imprimir(elem)
{
    //////CONFIGURAR NAVEGADOR   MARGENES =>  NINGUNO
    console.log("Imprimiendi")
    var mywindow = window.open('', 'PRINT', 'height=800,width=700');
     // mywindow.document.write('<html><head><title>' + document.title  + '</title>');
    mywindow.document.write('<html><head>');
    mywindow.document.write('</head><body>');
    //mywindow.document.write('<h1>' + document.title  + '</h1>');
    mywindow.document.write(document.getElementById(elem).innerHTML);
    mywindow.document.write('</body></html>');
    mywindow.document.close(); // necessary for IE >= 10
    mywindow.focus(); // necessary for IE >= 10*/
    mywindow.print();
    console.log("fin impresion");
     // setTimeout(function () { window.close();alert("termino imprimir") }, 100);
    mywindow.close();
    return true;
}




function EventoDatosJson(idEvento,idPuntoVenta,segundosantesbloqueo) {
    IDPUNTOVENTA=idPuntoVenta;
    SEGBLOQUEOANTESEVENTO=segundosantesbloqueo;
    $.ajax({
        type: 'POST',
       // async:false,
        tryCount : 0,
        retryLimit : 3,
        url: basePath + 'EventoDatosJsonFk',
        data: {
            '_token': $('input[name=_token]').val(),
            'idEvento': idEvento,
            'idPuntoVenta': idPuntoVenta,
        },
        success: function (response) {

            eventodatos=response.eventodatos;
            hora_servidor=response.hora_servidor;
            jugador=response.jugador;
            divisa=response.divisa;
            jackpotsuma=response.jackpotsuma;
            tipoapuesta=response.tipoapuesta;
            dinerodefault=response.dinerodefault;

            $("#row_datosevento #jugador").text(jugador);
            $("#row_datosevento #divisa").text(divisa);
            $("#row_datosevento #jackpotsuma").text(divisa+" "+jackpotsuma);

            $("#valor_total>span").text("TOTAL: 0.00 "+divisa);
            $("#valor_maximo>span").text("TOTAL: 0.00 "+divisa);
            $(".apuesta span").text("APUESTA "+divisa)
// ////////PROXIMO EN
            //////CONECTAR A SERVIDOR WEBSOCKET Y PEDIR HORA CADA  SEGUNDO
            connectarWebSockets(IPSERVIDOR_WEBSOCKETS,PUERTO_WEBSOCKETS);  ///en archivo ClaseWebSockets.js
            // setTimeout(function(){
            //     console.error("declarando intervalohora");
            //     // intervalohora=setInterval(function(){
            //     //                  pedir_hora_server();     
            //     //    },1000);
            // },800)
            ///////////////////////////////////////////////////////////////
////////FIN PROXIMO EN

        ////jackpot
            HistorialJackpotDatosJson($("#idPuntoVenta").val(),eventodatos.idEvento);
            intervaloihistorialjackpot=setInterval(function(){
                 HistorialJackpotDatosJson($("#idPuntoVenta").val(),eventodatos.idEvento);
            },14000)

            //      horaserv=ServerDate();horaserv= new Date(horaserv);
            //     reloj_servidor(horaserv,eventodatos.fechaFinEvento,eventodatos.segBloqueoAntesEvento);
            //     $(".TOMBOLACUY").show();
                eventoactual={};
                eventoactual.FechaEvento=eventodatos.FechaEvento;
                eventoactual.fechaFinEvento=eventodatos.fechaFinEvento;
                eventoactual.nombre=eventodatos.nombre;
                eventoactual.IdEvento=eventodatos.idEvento;
                eventoactual.apuestaMinima=eventodatos.apuestaMinima;
                eventoactual.apuestaMaxima=eventodatos.apuestaMaxima;
                eventoactual.segBloqueoAntesEvento=eventodatos.segBloqueoAntesEvento;
                eventoactual.idMoneda=eventodatos.idMoneda;
                eventoactual.Imagen="img/juegos/"+eventodatos.logo;
                $("#modal_imprimir #imagen_eventoactual").attr("src",eventodatos.logo);
                    setTimeout(function(){
                                   // horaserv=ServerDate();horaserv= new Date(horaserv);
                                    // reloj_servidor(horaserv,eventodatos.fechaFinEvento,eventodatos.segBloqueoAntesEvento);
                                    $(".TOMBOLACUY").css("cursor","");
                                    $(".TOMBOLACUY").show();
                    },500)
        ///fin jackpot
        },///FIN SUCCESS
    })
}///FIN EventoDatosJson



function EventoDatosJsonNuevo(divelemento,idEvento,idPuntoVenta,segundosantesbloqueo) {
    IDPUNTOVENTA=idPuntoVenta;
    IDEVENTO=idEvento;
    SEGBLOQUEOANTESEVENTO=segundosantesbloqueo;
            jugador=$(divelemento).attr("data-jugador");
            divisa=$(divelemento).attr("data-divisa");
            jackpotsuma=$(divelemento).attr("data-jackpotsuma");
            idevento=$(divelemento).attr("data-id");
            $("#row_datosevento #jugador").text(jugador);
            $("#row_datosevento #divisa").text(divisa);
            $("#row_datosevento #jackpotsuma").text(divisa+" "+jackpotsuma);
            $("#valor_total>span").text("TOTAL: 0.00 "+divisa);
            $("#valor_maximo>span").text("TOTAL: 0.00 "+divisa);
            $(".apuesta span").text("APUESTA "+divisa);
            if(socket!=null && socket.readyState==1){
                console.warn("YA CONECTADO, pedir hora")
                pedir_hora_server();
            }else{
                console.warn("INICIANDO CONEXIÓN ");
                connectarWebSockets(IPSERVIDOR_WEBSOCKETS,PUERTO_WEBSOCKETS);  ///en archivo ClaseWebSockets.js
            }
            // connectarWebSockets(IPSERVIDOR_WEBSOCKETS,PUERTO_WEBSOCKETS);  ///en archivo ClaseWebSockets.js
        ////jackpot
            HistorialJackpotDatosJson($("#idPuntoVenta").val(),idEvento);
            intervaloihistorialjackpot=setInterval(function(){
                 HistorialJackpotDatosJson($("#idPuntoVenta").val(),idEvento);
            },14000)
                eventoactual={};
                eventoactual.FechaEvento=$(divelemento).attr("data-FechaEvento");
                eventoactual.fechaFinEvento=$(divelemento).attr("data-fechaFinEvento");
                eventoactual.nombre=$(divelemento).attr("data-nombre");
                eventoactual.IdEvento=idevento;
                eventoactual.apuestaMinima=$(divelemento).attr("data-apuestaMinima");
                eventoactual.apuestaMaxima=$(divelemento).attr("data-apuestaMaxima");
                eventoactual.segBloqueoAntesEvento=$(divelemento).attr("data-segBloqueoAntesEvento");
                eventoactual.idMoneda=$(divelemento).attr("data-idMoneda");
                eventoactual.Imagen="img/juegos/"+$(divelemento).attr("data-logo");
                $("#modal_imprimir #imagen_eventoactual").attr("src",$(divelemento).attr("data-logo"));
                    setTimeout(function(){
                                   // horaserv=ServerDate();horaserv= new Date(horaserv);
                                    // reloj_servidor(horaserv,eventodatos.fechaFinEvento,eventodatos.segBloqueoAntesEvento);
                                    $(".TOMBOLACUY").css("cursor","");
                                    $(".TOMBOLACUY").show();
                    },500)
        ///fin jackpot
   
}///FIN EventoDatosJson


function responsivetombola(){
    heighttbody=$(".rowtablaeventos").outerHeight()-$("#tabla_eventos thead tr").height()
    $("#tabla_eventos tbody").attr("style","height:"+heighttbody+"px")

        $(".responsive").each(function(i,e){
            var height = $(e).height();
            $(e).css({
                'font-size': (height/2) + 'px',
                'line-height': height + 'px'
            })
        })
}

function detenerRelojServidor(){
     if(typeof intervalo_horaservidor!="undefined"){
        clearInterval(intervalo_horaservidor)
        delete intervalo_horaservidor;
    }
}
function detenerContador(){
     if(typeof intervalo_contador!="undefined"){
            clearInterval(intervalo_contador);
            delete intervalo_contador;
     }
}

function iniciarContador(duration, display,segundosantesbloqueo) {
    tiempototal=duration;
    var timer = duration, minutos, segundos;
    detenerContador();
    intervalo_contador=setInterval(function () {
        minutos = parseInt(timer / 60, 10);
        segundos = parseInt(timer % 60, 10);    

        minutos = minutos < 10 ? "0" + minutos : minutos;
        segundos = segundos < 10 ? "0" + segundos : segundos;
        display.text(minutos + ":" + segundos);
      
            ///termometro
        //         porcentaje= duration-((100*timer)/duration);
            porcentaje=((100*(timer-segundosantesbloqueo))/duration);
         //console.warn("porcn=" + porcentaje);
            $("#barra_loading").css("width",porcentaje+"%")
        //
       // ///////segundos bloqueo
           segantesdebloque=segundosantesbloqueo;
        if(minutos==0 && segundos<=segantesdebloque){
            if($("#contador_overlay").length==0){
                    $.LoadingOverlay("show",{image:basePath+"img/loading/load.gif"})
                    $(".loadingoverlay").append($('<div id="contador_overlay" style="position: relative; left: 6%;width:7%;height: 10%; text-align:center;font-size:8vh;color:red">--</div>'))
                
            }
            if($("#contador_overlay").length>0){
                    $("#contador_overlay").text(segundos)
                }
        }
        else{
           segundostotales= parseInt((parseInt(minutos)*60))+parseInt(segundos);
          if(segundostotales==segantesdebloque){
             $.LoadingOverlay("show",{image:basePath+"img/loading/load.gif"})
          }
        }
        if(minutos==0 && segundos==0){
              setTimeout(function(){
                 // RECONECTAR_WEBSOCKET=false;
                 // socket.close();///cerrar socket
                 //  location.reload();
                $.LoadingOverlay("hide");
                 $("#contador_overlay").remove();
                CargarTabla();
               // $.LoadingOverlay("hide");
                //location.reload();
              },250)
        }
          //fin segundos bloqueo
        if (--timer < 0) {
            timer = duration;
        }
    }, 1000);
}
function ContadorProximoEvento(horaserv,fechaFinEvento,segundosantesbloqueo){
    proxima_fecha=moment(fechaFinEvento, "YYYY-MM-DD HH:mm:ss a");
    ahora=moment(horaserv);
    segundos=proxima_fecha.diff(ahora,'seconds');
    $("#proximo_en2").text("--");
    if(segundos>0){
        iniciarContador(segundos, $("#proximo_en2"),segundosantesbloqueo) ;
    }
    else{
        if(typeof intervalo_contador!="undefined"){
            clearInterval(intervalo_contador) 
        }

    }
     console.log("proximo_en2 ="+segundos);
    console.log(horaserv);
}
function reloj_websockets(horaserv,fechaFinEvento,segundosantesbloqueo){
 // horaserv=ServerDate();horaserv= new Date(horaserv);
    //proxima_fecha=moment(fechaFinEvento, "YYYY-MM-DD HH:mm:ss a");
    //ahora=moment(horaserv);
    //segundos=proxima_fecha.diff(ahora,'seconds');
    //$("#proximo_en2").text("--");

    // if(segundos>0){
    //     iniciarContador(segundos, $("#proximo_en2")) ;
    // }
    // else{
    //     if(typeof intervalo_contador!="undefined"){
    //         clearInterval(intervalo_contador) 
    //     }

    // }
    // console.log("proximo_en2 ="+segundos);
    // console.log(horaserv)
    detenerRelojServidor();
    intervalo_horaservidor=setInterval(function(){
                            horaserv=new Date(horaserv);
                            horaserv=horaserv.setSeconds(horaserv.getSeconds()+1)
                            horaserv=new Date(horaserv);

                            hora=horaserv.getHours();
                            minutos=horaserv.getMinutes();
                            segundos=horaserv.getSeconds();
                            var dn = "PM";
                            if (hora < 12){
                                dn = "AM";
                            }
                            if (hora > 12){
                                hora = hora - 12;
                            }
                            if (hora == 0){
                                hora = 12;
                            }
                            if (minutos <= 9){
                                minutos = "0" + minutos;
                            }
                            if (segundos <= 9){
                                segundos = "0" + segundos;
                            }
                            hora_servidor_final=hora
                                                +":"+minutos
                                                +":"+segundos
                                                +" "+dn;
                           ///////segundos bloqueo
                            // if(minutos==0 && segundos==segundosantesbloqueo){
                            //     $.LoadingOverlay("show");
                            // }
                            // else{
                            //     segundostotales= parseInt((parseInt(minutos)*60))+parseInt(segundos);
                            //     if(segundostotales==segundosantesbloqueo){
                            //         $.LoadingOverlay("show");
                            //     }

                            // }
                            // if(minutos==0 && segundos==0){
                            //     setTimeout(function(){
                            //         RECONECTAR_WEBSOCKET=false;
                            //            socket.close();///cerrar socket
                            //             $.LoadingOverlay("hide");
                            //             CargarTabla()
                            //             // location.reload();
                            //     },1500)
                            // }
                            //fin segundos bloqueo
                            $('#fechaServidor').text(hora_servidor_final);
                        },1000)

}

function reloj_servidor(horaserv,fechaFinEvento,segundosantesbloqueo){
 // horaserv=ServerDate();horaserv= new Date(horaserv);
    proxima_fecha=moment(fechaFinEvento, "YYYY-MM-DD HH:mm:ss a");
    ahora=moment(horaserv);
    segundos=proxima_fecha.diff(ahora,'seconds');
    if(segundos>0){
        iniciarContador(segundos, $("#proximo_en2"),segundosantesbloqueo) ;

    }
    console.log("proximo_en2 ="+segundos);
    console.log(horaserv)
    if(typeof intervalo_horaservidor!="undefined"){
        clearInterval(intervalo_horaservidor)
    }

    intervalo_horaservidor=setInterval(function(){
                            horaserv=horaserv.setSeconds(horaserv.getSeconds()+1)
                            horaserv=new Date(horaserv);
                            hora=horaserv.getHours();
                            minutos=horaserv.getMinutes();
                            segundos=horaserv.getSeconds();
                            var dn = "PM";
                            if (hora < 12){
                                dn = "AM";
                            }
                            if (hora > 12){
                                hora = hora - 12;
                            }
                            if (hora == 0){
                                hora = 12;
                            }
                            if (minutos <= 9){
                                minutos = "0" + minutos;
                            }
                            if (segundos <= 9){
                                segundos = "0" + segundos;
                            }
                            hora_servidor_final=hora
                                                +":"+minutos
                                                +":"+segundos
                                                +" "+dn;
                           ///////segundos bloqueo
                            if(minutos==0 && segundos==segundosantesbloqueo){
                                $.LoadingOverlay("show");
                            }
                            else{
                                segundostotales= parseInt((parseInt(minutos)*60))+parseInt(segundos);
                                if(segundostotales==segundosantesbloqueo){
                                    $.LoadingOverlay("show");
                                }

                            }
                            if(minutos==0 && segundos==0){
                                setTimeout(function(){
                                        $.LoadingOverlay("hide");
                                        location.reload(true);
                                },1500)
                            }
                            //fin segundos bloqueo
                            $('#fechaServidor').text(hora_servidor_final);
                        },1000)

}






///////HORA SERVER
function hora_reloj(fechahora_servidor) {
    if (!document.layers && !document.all && !document.getElementById)
        return;
    var Digital = new Date();
    var z = Digital.getHours();
    var minutes = Digital.getMinutes();
    var seconds = Digital.getSeconds();
    if ($("#fechaHoy2").length) {
        var today = moment(fechahora_servidor).format('DD/MM/YYYY');
        window.onload = hora_reloj(fechahora_servidor);
    var dn = "PM";
    if (hours < 12)
        dn = "AM";
    if (hours > 12)
        hours = hours - 12;
    if (hours == 0)
        hours = 12;

    if (minutes <= 9)
        minutes = "0" + minutes;
    if (seconds <= 9)
        seconds = "0" + seconds;
    myclock = "<b>" + hours + ":" + minutes + ":"+ seconds + " " + dn + "</b>";
    if (document.layers) {
        document.layers.liveclock.document.write(myclock);
        document.layers.liveclock.document.close();
    }
    else if (document.all)
        liveclock.innerHTML = myclock;
    else if (document.getElementById)
        document.getElementById("liveclock").innerHTML = myclock;
    setTimeout(hora_reloj(fechahora_servidor), 1000);
    }
}
 if ($("#fechaHoy2").length) {
     var today = moment().format('DD/MM/YYYY');
     window.onload = hora_reloj(fechahora_servidor);
 }
//FIN HORA SERVER




///////Obtiene Datos de AperturaCaja,Evento  ,Apuestas, 
function ListarVentaDatosJson() {
    $.ajax({
        type: 'POST',async:false,
        url: basePath + 'VentaDatosJsonFk',
        data: {
            '_token': $('input[name=_token]').val(),
        },
        beforeSend: function () {
        },
        complete: function () {
        },
        tryCount : 0,
        retryLimit : 3,
        success: function (response) {

            USUARIO=response.usuario;
            hora_servidor=response.hora_servidor;

            dinerodefault=response.dinerodefault;
            if(dinerodefault.length==0){
                toastr.error("No hay DineroDefault Registrados","Error");
                return false;
            }
            ////apertura caja datos
             aperturacajadatos = response.aperturacajadatos;
            if(aperturacajadatos.length==0){
                toastr.error("No hay AperturaCaja Registrado","Error");
                return false;
            }
             aperturacajadatos=aperturacajadatos[0];

             //divdatos=$("#datoscaja");
             // $.each(aperturacajadatos,function(col,valor){
             //        $("#"+col,divdatos).val(valor).attr("readonly","readonly");
             // })
            ////fin apertura caja datos
            ///conf_eventos
            eventos=response.eventos;

             if(eventos.length==0){
                toastr.error("No hay Eventos Registrados","Error");
                return false;
            }
                // $(eventos).each(function(i,e){
                //         $("#div_configuracioneventos .eventos_fila_izq").append(
                //             $("<div>")
                //                 .addClass("configuracioneventosdiv")
                //                 .data("id",e.idEvento)
                //                 .data("nombre",e.nombre)
                //                 .data("apuestaMinima",e.apuestaMinima)
                //                 .data("apuestaMaxima",e.apuestaMaxima)
                //                 .data("FechaEvento",e.FechaEvento)
                //                 .data("fechaFinEvento",e.fechaFinEvento)
                //                 .data("segBloqueoAntesEvento",e.segBloqueoAntesEvento)
                //                 .data("idMoneda",e.idMoneda)
                //                 //.text(e.nombre)  
                //                 .append(
                //                         $("<div>").attr("style","width: 30%; height: 100%;float:left;position:relative")
                //                         .append(
                //                             $("<img>").attr("style","width:70%;height:80%;position: absolute; left: 50%; transform: translate(-50%, -50%); top: 50%;").attr("src",basePath+"img/juegos/"+e.logo)
                //                             )
                //                 )  
                //                 .append(
                //                         $("<div>").attr("style","width: 70%; height: 100%;float:left;display:flex;align-items:center").text(e.nombre).addClass("eventotextodiv")
                //                     )              
                //         );
                // })
             ///fin conf_eventos 
             ///apuestas
            // apuestas=response.apuestas;
                // $(dinerodefault).each(function(i,e){
                //           $("#div_apuestas").append(
                //             $("<div>")
                //                  .addClass("rowapuestasdiv")
                //                 // .data("id","#"+e.idConfiguracionEvento)
                //                  .data("valor",e.monto)
                //                  .data("tipo","apuesta")
                //                  .attr("data-tipo","apuesta")
                //                 .text(e.monto)                
                //                 );
                // })
             ///fin apuestas  
        },////fin success
        error : function(xhr, textStatus, errorThrown ) {
            this.tryCount++;
            if (this.tryCount <= this.retryLimit) {
                $.ajax(this);

                return;
            }            
            return;
         }

    })
}


function eventos_botones(){
/////botones numeros  SELECCIONADO CLASE
    //boton 0
    $(".rectangulo_izquierda").off().on("click",function(e){ 
            $(this).toggleClass("seleccionado") ;
        })
///fin boton 0
    $("#numeros_tabla [data-tipo='numero']").off().on("click",function(e){ 
            $(this).toggleClass("seleccionado") ;
        })

    $(".apuestasadicionalescontenedor .apuestacondicional_fila .apuestacondicional_fila_datos div")
    .off().on("click",function(e){ 
            $(this).toggleClass("seleccionado") ;
        })
/////finbotones numeros


///nuevo
$("#numeros_tabla2 .numeros_rect2 div").off().on("click",function(e){ 
            $(this).toggleClass("seleccionado") ;
        })
///fin nueo

        $("#numeros_tabla [data-tipo='rango']").off().on("click",function(e){ 
            $(this).toggleClass("seleccionado") ;
        })
        $("#numeros_tabla [data-tipo='pares']").off().on("click",function(e){ 
            $(this).toggleClass("seleccionado") ;
        })
        $("#numeros_tabla [data-tipo='impares']").off().on("click",function(e){ 
            $(this).toggleClass("seleccionado") ;
        })
        $("#numeros_tabla [data-tipo='color']").off().on("click",function(e){ 
            $(this).toggleClass("seleccionado") ;
        })
        $("#numeros_tabla [data-tipo='color']").off().on("click",function(e){ 
           $(this).toggleClass("seleccionado") ;
        })

    //////botones apuesta  1 2 5  10 50 100
       $("#div_apuestas [data-tipo='apuesta']").off().on("click",function(e){ 
                $(this).toggleClass("seleccionadoapuesta") ;
                var SUMAAPUESTAS=0;
                $("#div_apuestas .seleccionadoapuesta").each(function(ii,ee){
                SUMAAPUESTAS=SUMAAPUESTAS+$(ee).data("valor");
                })
                $(".rowtableeventos_footer_apuesta").text("APUESTA "+SUMAAPUESTAS+" "+divisa);
        })

    /////BOTONESSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSS  DINERODEFAULT

    ///boton check
    $("#div_botones .check").off().on("click",function(){
            ID_EVENTO=$(".id_tituloconfiguracionevento").text();

            cantidadapuesta=$("#div_apuestas .seleccionadoapuesta").length;
             SUMAAPUESTAS=0;
            $("#div_apuestas .seleccionadoapuesta").each(function(i,e){
                SUMAAPUESTAS=SUMAAPUESTAS+$(e).data("valor");
            })
            if(cantidadapuesta==0){
                toastr.error("Seleccione Apuesta")
                return false;
            }
            //cantidadnumeros=$("#numeros_tabla .seleccionado, .rectangulo_izquierda.seleccionado").length;
            cantidadnumeros=$(".apuestacondicional_fila_datos .seleccionado,#numeros_tabla2 .seleccionado,#numeros_tabla .seleccionado, .rectangulo_izquierda.seleccionado").length;
   // $(".apuestasadicionalescontenedor .apuestacondicional_fila .apuestacondicional_fila_datos div .seleccionado")

            if(cantidadnumeros==0)
            {
                toastr.error("Seleccione Número")
                return false;
            }
    //        apuesta_fila=parseFloat(SUMAAPUESTAS/cantidadnumeros).toFixed(2);
            apuesta_fila=parseFloat(SUMAAPUESTAS).toFixed(2);

            if(apuesta_fila<1){
                toastr.error("La apuesta no puede ser mínima al menor");
                 apuesta_fila=1;
            }
            array_apuestas_json=generar_json_apuestas();
            FILA_PARA_TABLA={};
            //$("#numeros_tabla .seleccionado , .rectangulo_izquierda.seleccionado")
            $(".apuestacondicional_fila_datos .seleccionado,#numeros_tabla2 .seleccionado,#numeros_tabla .seleccionado, .rectangulo_izquierda.seleccionado")
            // $("#numeros_tabla .seleccionado")
            .each(function(i,e){
////
                // $(e).addClass("apostado")
                 //$(e).off("click")
////
               array_apuestas_json=generar_json_apuestas();
                valornumero=$(e).data("valor");
                tiponumero=$(e).data("tipo");
                idTipoPago=$(e).data("idtipopago");
                colornumero=$(e).data("color");
                valornumero=$(e).data("valor");
                idtipopago=$(e).data("idtipopago");
                idtipoapuesta=$(e).data("idtipoapuesta");
                if(idtipopago.toString()=="2"){
                    valornumero=colornumero;
                }
                cuota=$(e).data("cuota");
                apostado=false;
                //console.log(array_apuestas_json);

                $(array_apuestas_json).each(function(ii,ee){
                    if((ee.SELECCION).toString()==valornumero.toString()){
                        apostado=true;
                    }
                })
                console.log("apostado"+apostado+" "+valornumero)
                if(!apostado){   ////SI NO FUE APOSTADO AUN SE  AGREGA TR A TABLA 
                    //cuota=tiponumero=="numero"?10:tiponumero=="rango"?10:tiponumero=="pares"?11:tiponumero=="impares"?14:15;
                    FILA_PARA_TABLA.ID_EVENTO=ID_EVENTO;
                    FILA_PARA_TABLA.SELECCION= valornumero;
                    FILA_PARA_TABLA.CUOTA= cuota;
                    FILA_PARA_TABLA.APUESTA= apuesta_fila;

                    var tr_tabla=$("#tabla_eventos tbody tr td:first-child:contains('-')").eq(0);
                    if(tr_tabla.length==0){

                         $("#tabla_eventos tbody").append(
                                $("<tr>")
                                    .attr("data-tipo",tiponumero)
                                    .attr("data-color",colornumero)
                                    .attr("data-valor",valornumero)
                                    .attr("data-idTipoPago",idTipoPago)
                                    .attr("data-idtipoapuesta",idtipoapuesta)
                                    .append(
                                            $("<td>").text(FILA_PARA_TABLA.ID_EVENTO)
                                            )
                                    .append(
                                            $("<td>").text(FILA_PARA_TABLA.SELECCION)
                                            )
                                    .append(
                                            $("<td>").text(FILA_PARA_TABLA.CUOTA)
                                            )
                                    .append(
                                            $("<td>").text(parseFloat(FILA_PARA_TABLA.APUESTA).toFixed(2))
                                                    .append($("<div>").addClass("divcerrarfila").append($('<i class="icon  fa fa-close" style="display:inline"></i>')))
                                            )
                            )
                         $(".divcerrarfila").off("click").on("click",function(){

                                $(this).closest("tr").remove();
                                // $("div[data-valor='"+$("td:eq(1)",$(this).closest("tr")).text()+"']").on("click",function(){ $(this).toggleClass("seleccionado") ;}) 
                                // $("div[data-valor='"+$("td:eq(1)",$(this).closest("tr")).text()+"']").removeClass("apostado")
                                var totales_maximo=sacar_totales_y_maximo();
                                $(".apuesta .rowtableeventos_footer_apuesta").text();
                                $(".valorestotalmax #valor_total span").text("TOTAL: "+parseFloat(totales_maximo.total).toFixed(2)+" "+divisa);
                                $(".valorestotalmax #valor_maximo span").text("MAX: "+parseFloat(totales_maximo.maximo).toFixed(2)+" "+divisa);

                         })
                    }
                    else{
                        tr_tabla=tr_tabla.parent();
                        tr_tabla.attr("data-tipo",tiponumero)       ;                 
                        tr_tabla.attr("data-color",colornumero)       ;   
                        tr_tabla.attr("data-valor",valornumero)       ;   

                        $("td",tr_tabla).eq(0).text(FILA_PARA_TABLA.ID_EVENTO)
                        $("td",tr_tabla).eq(1).text(FILA_PARA_TABLA.SELECCION)
                        $("td",tr_tabla).eq(2).text(FILA_PARA_TABLA.CUOTA)
                        $("td",tr_tabla).eq(3).text(parseFloat(FILA_PARA_TABLA.APUESTA).toFixed(2))
                    }
                    var totales_maximo=sacar_totales_y_maximo();
                    $(".valorestotalmax #valor_total span").text("TOTAL: "+parseFloat(totales_maximo.total).toFixed(2)+" "+divisa);
                    $(".valorestotalmax #valor_maximo span").text("MAX: "+parseFloat(totales_maximo.maximo).toFixed(2)+" "+divisa);
                }
                else{
                    toastr.error("Ya ingresó  "+valornumero);
                }
            })///fin numerotabla seleccionados

            $(".apuestacondicional_fila_datos .seleccionado,#numeros_tabla2 .seleccionado,#numeros_tabla .seleccionado, .rectangulo_izquierda.seleccionado").removeClass("seleccionado");

        $("#numeros_tabla .seleccionado").removeClass("seleccionado");

    })////FINNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNN on click boton check

        ///BOTON CERRAR  -- BORRAR
        $("#div_botones .cerrar").off().on("click",function(){
            if($("#tabla_eventos tbody tr").length=="0"){
                toastr.error("No hay Apuestas");
            }else{
                idtabla="tabla_eventos";
                $("tbody","#"+idtabla).empty();
                var totales_maximo=sacar_totales_y_maximo();
                $(".valorestotalmax #valor_total span").text("TOTAL: "+parseFloat(totales_maximo.total).toFixed(2)+" "+divisa);
                $(".valorestotalmax #valor_maximo span").text("MAX: "+parseFloat(totales_maximo.maximo).toFixed(2)+" "+divisa);

            }
        // $("#numeros_tabla .apostado").removeClass("apostado");


        })

           ///BOTON BUSCAR
        $("#div_botones .barcode").off().on("click",function(){
             $("#modal_buscar").modal("show"); 
        })

        ///BOTON IMPRIMIR
        $("#div_botones .print").off().on("click",function(){

            if(typeof intervalo_contador=="undefined"){
                toastr.error("Evento Actual Ya Finalizó,   Recargar Página");
                return;
            }

            if($("#tabla_eventos tbody tr").length=="0"){
                toastr.error("No hay Apuestas");
            }
            else{

                 $("#imagen_qrcode").attr("src","");
                $("#imagen_codigobarra").attr("src","");

                TICKET_IMPRIMIR={};
                TICKET_IMPRIMIR.ImagenSrc=eventoactual.Imagen
                TICKET_IMPRIMIR.Id_Ticket=0;
                TICKET_IMPRIMIR.Id_Unidad=CC_ID //eventoactual.IdEvento;
                TICKET_IMPRIMIR.Nro_Evento=eventoactual.IdEvento;
                TICKET_IMPRIMIR.Desc=eventoactual.nombre;

                totales=sacar_totales_y_maximo();
                TICKET_IMPRIMIR.TotalTicket=totales.total;
                TICKET_IMPRIMIR.ImpresoEn=moment(new Date()).format("DD-MM-YYYY HH:mm a");//new Date().toLocaleString();
                TICKET_IMPRIMIR.ImpresoPor=USUARIO;

                TICKET_IMPRIMIR.PremioMaximoAPagar=parseFloat(totales.maximo).toFixed(2)+" "+divisa;
                TICKET_IMPRIMIR.PremioMaximoPotencial=parseFloat(totales.total).toFixed(2)+" "+divisa;
                apuestas=[];
                $("#tabla_eventos tbody tr").each(function(i,e){
                        fila_apuesta={};
                        var tr=e;
                        if($("td:eq(1)",tr).text()!=""){
                            tipo= $(tr).data("tipo");
                            idtipopago= $(tr).data("idtipopago");
                            idtipoapuesta= $(tr).data("idtipoapuesta");
                            valor= $(tr).data("valor");
                            evento=$("td:eq(0)",tr).text();
                            seleccion=$("td:eq(1)",tr).text();
                            cuota=$("td:eq(2)",tr).text();
                            apuesta=$("td:eq(3)",tr).text();
                            fila_apuesta.evento=eventoactual.IdEvento;//evento;
                            fila_apuesta.descripcion=seleccion;
                            fila_apuesta.cuota=cuota;
                            fila_apuesta.idtipopago=idtipopago;
                            fila_apuesta.idtipoapuesta=idtipoapuesta;
                            fila_apuesta.apuesta=apuesta;
                            apuestas.push(fila_apuesta);
                        }
                })
                TICKET_IMPRIMIR.apuestas=apuestas;

                GuardarTicket(TICKET_IMPRIMIR);
            }
        })



        $("#modal_buscar").off("hidden.bs.modal").on("hidden.bs.modal", function () {
             ;CargarTabla();
        })
        $("#modal_buscar").off("shown.bs.modal").on("shown.bs.modal",function(){
                detenerContador();
                $("#modal_buscar #ticket_txt").focus();
        });
      
        $("#modal_imprimir").off("hidden.bs.modal").on("hidden.bs.modal", function () {
             CargarTabla();
        })
        $("#modal_imprimir").off("shown.bs.modal").on("shown.bs.modal", function () {
            detenerContador();  
        })
        $("#modal_imprimir_pago").off("hidden.bs.modal").on("hidden.bs.modal", function () {
             CargarTabla();
        })
        $("#modal_imprimir_pago").off("shown.bs.modal").on("shown.bs.modal", function () {
            detenerContador();  
        })        
        
///////////////////////////FIN BOTONESSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSS

}


function eventos_botones_modalbuscar(){
$('.digitador .digito').off().on('click',function(){
             valor=$(this).text();
             valortxt=$("#ticket_txt").val();
            valortxt=valortxt+valor;
            $("#ticket_txt").val(valortxt);
        })

        $('.digitador .borrar').off().on('click',function(){
            var valortxt=$("#ticket_txt").val();
            valortxt=valortxt.substring(0,valortxt.length-1);
            $("#ticket_txt").val(valortxt);
        })
        

        $("#btn_buscar_ticket").off().on("click",function(e){
                e.preventDefault(); 


            if($("#ticket_txt").val().trim()!=""){
                       $("#btn_buscar_ticket").attr("disabled",true);
                $("#btn_buscar_ticket").LoadingOverlay("show");

                objetobuscar={};
                objetobuscar.idEvento=eventoactual.IdEvento;
                objetobuscar.nombre=eventoactual.nombre;
                objetobuscar.idTicket=$("#ticket_txt").val().trim();
                // objetobuscar.idTipoApuesta=eventoactual.idTipoApuesta;
                BuscarTicket(objetobuscar);
                $("#ticket_txt").val("");

            }else{
                toastr.error("Ingrese Número Ticket");
                $("#btn_buscar_ticket").LoadingOverlay("hide");
                $("#btn_buscar_ticket").attr("disabled",false);



            }
        })
        $("#buscar_div").off().on("click",function(e){
              e.preventDefault(); 
                $("#btn_buscar_ticket").click();
            
        })

      


}



function generar_json_apuestas(){
    idtabla="tabla_eventos";
    array_apuestas=[];
    $("tbody tr","#"+idtabla).each(function(i,e){
        var tr =e;
        if($("td:eq(0)",tr).text()!="-"){
        filaapuesta={};
            filaapuesta.ID_EVENTO=$("td:eq(0)",tr).text();
            filaapuesta.SELECCION=$("td:eq(1)",tr).text();
            filaapuesta.CUOTA=$("td:eq(2)",tr).text();
            filaapuesta.APUESTA=$("td:eq(3)",tr).text().trim();
            array_apuestas.push(filaapuesta)
        }
    })
    return array_apuestas;
}
function sacar_totales_y_maximo(){
     idtabla="tabla_eventos";
    array_apuestas=[];
    var total=0;
    var maximo=0;var tipo="";
    var tr_maximo=null;
    $("tbody tr","#"+idtabla).each(function(i,e){
         var tr =e;
        if($("td:eq(0)",tr).text()!="-"){
            max_fila=parseFloat($("td:eq(2)",tr).text())*parseFloat($("td:eq(3)",tr).text().trim());
            total=total+parseFloat($("td:eq(3)",tr).text().trim());
            if(max_fila>maximo){
                tr_maximo=tr;
                maximo=max_fila;
                tipo=$("tr").attr("data-tipo");
            }
        }
    });
  
    if($(tr_maximo).data("tipo")=="numero"){  /////SI TR MAXIMO ES NUMERO, REVISAR SI HAY APUESTA EN RANGO,PAR,IMPAR,COLOR

        ///RANGO
            tr_rangos=$("#tabla_eventos tbody tr[data-tipo='rango']");
            $(tr_rangos).each(function(a,b){
                var trrango=b;
                var rango=$(trrango).data("valor");
                rangos_array=rango.split("-");
                valor_trmaximo=$(tr_maximo).data("valor");
                var rangoinicio=rangos_array[0];
                var rangofin=rangos_array[1];
                if(valor_trmaximo>=rangoinicio &&  valor_trmaximo<=rangofin){
                    maximo=maximo+(parseFloat($("td:eq(2)",trrango).text())*parseFloat($("td:eq(3)",trrango).text().trim()));
                }
            })
            //

        ///PAR IMPAR
            tr_pares=$("#tabla_eventos tbody tr[data-tipo='pares']");
            if(tr_pares.length){
                valor_trmaximo=$(tr_maximo).data("valor");
                var trpar=tr_pares;
                if(parseInt(valor_trmaximo)%2==0){///es par
                    maximo=maximo+(parseFloat($("td:eq(2)",trpar).text())*parseFloat($("td:eq(3)",trpar).text().trim()));
                }
            }
             tr_impares=$("#tabla_eventos tbody tr[data-tipo='impares']");
            if(tr_impares.length){
                valor_trmaximo=$(tr_maximo).data("valor");
                var trimpar=tr_impares;
                if(parseInt(valor_trmaximo)%2!=0){///es impar
                    maximo=maximo+(parseFloat($("td:eq(2)",trimpar).text())*parseFloat($("td:eq(3)",trimpar).text().trim()));
                }
            }
            //
        ///COLOR
          tr_negros=$("#tabla_eventos tbody tr[data-tipo='negros']");
            if(tr_negros.length){
                color_trmaximo=$(tr_maximo).data("color");
                var trnegro=tr_negros;
                if(color_trmaximo.toUpperCase()==(trnegro.data("valor")).toUpperCase()){///es negro
                    maximo=maximo+(parseFloat($("td:eq(2)",trnegro).text())*parseFloat($("td:eq(3)",trnegro).text().trim()));
                }
            }
            tr_rojos=$("#tabla_eventos tbody tr[data-tipo='rojos']");
            if(tr_rojos.length){
                color_trmaximo=$(tr_maximo).data("color");
                var trrojo=tr_rojos;
                if(color_trmaximo.toUpperCase()==(trrojo.data("valor")).toUpperCase()){///es negro
                    maximo=maximo+(parseFloat($("td:eq(2)",trrojo).text())*parseFloat($("td:eq(3)",trrojo).text().trim()));
                }
            }

    }////fin tr maximo es numero

/// SI TRMAXIMO  ES RANGO
    if($(tr_maximo).data("tipo")=="rango"){  /////SI TR MAXIMO ES RANGO,  REVISAR SI HAY APUESTA EN ALGUN NUMERO DEL RANGO
                var rango=$(tr_maximo).data("valor");
                var rangos_array=rango.split("-");
                var rangoinicio=rangos_array[0];
                var rangofin=rangos_array[1];

            tr_numeros=$("#tabla_eventos tbody tr[data-tipo='numero']");
            $(tr_numeros).each(function(iii,eee){
                var trnum=eee;
                var valornumero=$(eee).data("valor");
                if(valornumero>=rangoinicio && valornumero<=rangofin){ ////numero fila esta en rango 
                    maximo=maximo+(parseFloat($("td:eq(2)",trnum).text())*parseFloat($("td:eq(3)",trnum).text().trim()));
                }
            })
    }
    /// FIN SI TRMAXIMO  ES RANGO
    /// SI TRMAXIMO  ES COLOR
    //     if($(tr_maximo).data("tipo")=="negros"){  /////SI TR MAXIMO ES RANGO,  REVISAR SI HAY APUESTA EN ALGUN NUMERO DEL RANGO
    //             tr_negros=$("#tabla_eventos tbody tr[data-tipo='negros']");
    //             if(tr_negros.length){
    //                 color_trmaximo=$(tr_maximo).data("color");
    //                 var trnegro=tr_negros;
    //                 if(color_trmaximo.toUpperCase()==(trnegro.data("valor")).toUpperCase()){///es negro
    //                     maximo=maximo+(parseFloat($("td:eq(2)",trnegro).text())*parseFloat($("td:eq(3)",trnegro).text().trim()));
    //                 }
    //             }
    //             tr_numeros=$("#tabla_eventos tbody tr[data-tipo='numero']");
    //             $(tr_numeros).each(function(iii,eee){
    //                 var trnum=eee;
    //                 var valornumero=$(eee).data("valor");
    //                 if(valornumero>=rangoinicio && valornumero<=rangofin){ ////numero fila esta en rango 
    //                     maximo=maximo+(parseFloat($("td:eq(2)",trnum).text())*parseFloat($("td:eq(3)",trnum).text().trim()));
    //                 }
    //             })
    //     }
    // /// FIN SI TRMAXIMO  ES COLOR
    datos={}
    datos.total=total;
    datos.maximo=maximo;
    return datos;
}  ///FIN sacar_totales_y_maximo();




////ImprimirJson()  =>  al hacer click en boton PRINT;
function ImprimirJson(ticketobjeto_imprimir,idTicket){
//////genera codigoqr y codigo de barras desde php
   TICKET_IMPRIMIR=ticketobjeto_imprimir;
        ticketobjeto_imprimir.Id_Ticket=idTicket;
        $.ajax({
        type: 'POST',
        async:false,
        url: basePath + 'ImprimirDatosJsonFk',
        data: {
            'TICKET_IMPRIMIR': ticketobjeto_imprimir,
            '_token': $('input[name=_token]').val(),
        },
        success: function (response) {
            modalguardarticket.hide();

                codigo_barrahtml=response.codigo_barrahtml;
                qrcode_src=response.qrcode_src;
                codigo_barra_src=response.codigo_barra_src;
                $("#modal_imprimir #divimpresion #IDTique").text(idTicket)
                $("#modal_imprimir #divimpresion #IDUnidad").text(TICKET_IMPRIMIR.Id_Unidad)
                $("#modal_imprimir #divimpresion #NroEvento").text(TICKET_IMPRIMIR.Nro_Evento)
                $("#modal_imprimir #divimpresion #descripcion").text(TICKET_IMPRIMIR.Desc)
                $("#modal_imprimir #divimpresion #datos_filas").empty()
                $(TICKET_IMPRIMIR.apuestas).each(function(i,e){
                    $("#modal_imprimir #divimpresion #datos_filas").append($("<div>").attr("style","width:100%;display:table")
                            .append(
                            $("<div>").attr("style","width:30%;float:LEFT;text-align:left").text(e.evento)
                                )
                            .append(
                            $("<div>").attr("style","width:30%;float:LEFT;text-align:left").text(e.descripcion)
                                )

                            .append(
                            $("<div>").attr("style","width:25%;float:LEFT;text-align:left").text(e.cuota)
                                )

                              .append(
                            $("<div>").attr("style","width:15%;float:LEFT;text-align:left").text(e.apuesta)
                                )
                    )
                })
                $("#modal_imprimir #divimpresion #total_ticket").text(TICKET_IMPRIMIR.TotalTicket.toFixed(2) + " "+divisa)
                $("#modal_imprimir #divimpresion #impreso_en").text(moment(new Date()).format("YYYY-MM-DD HH:mm:s"));
                $("#modal_imprimir #divimpresion #impreso_por").text(TICKET_IMPRIMIR.ImpresoPor)
                $("#modal_imprimir #divimpresion #PremioMaximoAPagar").text(TICKET_IMPRIMIR.PremioMaximoAPagar)
                $("#modal_imprimir #divimpresion #PremioMaximoPotencial").text(TICKET_IMPRIMIR.PremioMaximoPotencial)

                //$("#modal_imprimir #divimpresion .imagen img").attr("src",TICKET_IMPRIMIR.ImagenSrc)  demora 
                ///$("#codigo_barra").html(codigo_barrahtml);
                $("#modal_imprimir #imagen_qrcode").attr("src","data:image/png;base64,"+qrcode_src);
                $("#modal_imprimir #imagen_codigobarra").attr("src","data:image/png;base64,"+codigo_barra_src);

                $("#modal_imprimir #btnimprimir").off("click").on("click",function(){
                    Imprimir("divimpresion");
                            // setTimeout(function(){
                            //     Imprimir("divimpresion");
                            // },1000)
                            //  setTimeout(function(){
                            //     GuardarTicket(TICKET_IMPRIMIR);
                            // },1000)
                })
                setTimeout(function(){
                    $("#btnimprimir").click()
                },1000)
                
            },
        })///FIN AJAX
}


function JugadoresJson(idev) {
    $.ajax({
        type: 'POST',
        url: basePath + 'JugadoresDatosJsonFk',
        data: {
            'idEvento':idev,
            '_token': $('input[name=_token]').val(),
        },
        success: function (response) {
            $("#row_datosevento #jugador").text(response.jugador.cantidadganadores)
        },
    })
}


function HistorialJackpotDatosJson(puntoventa,idev){
        $.ajax({
        type: 'POST',
        url: basePath + 'HistorialJackpotDatosJsonFk',
        data: {
            'idPuntoVenta': puntoventa,
            'idEvento':idev,
            '_token': $('input[name=_token]').val(),
        },
        success: function (response) {
            jackpotsuma=response.jackpotsuma;
            $("#row_datosevento #jackpotsuma").text(divisa+" "+jackpotsuma);

            historialdatos=response.historial;
            $(".historial_numeros").empty();
            $(historialdatos).each(function(i,e){
                  $(".historial_numeros").append(
                    $("<div>")
                    .attr("data-idEvento",e.idEvento)
                    .text(e.valorGanador).css("background-color",e.color)
                )
            })
        },
    })
}



function JackpotDatosJson(puntoventa){
        $.ajax({
        type: 'POST',
        url: basePath + 'JackpotDatosJsonFk',
        data: {
            'idPuntoVenta': puntoventa,
            '_token': $('input[name=_token]').val(),
        },
        success: function (response) {
            jackpotsuma=response.jackpotsuma;
            $("#row_datosevento #jackpotsuma").text(divisa+" "+jackpotsuma);
        },
    })
}
function HistorialJson(idev) {
    $.ajax({
        type: 'POST',
        url: basePath + 'HistorialDatosJsonFk',
        data: {
            'idEvento':idev,
            '_token': $('input[name=_token]').val(),
        },
        success: function (response) {
            historialdatos=response.historial;
            $(".historial_numeros").empty();
            $(historialdatos).each(function(i,e){
                  $(".historial_numeros").append(
                    $("<div>").text(e.valorGanador).css("background-color",e.color)
                )
            })
        },
    })
}



function mover_barra(){
        $("#barra_loading").css("width","100%")
            width=100;
            if(typeof intervalo_barra!="undefined"){
              clearInterval(intervalo_barra)
            }
            intervalo_barra=setInterval(function(){
              
            $("#barra_loading").css("width",width+"%")
            width=width-10;
            },1000)
}



var serverTimeOffset = false;
function getServerTime(callback) {
    if (serverTimeOffset === false) {

        var scripts = document.getElementsByTagName("script"),
            URL = scripts[scripts.length - 1].src;

        var clientTimestamp = Date.parse(new Date().toUTCString());
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.open("HEAD", URL + "?noCache=" + Date.now(), true);
        xmlhttp.onload = function(){
            if (xmlhttp.readyState === 4) {
                if (xmlhttp.status === 200) {

                    var serverDateStr = xmlhttp.getResponseHeader('Date');
                    var serverTimestamp = Date.parse(new Date(Date.parse(serverDateStr)).toUTCString());

                    var serverClientRequestDiffTime = serverTimestamp - clientTimestamp;
                    var nowTimeStamp  = Date.parse(new Date().toUTCString());

                    var serverClientResponseDiffTime = nowTimeStamp - serverTimestamp;
                    var responseTime = (serverClientRequestDiffTime - nowTimeStamp + clientTimestamp - serverClientResponseDiffTime )/2;

                    serverTimeOffset = (serverClientResponseDiffTime - responseTime);

                    var date = new Date();

                    date.setTime(date.getTime() + serverTimeOffset);

                    callback.call(null, date);
                } else {
                    console.error(xmlhttp.statusText);
                }
            }
        };
        xmlhttp.send(null);
        
    } else {
        var date = new Date();

        date.setTime(date.getTime() + serverTimeOffset);

        callback.call(null, date);
    }
}
