$(document).ready(function () {
    MostrarDataCierreCaja();
});

function MostrarDataCierreCaja() {
    // $.ajax({
    //     type: 'POST',
    //     url: basePath + "ReporteCierreCajaFk",
    //     success: function (response) {
    //         var data = response.data[0];
    //         console.log(data);
    //         $("#Caja").val(data.caja);
    //         $("#PuntoVenta").val(data.caja);
    //         $("#Venta").val(data.Venta);
    //         $("#Pago").val(data.Pagado);
    //         $("#Total").val(parseFloat(data.Venta) - parseFloat(data.Pagado));
    //     }
    // });
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
                data: response.data,

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