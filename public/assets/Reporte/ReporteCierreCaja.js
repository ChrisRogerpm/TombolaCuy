$(document).ready(function () {
    MostrarDataCierreCaja();
    $(document).on('click', '#btnCierreCaja', function () {
        $("#ModalConfirmacion").modal({
            backdrop: 'static',
            keyboard: false
        });
    });

    $(document).on('click','#btnConfirmar',function () {
        var idAperturacaja = $("#idAperturaCaja").val();
        if (idAperturacaja !== "") {
            var dataForm = {
                'idAperturaCaja': idAperturacaja
            };
            $.ajax({
                type: 'POST',
                url: basePath + "AperturaCajaCerrarFk",
                data: dataForm,
                success: function (response) {
                    var respuesta = response.respuesta;
                    if (respuesta) {
                        toastr.success('Se ha cerrado la caja exitosamente');
                        $("#ModalConfirmacion").modal("hide");
                        MostrarDataCierreCaja();
                    } else {
                        toastr.warning(response.mensaje, '');
                    }
                }
            })
        }
    })
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
                $("#idAperturaCaja").val(data[0].idAperturaCaja);
            } else {
                $("#btnCierreCaja").attr('disabled', true);
            }

            $("#table").DataTable({
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
                        data: null, title: "Utilidad",
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