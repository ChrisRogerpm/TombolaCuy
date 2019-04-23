///////////FUNCIONESSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSS
var index = 0;
var archivos = ['images/cuy6.glb', 'images/cajaPensando.glb', 'images/cuyDudandoGLB.glb', 'images/cuyChoqueGLB.glb'];
var objLoader = new THREE.GLTFLoader();
var escalacuys = 0.3;
var escalacajagirando = 0.04;
var intervalo_consultaevento=2000;
buscando_evento=false;


function camara_mirar(objeto){
 camera.position.x = objeto.position.x ;
 camera.position.y = objeto.position.y + 0.7;
 camera.position.z = objeto.position.z +3.6;
 camera.lookAt(objeto.position);
}

function camara_inicio(){
 camera.position.x = 0;
 camera.position.y = 10;
 camera.position.z = 0;
  camera.lookAt(new THREE.Vector3(0, 0, 0));
}

function animar_camara() {
    TWEEN.update();
    var_animarcamara=requestAnimationFrame(animar_camara);
    renderer.render(scene, camera);
    controls.update();
}


function camara_movimiento_inicio(hacia,camera,tiempo, callback){
        var from = {
            x: camera.position.x,
            y: camera.position.y,
            z: camera.position.z
        };

        var to = {
            x: hacia.x,
            y: hacia.y,
            z: hacia.z
        };
        var tween = new TWEEN.Tween(from)
            .to(to, tiempo)
            .easing(TWEEN.Easing.Linear.None)
            .onUpdate(function () {
            camera.position.set(this.x, this.y, this.z);
            camera.lookAt(new THREE.Vector3(0, 0, 0));
        })
            .onStart(function(){
              //  camera.position.x=to.x;camera.position.z=to.z;camera.position.y=to.y
            })
            .onComplete(function () {
            camera.lookAt(new THREE.Vector3(0, 0, 0));
        })
            .start();
}



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

