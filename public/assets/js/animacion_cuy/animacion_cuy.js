///////////FUNCIONESSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSS
var index = 0;
var archivos = ['images/cuy6.glb', 'images/cajaPensando.glb', 'images/cuyDudandoGLB.glb', 
// 'images/cuyChoqueGLB.glb'
'images/glb/cuyChoque2.glb'
// ,'images/glb/cuyesperando.glb'
// ,'images/glb/cuypremio.glb'
// ,'images/glb/cuysalto.glb'
// ,'images/glb/tablero.glb'
];
dt =0.03 // velocidad movimiento cuy
dtrotacion = 0.05; // velocidad rotacion cuy;
escalacuys = 0.25;
escalacajagirando = 0.04;
intervalo_consultaevento=2000;
buscando_evento=false;

ANIMACION_CUY=false;

function hexToRgb(hex) {
    var shorthandRegex = /^#?([a-f\d])([a-f\d])([a-f\d])$/i;
    hex = hex.replace(shorthandRegex, function(m, r, g, b) {
        return r + r + g + g + b + b;
    });

    var result = /^#?([a-f\d]{2})([a-f\d]{2})([a-f\d]{2})$/i.exec(hex);
    return result ? {
        r: parseInt(result[1], 16),
        g: parseInt(result[2], 16),
        b: parseInt(result[3], 16)
    } : null;
}

function camara_mirar(objeto){
        camera.position.x = objeto.position.x ;
        camera.position.y = objeto.position.y + 1.6;
        camera.position.z = objeto.position.z +4.5;
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
    if(typeof controls!="undefined"){
        controls.update();
    }
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
                detener_var_animarcamara();
               camera.lookAt(new THREE.Vector3(0, 0, 0));
        })
            .start();
}


