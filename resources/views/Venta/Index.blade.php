@extends('Shared.layout')

@section('body-class')
    sidebar-style loaded
@stop
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-primary">
                <div class="panel-body" style="padding-bottom: 10px;">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="block">
                                <div class="block-content-outer">
                                    <div class="block-content-inner">
                                        <div class="row">
                                            <div class="col-md-12 col-xs-12 col-sm-12">
                                                <h6>
                                                    <i class="glyphicon glyphicon-th mr-2"></i>
                                                    Venta Caja    
                                                </h6>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

 <div class="row">
        <div class="col-md-12">
            <div class="panel panel-primary">
                <div class="panel-body" id="datoscaja">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <div class="input-group">
                                    <div class="input-group-addon bg-primary text-white">TIENDA</div>
                                     <input type="text" class="form-control input-sm" id="tienda"  value="{{ $aperturacajadatos->tienda }}" readonly>
                                     <input type="hidden" class="form-control input-sm" id="idPuntoVenta" value="{{ $aperturacajadatos->idPuntoVenta }}" >
                                     <input type="hidden" class="form-control input-sm" id="idAperturaCaja" value="{{ $aperturacajadatos->idAperturaCaja }}" >
                                     <input type="hidden" class="form-control input-sm" id="cc_id" value="{{ $aperturacajadatos->cc_id }}" >
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <div class="input-group">
                                    <div class="input-group-addon bg-primary text-white">CAJA</div>
                                   <input type="text" class="form-control input-sm" id="caja" value="{{ $aperturacajadatos->caja }}" readonly>
                                </div>
                            </div>
                        </div>
                        
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <div class="input-group">
                                    <div class="input-group-addon bg-primary text-white">FECHA</div>
                                    <input type="text" class="form-control input-sm" id="fechaOperacion"  value="{{ $aperturacajadatos->fechaOperacion }}"  readonly>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <div class="input-group">
                                    <div class="input-group-addon bg-primary text-white">TURNO</div>
                                    <input type="text" class="form-control input-sm" id="turno" value="{{ $aperturacajadatos->turno }}" readonly>
                                </div>
                            </div>
                        </div>

                    </div>
                  
                </div>
            </div>
        </div>

    </div>


    <div class="row">


        <div class="col-md-12">
            <div class="panel panel-primary">
                <div class="panel-body">
                    <DIV class="TOMBOLACUY" style="height:83vh;display:none">
                        <div class=" rowcabecera">
                            
                                <div class=" rowcabecera_nombres">
                                                <div style="width:20%" class="">
                                                    HORA
                                                </div>

                                                <div style="width:15%"class="">
                                                PRÓXIMO EN
                                                </div>
                                                <div style="width:15%"class="">
                                                JUGADOR
                                                </div>
                                                <div style="width:15%" class="">
                                                DIVISA
                                                </div>
                                                  <div style="width:35%;text-align:right" class="">
                                                JACKPOT
                                                </div>
                                 </div>

                                <div class=" rowcabecera_datos" id="row_datosevento">
                                        <div style="width:20%;display:block" class="" >
<div style="display:flex;width:100%">
                                            <div id="fechaServidor" style="display:flex;width:50%;border:0" ></div>
                                            <div id="progreso" style="padding: 0;display:block;float:right;width: 40%;margin:auto;height:65%; background:rgba(0, 0, 0, 0) linear-gradient(to right,#2196f3, #8bc34a, #f44336) repeat scroll 0 0">

                                                <div id="barra_loading" style="float:right;width:100%;height:100%;background-color:green;"></div>
