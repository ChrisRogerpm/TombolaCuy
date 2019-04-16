

///////////FUNCIONESSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSS
var index = 0;
var archivos = ['images/cuy6.glb', 'images/cajaPensando.glb', 'images/cuyDudandoGLB.glb', 'images/cuyChoqueGLB.glb'];
var objLoader = new THREE.GLTFLoader();
var escalacuys = 0.3;
var intervalo_consultaevento=1800;
buscando_evento=false;
function cargar_archivos() {
    if (index > archivos.length - 1) {
        modelCaja.children[0].position.y=30
        console.warn("FIN CARGAA ARCHIVOS");
        loaded = true;

        //consultarEvento(1);

        intervalo_revisar_evento=setInterval(function(){
                    if(!buscando_evento){
                        consultarEvento(1);
                    }
                },intervalo_consultaevento)  
    //    iniciar_juego();
      //  cajagirando_animacion();
        return
    };

    objLoader.load(archivos[index], function (gltf) {
        if (archivos[index] == "images/cuy6.glb") {
            model = gltf.scenes[0];
            model.traverse(function (object) {
                if (object instanceof THREE.Mesh) {
                    object.castShadow = true
                }
            });
            model.scale.set(escalacuys, escalacuys, escalacuys);
            model.position.set(0, 0, 0);
            model.name = "CUY";

            scene.add(model);
            skeleton = new THREE.SkeletonHelper(model);
            var animations = gltf.animations;
            mixer = new THREE.AnimationMixer(model);
            mixer.clipAction(animations[0]).play();
        }
        if (archivos[index] == "images/cajaPensando.glb") {
            modelCajaP = gltf.scenes[0];
            modelCajaP.traverse(function (objectCajaGira) {
                if (objectCajaGira instanceof THREE.Mesh) {
                    objectCajaGira.castShadow = true
                }
            });
            modelCajaP.scale.set(0.05, 0.05, 0.05);
            modelCajaP.position.set(0, 0, 0);
            scene.add(modelCajaP);
            skeleton = new THREE.SkeletonHelper(modelCajaP);
            var animations = gltf.animations;
            
            mixerCajaP = new THREE.AnimationMixer(modelCajaP);
            mixerCajaP.clipAction(animations[0]).play();
        }
        if (archivos[index] == "images/cuyDudandoGLB.glb") {
            modelCuyDudando = gltf.scenes[0];
            modelCuyDudando.traverse(function (objectCuyDudando) {
                if (objectCuyDudando instanceof THREE.Mesh) {
                    objectCuyDudando.castShadow = true
                }
            });
            modelCuyDudando.name = "CUY_DUDANDO";

            modelCuyDudando.scale.set(escalacuys, escalacuys, escalacuys);
            modelCuyDudando.position.set(0, 0, 0);
            scene.add(modelCuyDudando);
            skeleton = new THREE.SkeletonHelper(modelCuyDudando);
            var animations = gltf.animations;
            mixerCuyDudando = new THREE.AnimationMixer(modelCuyDudando);
            mixerCuyDudando.clipAction(animations[0]).play();
        }
        if (archivos[index] == "images/cuyChoqueGLB.glb") {
            modelCuyChoque = gltf.scenes[0];
            modelCuyChoque.traverse(function (objectCuyChoque) {
                if (objectCuyChoque instanceof THREE.Mesh) {
                    objectCuyChoque.castShadow = true
                }
            });
            modelCuyChoque.name = "CUY_CHOQUE";

            modelCuyChoque.scale.set(escalacuys, escalacuys, escalacuys);
            modelCuyChoque.position.set(0, 0, 0);
            scene.add(modelCuyChoque);
            skeleton = new THREE.SkeletonHelper(modelCuyChoque);
            var animations = gltf.animations;
            mixerCuyChoque = new THREE.AnimationMixer(modelCuyChoque);
            mixerCuyChoque.clipAction(animations[0]).play();
        }
        index++;
        cargar_archivos();

    });
}

function cajagirando_animacion() {
    $("#ImgContainer").hide();
    var_cajagirando = requestAnimationFrame(cajagirando_animacion);
    if (loaded) {        
        mixer.update(clock.getDelta());
        mixerCuyDudando.update(clockCuyDudando.getDelta());
        mixerCajaP.update(clockCajaP.getDelta());
        
        model.visible = true;  
        modelCajaP.visible = true;
        modelCuyDudando.visible = true;        
        modelCuyChoque.visible = false;
    
        if(clockCajaP.getElapsedTime()<5){

        }else{
            modelCajaP.visible = false;
            cancelAnimationFrame(var_cajagirando);
            iniciar_cuy();

        }
        renderer.render(scene, camera);
    }//fin if loaded
}

