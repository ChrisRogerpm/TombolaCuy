@extends('Shared.layout')

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
     <!--    <div class="col-md-6">
            <div class="panel panel-primary">
                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-4 col-sm-4  col-xs-12 pull-right">
                            <div class="row">
                                <div class="col-md-12 col-sm-12">
                                    <a href="{{route('Jackpot.Insertar')}}"
                                       class="btn btn-primary btn-sm col-md-12 col-xs-12"><span
                                                class="glyphicon glyphicon-file"></span> NUEVO</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div> -->
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
                                     <input type="text" class="form-control input-sm" id="tienda">
                                     <input type="hidden" class="form-control input-sm" id="idPuntoVenta">


                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <div class="input-group">
                                    <div class="input-group-addon bg-primary text-white">CAJA</div>
                                   <input type="text" class="form-control input-sm" id="caja">
                                </div>
                            </div>
                        </div>
                        
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <div class="input-group">
                                    <div class="input-group-addon bg-primary text-white">FECHA</div>
                                    <input type="text" class="form-control input-sm" id="fechaOperacion">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <div class="input-group">
                                    <div class="input-group-addon bg-primary text-white">TURNO</div>
                                    <input type="text" class="form-control input-sm" id="turno">
                                </div>
                            </div>
                        </div>

                    </div>
                  
                </div>
            </div>
        </div>

    </div>


    <div class="row">


