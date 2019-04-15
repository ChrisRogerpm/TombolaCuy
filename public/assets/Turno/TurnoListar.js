$(document).ready(function () {
    ListarTurno();
    $(document).on('click', '.btnEditar', function () {
        var idTurno = $(this).data("id");
        var url = basePath + "TurnoEditar/" + idTurno;
        window.location.replace(url);
    })
});

function ListarTurno() {
    $.ajax({
        type: 'POST',
        url: basePath + 'TurnoListarJsonFk',
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
                            return '<button type="button" class="btn btn-success btn-sm btnEditar" data-id="' + value.idTurno + '"><i class="fa fa-edit"></i></button>';
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