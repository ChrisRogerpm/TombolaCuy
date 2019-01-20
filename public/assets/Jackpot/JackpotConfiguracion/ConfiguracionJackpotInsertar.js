$(document).ready(function () {

    $(document).on('click', '#btnAgregar', function () {
        var tr =
            '<tr>\n' +
            '<td class="text-center"><input type="number" min="1" name="numeroPozo" class="form-control input-sm"></td>\n' +
            '<td class="text-center"><input type="number" min="1" name="montoBase" class="form-control input-sm"></td>\n' +
            '<td class="text-center"><input type="number" min="1" name="montoBaseOculto" class="form-control input-sm"></td>\n' +
            '<td class="text-center"><input type="number" min="1" name="incrementoJackpot" class="form-control input-sm"></td>\n' +
            '<td class="text-center"><input type="number" min="1" name="incrementoPozoOculto" class="form-control input-sm"></td>\n' +
            '<td class="text-center"><input type="number" min="1" name="limiteInferior" class="form-control input-sm"></td>\n' +
            '<td class="text-center"><input type="number" min="1" name="limiteSuperior" class="form-control input-sm"></td>\n' +
            '<td class="text-center"><input type="number" min="1" name="limiteInferiorOculto" class="form-control input-sm"></td>\n' +
            '<td class="text-center"><input type="number" min="1" name="limiteSuperiorOculto" class="form-control input-sm"></td>\n' +
            '<td class="text-center"><button type="button" class="btn btn-danger btn-sm btnEliminar"><i class="fa fa-close"></i></button></td>\n' +
            '</tr>';
        $("#table tbody").append(tr);
    });

    $(document).on('click', '.btnEliminar', function () {
        $(this).parent().parent().remove();
    });

    $(document).on('click', '#btnGuardar', function () {

        var validar = $("#frmNuevo");
        if (validar.valid()) {
            var nombre = $("input[name='nombre']").val();
            var superjackpot = $("input[name='superjackpot']:checked").val() == undefined ? "0" : $("input[name='superjackpot']:checked").val();
            var pozo = LlenarConfigurazionPozo();
            if (pozo.length > 0) {
                var dataForm = {
                    '_token': $("input[name='_token']").val(),
                    'nombre': nombre,
                    'superjackpot': superjackpot,
                    'pozo': pozo
                };
                var url = basePath + "ConfiguracionJackpotInsertarJson";
                InsertarConfiguracionJackpot(dataForm, url);
            }
        }

    });

    $(".icheck-inline").iCheck({
        checkboxClass: 'icheckbox_square-blue',
        radioClass: 'iradio_square-red',
        increaseArea: '25%'
    });
});

function LlenarConfigurazionPozo() {
    var pozo = [];
    $("#table tbody tr").each(function () {
        var numeroPozo = $(this).find('input[name="numeroPozo"]').val();
        var montoBase = $(this).find('input[name="montoBase"]').val();
        var montoBaseOculto = $(this).find('input[name="montoBaseOculto"]').val();
        var incrementoJackpot = $(this).find('input[name="incrementoJackpot"]').val();
        var incrementoPozoOculto = $(this).find('input[name="incrementoPozoOculto"]').val();
        var limiteInferior = $(this).find('input[name="limiteInferior"]').val();
        var limiteSuperior = $(this).find('input[name="limiteSuperior"]').val();
        var limiteInferiorOculto = $(this).find('input[name="limiteInferiorOculto"]').val();
        var limiteSuperiorOculto = $(this).find('input[name="limiteSuperiorOculto"]').val();
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
                    'numeroPozo': numeroPozo,
                    'montoBase': montoBase,
                    'montoBaseOculto': montoBaseOculto,
                    'incrementoJackpot': incrementoJackpot,
                    'incrementoPozoOculto': incrementoPozoOculto,
                    'limiteInferior': limiteInferior,
                    'limiteSuperior': limiteSuperior,
                    'limiteInferiorOculto': limiteInferiorOculto,
                    'limiteSuperiorOculto': limiteSuperiorOculto,
                })
        }
    });

    return pozo;
}

function InsertarConfiguracionJackpot(dataform, url) {
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
                $("#frmNuevo")[0].reset();
                $("#table tbody").html("");
                $('.icheck-inline').iCheck('uncheck');
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
