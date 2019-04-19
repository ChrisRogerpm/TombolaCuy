///////////FUNCIONESSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSS
var index = 0;
var archivos = ['images/cuy6.glb', 'images/cajaPensando.glb', 'images/cuyDudandoGLB.glb', 'images/cuyChoqueGLB.glb'];
var objLoader = new THREE.GLTFLoader();
var escalacuys = 0.3;
var intervalo_consultaevento=2000;
buscando_evento=false;

function get_caja(numero){
    cajaobjeto={};
    $(ARRAY_PUNTOSCAJAS).each(function(i,e){
        if(e.nombre==numero){
            cajaobjeto=e;
            return false;
        }
    })
    return cajaobjeto;
}
function responsive_canvas() {
   camera.aspect = window.innerWidth / window.innerHeight;
   camera.updateProjectionMatrix();
   renderer.setSize( window.innerWidth, window.innerHeight );
}
function cargarImagenes(srcs, callback) {
    var contador = 0;
    function check() {
        contador++;
        if (srcs.length === contador) callback();
    }
    for (var i = srcs.length; i--;) {
        img = new Image();
        img.onload = check;
        img.src = urls[i]
    }
}

function cargar_archivos() {
    if (index > archivos.length - 1) {
        modelCaja.children[0].position.y = 30;
        modelCaja.children[0].children[1].scale.set(3, 3, 3);
        $.LoadingOverlay("hide");

        console.warn("FIN CARGA ARCHIVOS");

        CargarEstadistica(1);
        IPSERVIDOR_WEBSOCKETS="35.237.182.107";
        PUERTO_WEBSOCKETS="888";
        window.addEventListener('resize', responsive_canvas, false);
  
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

function INICIO_ANIMACION_CUY(){
    iniciogiro =  clockCajaP.getElapsedTime();
    cajagirando_animacion();
}
function cajagirando_animacion() {
    $("#ImgContainer").hide();
    var_cajagirando = requestAnimationFrame(cajagirando_animacion);
        mixer.update(clock.getDelta());
        mixerCuyDudando.update(clockCuyDudando.getDelta());
        mixerCajaP.update(clockCajaP.getDelta());
       
        model.visible = true; 
        modelCajaP.visible = true;
        modelCuyDudando.visible = true;       
        modelCuyChoque.visible = false;
        $("#barra_loading").css("height","0%");
        $("#barra_loading_tpi").css("width","0%");
        var tiempogirando = clockCajaP.getElapsedTime() - iniciogiro;
        // if (clockCajaP.getElapsedTime() <= (TIEMPO_GIRO_CAJA/1000)){
        if(tiempogirando<=(TIEMPO_GIRO_CAJA/1000)){
        }else{
            $("#texto_ganador").text(GANADOR_DE_EVENTO == 0 ? "x" : GANADOR_DE_EVENTO)
            modelCajaP.visible = false;
            cancelAnimationFrame(var_cajagirando);
            iniciar_cuy(GANADOR_DE_EVENTO,TIEMPO_CUY);
        }
        renderer.render(scene, camera);
}

var t = 0;
var dt = 0.01;//0.02                   // t (dt delta for demo)
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
            delete callback_rotacion;
        }
    }
}
////////////////////nuevo random
function generar_nueva_posicion_random(){
        randomx = Math.random() >= 0.5 ? Math.abs(parseFloat(random_posicion(0, 2.3))) : -Math.abs(parseFloat(random_posicion(0, 2.3))) ;  // rango x=> -2.5  a   2.5 
        randomz = Math.random() >= 0.5 ? Math.abs(parseFloat(random_posicion(0, 2.3))) : -Math.abs(parseFloat(random_posicion(0, 2.3))); // rango z=> -2.5  a   2.5
        b = { x: randomx, y: 0, z: randomz  };
}
function cuy_rotacionrandom() {//var_cuy_rotando
    if(!CUY_ROTANDO){return;}
    model.visible = true;
    modelCuyDudando.visible = false;
    modelCuyChoque.visible = false;
    // dtrotacion = 0.05; // changed
    timerotacion += dtrotacion;
    var_cuy_rotando = requestAnimationFrame(cuy_rotacionrandom);
    mixer.update(clock.getDelta());
    THREE.Quaternion.slerp(q1, q2, model.quaternion, timerotacion); // added
    renderer.render(scene, camera);
    if (timerotacion > 1) {
        CUY_ROTANDO=false;
        console.log("rotacion "+timerotacion);  
        timerotacion = 0; cancelAnimationFrame(var_cuy_rotando) // changed
         if (typeof var_cuy_rotando != "undefined") {
            cancelAnimationFrame(var_cuy_rotando);
            delete var_cuy_rotando;
        }
        //console.info("acabo rotacion rand");
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
        //cuydudando();
        if (typeof callback_rotacion != "undefined") {
            callback_rotacion();
            delete callback_rotacion;
        }
    }
}
function mover_cuyrandom() {    ///var_cuymoviendo  => animationframe
    if (!CUY_CORRIENDO) { return;}
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
    renderer.render(scene, camera);
    var_cuymoviendo = requestAnimationFrame(mover_cuyrandom);
    if(t>=1)
    {
        // console.warn("LLEGÓ ccc");
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
         if (typeof var_cuy_rotando != "undefined") {
            cancelAnimationFrame(var_cuy_rotando);
            delete var_cuy_rotando;
        }
        modelCuyDudando.position.z = model.position.z;
        modelCuyDudando.position.x = model.position.x;
        modelCuyDudando.position.y = model.position.y;
        modelCuyChoque.position.z = model.position.z;
        modelCuyChoque.position.x = model.position.x;
        modelCuyChoque.position.y = model.position.y;
        fin_tiempo=performance.now();
        milisegundos=(fin_tiempo-inicio_tiempo);
        console.warn("tiempo  " + milisegundos + " milliseconds.");
        cuydudando();
        if (milisegundos > TIEMPO_RANDOM) {
            if(!mover_a_ganador){
                    mover_a_ganador=true;
                    b=get_caja(GANADOR_DE_EVENTO).posicion;
                    random_tiempo();
            }  
            else {
                CUY_CORRIENDO = false;
                if(get_caja(0).posicion.x==model.position.x && get_caja(0).posicion.y==model.position.y){
                    cuychoque();
                }
                if (typeof funcion_callback != "undefined") {
                    delete funcion_callback;
                }
                 funcion_callback = function () {
                                console.warn("CALLBACK CUY GANADOR ---------");//**/}
                                CerrarEvento(1,token);
                                $("#barra_loading").css("height","0%");
                                $("#barra_loading_tpi").css("width","0%");

                                tiempo_cuychoque=1;
                                if(GANADOR_DE_EVENTO=="0"){
                                    tiempo_cuychoque=5000;
                                }
                                $("#barra_loading").css("height","98%");

                                setTimeout(function(){
                                        $("#progreso").hide();
                                        $("#img_ganador").show();

                                        setTimeout(function () {
                                            $("#img_ganador").hide();
                                            $("#ImgContainer").show();
                                            $("#barra_loading").css("height","0%");
                                            
                                            $("#termotetro_para_iniciar").show();
                                            CargarEstadistica(1);
                                         
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
                                        $("#barra_loading").css("height","100%");
                                        $("#idevento_titulo").text("");
                                      
                                    }, tiempo_cuychoque);
                 }
                fin_tiempof = performance.now();
                milisegundosf = (fin_tiempof - inicio_tiempo);
                console.info("tiempo  " + milisegundosf + " milliseconds.");
                funcion_callback();
                delete funcion_callback;
             }
            console.info("fin");
        }///ms > tiempo
        else{
            // tiempoazar_entrepuntos=Math.random() >= 0.5 ?
            tiempodudando=Math.random() * (10 - 1) + 1; 
           setTimeout(function(){
               generar_nueva_posicion_random();//b
               random_tiempo();
           },tiempodudando*100);

        }
    }  ///fin t>1
}

CUY_ROTANDO=false;
CUY_CORRIENDO = false;
function iniciar_tiempo_random(tiempo) {
    CUY_CORRIENDO = true;
    TIEMPO_RANDOM=tiempo;
    inicio_tiempo = performance.now();
    mover_a_ganador=false;
    cuydudando();
    generar_nueva_posicion_random()//b
    dt =0.01 // velocidad movimiento
    dtrotacion = 0.05; // velocidad rotacion;
    random_tiempo();
}
function random_tiempo(){
    if (typeof var_cuymoviendo === "undefined") {
        t = 0;  ///coeficiente
        aumento = 0;
        modelCuyDudando.visible = false;
        modelCuyChoque.visible = false;
        model.visible = true;
        mixer.update(clock.getDelta());
        renderer.render(scene, camera);
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
        if (typeof var_cuy_rotando != "undefined") {
            cancelAnimationFrame(var_cuy_rotando);
            delete var_cuy_rotando;
        }
        callback_rotacion = function () { ///se ejecuta al acabar  cuy_rotacion();
            mover_cuyrandom();
        }
        CUY_ROTANDO=true;
        //console.info("rotando true");
        cuy_rotacionrandom();
    } else {
        cancelAnimationFrame(var_cuymoviendo);
    } 
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
function iniciar_cuy(ganador,TIEMPO_RANDOM) {
    posicion_ganador = get_caja(ganador).posicion;///  ganador
    i = 0;
    cantidadveces_random = 5;
    porcentaje=100;
    porcentaje_r=80;
    //  porcentaje=((100*(timer-eventoactual.segBloqueoAntesEvento))/duration);
    //console.warn("porcn=" + porcentaje);
    TIEMPO_RANDOM = TIEMPO_RANDOM;

    TIEMPO_RANDOM = TIEMPO_RANDOM - 1500;

    iniciar_tiempo_random(TIEMPO_RANDOM); //////INICIO  CUY
    cantidad_inter=TIEMPO_RANDOM/100;
    porcentaje=90/cantidad_inter;
    porc=0;
    ii=0;
        inicio=performance.now();
        intervalo_termometro=setInterval(function(){
            if(ii>cantidad_inter){
                porc=90;
                clearInterval(intervalo_termometro);
                return;
            }
            porc=porc+porcentaje;
            $("#barra_loading").css("height",(porc)+"%")
            if(porc>50){
                $(".amount,.filler,.red-circle").css("background","#ff0000");
            }
            ii++;

       },100)
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
   // teclas();
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
