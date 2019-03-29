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

    $.when($.ajax(funcionLlenar())).then(function () {

        $("#cboConfiguracionJackPot option[value='0']").remove();
    });

    //Punto de venta Tienda

    $('#cboTienda').on('select2:select', function (e) {

        var data = e.params.data;
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
        }
    });

    //cboTienda es idPunto de Venta 
    llenarSelect(basePath + "PuntoVentaListarUsuarioJsonFk", {}, "cboTienda", "idPuntoVenta", "nombre", "allOption", false);
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
        var IdJackpot = $(this).data('id');
        $("#txtIdJackpot").val(IdJackpot);

        var NombreJackpot = $(this).data('nombre');
        $("#txtNombreJackpot").val(NombreJackpot);

        var data = e.target;
        var valor = data.dataset.menu;
        var idcTabl = '#menu' + valor + ' .tablajack';

        var tabla = document.querySelector(idcTabl);
        tabla = tabla.dataset.table;
        var jack = '#jack' + tabla;

        var idc = '#menu' + valor + ' .dataTables_scrollHeadInner .tablajack';


        var tablaSeleccionada = document.querySelector(idc);
        tablaSeleccionada.style.width = '1150px';
        tablaSeleccionada.style.marginLeft = "0px";
    });
});


function funcionLlenar() {
    llenarSelect(basePath + "ConfiguracionJackpotListarJson", {}, "cboConfiguracionJackPot", "idConfiguracionJackpot", "nombre", "allOption", true);
    $("#cboConfiguracionJackPot").select2('val', [0]);
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

var return_JackPotSegunidJackPot;
function callbackJackPotSegunidJackPot(response) {
    return_JackPotSegunidJackPot = response;
    //use return_first variable here
}

function ConfiguracionPozoSegunConfJackPot(idConfiguracionJackpot, tiendas) {
    //;
    var url = basePath + "ConfiguracionPozoSegunConfJackPotFk";
    var ConfiguracionJackpot = [...idConfiguracionJackpot];
    var idConfiguracionJackpot = ConfiguracionJackpot[0];

    if (tiendas[0] == "0") {
        var valAllOptions = $("#cboTienda option").map(function () {
            return this.value;
        }).get();

        var valTiendas = [];
        for (let i = 2; i < valAllOptions.length; i++) {
            valTiendas.push(valAllOptions[i]);
        }
    } else {
        valTiendas = [...tiendas];

    }

    var tiendas = valTiendas;
    debugger
    var dataForm = {
        idConfiguracionJackpot: idConfiguracionJackpot
    };

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
        success: function (response) {


            var resp = response;
            console.log(resp);
            listajackPots = [];
            //
            var tabEval = document.getElementById('tab-eval');

            if ([...resp.data].length == 0) {
                tabEval.innerHTML = `<div class="alert alert-warning" role="alert">
                                    <strong>No Hay Jackpots </strong> 
                                    para Configuración Jackpot elegido.
                                </div>`;
            } else {

                $(".container-btnExcel").html("").append('<button class="btn btn-success btn-sm col-md-12 col-xs-12" id="btnExcel"><span\n' +
                    '                                                class="glyphicon glyphicon-export"></span> Excel\n' +
                    '                                    </button>');

                var tabContenido = document.getElementById('tabContenido');

                var data = [...resp.data];
                var html = '';
                var htmlContenidoTabs = '';
                var firstIndex, firstIndexTab;
                tabEval.innerHTML = '';
                tabContenido.innerHTML = ''
                data.map((obj, index) => {
                    var index = index + 1;
                    firstIndex = (index == 1) ? 'active' : '';
                    firstIndexTab = (index == 1) ? 'in active' : '';


                    if (index === 1) {
                        $("#txtNombreJackpot").val(obj.JACKPOT);
                        $("#txtIdJackpot").val(obj.idJackPot);
                    }

                    html += `<li class="${firstIndex}" style="margin-right:5px;"><a class="tabClick" data-nombre="${obj.JACKPOT}" href="#menu${index}" data-id="${obj.idJackPot}" data-menu=${index}>${obj.JACKPOT}</a></li>`;

                    var idJack = obj.idJackPot;

                    listajackPots.push(obj.idJackPot);

                    ListarPozoJackPotSegunJackPotId(obj.idJackPot);


                    var listaPososJackPot = [];
                    var thPozo = '';
                    var tdPozo = '',
                        tdPozoOculto = '';

                    var thTiendas = '';

                    listaPososJackPot = [...return_first];

                    if (listaPososJackPot.length == 0) {
                        tabEval.innerHTML = `<div class="alert alert-warning" role="alert">
                                                <strong>No Hay Pozos </strong> 
                                                para el Jackpot.
                                            </div>`;
                    } else {



                        var limites = ['Incremento', 'Límite Inferior', 'Límite Superior']

                        tdPozo = limites.map(x => '<th style="font-weight: 600;color:black;text-align:center;">' + x + '</th>\n').join('');
                        tdPozo = tdPozo + limites.map(x => '<th style="font-weight: 600;color:steelblue;text-align:center;">' + x + ' Oculto</th>\n').join('');
                        tdPozo = tdPozo.repeat(listaPososJackPot.length);


                        var listaJackPotSegunidJackPot = [];


                        var tdBody = '';
                        var trBody;
                        var bodyJackpot = '';

                        listaPososJackPot.map((obj, index) => {
                            thPozo = thPozo + `<th colspan='3'style="color:black;width:110px;text-align:center;">Pozo ${index + 1} (${obj.idPozoJackpot})</th>\n
                                        <th colspan='3' style="color:steelblue;width:110px;text-align:center">Pozo Oculto ${index + 1} (${obj.idPozoJackpot})</th>\n`;

                        });

                        JackPotSegunidJackPot(obj.idJackPot);

                        listaJackPotSegunidJackPot = [...listaJackPotSegunidJackPot, ...return_JackPotSegunidJackPot];

                        debugger
                        for (let t = 0; t < tiendas.length; t++) {
                            var idTienda = tiendas[t];

                            var listaJacks = listaJackPotSegunidJackPot.filter(x => x.idPuntoVenta == idTienda);
                            var tiendaRepetida = '';
                            for (let l = 0; l < listaJacks.length; l++) {

                                const element = listaJacks[l].TIENDA;
                                tiendaRepetida = element;
                            }

                            tdBody += `<td>${tiendaRepetida}</td>`;
                            for (let p = 0; p < listaJacks.length; p++) {
                                var element = listaJacks[p];
                                tdBody += `
                            <td> ${element.incrementoJackpot}</td>
                            <td> ${element.limiteInferior}</td>
                            <td> ${element.limiteSuperior}</td>
                            <td> ${element.incrementoPozoOculto}</td>
                            <td> ${element.limiteInferiorOculto}</td>
                            <td> ${element.limiteSuperiorOculto}</td>`;
                                trBody = '<tr>' + tdBody + '</tr>';
                                //
                            }
                            trBody = (trBody != null) ? trBody : '';
                            bodyJackpot += trBody + "\n";
                            trBody = '';
                            tdBody = '';


                        }

                        var thp = '';

                        thp = tdPozo;

                        ; debugger
                        var listaTabla = '';
                        if (listaPososJackPot.length == 0) {
                            listaTabla = `
                                        <div class="alert alert-warning" role="alert">
                                                 <strong>No Hay Pozos </strong> 
                                                 para el Jackpot.
                                             </div>`;
                        } else {
                            listaTabla = `<div id="divtable${obj.idJackPot}" style="display:flex;padding:0;" class="panel-body">
                                                    
                                                
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
                                        </div>`;
                        }
                        htmlContenidoTabs += `
                        <div id="menu${index}" class="tab-pane fade ${firstIndexTab}">
                                    <h6>JackPot: ${obj.idJackPot}</h6>
                                    <p>JackPot: ${obj.JACKPOT}</p>
                                    
                                    ${listaTabla}
                        </div>
                
                
                        `;

                    }
                });

                tiendas = [];
                tabEval.innerHTML += html;
                tabContenido.innerHTML += htmlContenidoTabs;
                bodyJackpot = '';
                //1ero debe dibujarse el doom y despues usar esta funcion
                $("#tab-eval a").click(function () {
                    $(this).tab("show");
                })


                $("table.tablajack thead tr:nth-child(1) th:nth-child(2)").css("display", "none");;

                $('table.tablajack').DataTable({
                    dom: 'Bfrtip',
                    buttons: [{
                        extend: 'excel',
                        title: 'Reporte JackPot'
                    }
                    ],
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
            }
        },
        error: function (jqXHR, textStatus, errorThrown) { 
            
        }
    });

}

var listajackPots = [];

function ListarPozoJackPotSegunJackPotId(idJackpot) {
    var lista = [];
    var url = basePath + "PozoJackPotSegunJackPotIdFk";
    var idJackpot = idJackpot;
    var dataForm = {
        idJackpot: idJackpot
    };

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

            var tabEval = document.getElementById('tab-eval');

            var tabContenido = document.getElementById('tabContenido');

            var data = [...resp.data];
            lista = data;

            callback(lista);
        },
        error: function (jqXHR, textStatus, errorThrown) { }
    });
}