var t = 0, dt = 0.02,                   // t (dt delta for demo)
    a = { x: 0, y: 0, z: 0 }         // posicion inicio
    //b = { x: 0, y: 0, z: 2.7 };       // posicion fin

function random_posicion(min, max) {
    return ((Math.random() * (max - min)) + min).toFixed(2);
}
function lerp(a, b, t) {
    return a + (b - a) * t;
}
function ease(t) {
    return t < 0.5 ? 2 * t * t : -1 + (4 - 2 * t) * t;
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
    
    // cuyobjeto = new THREE.Box3().setFromObject(model);
    // cajaverde = new THREE.Box3().setFromObject(get_caja("x").position);// [0]=>  MADERA DE CAJA VERDE
    // if (cuyobjeto.intersectsBox(cajaverde)) {
    //     if (typeof var_cuymoviendo != "undefined") {
    //         cancelAnimationFrame(var_cuymoviendo);
    //         delete var_cuymoviendo;
    //     }
    //     if (typeof var_cuychoque != "undefined") {
    //         cancelAnimationFrame(var_cuychoque);
    //         delete var_cuychoque;

    //     }
    //     if (typeof var_cuydudando != "undefined") {
    //         cancelAnimationFrame(var_cuydudando);
    //         delete var_cuydudando;
    //     }
    //     t = 1;
    //     aumento = 0;
    //     //model.position.set(b.x, b.y, b.z); ///ajustar posición si no llegó exacto
    //     modelCuyDudando.position.z = model.position.z;
    //     modelCuyDudando.position.x = model.position.x;
    //     modelCuyDudando.position.y = model.position.y;
    //     modelCuyChoque.position.z = model.position.z;
    //     modelCuyChoque.position.x = model.position.x;
    //     modelCuyChoque.position.y = model.position.y;
    //     a = { x: model.position.x, y: model.position.y, z: model.position.z };  
    //     cuychoque();
    //     console.log("CHOCOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOO"); return;
    // }
    if(t>=1)
    {
        console.warn("LLEGÓ");
        model.position.set(b.x, b.y, b.z); ///ajustar posición si no llegó exacto
        a = { x: model.position.x, y: model.position.y, z: model.position.z };  
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
        modelCuyDudando.position.z = model.position.z;
        modelCuyDudando.position.x = model.position.x;
        modelCuyDudando.position.y = model.position.y;
        modelCuyChoque.position.z = model.position.z;
         modelCuyChoque.position.x = model.position.x;
        modelCuyChoque.position.y = model.position.y;
        if(GANADOR_DE_EVENTO==0){
            cuychoque();
        }
         else{
             cuydudando();
            }
        //console.log("nuevo")
        //cuyrandom();
        if (typeof funcion_callback !== "undefined" && funcion_callback!=null) {
           // console.log("sig random")
            funcion_callback();
            funcion_callback = null; delete funcion_callback;
        }
    }
}
function cuy_rotacion() {//var_cuy_rotando
    modelCuyDudando.visible = false;
    model.visible = true;
    modelCuyChoque.visible = false;
    dtrotacion = 0.04; // changed
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
            delete callback_rotacion();
        }
    }
}

