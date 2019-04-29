


function onMouseMove(evt) {
if(renderer) {

    var x = ( event.clientX / window.innerWidth ) * 2 - 1;
    var y =  - ( event.clientY / window.innerHeight ) * 2 + 1;
    var vNow = new THREE.Vector3(x, y, 0);
    console.info(vNow);
    vNow.unproject(camera);
   // splineArray.push(vNow);
    
}
}
function onMouseUp(evt) {
     document.removeEventListener("mousemove",onMouseMove,false);
}
function onMouseDown(evt) {
       
            if(evt.which == 3) return;
            var x = ( event.clientX / window.innerWidth ) * 2 - 1;
            var y =  - ( event.clientY / window.innerHeight ) * 2 + 1;
            // do not register if right mouse button is pressed.
            var vNow = new THREE.Vector3(x, y, 0);
            vNow.unproject(camera);
            console.log(vNow.x + " " + vNow.y+  " " + vNow.z); 
            //  splineArray.push(vNow);
            document.addEventListener("mousemove",onMouseMove,false);
            document.addEventListener("mouseup",onMouseUp,false);
}

       // document.addEventListener("mousemove",onMouseMove,false);



function iniciar_juego() {
    $("#ImgContainer").hide();
    if (typeof var_cuydudando !== "undefined") {
        cancelAnimationFrame(var_cuydudando);
    }
    cuydudando();
   // teclas();
}
function cuyrandom() { //// genera posición random =>   b  ,  EJECUTA  cuy_rotacion()  y  mover_cuy()
    if (typeof var_cuymoviendo === "undefined") {
        t = 0;  ///coeficiente
        aumento = 0;
        randomx = Math.random() >= 0.5 ? Math.abs(parseFloat(random_posicion(0, 2.4))) : -Math.abs(parseFloat(random_posicion(0, 2.4))) ;  // rango x=> -2.5  a   2.5 
        randomz = Math.random() >= 0.5 ? Math.abs(parseFloat(random_posicion(0, 2.4))) : -Math.abs(parseFloat(random_posicion(0, 2.4))); // rango z=> -2.5  a   2.5
        b = { x: randomx, y: 0, z: randomz  };
        console.log(a);
        console.log(b);
        //console.info("--");
        modelCuyDudando.visible = false;
        modelCuyChoque.visible = false;
        model.visible = true;
        //model.lookAt(b.x, b.y, b.z);
        //modelCuyDudando.lookAt(b.x, b.y, b.z);
        //modelCuyChoque.lookAt(b.x, b.y, b.z);
        mixer.update(clock.getDelta());
        renderer.render(scene, camera);
        //model.lookAt(a.x,a.y,a.z);
        q1 = new THREE.Quaternion().copy(model.quaternion);
        model.lookAt(b.x,b.y,b.z);
        q2 = new THREE.Quaternion().copy(model.quaternion); timerotacion = 0;

        if (typeof var_cuymoviendo != "undefined") {
            cancelAnimationFrame(var_cuymoviendo);
            delete var_cuymoviendo;
        }
        if (typeof var_cuychoque != "undefined") {
            cancelAnimationFrame(var_cuychoque);
            delete var_cuychoque;
        }
        if (typeof var_cuydudando != "undefined") {
            cancelAnimationFrame(var_cuydudando);
            delete var_cuydudando;
        }
        callback_rotacion = function () { ///se ejecuta al acabar  cuy_rotacion();
            mover_cuy();
        }
        cuy_rotacion();
        //setTimeout(function () {
        //   // funcion_callback = function () { console.warn("Termino MOVERRRRRRRRR");}
        //    mover_cuy();
        //}, 1000);
    } else {
        cancelAnimationFrame(var_cuymoviendo);
    }
}


