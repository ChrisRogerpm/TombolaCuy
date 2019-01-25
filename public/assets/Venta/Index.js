function ListarVentaDatosJson() {
    $.ajax({
        type: 'POST',async:false,
        url: basePath + 'VentaDatosJson',
        data: {
            '_token': $('input[name=_token]').val(),
        },
        success: function (response) {
            aaaa=response;

            hora_servidor=response.hora_servidor;
            ////apertura caja datos
             resp = response.aperturacajadatos;
             resp=resp[0];
             divdatos=$("#datoscaja");
             $.each(resp,function(col,valor){
                    $("#"+col,divdatos).val(valor).attr("readonly","readonly");

             })
            ////fin apertura caja datos
            ///conf_eventos
            eventos=response.eventos;
                $(eventos).each(function(i,e){
                          $("#div_configuracioneventos").append(
                            $("<div>")
                                .addClass("configuracioneventosdiv")
                                .data("id","#"+e.idEvento)
                                .data("nombre",e.nombre)
                                .data("apuestaMinima",e.apuestaMinima)
                                .data("apuestaMaxima",e.apuestaMaxima)
                                .data("FechaEvento",e.FechaEvento)
                                .text(e.nombre)                
                                );
                })
             ///fin conf_eventos 
             ///apuestas
            // apuestas=response.apuestas;
            apuestas=[];
            apuestas.push(1);   apuestas.push(10);            apuestas.push(1);
            apuestas.push(1);   apuestas.push(1);apuestas.push(1);            apuestas.push(1);apuestas.push(1);
                $(apuestas).each(function(i,e){
                          $("#div_apuestas").append(
                            $("<div>")
                                 .addClass("rowapuestasdiv")
                                // .data("id","#"+e.idConfiguracionEvento)
                                 .data("valor",e)
                                 .data("tipo","apuesta")
                                 .attr("data-tipo","apuesta")
                                // .data("apuestaMinima",e.apuestaMinima)
                                // .data("apuestaMaxima",e.apuestaMaxima)
                                .text(e/*e.nombre*/)                
                                );
                })
             ///fin apuestas  
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
        $(".nombre_tituloconfiguracionevento ").text($(this).data("nombre"));
        $(".id_tituloconfiguracionevento ").text($(this).data("id"));

        eventoactual={};
        eventoactual.FechaEvento=$(this).data("FechaEvento");
        eventoactual.nombre=$(this).data("nombre");
        eventoactual.IdEvento=$(this).data("id");
        eventoactual.apuestaMinima=$(this).data("apuestaMinima");
        eventoactual.apuestaMaxima=$(this).data("apuestaMaxima");


        proxima_fecha=moment(eventoactual.FechaEvento, "YYYY-MM-DD HH:mm:ss a");
        //ahora=moment(moment().format('YYYY-MM-DD')+" "+$("#liveclock").text(), "YYYY-MM-DD HH:mm:ss a");
        ahora=moment(hora_servidor, "YYYY-MM-DD HH:mm:ss a");

        hora_servidor
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
                  $('.countdown').html(minutes + ':' + seconds);
                  timer2 = minutes + ':' + seconds;
        }, 1000)

    })

    //$("#div_configuracioneventos div").eq(0).click();
/////botones numeros
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
            $("#numeros_tabla [data-tipo='negros']").off().on("click",function(e){ 
                $(this).toggleClass("seleccionado") ;
            })
            $("#numeros_tabla [data-tipo='rojos']").off().on("click",function(e){ 
               $(this).toggleClass("seleccionado") ;
            })
    
   $("#div_apuestas [data-tipo='apuesta']").off().on("click",function(e){ 
            $(this).toggleClass("seleccionadoapuesta") ;


         var SUMAAPUESTAS=0;
        $("#div_apuestas .seleccionadoapuesta").each(function(ii,ee){
            SUMAAPUESTAS=SUMAAPUESTAS+$(ee).data("valor");
        })
        $(".rowtableeventos_footer_apuesta").text("APUESTA "+SUMAAPUESTAS+" S/.");
    })


/////BOTONESSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSS

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
        cantidadnumeros=$("#numeros_tabla .seleccionado").length;
        if(cantidadnumeros==0)
        {
            toastr.error("Error","Seleccione Número")
            return false;
        }
        
        apuesta_fila=parseFloat(SUMAAPUESTAS/cantidadnumeros).toFixed(2);
        if(apuesta_fila<1){
            toastr.error("Error","La apuesta no puede ser mínima al menor");
             apuesta_fila=1;
        }
        array_apuestas_json=generar_json_apuestas();
        
        FILA_PARA_TABLA={};
        $("#numeros_tabla .seleccionado").each(function(i,e){
           array_apuestas_json=generar_json_apuestas();
            valornumero=$(e).data("valor");
            tiponumero=$(e).data("tipo");
            colornumero=$(e).data("color");
            valornumero=$(e).data("valor");
            apostado=false;
            console.log(array_apuestas_json);

            $(array_apuestas_json).each(function(ii,ee){
                if((ee.SELECCION).toString()==valornumero.toString()){
                    apostado=true;
                }
            })
            console.log("apostado"+apostado+" "+valornumero)
            if(!apostado){   ////SI NO FUE APOSTADO AUN SE  AGREGA TR A TABLA 
                cuota=tiponumero=="numero"?10:tiponumero=="rango"?10:tiponumero=="pares"?11:tiponumero=="impares"?14:15;
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
                                                .append($("<div>").addClass("divcerrarfila").append($('<i class="icon icon-inline fa fa-close"></i>')))
                                        )
                        )
                     $(".divcerrarfila").off("click").on("click",function(){

                        $(this).closest("tr").remove();
                         var totales_maximo=sacar_totales_y_maximo();
                $(".valorestotalmax #valor_total span").text("TOTAL: "+parseFloat(totales_maximo.total).toFixed(2)+" S/.");
                $(".valorestotalmax #valor_maximo span").text("MAX: "+parseFloat(totales_maximo.maximo).toFixed(2)+" S/.");
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
                $(".valorestotalmax #valor_total span").text("TOTAL: "+parseFloat(totales_maximo.total).toFixed(2)+" S/.");
                $(".valorestotalmax #valor_maximo span").text("MAX: "+parseFloat(totales_maximo.maximo).toFixed(2)+" S/.");

            }
            else{
                toastr.error("Ya apostado "+valornumero,"Error");
            }
        })///fin numerotabla seleccionados
    $("#numeros_tabla .seleccionado").removeClass("seleccionado");

})////fin on click boton check
    


///BOTON CERRAR
$("#div_botones .cerrar").on("click",function(){

      idtabla="tabla_eventos";

      $("tbody","#"+idtabla).empty();
        var totales_maximo=sacar_totales_y_maximo();

                $(".valorestotalmax #valor_total span").text("TOTAL: "+parseFloat(totales_maximo.total).toFixed(2)+" S/.");
                $(".valorestotalmax #valor_maximo span").text("MAX: "+parseFloat(totales_maximo.maximo).toFixed(2)+" S/.");
})
/*    $("#tabla_eventos").DataTable(
{
   "paging":   false,
        "ordering": false,
        "info":     false
     "searching": false
}
        )*/

   
});
