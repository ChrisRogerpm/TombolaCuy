$(document).ready(function () {

    $(document).on('click', '#btnGuardar', function () {
        var validar = $("#frmNuevo");
        if (validar.valid()) {
            var url = basePath + "JuegoEditarJson";
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
            idJuego:
                {
                    required: true,
                },
            apuestaMinima:
                {
                    required: true,
                },
            apuestaMaxima:
                {
                    required: true,
                },
            apuestaMaximaGeneral:
                {
                    required: true,
                }
        },
        messages: {
            idJuego:
                {
                    required: '',
                },
            apuestaMinima:
                {
                    required: '',
                },
            apuestaMaxima:
                {
                    required: '',
                },
            apuestaMaximaGeneral:
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