function cuyrandom() { //// genera posición random =>   b  ,  EJECUTA  cuy_rotacion()  y  mover_cuy() 
    if (typeof var_cuymoviendo === "undefined") {
        t = 0;  ///coeficiente
        aumento = 0;
        randomx = Math.random() >= 0.5 ? Math.abs(parseFloat(random_posicion(0, 2.5))) : -Math.abs(parseFloat(random_posicion(0, 2.5))) ;  // rango x=> -2.5  a   2.5  
        randomz = Math.random() >= 0.5 ? Math.abs(parseFloat(random_posicion(0, 2.5))) : -Math.abs(parseFloat(random_posicion(0, 2.5))); // rango z=> -2.5  a   2.5
        b = { x: randomx, y: 0, z: randomz  };
        console.log(a);
        console.log(b);
        console.info("--");
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

function cuydudando() {
    mixerCuyDudando.update(clockCuyDudando.getDelta());
    var_cuydudando = requestAnimationFrame(cuydudando);
    modelCuyDudando.visible = true;
    model.visible = false;
    modelCuyChoque.visible = false;
    renderer.render(scene, camera);
}
function cuychoque() {
    mixerCuyChoque.update(clockCuyChoque.getDelta());
    var_cuychoque = requestAnimationFrame(cuychoque);
    modelCuyChoque.visible = true;
    model.visible = false;
    modelCuyDudando.visible = false;
    renderer.render(scene, camera);
}
//////////////////////////COMENZAR CUY ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//position_caja11 = modelCaja.children[3].position;///  ganador
function iniciar_cuy() {
    cuyobjeto = new THREE.Box3().setFromObject(model);
    cajaverde = new THREE.Box3().setFromObject(CAJAS_ARRAY[0]);//CAJAS_ARRAY[0]; caja verde  =>  cuy choque
    //cuyobjeto.isIntersectionBox(cajaverde);
    //dt = 0.02;///velocidad cuy  >   o  <
    //var posicion_ganador = new THREE.Vector3(); posicion_ganador.setFromMatrixPosition(CAJAS_ARRAY[15].matrixWorld);
    //var posicion_ganador = CAJAS_ARRAY[15].getWorldPosition();
    //console.info("Posiciòn ganador = " + posicion_ganador.x + "  " + posicion_ganador.y + " " + posicion_ganador.z)
   // var posicion_ganador = { x: 1.2657, y:0,z:-2.3992};
    //var posicion_ganador = { x: -1.483573526240305, y: 1.055968622125986e-16, z: -3.261463815870136 };

        posicion_ganador=get_caja(GANADOR_DE_EVENTO);    ///GANADOR_DE_EVENTO   en animacion.js ; consultarevento(1)
        posicion_ganador=posicion_ganador.posicion;
    //16 => x => 1.2657 y = 0  z = -2.3992
    position_caja11 = posicion_ganador;///  ganador
    i = 0;
    cantidadveces_random = 5;
    porcentaje=80;
        porcentaje_r=80;
        //  porcentaje=((100*(timer-eventoactual.segBloqueoAntesEvento))/duration);
         //console.warn("porcn=" + porcentaje);
           // 
    intervalo_movimientocuy = setInterval(function () {
        if (i === cantidadveces_random) {
            clearInterval(intervalo_movimientocuy);
            funcion_callback = function () { 
                console.warn("CUY GANADOR ---------");//**/}
                CerrarEvento(1,token);
                intervalo_choque=10;
                if(GANADOR_DE_EVENTO=="0"){
                    intervalo_choque=5000;
                }
                setTimeout(function(){
                                $("#progreso").hide();
                        $("#ImgContainer").css("background-image",'url("images/fondo_ganador_nro.jpeg")')
                        $("#ImgContainer").append(
                            $("<div style='font-family: RosewoodStd-Regular;height:50% ; width: 50%; font-size: 60vh;position:relative;left:35%;top:25%;color:black'>").text(GANADOR_DE_EVENTO)
                            );
                        $("#ImgContainer").show();


                        setTimeout(function(){
                                $("#ImgContainer").empty();
                                $("#ImgContainer").css("background-image",'url("images/fondo_inicio.jpg")')
                        },10000)
                        modelCajaP.visible=true;
                        model.position.set(0,0,0);
                        modelCuyDudando.position.set(0,0,0);
                        modelCuyChoque.position.set(0,0,0);
                        clock = new THREE.Clock();
                        clockCuyDudando = new THREE.Clock();
                        clockCuyChoque= new THREE.Clock();
                        clockCajaP= new THREE.Clock();
                        token="";
                        GANADOR_DE_EVENTO="";
                        $("#idevento_titulo").text("");
                        intervalo_revisar_evento=setInterval(function(){
                            if(!buscando_evento){
                                consultarEvento(1);
                            }
                        },intervalo_consultaevento) 
                },intervalo_choque);
              $("#barra_loading").css("height","0%")

            }

            moveracaja(position_caja11);  ///////////caja ganadora
        }
        else {
            funcion_callback = function () {
                console.warn("CUY RANDOM No=" + i);
            }
            porcentaje=porcentaje-porcentaje_r/cantidadveces_random
              $("#barra_loading").css("height",porcentaje+"%")
            cuyrandom();
            i++;
        }
    }
        , 1500);
}
//////////////////////////FIN   COMENZAR CUY ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

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

function iniciar_juego() {
    $("#ImgContainer").hide();
    if (typeof var_cuydudando !== "undefined") {
        cancelAnimationFrame(var_cuydudando);
    }
    cuydudando();
    teclas();
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
///////////FINNNNNNNNNNNNNNNNNNNNNNNNN            FUNCIONES nuevas