////// mueve cuy a posicion   variable b       a=> nueva posicion cuy
function mover_cuy() {    ///var_cuymoviendo  => animationframe
    model.visible = true;
    modelCuyChoque.visible = false;
    modelCuyDudando.visible = false;
    if (typeof var_cuydudando !== "undefined") {
        cancelAnimationFrame(var_cuydudando);
    }
    if (typeof var_cuychoque!== "undefined") {
        cancelAnimationFrame(var_cuychoque);
    }

    var newX = lerp(a.x, b.x, ease(t));  
    var newY = lerp(a.y, b.y, ease(t));  
    var newZ = lerp(a.z, b.z, ease(t));  
    model.position.set(newX,0,newZ); 
    t += dt;
    //console.warn("x=> " + newX + "  y=>" + newY + "  z= " + newZ);
    mixer.update(clock.getDelta());
    var_cuymoviendo = requestAnimationFrame(mover_cuy);
    renderer.render(scene, camera);
    if(t>=1)
    {
        console.warn("LLEGÓ");
         cancelAnimationFrame(var_cuymoviendo);
        if (typeof animacion !== "undefined") {
            cancelAnimationFrame(animacion);
            delete animacion;
            aumento = 0;
        }
        if (typeof var_cuymoviendo !== "undefined") {
            cancelAnimationFrame(var_cuymoviendo);
            delete var_cuymoviendo;
            aumento = 0;
        }
         if (typeof var_cuy_rotando != "undefined") {
            cancelAnimationFrame(var_cuy_rotando);
            delete var_cuy_rotando;
        }
        model.position.set(b.x, b.y, b.z); ///ajustar posición si no llegó exacto
        a = { x: model.position.x, y: model.position.y, z: model.position.z }; 
      
        modelCuyDudando.position.z = model.position.z;
        modelCuyDudando.position.x = model.position.x;
        modelCuyDudando.position.y = model.position.y;
        modelCuyChoque.position.z = model.position.z;
         modelCuyChoque.position.x = model.position.x;
        modelCuyChoque.position.y = model.position.y;
        if(GANADOR_DE_EVENTO==0 && a.x==get_caja(0).posicion.x && a.z==get_caja(0).posicion.z){
            cuychoque();
        }
         else{
             cuydudando();
            }
        if (typeof funcion_callback !== "undefined" && funcion_callback!=null) {
            funcion_callback();
            funcion_callback = null; delete funcion_callback;
        }
    }
}
function cuy_rotacion() {//var_cuy_rotando
    modelCuyDudando.visible = false;
    model.visible = true;
    modelCuyChoque.visible = false;
    dtrotacion = 0.1; // changed
    timerotacion += dtrotacion;
    var_cuy_rotando = requestAnimationFrame(cuy_rotacion);
    mixer.update(clock.getDelta());

    THREE.Quaternion.slerp(q1, q2, model.quaternion, timerotacion); // added
    renderer.render(scene, camera);
    if (timerotacion > 1) {
        timerotacion = 0; cancelAnimationFrame(var_cuy_rotando) // changed
        console.info("acabo rotacion")
        modelCuyDudando.rotation.x = model.rotation.x;
        modelCuyDudando.rotation.y = model.rotation.y;
        modelCuyDudando.rotation.z = model.rotation.z;
        modelCuyChoque.rotation.x = model.rotation.x;
        modelCuyChoque.rotation.y = model.rotation.y;
        modelCuyChoque.rotation.z = model.rotation.z;
        modelCuyDudando.position.x = model.position.x;
        modelCuyDudando.position.y = model.position.y;
        modelCuyDudando.position.z = model.position.z;
        a = { x: model.position.x, y: model.position.y, z: model.position.z }; 

        cuydudando();
        if (typeof callback_rotacion != "undefined") {
            callback_rotacion();
            delete callback_rotacion;
        }
    }
}
function moveracaja(location) {
    if (typeof cuymoviendo === "undefined") {
        t = 0;
        aumento = 0;
        b = { x: location.x, y: location.y, z: location.z};
        console.log(a);
        console.log(b);
        console.info("-------");
        modelCuyDudando.visible = false;
        model.visible = true;
        modelCuyChoque.visible = false;
        //model.lookAt(b.x, b.y, b.z);
        //modelCuyDudando.lookAt(b.x, b.y, b.z);
        //modelCuyChoque.lookAt(b.x, b.y, b.z);
        console.info(model.rotation.y);
        mixer.update(clock.getDelta());
        renderer.render(scene, camera);

        q1 = new THREE.Quaternion().copy(model.quaternion);
        model.lookAt(b.x, b.y, b.z);
        q2 = new THREE.Quaternion().copy(model.quaternion); timerotacion = 0;
      
        if (typeof var_cuymoviendo != "undefined") {
            cancelAnimationFrame(var_cuymoviendo);
            delete var_cuymoviendo;
        }
        if (typeof var_cuychoque != "undefined") {
            cancelAnimationFrame(var_cuychoque);
            delete var_cuychoque;
        }
        if (typeof var_cuydudando != "undefined") {
            cancelAnimationFrame(var_cuydudando);
            delete var_cuydudando;
        }
        //callback_rotacion = function () { ///se ejecuta al acabar  cuy_rotacion();
        //    mover_cuy();
        //}
      //  cuy_rotacion();

        setTimeout(function () {
            mover_cuy();
        }, 500);
    } else {
        cancelAnimationFrame(cuymoviendo);
    }
}

