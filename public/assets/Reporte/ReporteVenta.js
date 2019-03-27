$(document).ready(function () {
    var dateNow = new Date();
    $(".Fecha").datetimepicker({
        // format: 'YYYY/MM/DD HH:mm:ss',
        format: 'YYYY/MM/DD',
        defaultDate: dateNow,
    });
    $(document).on('click', '#btnBuscar', function () {
        var url = basePath + "ReporteVentaJsonFk";
        var dataForm = {
            fechaInicio: $("input[name='fechaInicio']").val(),
            fechaFin: $("input[name='fechaFin']").val(),
            _token: $("input[name='_token']").val()
        };
        ReporteVentaJson(url, dataForm);
    });
    $(document).on('click', '.btnVer', function () {
        $("#ModalVer").modal();
        var Fecha = $(this).data("fecha");
        var Juego = $(this).data("juego");
        var IdJuego = $(this).data("id");
        var Moneda = $(this).data("moneda");
        Ganada = 0;
        $("#Codigo_NombreJuego").html("").html(IdJuego + " [ " + Juego + " ]");
        $("#TitleModal").html("").html(Fecha + ' - ' + Juego);
        $("#ValorTipoJugada").html("").html(Juego);
        $("#ValorGanado").html("").html(parseFloat(Ganada).toFixed(2) + " " + Moneda)
    });
    $(document).on('click', '#btnExcel', function () {
        GenerarExcel("table_panel", "Reporte de Ventas")
    });
});

function GananciaTotal() {
    var table = $('#table_panel').DataTable();
    var data = table
        .rows()
        .data().toArray();
    var total = 0;
    $.each(data, function (key, value) {
        total += value.Ganado;
    });
    return total;
}

function ReporteVentaJson(url, dataForm) {
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
        },
        success: function (response) {
            debugger
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
                    {data: "Fecha", title: "Fecha", class: 'text-center'},
                    {data: "Evento", title: "Evento", class: 'text-center'},
                    {data: "Juego", title: "Juego", class: 'text-center'},
                    {data: "TipoApuesta", title: 'Tipo Apta', class: 'text-center'},
                    {data: "Moneda", title: "Moneda", class: 'text-center'},
                    {data: "estadoEvento", title: "Estado", class: 'text-center'},
                    {data: "Ganado", title: 'Ganado', class: 'text-center'},
                ],
                "drawCallback": function (settings) {
                }
            });

            $(".container-btnExcel").html("").append('<button class="btn btn-success btn-sm col-md-12 col-xs-12" id="btnExcel"><span\n' +
                '                                                class="glyphicon glyphicon-export"></span> Excel\n' +
                '                                    </button>');
            var total = GananciaTotal();
            $("#TotalGanancia").html(total);

        }
    })
}