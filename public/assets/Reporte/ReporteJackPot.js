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
    $('#cboConfiguracionJackPot').on('select2:select', function (e) {
        var data = e.params.data;
        var valor = data.id;
        if (valor == 0) {
            $('#cboConfiguracionJackPot').val([]).trigger('change');
            $('#cboConfiguracionJackPot').val(0).trigger('change');
        } else {
            var valores = $('#cboConfiguracionJackPot').val();
            var nuevo = [];
            $.each(valores, function (index, value) {
                if (value != 0) {
                    nuevo.push(value);
                }
            })
            $('#cboConfiguracionJackPot').val(nuevo).trigger('change');
        }

        $('#subtituloTabsGeneral').html(data.text);
        ConfiguracionPozoSegunConfJackPot(valor);
    });


    
    $("#cboConfiguracionJackPot").select2('val', [0]);
    debugger

    $.when($.ajax(funcionLlenar())).then(function () {

        $('#cboConfiguracionJackPot').append('<option value="x" >Ninguno</option>');
    
    });
    
    
   
    
    //Punto de venta Tienda
    $('#cboTienda').on('select2:select', function (e) {
        var data = e.params.data;
        debugger
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
    llenarSelect(basePath + "PuntoVentaListarJson", {}, "cboTienda", "idPuntoVenta", "nombre", "allOption", false);
    $("#cboTienda").select2('val', [0]);
    //dinamico
    $("#tab-eval a").click(function () {
        $(this).tab("show");
    })
    
   
    $(document).on("click", "#btnBuscar", function () {
        ListarJackPot();
    });
});
function funcionLlenar(){
    llenarSelect(basePath + "ConfiguracionJackpotListarJson", {}, "cboConfiguracionJackPot", "idConfiguracionJackpot", "nombre", "allOption", true);
}



function ConfiguracionPozoSegunConfJackPot(idConfiguracionJackpot) {
    //debugger;
    var url = basePath + "ConfiguracionPozoSegunConfJackPot";
    var idConfiguracionJackpot = idConfiguracionJackpot;
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
            $.LoadingOverlay("show");
        },
        complete: function () {
            $.LoadingOverlay("hide");
        },
        success: function (response) {
            var resp = response;
            debugger;
            var tabEval = document.getElementById('tab-eval');

            var tabContenido = document.getElementById('tabContenido');

            var data = [...resp.data];
            var html = '';
            var htmlContenidoTabs = '';
            var firstIndex,firstIndexTab;
            tabEval.innerHTML = '';
            tabContenido.innerHTML=''
            data.map((obj, index) => {
                var index =index+1;
                firstIndex = (index == 1) ? 'active' : '';
                firstIndexTab = (index == 1) ? 'in active' : '';
                html += `<li class="btn btn-primary ${firstIndex}"><a href="#menu${index}">Configuracion ${obj.JACKPOT}</a></li>`;

                htmlContenidoTabs+=`
                <div id="menu${index}" class="tab-pane fade ${firstIndexTab}">
                            <p>JackPot: ${obj.JACKPOT}</p>

                        </div>
                `;
                
            });
            tabEval.innerHTML += html;
            tabContenido.innerHTML+=htmlContenidoTabs;
            //Esto lo pongo aqui ahora porque 1ero debe dibujarse el doom y despues usar esta funcion
            $("#tab-eval a").click(function () {
                $(this).tab("show");
            })
        },
        error: function (jqXHR, textStatus, errorThrown) {}
    });

}



function ListarJackPot() {
    debugger;

    var cboTienda = $("#cboTienda").val();
    var cboConfiguracionJackPot = $("#cboConfiguracionJackPot").val();
    var url = basePath + "ReporteJackPotListarJson";
    var dataForm = $('#frmNuevo').serializeFormJSON();
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

            $("#table").DataTable({
                "bDestroy": true,
                "bSort": true,
                "scrollCollapse": true,
                "scrollX": false,
                "paging": true,
                "autoWidth": false,
                "bProcessing": true,
                "bDeferRender": true,
                data: response.data,

                columns: [

                    {
                        data: "tienda",
                        title: "tienda"
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
                        data: "valor_apuesta_color_rgb",
                        title: "valor_apuesta_color_rgb"
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

            });
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