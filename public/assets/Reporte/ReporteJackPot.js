$(document).ready(function () {
    //$(".select2").select2();
    var dateNow = new Date();
    $(".hasDatepicker").datetimepicker({
        pickTime: false,
        format: 'DD/MM/YYYY',
        defaultDate: dateNow,
        maxDate: dateNow
    });

    $('.multiselect').select2({
        tags: false,
        allowClear: true,
        buttonWidth: '100%',
        width: '100%',
        placeholder: {
            id: '', // the value of the option
            text: '--Seleccione--'
        }
    });

    //cboConfiguracionJackPot
    // $('#cboConfiguracionJackPot').on('select2:select', function (e) {
    //     var data = e.params.data;
    //     var valor = data.id;
    //     //debugger
    //     if (valor == 0) {
    //         $('#cboConfiguracionJackPot').val([]).trigger('change');
    //         $('#cboConfiguracionJackPot').val(0).trigger('change');
    //     } else {
    //         var valores = $('#cboConfiguracionJackPot').val();
    //         var nuevo = [];
    //         $.each(valores, function (index, value) {
    //             if (value != 0) {
    //                 nuevo.push(value);
    //             }
    //         })
    //         $('#cboConfiguracionJackPot').val(nuevo).trigger('change');
    //     }

    //     $('#subtituloTabsGeneral').html(data.text);
    //     //ConfiguracionPozoSegunConfJackPot(valor);
    // });



    $("#cboConfiguracionJackPot").select2('val', [0]);

    $.when($.ajax(funcionLlenar())).then(function () {

        $('#cboConfiguracionJackPot').append('<option value="x" >Ninguno</option>');

    });




    //Punto de venta Tienda

    $('#cboTienda').on('select2:select', function (e) {
        var data = e.params.data;
        //debugger
        var valor = data.id;
        if (valor == 0) {
            $('#cboTienda').val([]).trigger('change');
            $('#cboTienda').val(0).trigger('change');
        } else {
            var valores = $('#cboTienda').val();
            var nuevo = [];
            $.each(valores, function (index, value) {
                if (value != 0) {
                    nuevo.push(value);
                }
            })
            $('#cboTienda').val(nuevo).trigger('change');

            dataTienda.push(data);
            //enviarTiendas(dataTienda);
        }
    });


    //cboTienda es idPunto de Venta 
    llenarSelect(basePath + "PuntoVentaListarJson", {}, "cboTienda", "idPuntoVenta", "nombre", "allOption", false);
    $("#cboTienda").select2('val', [0]);
    //dinamico
    $("#tab-eval a").click(function () {
        $(this).tab("show");
    })


    $(document).on("click", "#btnBuscar", function () {

        buscarListarJackPot();

    });
    var unav = true;
    $(document).on("click", ".tabClick", function (e) {

        var data = e.target;
        var valor = data.dataset.menu;
        var idcTabl = '#menu' + valor + ' .tablajack';

        var tabla = document.querySelector(idcTabl);
        tabla = tabla.dataset.table;
        var jack = '#jack' + tabla;
        debugger

        //     $(jack).DataTable({
        //         scrollY: '200px',
        //        destroy: false,
        //        sort: false,
        //        scrollCollapse: true,
        //        scrollX: true,

        //        paging: false,
        //        autoWidth: false,
        //        processing: false,
        //        deferRender: false,

        //        bInfo : false,
        //        searching: false,
        //        paging: false,

        //    });   

        var idc = '#menu' + valor + ' .dataTables_scrollHeadInner .tablajack';

        debugger
        var tablaSeleccionada = document.querySelector(idc);
        tablaSeleccionada.style.width = '1150px';
        tablaSeleccionada.style.marginLeft = "0px";




    });
    //width: 1724px; margin-left: 0px;
});


function funcionLlenar() {
    llenarSelect(basePath + "ConfiguracionJackpotListarJson", {}, "cboConfiguracionJackPot", "idConfiguracionJackpot", "nombre", "allOption", true);
}

var dataTienda = [];

function enviarTiendas(tiendas) {
    dataTienda = tiendas;
}

