$(document).ready(function () {
    $('#btnGuardar').on('click', function (e) {
        var validar = $("#frmNuevo");
        if (validar.valid()) {
            var url = basePath + "DineroDefaultInsertarJson";
            var dataForm = $('#frmNuevo').serializeFormJSON();
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
                        toastr.success("Se Registro Correctamente", "Mensaje Servidor");
                        $("#frmNuevo")[0].reset();
                    } else {
                        toastr.error(response.mensaje, "Mensaje Servidor");
                    }
                },
                error: function (jqXHR, textStatus, errorThrown) {
                }
            });
        }
    });
});

$("#frmNuevo")
    .validate({
        rules: {
            monto:
                {
                    required: true,

                }
        },
        messages: {
            monto:
                {
                    required: 'monto requerido',

                }
        },
        errorPlacement: function (error, element) {
            if (element.is(":radio") || element.is(":checkbox")) {
                element.closest('.option-group').after(error);
            }
            else {
                error.insertAfter(element);
            }
        }
    });