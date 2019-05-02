$(document).ready(function () {
    ListarTipoAlerta();

    $(document).on('click', '.btnProgramar', function () {
        var idTipoAlerta = $(this).data("id");
        var url = basePath + "TipoAlertaPuntoVenta/" + idTipoAlerta;
        window.location.replace(url);
    });
});

function ListarTipoAlerta() {
    $.ajax({
        type: 'POST',
        url: basePath + 'TipoAlertaListarJsonFk',
        success: function (response) {
            var resp = response.data;
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
                    {data: "idTipoAlerta", title: "#"},
                    {data: "nombre", title: "Tipo Alerta"},
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