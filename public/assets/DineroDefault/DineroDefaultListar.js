$(document).ready(function () {
    ListarDineroDefault();
    $(document).on('click', '.btnEditar', function () {
        var idDineroDefault = $(this).data("id");
        var url = basePath + "DineroDefaultEditar/" + idDineroDefault;
        window.location.replace(url);
    })
});

function ListarDineroDefault() {
    $.ajax({
        type: 'POST',
        url: basePath + 'DineroDefaultListarJson',
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
                    {data: "idDineroDefault", title: "Id"},
                    {data: "monto", title: "Monto"},
                    {
                        data:"estado",title:"Estado",
                        "render":function (value) {
                            var estado = value === 1 ? 'Activo': 'Inactivo';
                            return estado;
                        }
                    },
                    {
                        data: null, title: "",
                        "render": function (value) {
                            return '<button type="button" class="btn btn-success btn-sm btnEditar" data-id="' + value.idDineroDefault + '"><i class="fa fa-edit"></i></button>';
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