$(document).ready(function () {
    var dateNow = new Date();
    $(".fechaSorteo").datetimepicker({
        // pickTime: true,
        // format: 'YYYY-MM-DD hh:mm:ss',
        // defaultDate: dateNow,
        // autoClose: true,
        // keepOpen: false,
        format: 'YYYY/MM/DD HH:mm:ss',
        defaultDate: dateNow,
    });

    $('#btnBuscar').on('click', function (e) {
        e.preventDefault();
        $usuario = $("#txtUsuario").val();
        if($usuario != ""){
            var dataForm = $('#frmNuevo').serializeFormJSON();
            $.ajax({
                url: basePath + 'ReporteAuditoriaJsonFk',
                data: dataForm,
                type: "POST",
                beforeSend: function () {
                    $.LoadingOverlay("show");
                },
                complete: function () {
                    $.LoadingOverlay("hide");
                },
                success: function (response) {

                    $("#table").DataTable({
                        "bDestroy": true,
                        "bSort": true,
                        "scrollCollapse": true,
                        "scrollX": false,
                        "paging": true,
                        "autoWidth": false,
                        "bProcessing": true,
                        "bDeferRender": true,
                        "aaSorting": [],
                        data: response.data,
                        columns: [
                            {
                                data: "fecha_registro", title: "Fecha Registro", "render": function (o) {
                                    return moment(o).format("DD-MM-YYYY HH:mm:ss A");
                                }
                            },
                            {data: "usuario", title: "Usuario"},
                            {data: "permiso", title: "Permiso"},
                            {data: "controller", title: "Controlador"},
                            {data: "method", title: "Metodo"},
                            {
                                data: "id", title: "", "bSortable": false,
                                "render": function (o) {
                                    return '<button type="button" class="btn btn-xs btn-warning btnmodalAuditoria" data-id="' + o + '"><i class="glyphicon glyphicon-list"></i></button>';
                                }
                            },
                        ],
                        "drawCallback": function (settings) {
                        }
                    });
                },
                error: function (jqXHR, textStatus, errorThrown) {
                }
            });
        }else{
            toastr.warning('Seleccione un Usuario','Mensaje Servidor');
        }

    });

    $(document).on('click', '.btnmodalAuditoria', function () {
        var id = $(this).data("id");
        $.ajax({
            url: basePath + 'DataAuditoriaRegistroFk',
            data: {
                txtAuditoriaID: id
            },
            type: "POST",
            beforeSend: function () {
                $.LoadingOverlay("show");
            },
            complete: function () {
                $.LoadingOverlay("hide");
            },
            success: function (response) {
                var dataAuditoria = response.data;
                var datos = $.parseJSON(dataAuditoria.data);
                $("#bodyModalAuditoria").html("");
                $.each(datos, function (key, value) {
                    var lista = value;
                    console.log(key);
                    $("#bodyModalAuditoria").append("<div class='col-md-6'><div class='form-control' style='margin-bottom:5px;'>" + key.replace("txt", "") + ":" + lista + "</div></div>");
                });
                if ($.isEmptyObject(datos)) {
                    toastr.error("No tiene Data", "Mensaje Servidor");
                }
                else {
                    $("#modalAuditoria").modal("show");

                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
            }
        });

    });

    $.when(llenarSelect(basePath + "ListdoUsuariosSelectFk", {}, "txtUsuario", "idUsuario", "usuario","")).then(function (response, textStatus) {
        $("#txtUsuario").select2();
    });
});