$(document).ready(function () {
    // var dateNow = new Date();
    // $(".Fecha").datetimepicker({
    //     format: 'YYYY/MM/DD HH:mm:ss',
    //     defaultDate: dateNow,
    // });

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

    $(document).on('click', '#btnBuscar', function () {
        var url = basePath + "ReporteHistorialTicketJsonFk";
        var dataForm = $('#frmNuevo').serializeFormJSON();
        ReporteHistorialTicket(url, dataForm);
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


    llenarSelect(basePath + "PuntoVentaListarUsuarioJsonFk", {}, "cboTienda", "idPuntoVenta", "nombre", "allOption", false);
    $("#cboTienda").select2('val', [0]);

    $(document).on('click', '#btnExcel', function () {
        GenerarExcel("table_panel", "Reporte Historial Tickets");
    });

});

function ReporteHistorialTicket(url, dataForm) {
    $.ajax({
        type: 'POST',
        url: url,
        contentType: "application/json",
        data: JSON.stringify(dataForm),
        beforeSend: function () {
            $.LoadingOverlay("show");
        },
        complete: function () {
            $.LoadingOverlay("hide");
            Totales();
        },
        success: function (response) {
            $("#container-excel").html("").append('<a href="#" class="btn btn-success btn-sm col-md-12 col-xs-12" id="btnExcel">\n' +
                '                                        <span class="icon fa fa-fw fa-file-excel-o"></span> Excel\n' +
                '                                    </a>');

            var resp = response.data;
            $("#PanelTabla").show();
            $("#table_panel").DataTable({
                "bDestroy": true,
                "bSort": true,
                "scrollCollapse": true,
                "scrollX": false,
                "paging": true,
                "autoWidth": false,
                "bProcessing": true,
                "bDeferRender": true,
                "order": [[1, "desc"]],
                data: resp,
                columns: [
                    {data: "fechaevento", title: "Fecha Evento", class: 'text-center'},
                    {data: "juego", title: "Juego", class: 'text-center'},
                    {data: "idEvento", title: "Evento", class: 'text-center'},
                    {data: "idticket", title: "Ticket", class: 'text-center'},
                    {data: "fechaApuesta", title: "Fecha Apuesta", class: 'text-center'},
                    {data: "puntoventa", title: "Punto de Venta", class: 'text-center'},
                    {data: "fechapago", title: "Fecha de Pago", class: 'text-center'},
                    {data: "puntoventapago", title: "Punto de Venta de Pago", class: 'text-center'},
                    {data: "apostado", title: "Apostado", class: 'text-center'},
                    {data: "pagado", title: "Pagado", class: 'text-center'},
                    {data: "utilidad", title: "Utilidad", class: 'text-center'},
                    {data: "valores", title: "Valores", class: 'text-center'},
                ],
                "drawCallback": function (settings) {
                    $('.btnVer').tooltip({
                        title: "Ver"
                    });
                }
            });
        }
    })
}

function Totales() {
    var table = $('#table_panel').DataTable();
    var data = table
        .rows()
        .data().toArray();
    var totalapostado = 0;
    var totalpagado = 0;
    var totalutilidad = 0;
    $.each(data, function (key, value) {
        totalapostado += parseFloat(value.apostado);
        totalpagado += value.pagado;
        totalutilidad += value.utilidad;
    });
    //return total;
    $('#TotalApostado').html(totalapostado.toFixed(2));
    $('#TotalPagado').html(totalpagado);
    $('#TotalUtilidad').html(totalutilidad);
}