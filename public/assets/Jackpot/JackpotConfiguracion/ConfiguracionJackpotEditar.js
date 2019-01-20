$(document).ready(function () {
    CargarSuperjackpot();
    $(document).on('click', '#btnAgregar', function () {
        var tr =
            '<tr>\n' +
            '<td class="text-center"><input type="hidden" name="idConfiguracionPozo" value="0" /><input type="number" min="1" name="numeroPozo" class="form-control input-sm"></td>\n' +
            '<td class="text-center"><input type="number" min="1" name="montoBase" class="form-control input-sm"></td>\n' +
            '<td class="text-center"><input type="number" min="1" name="montoBaseOculto" class="form-control input-sm"></td>\n' +
            '<td class="text-center"><input type="number" min="1" name="incrementoJackpot" class="form-control input-sm"></td>\n' +
            '<td class="text-center"><input type="number" min="1" name="incrementoPozoOculto" class="form-control input-sm"></td>\n' +
            '<td class="text-center"><input type="number" min="1" name="limiteInferior" class="form-control input-sm"></td>\n' +
            '<td class="text-center"><input type="number" min="1" name="limiteSuperior" class="form-control input-sm"></td>\n' +
            '<td class="text-center"><input type="number" min="1" name="limiteInferiorOculto" class="form-control input-sm"></td>\n' +
            '<td class="text-center"><input type="number" min="1" name="limiteSuperiorOculto" class="form-control input-sm"></td>\n' +
            '<td class="text-center"></td>\n' +
            '<td class="text-center"><button type="button" class="btn btn-danger btn-sm btnEliminar"><i class="fa fa-close"></i></button></td>\n' +
            '</tr>';
        $("#table tbody").append(tr);
    });

    $(document).on('click', '.btnEliminar', function () {

        var idConfiguracionPozo = $(this).data("id");
        if (idConfiguracionPozo === undefined) {
            $(this).parent().parent().remove();
        } else {
            EliminarConfiguracionPozo(idConfiguracionPozo);
            $(this).parent().parent().remove();
        }

    });

    $(document).on('click', '#btnGuardar', function () {

        var validar = $("#frmNuevo");
        if (validar.valid()) {
            var idConfiguracionJackpot = $("input[name='idConfiguracionJackpot']").val();
            var nombre = $("input[name='nombre']").val();
            var superjackpot = $("input[name='superjackpot']:checked").val() == undefined ? "0" : $("input[name='superjackpot']:checked").val();
            var pozo = LlenarConfigurazionPozo();
            if (pozo.length > 0) {
                var dataForm = {
                    '_token': $("input[name='_token']").val(),
                    'idConfiguracionJackpot': idConfiguracionJackpot,
                    'nombre': nombre,
                    'superjackpot': superjackpot,
                    'pozo': pozo
                };
                var url = basePath + "ConfiguracionJackpotEditarJson";
                console.log(pozo)
                EditarConfiguracionJackpot(dataForm, url);
            }
        }

    });

    $(document).on('ifChecked', '#table input:checkbox', function (event) {
        var idConfiguracionPozo = $(this).data("id");
        var estado = "1";
        var url = basePath + "CambiarEstadoConfiguracionPozoJson";
        var dataForm = {
            '_token': $("input[name='_token']").val(),
            'idConfiguracionPozo': idConfiguracionPozo,
            'estado': estado
        };
        CambiarEstadoConfiguracionPozo(dataForm, url);
    });

    $(document).on('ifUnchecked', '#table input:checkbox', function (event) {
        var idConfiguracionPozo = $(this).data("id");
        var estado = "0";
        var url = basePath + "CambiarEstadoConfiguracionPozoJson";
        var dataForm = {
            '_token': $("input[name='_token']").val(),
            'idConfiguracionPozo': idConfiguracionPozo,
            'estado': estado
        };
        CambiarEstadoConfiguracionPozo(dataForm, url);
    });
});

