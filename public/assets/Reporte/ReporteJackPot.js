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

                debugger
                listaPososJackPot.map((obj, index) => {
                    thPozo = thPozo + `<th colspan='3'style="color:black;width:110px;text-align:center;">Pozo ${index+1} (${obj.idPozoJackpot})</th>\n
                                        <th colspan='3' style="color:steelblue;width:110px;text-align:center">Pozo Oculto ${index+1} (${obj.idPozoJackpot})</th>\n`;

                    //tdPozo = tdPozo + `<td>Inicial</td>`;
                    //tdPozo = limites.map(x=>'<td>'+x+'</td>').join('');
                });
                
                // tdPozoOculto = tdPozoOculto + limites.map(x => '<td style="font-weight: 600;color:blue">' + x + ' Oculto</td>').join('');

                // tdPozoOculto = tdPozoOculto.repeat(listaPososJackPot.length);
                //tdPozo += tdPozoOculto;
                // listaPososJackPot.map((obj, index) => {
                //     thPozo = thPozo + `<th colspan='3'>Pozo Oculto ${index+1} (${obj.idPozoJackpot})</th>`;

                //     //tdPozo = tdPozo + `<td>Inicial</td>`;
                //     //tdPozo = limites.map(x=>'<td>'+x+'</td>').join('');
                // });
                var thp = '';
                //thp = `<th style="display:none;">f</th>`;
                // for (let j = 0; j < (listaPososJackPot.length * 6); j++) {
                //     thp = thp + `<th style="display:none;">f</th>`;
                // }
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
    debugger;

    var cboTienda = $("#cboTienda").val();
    var cboConfiguracionJackPot = $("#cboConfiguracionJackPot").val();
    var url = basePath + "ReporteJackPotListarJson";
    var confJack = [...cboConfiguracionJackPot];

    var tiendas = dataTienda;

    //$('#subtituloTabsGeneral').html($("#cboConfiguracionJackPot").text);
    ConfiguracionPozoSegunConfJackPot(confJack[0], tiendas);

    //ListarHistorialGanadores();

}

