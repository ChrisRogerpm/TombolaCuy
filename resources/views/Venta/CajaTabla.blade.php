       <?php //if($error==""){?>

         <div class="row">
            <div class="col-md-12">
                <div class="panel panel-primary">
                    <div class="panel-body" id="datoscaja">
                        <div class="row">
                            <div class="col-md-9 col-xs-12 col-sm-12">
                                <h6>
                                    <i class="glyphicon glyphicon-th mr-2"></i>
                                    Venta Caja    
                                    
<input type="hidden" id="IPSERVIDOR_WEBSOCKETS" value="{{env('IPSERVIDOR_WEBSOCKETS','35.184.46.33')}}">
<input type="hidden" id="PUERTO_WEBSOCKETS" value="{{env('PUERTO_WEBSOCKETS','888')}}">
                                </h6>
                            </div>
                            <div class="col-md-3 col-xs-12 col-sm-12">
                                <div class="row">
                                <?php if($aperturacajadatos==null){?>
                                    <div class="col-md-12 col-xs-12 col-sm-12 pull-right">
                                        <button class="btn btn-primary  pull-right" style="float: right;" id="apertura_de_caja" onClick="CargarAperturaCaja()">AP. DE CAJA</button> 
                                    </div>
                                 <?php }
                                 else{ ?>
                                    <div class="col-md-6 col-xs-12 col-sm-12 pull-right">

                                         <button class="btn btn-primary pull-right" style="float: left;" id="cierre_caja" onClick="CargarCierreCaja()">CIERRE CAJA</button>   
                                    </div>
                                    <div class="col-md-6 col-xs-12 col-sm-12 pull-right">

                                         <button class="btn btn-primary pull-right" style="float: left;" id="recargar_tabla" onClick="CargarTabla()">RECARGAR</button>   
                                    </div>
                               <?php }?>
                               </div>

                            </div>
                        </div>
                        <?php if($eventosdatos!=null){?>

                        <hr style="margin-top: 0px;">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <div class="input-group">
                                        <div class="input-group-addon bg-primary text-white">TIENDA</div>
                                        <input type="text" class="form-control input-sm" id="tienda"  value="{{ $aperturacajadatos->tienda }}" readonly>
                                        <input type="hidden" class="form-control input-sm" id="idPuntoVenta" value="{{ $aperturacajadatos->idPuntoVenta }}" >
                                        <input type="hidden" class="form-control input-sm" id="idUbigeo" value="{{ $aperturacajadatos->idUbigeo }}" >
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
                     <?php }?>

                    </div>
                </div>
            </div>

        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-primary">
                    <div class="panel-body">

