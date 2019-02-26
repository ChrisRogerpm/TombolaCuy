$(document).ready(function () {
    $(".Fecha").datetimepicker({
        format: 'YYYY/MM/DD HH:mm:ss',
    });

    $(document).on('click', '.btnJuego', function (e) {
        e.preventDefault();
        var IdJuego = $(this).data("id");
        var url = basePath + "ReporteVentaJuego";
        var dataForm = {
            IdJuego: IdJuego,
            _token: $("input[name='_token']").val()
        };
        $("#txtIdJuego").val(IdJuego);
        $(".Fecha").val("");
        ReporteVentaJson(url, dataForm);
        $("#btnBuscar").attr('disabled', false);
    });

    $(document).on('click', '#btnBuscar', function () {
        var url = basePath + "ReporteVentaJuego";
        var dataForm = $('#frmNuevo').serializeFormJSON();
        ReporteVentaJson(url, dataForm);
    });

    $(document).on('click','#btnExcel',function () {

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
                // dom: 'Bfrtip',
                // buttons: [
                //     {
                //         extend: 'excelHtml5',
                //         title: 'Reporte Ventas',
                //     }
                // ],
                "bDestroy": true,
                "bSort": true,
                "scrollCollapse": true,
                "scrollX": false,
                "paging": true,
                "autoWidth": false,
                "bProcessing": true,
                "bDeferRender": true,
                "ordering": false,
                data: resp,
                columns: [
                    {
                        data: null, title: "#", class: 'text-center', "render": function (value) {
                            return '#' + value.idEvento;
                        }
                    },
                    {data: "fechaEvento", title: "Fecha Evento", class: 'text-center'},

                    {
                        data: null, title: "Nro Ganador", class: 'text-center', "render": function (value) {
                            return '<span class="badge badge-warning" style="padding-top: 7px;padding-bottom: 7px;">' + value.ValorGanador + '</span>';
                        }
                    },
                    {
                        data: null, title: "Descripcion",
                        "render": function (value) {
                            return 'Número - ' + value.ValorGanador + ' / ' + value.Descripcion;
                        }
                    }
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
