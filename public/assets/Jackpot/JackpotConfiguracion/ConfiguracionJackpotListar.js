$(document).ready(function () {
    ListarJackpotConfiguracion();
    $(document).on('click', '.btnEditar', function () {
        var idConfiguracionJackpot = $(this).data("id");
        var url = basePath + "ConfiguracionJackpotEditar/" + idConfiguracionJackpot;
        window.location.replace(url);
    })
});

function ListarJackpotConfiguracion() {
    $.ajax({
        type: 'POST',
        url: basePath + 'ConfiguracionJackpotListarJson',
        data: {
            '_token': $('input[name=_token]').val(),
        },
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
                    {data: "idConfiguracionJackpot", title: "Id"},
                    {data: "nombre", title: "Nombre"},
                    {data: "NroPozos", title: "Nro Pozos"},
                    {
                        data: "superjackpot", title: "MegaJackpot",
                        "render": function (value) {
                            var superjackpot;
                            if (value == 1) {
                                superjackpot = "SI";
                            } else {
                                superjackpot = "NO";
                            }
                            return superjackpot;
                        }
                    },
                    {
                        data: null, title: "",
                        "render": function (value) {
                            return '<button type="button" class="btn btn-success btn-sm btnEditar" data-id="' + value.idConfiguracionJackpot + '"><i class="fa fa-edit"></i></button>';
                        }
                    }
                ],
                "drawCallback": function (settings) {
                    $('.btnEditar').tooltip({
                        title: "Editar"
                    });
                }
            });
        },
    })
}