<!--    <div class="col-md-12">
            <div class="panel panel-primary">

                <div class="panel-body">
                    <div class="row">
                        <div class="col-xs-12 col-md-2">
                            HORA
                        </div>

                        <div class="col-xs-12 col-md-2">
                        PRÓXIMO EN
                        </div>
                        <div class="col-xs-12 col-md-2">
                        JUGADOR
                        </div>
                        <div class="col-xs-12 col-md-4">
                        DIVISA
                        </div>
                          <div class="col-xs-12 col-md-1">
                        JACKPOT
                        </div>
                    </div>

                      <div class="row" id="row_datosevento">
                        <div class="col-xs-12 col-md-2">
                            <span id="fechaHoy"></span><span id="liveclock"></span>
                        </div>

                        <div class="col-xs-12 col-md-2">
                            <span id="proximo_en" class="countdown"></span>
                        </div>
                        <div class="col-xs-12 col-md-2">
                            <span id="jugador" ></span>

                        </div>
                        <div class="col-xs-12 col-md-4">
                            <span id="divisa" ></span>

                        </div>
                         <div class="col-xs-12 col-md-1">
                            <span id="jackpotsuma" ></span>
                        </div>
                    </div>
                </div>
            </div>
    
    </div>
 -->
        <div class="col-md-12">
            <div class="panel panel-primary">
                <div class="panel-body">
                    <DIV class="TOMBOLACUY" style="height:80vh">
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
                                        <div style="width:20%" class="">

                                            <span id="fechaHoy"></span><span id="liveclock">-</span>
                                        </div>

                                        <div style="width:15%" class="">
                                            <span id="proximo_en" class="countdown">-</span>
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
                                                        <div class="rectangulo_izquierda"></div>
                                                    </div>
                                                    <div class=""  style="height:35%">
                                                        <div class="rectangulo_izquierda2"></div>
                                                    </div>
                                              </div>
                                               <div class="" id="numeros_tabla">
                                                <!--TABLA DE NUMEROS PRINCIPAL-->
                                                <div class=" numeros_rect">
                                                    <div data-idTipoPago=1 data-tipo="numero" data-color="rojo" data-valor=3 class="rectangulo_rojo">3</div>
                                                    <div data-idTipoPago=1 data-tipo="numero" data-color="negro" data-valor=6  class="rectangulo_negro">6</div>
                                                    <div data-idTipoPago=1 data-tipo="numero" data-color="rojo" data-valor=9  class="rectangulo_rojo">9</div>
                                                    <div data-idTipoPago=1 data-tipo="numero" data-color="rojo" data-valor=12  class="rectangulo_rojo">12</div>
                                                    <div data-idTipoPago=1 data-tipo="numero" data-color="negro" data-valor=15 class="rectangulo_negro">15</div>
                                                    <div data-idTipoPago=1 data-tipo="numero" data-color="rojo" data-valor=18  class="rectangulo_rojo">18</div>
                                                    <div data-idTipoPago=1 data-tipo="numero" data-color="rojo" data-valor=21  class="rectangulo_rojo">21</div>
                                                    <div data-idTipoPago=1 data-tipo="numero" data-color="negro" data-valor=24  class="rectangulo_negro">24</div>
                                                </div>

                                                <div class=" numeros_rect">
                                                    <div data-idTipoPago=1  data-tipo="numero"  data-color="negro" data-valor=2 class="rectangulo_negro">2</div>
                                                    <div data-idTipoPago=1 data-tipo="numero" data-color="negro" data-valor=5 class="rectangulo_rojo">5</div>
                                                    <div data-idTipoPago=1 data-tipo="numero" data-color="negro" data-valor=8  class="rectangulo_negro">8</div>
                                                    <div data-idTipoPago=1 data-tipo="numero" data-color="negro" data-valor=11 class="rectangulo_negro">11</div>
                                                    <div data-idTipoPago=1 data-tipo="numero" data-color="rojo" data-valor=14 class="rectangulo_rojo">14</div>
                                                    <div data-idTipoPago=1 data-tipo="numero" data-color="negro" data-valor=17 class="rectangulo_negro">17</div>
                                                    <div data-idTipoPago=1 data-tipo="numero" data-color="negro" data-valor=20 class="rectangulo_negro">20</div>
                                                    <div data-idTipoPago=1 data-tipo="numero" data-color="rojo" data-valor=23 class="rectangulo_rojo">23</div>
                                                </div>
                                                <div class=" numeros_rect">
                                                    <div data-idTipoPago=1 data-tipo="numero" data-color="rojo" data-valor=1  class="rectangulo_rojo">1</div>
                                                    <div data-idTipoPago=1 data-tipo="numero" data-color="negro" data-valor=4 class="rectangulo_negro">4</div>
                                                    <div data-idTipoPago=1 data-tipo="numero" data-color="rojo" data-valor=7  class="rectangulo_rojo">7</div>
                                                    <div data-idTipoPago=1 data-tipo="numero" data-color="negro" data-valor=10 class="rectangulo_negro">10</div>
                                                    <div data-idTipoPago=1 data-tipo="numero" data-color="negro" data-valor=13 class="rectangulo_negro">13</div>
                                                    <div data-idTipoPago=1 data-tipo="numero" data-color="rojo" data-valor=16 class="rectangulo_rojo">16</div>
                                                    <div data-idTipoPago=1 data-tipo="numero" data-color="rojo" data-valor=19 class="rectangulo_rojo">19</div>
                                                    <div data-idTipoPago=1 data-tipo="numero" data-color="negro" data-valor=22 class="rectangulo_negro">22</div>
                                                </div>

                                                <div class=" numeros_rango">
                                                    <div data-idTipoPago=4 data-tipo="rango" data-color="azul" data-valor="1-6" class="rectangulo_azul">1-6</div>
                                                    <div data-idTipoPago=4 data-tipo="rango" data-color="azul" data-valor="7-12" class="rectangulo_azul">7-12</div>
                                                    <div data-idTipoPago=4 data-tipo="rango" data-color="azul" data-valor="13-18" class="rectangulo_azul">13-18</div>
                                                    <div data-idTipoPago=4  data-tipo="rango" data-color="azul" data-valor="19-24" class="rectangulo_azul">19-24</div>

                                                </div>

                                                <div class=" numeros_rango2">
                                                    <div data-idTipoPago=5 data-tipo="rango" data-color="azul" data-valor="1-12" class="rectangulo_azul">1-12</div>
                                                    <div data-idTipoPago=3 data-tipo="pares" data-color="azul" data-valor="PAR" class="rectangulo_azul">PAR</div>
                                                    <div data-idTipoPago=2 data-tipo="negros" data-color="negro" data-valor="1" class="rectangulo_negro"></div>
                                                    <div data-idTipoPago=2  data-tipo="rojos" data-color="rojo" data-valor="2"  class="rectangulo_rojo"></div>
                                                    <div data-idTipoPago=3 data-tipo="impares" data-color="azul" data-valor="IMPAR" class="rectangulo_azul">IMPAR</div>
                                                    <div data-idTipoPago=5 data-tipo="rango" data-color="azul" data-valor="13-24" class="rectangulo_azul">13-24</div>
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
                                <!-- <div class="">
                                    <div class="historialfila"> -->
                                  <!--    <div class=" historial_numeros">
                                                            <div class="rectangulo_rojo">1</div>
                                                            <div class="rectangulo_negro">4</div>
                                                            <div class="rectangulo_verde">22</div>
                                     </div>  -->   
                                     <!--    </div>
                                    </div> -->
                                    <!--  <div class="">
                                        <div class="historialfila"> -->
                                             <div class=" historial_numeros">
                                                                    <div class="rectangulo_rojo">1</div>
                                                                   <!--  <div class="rectangulo_negro">4</div>
                                                                   -->
                                                                    
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
                                            <tr>
                                                <td>-</td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                            </tr>
                                              <tr>
                                                <td>-</td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                            </tr>
                                              <tr>
                                                <td>-</td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                            </tr>
                                              <tr>
                                                <td>-</td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                            </tr>
                                             <tr>
                                                <td>-</td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                            </tr>
                                              <tr>
                                                <td>-</td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                            </tr>
                                              <tr>
                                                <td>-</td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                            </tr>
                                              <tr>
                                                <td>-</td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                            </tr>
                                            <tr>
                                                <td>-</td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                            </tr>
                                            <tr>
                                                <td>-</td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                            </tr>
                                         
                                          <tr>
                                                <td>-</td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                            </tr>
                                         
                                          <tr>
                                                <td>-</td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                            </tr>
                                         
                                         
                                        
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
                                           <!--      <div class="rowapuestasdiv">
                                                </div> -->
                                    </div><!--rowapuestas-->

                                      <div class="rowbotones" id="div_botones">
                                               <div class="rowbotonesdiv check icon icon-2x fa fa-check">
                                                <!-- <i style="margin-top:8px"  class="icon icon-1_5x fa fa-check"></i> -->
                                                </div> 
                                                   <div class="rowbotonesdiv cerrar icon icon-2x fa fa-close">
                                                <!-- <i style="margin-top:8px"  class="icon icon-1_5x fa fa-close"></i> -->

                                                </div> 
                                                <div class="rowbotonesdiv barcode icon icon-2x fa fa-barcode">
                                                     <!-- <i style="margin-top:8px"  class="icon icon-1_5x fa fa-barcode"></i> -->

                                                </div> 
                                                <div class="rowbotonesdiv print icon icon-2x fa fa-print">
                                                    <!-- <i style="margin-top:8px"  class="icon icon-1_5x fa fa-print"></i> -->
                                                </div> 
                                    </div><!--rowapuestas-->
                                </div>
                        </div><!--fin row medio -->


                        <div class="rowconfiguracioneventosdiv" id="div_configuracioneventos">
                         
                            <div class="eventos_fila_izq">
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
      <div class="modal-body">
