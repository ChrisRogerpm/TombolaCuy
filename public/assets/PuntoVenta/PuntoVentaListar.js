$(document).ready(function () {
    ListarPuntoVenta();
    $(document).on('click', '.btnEditar', function () {
        var idPuntoVenta = $(this).data("id");
        var url = basePath + "PuntoVentaEditar/" + idPuntoVenta;
        window.location.replace(url);
    })
    $(document).on('click', '#btnSincronizar', function () {
        $.ajax({
            type: 'POST',
            url: basePath + 'SincronizarPuntoVenta',
            data: {
                '_token': $('input[name=_token]').val(),
            },
            beforeSend: function () {
                $.LoadingOverlay("show");
            },
            complete: function () {
                $.LoadingOverlay("hide");
            },
            success: function (response) {
                var respuesta = response.respuesta;
                if (respuesta === true) {
                    toastr.success("Se Sincronizo Correctamente", "Mensaje Servidor");
                    ListarPuntoVenta();
                } else {
                    toastr.error(response.mensaje, "Mensaje Servidor");
                }
            }
        });
    });
});

function ListarPuntoVenta() {
    $.ajax({
        type: 'POST',
        url: basePath + 'PuntoVentaListarJson',
        data: {
            '_token': $('input[name=_token]').val(),
        },
        beforeSend: function () {
            $.LoadingOverlay("show");
        },
        complete: function () {
            $.LoadingOverlay("hide");
        },
        success: function (response) {
            var resp = response.data;
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
                    { data: "nombre", title: "Punto de Venta" },
                    { data: "razonSocial", title: "Empresa" },
                    { data: "Ubigeo", title: "Ubigeo" },
                    {
                        data: null, title: "",
                        "render": function (value) {
                            return '<button type="button" class="btn btn-success btn-sm btnEditar" data-id="' + value.idPuntoVenta + '"><i class="fa fa-edit"></i></button>';
                        }
                    }
                ],
                "drawCallback": function (settings) {
                    $('.btnEditar').tooltip({
                        title: "Editar"
                    });
                }
            });
        },
    })
}