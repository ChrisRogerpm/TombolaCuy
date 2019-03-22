///  RESPONSIVE TOMBOLACUY  
$(window).resize(function () {
    responsivetombola();
}).trigger('resize')
/////fin responsive tombolacuy
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
    /////barra de eventos
        // $(".eventos_fila_izq>div").each(function(i,e){
        //      var height = $(e).parent().parent().height();
        //      $(e).css({
        //          'line-height': height + 'px'
        //      })
        //  })
        ///fin barra de eventos

    ////textoresponsive
    // $("#div_configuracioneventos .eventotextodiv").each(function(i,e){
    //     textoresponsive($(e))
    // })

    //fin textoresponmsive
}


///////HORA SERVER
// function hora_reloj(fechahora_servidor) {
//     if (!document.layers && !document.all && !document.getElementById)
//         return;
//     var Digital = new Date();
//     var hours = Digital.getHours();
//     var minutes = Digital.getMinutes();
//     var seconds = Digital.getSeconds();
//     if ($("#fechaHoy2").length) {
//         var today = moment(fechahora_servidor).format('DD/MM/YYYY');
//         window.onload = hora_reloj(fechahora_servidor);
//     var dn = "PM";
//     if (hours < 12)
//         dn = "AM";
//     if (hours > 12)
//         hours = hours - 12;
//     if (hours == 0)
//         hours = 12;

//     if (minutes <= 9)
//         minutes = "0" + minutes;
//     if (seconds <= 9)
//         seconds = "0" + seconds;
//     myclock = "<b>" + hours + ":" + minutes + ":"
//         + seconds + " " + dn + "</b>";
//     if (document.layers) {
//         document.layers.liveclock.document.write(myclock);
//         document.layers.liveclock.document.close();
//     }
//     else if (document.all)
//         liveclock.innerHTML = myclock;
//     else if (document.getElementById)
//         document.getElementById("liveclock").innerHTML = myclock;
//     setTimeout(hora_reloj(fechahora_servidor), 1000);
//     }
// }
//  if ($("#fechaHoy2").length) {
//      var today = moment().format('DD/MM/YYYY');
//      window.onload = hora_reloj(fechahora_servidor);
//  }
//FIN HORA SERVER

