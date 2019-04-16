$(document).ready(function () {
    // $(".select2").select2();
    // var dateNow = new Date();
    var d = new Date();
    var datestring = d.getFullYear() + "/" + (d.getMonth()+1) + "/"+ d.getDate();
    $(".Fecha").datetimepicker({
        format: 'YYYY/MM/DD HH:mm:ss',
        defaultDate: datestring,
        useCurrent:'day'
    });

    var dateNow = new Date();
    $(".FechaFin").datetimepicker({
        format: 'YYYY/MM/DD HH:mm:ss',
        defaultDate: dateNow,
    });

    $('.multiselect').select2({
        tags: false, allowClear: true, buttonWidth: '100%',
        width: '100%',
        placeholder: {
            id: '', // the value of the option
            text: '--Seleccione--'
        }
    });
    llenarSelect(basePath + "PuntoVentaListarUsuarioJsonFk", {}, "cboTienda", "idPuntoVenta", "nombre", "allOption", false);
    $("#cboTienda").select2('val', [0]);

    $(document).on('click', '#btnExcel', function () {
        GenerarExcel("table", "Reporte de Apuestas");
    });

    $(document).on('click', '#btnBuscar', function () {
        var validar = $("#frmNuevo");
        if (validar.valid()) {
            var url = basePath + "ReporteApuestaJsonFk";
            var dataForm = $('#frmNuevo').serializeFormJSON();
            $("#ContenedorTabla").html("").append('<table id="table" class="table table-bordered table-striped" style="width:100%"></table>');
            $("#container-excel").html("").append('<a href="#" class="btn btn-success btn-sm col-md-12 col-xs-12" id="btnExcel">\n' +
                '                                        <span class="icon fa fa-fw fa-file-excel-o"></span> Excel\n' +
                '                                    </a>');
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
                    $("#table").append('<tfoot style="background-color: #CCCCCC"><tr><th class="text-center">Total</th><th></th><th class="text-center" id="TotalApuesta"></th><th class="text-center" id="TotalPagos"></th><th></th><th class="text-center" id="TotalJugadores"></th><th></th></tr></tfoot>');
                    GananciaTotal();
                },
                success: function (response) {
                    var resp = response.data;
                    $("#PanelTabla").show();
                    $("#table").DataTable({
                        "bDestroy": true,
                        "bSort": true,
                        "scrollCollapse": true,
                        "scrollX": false,
                        "paging": true,
                        "autoWidth": false,
                        "bProcessing": true,
                        "bDeferRender": true,
                        data: resp,
                        columns: [
                            {data: "Tienda", title: "Tienda", class: "text-center"},
                            {data: "Turno", title: "Turno", class: "text-center"},
                            {data: "apuestas", title: "Apuestas", class: "text-center"},
                            {data: "Pagos", title: "Pagos", class: "text-center"},
                            {data: "Evento", title: "Evento", class: "text-center"},
                            {data: "Jugadores", title: "Jugadores", class: "text-center"},
                            {data: "fechaoperacion", title: "Fecha de Operacion", class: "text-center"},
                        ],
                    });
                },
                error: function (jqXHR, textStatus, errorThrown) {
                }
            });
        }
    });
});

function GananciaTotal() {
    var total;
    var table = $('#table').DataTable();
    var data = table
        .rows()
        .data().toArray();
    var totalApuestas = 0;
    var totalJugadores = 0;
    var totalPagos = 0;
    $.each(data, function (key, value) {
        totalApuestas += parseFloat(value.apuestas);
        totalJugadores += value.Jugadores;
        totalPagos += value.Pagos;
    });
    //return total;
    $('#TotalApuesta').html(totalApuestas.toFixed(2));
    $('#TotalPagos').html(totalPagos);
    $('#TotalJugadores').html(totalJugadores);
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