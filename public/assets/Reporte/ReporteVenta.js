$(document).ready(function () {

    $.when(llenarSelect(basePath + "PuntoVentaListarUsuarioJsonFk", {}, "cboPuntoVenta", "idPuntoVenta", "nombre", "")).then(function (response, textStatus) {
        $("#cboPuntoVenta").select2();
    });


    // llenarSelect(basePath + "PuntoVentaListarUsuarioJsonFk", {}, "cboTienda", "idPuntoVenta", "nombre", "allOption", false);
    // $("#cboTienda").select2('val', [0]);

    var dateNow = new Date();
    $(".Fecha").datetimepicker({
        // format: 'YYYY/MM/DD HH:mm:ss',
        format: 'YYYY/MM/DD',
        defaultDate: dateNow,
    });
    $('#cboZona').select2();
    // $("#cboPuntoVenta").select2();

    $('.multiselect').select2({
        tags: false, allowClear: true, buttonWidth: '100%',
        width: '100%',
        placeholder: {
            id: '', // the value of the option
            text: '--Seleccione--'
        }
    });

    $(document).on('change', '#cboZona', function () {
        var IdZonaComercial = $(this).val();
        var url = basePath + "ObtenerPuntosVentaZonaComercialJsonFk";
        var dataForm = {
            'IdZonaComercial': IdZonaComercial
        };
        $.ajax({
            type: 'POST',
            url: url,
            data: dataForm,
            beforeSend: function () {
                $.LoadingOverlay("show");
            },
            complete: function () {
                $.LoadingOverlay("hide");
            },
            success: function (response) {
                var data = response.data;
                $('#cboPuntoVenta').html("");
                if (data.length === 0) {
                    toastr.warning('No hay Puntos de Ventas registrados', 'Mensaje Servidor');
                } else {
                    $.each(data, function (key, value) {
                        $('#cboPuntoVenta').append('<option value="' + value.idPuntoVenta + '">' + value.nombre + '</option>')
                    });
                    $("#cboPuntoVenta").select2({
                        tags: false, allowClear: true, buttonWidth: '100%',
                        width: '100%',
                        placeholder: {
                            id: '', // the value of the option
                            text: '--Seleccione--'
                        }
                    });
                }
            }
        });
    });
    $('#cboPuntoVenta').on('select2:select', function (e) {
        var data = e.params.data;
        var valor = data.id;
        if (valor === 0) {
            $('#cboPuntoVenta').val([]).trigger('change');
            $('#cboPuntoVenta').val(0).trigger('change');
        } else {
            var valores = $('#cboPuntoVenta').val();
            var nuevo = [];
            $.each(valores, function (index, value) {
                if (value !== 0) {
                    nuevo.push(value);
                }
            });
            $('#cboPuntoVenta').val(nuevo).trigger('change');
        }
    });
    $(document).on('click', '#btnBuscar', function () {
        var url = basePath + "ReporteVentaJsonFk";
        var dataForm = $('#frmNuevo').serializeFormJSON();
        ReporteVentaJson(url, dataForm);
    });
    $(document).on('click', '.btnVer', function () {
        $("#ModalVer").modal();
        var Fecha = $(this).data("fecha");
        var Juego = $(this).data("juego");
        var IdJuego = $(this).data("id");
        var Moneda = $(this).data("moneda");
        Ganada = 0;
        $("#Codigo_NombreJuego").html("").html(IdJuego + " [ " + Juego + " ]");
        $("#TitleModal").html("").html(Fecha + ' - ' + Juego);
        $("#ValorTipoJugada").html("").html(Juego);
        $("#ValorGanado").html("").html(parseFloat(Ganada).toFixed(2) + " " + Moneda)
    });
    $(document).on('click', '#btnExcel', function () {
        GenerarExcel("table_panel", "Reporte de Ventas por Eventos")
    });
});

function GananciaTotal() {
    var table = $('#table_panel').DataTable();
    var data = table
        .rows()
        .data().toArray();
    var total = 0;
    $.each(data, function (key, value) {
        total += value.Ganado;
    });
    return total;
}

function ReporteVentaJson(url, dataForm) {
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
            debugger
            var resp = response.data;
            $("#PanelTabla").show();
            var objdata = $("#table_panel").DataTable({
                "bDestroy": true,
                "bSort": true,
                "scrollCollapse": true,
                "scrollX": false,
                "paging": true,
                "autoWidth": false,
                "bProcessing": true,
                "bDeferRender": true,
                "order": [[1, "desc"]],
                data: resp,
                columns: [
                    {data: "Fecha", title: "Fecha Evento", class: 'text-center'},
                    {data: "ZonaComercial", title: 'Zona Comercial', class: 'text-center'},
                    {data: "Tienda", title: 'Tienda', class: 'text-center'},
                    {data: "Juego", title: "Juego", class: 'text-center'},
                    {data: "Evento", title: "Evento", class: 'text-center'},
                    {data: "TipoApuesta", title: 'Tipo Apta', class: 'text-center'},
                    {data: "Moneda", title: "Moneda", class: 'text-center'},
                    {data: "Ganado", title: 'Ganado', class: 'text-center'},
                    {data: "estadoEvento", title: "Estado", class: 'text-center'},
                ],
                "drawCallback": function (settings) {
                }
            });

            objdata.on('search.dt', function () {
                var data = objdata.rows({filter: 'applied'}).data().toArray();
                var total = 0;
                $.each(data, function (key, value) {
                    total += value.Ganado;
                });
                $("#TotalGanancia").html(total);
            });

            $(".container-btnExcel").html("").append('<button class="btn btn-success btn-sm col-md-12 col-xs-12" id="btnExcel"><span\n' +
                '                                                class="glyphicon glyphicon-export"></span> Excel\n' +
                '                                    </button>');
            var total = GananciaTotal();
            $("#TotalGanancia").html(total);

        }
    })
}