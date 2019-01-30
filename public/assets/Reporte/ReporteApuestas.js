$(document).ready(function () {
    $(".select2").select2();
    var dateNow = new Date();
    $(".Fecha").datetimepicker({
        // pickTime: false,
        format: 'YYYY/MM/DD HH:mm:ss',
        defaultDate: dateNow,
    });
    $.when(llenarSelect(basePath + "PuntoVentaListarJson", { '_token': $("input[name='_token']").val() }, "cboTienda", "idPuntoVenta", "nombre", "")).then(function (response, textStatus) {
        $("#cboTienda").select2();
    });
    $(document).on('click', '#btnBuscar', function () {
        var validar = $("#frmNuevo");
        if (validar.valid()) {
            var url = basePath + "ReporteApuestaJson";
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
                    var resp = response.data;
                    $("#PanelTabla").show();
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
                            {data: "Tienda", title: "Tienda"},
                            {data: "Apuestas", title: "Apuestas"},
                            {data: "Pagos", title: "Pagos"},
                            {data: "Evento", title: "Evento"},
                            {data: "Jugadores", title: "Jugadores"},
                        ],
                        "drawCallback": function (settings) {
                            // $('.btnEditar').tooltip({
                            //     title: "Editar"
                            // });
                        }
                    });
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
        fechaInicio:
        {
            required: true,

        }, fechaFin:
        {
            required: true,

        }, tiendas:
        {
            required: true,

        }
    },
    messages: {
        fechaInicio:
        {
            required: '',

        }, fechaFin:
        {
            required: '',

        }, tiendas:
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