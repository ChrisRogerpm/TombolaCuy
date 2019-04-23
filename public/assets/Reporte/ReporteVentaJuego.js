$(document).ready(function () {
    // $(".Fecha").datetimepicker({
    //     format: 'YYYY/MM/DD HH:mm:ss',
    // });

    var d = new Date();
    var datestring = d.getFullYear() + "/" + (d.getMonth()+1) + "/"+ d.getDate();
    $(".Fecha").datetimepicker({
        format: 'YYYY/MM/DD HH:mm:ss',
        defaultDate: datestring,
        useCurrent:'day'
    });

    var dateNow = new Date();
    $(".FechaFin").datetimepicker({
        format: 'YYYY/MM/DD HH:mm:ss',
        defaultDate: dateNow,
    });

    $(document).on('click', '.btnJuego', function (e) {
        e.preventDefault();
        var IdJuego = $(this).data("id");
        var NombreJuego = $(this).data("nombre");
        var url = basePath + "ReporteVentaJuegoFk";
        var dataForm = {
            IdJuego: IdJuego,
            _token: $("input[name='_token']").val()
        };
        $("#txtIdJuego").val(IdJuego);
        // $(".Fecha").val("");
        $("#txtNombreTabla").val(NombreJuego.split(' ').join(''));
        ReporteVentaJson(url, dataForm, NombreJuego.split(' ').join(''));
        $("#btnBuscar").attr('disabled', false);
    });

    $(document).on('click', '#btnBuscar', function () {
        var url = basePath + "ReporteVentaJuegoFk";
        var dataForm = $('#frmNuevo').serializeFormJSON();
        var NombreJuego = $("#txtNombreTabla").val();
        ReporteVentaJson(url, dataForm, NombreJuego);
    });

    $(document).on('click', '#btnExcel', function () {
        var NombreJuego = $(this).data("nombre");
        GenerarExcel(NombreJuego, "Reporte de " + NombreJuego);
    });

});

function ReporteVentaJson(url, dataForm, NombreJuego) {
    $.ajax({
        type: 'POST',
        url: url,
        contentType: "application/json",
        data: JSON.stringify(dataForm),
        beforeSend: function () {
            $.LoadingOverlay("show");
        },
        complete: function () {
            $.LoadingOverlay("hide");
        },
        success: function (response) {
            $(".container-tabla").html("").append('<table class="table table-bordered border-1" id="' + NombreJuego + '"></table>');
            $("#container-excel").html("").append('<a href="#" class="btn btn-success btn-sm col-md-12 col-xs-12" data-nombre="' + NombreJuego + '" id="btnExcel">\n' +
                '                                        <span class="icon fa fa-fw fa-file-excel-o"></span> Excel\n' +
                '                                    </a>');

            var resp = response.data;
            $("#PanelTabla").show();
            $("#" + NombreJuego).DataTable({
                "bDestroy": true,
                "bSort": true,
                "scrollCollapse": true,
                "scrollX": false,
                "paging": true,
                "autoWidth": false,
                "bProcessing": true,
                "bDeferRender": true,
                "ordering": false,
                data: resp,
                columns: [
                    {
                        data: null, title: "#", class: 'text-center', "render": function (value) {
                            return '#' + value.idEvento;
                        }
                    },
                    {data: "fechaEvento", title: "Fecha Evento", class: 'text-center'},

                    {
                        data: null, title: "Nro Ganador", class: 'text-center', "render": function (value) {
                            return '<span class="badge badge-warning" style="padding-top: 7px;padding-bottom: 7px;">' + value.ValorGanador + '</span>';
                        }
                    },
                    {
                        data: null, title: "Descripcion",
                        "render": function (value) {
                            return 'Número - ' + value.ValorGanador + ' / ' + value.Descripcion;
                        }
                    }
                ],
                "drawCallback": function (settings) {
                    $('.btnVer').tooltip({
                        title: "Ver"
                    });
                }
            });
        }
    })
}
