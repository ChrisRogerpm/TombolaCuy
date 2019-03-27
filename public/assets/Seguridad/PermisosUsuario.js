$(document).ready(function () {

    tabletUsuario();
    $(document).on('change', '.selectPerfil', function () {
        var perfil_id = $(this).val();
        var usuarioid = $(this).data("id");
        $.ajax({
            url: basePath + 'CambiarPerfilUsuarioFk',
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
                } else {
                    toastr.error(response.mensaje, "Mensaje Servidor");
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
            }
        });
    });
    $(document).on('ifChecked', '#tablePermisos input:checkbox', function () {
        var IdPerfil = $(this).data('perfil');
        var IdPermiso = $(this).data('permiso');
        GestionarPermisos(IdPermiso, IdPerfil);
    });
    $(document).on('ifUnchecked', '#tablePermisos input:checkbox', function () {
        var IdPermiso = $(this).data('permiso');
        var IdPerfil = $(this).data('perfil');
        GestionarPermisos(IdPermiso, IdPerfil);
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
                } else {
                    toastr.error(response.mensaje, "Mensaje Servidor");
                }

            },
            error: function (jqXHR, textStatus, errorThrown) {
            }
        });
    });
    $(document).on('click', '#btnBuscar', function () {
        var id = $("#txtPerfil").val();
        if (id === "") {
            toastr.warning('Seleccione un Perfil', 'Mensaje Servidor');
        } else {
            ListarPermisosPerfil(id);
        }
    });
    $(".icheck-inline").iCheck({
        checkboxClass: 'icheckbox_square-blue',
        radioClass: 'iradio_square-red',
        increaseArea: '25%'
    });
});

function GestionarPermisos(IdPermiso, IdPerfil) {
    $.ajax({
        url: basePath + 'PermisoPerfilCheckFk',
        data: {
            'txtPerfilID': IdPerfil, 'txtPermisoID': IdPermiso
        },
        type: "POST",
        // beforeSend: function () {
        //     $.LoadingOverlay("show");
        // },
        // complete: function () {
        //     $.LoadingOverlay("hide");
        // },
        success: function (response) {
            console.log(response);
            if (response.respuesta == true) {
                toastr.success(response.mensaje, "Mensaje Servidor");
            } else {
                toastr.error(response.mensaje, "Mensaje Servidor");
            }

        },
        error: function (jqXHR, textStatus, errorThrown) {
        }
    });
}

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
                            var usuarioid = t.idUsuario;
                            var select = "";
                            select += "<select data-id='" + usuarioid + "' class='form-control selectPerfil' style='width:100%;'>";
                            if (o == 0) {
                                select += "<option selected value='0'>Administrador</option>";
                                select += "<option value='1'>Cajero</option>";
                            } else {
                                select += "<option value='0'>Administrador</option>";
                                select += "<option selected value='1'>Cajero</option>";
                            }

                            select += "</select>";
                            return select;
                        }
                    }
                ]
            });
        },
        error: function (jqXHR, textStatus, errorThrown) {
        }
    });
}

function ListarPermisosPerfil(id) {
    $.ajax({
        url: basePath + 'ListdoPermisosPerfilFk',
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
            var permisoID = [];

            $.each(response.data[1], function (s, val_) {
                permisoID.push(val_.permiso_id);
            });
            console.log(permisoID);
            $("#bodyModal").html("").append('<div class="row">\n' +
                '                        <div class="col-md-12">\n' +
                '                            <table class="table table-condensed table-striped table-bordered" id="tablePermisos"></table>\n' +
                '                        </div>\n' +
                '                    </div>');


            $("#tablePermisos").DataTable({
                "bDestroy": true,
                "bSort": true,
                "scrollCollapse": true,
                "scrollX": false,
                "paging": true,
                "autoWidth": false,
                "bProcessing": true,
                "bDeferRender": true,
                data: response.data[0],
                columns: [
                    {data: "nombre", title: "Nombre"},
                    {data: "method", title: "Metodo"},
                    {
                        data: null, title: "",
                        "render": function (value) {

                            var select = "";
                            if (jQuery.inArray(value.id, permisoID) >= 0) {
                                select = "checked";
                            }
                            return '<div class="icheck-inline" style="margin-top: 5px;"><input type="checkbox" data-todos="2" data-permiso="' + value.id + '" data-perfil="' + id + '" name="chkpermiso_1" ' + select + ' data-checkbox="icheckbox_square-blue"></div>';
                        }
                    },
                ],
                "drawCallback": function (settings) {
                    $(".icheck-inline").iCheck({
                        checkboxClass: 'icheckbox_square-blue',
                        radioClass: 'iradio_square-red',
                        increaseArea: '25%'
                    });
                }
            });

            $("#modalAuditoria").modal("show");
        },
        error: function (jqXHR, textStatus, errorThrown) {
        }
    });
}