scene.children[1].visible=false;
scene.children[1].visible=true;

        // $("#imagen_cargando").hide();
        console.warn("FIN CARGA ARCHIVOS");

        CargarEstadistica(1);
        IPSERVIDOR_WEBSOCKETS="35.239.64.189";
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

            model.castShadow=true;
            model.receiveShadow=true;
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
            modelCajaP.scale.set(escalacajagirando,escalacajagirando,escalacajagirando);
            modelCajaP.position.set(0, 0, 0);
            modelCajaP.castShadow=true;
            modelCajaP.receiveShadow=true;

            scene.add(modelCajaP);
            skeleton = new THREE.SkeletonHelper(modelCajaP);
            var animations = gltf.animations;
           
            mixerCajaP = new THREE.AnimationMixer(modelCajaP);
            mixerCajaP.clipAction(animations[0]).play();
        }
        if (archivos[index] == "images/cuyDudandoGLB.glb") {
            modelCuyDudando = gltf.scenes[0];
            modelCuyDudando.castShadow=true;
            modelCuyDudando.receiveShadow=true;
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
            modelCuyChoque.castShadow=true;
            modelCuyChoque.receiveShadow=true;
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
function detener_var_cuymoviendo(){
    if(typeof var_cuymoviendo!="undefined"){
        //CUY_CORRIENDO=false;
         cancelAnimationFrame(var_cuymoviendo);
         delete var_cuymoviendo;
            aumento = 0;
    }
}
function detener_var_animarcamara(){
    if(typeof var_animarcamara!="undefined"){
         cancelAnimationFrame(var_animarcamara);
         delete var_animarcamara;
    }
}

function detener_var_cajagirando(){
    if(typeof var_cajagirando!="undefined"){
         cancelAnimationFrame(var_cajagirando);
         delete var_cajagirando;
    }
}

function detener_var_cuydudando(){
    if(typeof var_cuydudando!="undefined"){
         cancelAnimationFrame(var_cuydudando);
         delete var_cuydudando;
    }
}
function detener_var_cuychoque(){
    if(typeof var_cuychoque!="undefined"){
         cancelAnimationFrame(var_cuychoque);
         delete var_cuychoque;
    }
}

function detener_var_cuy_rotando(){
      if(typeof var_cuy_rotando!="undefined"){
         cancelAnimationFrame(var_cuy_rotando);
         delete var_cuy_rotando;
    }
}
function detener_animacion(){
         if (typeof animacion !== "undefined") {
            cancelAnimationFrame(animacion);
            delete animacion;
            aumento = 0;
        }
}
function mostrar_cuymoviendo(){
        model.visible = true; 
        modelCajaP.visible = false;
        modelCuyDudando.visible = false;       
        modelCuyChoque.visible = false;

}
function mostrar_cajagirando(){
        modelCajaP.visible = true;
        model.visible = false; 
        modelCuyDudando.visible = false;       
        modelCuyChoque.visible = false;
}
function actualizar_cuyes_posicion(){
     modelCuyDudando.position.x=model.position.x;
        modelCuyDudando.position.y=model.position.y;
        modelCuyDudando.position.z=model.position.z;
        modelCuyChoque.position.x=model.position.x;
        modelCuyChoque.position.y=model.position.y;
        modelCuyChoque.position.z=model.position.z;


}
function reiniciar_cuy(){
    model.position.set(0,0,0);
    a={x:model.position.x,
       y:model.position.y,
       z:model.position.z}

        modelCuyDudando.position.set(0,0,0);
        modelCuyChoque.position.set(0,0,0);
        clock = new THREE.Clock();
        clockCuyDudando = new THREE.Clock();
        clockCuyChoque= new THREE.Clock();
        clockCajaP= new THREE.Clock();
        token="";
        t=0;
        $("#barra_loading").css("height","100%");
        $("#barra_loading_tpi").css("width","0%");

}


function INICIO_ANIMACION_CUY(){
        iniciogiro =  clockCajaP.getElapsedTime();

        dt =0.05 // velocidad movimiento cuy
        dtrotacion = 0.05; // velocidad rotacion cuy;
        t = 0   /// tiempo movimiento cuy;
        timerotacion=0; 
        detener_var_animarcamara();
        animar_camara();

        camara_mirar(modelCajaP);
        if(typeof ULTIMO_PUNTO_CUY!="undefined"){
            ULTIMO_PUNTO_CUY=a;
        }
        reiniciar_cuy();

        actualizar_cuyes_posicion();
        controls.autoRotate = true;

        detener_var_cajagirando();
        cajagirando_animacion();
}
function cajagirando_animacion() {
        $("#ImgContainer").hide();
        var_cajagirando = requestAnimationFrame(cajagirando_animacion);
        mixer.update(clock.getDelta());
        mixerCuyDudando.update(clockCuyDudando.getDelta());
        mixerCajaP.update(clockCajaP.getDelta());
       
        mostrar_cajagirando();
        var tiempogirando = clockCajaP.getElapsedTime() - iniciogiro;
        renderer.render(scene, camera);
        if(tiempogirando<=(TIEMPO_GIRO_CAJA/1000)){
        }
        else{
            $("#texto_ganador").text(GANADOR_DE_EVENTO == 0 ? "x" : GANADOR_DE_EVENTO);
            detener_var_cajagirando();
            mostrar_cuymoviendo();

            controls.autoRotate = false;
            camara_movimiento_inicio({x:0,y:10,z:0},camera,2500);
            iniciar_cuy(GANADOR_DE_EVENTO,TIEMPO_CUY);
        }
}

// var t = 0;
// var dt = 0.01;//0.02                   // t (dt delta for demo)
//     a = { x: 0, y: 0, z: 0 }         // posicion inicio
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
    // timerotacion += dtrotacion;
    timerotacion=parseFloat(timerotacion+dtrotacion).toFixed(5);
    timerotacion=parseFloat(timerotacion);
    var_cuy_rotando = requestAnimationFrame(cuy_rotacionrandom);
    mixer.update(clock.getDelta());
  //  console.log("aca "+timerotacion)
    THREE.Quaternion.slerp(q1, q2, model.quaternion, timerotacion); // added
    renderer.render(scene, camera);
    if (timerotacion > 1) {
        model.lookAt(new THREE.Vector3(b.x,b.y,b.z))
        model.lookAt(new THREE.Vector3(b.x,b.y,b.z))

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
    if (!CUY_CORRIENDO) {  return;}
    mostrar_cuymoviendo();

    funcion_ease=EasingFunctions_array[0].funcion;//linear
    var newX = lerp(a.x, b.x, funcion_ease(t));  
    var newY = lerp(a.y, b.y, funcion_ease(t));  
    var newZ = lerp(a.z, b.z, funcion_ease(t));  
    model.position.set(newX,0,newZ); 
    //t += dt;
    t=parseFloat(t+dt).toFixed(5);
    t=parseFloat(t);
    //console.warn("x=> " + newX + "  y=>" + newY + "  z= " + newZ);
    mixer.update(clock.getDelta());
    renderer.render(scene, camera);
    var_cuymoviendo = requestAnimationFrame(mover_cuyrandom);
    if(t>=1)
    {
        // console.warn("LLEGÓ ccc");
        model.position.set(b.x, b.y, b.z); ///ajustar posición si no llegó exacto
        a = { x: model.position.x, y: model.position.y, z: model.position.z };   //////nueva posicion
        cancelAnimationFrame(var_cuymoviendo);
        detener_animacion();///ant
        detener_var_cuymoviendo();
        detener_var_cuy_rotando();

        actualizar_cuyes_posicion();

        fin_tiempo=performance.now();
        milisegundos=(fin_tiempo-inicio_tiempo);
        console.warn("tiempo => "+t+"   segundos :"+parseFloat(milisegundos/1000).toFixed(2) +"   -    milliseconds :"+ milisegundos  );
        // cuydudando();
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
                               // CerrarEvento(1,token);
                                $("#barra_loading").css("height","0%");
                                $("#barra_loading_tpi").css("width","0%");

                                tiempo_cuychoque=1;
                                if(GANADOR_DE_EVENTO=="0"){
                                    tiempo_cuychoque=5000;
                                }

                                setTimeout(function(){
                                        $("#progreso").hide();
                                        $("#img_ganador").show();

                                        setTimeout(function () {
                                            $("#img_ganador").hide();
                                            $("#ImgContainer").show();
                                            
                                            $("#termotetro_para_iniciar").show();
                                            t=0;
                                            CargarEstadistica(1);
                                        },10000)

                                        setTimeout(function(){
                                                $("#idevento_titulo").text("");
                                               GANADOR_DE_EVENTO="";

                                                modelCajaP.visible=true;
                                                reiniciar_cuy();

                                        },1000);
                                      
                                      
                                }, tiempo_cuychoque);
                 }
                fin_tiempof = performance.now();
                milisegundosf = (fin_tiempof - inicio_tiempo);
                console.info("TIEMPO FINAL=> segundos: " +parseFloat(milisegundosf/1000).toFixed(2)+" ,  milliseconds : "+ milisegundosf );
                funcion_callback();
                delete funcion_callback;
             }
            console.info("fin");
        }///ms > tiempo
        else{
            mostrar_cuydudando=Math.random()>=0.5?true:false;
            if(mostrar_cuydudando){
                detener_var_cuydudando();
                
                cuydudando();
                tiempodudando=Math.random() * (10 - 1) + 1; 
                setTimeout(function(){
                   generar_nueva_posicion_random();//b
                   random_tiempo();
                },tiempodudando*100);
            }
            else{
                detener_var_cuydudando();

                generar_nueva_posicion_random();//b
                random_tiempo();
            }
        }
    }  ///fin t>1
}


