// IPSERVIDOR_WEBSOCKETS="35.237.208.5";
// PUERTO_WEBSOCKETS="50051";
// IPSERVIDOR_WEBSOCKETS="35.184.46.33";
// // PUERTO_WEBSOCKETS="4555";
// PUERTO_WEBSOCKETS="888";

IPSERVIDOR_WEBSOCKETS=$("#IPSERVIDOR_WEBSOCKETS").val();
PUERTO_WEBSOCKETS=$("#PUERTO_WEBSOCKETS").val();


USUARIO=$(".user-name").text();
CC_ID=$("#cc_id").val();
IDAPERTURACAJA=$("#idAperturaCaja").val();
/////fin responsive tombolacuy
$(document).ready(function () {
    INICIAR()
       
});////fin document funciton

function INICIAR(){
 ////activar reloj sin websockets   
        //     if ($("#fechaHoy").length) {
        //     var today = moment().format('DD/MM/YYYY');
        //     //document.getElementById("fechaHoy").innerHTML = today;
        //     window.onload = show5;
        // }
        ///reloj sin websockets
            // $.LoadingOverlay("show");
            // DATOSVENTAJSON=ListarVentaDatosJson();
    /////////onClick de Eventos 
    $("#div_configuracioneventos .configuracioneventosdiv").off("click").on("click",function(){
        $(".TOMBOLACUY").css("cursor","wait");
                $("#div_configuracioneventos .configuracioneventosdiv").removeClass("seleccionadoevento");
                $(this).addClass("seleccionadoevento");
                 if(typeof intervaloihistorialjackpot!="undefined"){
                    clearInterval(intervaloihistorialjackpot)
                } 
                $(".nombre_tituloconfiguracionevento ").text($(this).data("nombre"));
                $(".id_tituloconfiguracionevento ").text("#"+$(this).data("id"));
                EventoDatosJsonNuevo(this,$(this).data("id"),$("#idPuntoVenta").val(),$(this).data("segbloqueoantesevento"));
                
                $("#modal_imprimir #divimpresion .imagen img").attr("src","img/juegos/"+$(this).data("logo"))

                //EventoDatosJson($(this).data("id"),$("#idPuntoVenta").val(),$(this).data("segbloqueoantesevento"));///DATOS jugador,divisa,jackpot
                //, inicia setinterval de historialyjackpot 
                //, inicia reloj y contador
                //, carga imagenes de logo de evento
                //, muestra  .TOMBOLACUY
        //         eventoactual={};
        //         eventoactual.FechaEvento=$(this).data("fechaevento");
        //         eventoactual.fechaFinEvento=$(this).data("fechafinevento");
        //         eventoactual.nombre=$(this).data("nombre");
        //         eventoactual.IdEvento=$(this).data("id");
        //         eventoactual.apuestaMinima=$(this).data("apuestaminima");
        //         eventoactual.apuestaMaxima=$(this).data("apuestamaxima");
        //         eventoactual.segBloqueoAntesEvento=$(this).data("segbloqueoantesevento");
        //         eventoactual.idMoneda=$(this).data("idmoneda");
        //         var imagensrc=$("img",this).attr("src");
        //         eventoactual.Imagen=imagensrc;
        //         // $("#modal_imprimir #imagen_apuestatotal").attr("src",basePath+"img/logo.png");
        //         $("#modal_imprimir #imagen_eventoactual").attr("src",$("img",this).attr("src"));

        //          horaserv=ServerDate();horaserv= new Date(horaserv);
        //         reloj_servidor(horaserv,eventodatos.fechaFinEvento,eventodatos.segBloqueoAntesEvento);
        // $(".TOMBOLACUY").css("cursor","");

        //         $(".TOMBOLACUY").show();

    })
    //// FIN  Onclick eventos
    setTimeout(function(){
        $("#div_configuracioneventos .eventos_fila_izq>div").eq(0).click();
    },0)
        //HistorialJson(eventoactual.IdEvento);
    eventos_botones(); ////botones 1-22, rangos, colores ,  botones apuestas(1,2,4,5,10,20,50,100)  , botones check, x, buscar,imprimir
    eventos_botones_modalbuscar(); ///botones del modal buscar=>  1-9 , buscar
    $(".TOMBOLACUY").show();
    responsivetombola();
    $(window).resize(function () {
            responsivetombola();
            heighttbody=$(".rowtablaeventos").height()-$("#tabla_eventos thead").height()     
            $("#tabla_eventos tbody").height(heighttbody)


    }).trigger('resize');

}




function CargarTabla() {


    $.ajax({
        type: 'POST',
        url: basePath + 'CajaTablaFk',
        data: {
            '_token': $('input[name=_token]').val(),
        },
        beforeSend:function(){
             // RECONECTAR_WEBSOCKET=false;socket.close();
                $.LoadingOverlay("show");
        },
        success: function (response) {
            $('.modal').modal('hide');
            //if($(".modal-backdrop").length>0){$(".modal-backdrop").hide()}
          //    RECONECTAR_WEBSOCKET=true;
            $(".content.container-fluid").html(response.html);
            INICIAR();
            $.LoadingOverlay("hide");

        },
       error: function (jqXHR, textStatus, errorThrown) {
                toastr.error("Error de Conexión a Servidor");
                $.LoadingOverlay("hide");
                setTimeout(function(){CargarTabla()},1000)
        
        }
    })
}

function CargarAperturaCaja(){
window.location=basePath+"AperturaCajaListar";

}
function CargarCierreCaja(){
window.location=basePath+"ReporteCierraVentaVista";

}



