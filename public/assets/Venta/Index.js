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



function Imprimir(elem)
{
    console.log("Imprimiendi")
    var mywindow = window.open('', 'PRINT', 'height=400,width=600');

    // mywindow.document.write('<html><head><title>' + document.title  + '</title>');
    mywindow.document.write('</head><body >');
    //mywindow.document.write('<h1>' + document.title  + '</h1>');
    mywindow.document.write(document.getElementById(elem).innerHTML);
    mywindow.document.write('</body></html>');

    mywindow.document.close(); // necessary for IE >= 10
    mywindow.focus(); // necessary for IE >= 10*/

    mywindow.print();
    console.log("fin impresion")

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
            hora_servidor=response.hora_servidor;
            dinerodefault=response.dinerodefault;
            if(dinerodefault.length==0){
                toastr.error("No hay DineroDefault Registrados","Error");
                return false;
            }
            ////apertura caja datos
             resp = response.aperturacajadatos;
             resp=resp[0];
            if(resp.length==0){
                toastr.error("No hay AperturaCaja Registrado","Error");
                return false;
            }
             divdatos=$("#datoscaja");
             $.each(resp,function(col,valor){
                    $("#"+col,divdatos).val(valor).attr("readonly","readonly");

             })
            ////fin apertura caja datos
            ///conf_eventos
            eventos=response.eventos;
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
                                .data("segBloqueoAntesEvento",e.segBloqueoAntesEvento)

                                //.text(e.nombre)  

                                .append(
                                        $("<div>").attr("style","width: 30%; height: 100%;float:left;position:relative")
                                        // $("<div>").attr("style","width: 30%; height: 100%;display:inline-block")
                                        .append(
                                            $("<img>").attr("style","width:70%;height:80%;position: absolute; left: 50%; transform: translate(-50%, -50%); top: 50%;").attr("src",basePath+"img/juegos/"+e.logo)
                                            )
                                       //                  .attr("width",50)
                                       //                  .attr("height",40)
                                       // $("<span>")  .attr("style","vertical-align: middle;display: table-cell;")
                                       //          .append(
                                       //                  $("<img>").attr("src",basePath+"img/juegos/"+e.logo)
                                       //                  .attr("width",50)
                                       //                  .attr("height",40)
                                       //                  )
                                    )  
                                 .append(
                                        // $("<div>").attr("style","width: 70%; height: 100%;display:inline-block").text(e.nombre).addClass("eventotextodiv")
                                        $("<div>").attr("style","width: 70%; height: 100%;float:left;display:flex;align-items:center").text(e.nombre).addClass("eventotextodiv")

                                   // $("<span>")  .attr("style","vertical-align: middle;display: table-cell;")
                                   //              .text(e.nombre)
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
           proxima_fecha=moment(eventodatos.FechaEvento, "YYYY-MM-DD HH:mm:ss a");
            ahora=moment(hora_servidor, "YYYY-MM-DD HH:mm:ss a");
            var minutos=proxima_fecha.diff(ahora,'minutes');
            var segundos=0;//proxima_fecha.diff(ahora,'seconds');
            var timer2 = minutos+":01";//"5:01";
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

    $("#numeros_tabla .numeros_rect DIV").each(function(i,e){
            var valor=$(e).text();
            var color="";var cuota="";
            $(tipoapuesta).each(function(ii,ee){
                    var valorapuesta=ee.valorapuesta;
                    if(ee.idTipoPago==1&&valorapuesta.toString()==valor.toString()){
                        color=ee.rgb;
                        cuota=ee.multiplicadorDefecto;
                     
                    }
            })  
            $(e).css("background-color",color);
            $(e).attr("data-cuota",cuota);
    })

   $(".numeros_rango2 [data-tipo='color']").each(function(i,e){
            var valor=$(e).text();
            var color="";var cuota="";
            $(tipoapuesta).each(function(ii,ee){
                    var valorapuesta=ee.valorapuesta;
                    if(ee.idTipoPago==2 && valorapuesta.toString()== $(e).data("valor")){
                        color=ee.rgb;
                        cuota=ee.multiplicadorDefecto;
                    }
            })  
            $(e).css("background-color",color);
            $(e).attr("data-cuota",cuota);

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
            $(tipoapuesta).each(function(ii,ee){
                    var valorapuesta=ee.valorapuesta;
                    if(ee.idTipoPago==4 ){
                        cuota=ee.multiplicadorDefecto;
                     
                    }
            })  
            $(e).attr("data-cuota",cuota);

    })

       $(".numeros_rango2 div").each(function(i,e){
        var valor=$(e).text();
        var idtipopago=$(e).data("idtipopago")
            var color="";var cuota="";
            $(tipoapuesta).each(function(ii,ee){
                    var valorapuesta=ee.valorapuesta;
                    if(idtipopago.toString()==(ee.idTipoPago).toString() ){
                        cuota=ee.multiplicadorDefecto;
                     
                    }
            })  
            $(e).attr("data-cuota",cuota);

    })
        //FIN PLENO

        ////jackpot
        JackpotDatosJson();
        intervalojackpot=setInterval(function(){
            JackpotDatosJson();
        },14000)
        HistorialJson();
        intervalohistorial=setInterval(function(){
            HistorialJson();
        },14000)
        ///fin jackpot

        },///FIN SUCCESS
    })
}///FIN EventoDatosJson