function LlenarConfigurazionPozo() {
    var pozo = [];
    $("#table tbody tr").each(function () {
        var idConfiguracionPozo = $(this).find('input[name="idConfiguracionPozo"]').val();
        var numeroPozo = $(this).find('input[name="numeroPozo"]').val();
        var montoBase = $(this).find('input[name="montoBase"]').val();
        var montoBaseOculto = $(this).find('input[name="montoBaseOculto"]').val();
        var incrementoJackpot = $(this).find('input[name="incrementoJackpot"]').val();
        var incrementoPozoOculto = $(this).find('input[name="incrementoPozoOculto"]').val();
        var limiteInferior = $(this).find('input[name="limiteInferior"]').val();
        var limiteSuperior = $(this).find('input[name="limiteSuperior"]').val();
        var limiteInferiorOculto = $(this).find('input[name="limiteInferiorOculto"]').val();
        var limiteSuperiorOculto = $(this).find('input[name="limiteSuperiorOculto"]').val();
        var estado = $(this).find("input[name='estado']:checked").val() == undefined ? "0" : $("input[name='estado']:checked").val();

        // $("input[name='superjackpot']:checked").val() == undefined ? "0" : $("input[name='superjackpot']:checked").val();
        var validar = true;
        if (numeroPozo === "" || montoBase === "" || montoBaseOculto === "" || montoBaseOculto === "" || incrementoJackpot === "" || incrementoPozoOculto === "" || limiteInferior === "" || limiteSuperior === "" ||
            limiteSuperiorOculto === "" || limiteInferiorOculto === "") {
            validar = false;
            toastr.warning('Todo los campos de la tabla deben ser llenados', 'Mensaje Servidor');
            pozo = [];
            return false;
        }
        if (validar) {
            pozo.push(
                config_pozo = {
                    'idConfiguracionPozo': idConfiguracionPozo,
                    'numeroPozo': numeroPozo,
                    'montoBase': montoBase,
                    'montoBaseOculto': montoBaseOculto,
                    'incrementoJackpot': incrementoJackpot,
                    'incrementoPozoOculto': incrementoPozoOculto,
                    'limiteInferior': limiteInferior,
                    'limiteSuperior': limiteSuperior,
                    'limiteInferiorOculto': limiteInferiorOculto,
                    'limiteSuperiorOculto': limiteSuperiorOculto,
                    'estado': estado
                })
        }
    });

    return pozo;
}

function EditarConfiguracionJackpot(dataform, url) {
    $.ajax({
        url: url,
        type: "POST",
        contentType: "application/json",
        data: JSON.stringify(dataform),
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
                CargarConfiguracionPozo();
            } else {
                toastr.error(response.mensaje, "Mensaje Servidor");
            }
        },
        error: function (jqXHR, textStatus, errorThrown) {
        }
    });
}

function CargarSuperjackpot() {

    var Superjackpot = $("#txtsuperjackpot").val();

    if (Superjackpot == 1) {
        $("input[name='superjackpot']").attr('checked', true);
        $(".contenedor_checkbox").html('<div class="icheck-inline" style="margin-top: 5px;"><input type="checkbox" name="superjackpot" checked value="1" data-checkbox="icheckbox_square-blue"></div>');
    } else {
        $(".contenedor_checkbox").html('<div class="icheck-inline" style="margin-top: 5px;"><input type="checkbox" name="superjackpot" value="1" data-checkbox="icheckbox_square-blue"></div>');
    }
    CargarConfiguracionPozo();

    $(".icheck-inline").iCheck({
        checkboxClass: 'icheckbox_square-blue',
        radioClass: 'iradio_square-red',
        increaseArea: '25%'
    });
}

function CargarConfiguracionPozo() {
    var idConfiguracionJackpot = $("input[name='idConfiguracionJackpot']").val();
    var url = basePath + "ConfiguracionPozoListarJson";
    var dataForm = {
        '_token': $("input[name='_token']").val(),
        'idConfiguracionJackpot': idConfiguracionJackpot
    };
    $.ajax({
        url: url,
        type: "POST",
        data: dataForm,
        beforeSend: function () {
            $.LoadingOverlay("show");
        },
        complete: function () {
            $.LoadingOverlay("hide");
            $(".icheck-inline").iCheck({
                checkboxClass: 'icheckbox_square-blue',
                radioClass: 'iradio_square-red',
                increaseArea: '25%'
            });
        },
        success: function (response) {
            var data = response.data;
            $("#table tbody").html("");
            $.each(data, function (key, value) {
                var estado = value.estado == 1 ? 'checked' : '';
                var tr =
                    '<tr>\n' +
                    '<td class="text-center"><input type="hidden" name="idConfiguracionPozo" value="' + value.idConfiguracionPozo + '" /><input type="number" min="1" name="numeroPozo" value="' + value.numeroPozo + '" class="form-control input-sm"></td>\n' +
                    '<td class="text-center"><input type="number" min="1" name="montoBase" value="' + value.montoBase + '" class="form-control input-sm"></td>\n' +
                    '<td class="text-center"><input type="number" min="1" name="montoBaseOculto" value="' + value.montoBaseOculto + '" class="form-control input-sm"></td>\n' +
                    '<td class="text-center"><input type="number" min="1" name="incrementoJackpot" value="' + value.incrementoJackpot + '" class="form-control input-sm"></td>\n' +
                    '<td class="text-center"><input type="number" min="1" name="incrementoPozoOculto" value="' + value.incrementoPozoOculto + '" class="form-control input-sm"></td>\n' +
                    '<td class="text-center"><input type="number" min="1" name="limiteInferior" value="' + value.limiteInferior + '" class="form-control input-sm"></td>\n' +
                    '<td class="text-center"><input type="number" min="1" name="limiteSuperior" value="' + value.limiteSuperior + '" class="form-control input-sm"></td>\n' +
                    '<td class="text-center"><input type="number" min="1" name="limiteInferiorOculto" value="' + value.limiteInferiorOculto + '" class="form-control input-sm"></td>\n' +
                    '<td class="text-center"><input type="number" min="1" name="limiteSuperiorOculto" value="' + value.limiteSuperiorOculto + '" class="form-control input-sm"></td>\n' +
                    '<td class="text-center"><div class="icheck-inline"><input type="checkbox" name="estado" ' + estado + ' value="1" data-id="' + value.idConfiguracionPozo + '"  data-checkbox="icheckbox_square-blue"></div></td>\n' +
                    '<td class="text-center"><button type="button" class="btn btn-danger btn-sm btnEliminar" data-id="' + value.idConfiguracionPozo + '"><i class="fa fa-close"></i></button></td>\n' +
                    '</tr>';
                $("#table tbody").append(tr);
            })
        },
        error: function (jqXHR, textStatus, errorThrown) {
        }
    });
}