var return_first;
function callback(response) {
    return_first = response;
    //use return_first variable here
}

var return_JackPotSegunidPozoJackPot;
function callbackJackPotSegunidPozoJackPot(response) {
    return_JackPotSegunidPozoJackPot = response;
    //use return_first variable here
}


function ConfiguracionPozoSegunConfJackPot(idConfiguracionJackpot, tiendas) {
    //debugger;
    var url = basePath + "ConfiguracionPozoSegunConfJackPot";
    var ConfiguracionJackpot = [...idConfiguracionJackpot];
    var idConfiguracionJackpot = ConfiguracionJackpot[0];

    var tiendas = [...tiendas];

    //debugger
    var dataForm = {
        idConfiguracionJackpot: idConfiguracionJackpot
    };
    // var obj = { name: "John", age: 30, city: "New York" };
    // var myJSON = JSON.stringify(obj);

    $.ajax({
        url: url,
        type: "POST",
        contentType: "application/json",
        data: JSON.stringify(dataForm),
        beforeSend: function () {
            //$.LoadingOverlay("show");
        },
        complete: function () {
            $.LoadingOverlay("hide");
        },
        success: function (response) {

            var resp = response;
            listajackPots = [];
            //debugger;
            var tabEval = document.getElementById('tab-eval');

            var tabContenido = document.getElementById('tabContenido');

            var data = [...resp.data];
            var html = '';
            var htmlContenidoTabs = '';
            var firstIndex, firstIndexTab;
            tabEval.innerHTML = '';
            tabContenido.innerHTML = ''
            data.map((obj, index) => {
                debugger
                var index = index + 1;
                firstIndex = (index == 1) ? 'active' : '';
                firstIndexTab = (index == 1) ? 'in active' : '';
                html += `<li class="${firstIndex}"><a class="tabClick" href="#menu${index}" data-menu=${index}>${obj.JACKPOT}</a></li>`;

                var idJack = obj.idJackPot;
                //debugger;

                listajackPots.push(obj.idJackPot);
                //jackPostt(listajackPots);
                ListarPozoJackPotSegunJackPotId(obj.idJackPot);

                // $.when($.ajax(ListarPozoJackPotSegunJackPotId(obj.idJackPot))).then(function () {

                //    //codigo se ejecuta despues de que el metodo termine
                // });
                var listaPososJackPot = [];
                var thPozo = '';
                var tdPozo = '',
                    tdPozoOculto = '';

                var thTiendas = '';
                // var tdTiendas = '';
                listaPososJackPot = [...return_first];
                // thTiendas = '<th style="font-weight: 600;color:black">Tiendas </th> ';
                // tdTiendas = '<td style="font-weight: 600;color:steelblue"">Limites</td>';

                var limites = ['Incremento', 'Límite Inferior', 'Límite Superior']
                // tiendas.map((obj, index) => {

                //     tdTiendas = tdTiendas + `<tr>
                //                         <td style="font-weight: 600;color:black">${obj.text} </td>
                //                         </tr>`;
                // });
                //thPozo = `<th>Tienda${index}<th>`;

                tdPozo = limites.map(x => '<th style="font-weight: 600;color:black;text-align:center;">' + x + '</th>\n').join('');
                tdPozo = tdPozo + limites.map(x => '<th style="font-weight: 600;color:steelblue;text-align:center;">' + x + ' Oculto</th>\n').join('');
                tdPozo = tdPozo.repeat(listaPososJackPot.length);
                
                //thPozo = '<th rowspan="2">Tiendas<th>';
                var listaJackPotSegunidPozoJackPot = [];
                

                var tdBody ='';
                var trBody;
                var bodyJackpot='';
                debugger
                listaPososJackPot.map((obj, index) => {
                    thPozo = thPozo + `<th colspan='3'style="color:black;width:110px;text-align:center;">Pozo ${index+1} (${obj.idPozoJackpot})</th>\n
                                        <th colspan='3' style="color:steelblue;width:110px;text-align:center">Pozo Oculto ${index+1} (${obj.idPozoJackpot})</th>\n`;

                    //tdPozo = limites.map(x=>'<td>'+x+'</td>').join('');
                    
                    JackPotSegunidPozoJackPot(obj.idPozoJackpot);
                 
                    listaJackPotSegunidPozoJackPot = [...listaJackPotSegunidPozoJackPot,...return_JackPotSegunidPozoJackPot];
                    debugger
                    //tdBody +=listaJackPotSegunidPozoJackPot.map(x => '<td style="color:black;text-align:center;">' + x.incrementoJackpot + '</td>\n').join('');
                    for (let p = 0; p < listaJackPotSegunidPozoJackPot.length; p++) {
                        var element = listaJackPotSegunidPozoJackPot[p];
                        tdBody+=`<td> ${element.TIENDA}</td>
                        <td> ${element.incrementoJackpot}</td>
                        <td> ${element.limiteInferior}</td>
                        <td> ${element.limiteSuperior}</td>
                        <td> ${element.incrementoPozoOculto}</td>
                        <td> ${element.limiteInferiorOculto}</td>
                        <td> ${element.limiteSuperiorOculto}</td>`;
                        trBody ='<tr>'+ tdBody + '</tr>';
                        //debugger
                    }
                    
                    //listaJackPotSegunidPozoJackPot=[];
                    //bodyJackpot +=trBody+"\n";
                    trBody='';
                    tdBody='';
                    //debugger
                    
                });

                for (let jp = 0; jp < (listaPososJackPot.length*6)+1; jp++) {
                    //var element = ;
                  
                    for (let p = 0; p < listaJackPotSegunidPozoJackPot.length; p++) {
                        // var pozoId= listaPososJackPot[jp].idPozoJackpot;debugger
                        // var element = listaJackPotSegunidPozoJackPot[p];
                        // if (pozoId== element.idPozoJackpot) {
                        //     tdBody+=`<td> ${element.TIENDA}</td>
                        //     <td> ${element.incrementoJackpot}</td>
                        //     <td> ${element.limiteInferior}</td>
                        //     <td> ${element.limiteSuperior}</td>
                        //     <td> ${element.incrementoPozoOculto}</td>
                        //     <td> ${element.limiteInferiorOculto}</td>
                        //     <td> ${element.limiteSuperiorOculto}</td>`;        
                        // }
                        
                       
                    }
                    debugger
                    trBody ='<tr>'+ tdBody + '</tr>';
                }
                // tdPozoOculto = tdPozoOculto + limites.map(x => '<td style="font-weight: 600;color:blue">' + x + ' Oculto</td>').join('');

                // tdPozoOculto = tdPozoOculto.repeat(listaPososJackPot.length);
                //tdPozo += tdPozoOculto;
                // listaPososJackPot.map((obj, index) => {
                //     thPozo = thPozo + `<th colspan='3'>Pozo Oculto ${index+1} (${obj.idPozoJackpot})</th>`;

                //     //tdPozo = tdPozo + `<td>Inicial</td>`;
                //     //tdPozo = limites.map(x=>'<td>'+x+'</td>').join('');
                // });
                var thp = '';
               
                thp = tdPozo;
                //debugger;
                debugger;
                htmlContenidoTabs += `
                <div id="menu${index}" class="tab-pane fade ${firstIndexTab}">
                            <h6>JackPot: ${obj.idJackPot}</h6>
                            <p>JackPot: ${obj.JACKPOT}</p>
                            
                            <div id="divtable${obj.idJackPot}" style="display:flex;padding:0;" class="panel-body">
                                
                               
                                <table data-table=${obj.idJackPot} style="width: 1150px; margin-left: 0px;" id="jack${obj.idJackPot}" class="tablajack table table-bordered table-stripeds">
                                    <thead>
                                        <tr>
                                            <th rowspan="2">Tiendas<th>
                                            
                                            ${thPozo}
                                            
                                        </tr>

                                        <tr>
                                            
                                            ${thp}
                                        </tr>
                                    </thead>
                                    <tbody>
                                       
                                        ${bodyJackpot}
                                    </tbody>
                                </table>
                            </div>
                </div>
                
                
                `;


            });


           

            tabEval.innerHTML += html;
            tabContenido.innerHTML += htmlContenidoTabs;
            //1ero debe dibujarse el doom y despues usar esta funcion
            $("#tab-eval a").click(function () {
                $(this).tab("show");
            })

            debugger
            //var tablaExi = document.getElementsByClassName('tablajack');

            $("table.tablajack thead tr:nth-child(1) th:nth-child(2)").css("display","none");
            debugger;
            $('table.tablajack').DataTable({
                scrollY: '200px',
                destroy: true,
                sort: true,
                scrollCollapse: true,
                scrollX: true,

                paging: false,
                autoWidth: false,
                processing: false,
                deferRender: false,

                bInfo: false,
                searching: false,
                paging: false,

            });

           
        },
        error: function (jqXHR, textStatus, errorThrown) {}
    });

}
var listajackPots = [];

