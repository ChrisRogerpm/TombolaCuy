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
        url: basePath + 'AperturaCajaListarJsonFk',
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
                    {data: "Caja", title: "Caja", class: "text-center"},
                    {data: "Turno", title: "Turno", class: "text-center"},
                    {data: "usuario", title: "Usuario", class: "text-center"},
                    {data: "fechaRegistro", title: "Fecha Apertura", class: "text-center"},
                    {
                        data: "fechaCierre", title: "Fecha Cierre", class: "text-center",
                        "render": function (value) {
                            var data = value == null ? '--' : value;
                            return data;
                        }
                    },
                    {
                        data: null, title: "Estado",
                        "render": function (value) {
                            var estado = value.estado == 1 ? 'Caja Aperturada' : 'Caja Cerrada';
                            return '<span class="label label-success" style="padding:5px;">' + estado + '</span>';
                        }, class: "text-center"
                    },
                    {
                        data: null, title: "",
                        "render": function (value) {
                            var estado = value.estado;
                            if (estado === 1) {
                                return '<button type="button" class="btn btn-success btn-sm btnEditar" data-id="' + value.idAperturaCaja + '"><i class="fa fa-edit"></i></button>';
                            } else {
                                return '<button type="button" class="btn btn-success btn-sm" disabled><i class="fa fa-edit"></i></button>';
                            }

                        }, class: "text-center"
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