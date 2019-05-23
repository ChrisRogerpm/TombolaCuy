$(document).ready(function () {
    MostrarConfiguracionEvento();
    $(document).on('click', '#btnGuardarConfiguracionEvento', function () {
        var validar = $("#frmConfiguracionEvento");
        if (validar.valid()) {
            var url = basePath + "ConfiguracionEventoJsonFk";
            var dataForm = $('#frmConfiguracionEvento').serializeFormJSON();
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

    $(document).on('click', '#btnGuardarConfiguracionCobrarTicket', function () {
        var validar = $("#frmConfiguracionCobroTicket");
        if (validar.valid()) {
            var url = basePath + "ConfiguracionCobrarTicketJsonFk";
            var dataForm = $('#frmConfiguracionCobroTicket').serializeFormJSON();
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
                        // MostrarConfiguraciónEvento();
                    } else {
                        toastr.error(response.mensaje, "Mensaje Servidor");
                    }
                },
                error: function (jqXHR, textStatus, errorThrown) {
                }
            });
        }
    });

    $(document).on('click', '#btnGuardarConfiguracionCuentaCorreo', function () {
        var validar = $("#frmConfiguracionCuentaCorreo");
        if (validar.valid()) {
            var url = basePath + "ConfiguracionCuentaCorreoJsonFk";
            var dataForm = $('#frmConfiguracionCuentaCorreo').serializeFormJSON();
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

    $(document).on('ifChecked', 'input:checkbox', function () {
        $('#txtCobrarTicket').val('1');
    });
    $(document).on('ifUnchecked', 'input:checkbox', function () {
        $('#txtCobrarTicket').val('0');
    });
});

function MostrarConfiguracionEvento() {
    var url = basePath + "ConfiguracionEventoMostrarFk";
    $.ajax({
        type: 'POST',
        url: url,
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
            $("#Encriptacion").select2();
        },
        success: function (response) {
            var data = response.data;
            if (data != null) {
                $(".idConfiguracion").val(data.idConfiguracion);
                $("#HoraInicioIntervalo").val(data.HoraInicioIntervalo);
                $("#HoraFinIntervalo").val(data.HoraFinIntervalo);
                $("#CuentaCorreo").val(data.CuentaCorreo);
                $("#PasswordCorreo").val(data.PasswordCorreo);
                $("#Encriptacion").val(data.Encriptacion);
                if (data.CobrarTicket === 1) {
                    $("#CheckTicket").attr('checked', true);
                    $("#txtCobrarTicket").val(1);
                } else {
                    $("#CheckTicket").attr('checked', false);
                    $("#txtCobrarTicket").val(0);
                }
            }
        }
    })
}