function moverderecha() {
    $("#ImgContainer").hide();
    mixer.update(clock.getDelta());
    animacion = requestAnimationFrame(moverderecha);
    model.visible = true;
    modelCuyDudando.visible = false;
    modelCuyChoque.visible = false;
    model.position.x = model.position.x + 0.03;
    renderer.render(scene, camera);
    aumento = aumento + 0.005;
    //console.info(aumento + " - " + model.position.z);
    if (aumento > 0.10) {
        if (typeof animacion !== "undefined") {
            cancelAnimationFrame(animacion);
            aumento = 0;
        }
        modelCuyDudando.position.z = model.position.z;
        modelCuyDudando.position.x = model.position.x;
        modelCuyDudando.position.y = model.position.y;
        cuydudando();
    }
    else {/**/
    }
}
function moverizquierda() {
    $("#ImgContainer").hide();
    mixer.update(clock.getDelta());
    animacion = requestAnimationFrame(moverizquierda);
    model.visible = true;
    modelCuyDudando.visible = false;
    modelCuyChoque.visible = false;
    model.position.x = model.position.x - 0.03;
    renderer.render(scene, camera);
    aumento = aumento + 0.005;
    //console.info(aumento + " - " + model.position.z);
    if (aumento > 0.10) {
        if (typeof animacion !== "undefined") {
            cancelAnimationFrame(animacion);
            aumento = 0;
        }
        modelCuyDudando.position.z = model.position.z;
        modelCuyDudando.position.x = model.position.x;
        modelCuyDudando.position.y = model.position.y;
        cuydudando();
    }
    else {/**/
    }
}
function rotarderecha() {
    $("#ImgContainer").hide();
    mixer.update(clock.getDelta());
    animacion = requestAnimationFrame(rotarderecha);
    model.visible = true;
    modelCuyDudando.visible = false;
    modelCuyChoque.visible = false;
    model.rotation.y = model.rotation.y - 0.03;
    //model.rotateY(0.05);

    renderer.render(scene, camera);
    aumento = aumento + 0.005;
    //console.info(aumento + " - " + model.position.z);
    if (aumento > 0.09) {
        if (typeof animacion !== "undefined") {
            cancelAnimationFrame(animacion);
            aumento = 0;
        }
        modelCuyDudando.position.z = model.position.z;
        modelCuyDudando.position.x = model.position.x;
        modelCuyDudando.position.y = model.position.y;
        //modelCuyDudando.rotation.y = model.rotation.y;
        modelCuyDudando.rotation.y = model.rotation.y;

        cuydudando();
    }
    else {/**/
    }
}
function rotarizquierda() {
    $("#ImgContainer").hide();
    mixer.update(clock.getDelta());
    animacion = requestAnimationFrame(rotarizquierda);
    model.visible = true;
    modelCuyDudando.visible = false;
    modelCuyChoque.visible = false;
    model.rotation.y = model.rotation.y + 0.03;

    renderer.render(scene, camera);
    aumento = aumento + 0.005;
    //console.info(aumento + " - " + model.position.z);
    if (aumento > 0.09) {
        if (typeof animacion !== "undefined") {
            cancelAnimationFrame(animacion);
            aumento = 0;
        }
        modelCuyDudando.position.z = model.position.z;
        modelCuyDudando.position.x = model.position.x;
        modelCuyDudando.position.y = model.position.y;
        modelCuyDudando.rotation.y = model.rotation.y;
        cuydudando();
    }
    else {/**/
    }
}



