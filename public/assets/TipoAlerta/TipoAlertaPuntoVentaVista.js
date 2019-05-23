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
                        $("#ModalNuevoAlertaPuntoVenta").modal("hide");
                        toastr.success("Se Registro Correctamente", "Mensaje Servidor");
                        ListarAlertaPuntoVenta();
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
        var validacion = /\S+@\S+\.\S+/;
        var validar = validacion.test(Correo);
        if (!validar) {
            toastr.warning('El correo ingresado no es valido', 'Mensaje Servidor');
            return false;
        } else {
            var respuesta = array_correo.indexOf(Correo);
            if (respuesta < 0) {
                if (Correo !== "") {
                    array_correo.push(Correo);
                    $("#table_correo tbody").append('<tr><td>' + Correo + '</td><td class="text-center"><button class="btn btn-danger btn-xs btnEliminarCorreo" data-correo="' + Correo + '"><i class="fa fa-close"></i></button></td></tr>');
                } else {
                    toastr.warning('Ingrese un correo', 'Mensaje Servidor');
                }
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
    $(document).on('click', '.btnEditar', function () {
        var idPuntoVentaTipoAlerta = $(this).data("id");
        var asunto = $("#table tbody").find(".asunto" + idPuntoVentaTipoAlerta).val();
        var mensaje = $("#table tbody").find(".mensaje" + idPuntoVentaTipoAlerta).val();
        var puntoventa = $("#table tbody").find(".puntoventa" + idPuntoVentaTipoAlerta).val();
        var monto = $("#table tbody").find(".monto" + idPuntoVentaTipoAlerta).val();
        var correo = $("#table tbody").find(".correo" + idPuntoVentaTipoAlerta).val();
        var estado = $("#table tbody").find(".estado" + idPuntoVentaTipoAlerta).val();
        if (asunto === "") {
            toastr.warning('Ingrese un asunto', 'Mensaje Servidor');
            return false;
        }
        if (mensaje === "") {
            toastr.warning('Ingrese un mensaje', 'Mensaje Servidor');
            return false;
        }
        if (monto === "") {
            toastr.warning('Ingrese un monto', 'Mensaje Servidor');
            return false;
        }
        if (monto <= 0) {
            toastr.warning('Ingrese un monto mayor a 0', 'Mensaje Servidor');
            return false;
        }
        if (correo === "") {
            toastr.warning('Ingrese correos', 'Mensaje Servidor');
            return false;
        }
        var validar = true;
        correo = correo.split(",");
        correo = removerItemArray(correo);
        $.each(correo, function (key, value) {
            var email = value;
            var validacion = /\S+@\S+\.\S+/;
            var respuesta = validacion.test(email);
            if (!respuesta) {
                toastr.warning('Los correos ingresados no son validos', 'Mensaje Servidor');
                validar = false;
                return false;
            }
        });
        if (validar) {
            var url = basePath + "TipoAlertaPuntoVentaEditarJson";
            var dataForm = {
                'idPuntoVentaTipoAlerta': idPuntoVentaTipoAlerta,
                'asunto': asunto,
                'mensaje': mensaje,
                'puntoventa': puntoventa,
                'monto': monto,
                'correo': correo,
                'estado': estado,
            };
            TipoAlertaPuntoVentaEditar(url, dataForm);
        }
    });
});

function TipoAlertaPuntoVentaEditar(url, dataForm) {
    $.ajax({
        type: 'POST',
        url: url,
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
                ListarAlertaPuntoVenta();
            } else {
                toastr.error(response.mensaje, "Mensaje Servidor");
                ListarAlertaPuntoVenta();
            }
        }
    })
}

function removerItemArray(lista_correo) {
    let unique = {};
    lista_correo.forEach(function (i) {
        if (!unique[i]) {
            unique[i] = true;
        }
    });
    return Object.keys(unique);
}

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
            var data_punto_usuario = response.data_lista;
            $("#table").DataTable({
                "bDestroy": true,
                "bSort": true,
                "scrollCollapse": true,
                "scrollX": false,
                "paging": true,
                "autoWidth": false,
                "bProcessing": true,
                "bDeferRender": true,
                columnDefs: [
                    {width: 50, targets: 1}
                ],
                data: resp,
                columns: [
                    {data: "idPuntoVentaTipoAlerta", title: "Id"},
                    {
                        data: "Alerta", title: "Alerta", class: "text-center"
                    },
                    {
                        data: null, title: "Asunto",
                        "render": function (value) {
                            var asunto = value.asunto;
                            var idPuntoVentaTipoAlerta = value.idPuntoVentaTipoAlerta;
                            return '<textarea class="form-control asunto' + idPuntoVentaTipoAlerta + '"  rows="3" maxlength="30" style="resize: none;">' + asunto + '</textarea>';
                        }
                    },
                    {
                        data: null, title: "Mensaje",
                        "render": function (value) {
                            var mensaje = value.mensaje;
                            var idPuntoVentaTipoAlerta = value.idPuntoVentaTipoAlerta;
                            return '<textarea class="form-control mensaje' + idPuntoVentaTipoAlerta + '" readonly rows="4" style="resize: none;">' + mensaje + '</textarea>';
                        }
                    },
                    {
                        data: null, title: "Punto Venta",
                        "render": function (value) {
                            var idPuntoVenta = value.idPuntoVenta;
                            var option = "";
                            var idPuntoVentaTipoAlerta = value.idPuntoVentaTipoAlerta;
                            $.each(data_punto_usuario, function (key, val) {
                                var selected = val.idPuntoVenta === idPuntoVenta ? 'selected' : '';
                                option += '<option value="' + val.idPuntoVenta + '" ' + selected + '>' + val.nombre + '</option>';
                            });
                            return '<select class="form-control select_general puntoventa' + idPuntoVentaTipoAlerta + '">' + option + '</select>';
                        }
                    },
                    {
                        data: null, title: "Monto",
                        "render": function (value) {
                            var monto = value.monto;
                            var idPuntoVentaTipoAlerta = value.idPuntoVentaTipoAlerta;
                            return '<input type="number" min="0" class="form-control monto' + idPuntoVentaTipoAlerta + '" value="' + monto + '"/>'
                        }
                    },
                    {
                        data: null, title: "Enviar a",
                        "render": function (value) {
                            var correos = value.Enviar;
                            var idPuntoVentaTipoAlerta = value.idPuntoVentaTipoAlerta;
                            return '<input type="text" class="form-control correo' + idPuntoVentaTipoAlerta + '" value="' + correos + '"/>'
                        }
                    },
                    {
                        data: null, title: "Estado",
                        "render": function (value) {
                            var select_activo = value.estado === 1 ? 'selected' : '';
                            var select_inactivo = value.estado === 0 ? 'selected' : '';
                            var idPuntoVentaTipoAlerta = value.idPuntoVentaTipoAlerta;
                            var option = '<option value="1"' + select_activo + '>Activo</option><option value="0"' + select_inactivo + '>Inactivo</option>';
                            return '<select class="form-control select_general estado' + idPuntoVentaTipoAlerta + '" style="width: 100%">' + option + '</select>';
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
                    // $('.select_general').select2();
                }
            });
        },
    })
}