</div>
                                            </div>
                                        </div>

                                        <div style="width:15%" class="">
                                            <!-- <span id="proximo_en" class="countdown">-</span> |  -->
                                            <span id="proximo_en2" class="countdown">-</span>
                                        </div>
                                        <div style="width:15%" class="">
                                            <span id="jugador" >-</span>

                                        </div>
                                        <div style="width:15%" class="">
                                            <span id="divisa" >-</span>

                                        </div>
                                        <div style="width:35%;text-align:right" class="">
                                            <span id="jackpotsuma" >0.00</span>
                                        </div>
                                </div>
                        </div>


                        <div class=" row_medio">
                                <div class="columna_principalizquierda"  >

                                    <div class="row_pleno" >
                                        <div class="div_pleno">PLENO</div>
                                    </div>
                                    <div class="contenedor_tablaprincipal" >


                                              <div class="" style="height:100%" id="columna_izq">
                                                    <div class="" style="height:65%">
                                                        <div class="rectangulo_izquierda"
                                                        data-idTipoPago="6"
                                                        data-tipo="zero" data-color="verde" data-valor=0
                                                        style="background-color:{{$divzero->rgb}}"
                                                        data-cuota="{{$divzero->multiplicadorDefecto}}"
                                                        data-idTipoApuesta="{{$divzero->idTipoApuesta}}"

                                                        ></div>
                                                    </div>
                                                    <div class=""  style="height:35%">
                                                        <div class="rectangulo_izquierda2"></div>
                                                    </div>
                                              </div>
                                               <div class="" id="numeros_tabla">
                                                <!--TABLA DE NUMEROS PRINCIPAL-->
                                                <div class=" numeros_rect">
                                                         @foreach($primerafila as $div) 
                                                                   <div 
                                                                    data-idTipoPago="{{$div->idTipoPago}}" 
                                                                    data-idTipoApuesta="{{$div->idTipoApuesta}}" 
                                                                    style="background-color:{{$div->rgb}}" 
                                                                    data-tipo="numero" 
                                                                    data-color="{{$div->rgb}}"
                                                                    data-valor={{$div->valorapuesta}} 
                                                                    data-cuota={{$div->multiplicadorDefecto}} 
                                                                    >{{$div->valorapuesta}}</div>
                                                            @endforeach
                                                </div>

                                                <div class=" numeros_rect">
                                                 
                                                   @foreach($segundafila as $div) 
                                                       <div 
                                                         data-idTipoApuesta="{{$div->idTipoApuesta}}" 
                                                        data-idTipoPago="{{$div->idTipoPago}}" 
                                                        style="background-color:{{$div->rgb}}" 
                                                        data-tipo="numero" 
                                                        data-color="{{$div->rgb}}"
                                                        data-valor={{$div->valorapuesta}} 
                                                        data-cuota={{$div->multiplicadorDefecto}} 
                                                        >{{$div->valorapuesta}}</div>
                                                     @endforeach

                                                </div>
                                                <div class=" numeros_rect">
                                                            
                                                    @foreach($tercerafila as $div) 
                                                           <div 
                                                         data-idTipoApuesta="{{$div->idTipoApuesta}}" 
                                                            data-idTipoPago="{{$div->idTipoPago}}" 
                                                            style="background-color:{{$div->rgb}}" 
                                                            data-tipo="numero" 
                                                            data-color="{{$div->rgb}}"
                                                            data-valor={{$div->valorapuesta}} 
                                                            data-cuota={{$div->multiplicadorDefecto}} 
                                                            >{{$div->valorapuesta}}</div>
                                                     @endforeach
                                                </div>

                                                <div class=" numeros_rango">

                                                      @foreach($cuartafila as $div) 
                                                       <div 
                                                         data-idTipoApuesta="{{$div->idTipoApuesta}}" 
                                                        data-idTipoPago="{{$div->idTipoPago}}" 
                                                        style="background-color:{{$div->rgb}}" 
                                                        data-tipo="rango" 
                                                        data-color="{{$div->rgb}}"
                                                        data-valor={{$div->nombre}} 
                                                        data-cuota={{$div->multiplicadorDefecto}} 
                                                        >{{$div->nombre}}</div>
                                                     @endforeach

                                 

                                                </div>

                                                <div class=" numeros_rango2">

                                                     @foreach($quintafila as $div) 
                                                       <div 
                                                         data-idTipoApuesta="{{$div->idTipoApuesta}}" 
                                                        data-idTipoPago="{{$div->idTipoPago}}" 
                                                        style="background-color:{{$div->rgb}}" 
                                                        <?php if($div->idTipoApuesta==107 || $div->idTipoApuesta==108){$tipo="rango";}
                                                                else if($div->idTipoApuesta==101 ){$tipo="pares";}
                                                                else if($div->idTipoApuesta==102 ){$tipo="impares";}
                                                                else if($div->idTipoApuesta==25 || $div->idTipoApuesta==26 ){$tipo="color";}
                                                        ?>
                                                        data-tipo="{{$tipo}}" 

                                                        <?php if($tipo=="color"){
                                                            $datacolor=$div->nombre;}else{
                                                                $datacolor=$div->rgb;
                                                            }
                                                        ?>

                                                        data-color="{{$datacolor}}"
                                                        data-valor={{$div->nombre}} 
                                                        data-cuota={{$div->multiplicadorDefecto}} 
                                                        >{{$div->nombre}}</div>
                                                     @endforeach
                                                            }
                                                </div>

                                                <!--  <div class="rowhistorial">
                                       <div class="historial">HISTORIAL</div>
                                  </div>-->

                                            </div><!--div col 10-->


                                            <div class="" style="height:100%" id="columna_der">
                                                    <div class="" style="height:65%">
                                                        <div class="rectangulo_derecha"></div>
                                                    </div>
                                                    <div class=""  style="height:35%">
                                                        <div class="rectangulo_derecha2"></div>
                                                    </div>
                                              </div>
                                              
                                              <!-- <div class="col-xs-12 col-md-1"></div> -->
                                    </div><!--contenedor_tablaprincipal-->


                                    <div class=" rowhistorial"><div class="historialtitulo">HISTORIAL</div></div>
                                     <div class=" historial_numeros">
                                        <!-- <div class="rectangulo_rojo">1</div> -->
                                     </div>    
                                       <!--  </div>
                                    </div> -->
                                </div>
                                <div class="columna_principalderecha">
                             
                                    <div class="tituloconfiguracionevento">

                                        <div class="izquierda">
                                            <span CLASS="nombre_tituloconfiguracionevento"></span>
                                        </div>
                                        <div class="derecha">
                                            <span class="id_tituloconfiguracionevento"></span>   
                                        </div>
                                    </div>
                                    <div class="rowtablaeventos">
                                        <table class="table table-condensed table-stripedVenta" id="tabla_eventos">
                                            <thead>
                                            <tr>
                                                <th>ID EVENTO</th>
                                                <th>SELECCIÓN</th>
                                                <th>CUOTA</th>
                                                <th>APUESTA </th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            </tbody>
                                        </table>
                                    </div><!--rowtablaeventos-->
                                    <div class="rowtableeventos_footer">
                                        <div class="apuesta">
                                                        <span class="rowtableeventos_footer_apuesta">APUESTA</span>
                                        </div>
                                        <div class="valorestotalmax">
                                           <div id="valor_total"> 
                                            <span>TOTAL: 0.00 S/.</span>
                                            </div>
                                            <div  id="valor_maximo">
                                                <span>MAX: 0.00 S/.</span>
                                            </div>
                                        </div>
                                    </div><!--rowtableeventos_footer-->


                                    <div class="rowapuestas" id="div_apuestas">
                                         @foreach($dinerodefault as $apuesta) 
                                         <div class="rowapuestasdiv" 
                                            data-valor="{{$apuesta->monto}}"
                                            data-tipo="apuesta"
                                            >
                                             {{$apuesta->monto}}
                                         </div>
                                        @endforeach


                                           <!--      <div class="rowapuestasdiv">
                                                </div> -->
                                    </div><!--rowapuestas-->

                                      <div class="rowbotones" id="div_botones">
                                               <div class="rowbotonesdiv check icon icon-2x fa fa-check">
                                                </div> 
                                                   <div class="rowbotonesdiv cerrar icon icon-2x fa fa-close">
                                                </div> 
                                                <div class="rowbotonesdiv barcode icon icon-2x fa fa-barcode">
                                                </div> 
                                                <div class="rowbotonesdiv print icon icon-2x fa fa-print">
                                                </div> 
                                    </div><!--rowapuestas-->
                                </div>
                        </div><!--fin row medio -->


                        <div class="rowconfiguracioneventosdiv" id="div_configuracioneventos">
                         
                                <div class="eventos_fila_izq">
                                        @foreach($eventos as $evento) 

                                            <div class="configuracioneventosdiv" 
                                                    data-id="{{ $evento->idEvento }}"
                                                    data-nombre="{{ $evento->nombre }}"
                                                    data-apuestaMinima="{{ $evento->apuestaMinima }}"
                                                    data-apuestaMaxima="{{ $evento->apuestaMaxima }}"
                                                    data-FechaEvento="{{ $evento->FechaEvento }}"
                                                    data-fechaFinEvento="{{ $evento->fechaFinEvento }}"
                                                    data-segBloqueoAntesEvento="{{ $evento->segBloqueoAntesEvento }}"
                                                    data-idMoneda="{{ $evento->idMoneda }}"
                                                    > 
                                                    <div style="width: 30%; height: 100%;float:left;position:relative">
                                                        <img style="width:70%;height:80%;position: absolute; left: 50%; transform: translate(-50%, -50%); top: 50%;" src="img/juegos/{{$evento->logo}}">
                                                    </div>
                                                    <div class="eventotextodiv" style="width: 70%; height: 100%;float:left;display:flex;align-items:center">{{$evento->nombre}}
                                                    </div>
                                            </div>
                                        @endforeach

                            </div>
                              <div class="eventos_fila_der">
                            </div>
                        </div>
    </div><!--JUEGO TOMBOLACUY-->