function moveraposition(x, y, z) {
    if (typeof var_cuydudando !== "undefined") {
        modelCuyDudando.visible = false;
        cancelAnimationFrame(var_cuydudando);
    }
    $("#ImgContainer").hide();
    mixer.update(clock.getDelta());
    animacion = requestAnimationFrame(moveraposition);
    model.visible = true;
    modelCuyDudando.visible = false;
    modelCuyChoque.visible = false;
    //model.position.x = x;
    //model.position.y = y;
    //model.position.z = z;
    model.position.set(x,y,z);
    renderer.render(scene, camera);
    aumento = aumento + 0.005;
    //console.info(aumento + " - " + model.position.z);
    if (aumento > 0.10) {
        if (typeof animacion !== "undefined") {
            cancelAnimationFrame(animacion);
            aumento = 0;
        }
        modelCuyDudando.position.z = model.position.z;
        modelCuyDudando.position.x = model.position.x;
        modelCuyDudando.position.y = model.position.y;
        modelCuyDudando.rotation.y = model.rotation.y;
        cuydudando();
    }
    else {/**/
    }
}
function moverarriba() {
    $("#ImgContainer").hide();
    mixer.update(clock.getDelta());
    animacion = requestAnimationFrame(moverarriba);
    model.visible = true;
    modelCuyDudando.visible = false;
    modelCuyChoque.visible = false;
    //model.position.z = model.position.z - 0.01;
    model.translateZ(0.01);
    renderer.render(scene, camera);
    aumento = aumento + 0.005;
   //console.info(aumento + " - " + model.position.z);
    if (aumento > 0.10) {
        if (typeof animacion !== "undefined") {
            cancelAnimationFrame(animacion);
            aumento = 0;
        }
        modelCuyDudando.position.z = model.position.z;
        modelCuyDudando.position.x = model.position.x;
        modelCuyDudando.position.y = model.position.y;
        modelCuyDudando.rotation.y = model.rotation.y;

        cuydudando();
    }
    else {/**/
    }
}
function moverabajo() {
    $("#ImgContainer").hide();
    mixer.update(clock.getDelta());
    animacion = requestAnimationFrame(moverabajo);
    model.visible = true;
    modelCuyDudando.visible = false;
    modelCuyChoque.visible = false;
    //model.position.z = model.position.z + 0.01;
    model.translateZ(-0.01);

    renderer.render(scene, camera);
    aumento = aumento + 0.005;
    ///console.info(aumento + " - " + model.position.z);
    if (aumento > 0.10) {
        if (typeof animacion !== "undefined") {
            cancelAnimationFrame(animacion);
            aumento = 0;
        }
        modelCuyDudando.position.z = model.position.z;
        modelCuyDudando.position.x = model.position.x;
        modelCuyDudando.position.y = model.position.y;
        modelCuyDudando.rotation.y = model.rotation.y;
        cuydudando();
    }
    else {/**/
    }
}




