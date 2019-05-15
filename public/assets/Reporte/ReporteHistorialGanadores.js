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

    $(document).on('click', '#btnExcel', function () {
        GenerarExcel("table", "Reporte Detalle Apuesta Evento");
    });


    //cboTienda es idPunto de Venta
    llenarSelect(basePath + "PuntoVentaListarUsuarioJsonFk", {}, "cboTienda", "idPuntoVenta", "nombre", "allOption", false);
    $("#cboTienda").select2('val', [0]);

    $(document).on("click", "#btnBuscar", function () {
        ListarHistorialGanadores();
    });
});

function ListarHistorialGanadores() {
    var fechaInicial = $("#fechaInicio").val();
    var fechaFinal = $("#fechaFin").val();

    var cboTienda = $("#cboTienda").val();

    var url = basePath + "ReporteHistorialGanadoresListarJsonFk";
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
            $("#container-excel").html("").append('<a href="#" class="btn btn-success btn-sm col-md-12 col-xs-12" id="btnExcel">\n' +
                '                                        <span class="icon fa fa-fw fa-file-excel-o"></span> Excel\n' +
                '                                    </a>');
            $("#container-tabla").show();
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
                    {data: "tienda", title: "Tienda", class: "text-center"},
                    {data: "Turno", title: "Turno", class: "text-center"},
                    {data: "Evento", title: "Evento", class: "text-center"},
                    {data: "fechaoperacion", title: "Fecha", class: "text-center"},
                    {data: "Jugadores", title: "Total jugadores", class: "text-center"},
                    {data: "totalganadores", title: "Total ganadores", class: "text-center"},
                    {data: "apuestas", title: "Monto total apostado", class: "text-center"},
                    {data: "Pagos", title: "Monto total pagado", class: "text-center"},
                    {data: "ganador", title: "Pleno", class: "text-center"},
                    {data: "TipoApuesta", title: "Tipo de apuesta", class: "text-center"},
                    {
                        data: "color", title: "Color",
                        "render": function (value) {
                            return '<span class="badge" style="padding-top: 10px;padding-bottom: 5px;background-color: ' + value + ';"> * </span>';
                        }, class: "text-center"
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