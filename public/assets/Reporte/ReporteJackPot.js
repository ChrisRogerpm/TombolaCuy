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
        debugger
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
        //ConfiguracionPozoSegunConfJackPot(valor);
    });



    $("#cboConfiguracionJackPot").select2('val', [0]);

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

    debugger
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
            var firstIndex, firstIndexTab;
            tabEval.innerHTML = '';
            tabContenido.innerHTML = ''
            data.map((obj, index) => {
                var index = index + 1;
                firstIndex = (index == 1) ? 'active' : '';
                firstIndexTab = (index == 1) ? 'in active' : '';
                html += `<li class="btn btn-primary ${firstIndex}"><a href="#menu${index}">${obj.JACKPOT}</a></li>`;

                var idJack = obj.idJackPot;
                debugger;


                ListarPozoJackPotSegunJackPotId(obj.idJackPot);

                // $.when($.ajax(ListarPozoJackPotSegunJackPotId(obj.idJackPot))).then(function () {

                //    //codigo se ejecuta despues de que el metodo termine
                // });
                var listaPososJackPot = [];
                var thPozo = '';
                var tdPozo = '';

                var thTiendas = '';
                var tdTiendas = '';
                listaPososJackPot = [...return_first];
                thTiendas = '<th style="font-weight: 600;color:black">Tiendas </th> ';
                tdTiendas='<td style="font-weight: 600;color:black"">Limites</td>';

                var limites =['Inicial','limite inferior','limite superior']
                tiendas.map((obj, index) => {
                    
                    tdTiendas = tdTiendas + `<tr>
                                        <td style="font-weight: 600;color:black">${obj.text} </td>
                                        </tr>`;
                });
                tdPozo = limites.map(x=>'<td style="font-weight: 600;color:black">'+x+'</td>').join('');
                tdPozo = tdPozo.repeat(listaPososJackPot.length);
                listaPososJackPot.map((obj, index) => {
                    thPozo = thPozo + `<th colspan='3'>Pozo ${index+1} (${obj.idPozoJackpot})</th>`;

                    //tdPozo = tdPozo + `<td>Inicial</td>`;
                    //tdPozo = limites.map(x=>'<td>'+x+'</td>').join('');
                });
                
        
                debugger;

                htmlContenidoTabs += `
                <div id="menu${index}" class="tab-pane fade ${firstIndexTab}">
                            <h6>JackPot: ${obj.idJackPot}</h6>
                            <p>JackPot: ${obj.JACKPOT}</p>
                            
                            <div id="divtable" style="display:flex;">
                                <table class="table table-bordered table-striped" style="width:200px;">
                                    <thead>
                                            <tr>
                                                ${thTiendas}
                                            </tr>
                                        </thead>
                                        <tbody>
                                            
                                                
                                                ${tdTiendas}
                                            
                                        </tbody>
                                    </table>
                               
                                    <table id="tablejack-${obj.idJackPot}" class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            ${thPozo}
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            
                                            ${tdPozo}
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                </div>
                        
                `;
              
            });
            tabEval.innerHTML += html;
            tabContenido.innerHTML += htmlContenidoTabs;
            //Esto lo pongo aqui ahora porque 1ero debe dibujarse el doom y despues usar esta funcion
            $("#tab-eval a").click(function () {
                $(this).tab("show");
            })
        },
        error: function (jqXHR, textStatus, errorThrown) {}
    });

}

function ListarPozoJackPotSegunJackPotId(idJackpot) {
    var lista = [];
    var url = basePath + "PozoJackPotSegunJackPotId";
    var idJackpot = idJackpot;
    var dataForm = {
        idJackpot: idJackpot
    };
    debugger
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

function buscarListarJackPot() {
    debugger;

    var cboTienda = $("#cboTienda").val();
    var cboConfiguracionJackPot = $("#cboConfiguracionJackPot").val();
    var url = basePath + "ReporteJackPotListarJson";
    var confJack = [...cboConfiguracionJackPot];

    var tiendas = dataTienda;

    ConfiguracionPozoSegunConfJackPot(confJack[0], tiendas);

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
