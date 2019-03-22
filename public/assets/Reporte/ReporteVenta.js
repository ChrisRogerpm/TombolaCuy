$(document).ready(function () {
    var dateNow = new Date();
    $(".Fecha").datetimepicker({
        // format: 'YYYY/MM/DD HH:mm:ss',
        format: 'YYYY/MM/DD',
        defaultDate: dateNow,
    });
    $(document).on('click', '#btnBuscar', function () {
        var url = basePath + "ReporteVentaJson";
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

});

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
            var resp = response.data;
            $("#PanelTabla").show();
            $("#table_panel").DataTable({
                dom: 'Bfrtip',
                buttons: [
                    {
                        extend: 'excelHtml5',
                        title: 'Reporte Ventas',
                        exportOptions: {
                            columns: [0, 1, 2, 3, 4, 5, 6, 7]
                        }
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
                data: resp,
                columns: [
                    {data: "Fecha", title: "Fecha", class: 'text-center'},
                    {data: "Evento", title: "Evento", class: 'text-center'},
                    {data: "Juego", title: "Juego", class: 'text-center'},
                    {
                        data: null, title: 'Tipo Apta',
                        "render": function (value) {
                            return '--';
                        }, class: 'text-center'
                    },
                    {data: "Moneda", title: "Moneda", class: 'text-center'},
                    {
                        data: null, title: "Estado",
                        "render": function (value) {
                            var estado = "";
                            if (value.estadoEvento === 0) {
                                estado = "Anulado";
                            }
                            else if (value.estadoEvento === 1) {
                                estado = "Ejecucion";
                            } else if (value.estadoEvento === 2) {
                                estado = "Terminado";
                            } else if (value.estadoEvento === 3) {
                                estado = "PendPago";
                            } else if (value.estadoEvento === 4) {
                                estado = "Pagado";
                            } else if (value.estadoEvento === 5) {
                                estado = "Suspendido";
                            }
                            return estado;
                        }, class: 'text-center'
                    },
                    {
                        data: "Ganado", title: 'Ganado', class: 'text-center'
                    },
                    // {
                    //     data: null, title: "",
                    //     "render": function (value) {
                    //         return '<button type="button" class="btn btn-success btn-sm btnVer" data-moneda="' + value.Moneda + '" data-id="' + value.idEvento + '" data-fecha="' + value.Fecha + '" data-juego="' + value.Juego + '"><i class="fa fa-eye m-r-20"></i> Ver</button>'
                    //     }, class: "text-center"
                    // }
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