//////////////////////////COMENZAR CUY ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//position_caja11 = modelCaja.children[3].position;///  ganador
function iniciar_cuy(ganador,TIEMPO_RANDOM) {
    posicion_ganador = get_caja(ganador).posicion;///  ganador
    i = 0;
    TIEMPO_RANDOM = TIEMPO_RANDOM;
    TIEMPO_RANDOM = TIEMPO_RANDOM - 2000; ///2000 tiempo para ultimo movimiento , hacia ganador

    CUY_ROTANDO=false;
    CUY_CORRIENDO = false;
    iniciar_tiempo_random(TIEMPO_RANDOM); //////INICIO  CUY
}
//////////////////////////FIN   COMENZAR CUY ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

function iniciar_tiempo_random(tiempo) {
    TIEMPO_RANDOM=tiempo;
    inicio_tiempo = performance.now();
    mover_a_ganador=false;

    detener_var_cuydudando();
    cuydudando();
    setTimeout(function(){
        detener_var_cuydudando();
        generar_nueva_posicion_random();//b
            random_tiempo();
    },3500);

}
function random_tiempo(){
    if (typeof var_cuymoviendo === "undefined") {
        rotarono=Math.random() >= 0.5 ?true:false;
        //rotarono=false;

        t = 0;  ///coeficiente
        aumento = 0;
     
        mostrar_cuymoviendo();
        mixer.update(clock.getDelta());
        renderer.render(scene, camera);
        if(rotarono){
            q1 = new THREE.Quaternion().copy(model.quaternion);
            model.lookAt(b.x,b.y,b.z);
            q2 = new THREE.Quaternion().copy(model.quaternion); timerotacion = 0;
        }

        detener_animacion();///ant
        detener_var_cuymoviendo();
        detener_var_cuychoque();
        detener_var_cuydudando();
        detener_var_cuy_rotando();

        if(rotarono){
            callback_rotacion = function () { ///se ejecuta al acabar  cuy_rotacion();
                detener_var_cuymoviendo();
                CUY_CORRIENDO=true;
                mover_cuyrandom();
            }
            CUY_ROTANDO=true;
            detener_var_cuy_rotando();
            cuy_rotacionrandom();
        }else{
            CUY_ROTANDO=false;
            model.lookAt(b.x, b.y, b.z);
            modelCuyDudando.lookAt(b.x, b.y, b.z);
            modelCuyDudando.lookAt(b.x, b.y, b.z);
            t=0;
            aver=CUY_CORRIENDO?"true":"false";
             console.warn("t else:::::  "+t +" "+b.x+" "+b.y+" "+b.z +"  cuycorriendo  = "+ aver);
            console.warn(b);
            detener_var_cuymoviendo();
            detener_var_cuydudando();
            detener_var_cuychoque();
            CUY_CORRIENDO=true;
            mover_cuyrandom();
        }

        // callback_rotacion = function () { ///se ejecuta al acabar  cuy_rotacion();
        //     mover_cuyrandom();
        // }
        // CUY_ROTANDO=true;
        // //console.info("rotando true");
        // cuy_rotacionrandom();
    } else {
        cancelAnimationFrame(var_cuymoviendo);
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

///////////FINNNNNNNNNNNNNNNNNNNNNNNNN            FUNCIONES nuevas
