$(document).ready(function () {
    $('#btnGuardar').on('click', function (e) {
        var validar = $("#frmNuevo");
        if (validar.valid()) {
            var url = basePath + "ClienteInsertarJson";
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
        nombres:
        {
            required: true,

        }, apePaterno:
        {
            required: true,

        }, apeMaterno:
        {
            required: true,

        }, dni:
        {
            required: true,

        }
    },
    messages: {
        nombres:
        {
            required: 'nombre'

        },apePaterno:
        {
            required: 'apellido'

        },apeMaterno:
        {
            required: 'materno'

        },dni:
        {
            required: 'dni'

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