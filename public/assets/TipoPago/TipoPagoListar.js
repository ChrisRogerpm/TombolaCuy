$(document).ready(function () {
    ListarTipoPago();
    $(document).on('click', '.btnEditar', function () {
        var idTipoPago = $(this).data("id");
        var url = basePath + "TipoPagoEditar/" + idTipoPago;
        window.location.replace(url);
    })
});

function ListarTipoPago() {debugger;
    $.ajax({
        type: 'POST',
        url: basePath + 'TipoPagoListarJsonFk',
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
                {data: "idTipoPago", title: "Id"},
                {data: "nombre", title: "Nombre"},
                {data: "multiplicadorDefecto", title: "Multiplicador Defecto"},
                {
                    data:"estado",title:"Estado",
                    "render":function (value) {
                        var estado = value === 1 ? 'Activo': 'Inactivo';
                        return estado;
                    }
                },
                {data: "plenoMinimo", title: "Pleno Minimo"},
                {data: "plenoMaximo", title: "Pleno Maximo"},
                {data: "intercalado", title: "Intercalado"},
                {
                    data: null, title: "",
                    "render": function (value) {
                        return '<button type="button" class="btn btn-success btn-sm btnEditar" data-id="' + value.idTipoPago + '"><i class="fa fa-edit"></i></button>';
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