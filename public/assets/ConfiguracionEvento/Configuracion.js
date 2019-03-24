$(document).ready(function () {
    MostrarConfiguraciónEvento();
    $('#btnGuardar').on('click', function (e) {
        var validar = $("#frmNuevo");
        if (validar.valid()) {
            var url = basePath + "ConfiguracionEventoJsonFk";
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

function MostrarConfiguraciónEvento() {
    var url = basePath + "ConfiguracionEventoMostrarFk";
    $.ajax({
        type: 'POST',
        url: url,
        success: function (response) {
            var data = response.data;
            if (data != null) {
                $("#idConfiguracion").val(data.idConfiguracion);
                $("#HoraInicioIntervalo").val(data.HoraInicioIntervalo);
                $("#HoraFinIntervalo").val(data.HoraFinIntervalo);
                $("#HoraEjecucion").val(data.HoraEjecucion);
            }
        }
    })
}