<?php //if($aperturacajadatos!=null){?>

                        <div class="TOMBOLACUY" style="height:120vh;display:none">
                            <div class=" rowcabecera">
                                <div class=" rowcabecera_nombres">
                                    <div style="width:22%" class="">
                                        <span> HORA</span>
                                    </div>

                                    <div style="width:20%"class="">
                                     <span>PRÓXIMO EN</span> 
                                 </div>
                                 <div style="width:15%"class="">
                                    <span>JUGADOR</span> 
                                </div>
                                <div style="width:10%" class="">
                                  <span>DIVISA</span>  
                              </div>
                              <div style="width:33%;text-align:right" class="">
                                  <span>JACKPOT</span>  
                              </div>
                          </div>

                          <div class=" rowcabecera_datos" id="row_datosevento">
                            <div style="width:22%;display:block" class="" >
                                <div style="display:flex;width:100%">
                                    <div id="fechaServidor" style="display:flex;width:100%;border:0" >

                                    </div>

                                </div>
                            </div>

                            <div style="width:20%;padding-top: 7px;" class="">

                                <div style="width:50%;border-right:0px" id="proximo_en2" class="countdown">
                                    -
                                </div>
                                <div style="display:flex;width:50%">
                                    <div id="progreso" style="padding: 0;display:block;float:right;width: 80%;margin:auto;height:45%; background:rgba(0, 0, 0, 0) linear-gradient(to right,#2196f3, #8bc34a, #f44336) repeat scroll 0 0; border-radius:5px 0px 0px 5px">
                                        <div id="barra_loading" style="float:right;width:100%;height:100%;background-color: green;

                                        ">
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div style="width:15%;padding-top: 7px;" class="">
                            <span id="jugador" >-</span>

                        </div>
                        <div style="width:10%;padding-top: 7px;" class="">
                            <span id="divisa" >-</span>

                        </div>
                        <div style="width:33%;text-align:right;font-size: 30px;background-color: #a5201b;box-shadow: inset 0 1px 0 rgba(255, 255, 255, 0.1), inset 0 -3px 2px rgba(0, 0, 0, 0.12), 0 5px 5px rgba(0, 0, 0, 0.4), 0 0 5px rgba(0, 0, 0, 0.4), inset 0 -15px 10px rgba(0, 0, 0, 0.25);padding-right: 20px;" class="">
                            <span id="jackpotsuma" >0.00</span>
                        </div>
                    </div>
                </div>


                <div class=" row_medio">
                    <div class="columna_principalizquierda"  >
                        <div  class="tabla_pleno">
                            <div class="row_pleno" >
                                <div class="div_pleno">
                                    PLENO
                                </div>
                            </div>
                            <div class="contenedor_tablaprincipal2"  style="height:90%">
                                <div class="" id="numeros_tabla2">
                                    <!--TABLA DE NUMEROS PRINCIPAL-->
                                    <div class=" margen_numeros">
                                    </div>
                                    <div class=" numeros_rect2">
                                     @foreach($primerafila as $div) 
                                     <div 
                                     data-idTipoPago="{{$div->idTipoPago}}" 
                                     data-idTipoApuesta="{{$div->idTipoApuesta}}" 
                                     style="background-color:{{$div->rgb}};color:{{$div->rgbLetra}}" 
                                     data-tipo="numero" 
                                     data-color="{{$div->rgb}}"
                                     data-valor={{$div->valorapuesta}} 
                                     data-cuota={{$div->multiplicadorDefecto}} 
                                     >{{$div->valorapuesta}}
                                 </div>
                                 @endforeach
                             </div>
                             <div class=" margen_bottom_numeros">

                             </div>
                             <div class=" margen_numeros">

                             </div>
                             <div class=" numeros_rect2">
                               @foreach($segundafila as $div) 
                               <div 
                               data-idTipoApuesta="{{$div->idTipoApuesta}}" 
                               data-idTipoPago="{{$div->idTipoPago}}" 
                                     style="background-color:{{$div->rgb}};color:{{$div->rgbLetra}}" 
                               data-tipo="numero" 
                               data-color="{{$div->rgb}}"
                               data-valor={{$div->valorapuesta}} 
                               data-cuota={{$div->multiplicadorDefecto}} 
                               >{{$div->valorapuesta}}
                           </div>
                           @endforeach
                       </div>
                       <div class=" margen_bottom_numeros"></div>
                       <div class=" margen_numeros"></div>
                       <div class=" numeros_rect2">
                        @foreach($tercerafila as $div) 
                        <div 
                        data-idTipoApuesta="{{$div->idTipoApuesta}}" 
                        data-idTipoPago="{{$div->idTipoPago}}" 
                                     style="background-color:{{$div->rgb}};color:{{$div->rgbLetra}}" 
                        
                        data-tipo="numero" 
                        data-color="{{$div->rgb}}"
                        data-valor={{$div->valorapuesta}} 
                        data-cuota={{$div->multiplicadorDefecto}} 
                        >{{$div->valorapuesta}}</div>
                        @endforeach
                    </div>
                    <div class=" margen_bottom_numeros"></div>
                    <div class=" margen_numeros"></div>
                    <div class=" numeros_rect2">
                        @foreach($cuartafila as $div) 
                        <div 
                        data-idTipoApuesta="{{$div->idTipoApuesta}}" 
                        data-idTipoPago="{{$div->idTipoPago}}" 
                                     style="background-color:{{$div->rgb}};color:{{$div->rgbLetra}}" 
                       
                        data-tipo="numero" 
                        data-color="{{$div->rgb}}"
                        data-valor={{$div->valorapuesta}} 
                        data-cuota={{$div->multiplicadorDefecto}} 
                        >{{$div->valorapuesta}}</div>
                        @endforeach
                    </div>
                    <div class=" margen_bottom_numeros"></div>
                    <div class=" margen_numeros"></div>
                    <div class=" numeros_rect2">
                        @foreach($quintafila as $div) 
                        <div 
                        data-idTipoApuesta="{{$div->idTipoApuesta}}" 
                        data-idTipoPago="{{$div->idTipoPago}}" 
                                     style="background-color:{{$div->rgb}};color:{{$div->rgbLetra}}" 
                       
                        data-tipo="numero" 
                        data-color="{{$div->rgb}}"
                        data-valor={{$div->valorapuesta}} 
                        data-cuota={{$div->multiplicadorDefecto}} 
                        >{{$div->valorapuesta}}</div>
                        @endforeach
                    </div>
                    <div class=" margen_bottom_numeros"></div>
                    <div class=" margen_numeros"></div>
                    <div class=" numeros_rect2">

                        @foreach($sextafila as $div) 
                        <div 
                        data-idTipoApuesta="{{$div->idTipoApuesta}}" 
                        data-idTipoPago="{{$div->idTipoPago}}" 
                                     style="background-color:{{$div->rgb}};color:{{$div->rgbLetra}}" 
                        
                        data-tipo="numero" 
                        data-color="{{$div->rgb}}"
                        data-valor={{$div->valorapuesta}} 
                        data-cuota={{$div->multiplicadorDefecto}} 
                        >{{$div->valorapuesta}}</div>
                        @endforeach
                    </div>
                    <div class=" margen_bottom_numeros"></div>
                                                    <!--  <div class="rowhistorial">
                                           <div class="historial">HISTORIAL</div>
                                       </div>-->
                                   </div>
                                   <!--div col 10-->
                                   <!-- <div class="col-xs-12 col-md-1"></div> -->
                               </div>
                               <!--contenedor_tablaprincipal-->
                           </div>
                           <!--FIN TABLA PLENO-->

                           <div class="tabla_apuestas_adicionales" >
                            <div class="apuestas_adicionales">
                                <div class=" apuestasadicionales_titulo" >
                                    <div class="apuestasadicionales_titulo_div">APUESTAS ADICIONALES</div>
                                </div>
                                <div class="apuestasadicionalescontenedor" >
                                    <div class="apuestacondicional_fila">
                                        <div class="apuestacondicional_fila_nombre">COLORES</div>
                                        <div class="apuestacondicional_fila_datos">
                                         @foreach($coloresfila as $div) 
                                         <div 
                                         data-idTipoApuesta="{{$div->idTipoApuesta}}" 
                                         data-idTipoPago="{{$div->idTipoPago}}" 
                                         style="background-color:{{$div->rgb}}" 

                                         data-tipo="color" 

                                         <?php 
                                         $datacolor=$div->nombre;
                                         ?>
                                         data-color="{{$datacolor}}"
                                         data-valor={{$div->nombre}} 
                                         data-cuota={{$div->multiplicadorDefecto}} 
                                         >{{$div->nombre}}</div>
                                         @endforeach
                                     </div>      
                                 </div>
                                 <div class="apuestacondicional_fila">
                                     <div class="apuestacondicional_fila_nombre">RANGOS</div>
                                     <div class="apuestacondicional_fila_datos">
                                         @foreach($rangosfila as $div) 
                                         <div 
                                         data-idTipoApuesta="{{$div->idTipoApuesta}}" 
                                         data-idTipoPago="{{$div->idTipoPago}}" 
                                         style="background-color:{{$div->rgb}}" 
                                         data-tipo="rango" 
                                         <?php
                                         $datacolor=$div->rgb;
                                         ?>
                                         data-color="{{$datacolor}}"
                                         data-valor={{$div->nombre}} 
                                         data-cuota={{$div->multiplicadorDefecto}} 
                                         >{{$div->nombre}}
                                     </div>
                                     @endforeach
                                 </div>      
                             </div>
                             <div class="apuestacondicional_fila">

                                 <div class="apuestacondicional_fila_nombre">PAR/IMPAR</div>

                                 <div class="apuestacondicional_fila_datos">
                                     @foreach($par_imparfila as $div) 
                                     <div 
                                     data-idTipoApuesta="{{$div->idTipoApuesta}}" 
                                     data-idTipoPago="{{$div->idTipoPago}}" 
                                     style="background-color:{{$div->rgb}}" 
                                     data-tipo="par_impar" 
                                     <?php
                                     $datacolor=$div->rgb;

                                     ?>
                                     data-color="{{$datacolor}}"
                                     data-valor={{$div->nombre}} 
                                     data-cuota={{$div->multiplicadorDefecto}} 
                                     >{{$div->nombre}}</div>
                                     @endforeach
                                 </div>     
                             </div>
                             <!-- <div class="rectangulo_rojo">1</div> -->
                         </div>    

                     </div>
                     <!--fin div rowhisto hisotrila numeros-->
                 </div>
                 <!--fin div tabla_apuestas_adicionales-->


                 <div class="tabla_historial">
                    <div class=" tabla_historial_titulo" ><div class="tabla_historial_titulo_div">HISTORIAL</div></div>
                    <div class=" historial_numeros" style="height:80%">

                    </div>    

                </div>
                <!--fin div rowhisto hisotrila numeros-->


            </div>
            <!-- columna principal_izqueirda -->
            <div class="columna_principalderecha">

                <div class="tituloconfiguracionevento">

                    <div class="izquierda">
                        <span CLASS="nombre_tituloconfiguracionevento"></span>
                    </div>
                    <div class="derecha" style="padding-right">
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
                <div style="height:2%;width:100%">

                </div>
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
            </div>
            <!--rowtableeventos_footer-->
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
                                       </div>
                                       <!--rowapuestas-->
                                       <div class="rowbotones" id="div_botones">
                                           <div class="rowbotonesdiv check icon icon-2x fa fa-check">
                                           </div> 
                                           <div class="rowbotonesdiv cerrar icon icon-2x fa fa-close">
                                           </div> 
                                           <div class="rowbotonesdiv barcode icon icon-2x fa fa-barcode">
                                           </div> 
                                           <div class="rowbotonesdiv print icon icon-2x fa fa-print">
                                           </div> 
                                       </div>
                                       <!--rowapuestas-->
                                       <div style="width:100%;height:1%"></div>
                                   </div>
                               </div><!--fin row medio -->
                               <div class="rowconfiguracioneventosdiv" id="div_configuracioneventos">

                                <div class="eventos_fila_izq">
                                    <?php if ($eventosdatos!=null){?>
                                    @foreach($eventosdatos as $evento) 
                                    <div class="configuracioneventosdiv" 
                                    data-id="{{ $evento->idEvento }}"
                                    data-idJuego="{{ $evento->idJuego }}"
                                    data-nombre="{{ $evento->nombre }}"
                                    data-apuestaMinima="{{ $evento->apuestaMinima }}"
                                    data-apuestaMaxima="{{ $evento->apuestaMaxima }}"

                                    data-apuestaMinimajuego="{{ $evento->apuestaMinimaJuego }}"
                                    data-apuestaMaximajuego="{{ $evento->apuestaMaximaJuego }}"
                                    
                                    data-FechaEvento="{{ $evento->FechaEvento }}"
                                    data-fechaFinEvento="{{ $evento->fechaFinEvento }}"
                                    data-segBloqueoAntesEvento="{{ $evento->segBloqueoAntesEvento }}"
                                    data-idMoneda="{{ $evento->idMoneda }}"

                                    data-jugador="{{$evento->jugador}}"
                                    data-divisa="{{$evento->divisa}}"
                                    data-jackpotsuma="{{$evento->jackpotsuma}}"
                                    data-logo="{{$evento->logo}}"

                                    > 
                                    <div style="width: 30%; height: 100%;float:left;position:relative">
                                        <img style="width:70%;height:80%;position: absolute; left: 50%; transform: translate(-50%, -50%); top: 50%;" src="img/juegos/{{$evento->logo}}">
                                    </div>
                                    <div class="eventotextodiv" style="width: 70%; height: 100%;float:left;display:flex;align-items:center">{{$evento->nombre}}
                                    </div>
                                </div>
                                @endforeach
                            <?php }?>
                            </div>
                            <div class="eventos_fila_der">
                            </div>
                        </div><!--fin rowconfiguracioneventosdiv-->
                    </div><!--JUEGO TOMBOLACUY-->
<?php //}?>

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

                                           <!--  <div style="width:100%;display:table" id="">
                                                <div style="width:50%;float:LEFT;text-align:left">Apuesta Minima</div>
                                                <div style="width:50%;float:LEFT;text-align:right" id="ApuestaMinimaJuego"></div>
                                            </div> -->
                                            <div style="width:100%;display:table" id="">
                                                <div style="width:50%;float:LEFT;text-align:left">Apuesta Máxima</div>
                                                <div style="width:50%;float:LEFT;text-align:right" id="ApuestaMaximaJuego"></div>
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
</div><!--fin  modal_imprimir_pago-->





</div>




</div><!--FIN  panel-body-->


</div>

</div>
<?  //php }?>

<!-- </div> -->



@push('Js')

<!-- <?php if($error!=""){?>
    <script>toastr.error("<?php echo $error;?>")</script>
<?php }?> -->

@endpush