function EliminarConfiguracionPozo(idConfiguracionPozo) {
    var dataForm = {
        '_token': $("input[name='_token']").val(),
        'idConfiguracionPozo': idConfiguracionPozo
    };
    var url = basePath + "ConfiguracionPozoEliminarJson";
    $.ajax({
        url: url,
        type: "POST",
        contentType: "application/json",
        data: JSON.stringify(dataForm),
        beforeSend: function () {
            $.LoadingOverlay("show");
        },
        complete: function () {
            $.LoadingOverlay("hide");
        },
        success: function (response) {

            var respuesta = response.respuesta;
            if (respuesta === true) {
                toastr.success("Se Elimino Correctamente", "Mensaje Servidor");
            } else {
                toastr.error(response.mensaje, "Mensaje Servidor");
            }
        },
        error: function (jqXHR, textStatus, errorThrown) {
        }
    });
}

function CambiarEstadoConfiguracionPozo(dataform, url) {
    $.ajax({
        url: url,
        type: "POST",
        contentType: "application/json",
        data: JSON.stringify(dataform),
        beforeSend: function () {
            $.LoadingOverlay("show");
        },
        complete: function () {
            $.LoadingOverlay("hide");
        },
        success: function (response) {
            var respuesta = response.respuesta;
            if (respuesta === true) {
                toastr.success("Se Actualizo Correctamente", "Mensaje Servidor");
            } else {
                toastr.error(response.mensaje, "Mensaje Servidor");
            }
        },
        error: function (jqXHR, textStatus, errorThrown) {
        }
    });
}

$("#frmNuevo")
    .validate({
        rules: {
            nombre:
                {
                    required: true,

                },
            numeroPozo:
                {
                    required: true,

                },
            montoBase:
                {
                    required: true,

                },
            montoBaseOculto:
                {
                    required: true,

                },
            incrementoJackpot:
                {
                    required: true,

                }, incrementoPozoOculto:
                {
                    required: true,

                }, limiteInferior:
                {
                    required: true,

                }, limiteSuperior:
                {
                    required: true,

                }, limiteInferiorOculto:
                {
                    required: true,

                }, limiteSuperiorOculto:
                {
                    required: true,

                }
        },
        messages: {
            nombre:
                {
                    required: '',

                },
            numeroPozo:
                {
                    required: '',

                },
            montoBase:
                {
                    required: '',

                },
            montoBaseOculto:
                {
                    required: '',

                },
            incrementoJackpot:
                {
                    required: '',

                }, incrementoPozoOculto:
                {
                    required: '',

                }, limiteInferior:
                {
                    required: '',

                }, limiteSuperior:
                {
                    required: '',

                }, limiteInferiorOculto:
                {
                    required: '',

                }, limiteSuperiorOculto:
                {
                    required: '',

                }
        },
        errorPlacement: function (error, element) {
            if (element.is(":radio") || element.is(":checkbox")) {
                element.closest('.option-group').after(error);
            } else {
                error.insertAfter(element);
            }
        }
    });
