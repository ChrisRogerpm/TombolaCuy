$(document).ready(function () {

    $.when(llenarSelect(basePath + "CajaPuntoVentaUsuarioJsonFk", {'_token': $("input[name='_token']").val()}, "cboCaja", "idCaja", "NombreCaja", "")).then(function (response, textStatus) {
        $("#cboCaja").select2();
    });

    $.when(llenarSelect(basePath + "TurnoListarJsonFk", {'_token': $("input[name='_token']").val()}, "cboTurno", "idTurno", "nombre", "")).then(function (response, textStatus) {
        $("#cboTurno").select2();
    });
    var dateNow = new Date();
    $("#txtfechaOperacion").datetimepicker({
        pickTime: false,
        format: 'YYYY/MM/DD',
        defaultDate: dateNow,
    });
    $('#btnGuardar').on('click', function (e) {
        var validar = $("#frmNuevo");
        if (validar.valid()) {
            var url = basePath + "AperturaCajaInsertarJson";
            var dataForm = $('#frmNuevo').serializeFormJSON();
            idUsuario=dataForm.idUsuario;
              $.ajax({
                url: basePath+"AperturaCajaListarActivaFk",
                type: "POST",
                contentType: "application/json",
                data: JSON.stringify({
                    '_token': $("input[name='_token']").val(),
                    "idUsuario":idUsuario}),
                success: function (response) {
                    var cajas =response.data.length;
                    if (cajas ==0) {
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
                                    toastr.success("Se Registró Correctamente", "Mensaje Servidor");
                                    $("#frmNuevo")[0].reset();
                                    $("#cboCaja").val('').trigger('change');
                                    $("#cboTurno").val('').trigger('change');
                                } else {
                                    toastr.error(response.mensaje, "Mensaje Servidor");
                                }
                            },
                            error: function (jqXHR, textStatus, errorThrown) {
                            }
                        });


                    } else {
                        toastr.error("Usuario Ya tiene caja registrada", "Mensaje Servidor");
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
            idCaja:
                {
                    required: true,
                },
            idTurno:
                {
                    required: true,
                },
            usuario:
                {
                    required: true,
                },
            fechaOperacion:
                {
                    required: true,
                }
        },
        messages: {
            idCaja:
                {
                    required: '',
                },
            idTurno:
                {
                    required: '',
                },
            usuario:
                {
                    required: '',
                },
            fechaOperacion:
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