function ImprimirJson(){
        TICKET_IMPRIMIR={};
TICKET_IMPRIMIR.ImagenSrc=eventoactual.Imagen
TICKET_IMPRIMIR.Id_Ticket=297101120;
TICKET_IMPRIMIR.Id_Unidad=105432;
TICKET_IMPRIMIR.Nro_Evento=eventoactual.IdEvento;
TICKET_IMPRIMIR.Desc=eventoactual.nombre;

totales=sacar_totales_y_maximo();
TICKET_IMPRIMIR.TotalTicket=totales.total;
TICKET_IMPRIMIR.ImpresoEn=new Date().toLocaleString();
TICKET_IMPRIMIR.ImpresoPor="BTD ManuelLaguno"

TICKET_IMPRIMIR.PremioMaximoAPagar=parseFloat(totales.maximo).toFixed(2)+" "+divisa;
TICKET_IMPRIMIR.PremioMaximoPotencial=parseFloat(totales.total).toFixed(2)+" "+divisa;
        apuestas=[];
    $("#tabla_eventos tbody tr").each(function(i,e){
            fila_apuesta={};
            var tr=e;
            if($("td:eq(1)",tr).text()!=""){
                tipo= $(tr).data("tipo")
                valor= $(tr).data("valor")
                evento=$("td:eq(0)",tr).text();
                seleccion=$("td:eq(1)",tr).text();
                cuota=$("td:eq(2)",tr).text();
                apuesta=$("td:eq(3)",tr).text();
                fila_apuesta.evento=evento;
                fila_apuesta.descripcion=seleccion;
                fila_apuesta.cuota=cuota;
                fila_apuesta.apuesta=apuesta;
                apuestas.push(fila_apuesta);
            }
    })
    TICKET_IMPRIMIR.apuestas=apuestas;

            $.ajax({
            type: 'POST',async:false,
            url: basePath + 'ImprimirDatosJson',
            data: {
                'TICKET_IMPRIMIR': TICKET_IMPRIMIR,
                '_token': $('input[name=_token]').val(),
            },
            success: function (response) {
                    codigo_barrahtml=response.codigo_barrahtml;
                    qrcode_src=response.qrcode_src;
                    codigo_barra_src=response.codigo_barra_src;

                        $("#divimpresion #IDTique").text(TICKET_IMPRIMIR.Id_Ticket)
                        $("#divimpresion #IDUnidad").text(TICKET_IMPRIMIR.Id_Unidad)
                        $("#divimpresion #NroEvento").text(TICKET_IMPRIMIR.Nro_Evento)
                        $("#divimpresion #descripcion").text(TICKET_IMPRIMIR.Desc)
$("#divimpresion #datos_filas").empty()
                        $(TICKET_IMPRIMIR.apuestas).each(function(i,e){
                            $("#divimpresion #datos_filas").append($("<div>").attr("style","width:100%;display:table")
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

                        $("#divimpresion #total_ticket").text(TICKET_IMPRIMIR.total_ticket)
                        $("#divimpresion #impreso_en").text(moment(new Date()).format("YYYY-MM-DD HH:MM:SS"));
                        $("#divimpresion #impreso_por").text(TICKET_IMPRIMIR.ImpresoPor)
                        $("#divimpresion #PremioMaximoAPagar").text(TICKET_IMPRIMIR.PremioMaximoAPagar)
                        $("#divimpresion #PremioMaximoPotencial").text(TICKET_IMPRIMIR.PremioMaximoPotencial)


                    $("#divimpresion .imagen img").attr("src",TICKET_IMPRIMIR.ImagenSrc)
                    ///$("#codigo_barra").html(codigo_barrahtml);
                    $("#imagen_qrcode").attr("src","data:image/png;base64,"+qrcode_src);
                    $("#imagen_codigobarra").attr("src","data:image/png;base64,"+codigo_barra_src);


                    $("#modal_imprimir").modal("show");
                    $("#btnimprimir").off("click").on("click",function(){
                                setTimeout(function(){
                                    Imprimir("divimpresion");
                                },1000)
                    })
                    $("#btnimprimir").click()
            },
        })
}



function HistorialJson() {
    $.ajax({
        type: 'POST',async:false,
        url: basePath + 'HistorialDatosJson',
        data: {
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
}







$(document).ready(function () {

     ListarVentaDatosJson();

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
                eventoactual.nombre=$(this).data("nombre");
                eventoactual.IdEvento=$(this).data("id");
                eventoactual.apuestaMinima=$(this).data("apuestaMinima");
                eventoactual.apuestaMaxima=$(this).data("apuestaMaxima");
                eventoactual.segBloqueoAntesEvento=$(this).data("segBloqueoAntesEvento");

                var imagensrc=$("img",this).attr("src");
                eventoactual.Imagen=imagensrc;


    })

    $("#div_configuracioneventos .eventos_fila_izq>div").eq(0).click();
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
                toastr.error("Error","Seleccione Apuesta")
                return false;
            }
            cantidadnumeros=$("#numeros_tabla .seleccionado, .rectangulo_izquierda.seleccionado").length;
            if(cantidadnumeros==0)
            {
                toastr.error("Error","Seleccione Número")
                return false;
            }
            
    //        apuesta_fila=parseFloat(SUMAAPUESTAS/cantidadnumeros).toFixed(2);
            apuesta_fila=parseFloat(SUMAAPUESTAS).toFixed(2);

            if(apuesta_fila<1){
                toastr.error("Error","La apuesta no puede ser mínima al menor");
                 apuesta_fila=1;
            }
            array_apuestas_json=generar_json_apuestas();
            
            FILA_PARA_TABLA={};
            $("#numeros_tabla .seleccionado , .rectangulo_izquierda.seleccionado")
            // $("#numeros_tabla .seleccionado")
            .each(function(i,e){
               array_apuestas_json=generar_json_apuestas();
                valornumero=$(e).data("valor");
                tiponumero=$(e).data("tipo");
                colornumero=$(e).data("color");
                valornumero=$(e).data("valor");
                idtipopago=$(e).data("idtipopago");
                if(idtipopago.toString()=="2"){
                    valornumero=colornumero;
                }
                cuota=$(e).data("cuota");
                apostado=false;
                console.log(array_apuestas_json);

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
                                var totales_maximo=sacar_totales_y_maximo();
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
                    toastr.error("Ya apostado "+valornumero,"Error");
                }
            })///fin numerotabla seleccionados
        $("#numeros_tabla .seleccionado").removeClass("seleccionado");

    })////FINNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNN on click boton check
    


        ///BOTON CERRAR  -- BORRAR
        $("#div_botones .cerrar").on("click",function(){
            idtabla="tabla_eventos";
            $("tbody","#"+idtabla).empty();
            var totales_maximo=sacar_totales_y_maximo();
            $(".valorestotalmax #valor_total span").text("TOTAL: "+parseFloat(totales_maximo.total).toFixed(2)+" "+divisa);
            $(".valorestotalmax #valor_maximo span").text("MAX: "+parseFloat(totales_maximo.maximo).toFixed(2)+" "+divisa);
        })
        /*    $("#tabla_eventos").DataTable(
        {
        "paging":   false,
        "ordering": false,
        "info":     false
        "searching": false
        }
        )*/

        ///BOTON IMPRIMIR
        $("#div_botones .print").on("click",function(){
            if($("#tabla_eventos tbody tr").length=="0"){
                toastr.error("No hay Apuestas");
            }
            else{
                ImprimirJson();
            }
        })


responsivetombola()
   
});
