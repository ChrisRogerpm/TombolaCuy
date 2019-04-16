$(document).ready(function () {
    ListarEmpresa();
    $(document).on('click', '.btnEditar', function () {
        var idEmpresa = $(this).data("id");
        var url = basePath + "EmpresaEditar/" + idEmpresa;
        window.location.replace(url);
    })
});

function ListarEmpresa() {
    $.ajax({
        type: 'POST',
        url: basePath + 'EmpresaListarJsonFk',
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
                    {data: "razonSocial", title: "Razon Social"},
                    {data: "ruc", title: "RUC"},
                    {data: "direccion", title: "Direccion"},
                    {data: "telefono", title: "Telefono"},
                    {
                        data: null, title: "",
                        "render": function (value) {
                            return '<button type="button" class="btn btn-success btn-sm btnEditar" data-id="' + value.idEmpresa + '"><i class="fa fa-edit"></i></button>';
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