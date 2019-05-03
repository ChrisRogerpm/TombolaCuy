var array_puntoventa = [];
var array_correo = [];
$(document).ready(function () {
    ListarAlertaPuntoVenta();
    $(document).on('click', '#btnNuevo', function () {
        $(".icheck-inline").iCheck("destroy");
        var idTipoAlerta = $(this).data("id");
        $("#idTipoAlerta").val(idTipoAlerta);
        ListarPuntoVentaAsignados();
        array_puntoventa = [];
        array_correo = [];
        $("#table_correo tbody").html("");
        $("#ModalNuevoAlertaPuntoVenta").modal({
            backdrop: 'static',
            keyboard: false
        });
    });

    $(document).on('click', '#btnGuardar', function () {
        if (array_puntoventa.length === 0) {
            toastr.warning('Seleccione puntos de Ventas', 'Mensaje Servidor');
        } else if (array_correo.length === 0) {
            toastr.warning('Seleccione ingrese correos', 'Mensaje Servidor');
        } else {
            var dataForm = {
                'idTipoAlerta': $("#idTipoAlerta").val(),
                'idPuntoVenta': array_puntoventa,
                'correoDestino': array_correo,
            };
            $.ajax({
                type: 'POST',
                url: basePath + "TipoAlertaPuntoVentaInsertarJson",
                data: dataForm,
                beforeSend: function () {
                    $.LoadingOverlay("show");
                },
                complete: function () {
                    $.LoadingOverlay("hide");
                },
                success: function (response) {
                    var respuesta = response.respuesta;
                    if (respuesta === true) {
                        toastr.success("Se Registro Correctamente", "Mensaje Servidor");
                    } else {
                        toastr.error(response.mensaje, "Mensaje Servidor");
                    }
                }
            });
        }
    });
    $(document).on('ifChecked', '#table_punto_venta input:checkbox', function () {
        var IdPuntoVenta = $(this).val();
        array_puntoventa.push(IdPuntoVenta);
    });
    $(document).on('ifUnchecked', '#table_punto_venta input:checkbox', function () {
        var IdPuntoVenta = $(this).val();
        for (var i = array_puntoventa.length; i--;) {
            if (array_puntoventa[i] === IdPuntoVenta) {
                array_puntoventa.splice(i, 1);
            }
        }
    });
    $(document).on('click', '#btnAgregarCorreo', function () {
        var Correo = $("#txtCorreo").val();
        Correo = Correo.toLowerCase();
        var respuesta = array_correo.indexOf(Correo);
        if (respuesta < 0) {
            if (Correo !== "") {
                array_correo.push(Correo);
                $("#table_correo tbody").append('<tr><td>' + Correo + '</td><td class="text-center"><button class="btn btn-danger btn-xs btnEliminarCorreo" data-correo="' + Correo + '"><i class="fa fa-close"></i></button></td></tr>');
            } else {
                toastr.warning('Ingrese un correo', 'Mensaje Servidor');
            }
        }
    });
    $(document).on('click', '.btnEliminarCorreo', function () {
        $correo = $(this).data("correo");
        for (var i = array_correo.length; i--;) {
            if (array_correo[i] === $correo) {
                array_correo.splice(i, 1);
            }
        }
        $(this).parent().parent().remove();
    });
});

function ListarPuntoVentaAsignados() {
    $.ajax({
        type: 'POST',
        url: basePath + 'PuntoVentaUsuarioAlertaJsonFk',
        data: {
            'idTipoAlerta': $("#idTipoAlerta").val()
        },
        beforeSend: function () {
            $.LoadingOverlay("show");
        },
        complete: function () {
            $.LoadingOverlay("hide");
        },
        success: function (response) {
            var resp = response.data;
            $('.container-table-punto').html("").append('<table id="table_punto_venta" class="table table-bordered table-striped" style="width:100%"></table>');
            $("#table_punto_venta").DataTable({
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
                    {data: "nombre", title: "Punto de Venta"},
                    {
                        data: null, title: "",
                        "render": function (value) {
                            return '<div class="icheck-inline" style="margin-top: 5px;"><input type="checkbox" value="' + value.idPuntoVenta + '" data-checkbox="icheckbox_square-blue"></div>'
                        }
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

function ListarAlertaPuntoVenta() {
    $.ajax({
        type: 'POST',
        url: basePath + 'TipoAlertaPuntoVentaJsonFk',
        data: {
            'idTipoAlerta': $("#txtIdTipoAlerta").val()
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
                    {data: "idPuntoVentaTipoAlerta", title: "Id"},
                    {data: "Alerta", title: "Alerta"},
                    {data: "asunto", title: "Asunto"},
                    {data: "mensaje", title: "Mensaje"},
                    {data: "PuntoVenta", title: "Punto Venta"},
                    {
                        data: null, title: "Monto",
                        "render": function (value) {
                            var monto = value.monto;
                            return '<input type="text" class="form-control" value="' + monto + '"/>'
                        }
                    },
                    {
                        data: null, title: "Enviar a",
                        "render": function (value) {
                            var correos = value.Enviar;
                            return '<input type="text" class="form-control" value="' + correos + '"/>'
                        }
                    },
                    {
                        data: null, title: "Estado",
                        "render": function (value) {
                            var select_activo = value.estado === 1 ? 'selected' : '';
                            var select_inactivo = value.estado === 0 ? 'selected' : '';
                            var option = '<option value="1"' + select_activo + '>Activo</option><option value="0"' + select_inactivo + '>Inactivo</option>';
                            return '<select class="form-control estado" style="width: 100%">' + option + '</select>';
                        }
                    },
                    {
                        data: null, title: "",
                        "render": function (value) {
                            return '<button type="button" class="btn btn-success btn-sm btnEditar" data-id="' + value.idPuntoVentaTipoAlerta + '"><i class="fa fa-pencil-square-o"></i></button>';
                        }
                    }
                ],
                "drawCallback": function (settings) {
                    $('.btnEditar').tooltip({
                        title: "Editar"
                    });
                    $('.estado').select2();
                }
            });
        },
    })
}