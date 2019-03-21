$(document).ready(function () {

    tabletUsuario();

    $(document).on('change', '.selectPerfil', function () {
        var perfil_id = $(this).val();
        var usuarioid = $(this).data("id");
        $.ajax({
            url: basePath + 'CambiarPerfilUsuario',
            data: {
                txtPerfilID: perfil_id, txtUsuarioID: usuarioid
            },
            type: "POST",
            beforeSend: function () {
                $.LoadingOverlay("show");
            },
            complete: function () {
                $.LoadingOverlay("hide");
            },
            success: function (response) {
                console.log(response);
                if (response.respuesta == true) {
                    toastr.success(response.mensaje, "Mensaje Servidor");
                }
                else {
                    toastr.error(response.mensaje, "Mensaje Servidor");
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
            }
        });
    });

    $(document).on('click', '.chkchecked', function () {
        var permisoid = $(this).data("permiso_id");
        var perfil_id = $("#txtPerfil").val();
        $.ajax({
            url: basePath + 'PermisoPerfilCheck',
            data: {
                txtPerfilID: perfil_id, txtPermisoID: permisoid
            },
            type: "POST",
            beforeSend: function () {
                $.LoadingOverlay("show");
            },
            complete: function () {
                $.LoadingOverlay("hide");
            },
            success: function (response) {
                console.log(response);
                if (response.respuesta == true) {
                    toastr.success(response.mensaje, "Mensaje Servidor");
                }
                else {
                    toastr.error(response.mensaje, "Mensaje Servidor");
                }

            },
            error: function (jqXHR, textStatus, errorThrown) {
            }
        });
    });

    $(document).on('click', '#btnBarrido', function () {

        $.ajax({
            url: basePath + 'BarridoPermisosFk',
            data: {},
            type: "GET",
            beforeSend: function () {
                $.LoadingOverlay("show");
            },
            complete: function () {
                $.LoadingOverlay("hide");
            },
            success: function (response) {
                console.log(response);
                if (response.respuesta == true) {
                    toastr.success(response.mensaje, "Mensaje Servidor");
                }
                else {
                    toastr.error(response.mensaje, "Mensaje Servidor");
                }

            },
            error: function (jqXHR, textStatus, errorThrown) {
            }
        });
    });
    $(document).on('click', '#btnBuscar', function () {
        var id = $("#txtPerfil").val();
        $.ajax({
            url: basePath + 'ListdoPermisosPerfil',
            data: {
                txtPerfilID: id
            },
            type: "POST",
            beforeSend: function () {
                $.LoadingOverlay("show");
            },
            complete: function () {
                $.LoadingOverlay("hide");
            },
            success: function (response) {
                console.log(response);
                var permisoID = [];
                $.each(response.data[1], function (s, val_) {
                    permisoID.push(val_.permiso_id);
                });
                console.log(permisoID);
                $("#tbodyPermisos").html("");
                $.each(response.data[0], function (s, val) {
                    var select = "";
                    if (jQuery.inArray(val.id, permisoID) >= 0) {
                        select = "checked";
                    }
                    $('#tbodyPermisos').append("<tr><td style='width: 40%'>" + val.nombre + "</td><td style='width: 40%'>" + val.method + "</td><td style='width: 20%;text-align:center;'><input " + select + " type='checkbox' data-permiso_id='" + val.id + "' name='chkpermiso_1' class='chkchecked'></td></tr>");
                });
                $("#modalAuditoria").modal("show");
            },
            error: function (jqXHR, textStatus, errorThrown) {
            }
        });

    });

    tabletUsuario();

    function tabletUsuario() {
        // body...
        $.ajax({
            url: basePath + 'ListdoUsuariosSelectFk',
            data: {},
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
                    data: response.data,
                    columns: [
                        {
                            data: "fecha_registro", title: "Fecha Registro", "bSortable": false
                        },
                        {data: "usuario", title: "Usuario"},
                        {
                            data: "perfil_id", title: "Perfil", "bSortable": false,
                            "render": function (o, q, t) {
                                var usuarioid = t.id;
                                var select = "";
                                select += "<select data-id='" + usuarioid + "' class='form-control selectPerfil' style='width:100%;'>";
                                if (o == 0) {
                                    select += "<option selected value='0'>Administrador</option>";
                                    select += "<option value='1'>Cajero</option>";
                                }
                                else {
                                    select += "<option value='0'>Administrador</option>";
                                    select += "<option selected value='1'>Cajero</option>";
                                }

                                select += "</select>";
                                return select;
                            }
                        },
                        {data: "id", title: "","bSortable": false,
                            "render": function (o) {
                                return '<button type="button" class="btn btn-sm btn-warning btnmodalPermisos" data-id="'+o+'"><i class="icon_info_alt"></i></button>';
                            }
                        },
                    ],
                    "drawCallback": function (settings) {
                        $('.btnmodalPermisos').tooltip({
                            title: "Permisos"
                        });
                    }
                });
            },
            error: function (jqXHR, textStatus, errorThrown) {
            }
        });
    }
});





