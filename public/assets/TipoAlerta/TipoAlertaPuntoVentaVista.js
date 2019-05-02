var array_puntoventa = [];
$(document).ready(function () {
    // ListarAlertaPuntoVenta();
    var resp = [];
    $("#table").DataTable({
        "bDestroy": true,
        "bSort": true,
        "scrollCollapse": true,
        "scrollX": false,
        "paging": true,
        "autoWidth": false,
        "bProcessing": true,
        "bDeferRender": true,
        data: resp,
        columns: [
            {data: "idTipoAlerta", title: "Id"},
            {data: "nombre", title: "Alerta"},
            {data: "nombre", title: "Asunto"},
            {data: "nombre", title: "Mensaje"},
            {data: "nombre", title: "Punto Venta"},
            {data: "nombre", title: "Monto"},
            {data: "nombre", title: "Enviar a"},
            {data: "nombre", title: "Estado"},
            {
                data: null, title: "",
                "render": function (value) {
                    return '<button type="button" class="btn btn-success btn-sm btnProgramar" data-id="' + value.idTipoAlerta + '"><i class="fa fa-cog"></i></button>';
                }
            }
        ],
        "drawCallback": function (settings) {
            $('.btnProgramar').tooltip({
                title: "Programar"
            });
        }
    });

    $(document).on('click', '#btnNuevo', function () {
        $(".icheck-inline").iCheck("destroy");
        var idTipoAlerta = $(this).data("id");
        $("#idTipoAlerta").val(idTipoAlerta);
        ListarPuntoVentaAsignados();
        array_puntoventa = [];
        $("#ModalNuevoAlertaPuntoVenta").modal({
            backdrop: 'static',
            keyboard: false
        });
    });

    $(document).on('click', '#btnGuardar', function () {
        var dataForm = $("#frmNuevo").serializeFormJSON();
        $.ajax({
            type: 'POST',
            url: basePath + "TipoAlertaPuntoVentaInsertarJson",
            data: dataForm,
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
            }
        });
    });
    $(document).on('ifChecked', '#table_punto_venta input:checkbox', function () {
        var IdPuntoVenta = $(this).val();
        array_puntoventa.push(IdPuntoVenta);
    });
    $(document).on('ifUnchecked', '#table_punto_venta input:checkbox', function () {
        var IdPuntoVenta = $(this).val();
        for (var i = array_puntoventa.length; i--;) {
            if (array_puntoventa[i] === IdPuntoVenta) {
                array_puntoventa.splice(i, 1);
            }
        }
    });
});

function ListarPuntoVentaAsignados() {
    $.ajax({
        type: 'POST',
        url: basePath + 'PuntoVentaUsuarioAlertaJsonFk',
        beforeSend: function () {
            $.LoadingOverlay("show");
        },
        complete: function () {
            $.LoadingOverlay("hide");
        },
        success: function (response) {
            var resp = response.data;
            $(".container-table-punto").html("").append('<table id="table_punto_venta" class="table table-bordered table-striped" style="width:100%"></table>');
            $("#table_punto_venta").DataTable({
                "bDestroy": true,
                "bSort": true,
                "scrollCollapse": true,
                "scrollX": false,
                "paging": true,
                "autoWidth": false,
                "bProcessing": true,
                "bDeferRender": true,
                data: resp,
                columns: [
                    {data: "nombre", title: "Punto de Venta"},
                    {
                        data: null, title: "",
                        "render": function (value) {
                            return '<div class="icheck-inline" style="margin-top: 5px;"><input type="checkbox" value="' + value.idPuntoVenta + '" data-checkbox="icheckbox_square-blue"></div>'
                        }
                    }
                ],
                "drawCallback": function (settings) {
                    $(".icheck-inline").iCheck({
                        checkboxClass: 'icheckbox_square-blue',
                        radioClass: 'iradio_square-red',
                        increaseArea: '25%'
                    });
                }
            });
        },
    })
}

function ListarAlertaPuntoVenta() {
    $.ajax({
        type: 'POST',
        url: basePath + 'TipoAlertaListarJsonFk',
        success: function (response) {
            // var resp = response.data;
            var resp = [];
            $("#table").DataTable({
                "bDestroy": true,
                "bSort": true,
                "scrollCollapse": true,
                "scrollX": false,
                "paging": true,
                "autoWidth": false,
                "bProcessing": true,
                "bDeferRender": true,
                data: resp,
                columns: [
                    {data: "idTipoAlerta", title: "Id"},
                    {data: "nombre", title: "Alerta"},
                    {data: "nombre", title: "Asunto"},
                    {data: "nombre", title: "Mensaje"},
                    {data: "nombre", title: "Punto Venta"},
                    {data: "nombre", title: "Monto"},
                    {data: "nombre", title: "Enviar a"},
                    {data: "nombre", title: "Estado"},
                    {
                        data: null, title: "",
                        "render": function (value) {
                            return '<button type="button" class="btn btn-success btn-sm btnProgramar" data-id="' + value.idTipoAlerta + '"><i class="fa fa-cog"></i></button>';
                        }
                    }
                ],
                "drawCallback": function (settings) {
                    $('.btnProgramar').tooltip({
                        title: "Programar"
                    });
                }
            });
        },
    })
}