function teclas() {///mover cuy con teclas flechas  y ctrl  giro
    $("#ImgContainer").hide();
    document.onkeydown = function (e) {
        ctrlpresionado = false;
        if (e.ctrlKey === true) {
            ctrlpresionado = true;
        }
        if (ctrlpresionado) {
            if (e.which === 37) {//izq rot
                if (typeof var_cuydudando !== "undefined") {
                    cancelAnimationFrame(var_cuydudando);
                }; aumento = 0;
                if (typeof animacion !== "undefined") {
                    cancelAnimationFrame(animacion);
                }
                rotarizquierda();
            }
            else if (e.which === 39) {//der rot
                if (typeof var_cuydudando !== "undefined") {
                    cancelAnimationFrame(var_cuydudando);
                }; aumento = 0;
                if (typeof animacion !== "undefined") {
                    cancelAnimationFrame(animacion);
                }
                rotarderecha();
            }
            //else if (e.which === 68) {
            //    cancelAnimationFrame(cuyanimacion);
            //    animacion_cuydudando();
            //}
        }
        else {
            if (e.keyCode === 38) {
                //arriba
                aumento = 0;
                nuevaposicion = model.position.z + 0.8;
                console.warn(nuevaposicion);
                if (typeof var_cuydudando !== "undefined") {
                    cancelAnimationFrame(var_cuydudando);
                }
                if (typeof animacion !== "undefined") {
                    cancelAnimationFrame(animacion);
                }
                moverarriba();
            } else if (e.which === 40) {///abajo
                if (typeof var_cuydudando !== "undefined") {
                    cancelAnimationFrame(var_cuydudando);
                }
                aumento = 0;
                nuevaposicion = model.position.z - 0.8;
                console.warn(nuevaposicion);
                if (typeof animacion != "undefined") {
                    cancelAnimationFrame(animacion);
                }
                moverabajo();

            } else if (e.which === 39) {//der
                if (typeof var_cuydudando !== "undefined") {
                    cancelAnimationFrame(var_cuydudando);
                }
                aumento = 0;
                nuevaposicion = model.position.z + 0.8;
                console.warn(nuevaposicion);
                //model.position.z = model.position.z - 0.27;
                //model.position.x = model.position.x + 0.27;
                if (typeof animacion != "undefined") {
                    cancelAnimationFrame(animacion);
                }
                moverderecha();


            } else if (e.which === 37) {//izq
                if (typeof var_cuydudando !== "undefined") {
                    cancelAnimationFrame(var_cuydudando);
                }
                aumento = 0;
                nuevaposicion = model.position.z + 0.8;
                console.warn(nuevaposicion);
                //model.position.z = model.position.z - 0.07;
                //model.position.x = model.position.x - 0.07;
                    if (typeof animacion != "undefined") {
                        cancelAnimationFrame(animacion);
                    }
                        moverizquierda();
            }
        }
    };
}


function bloquear_teclas_mouse(){

    document.onkeydown = function(e) {
                if(e.keyCode == 123) {
                return false;
                }
                if(e.ctrlKey && e.shiftKey && e.keyCode == 'I'.charCodeAt(0)){
                return false;
                }
                if(e.ctrlKey && e.shiftKey && e.keyCode == 'J'.charCodeAt(0)){
                return false;
                }
                if(e.ctrlKey && e.keyCode == 'U'.charCodeAt(0)){
                return false;
                }
    }



    document.addEventListener("contextmenu", function(e){
        e.preventDefault();
    }, false);
    
}






/**
 * @author alteredq / http://alteredqualia.com/
 */

THREE.SceneUtils = {

    createMultiMaterialObject: function ( geometry, materials ) {

        var group = new THREE.Group();

        for ( var i = 0, l = materials.length; i < l; i ++ ) {

            group.add( new THREE.Mesh( geometry, materials[ i ] ) );

        }

        return group;

    },

    detach: function ( child, parent, scene ) {

        child.applyMatrix( parent.matrixWorld );
        parent.remove( child );
        scene.add( child );

    },

    attach: function ( child, scene, parent ) {

        child.applyMatrix( new THREE.Matrix4().getInverse( parent.matrixWorld ) );

        scene.remove( child );
        parent.add( child );

    }

};