function ListarPozoJackPotSegunJackPotId(idJackpot) {
    var lista = [];
    var url = basePath + "PozoJackPotSegunJackPotId";
    var idJackpot = idJackpot;
    var dataForm = {
        idJackpot: idJackpot
    };
    //debugger
    // var obj = { name: "John", age: 30, city: "New York" };
    // var myJSON = JSON.stringify(obj);

    $.ajax({
        url: url,
        type: "POST",
        contentType: "application/json",
        data: JSON.stringify(dataForm),
        beforeSend: function () {
            $.LoadingOverlay("show");
        },
        complete: function () {
            $.LoadingOverlay("hide");
        },
        async: false,
        success: function (response) {
            var resp = response;
            debugger;
            var tabEval = document.getElementById('tab-eval');

            var tabContenido = document.getElementById('tabContenido');

            var data = [...resp.data];
            lista = data;

            callback(lista);
        },
        error: function (jqXHR, textStatus, errorThrown) {}
    });
}
var lista = [];

function ListaDeJacks() {
    var list = [...li];
    debugger;
    $.when($.ajax(funcionLlenar())).then(function () {

        $('#cboConfiguracionJackPot').append('<option value="x" >Ninguno</option>');

    });
}


function buscarListarJackPot() {
    //debugger;

    var cboTienda = $("#cboTienda").val();
    var cboConfiguracionJackPot = $("#cboConfiguracionJackPot").val();
    var url = basePath + "ReporteJackPotListarJson";
    var confJack = [...cboConfiguracionJackPot];

    var tiendas = dataTienda;

    //$('#subtituloTabsGeneral').html($("#cboConfiguracionJackPot").text);
    ConfiguracionPozoSegunConfJackPot(confJack[0], tiendas);

    //ListarHistorialGanadores();

}