function get_cajaanterior(numero){
    cajaobjeto={};
    $(ARRAY_PUNTOSCAJAS).each(function(i,e){
        if(e.nombre==numero){
            cajaobjeto=e;
            return false;
        }
    })
    return cajaobjeto;
}
function get_caja(numero){
    cajaobjeto={};
    if(numero==0 || numero=="x"){
        numero="x";
    }
    $(CAJAS_ARRAY).each(function(i,e){
        if(e.name==numero){
            cajaobjeto=e;
            return false;
        }
    })
    var worldposition=new THREE.Vector3();
    cajaobjeto.getWorldPosition(worldposition);
    posicion={nombre:numero,posicion:{x:worldposition.x,y:worldposition.y,z:worldposition.z}}
    return posicion;
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
    var objLoader = new THREE.GLTFLoader();
    if (index > archivos.length - 1) {
         otro=model.clone();////////////////////////

        TIEMPO_FIN_RENDER=performance.now()-TIEMPO_RENDER;
        TIEMPO_FIN_RENDER=(TIEMPO_FIN_RENDER/1000).toFixed(2);
        console.warn("FIN CARGA ARCHIVOS en "+TIEMPO_FIN_RENDER + " seg");
        //CargarEstadistica(1);
    
        ///NUEVOOOOOOOOOO
        iniciar_websocketservidor();

        window.addEventListener('resize', responsive_canvas, false);
        return;
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
            modelCajaP.name="CAJA_GIRANDO";
            modelCajaP.scale.set(escalacajagirando,escalacajagirando,escalacajagirando);
            modelCajaP.position.set(0, 0, 0);
            modelCajaP.castShadow=true;
            modelCajaP.receiveShadow=true;

            scene.add(modelCajaP);
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
            var animations = gltf.animations;
            mixerCuyDudando = new THREE.AnimationMixer(modelCuyDudando);
            mixerCuyDudando.clipAction(animations[0]).play();
        }
        if (archivos[index] ==
         "images/glb/cuyChoque2.glb"
         // "images/cuyChoqueGLB.glb"
         ) {
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
            // modelCuyChoque.children[0].children[0].scale.set(1,1,1);
            scene.add(modelCuyChoque);
            var animations = gltf.animations;
            mixerCuyChoque = new THREE.AnimationMixer(modelCuyChoque);
            mixerCuyChoque.clipAction(animations[0]).play();
        }

          if (archivos[index] =="images/glb/cuypremio.glb") {
            modelCuyPremio = gltf.scenes[0];
            modelCuyPremio.traverse(function (objeto) {
                if (objeto instanceof THREE.Mesh) {
                    objeto.castShadow = true
                }
            });
            modelCuyPremio.castShadow=true;
            modelCuyPremio.receiveShadow=true;
            modelCuyPremio.name = "CUY_PREMIO";
            modelCuyPremio.scale.set(escalacuys, escalacuys, escalacuys);
            modelCuyPremio.position.set(0, 0, 0);
            scene.add(modelCuyPremio);
            var animations = gltf.animations;
            mixerCuyPremio = new THREE.AnimationMixer(modelCuyPremio);
            mixerCuyPremio.clipAction(animations[0]).play();
        }

        if (archivos[index] =="images/glb/cuyesperando.glb") {
            modelCuyEsperando = gltf.scenes[0];
            modelCuyEsperando.traverse(function (objeto) {
                if (objeto instanceof THREE.Mesh) {
                    objeto.castShadow = true
                }
            });
            modelCuyEsperando.castShadow=true;
            modelCuyEsperando.receiveShadow=true;
            modelCuyEsperando.name = "CUY_PREMIO";
            modelCuyEsperando.scale.set(escalacuys, escalacuys, escalacuys);
            modelCuyEsperando.position.set(0, 0, 0);
            scene.add(modelCuyEsperando);
            var animations = gltf.animations;
            mixerCuyEsperando = new THREE.AnimationMixer(modelCuyEsperando);
            mixerCuyEsperando.clipAction(animations[0]).play();
        }
         if (archivos[index] =="images/glb/cuysalto.glb") {
            modelCuySalto = gltf.scenes[0];
            modelCuySalto.traverse(function (objeto) {
                if (objeto instanceof THREE.Mesh) {
                    objeto.castShadow = true
                }
            });
            modelCuySalto.castShadow=true;
            modelCuySalto.receiveShadow=true;
            modelCuySalto.name = "CUY_PREMIO";
            modelCuySalto.scale.set(escalacuys, escalacuys, escalacuys);
            modelCuySalto.position.set(0, 0, 0);
            scene.add(modelCuySalto);
            var animations = gltf.animations;
            mixerCuySalto = new THREE.AnimationMixer(modelCuySalto);
            mixerCuySalto.clipAction(animations[0]).play();
        }
        // if (archivos[index] =="images/glb/tablero.glb") {
        //     modelCuyTablero = gltf.scenes[0];
        //     modelCuyTablero.traverse(function (objeto) {
        //         if (objeto instanceof THREE.Mesh) {
        //             objeto.castShadow = true
        //         }
        //     });
        //     modelCuyTablero.castShadow=true;
        //     modelCuyTablero.receiveShadow=true;
        //     modelCuyTablero.name = "CUY_PREMIO";
        //     modelCuyTablero.scale.set(escalacuys, escalacuys, escalacuys);
        //     modelCuyTablero.position.set(0, 0, 0);
        //     scene.add(modelCuyTablero);
        //     var animations = gltf.animations;
        //     mixerCuySalto = new THREE.AnimationMixer(modelCuyTablero);
        //     mixerCuySalto.clipAction(animations[0]).play();
        // }
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
    TWEEN.removeAll();
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
function detener_var_animar_cajax(){
         if (typeof var_animar_cajax !== "undefined") {
            cancelAnimationFrame(var_animar_cajax);
            delete var_animar_cajax;
        }
}

function detener_var_cuysalto(){
        if (typeof var_cuysalto !== "undefined") {
            cancelAnimationFrame(var_cuysalto);
            delete var_cuysalto;
        }

}
function detener_var_cuypremio(){
        if (typeof var_cuypremio !== "undefined") {
            cancelAnimationFrame(var_cuypremio);
            delete var_cuypremio;
        }

}
function detener_var_cuyesperando(){
        if (typeof var_cuyesperando !== "undefined") {
            cancelAnimationFrame(var_cuyesperando);
            delete var_cuyesperando;
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
        t=0;
        $("#barra_loading").css("height","100%");
        $("#barra_loading_tpi").css("width","0%");
        //PUNTOS_CUY=null;
        //INDICE_PUNTOS_CUY=0;
}


function INICIO_ANIMACION_CUY(){

        ANIMACION_CUY=true;
        iniciogiro =  clockCajaP.getElapsedTime();
        t = 0   /// tiempo movimiento cuy;
        timerotacion=0; 
        detener_var_animarcamara();
        $("#ImgContainer").hide();
        animar_camara();

        camara_mirar(modelCajaP);
        if(typeof a!="undefined"){
            ULTIMO_PUNTO_CUY=a;
        }
        reiniciar_cuy();///reiniciar posicion cuyes 0 0 0
        actualizar_cuyes_posicion();
        if(typeof controls!="undefined"){
             //controls.autoRotate = true;
        }
        detener_var_cajagirando();
        cajagirando_animacion();
}
function getPositionOtro(ganador,otro){
            vector_ganador=new THREE.Vector3();
            getObjeto_caja(ganador).getWorldPosition(vector_ganador);
            otro.position.copy(vector_ganador);
            otro.lookAt(0,0,0);
            otro.translateZ(1);
            posicionnueva=otro.getWorldPosition();
            return {x:posicionnueva.x,y:0,z:posicionnueva.z}
}
function getPositionOtroVector(ganador,otro){
    if(ganador=="0"){ganador="x";}
            vector_ganador=new THREE.Vector3();
            getObjeto_caja(ganador).getWorldPosition(vector_ganador);
            otro.position.copy(vector_ganador);
            otro.lookAt(0,0,0);
            otro.translateZ(1);
            posicionnueva=new THREE.Vector3();
            otro.getWorldPosition(posicionnueva);
            vector =new THREE.Vector3(posicionnueva.x,0,posicionnueva.z);
            return vector;
}

function cajagirando_animacion() {
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
       puntootro=getPositionOtroVector(GANADOR_DE_EVENTO,otro);///punto antes de caja centro

            $("#texto_ganador").text(GANADOR_DE_EVENTO == 0 ? "x" : GANADOR_DE_EVENTO);

            datos=getColor(estadistica,GANADOR_DE_EVENTO);
            $("#texto_ganador").css("background-color",datos.rgb);
            $("#texto_ganador").css("color",datos.rgbLetra);
            $("#span_idevento").text("#"+EVENTO_ACTUAL.evento_id_actual);
   // spline = new THREE.SplineCurve3(puntos_azar());

       // detener_var_animarcamara();
            detener_var_cajagirando();
            mostrar_cuymoviendo();
       
             cajax=getObjeto_caja("x");
             maderas=[];
            maderas.push(getObjeto_caja("madera"));
             maderas.push(getObjeto_caja("madera2"));
            posicionycajaxinicial=-9.8808069229126  ;//9.932283401;//-6.86645478253922e-7;//-993.228455;///  z=>  -993.228455
            posicionfinalcaja=-11.4;//8.2;//3.4999993133545217//800;
            
            //cajax_posicioninicial=cajax.getWorldPosition();
            cajax_posicioninicial= new THREE.Vector3() ; 
            cajax.getWorldPosition(cajax_posicioninicial);

            posicionmadera = new THREE.Vector3() ; 
            getObjeto_caja("madera").getWorldPosition(posicionmadera)

            dtcajax=0.2;
            tcajax=0;
            rotacionx_inicio=0;//-7.318557638911297e-33;
            rotacionx_fin=-Math.PI / 2;//-1.4;
            q1_cajax = new THREE.Quaternion().copy(cajax.quaternion);
            q2_cajax = new THREE.Quaternion().copy(cajax.quaternion);
             timerotacion = 0;

            if(typeof controls!="undefined"){
              controls.autoRotate = false;
            }
            camara_movimiento_inicio({x:0,y:10.3,z:0},camera,2500);
            iniciar_cuy(GANADOR_DE_EVENTO,TIEMPO_CUY);
        }
}

function retornar_cajx(){
    cajax.position.y=-9.8808069229126;//9.932283401;//-993.228455; 
    cajax.rotation.x=0;//-7.318557638911297e-33;
    maderas[0].visible=true;
    maderas[1].visible=true;
}

function cajax_animacion(){
    maderas[0].visible=false;
    maderas[1].visible=false;

    funcion_ease=EasingFunctions_array[2].funcion;//easeOutQuad
    // var newZ = lerp(posicionxcajaxinicial, bcajaxz, funcion_ease(tcajax));  
    var newY = lerp(posicionycajaxinicial, posicionfinalcaja, funcion_ease(tcajax));  
    var newrotacionX = lerp(rotacionx_inicio, rotacionx_fin, funcion_ease(tcajax));  
    // cajax.position.z=newZ;
    cajax.position.y=newY;
    cajax.rotation.x=newrotacionX;
    //t += dt;
    tcajax=parseFloat(tcajax+dtcajax).toFixed(5);
    tcajax=parseFloat(tcajax);
    var_animar_cajax = requestAnimationFrame(cajax_animacion);
    if(tcajax>1){
        detener_var_animar_cajax();tcajax=0;
    }
}

function random_posicion(min, max) {
    return ((Math.random() * (max - min)) + min).toFixed(2);
}
function random_entero(min, max) {
  min = Math.ceil(min);
  max = Math.floor(max);
  return Math.floor(Math.random() * (max - min)) + min; //The maximum is exclusive and the minimum is inclusive
}
function lerp(a, b, t) {
    return a + (b - a) * t;
}
function ease(t) {
    return t < 0.5 ? 2 * t * t : -1 + (4 - 2 * t) * t;
}

////////////////////nuevo random
function generar_nueva_posicion_random(){
        bfuncion_easing_indice=0;//random_entero(0,EasingFunctions_array.length-1);
        //console.warn("i= "+bfuncion_easing_indice);
        b=PUNTOS_CUY[INDICE_PUNTOS_CUY];
        INDICE_PUNTOS_CUY++;
        if(INDICE_PUNTOS_CUY>PUNTOS_CUY.length){
            console.warn(INDICE_PUNTOS_CUY+ " ---------Cuy pasó length del array PUNTOS_CUY  --- ")
            INDICE_PUNTOS_CUY=0; 
            b=PUNTOS_CUY[INDICE_PUNTOS_CUY];
        }
        return b;
}
/////////////////nuevo movimiento
function generar_nueva_posicion_random2(rango){
    // rango=2.,5
       randomx = Math.random() >= 0.5 ? Math.abs(parseFloat(random_posicion(0, rango))) : -Math.abs(parseFloat(random_posicion(0,rango))) ;  // rango x=> -2.5  a   2.5 
       randomz = Math.random() >= 0.5 ? Math.abs(parseFloat(random_posicion(0, rango))) : -Math.abs(parseFloat(random_posicion(0, rango))); // rango z=> -2.5  a   2.5
       b = { x: randomx, y: 0, z: randomz  };
       return b;
}

function puntos_azar(){
    arrayvector=[];
    for(a=0;a<10;a++){
        nuevo=generar_nueva_posicion_random2(2.7);
        arrayvector.push(new THREE.Vector3(nuevo.x,0,nuevo.z))
    }
    return arrayvector;
}
function linea_camino(){
 var material = new THREE.LineBasicMaterial({
        color: 0xff00f0,
    });
    var geometry = new THREE.Geometry();
    for(var i = 0; i < spline.getPoints(100).length; i++){
        geometry.vertices.push(spline.getPoints(100)[i]);  
    }
    var line = new THREE.Line(geometry, material);line.name="linea_camino";
    scene.add(line);
}

up = new THREE.Vector3(0,0,1 );
axis = new THREE.Vector3( );
// t=0;dt=0.003
// correr_nuevo()
function correr_spline(){
    var var_correr=requestAnimationFrame(correr_spline);
    var tangent;
    pt = spline.getPoint( t );
//    console.log(pt)
    model.position.set( pt.x, pt.y, pt.z );
    tangent = spline.getTangent( t ).normalize();
    mixer.update(clock.getDelta())
    axis.crossVectors(up, tangent).normalize();
    radians = Math.acos( up.dot( tangent ) );
    model.quaternion.setFromAxisAngle( axis, radians );
    t=t+dtSPLINE;
    if(t>=1){
        model.position.copy(posicion_fin_caja);
         t=0;cancelAnimationFrame(var_correr) ;
            console.info("FIN SPLINE");
        CUY_CORRIENDO = false;
        if(model.position.x== posicionmadera.x && model.position.z== posicionmadera.z)
        {
            modelCuyChoque.position.copy(posicionmodel);
            modelCuyChoque.lookAt(getObjeto_caja("x").getWorldPosition());
            modelCuyChoque.position.y=-0.1;
            cuychoque();
            cajax_animacion();///caja x voltear
        }
        model.visible=false;
        callback_ganador();
        fin_tiempof = performance.now();
        milisegundosf = (fin_tiempof - inicio_tiempo);
        console.info("TIEMPO FINAL=> segundos: " +parseFloat(milisegundosf/1000).toFixed(2)+" ,  milliseconds : "+ milisegundosf );
      


    }
}
////fin nuevo movimiento

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
        modelCuyDudando.lookAt(new THREE.Vector3(b.x,b.y,b.z))
        modelCuyChoque.lookAt(new THREE.Vector3(b.x,b.y,b.z))

        CUY_ROTANDO=false;
        // console.log("rotacion "+timerotacion);  
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

function callback_ganador(){
        console.warn("CALLBACK CUY GANADOR  --------");//**/}
        $("#barra_loading_tpi").css("width","0%");
        tiempo_cuychoque=1000; ///por defecto 1 seg,al entrar en caja
        if(GANADOR_DE_EVENTO=="0" || GANADOR_DE_EVENTO=="x"){
            tiempo_cuychoque=5000;
        }
        setTimeout(function(){
                $("#img_ganador").show();
                setTimeout(function () {
                    $("#img_ganador").hide();
                    $("#ImgContainer").show();
                    $("#termotetro_para_iniciar").show();
                    t=0;
                    ANIMACION_CUY=false;
                    iniciar_websocketservidor()
                },10000);
                setTimeout(function(){
                        $("#idevento_titulo").text("");
                        GANADOR_DE_EVENTO="";
                         detener_var_animarcamara();
                        modelCajaP.visible=true;
                        PUNTOS_CUY=null;
                        INDICE_PUNTOS_CUY=0;
                        reiniciar_cuy();
                        retornar_cajx();
                        bfuncion_easing_indice=0;
                },1000);
        }, tiempo_cuychoque);
};
function mover_cuyrandom() {    ///var_cuymoviendo  => animationframe
    if (!CUY_CORRIENDO) {  return;}
    mostrar_cuymoviendo();

    // funcion_ease=EasingFunctions_array[0].funcion;//linear
    funcion_ease=EasingFunctions_array[bfuncion_easing_indice].funcion;//usar random de generarrandompunto b

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
        // console.warn("tiempo => "+t+"   segundos :"+parseFloat(milisegundos/1000).toFixed(2) +"   -    milliseconds :"+ milisegundos  );
        // cuydudando();

        // if(milisegundos>TIEMPO_RANDOM){
        //             posicion_fin_caja= new THREE.Vector3();
        //             if(GANADOR_DE_EVENTO=="x" || GANADOR_DE_EVENTO=="0"){
        //                 getObjeto_caja("madera").getWorldPosition(posicion_fin_caja);
        //             }
        //             else{
        //                 getObjeto_caja(GANADOR_DE_EVENTO).getWorldPosition(posicion_fin_caja);
        //             }
        //             posicion_fin_caja.y=0;
        //                     CUY_CORRIENDO = false;
        //                     puntosspline=[];
        //                     posicionmodel=new THREE.Vector3();
        //                     model.getWorldPosition(posicionmodel);
                            
        //                     puntootro.y=0;
        //                     puntosspline.push(posicionmodel);
        //                     puntosspline.push(puntootro);
        //                     puntosspline.push(posicion_fin_caja);
        //                     spline= new THREE.SplineCurve3(puntosspline);
        //                     // linea_camino();
        //                     t=0;
        //                     correr_spline();
        // }
        // else{
        //     mostrar_cuydudando=Math.random()>=0.5?true:false;
        //     if(mostrar_cuydudando){
        //         detener_var_cuydudando();
                
        //         cuydudando();
        //         tiempodudando=Math.random() * (10 - 1) + 1; 
        //         setTimeout(function(){
        //            generar_nueva_posicion_random();//b
        //            random_tiempo();
        //         },tiempodudando*100);
        //     }
        //     else{
        //         detener_var_cuydudando();

        //         generar_nueva_posicion_random();//b
        //         random_tiempo();
        //     }
        // }  ///fin else ms >tiempo

        if (milisegundos > TIEMPO_RANDOM) {////tiempo de animacion cuy paso, ir a caja ganador posicion
            if(!mover_a_ganador){
                    mover_a_ganador=true;
                    // b=get_caja(GANADOR_DE_EVENTO).posicion;
                    if(GANADOR_DE_EVENTO=="x" || GANADOR_DE_EVENTO=="0"){
                          bfuncion_easing_indice=7;//easeInQuart
                          console.log("X o O");
                         // b=ARRAY_PUNTOSCAJAS[ARRAY_PUNTOSCAJAS.length-1].posicion;
                         // b=getObjeto_caja("madera").getWorldPosition();
                         b=new THREE.Vector3();
                         getObjeto_caja("madera").getWorldPosition(b);
                         random_tiempo();
                    }else{

                            posicion_fin_caja= new THREE.Vector3();
                            getObjeto_caja(GANADOR_DE_EVENTO).getWorldPosition(posicion_fin_caja);
                            posicion_fin_caja.y=0;
                            CUY_CORRIENDO = false;
                            puntosspline=[];
                            posicionmodel=new THREE.Vector3();
                            model.getWorldPosition(posicionmodel);

                            puntootro.y=0;
                            puntosspline.push(posicionmodel);
                            puntosspline.push(puntootro);
                            puntosspline.push(posicion_fin_caja);
                            // spline= new THREE.SplineCurve3(puntosspline);
                            spline= new THREE.CatmullRomCurve3(puntosspline);
                            // linea_camino();
                            t=0;
                            dtSPLINE=0.02;
                            dist_spline=spline.getLength();
                            console.info("dist_spline "+dist_spline);
                            if(dist_spline>4){
                                dtSPLINE=0.005;
                            }
        //                     // linea_camino();

                            correr_spline();



                           // b=get_caja(GANADOR_DE_EVENTO).posicion;
                    }
                    //console.log(b);
                   // random_tiempo();
            }  
            else { ///movera ganador true  => CUY EN POSICION DE CAJA, FINALIZAR ANIMACION
                CUY_CORRIENDO = false;
                if(model.position.x== posicionmadera.x && model.position.z== posicionmadera.z)
                {
                    modelCuyChoque.position.y=-0.1;
                    cuychoque();
                    cajax_animacion();///caja x voltear
                }
                model.visible=false;
                callback_ganador();
                fin_tiempof = performance.now();
                milisegundosf = (fin_tiempof - inicio_tiempo);
                console.info("TIEMPO FINAL=> segundos: " +parseFloat(milisegundosf/1000).toFixed(2)+" ,  milliseconds : "+ milisegundosf );
               // delete funcion_callback;
             }
            console.info("fin");
        }///ms > tiempo
        else{
            mostrar_cuydudando=b.mostrar_cuydudando;//Math.random()>=0.5?true:false;
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
        }  ///fin else ms >tiempo
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
    INDICE_PUNTOS_CUY=0;
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
        // console.info(b);
        //esta=typeof var_cuymoviendo === "undefined"?"true":"false";
        //console.warn(esta);
        // rotarono=b.rotarono;
        // mostrar_cuydudando=b.mostrar_cuydudando;
            random_tiempo();
    },3500);

}
function random_tiempo(){
    if (typeof var_cuymoviendo === "undefined") {
        rotarono=b.rotarono;//Math.random() >= 0.5 ?true:false;
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
            modelCuyChoque.lookAt(b.x, b.y, b.z);
            t=0;
            aver=CUY_CORRIENDO?"true":"false";
              // console.warn("t else:::::  "+t +" "+b.x+" "+b.y+" "+b.z +"  cuycorriendo  = "+ aver);
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

function cuyesperando(){
    mixerCuyEsperando.update
    mixerCuyEsperando.update(clockCuyEsperando.getDelta());
    var_cuyesperando = requestAnimationFrame(cuyesperando);
    modelCuyEsperando.visible = true;
   // model.visible = false;
   // modelCuyChoque.visible = false;
    renderer.render(scene, camera);
}
function cuysalto(){
    mixerCuySalto.update
    mixerCuySalto.update(clockCuySalto.getDelta());
    var_cuysalto = requestAnimationFrame(cuysalto);
    modelCuySalto.visible = true;
   // model.visible = false;
   // modelCuyChoque.visible = false;
    renderer.render(scene, camera);
}
function cuypremio(){
    mixerCuyPremio.update
    mixerCuyPremio.update(clockCuyPremio.getDelta());
    var_cuypremio = requestAnimationFrame(cuypremio);
    modelCuyPremio.visible = true;
   // model.visible = false;
   // modelCuyChoque.visible = false;
    renderer.render(scene, camera);
}

///////////FINNNNNNNNNNNNNNNNNNNNNNNNN            FUNCIONES nuevas








function dibujarCurva() {
  var vertices = path.getSpacedPoints(20);

  // Change 2D points to 3D points
  for (var i = 0; i < vertices.length; i++) {
    point = vertices[i]
    vertices[i] = new THREE.Vector3(point.x, point.y, 0);
  }
  var lineGeometry = new THREE.Geometry();
  lineGeometry.vertices = vertices;
  var lineMaterial = new THREE.LineBasicMaterial({
    color: 0xffffff
  });
  var line = new THREE.Line(lineGeometry, lineMaterial)
  scene.add(line);
}










function mover_rapido(ganador){
    mover_a_ganador=ganador;
    rotarono=Math.random() >= 0.5 ?true:false;
        //rotarono=false;

        t = 0;  ///coeficiente
        timerotacion=0;
     
        mostrar_cuymoviendo();
        mixer.update(clock.getDelta());
        renderer.render(scene, camera);
        if(rotarono){
            q1 = new THREE.Quaternion().copy(model.quaternion);
            model.lookAt(b.x,b.y,b.z);
            q2 = new THREE.Quaternion().copy(model.quaternion);
        }
        detener_var_cuymoviendo();
        detener_var_cuychoque();
        detener_var_cuydudando();
        detener_var_cuy_rotando();
          
        if(rotarono){
            callback_rotacion = function () { ///se ejecuta al acabar  cuy_rotacion();
                detener_var_cuymoviendo();
                CUY_CORRIENDO=true;
                mover_cuy_rapido();
            }
            CUY_ROTANDO=true;
            detener_var_cuy_rotando();
            cuy_rotacionrapido();
        }else{
            CUY_ROTANDO=false;
            model.lookAt(b.x, b.y, b.z);
            modelCuyDudando.lookAt(b.x, b.y, b.z);
            modelCuyChoque.lookAt(b.x, b.y, b.z);
            t=0;
            aver=CUY_CORRIENDO?"true":"false";
              // console.warn("t else:::::  "+t +" "+b.x+" "+b.y+" "+b.z +"  cuycorriendo  = "+ aver);
            detener_var_cuymoviendo();
            detener_var_cuydudando();
            detener_var_cuychoque();
            CUY_CORRIENDO=true;
            mover_cuy_rapido();
        }

}

function cuy_rotacionrapido() {//var_cuy_rotando
    if(!CUY_ROTANDO){return;}
    model.visible = true;
    modelCuyDudando.visible = false;
    modelCuyChoque.visible = false; 
    timerotacion=parseFloat(timerotacion+dtrotacion).toFixed(5);
    timerotacion=parseFloat(timerotacion);
    var_cuy_rotando = requestAnimationFrame(cuy_rotacionrapido);
    mixer.update(clock.getDelta());
    THREE.Quaternion.slerp(q1, q2, model.quaternion, timerotacion); // added
    renderer.render(scene, camera);
    if (timerotacion > 1) {
        model.lookAt(new THREE.Vector3(b.x,b.y,b.z))
        modelCuyDudando.lookAt(new THREE.Vector3(b.x,b.y,b.z))
        modelCuyChoque.lookAt(new THREE.Vector3(b.x,b.y,b.z))

        CUY_ROTANDO=false;
        // console.log("rotacion "+timerotacion);  
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


function mover_cuy_rapido2() {    ///var_cuymoviendo  => animationframe
    if (!CUY_CORRIENDO) {  return;}
    mostrar_cuymoviendo();
  //thrust=0.01;
x=model.position.x;
z=model.position.z;
   tx = (b.x - x).toFixed(10);tx=parseFloat(tx);
 tz = (b.z - z).toFixed(10);tz=parseFloat(tz);
 dist = Math.sqrt(tx*tx+tz*tz);
 dist=dist.toFixed(10);dist=parseFloat(dist);
 if(x>=b.x){dist=0;}
    rad = Math.atan2(tz,tx);
    angle = rad/Math.PI * 180;
    velX = (tx/dist)*thrust;
    velZ = (tz/dist)*thrust;
console.log(dist+"  x:"+x+" z:"+z);

 if(dist>0){
    x=(x+velX).toFixed(10);
    z=(z+velZ).toFixed(10);
          model.position.set(parseFloat(x),
                             0,
                              parseFloat(z)); 
            mixer.update(clock.getDelta());
    renderer.render(scene, camera);
    var_cuymoviendo = requestAnimationFrame(mover_cuy_rapido2);
}  
  
  
else
    {
console.log(model.position.x+"  - "+model.position.z);
        //model.position.set(b.x, b.y, b.z); ///ajustar posición si no llegó exacto
        a = { x: model.position.x, y: model.position.y, z: model.position.z };   //////nueva posicion
        detener_var_cuymoviendo();
        detener_var_cuy_rotando();
        actualizar_cuyes_posicion();
            if(!mover_a_ganador){
                    mover_a_ganador=true;
                    // b=get_caja(GANADOR_DE_EVENTO).posicion;
                    if(GANADOR_DE_EVENTO=="x"){
                         b=ARRAY_PUNTOSCAJAS[ARRAY_PUNTOSCAJAS.length-1].posicion;
                    }else{
                        b=get_caja(GANADOR_DE_EVENTO).posicion;
                    }
            }  
            else {
                CUY_CORRIENDO = false;
                if(ARRAY_PUNTOSCAJAS[ARRAY_PUNTOSCAJAS.length-1].posicion.x==model.position.x && ARRAY_PUNTOSCAJAS[ARRAY_PUNTOSCAJAS.length-1].posicion.y==model.position.y ){
                    modelCuyChoque.position.y=-0.1;
                    cuychoque();
                    cajax_animacion();
                }
             }
      
    }  ///fin t>1
}
function mover_cuy_rapido() {    ///var_cuymoviendo  => animationframe
    if (!CUY_CORRIENDO) {  return;}
    mostrar_cuymoviendo();
    funcion_ease=EasingFunctions_array[bfuncion_easing_indice].funcion;//usar random de generarrandompunto b

    var newX = lerp(a.x, b.x, funcion_ease(t));  
    var newY = lerp(a.y, b.y, funcion_ease(t));  
    var newZ = lerp(a.z, b.z, funcion_ease(t));  
    model.position.set(newX,0,newZ); 
    t=parseFloat(t+dt).toFixed(5);
    t=parseFloat(t);
    mixer.update(clock.getDelta());
    renderer.render(scene, camera);
    var_cuymoviendo = requestAnimationFrame(mover_cuy_rapido);
    if(t>=1)
    {
        model.position.set(b.x, b.y, b.z); ///ajustar posición si no llegó exacto
        a = { x: model.position.x, y: model.position.y, z: model.position.z };   //////nueva posicion
        detener_var_cuymoviendo();
        detener_var_cuy_rotando();
        actualizar_cuyes_posicion();
            if(!mover_a_ganador){
                    mover_a_ganador=true;
                    // b=get_caja(GANADOR_DE_EVENTO).posicion;
                    if(GANADOR_DE_EVENTO=="x"){
                         b=ARRAY_PUNTOSCAJAS[ARRAY_PUNTOSCAJAS.length-1].posicion;
                    }else{
                        b=get_caja(GANADOR_DE_EVENTO).posicion;
                    }
            }  
            else {
                CUY_CORRIENDO = false;
                if(ARRAY_PUNTOSCAJAS[ARRAY_PUNTOSCAJAS.length-1].posicion.x==model.position.x && ARRAY_PUNTOSCAJAS[ARRAY_PUNTOSCAJAS.length-1].posicion.y==model.position.y ){
                    modelCuyChoque.position.y=-0.1;
                    cuychoque();
                    cajax_animacion();
                }
             }
      
    }  ///fin t>1
}