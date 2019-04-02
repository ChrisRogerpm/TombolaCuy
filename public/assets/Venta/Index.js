IPSERVIDOR_WEBSOCKETS="35.237.208.5";
PUERTO_WEBSOCKETS="50051";
// IPSERVIDOR_WEBSOCKETS="192.168.1.60";
// PUERTO_WEBSOCKETS="9004";

USUARIO=$(".user-name").text();
CC_ID=$("#cc_id").val();
IDAPERTURACAJA=$("#idAperturaCaja").val();
/////fin responsive tombolacuy
$(document).ready(function () {
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
    $("#div_configuracioneventos .configuracioneventosdiv").on("click",function(){
        $(".TOMBOLACUY").css("cursor","wait");
                $("#div_configuracioneventos .configuracioneventosdiv").removeClass("seleccionadoevento");
                $(this).addClass("seleccionadoevento");
                 if(typeof intervaloihistorialjackpot!="undefined"){
                    clearInterval(intervaloihistorialjackpot)
                } 
                $(".nombre_tituloconfiguracionevento ").text($(this).data("nombre"));
                $(".id_tituloconfiguracionevento ").text("#"+$(this).data("id"));
                EventoDatosJson($(this).data("id"),$("#idPuntoVenta").val(),$(this).data("segbloqueoantesevento"));///DATOS jugador,divisa,jackpot
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
        //mover_barra();
    $(".TOMBOLACUY").show();
        responsivetombola();
        $(window).resize(function () {
                responsivetombola();
                heighttbody=$(".rowtablaeventos").height()-$("#tabla_eventos thead").height()     
                $("#tabla_eventos tbody").height(heighttbody)


            }).trigger('resize');
});////fin document funciton


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




