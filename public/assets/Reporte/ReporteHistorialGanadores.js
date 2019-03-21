$(document).ready(function () {
    //$(".select2").select2();
    var dateNow = new Date();
    $(".hasDatepicker").datetimepicker({
        pickTime: false,
        format: 'YYYY/MM/DD',
        defaultDate: dateNow,
        maxDate: dateNow
    });

    $('.multiselect').select2({
        tags: false, allowClear: true, buttonWidth: '100%',
        width: '100%',
        placeholder: {
            id: '', // the value of the option
            text: '--Seleccione--'
        }
    });    

    $('#cboTienda').on('select2:select', function (e) {
        var data = e.params.data;
        var valor = data.id;
        if (valor == 0) {
            $('#cboTienda').val([]).trigger('change');
            $('#cboTienda').val(0).trigger('change');
        }
        else {
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
    $("#fechaInicio").val("01/01/2018");
    llenarSelect(basePath + "PuntoVentaListarJson", {}, "cboTienda", "idPuntoVenta", "nombre", "allOption",false);
    $("#cboTienda").select2('val', [0]);   
    
    $(document).on("click", "#btnBuscar", function () {
        ListarHistorialGanadores();
    });
});

function ListarHistorialGanadores() {
    var fechaInicial = $("#fechaInicio").val();
    var fechaFinal = $("#fechaFin").val();
    
    var cboTienda = $("#cboTienda").val();
    
    var url = basePath + "ReporteHistorialGanadoresListarJson";
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
            dom: 'Bfrtip',
                    
            buttons: [
                {
                    extend: 'excelHtml5',
                    title: 'Reporte Historial de Ganadores'
                    
                },
                
                {
                    extend: 'pdfHtml5',
                    title: 'Reporte Historial de Ganadores'
                },
                {
                    extend: 'print',
                    title: 'Reporte Historial de Ganadores'
                }
            ],
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

            {data: "tienda", title: "Tienda"},
            {data: "evento", title: "Evento"},
            {data: "fecha", title: "Fecha"},
            {data: "total_jugadores", title: "Total jugadores"},
            {data: "total_ganadores", title: "Total ganadores"},
            {data: "monto_total_apostado", title: "Monto total apostado"},
            {data: "monto_total_pagado", title: "Monto total pagado"},
            {data: "NR_ticket_ganador", title: "Nº ticket ganador"},
            {data: "tipo_de_apuesta", title: "Tipo de apuesta"},

            {data: "valor_apuesta_color_rgb", title: "Color"},

            
            {   
                data: "valor_de_apuesta", 
                title: "valor de apuesta",
                "render": function (value, i, j) {

                    var valorRetornar = j.valor_de_apuesta;
                    var valor_de_apuesta = '';
                    valor_de_apuesta = j.valor_de_apuesta;
                    var tipo_de_apuesta = j.tipo_de_apuesta;
                    if (tipo_de_apuesta=="pleno") {
                        valorRetornar=`<div style='width:100%;text-align:center;''>${valor_de_apuesta} </div>`;
                    }
                    if (tipo_de_apuesta=="color") {
                        if (valor_de_apuesta=="verde") {
                            valorRetornar='darkGreen';
                        }
                        if (valor_de_apuesta=="rojo") {
                            valorRetornar='DarkRed';
                        }
                        if (valor_de_apuesta=="negro") {
                            valorRetornar='Black';
                        }
                        if (tipo_de_apuesta=="caja bloqueada") {
                            valorRetornar = "CASA";
                        }
                        valorRetornar = `<div style='width:100%;color:white;text-align:center;background-color: ${valorRetornar};'> ${valor_de_apuesta}</div>`            
                    }
                    if (tipo_de_apuesta=="caja bloqueada") 
                        valorRetornar = `<span  style="width: 100%;text-align: center" class="glyphicon glyphicon-home"></span>`;            

                    return valorRetornar;


                }
            },

            ],

        });
       },
       error: function (jqXHR, textStatus, errorThrown) {
       }
   });
}
$("#frmNuevo")
    .validate({
        rules: {
            fechaInicio:
            {
                required: true,

            }, fechaFin:
            {
                required: true,

            }, tiendas:
            {
                required: true,

            }
        },
        messages: {
            fechaInicio:
            {
                required: '',

            }, fechaFin:
            {
                required: '',

            }, tiendas:
            {
                required: '',

            }
        },


        errorPlacement: function (error, element) {
            if (element.is(":radio") || element.is(":checkbox")) {
                element.closest('.option-group').after(error);
            }
            else {
                error.insertAfter(element);
            }
        }
    });