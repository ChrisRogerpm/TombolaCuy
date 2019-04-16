$(document).ready(function () {
    ListarCliente();
    $(document).on('click', '.btnEditar', function () {
        var idCliente = $(this).data("id");
        var url = basePath + "ClienteEditar/" + idCliente;
        window.location.replace(url);
    })
});

function ListarCliente() {
    $.ajax({
        type: 'POST',
        url: basePath + 'ClienteListarJsonFk',
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
                    {
                        data: null, title: "Nombre Completo",
                        "render": function (value) {
                            return value.nombres + ' ' + value.apePaterno + ' ' + value.apeMaterno;
                        }
                    },
                    {data: "dni", title: "DNI"},
                    {
                        data: null, title: "",
                        "render": function (value) {
                            return '<button type="button" class="btn btn-success btn-sm btnEditar" data-id="' + value.idCliente + '"><i class="fa fa-edit"></i></button>';
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