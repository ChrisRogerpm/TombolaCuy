var data_apuestas = [];
$(document).ready(function () {
    // $(".Fecha").datetimepicker({
    //     format: 'YYYY/MM/DD HH:mm:ss',
    // });

    var d = new Date();

    var fechaMin = new Date();
    fechaMin.setDate(fechaMin.getDate() - 45);

    var fechaMax = new Date();
    fechaMax.setDate(fechaMax.getDate() + 45);

    var datestring = d.getFullYear() + "/" + (d.getMonth() + 1) + "/" + d.getDate();
    $(".Fecha").datetimepicker({
        format: 'YYYY/MM/DD HH:mm:ss',
        defaultDate: datestring,
        maxDate: fechaMax,
        minDate: fechaMin,
        useCurrent: 'day'
    });

    var dateNow = new Date();
    $(".FechaFin").datetimepicker({
        format: 'YYYY/MM/DD HH:mm:ss',
        defaultDate: dateNow,
        maxDate: fechaMax,
        minDate: fechaMin,
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
        GenerarExcel(NombreJuego, "Rep. Historial Eventos - " + NombreJuego);
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
            data_apuestas = response.data_apuestas;
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
                        data: null, title: "Nro Ganador", class: 'text-center', "render": function (valor) {

                            var ValorGanador = parseInt(valor.ValorGanador);
                            var color_rgb = "";
                            var color_rgb_letra = "";
                            $.each(data_apuestas, function (key, value) {
                                if (value.valorapuesta === ValorGanador) {
                                    color_rgb = value.rgb;
                                    color_rgb_letra = value.rgbLetra;
                                    return false;
                                }
                            });

                            return '<span class="badge" style="padding-top: 7px;padding-bottom: 7px; background-color: ' + color_rgb + '; color: ' + color_rgb_letra + '">' + valor.ValorGanador + '</span>';
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
