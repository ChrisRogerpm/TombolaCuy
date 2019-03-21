

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





//////////////////////////////////////////////////////////////  hora
function actualizar_hora() {
    var Digital = new Date();
    var hours = Digital.getHours();
    var minutes = Digital.getMinutes();
    var seconds = Digital.getSeconds();

    if ($("#fechaHoy").length) {
        var today = moment().format('DD/MM/YYYY');
        window.onload = actualizar_hora;
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
        myclock = "<b>" + hours + ":" + minutes + ":" + seconds + " " + dn + "</b>";
        document.getElementById("liveclock").innerHTML = myclock;
        setTimeout(actualizar_hora(), 1000);
    }
}
if ($("#fechaHoy").length) {
    var today = moment().format('DD/MM/YYYY');
    window.onload = actualizar_hora;
}

///////////////////////////////////////////////////////////////////////////////////////////////////