<!-- <table>
   <thead><tr><td colspan="3">ApuestaTotal.com</td></tr></thead>
   <tbody>
       <tr class="imagen">
<td colspan="3"><img height=80 width=80></td>

       </tr>
       <tr>
        <td></td>
        </tr>
   </tbody> 

</table> -->
  <div class="ticket" id="divimpresion" style="width:50%;height:500px">
            <div class="titulo" style="width: 100%; text-align: center; display: flex; align-items: center;"><div style="width:100%">apuestatotal.com</div></div>
            <div class="imagen" style="width:100%;text-align:center"><img src="http://tombolacuy.local:88/img/juegos/cuy.png" width="200" height="120"></div>
            <div class="datos" style="width:100%;text-align:center">
                <div style="width:100%;display:table">
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


                <div style="width:100%;display:table" id="datos_filas">
             
   

                </div>

                <div style="width:100%;display:table" id="total_ticket">
                     
                        <div style="width:50%;float:LEFT;text-align:left">Total del Ticket</div>
                        <div style="width:50%;float:LEFT;text-align:right" id="total_ticket"></div>

                </div>
                <div style="width:100%;display:table" id="">
             
                    <div style="width:50%;float:LEFT;text-align:left">Impreso En</div>
                    <div style="width:50%;float:LEFT;text-align:right" id="impreso_en"></div>

                </div>
                <div style="width:100%;display:table" id="">
                    <div style="width:50%;float:LEFT;text-align:left">Impresor por </div>
                    <div style="width:50%;float:LEFT;text-align:right" id="impreso_por"></div>

                </div>


                 <div style="width:100%;display:table" id="">
                    <div style="width:50%;float:LEFT;text-align:left">Premio Máximo a Pagar </div>
                    <div style="width:50%;float:LEFT;text-align:right" id="PremioMaximoAPagar"></div>

                </div>
                 <div style="width:100%;display:table" id="">
                    <div style="width:50%;float:LEFT;text-align:left">Premio Máximo Potencial</div>
                    <div style="width:50%;float:LEFT;text-align:right" id="PremioMaximoPotencial"></div>

                </div>


            </div>
            <div class="footer" style="width:100%;text-align:center"></div>
            <div class="codigoqr_barra" style="width:100%">
                  <div id="codigo_barra" style="float: LEFT; width:50%;padding-top:20px;text-align:center">
                <img id="imagen_codigobarra"width="180" height="80">
                  </div>

                  <div id="codigo_qr" style="float: left; width:50%;text-align:right"><img id="imagen_qrcode"  width="120" height="120"></div>
                
            </div>

                  


        </div>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" id="btnimprimir">Imprimir</button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
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
    <script src="{{asset('../assets/Venta/Index.js')}}"></script>
@endpush