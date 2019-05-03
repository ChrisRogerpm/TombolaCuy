$(document).ready(function () {

    $.when(llenarSelect(basePath + "EmpresaListarJsonFk", {'_token': $("input[name='_token']").val()}, "cboEmpresa", "idEmpresa", "razonSocial","")).then(function (response, textStatus) {
        $("#cboEmpresa").select2();
    });

    $.when(llenarSelect(basePath + "UbigeoListarJsonFk", {}, "cboUbigeo", "id", "nombre", $("#txtUbigeo").val())).then(function (response, textStatus) {
        $("#cboUbigeo").select2();
    });

    $('#btnGuardar').on('click', function (e) {
        var validar = $("#frmNuevo");
        if (validar.valid()) {
            var url = basePath + "PuntoVentaInsertarJson";
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
                        var url = basePath + "CajaListar";
                        window.location.replace(url);
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
            idEmpresa:
                {
                    required: true,

                },
            idUbigeo:
                {
                    required: true,

                },
            nombre:
                {
                    required: true,

                },
        },
        messages: {
            idEmpresa:
                {
                    required: '',

                },
            idUbigeo:
                {
                    required: '',

                },
            nombre:
                {
                    required: '',

                },
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