<div class="modal" id="modal_imprimir" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">Impresión</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body" style="overflow:auto">
             <div style="text-align:center">
                <div id="divimpresion" style="box-shadow:0 0 10px black;width:80mm;margin:auto">
                    <div class="ticket" style="display:inline-block;font-size:10pt;width:80mm;padding:8mm">
                        <div class="titulo" style="width: 100%; text-align: center; display: flex; align-items: center;border-bottom:1px solid;padding-bottom:5px"><div style="width:100%">
                            <img id="imagen_apuestatotal" width="180" height="80" src="{{asset('img/logo.png')}}">
                        </div></div>
                        <div class="imagen" style="width:100%;text-align:center;display:block;padding:4px"><img id="imagen_evento"  width="200" height="120"></div>
                        <div class="datos" style="width:100%;display:table;padding-top:4px">
                            <div style="width:100%;border-top:2px dotted;display:table">
                                        <div style="width:50%;float:LEFT;text-align:left">ID Tique</div>
                                        <div style="width:50%;float:LEFT;text-align:right" id="IDTique"></div>
                            </div>
                            <div style="width:100%;display:table">
                           
                                        <div style="width:50%;float:LEFT;text-align:left">ID Unidad</div>
                                        <div style="width:50%;float:LEFT;text-align:right" id="IDUnidad"></div>

                            </div>
                            <div style="width:100%;display:table">
                             
                                        <div style="width:50%;float:LEFT;text-align:left">Nro Evento</div>
                                        <div style="width:50%;float:LEFT;text-align:right" id="NroEvento"></div>

                            </div>
                            <div style="width:100%;display:table">
                         
                                        <div style="width:50%;float:LEFT;text-align:left">Desc.</div>
                                        <div style="width:50%;float:LEFT;text-align:right" id="descripcion"></div>
                            </div>
                            <div style="width:100%;display:table;border-top:2px dotted;padding-bottom:4px;padding-top:4px" id="datos_filas">
                            </div>

                            <div style="width:100%;display:table;border-top:2px dotted;padding-bottom:4px;padding-top:4px" id="totales_ticket">
                                    <div style="width:50%;float:LEFT;text-align:left">Total del Ticket</div>
                                    <div style="width:50%;float:LEFT;text-align:right" id="total_ticket"></div>

                            </div>
                            <div style="width:100%;display:table;border-top:2px dotted;padding-top:4px" id="">
                         
                                <div style="width:50%;float:LEFT;text-align:left;">Impreso En</div>
                                <div style="width:50%;float:LEFT;text-align:right" id="impreso_en"></div>

                            </div>
                            <div style="width:100%;display:table;padding-bottom:4px;" id="">
                                <div style="width:50%;float:LEFT;text-align:left">Impresor por </div>
                                <div style="width:50%;float:LEFT;text-align:right" id="impreso_por"></div>

                            </div>


                             <div style="width:100%;display:table;border-top:2px dotted;padding-top:4px" id="">
                                <div style="width:50%;float:LEFT;text-align:left;">Premio Máximo a Pagar </div>
                                <div style="width:50%;float:LEFT;text-align:right" id="PremioMaximoAPagar"></div>

                            </div>
                             <div style="width:100%;display:table" id="">
                                <div style="width:50%;float:LEFT;text-align:left">Premio Máximo Potencial</div>
                                <div style="width:50%;float:LEFT;text-align:right" id="PremioMaximoPotencial"></div>

                            </div>


                        </div>
                        <div class="footer" style="width:100%;text-align:center"></div>
                        <div class="codigoqr_barra" style="width:100%;margin-bottom:8mm;display:table">
                              <div id="codigo_barra" style="float: LEFT; width:50%;padding-top:20px;text-align:center">
                            <!-- <img id="imagen_codigobarra"width="180" height="80"> -->
                            <img id="imagen_codigobarra"width="114" height="80">
                              </div>

                              <div id="codigo_qr" style="float: left; width:50%;text-align:right"><img id="imagen_qrcode"  width="120" height="120"></div>
                            
                        </div>

                    </div>
                </div>
            </div><!--FIN DIV WRAPPER-->
        </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" id="btnimprimir">Imprimir</button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>




