$(document).ready(function () {
    // $(".select2").select2();
    var dateNow = new Date();
    $(".Fecha").datetimepicker({
        format: 'YYYY/MM/DD HH:mm:ss',
        defaultDate: dateNow,
    });


    // $.when(llenarSelect(basePath + "PuntoVentaListarUsuarioJson", {'_token': $("input[name='_token']").val()}, "cboTienda", "idPuntoVenta", "nombre", "")).then(function (response, textStatus) {
    //     $("#cboTienda").select2();
    // });
    $('.multiselect').select2({
        tags: false, allowClear: true, buttonWidth: '100%',
        width: '100%',
        placeholder: {
            id: '', // the value of the option
            text: '--Seleccione--'
        }
    });
    llenarSelect(basePath + "PuntoVentaListarUsuarioJson", {}, "cboTienda", "idPuntoVenta", "nombre", "allOption", false);
    $("#cboTienda").select2('val', [0]);

    $(document).on('click', '#btnBuscar', function () {
        var validar = $("#frmNuevo");
        if (validar.valid()) {
            var TiendaArray = [];
            $("#cboTienda option:selected").each(function () {
                if ($(this).val() !== "") {
                    TiendaArray.push({'Id': $(this).val(), 'Tienda': $(this).text()})
                }
            });
            $("#ContenedorTabla").html("").append('<div class="panel panel-primary" id="PanelTabla"><div class="panel-body">\n' +
                '<table class="table" id="table_panel"><thead><tr></tr></thead></table>\n' +
                '<div class="tab-content"></div>\n' +
                '</div>\n' +
                '</div>');
            $("#PanelTabla #table_panel thead tr").html("");
            $("#PanelTabla .tab-content").html("");
            $.each(TiendaArray, function (key, value) {
                var Active = key === 0 ? 'in active' : '';
                var IdTienda = value.Id;
                var NombreTienda = value.Tienda;
                var TiendasNombreId = NombreTienda + IdTienda;
                var TablaNombreTienda = "table" + TiendasNombreId.split(' ').join('');
                $("#PanelTabla #table_panel thead tr")
                    .append('<th class="text-center btn btn-primary" data-toggle="pill" href="#' + TiendasNombreId.split(' ').join('') + '" style="margin-right:2px; color:white;">' + NombreTienda + '</th>');
                $("#PanelTabla .tab-content")
                    .append('<div id="' + TiendasNombreId.split(' ').join('') + '" class="tab-pane fade ' + Active + '">' +
                        '<table id="table' + TiendasNombreId.split(' ').join('') + '" class="table table-bordered table-striped" style="width:100%"></table>\n' +
                        '</div>');
                CargarDataTienda(TablaNombreTienda, IdTienda, NombreTienda);
            });
        }
    });
});

function CargarDataTienda(Tabla, IdTienda,NombreTienda) {
    var tienda =IdTienda;
    debugger
    var url = basePath + "ReporteApuestaJson";
    var dataForm = {
        fechaInicio: $("input[name='fechaInicio']").val(),
        fechaFin: $("input[name='fechaFin']").val(),
        tiendas: IdTienda,
        _token: $("input[name='_token']").val()
    };
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
        success: function (response) {debugger;
            var resp = response.data;
            $("#PanelTabla").show();
            $("#" + Tabla).DataTable({
                dom: 'Bfrtip',
                buttons: [
                    {
                        extend: 'excelHtml5',
                        title: 'Reporte Apuestas - Tienda ' + NombreTienda
                    }
                ],
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
                    {data: "apuestas", title: "Apuestas"},
                    {data: "Pagos", title: "Pagos"},
                    {data: "Evento", title: "Evento"},
                    {data: "Jugadores", title: "Jugadores"},
                    {data: "fechaoperacion", title: "Fecha de Operacion"},
                ]
            });
        },
        error: function (jqXHR, textStatus, errorThrown) {
        }
    });
}

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