function ListarHistorialGanadores() {
    debugger;
    var fechaInicial = $("#fechaInicio").val();
    var fechaFinal = $("#fechaFin").val();

    var cboTienda = $("#cboTienda").val();

    var url = basePath + "ReporteHistorialGanadoresListarJson";
    var dataForm = $('#frmNuevo').serializeFormJSON();

    resp = [ // resp = [
        {
            tienda: "tienda 1",
            evento: "evento 1",
            fecha: "25/01/19 14:30", // {tienda: "tienda 1", evento: "evento 1", fecha: "25/01/19 14:30", 
            total_jugadores: 55,
            total_ganadores: 3, // total_jugadores: 55, total_ganadores: 3, 
            monto_total_apostado: 3,
            monto_total_pagado: 4, // monto_total_apostado: 3, monto_total_pagado: 4, 
            NR_ticket_ganador: 32,
            tipo_de_apuesta: "color",
            valor_de_apuesta: "verde"
        } // NR_ticket_ganador: 32, tipo_de_apuesta: "color", valor_de_apuesta: "verde"}
        , // ,
        {
            tienda: "tienda 1",
            evento: "evento 1",
            fecha: "25/01/19 15:30", // {tienda: "tienda 1", evento: "evento 1", fecha: "25/01/19 15:30", 
            total_jugadores: 53,
            total_ganadores: 3, // total_jugadores: 53, total_ganadores: 3, 
            monto_total_apostado: 3,
            monto_total_pagado: 4, // monto_total_apostado: 3, monto_total_pagado: 4, 
            NR_ticket_ganador: 32,
            tipo_de_apuesta: "color",
            valor_de_apuesta: "rojo"
        } // NR_ticket_ganador: 32, tipo_de_apuesta: "color", valor_de_apuesta: "rojo"}
        , // ,
        {
            tienda: "tienda 1",
            evento: "evento 1",
            fecha: "25/01/19 15:50", // {tienda: "tienda 1", evento: "evento 1", fecha: "25/01/19 15:50", 
            total_jugadores: 53,
            total_ganadores: 3, // total_jugadores: 53, total_ganadores: 3, 
            monto_total_apostado: 3,
            monto_total_pagado: 4, // monto_total_apostado: 3, monto_total_pagado: 4, 
            NR_ticket_ganador: 32,
            tipo_de_apuesta: "color",
            valor_de_apuesta: "negro"
        } // NR_ticket_ganador: 32, tipo_de_apuesta: "color", valor_de_apuesta: "negro"}
        , // ,
        {
            tienda: "tienda 1",
            evento: "evento 1",
            fecha: "26/01/19 15:50", // {tienda: "tienda 1", evento: "evento 1", fecha: "26/01/19 15:50", 
            total_jugadores: 53,
            total_ganadores: 2, // total_jugadores: 53, total_ganadores: 2, 
            monto_total_apostado: 3,
            monto_total_pagado: 4, // monto_total_apostado: 3, monto_total_pagado: 4, 
            NR_ticket_ganador: 32,
            tipo_de_apuesta: "pleno",
            valor_de_apuesta: "2"
        } // NR_ticket_ganador: 32, tipo_de_apuesta: "pleno", valor_de_apuesta: "2"}
        , // ,
        {
            tienda: "tienda 1",
            evento: "evento 1",
            fecha: "25/01/19 16:30", // {tienda: "tienda 1", evento: "evento 1", fecha: "25/01/19 16:30", 
            total_jugadores: 53,
            total_ganadores: 3, // total_jugadores: 53, total_ganadores: 3, 
            monto_total_apostado: 3,
            monto_total_pagado: 4, // monto_total_apostado: 3, monto_total_pagado: 4, 
            NR_ticket_ganador: 32,
            tipo_de_apuesta: "caja bloqueada",
            valor_de_apuesta: "0"
        } // NR_ticket_ganador: 32, tipo_de_apuesta: "caja bloqueada", valor_de_apuesta: "0"}
    ];

    $("#table").DataTable({
        scrollY: '200px',
        destroy: true,
        sort: true,
        scrollCollapse: true,
        scrollX: true,

        paging: true,
        autoWidth: true,
        processing: true,
        deferRender: true,

        bInfo: false,
        searching: false,
        paging: false,

        // columnDefs: [
        //     { targets: [0, 1], visible: true},
        //     { targets: '_all', visible: false }
        // ],
        data: resp,
        columns: [


            {
                data: "tienda",
                title: "tienda",

            },
            {
                data: "evento",
                title: "evento"
            },
            {
                data: "fecha",
                title: "fecha"
            },
            {
                data: "total_jugadores",
                title: "total jugadores"
            },
            {
                data: "total_ganadores",
                title: "total ganadores"
            },
            {
                data: "monto_total_apostado",
                title: "monto total apostado"
            },
            {
                data: "monto_total_pagado",
                title: "monto total pagado"
            },
            {
                data: "NR_ticket_ganador",
                title: "NR ticket ganador"
            },
            {
                data: "tipo_de_apuesta",
                title: "tipo de apuesta"
            },


            {
                data: "valor_de_apuesta",
                title: "valor de apuesta",
                "render": function (value, i, j) {

                    var valorRetornar = j.valor_de_apuesta;
                    var valor_de_apuesta = '';
                    valor_de_apuesta = j.valor_de_apuesta;
                    var tipo_de_apuesta = j.tipo_de_apuesta;
                    if (tipo_de_apuesta == "pleno") {
                        valorRetornar = `<div style='width:100%;text-align:center;''>${valor_de_apuesta} </div>`;
                    }
                    if (tipo_de_apuesta == "color") {
                        if (valor_de_apuesta == "verde") {
                            valorRetornar = 'darkGreen';
                        }
                        if (valor_de_apuesta == "rojo") {
                            valorRetornar = 'DarkRed';
                        }
                        if (valor_de_apuesta == "negro") {
                            valorRetornar = 'Black';
                        }
                        if (tipo_de_apuesta == "caja bloqueada") {
                            valorRetornar = "CASA";
                        }
                        valorRetornar = `<div style='width:100%;color:white;text-align:center;background-color: ${valorRetornar};'> ${valor_de_apuesta}</div>`
                    }
                    if (tipo_de_apuesta == "caja bloqueada")
                        valorRetornar = `<span  style="width: 100%;text-align: center" class="glyphicon glyphicon-home"></span>`;

                    return valorRetornar;


                }
            },
        ],
        createdRow: function (row, data, dataIndex) {

            debugger
            // If name is "Ashton Cox"

            // Add COLSPAN attribute
            $('td:eq(1)', row).attr('colspan', 3);

            // Center horizontally
            $('td:eq(1)', row).attr('align', 'center');

            // Hide required number of columns
            // next to the cell with COLSPAN attribute
            $('td:eq(2)', row).css('display', 'none');
            $('td:eq(3)', row).css('display', 'none');

            // Update cell data
            this.api().cell($('td:eq(1)', row)).data('N/A');

        },
        rowCallback: function (row, data) {
            var row = row;
            var data = data;
            debugger
        }
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
