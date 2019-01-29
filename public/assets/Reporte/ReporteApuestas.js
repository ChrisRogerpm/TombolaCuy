$(document).ready(function () {
    $(".select2").select2();
    var dateNow = new Date();
    $(".Fecha").datetimepicker({
        // pickTime: false,
        format: 'YYYY/MM/DD HH:mm:ss',
        defaultDate: dateNow,
    });
    $.when(llenarSelect(basePath + "PuntoVentaListarJson", {'_token': $("input[name='_token']").val()}, "cboTienda", "idPuntoVenta", "nombre", "")).then(function (response, textStatus) {
        $("#cboTienda").select2();
    });
    $(document).on('click','#btnBuscar',function () {
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
                debugger
            },
            error: function (jqXHR, textStatus, errorThrown) {
            }
        });
    });
    $("#table").DataTable({
        "bDestroy": true,
        "bSort": true,
        "scrollCollapse": true,
        "scrollX": false,
        "paging": true,
        "autoWidth": false,
        "bProcessing": true,
        "bDeferRender": true
    });
});