function JackPotSegunidPozoJackPot(idPozoJackpot) {
    debugger;
    
    var lista = [];
    var url = basePath + "JackPotSegunidPozoJackPot";
    var idPozoJackpot = idPozoJackpot;
    var dataForm = {
        idPozoJackpot: idPozoJackpot
    };
    //debugger
    // var obj = { name: "John", age: 30, city: "New York" };
    // var myJSON = JSON.stringify(obj);

    $.ajax({
        url: url,
        type: "POST",
        contentType: "application/json",
        data: JSON.stringify(dataForm),
        beforeSend: function () {
            $.LoadingOverlay("show");
        },
        complete: function () {
            $.LoadingOverlay("hide");
        },
        async: false,
        success: function (response) {
            var resp = response;
            debugger;
         
            var data = [...resp.data];
            lista = data;

            callbackJackPotSegunidPozoJackPot(lista);
        },
        error: function (jqXHR, textStatus, errorThrown) {}
    });
}

$("#frmNuevo")
    .validate({
        rules: {
            jackPots: {
                required: true,

            },
            tiendas: {
                required: true,

            }
        },
        messages: {
            jackPots: {
                required: '',

            },
            tiendas: {
                required: '',

            }
        },


        errorPlacement: function (error, element) {
            if (element.is(":radio") || element.is(":checkbox")) {
                element.closest('.option-group').after(error);
            } else {
                error.insertAfter(element);
            }
        }
    });
