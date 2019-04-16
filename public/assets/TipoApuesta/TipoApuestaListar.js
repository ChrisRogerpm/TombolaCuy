$(document).ready(function () {
    ListarTipoApuesta();
    $(document).on('click', '.btnEditar', function () {
        var idTipoApuesta = $(this).data("id");
        var url = basePath + "TipoApuestaEditar/" + idTipoApuesta;
        window.location.replace(url);
    })
});

function ListarTipoApuesta() {
    $.ajax({
        type: 'POST',
        url: basePath + 'TipoApuestaListarJsonFk',
        data: {
            '_token': $('input[name=_token]').val(),
        },
        success: function (response) {
            var resp = response.data;
            debugger;
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
                {data: "idTipoApuesta", title: "idTipoApuesta"},
                {data: "idTipoPago", title: "idTipoPago"},
                {data: "valorapuesta", title: "Valor Apuesta"},
                 {data: "nombre", title: "Nombre"},
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
                        return '<button type="button" class="btn btn-success btn-sm btnEditar" data-id="' + value.idTipoApuesta + '"><i class="fa fa-edit"></i></button>';
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