function textoresponsive(elemento) {
  var el, elements, _i, _len, _results;
  elements = $(elemento);
  if (elements.length < 0) {
    return;
  }
  _results = [];
  for (_i = 0, _len = elements.length; _i < _len; _i++) {
    el = elements[_i];
    _results.push((function(el) {
      var resizeText, _results1;
      resizeText = function() {
        var elNewFontSize;
        elNewFontSize = (parseInt($(el).css('font-size').slice(0, -2)) - 1) + 'px';
        return $(el).css('font-size', elNewFontSize);
      };
      _results1 = [];
      while (el.scrollHeight > el.offsetHeight) {
        _results1.push(resizeText());
      }
       return _results1;
    })(el));
  }
  return _results;
};
////BUSCARTICKET   E  IMPRIMIR PAGO
function BuscarTicket(ticketobjeto){
    $.ajax({
        type: 'POST',
        async:false,
        url: basePath + 'BuscarTicket',
         data: {
            '_token': $('input[name=_token]').val(),
            'datos':ticketobjeto
        },
        success: function (response) {
                $("#modal_imprimir_pago #imagen_apuestatotal").attr("src",basePath+"img/logo.png")

            ticketbuscado=response.ticketbuscado;
            ticketsganadores=response.tickets;
            resultados_evento=response.resultados_evento;
            
             ganadores="";
             if(ticketsganadores.length>0){

                if(ticketsganadores[0].estadoTicket==0){toastr.error("Ticket Anulado");return false;}
                if(ticketsganadores[0].estadoTicket==2){toastr.error("Ticket Pagado");return false;}
                if(ticketsganadores[0].estadoTicket==3){toastr.error("Ticket Suspendido");return false;}

                GuardarGanadorEvento(ticketsganadores,ticketsganadores[0].idTicket);

                TICKET_IMPRIMIR_pago={};
                TICKET_IMPRIMIR_pago.ImagenSrc=eventoactual.Imagen
                TICKET_IMPRIMIR_pago.Id_Ticket=ticketsganadores[0].idTicket;
                TICKET_IMPRIMIR_pago.Id_Unidad=aperturacajadatos.cc_id //eventoactual.IdEvento;
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

                $(ticketsganadores).each(function(i,e){
                     ganadores=ganadores+"<br> "+e.TipoPagoNombre+" "+e.TipoApuestaValor;
                })
                toastr.success(" Ticket "+ticketbuscado +" Evento "+ticketobjeto.nombre+" <br>Apuestas Ganadoras:" +ganadores);
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
        url: basePath + 'GuardarGanadorEvento',
         data: {
            '_token': $('input[name=_token]').val(),
            'apuestas':apuestas_ganadoras,
            'idTicket':idTicket
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
    TicketObjeto.idAperturaCaja=aperturacajadatos.idAperturaCaja;
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
        async:false,
        url: basePath + 'GuardarTicket',
         data: {
            '_token': $('input[name=_token]').val(),
            'datos':datosobjeto
        },

        success: function (response) {
            ticketdata=response.id_ticketinsertado;
            idticket=ticketdata.idTicket;
                ImprimirJson(ticketobjeto_imprimir,idticket);

            $("#divimpresion #IDTique").text(idticket);
            $("#modal_imprimir").modal("show");

          

            // TICKET_IMPRIMIR={}

            toastr.success("Ticket Guardado");
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

function ListarVentaDatosJson() {
    $.ajax({
        type: 'POST',async:false,
        url: basePath + 'VentaDatosJson',
        data: {
            '_token': $('input[name=_token]').val(),
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

             divdatos=$("#datoscaja");
             $.each(aperturacajadatos,function(col,valor){
                    $("#"+col,divdatos).val(valor).attr("readonly","readonly");
             })
            ////fin apertura caja datos
            ///conf_eventos
            eventos=response.eventos;

             if(eventos.length==0){
                toastr.error("No hay Eventos Registrados","Error");
                return false;
            }
                $(eventos).each(function(i,e){
                          $("#div_configuracioneventos .eventos_fila_izq").append(
                            $("<div>")
                                .addClass("configuracioneventosdiv")
                                .data("id",e.idEvento)
                                .data("nombre",e.nombre)
                                .data("apuestaMinima",e.apuestaMinima)
                                .data("apuestaMaxima",e.apuestaMaxima)
                                .data("FechaEvento",e.FechaEvento)
                                .data("fechaFinEvento",e.fechaFinEvento)
                                .data("segBloqueoAntesEvento",e.segBloqueoAntesEvento)
                                .data("idMoneda",e.idMoneda)

                                //.text(e.nombre)  

                                .append(
                                        $("<div>").attr("style","width: 30%; height: 100%;float:left;position:relative")
                                        .append(
                                            $("<img>").attr("style","width:70%;height:80%;position: absolute; left: 50%; transform: translate(-50%, -50%); top: 50%;").attr("src",basePath+"img/juegos/"+e.logo)
                                            )
                                    )  
                                 .append(
                                        $("<div>").attr("style","width: 70%; height: 100%;float:left;display:flex;align-items:center").text(e.nombre).addClass("eventotextodiv")
                                    )              
                                );
                })
             ///fin conf_eventos 
             ///apuestas
            // apuestas=response.apuestas;
                $(dinerodefault).each(function(i,e){
                          $("#div_apuestas").append(
                            $("<div>")
                                 .addClass("rowapuestasdiv")
                                // .data("id","#"+e.idConfiguracionEvento)
                                 .data("valor",e.monto)
                                 .data("tipo","apuesta")
                                 .attr("data-tipo","apuesta")
                                // .data("apuestaMinima",e.apuestaMinima)
                                // .data("apuestaMaxima",e.apuestaMaxima)
                                .text(e.monto)                
                                );
                })
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

function JackpotDatosJson(puntoventa){
        $.ajax({
        type: 'POST',async:false,
        url: basePath + 'JackpotDatosJson',
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

function EventoDatosJson(idEvento,idPuntoVenta,segundosantesbloqueo) {
    IDPUNTOVENTA=idPuntoVenta;
    SEGBLOQUEOANTESEVENTO=segundosantesbloqueo;
    $.ajax({
        type: 'POST',async:false,
        url: basePath + 'EventoDatosJson',
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

////////PROXIMO EN
            fechaFinEvento=eventodatos.fechaFinEvento;
           //proxima_fecha=moment(eventodatos.FechaEvento, "YYYY-MM-DD HH:mm:ss a");
            proxima_fecha=moment(eventodatos.fechaFinEvento, "YYYY-MM-DD HH:mm:ss a");
            ahora=moment(hora_servidor, "YYYY-MM-DD HH:mm:ss a");
             minutos=proxima_fecha.diff(ahora,'minutes');
             segundos=proxima_fecha.diff(ahora.add(minutos,"minutes"),'seconds');
            //var segundos=0;//proxima_fecha.diff(ahora,'seconds');
            //var timer2 = minutos+":01";//"5:01";
            var timer2 = minutos+":"+segundos;
            console.log(fechaFinEvento + " "+ hora_servidor+  "  - "+timer2 );
            if(minutos<0)
            console.error("fechaFinEvento MENOR a hora_servidor => "+ fechaFinEvento +" < " +hora_servidor );

            if(typeof interval!="undefined"){
                clearInterval(interval);$('.countdown').html("00:00")
            }
            interval = setInterval(function() {
                      var timer = timer2.split(':');
                      var minutes = parseInt(timer[0], 10);
                      var seconds = parseInt(timer[1], 10);
                      --seconds;
                      minutes = (seconds < 0) ? --minutes : minutes;
                      if (minutes < 0) clearInterval(interval);
                      seconds = (seconds < 0) ? 59 : seconds;
                      seconds = (seconds < 10) ? '0' + seconds : seconds;
///////segundos bloqueo
                      if(minutes==0 && seconds==SEGBLOQUEOANTESEVENTO){
                         $.LoadingOverlay("show");
                      }
                      else{
                         segundostotales= parseInt((parseInt(minutes)*60))+parseInt(seconds);
                        if(segundostotales==SEGBLOQUEOANTESEVENTO){
                            $.LoadingOverlay("show");
                        }

                      }
                      if(minutes==0 && seconds==1){
                        $.LoadingOverlay("hide");
                          location.reload(true)
                      }
//fin segundos bloqueo
                      $('.countdown').html(minutes + ':' + seconds);
                      timer2 = minutes + ':' + seconds;
            }, 1000)
////////FIN PROXIMO EN

////multiplicadores definir
///fin multiplicadores
////PLENO
    var div_zero=$(".rectangulo_izquierda");
    var valorzero=$(div_zero).text();
    var colorzero="";var cuotazero="";
     $(tipoapuesta).each(function(ii,ee){
                    var valorapuesta=ee.valorapuesta;
                    if(ee.idTipoPago==6 && valorapuesta.toString()=="0"){
                        color=ee.rgb;
                        cuota=ee.multiplicadorDefecto;
                    }
    });
    $(div_zero).css("background-color",color);
    $(div_zero).attr("data-cuota",cuota);
    $(div_zero).attr("data-idtipoapuesta",100);


    $("#numeros_tabla .numeros_rect DIV").each(function(i,e){
            var valor=$(e).text();
            var color="";
            var cuota="";
            var idtipoapuesta="";

            $(tipoapuesta).each(function(ii,ee){
                    var valorapuesta=ee.valorapuesta;
                    if(ee.idTipoPago==1&&valorapuesta.toString()==valor.toString()){
                        color=ee.rgb;
                        cuota=ee.multiplicadorDefecto;
                        idtipoapuesta=ee.idTipoApuesta;
                    }
            })  
            $(e).css("background-color",color);
            $(e).attr("data-cuota",cuota);
            $(e).attr("data-idtipoapuesta",idtipoapuesta);
    })

   $(".numeros_rango2 [data-tipo='color']").each(function(i,e){
            var valor=$(e).text();
            var color="";var cuota="";
            var idtipoapuesta="";
            $(tipoapuesta).each(function(ii,ee){
                    var valorapuesta=ee.valorapuesta;
                    if(ee.idTipoPago==2 && valorapuesta.toString()== $(e).data("valor")){
                        color=ee.rgb;
                        cuota=ee.multiplicadorDefecto;
                        idtipoapuesta=ee.idTipoApuesta;

                    }
            })  
            $(e).css("background-color",color);
            $(e).attr("data-cuota",cuota);
            $(e).attr("data-idtipoapuesta",idtipoapuesta);

    })

    // $(".numeros_rango2 [data-tipo='rojos']").each(function(i,e){
    //         var valor=$(e).text();
    //         var color="";var cuota="";
    //         $(tipoapuesta).each(function(ii,ee){
    //                 var valorapuesta=ee.valorapuesta;
    //                 if(ee.idTipoPago==2 && valorapuesta.toString()== $(e).data("valor")){
    //                     color=ee.rgb;
    //                     cuota=ee.multiplicadorDefecto;
    //                 }
    //         })  
    //         $(e).css("background-color",color);
    //         $(e).attr("data-cuota",cuota);

    // })
    // $(".numeros_rango2 [data-tipo='negros']").each(function(i,e){
    //         var valor=$(e).text();
    //         var color="";var cuota="";
    //         $(tipoapuesta).each(function(ii,ee){
    //                 var valorapuesta=ee.valorapuesta;
    //                 if(ee.idTipoPago==2 && valorapuesta.toString()== $(e).data("valor")){
    //                     color=ee.rgb;
    //                     cuota=ee.multiplicadorDefecto;
                     
    //                 }
    //         })  
    //         $(e).css("background-color",color);
    //         $(e).attr("data-cuota",cuota);
    // })

    $(".numeros_rango div").each(function(i,e){
        var valor=$(e).text();
            var color="";var cuota="";
            var idtipoapuesta="";
            $(tipoapuesta).each(function(ii,ee){
                    var valorapuesta=ee.valorapuesta;
                    var nombreapuesta=ee.nombre;

                    if(ee.idTipoPago==4 && nombreapuesta.toString()==$(e).data("valor") ){
                        cuota=ee.multiplicadorDefecto;
                        idtipoapuesta=ee.idTipoApuesta;
                    }
            })  
            $(e).attr("data-cuota",cuota);
            $(e).attr("data-idtipoapuesta",idtipoapuesta);

    })

    $(".numeros_rango2 div:not('.rectangulo_negro'):not('.rectangulo_rojo')").each(function(i,e){
        var valor=$(e).text();
        var idtipopago=$(e).data("idtipopago")
            var color="";var cuota="";
            var idtipoapuesta="";
            $(tipoapuesta).each(function(ii,ee){
                    var valorapuesta=ee.valorapuesta;
                    var nombreapuesta=ee.nombre;
                    if(idtipopago.toString()==(ee.idTipoPago).toString() && nombreapuesta.toString()==$(e).data("valor") ){
                        cuota=ee.multiplicadorDefecto;
                        idtipoapuesta=ee.idTipoApuesta;
                    }
            })  
            $(e).attr("data-cuota",cuota);
            $(e).attr("data-idtipoapuesta",idtipoapuesta);

    })
        //FIN PLENO

        ////jackpot
        JackpotDatosJson($("#idPuntoVenta").val());
        intervalojackpot=setInterval(function(){
            JackpotDatosJson($("#idPuntoVenta").val());
        },14000)
        //HistorialJson(eventoactual.IdEvento);
        
        intervalohistorial=setInterval(function(){
        HistorialJson(eventoactual.IdEvento);

        },14000)
        ///fin jackpot

        },///FIN SUCCESS
    })
}///FIN EventoDatosJson


////ImprimirJson()  =>  al hacer click en boton PRINT;
function ImprimirJson(ticketobjeto_imprimir,idTicket){
//////genera codigoqr y codigo de barras desde php
   TICKET_IMPRIMIR=ticketobjeto_imprimir;
        ticketobjeto_imprimir.Id_Ticket=idTicket;
        $.ajax({
        type: 'POST',async:false,
        url: basePath + 'ImprimirDatosJson',
        data: {
            'TICKET_IMPRIMIR': ticketobjeto_imprimir,
            '_token': $('input[name=_token]').val(),
        },
        success: function (response) {
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

                $("#modal_imprimir #divimpresion .imagen img").attr("src",TICKET_IMPRIMIR.ImagenSrc)
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



function HistorialJson(idev) {
    $.ajax({
        type: 'POST',async:false,
        url: basePath + 'HistorialDatosJson',
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




$(document).ready(function () {

     DATOSVENTAJSON=ListarVentaDatosJson();

    $("#div_configuracioneventos .configuracioneventosdiv").on("click",function(){
                $("#div_configuracioneventos .configuracioneventosdiv").removeClass("seleccionadoevento");
                $(this).addClass("seleccionadoevento");

                if(typeof intervalojackpot!="undefined"){
                    clearInterval(intervalojackpot)
                } 
                if(typeof intervalohistorial!="undefined"){
                    clearInterval(intervalohistorial)
                } 
                $(".nombre_tituloconfiguracionevento ").text($(this).data("nombre"));
                $(".id_tituloconfiguracionevento ").text("#"+$(this).data("id"));

                EventoDatosJson($(this).data("id"),$("#idPuntoVenta").val(),$(this).data("segBloqueoAntesEvento"));
                eventoactual={};
                eventoactual.FechaEvento=$(this).data("FechaEvento");
                eventoactual.fechaFinEvento=$(this).data("fechaFinEvento");
                eventoactual.nombre=$(this).data("nombre");
                eventoactual.IdEvento=$(this).data("id");
                eventoactual.apuestaMinima=$(this).data("apuestaMinima");
                eventoactual.apuestaMaxima=$(this).data("apuestaMaxima");
                eventoactual.segBloqueoAntesEvento=$(this).data("segBloqueoAntesEvento");
                eventoactual.idMoneda=$(this).data("idMoneda");


                HistorialJson(eventoactual.IdEvento);


                var imagensrc=$("img",this).attr("src");
                eventoactual.Imagen=imagensrc;

                $("#modal_imprimir #imagen_apuestatotal").attr("src",basePath+"img/logo.png")
                $("#modal_imprimir #imagen_eventoactual").attr("src",$("img",this).attr("src"))
    })

    $("#div_configuracioneventos .eventos_fila_izq>div").eq(0).click();

        //HistorialJson(eventoactual.IdEvento);



/////botones numeros  SELECCIONADO CLASE
    //boton 0
    $(".rectangulo_izquierda").off().on("click",function(e){ 
            $(this).toggleClass("seleccionado") ;
        })
///fin boton 0
    $("#numeros_tabla [data-tipo='numero']").off().on("click",function(e){ 
            $(this).toggleClass("seleccionado") ;
        })
/////finbotones numeros
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
    $("#div_botones .check").on("click",function(){
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
            cantidadnumeros=$("#numeros_tabla .seleccionado, .rectangulo_izquierda.seleccionado").length;
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
            $("#numeros_tabla .seleccionado , .rectangulo_izquierda.seleccionado")
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
        $("#numeros_tabla .seleccionado").removeClass("seleccionado");

    })////FINNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNN on click boton check

        ///BOTON CERRAR  -- BORRAR
        $("#div_botones .cerrar").on("click",function(){
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
        /*    $("#tabla_eventos").DataTable(
        {
        "paging":   false,
        "ordering": false,
        "info":     false
        "searching": false
        }
        )*/

           ///BOTON BUSCAR
        $("#div_botones .barcode").on("click",function(){
             $("#modal_buscar").modal("show"); 
        })

        ///BOTON IMPRIMIR
        $("#div_botones .print").on("click",function(){
            if($("#tabla_eventos tbody tr").length=="0"){
                toastr.error("No hay Apuestas");
            }
            else{

                 $("#imagen_qrcode").attr("src","");
                $("#imagen_codigobarra").attr("src","");

                TICKET_IMPRIMIR={};
                TICKET_IMPRIMIR.ImagenSrc=eventoactual.Imagen
                TICKET_IMPRIMIR.Id_Ticket=0;
                TICKET_IMPRIMIR.Id_Unidad=aperturacajadatos.cc_id //eventoactual.IdEvento;
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

        $('.digitador .digito').on('click',function(){
             valor=$(this).text();
             valortxt=$("#ticket_txt").val();
            valortxt=valortxt+valor;
            $("#ticket_txt").val(valortxt);
        })

        $('.digitador .borrar').on('click',function(){
            var valortxt=$("#ticket_txt").val();
            valortxt=valortxt.substring(0,valortxt.length-1);
            $("#ticket_txt").val(valortxt);
        })
        

        $("#btn_buscar_ticket").on("click",function(e){
            e.preventDefault(); 
                objetobuscar={};
                objetobuscar.idEvento=eventoactual.IdEvento;
                objetobuscar.nombre=eventoactual.nombre;

                objetobuscar.idTicket=$("#ticket_txt").val().trim();
                // objetobuscar.idTipoApuesta=eventoactual.idTipoApuesta;
                BuscarTicket(objetobuscar);
                $("#ticket_txt").val("");
            
        })
        $("#buscar_div").on("click",function(e){
              e.preventDefault(); 
                $("#btn_buscar_ticket").click();
            
        })


        $("#modal_buscar").on("shown.bs.modal",function(){
                $("#modal_buscar #ticket_txt").focus();

        });



        responsivetombola()
});
