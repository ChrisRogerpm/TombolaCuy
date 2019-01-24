$(document).ready(function () {
    $(".select2").select2();
    var dateNow = new Date();
    $(".hasDatepicker").datetimepicker({
        pickTime: false,
        format: 'DD/MM/YYYY',
        defaultDate: dateNow,
        maxDate: dateNow
    });

    $("#fechaInicio").val("01/01/2018");
    debugger;
    ListarHistorialGanadores();
    
});

function ListarHistorialGanadores() {
    $.ajax({
        type: 'GET',
        url: basePath + 'ReporteHistorialGanadoresListarJson',
        data: {
            '_token': $('input[name=_token]').val(),
        },

        success: function (response) {
            var resp = response.data;
            debugger;
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

                {data: "tienda", title: "tienda",
                {data: "evento", title: "evento",
                {data: "fecha", title: "fecha",
                {data: "total_jugadores", title: "total jugadores",
                {data: "total_ganadores", title: "total ganadores",
                {data: "monto_total_apostado", title: "monto total apostado",
                {data: "monto_total_pagado", title: "monto total pagado",
                {data: "NR_ticket_ganador", title: "NR ticket ganador",
                {data: "tipo_de_apuesta", title: "tipo de apuesta",
                {data: "valor_de_apuesta", title: "valor de apuesta",

                
                ],
                
            });
        },
    })
}