<div class="modal" id="modal_buscar" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">TICKET</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" style="overflow:auto">
                 <div class="row">
                    <div class="col-md-12">
                       <form class="form-inline">
                                
                                <div class="form-group">
                                    <label for="inputPassword2" class="sr-only">Nro Ticket</label>
                                    <input class="form-control" id="ticket_txt" placeholder="Ticket" type="text">
                                </div>
                                <button type="submit" class="btn btn-success" id="btn_buscar_ticket">Buscar</button>
                            </form>
                    </div>
                </div>
                 <div class="row">

                    <div class="col-md-12">
                        <div class="digitador">
                                <div class="digito">7</div>
                                <div class="digito">8</div>
                                <div class="digito">9</div>
                                <div class="digito">4</div>
                                <div class="digito">5</div>
                                <div class="digito">6</div>
                                <div class="digito">1</div>
                                <div class="digito">2</div>
                                <div class="digito">3</div>
                                <div class="borrar">BORRAR</div>
                                <div class="digito">0</div>
                                <div class="buscar_div" id="buscar_div">BUSCAR</div>
                        </div>
                    </div>
                </div>
                 
            </div><!--FIN DIV WRAPPER-->
       
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
        </div>
       </div>
    </div>
  </div>





<div class="modal" id="modal_imprimir_pago" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">Impresión</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body" style="overflow:auto">
             <div style="text-align:center">
                <div id="divimpresion_pago" style="box-shadow:0 0 10px black;width:80mm;margin:auto">
                    <div class="ticket" style="display:inline-block;font-size:10pt;width:80mm;padding:8mm">
                        <div class="titulo" style="width: 100%; text-align: center; display: flex; align-items: center;border-bottom:1px solid;padding-bottom:5px"><div style="width:100%">
                            <img id="imagen_apuestatotal" width="180" height="80">
                        </div></div>
                        <div class="imagen" style="width:100%;text-align:center;display:block;padding:4px"><img id="imagen_evento"  width="200" height="120"></div>

   <div style="width:100%;display:table;border-top:2px dotted;;border-bottom:2px dotted;padding-bottom:4px;padding-top:4px;word-spacing:13px;letter-spacing:3px" id="totales_ticket">
                                    <div style="width:100%;;text-align:center">TIQUE DE PAGO</div>

                            </div>

                        <div class="datos" style="width:100%;display:table;padding-top:4px;padding-top:17px">
                            <div style="width:100%;border-top:2px dotted;display:table">
                                        <div style="width:50%;float:LEFT;text-align:left">ID Tique</div>
                                        <div style="width:50%;float:LEFT;text-align:left" id="IDTique"></div>
                            </div>
                            <div style="width:100%;display:table">
                           
                                        <div style="width:50%;float:LEFT;text-align:left">ID Unidad</div>
                                        <div style="width:50%;float:LEFT;text-align:left" id="IDUnidad"></div>

                            </div>
                            <div style="width:100%;display:table">
                             
                                        <div style="width:50%;float:LEFT;text-align:left">Nro Evento</div>
                                        <div style="width:50%;float:LEFT;text-align:left" id="NroEvento"></div>

                            </div>
                            <div style="width:100%;display:table">
                         
                                        <div style="width:50%;float:LEFT;text-align:left">Desc.</div>
                                        <div style="width:50%;float:LEFT;text-align:left" id="descripcion"></div>
                            </div>
                            <div style="width:100%;display:table;border-top:2px dotted;padding-bottom:4px;padding-top:4px" id="datos_filas">
                            </div>

                            <div style="width:100%;display:table;border-top:2px dotted;padding-bottom:4px;padding-top:4px" id="totales_ticket">
                                    <div style="width:50%;float:LEFT;text-align:left">Cantidad Ganada</div>
                                    <div style="width:50%;float:LEFT;text-align:right" id="total_ticket"></div>

                            </div>
                            <div style="width:100%;display:table;border-top:2px dotted;padding-top:4px" id="">
                         
                                <div style="width:50%;float:LEFT;text-align:left;">Impreso En</div>
                                <div style="width:50%;float:LEFT;text-align:right" id="impreso_en"></div>

                            </div>
                            <div style="width:100%;display:table;padding-bottom:6pt;" id="">
                                <div style="width:50%;float:LEFT;text-align:left">Impresor por </div>
                                <div style="width:50%;float:LEFT;text-align:right" id="impreso_por"></div>

                            </div>

<!-- 
                             <div style="width:100%;display:table;border-top:2px dotted;padding-top:8pt" id="">
                                <div style="width:60%;float:LEFT;text-align:left;">Premio Máximo a Pagar </div>
                                <div style="width:40%;float:LEFT;text-align:right" id="PremioMaximoAPagar"></div>

                            </div> -->
                            


                        </div>
                        <div class="footer" style="width:100%;text-align:center"></div>
                     

                    </div>
                </div>
            </div><!--FIN DIV WRAPPER-->
        </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" id="btnimprimir">Imprimir</button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>





</div>




</div><!--FIN  panel-body-->
              
  
 
  </div>
  </div>
  </div>
    
@stop

@push('Js')
    <script src="{{asset('../assets/Venta/ServerDate.js')}}"></script>
    <script src="{{asset('../assets/Venta/FuncionesCaja.js')}}"></script>
    <script src="{{asset('../assets/Venta/Index.js')}}"></script>
    <script src="{{asset('../assets/Venta/ClaseWebSockets.js')}}"></script>

@endpush



