$(document).ready(function () {
    ListarUsuarioPuntoVenta();
    $(document).on('click', '.Configuracion', function () {
        var idUsuarioPuntoVenta = $(this).data("id");
        var url = basePath + "UsuarioPuntoVentaEditar/" + idUsuarioPuntoVenta;
        window.location.replace(url);
    });
});

function ListarUsuarioPuntoVenta() {
    $.ajax({
        type: 'POST',
        url: basePath + 'UsuarioPuntoVentaListarJsonFk',
        beforeSend: function () {
            $.LoadingOverlay("show");
        },
        complete: function () {
            $.LoadingOverlay("hide");
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
                    {data: "idUsuario", title: "#", class: "text-center"},
                    {data: "usuario", title: "Usuario", class: "text-center"},
                    {data: "total", title: "Punto de Ventas Asignados", class: "text-center"},
                    {
                        data: null, title: "",
                        "render": function (value) {
                            return '<button type="button" class="btn btn-warning btn-sm Configuracion" data-id="' + value.idUsuario + '"><i class="fa fa-cog"></i></button>';
                        }, class: "text-center"
                    }
                ],
                "drawCallback": function (settings) {
                    $('.Configuracion').tooltip({
                        title: "Configuración"
                    });
                }
            });
        },
    })
}