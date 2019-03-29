

$.fn.serializeFormJSON = function () {

    var o = {};
    var a = this.serializeArray();
    $.each(a, function () {
        if (o[this.name]) {
            if (!o[this.name].push) {
                o[this.name] = [o[this.name]];
            }
            o[this.name].push(this.value || '');
        } else {
            o[this.name] = this.value || '';
        }
    });
    return o;
}

var basePath = document.location.origin + "/";

function llenarSelect(url, data, select, dataId, dataValor, selectVal) {
    if (!url) {
        toastr.error("No se Declaro Url", "Mensaje Servidor");
        return false;
    }
    var mensaje = true;
    $.ajax({
        url: url,
        type: "POST",
        data: JSON.stringify(data),
        contentType: "application/json",
        beforeSend: function () {
            $("#" + select).html("");
            $("#" + select).append('<option value="">Cargando...</option>');
            $("#" + select).attr("disabled", "disabled");
            //$.LoadingOverlay("show");
        },
        success: function (response) {
            var datos = response.data;
            var mensaje = response.mensaje;
            if (datos.length > 0) {
                $("#" + select).html("");
                $("#" + select).append('<option value="">--Seleccione--</option>');
                if (selectVal == "allOption") {
                    $("#" + select).append('<option value="0">Todos</option>');
                }
                $.each(datos, function (index, value) {
                    var selected = "";
                    if ($.isArray(selectVal)) {
                        if (objectFindByKey(selectVal, dataId, value[dataId]) != null) {
                            selected = "selected='selected'";
                        }
                        ;
                    } else {

                        if (value[dataId] === selectVal) {
                            selected = "selected='selected'";
                        }
                        ;
                    }
                    $("#" + select).append('<option value="' + value[dataId] + '"    ' + selected + '>' + value[dataValor] + '</option>');

                });
                $("#" + select).removeAttr("disabled");
            } else {
                toastr.warning("No Hay Registros en " + select, 'Opps! Mensaje Servidor', 3500);
            }
            if (mensaje !== "") {
                toastr.error(mensaje, "Mensaje Servidor");
            }
        },
        complete: function () {
            //$.LoadingOverlay("hide");
        },
        error: function (jqXHR, textStatus, errorThrown) {
            mensaje = false;

        }
    });
    return mensaje;
}


function GenerarExcel(idTabla, NombreArchivo) {
    var table = $('#' + idTabla).DataTable();
    var data = table
        .rows()
        .data().toArray();
    var dataForm = {
        'table_data': data,
        '_token': $('input[name=_token]').val(),
        'NombreArchivo': NombreArchivo
    };
    if (data.length > 0){
        $.ajax({
            url: basePath + "GenerarExcelFk",
            type: "POST",
            contentType: "application/json",
            data: JSON.stringify(dataForm),
            beforeSend: function () {
                $.LoadingOverlay("show");
            },
            complete: function () {
                $.LoadingOverlay("hide");
            },
            success: function (response) {
                var respuesta = response.respuesta;
                if (respuesta === "") {
                    toast.warning(respuesta, 'Mensaje Servidor');
                } else {
                    var url = basePath + respuesta;
                    window.location.href = url;
                }
            }
        });
    } else{
        toastr.warning('No hay registros en la tabla','Mensaje Servidor');
    }
}

function GenerarExcelJackpot(idTabla, NombreArchivo) {
    var table = $('#' + idTabla).DataTable();
    var data = table
        .rows()
        .data().toArray();
    var dataForm = {
        'table_data': data,
        '_token': $('input[name=_token]').val(),
        'NombreArchivo': NombreArchivo
    };
    if (data.length > 0){
        $.ajax({
            url: basePath + "GenerarArchivoExcelJackpotFk",
            type: "POST",
            contentType: "application/json",
            data: JSON.stringify(dataForm),
            beforeSend: function () {
                $.LoadingOverlay("show");
            },
            complete: function () {
                $.LoadingOverlay("hide");
            },
            success: function (response) {
                var respuesta = response.respuesta;
                if (respuesta === "") {
                    toast.warning(respuesta, 'Mensaje Servidor');
                } else {
                    var url = basePath + respuesta;
                    window.location.href = url;
                }
            }
        });
    } else{
        toastr.warning('No hay registros en la tabla','Mensaje Servidor');
    }
}

//////////////////////////////////////////////////////////////  hora
//////////////////////////////////////////////////////////////  hora
function show5() {
    if (!document.layers && !document.all && !document.getElementById)
        return;

    var Digital = new Date();
    var hours = Digital.getHours();
    var minutes = Digital.getMinutes();
    var seconds = Digital.getSeconds();

    if ($("#fechaHoy").length) {
        var today = moment().format('DD/MM/YYYY');
        //Zdocument.getElementById("fechaHoy").innerHTML = today;
        window.onload = show5;
    var dn = "PM";
    if (hours < 12)
        dn = "AM";
    if (hours > 12)
        hours = hours - 12;
    if (hours == 0)
        hours = 12;

    if (minutes <= 9)
        minutes = "0" + minutes;
    if (seconds <= 9)
        seconds = "0" + seconds;
    //change font size here to your desire
    myclock = "<b>" + hours + ":" + minutes + ":"
        + seconds + " " + dn + "</b>";
    if (document.layers) {
        document.layers.liveclock.document.write(myclock);
        document.layers.liveclock.document.close();
    }
    else if (document.all)
        liveclock.innerHTML = myclock;
    else if (document.getElementById)
        document.getElementById("liveclock").innerHTML = myclock;
    setTimeout("show5()", 1000);
}


}

// if ($("#fechaHoy").length) {
//     var today = moment().format('DD/MM/YYYY');
//     //document.getElementById("fechaHoy").innerHTML = today;
//     window.onload = show5;
// }

///////////////////////////////////////////////////////////////////////////////////////////////////


///////////////////////////////////////////////////////////////////////////////////////////////////
