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
    llenarSelect(basePath + "PuntoVentaListarUsuarioJson", {}, "cboTienda", "idPuntoVenta", "nombre", "allOption", false);
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
                    {data: "Evento", title: "Evento"},
                    {data: "fechaoperacion", title: "Fecha"},
                    {data: "Jugadores", title: "Total jugadores"},
                    {data: "totalganadores", title: "Total ganadores"},
                    {data: "apuestas", title: "Monto total apostado"},
                    {data: "Pagos", title: "Monto total pagado"},
                    {data: "ganador", title: "Pleno"},
                    {data: "TipoApuesta", title: "Tipo de apuesta"},
                    {
                        data: "color", title: "Color",
                        "render": function (value) {
                            return '<span class="badge" style="padding-top: 7px;padding-bottom: 7px; background-color: ' + value + '"> * </span>';
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