$(document).ready(function () {
    MostrarDataCierreCaja();
    $(document).on('click', '#btnCierreCaja', function () {
        var idAperturacaja = $("#idAperturaCaja").val();
        if (idAperturacaja !== "") {
            $.ajax({
                type: 'POST',
                url: basePath + "",
                success: function (response) {
                    var respuesta = response.respuesta;
                    if (respuesta) {
                        toastr.success('Se ha cerrado la caja exitosamente');
                    } else {
                        toastr.warning(response.mensaje, '');
                    }
                }
            })
        }
    });
});

function MostrarDataCierreCaja() {
    var url = basePath + "ReporteCierreCajaFk";
    $.ajax({
        url: url,
        type: "POST",
        beforeSend: function () {
            $.LoadingOverlay("show");
        },
        complete: function () {
            $.LoadingOverlay("hide");
        },
        success: function (response) {
            var data = response.data;

            if (data.length > 0) {
                $("#btnCierreCaja").attr('disabled', false);
            } else {
                $("#btnCierreCaja").attr('disabled', true);
            }

            $("#idAperturaCaja").val(data[0].idAperturaCaja);
            $("#table").DataTable({
                dom: 'Bfrtip',
                buttons: [
                    {
                        extend: 'excelHtml5',
                        title: 'Reporte Cierre de Caja'
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
                data: data,

                columns: [
                    {data: "caja", title: "Caja"},
                    {data: "puntoventa", title: "Punto de Venta"},
                    {data: "Venta", title: "Venta"},
                    {data: "Pagado", title: "Pagado"},
                    {
                        data: null, title: "Total",
                        "render": function (value) {
                            return value.Venta - value.Pagado;
                        }
                    }
                ],

            });
        },
        error: function (jqXHR, textStatus, errorThrown) {
        }
    });
}