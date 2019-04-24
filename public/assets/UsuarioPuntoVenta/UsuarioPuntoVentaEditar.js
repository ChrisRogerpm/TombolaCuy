$(document).ready(function () {
    ListarPuntoVenta();
    $(document).on('ifChecked', '#table input:checkbox', function () {
        var idPuntoVenta = $(this).data('id');
        var idUsuario = $("#IdUsuario").val();
        AgregarPuntoVenta(idPuntoVenta, idUsuario);

    });
    $(document).on('ifUnchecked', '#table input:checkbox', function () {
        var idPuntoVenta = $(this).data('id');
        var idUsuario = $("#IdUsuario").val();
        QuitarPuntoVenta(idPuntoVenta, idUsuario);
    });
});


function AgregarPuntoVenta(IdPuntoVenta, IdUsuario) {
    var dataForm = {
        'IdPuntoVenta': IdPuntoVenta,
        'IdUsuario': IdUsuario
    };
    $.ajax({
        type: 'POST',
        url: basePath + 'AgregarPuntoVentaUsuarioJsonFk',
        data: dataForm,
        beforeSend: function () {
            $.LoadingOverlay("show");
        },
        complete: function () {
            $.LoadingOverlay("hide");
        },
        success: function (response) {
            var respuesta = response.respuesta;
            if (respuesta) {
                toastr.success('Se asigno PuntoVenta', 'Mensaje Servidor');
            } else {
                toastr.warning(response.mensaje, 'Mensaje Servidor');
            }
        }
    })
}

function QuitarPuntoVenta(IdPuntoVenta, IdUsuario) {
    var dataForm = {
        'IdPuntoVenta': IdPuntoVenta,
        'IdUsuario': IdUsuario
    };
    $.ajax({
        type: 'POST',
        url: basePath + 'QuitarPuntoVentaUsuarioJsonFk',
        data: dataForm,
        beforeSend: function () {
            $.LoadingOverlay("show");
        },
        complete: function () {
            $.LoadingOverlay("hide");
        },
        success: function (response) {
            var respuesta = response.respuesta;
            if (respuesta) {
                toastr.success('Se quito el PuntoVenta asignado', 'Mensaje Servidor');
            } else {
                toastr.warning(response.mensaje, 'Mensaje Servidor');
            }
        }
    })
}

function ListarPuntoVenta() {
    var idUsuario = $("#IdUsuario").val();
    $.ajax({
        type: 'POST',
        url: basePath + 'UsuarioPuntoVentaListaObtenerFk',
        data: {
            'idUsuario': idUsuario
        },
        beforeSend: function () {
            $.LoadingOverlay("show");
        },
        complete: function () {
            $.LoadingOverlay("hide");
        },
        success: function (response) {
            var resp = response.data;
            var lista_obtener = response.lista_obtener;
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
                    {data: "idPuntoVenta", title: "Id"},
                    {data: "nombre", title: "Punto de Venta"},
                    {
                        data: null, title: "Zona Comercial",
                        "render": function (value) {
                            var ZonaComercial = value.ZonaComercial == null ? 'Sin Asignar' : 'Zona Comercial ' + value.ZonaComercial;
                            return ZonaComercial;
                        }
                    },
                    {
                        data: null, title: "",
                        "render": function (value) {
                            var resp = lista_obtener.includes(value.idPuntoVenta);
                            var checked = '';
                            if (resp) {
                                checked = 'checked';
                                console.log(checked);
                            }
                            return '<div class="icheck-inline"><input type="checkbox" ' + checked + ' data-id="' + value.idPuntoVenta + '" data-checkbox="icheckbox_square-blue"></div>';
                        }, class: "text-center"
                    }
                ],
                "drawCallback": function (settings) {
                    $(".icheck-inline").iCheck({
                        checkboxClass: 'icheckbox_square-blue',
                        radioClass: 'iradio_square-red',
                        increaseArea: '25%'
                    });
                }
            });
        },
    })
}