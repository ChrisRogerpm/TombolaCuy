$(document).ready(function () {
    ListarAperturaCaja();
    $(document).on('click', '.btnEditar', function () {
        var idAperturaCaja = $(this).data("id");
        var url = basePath + "AperturaCajaEditar/" + idAperturaCaja;
        window.location.replace(url);
    })
});

function ListarAperturaCaja() {
    $.ajax({
        type: 'POST',
        url: basePath + 'AperturaCajaListarJson',
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
                    {data: "Caja", title: "Caja"},
                    {data: "Turno", title: "Turno"},
                    {data: "usuario", title: "Usuario"},
                    {data: "fechaOperacion", title: "Fecha Operacion"},
                    {
                        data: null, title: "",
                        "render": function (value) {
                            return '<button type="button" class="btn btn-success btn-sm btnEditar" data-id="' + value.idAperturaCaja + '"><i class="fa fa-edit"></i></button>';
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