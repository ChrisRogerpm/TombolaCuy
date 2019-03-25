$(document).ready(function(){

    $(document).on('click','#btnEntrar',function(){
        var validar = $("#frmNuevo");
        if (validar.valid()) {
            var url = basePath + "ValidarLoginJsonFk";
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
                    $("#txtusuario").attr('readonly',true);
                    $("#txtpassword").attr('readonly',true);
                    $("#btnEntrar").attr('disabled',true);
                },
                success: function (response) {
                    var respuesta = response.respuesta;
                    if (respuesta === true) {
                        toastr.success("Bienvenido al Sistema", "Mensaje Servidor");
                        $("#btnEntrar").attr('disabled',true);
                        var url = basePath + "Dashboard";
                        setTimeout(function () {
                            window.location.replace(url);
                        }, 2000);
                    } else {
                        toastr.error(response.mensaje, "Mensaje Servidor");
                    }
                },
                error: function (jqXHR, textStatus, errorThrown) {
                }
            });
        }
    });

})

$("#frmNuevo")
.validate({
    rules: {
        usuario:
        {
            required: true,
        }, 
        password:
        {
            required: true,
        }
    },
    messages: {
        usuario:
        {
            required: '',
        }, 
        password:
        {
            required: '',
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