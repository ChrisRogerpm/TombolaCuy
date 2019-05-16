$(document).ready(function () {
    ListarJuegos();
    $(document).on('click', '.btnEditar', function () {
        var IdJuego = $(this).data('id');
        var url = basePath + "JuegoEditarVista/" + IdJuego;
        window.location.replace(url);
    });
});

function ListarJuegos() {
    var url = basePath + "JuegoListarJsonFk";
    $.ajax({
        type: 'POST',
        url: url,
        beforeSend: function () {
            $.LoadingOverlay("show");
        },
        complete: function () {
            $.LoadingOverlay("hide");
        },
        success: function (response) {
            var data = response.data;
            $("#table").DataTable({
                "bDestroy": true,
                "bSort": true,
                "scrollCollapse": true,
                "scrollX": false,
                "paging": true,
                "autoWidth": false,
                "bProcessing": true,
                "bDeferRender": true,
                data: data,
                columns: [
                    {data: "nombre", title: "Juego", class: "text-center"},
                    {data: "apuestaMinima", title: "Apuesta Minima", class: "text-center"},
                    {data: "apuestaMaxima", title: "Premio Maximo Pagar", class: "text-center"},
                    {
                        data: null, title: "",
                        "render": function (value) {
                            return '<button type="button" class="btn btn-success btn-sm btnEditar" data-id="' + value.idJuego + '"><i class="fa fa-edit"></i></button>';
                        }, class: "text-center"
                    }
                ],
                "drawCallback": function (settings) {
                    $('.btnEditar').tooltip({
                        title: "Editar"
                    });
                }
            });
        }
    })
}