var lista = [];

function ListaDeJacks() {
    var list = [...li];
    ;
    $.when($.ajax(funcionLlenar())).then(function () {

        $('#cboConfiguracionJackPot').append('<option value="x" >Ninguno</option>');

    });
}


function buscarListarJackPot() {
    ;
    var validar = $("#frmNuevo");
    if (validar.valid()) {
        var cboTienda = $("#cboTienda").val();
        var cboConfiguracionJackPot = $("#cboConfiguracionJackPot").val();
        var url = basePath + "ReporteJackPotListarJson";
        var confJack = [...cboConfiguracionJackPot];

        var tabContenido = document.getElementById("tabContenido");
        if (tabContenido != undefined || tabContenido != null) {
            tabContenido.innerHTML = ""; //limpiar Tab    
        }

        // var TiendaArray = [];
        // $("#cboTienda option:selected").each(function () {
        //     if ($(this).val() !== "") {
        //         TiendaArray.push({'id': $(this).val(), 'Tienda': $(this).text()})
        //     }
        // });
        var tiendas = cboTienda;

        debugger

        ConfiguracionPozoSegunConfJackPot(confJack[0], tiendas);

    }

}

function JackPotSegunidJackPot(idJackpot) {
    ;

    var lista = [];
    var url = basePath + "JackPotSegunidJackpotFk";
    var idJackpot = idJackpot;
    var dataForm = {
        idJackpot: idJackpot
    };

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
            ;

            var data = [...resp.data];
            lista = data;

            callbackJackPotSegunidJackPot(lista);
        },
        error: function (jqXHR, textStatus, errorThrown) { }
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
                required: 'Eliga una configuración',

            },
            tiendas: {
                required: 'Eliga una o mas tiendas',
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
