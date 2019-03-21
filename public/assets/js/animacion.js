iniciado = false;
$(document).ready(function () {
    $("#ImgContainer").css("background-image", "url('images/imgCuyInicio.jpg')");
    setInterval(function () {
        if (iniciado == false) {
            consultarEvento(1);
        }
    }, 1000);


});
if (WEBGL.isWebGLAvailable() === false) {
    document.body.appendChild(WEBGL.getWebGLErrorMessage());
}
var scene, renderer, camera, stats;
var model, modelCuyDudando, modelChoque, modelCaja, skeleton, mixer, mixerCaja, clock;
var crossFadeControls = [];
var idleAction, walkAction, runAction;
var idleWeight, walkWeight, runWeight;
var actions, settings;
var singleStepMode = false;
var sizeOfNextStep = 0;
var loaded = false;
var i = 0;
var ganador = 0;
var controls;
var posicionZ = 0;

init();

function init() {
    var container = document.getElementById('container');
    camera = new THREE.PerspectiveCamera(60, window.innerWidth / window.innerHeight, 1, 100);
    camera.position.set(0, 10, 0);
    clock = new THREE.Clock();
    clockCuyDudando = new THREE.Clock();
    clockCuyChoque = new THREE.Clock();
    scene = new THREE.Scene();
    scene.background = new THREE.Color(0xa0a0a0);
    scene.fog = new THREE.Fog(0xa0a0a0, 10, 50);
    var hemiLight = new THREE.HemisphereLight(0xffffff, 0x444444);
    hemiLight.position.set(0, 20, 0);
    scene.add(hemiLight);
    var dirLight = new THREE.DirectionalLight(0xffffff);
    dirLight.position.set(-3, 10, -10);
    dirLight.castShadow = true;
    dirLight.shadow.camera.top = 2;
    dirLight.shadow.camera.bottom = -2;
    dirLight.shadow.camera.left = -2;
    dirLight.shadow.camera.right = 2;
    dirLight.shadow.camera.near = 0.1;
    dirLight.shadow.camera.far = 40;
    scene.add(dirLight);


    controls = new THREE.OrbitControls(camera);
    controls.autoRotate = true;
    controls.autoRotateSpeed = 10;
    camera.lookAt(new THREE.Vector3(0, 0, 0));

    var mesh = new THREE.Mesh(new THREE.PlaneBufferGeometry(100, 100), new THREE.MeshPhongMaterial({
        color: 0x999999,
        depthWrite: false
    }));
    mesh.rotation.x = -Math.PI / 2;
    mesh.receiveShadow = true;
    scene.add(mesh);
    var material = new THREE.MeshBasicMaterial();
    var loader = new THREE.GLTFLoader();
    // Plano y Cajas
    var loaderCaja = new THREE.GLTFLoader();
    loaderCaja.load('images/Cajas5.glb', function (gltfCaja) {
        modelCaja = gltfCaja.scenes[0];
        modelCaja.traverse(function (object) {
            if (object instanceof THREE.Mesh) {
                object.castShadow = true;
                if (object.name != "Box006" && object.name != "Box007") {
                    object.position.y = 0;
                }
                ;
            }
        });
        //modelCaja.position.set(-2,0,2);
        scene.add(modelCaja);
        skeleton = new THREE.SkeletonHelper(modelCaja);
    });
    // CUY CAMINANDO				
    loader.load('images/cuy6.glb', function (gltf) {
        model = gltf.scenes[0];
        model.traverse(function (object) {
            if (object instanceof THREE.Mesh) {
                object.castShadow = true
            }
        });
        model.scale.set(0.5, 0.5, 0.5);
        model.position.set(0, 0, 0.05);
        scene.add(model);
        //model.position.z=2;
        skeleton = new THREE.SkeletonHelper(model);
        var animations = gltf.animations;
        mixer = new THREE.AnimationMixer(model);
        mixer.clipAction(animations[0]).play();
        loaded = true;
    });
    // CUY DUDANDO
    var loaderCuyDudando = new THREE.GLTFLoader();
    loaderCuyDudando.load('images/cuyDudandoGLB.glb', function (gltf) {
        modelCuyDudando = gltf.scenes[0];
        modelCuyDudando.traverse(function (objectCuyDudando) {
            if (objectCuyDudando instanceof THREE.Mesh) {
                objectCuyDudando.castShadow = true
            }
        });
        modelCuyDudando.scale.set(0.5, 0.5, 0.5);
        model.position.set(0, 0, 0.05);
        scene.add(modelCuyDudando);
        skeleton = new THREE.SkeletonHelper(model);
        var animations = gltf.animations;
        mixerCuyDudando = new THREE.AnimationMixer(modelCuyDudando);
        mixerCuyDudando.clipAction(animations[0]).play();
        loaded = true;
    });
    // CUY CHOQUE				
    var loaderCuyChoque = new THREE.GLTFLoader();
    loaderCuyChoque.load('images/cuyChoqueGLB.glb', function (gltf) {
        modelCuyChoque = gltf.scenes[0];
        modelCuyChoque.traverse(function (objectCuyChoque) {
            if (objectCuyChoque instanceof THREE.Mesh) {
                objectCuyChoque.castShadow = true
            }
        });
        modelCuyChoque.scale.set(0.5, 0.5, 0.5);
        model.position.set(0, 0, 0.05);
        scene.add(modelCuyChoque);
        skeleton = new THREE.SkeletonHelper(model);
        var animations = gltf.animations;
        mixerCuyChoque = new THREE.AnimationMixer(modelCuyChoque);
        mixerCuyChoque.clipAction(animations[0]).play();
        loaded = true;
    });

    renderer = new THREE.WebGLRenderer({antialias: true});
    renderer.setPixelRatio(window.devicePixelRatio);
    renderer.setSize(window.innerWidth, window.innerHeight);
    renderer.gammaOutput = true;
    renderer.gammaFactor = 2.2;
    renderer.shadowMap.enabled = true;
    container.appendChild(renderer.domElement);
}

function animate() {
    $("#ImgContainer").hide();
    id = requestAnimationFrame(animate);
    if (loaded) {
        mixer.update(clock.getDelta());
        mixerCuyDudando.update(clockCuyDudando.getDelta());
        model.visible = true;
        if (clock.getElapsedTime() <= 5) {
            if (clock.getElapsedTime() <= 3) {
                modelCuyDudando.visible = true;
                model.visible = false;
                modelCuyChoque.visible = false;
            }
            else {
                modelCuyDudando.visible = false;
                model.visible = true;
                model.rotation.y += 0.1;
            }
        }
        else {
            switch (ganador) {
                case 0:
                    // model.visible = false; 
                    // modelCuyChoque.visible=true; 
                    // mixerCuyChoque.update(clockCuyChoque.getDelta());            			                   
                    if (model.position.z < -2.5) {
                        if (model.position.z < -3.5) {
                            cancelAnimationFrame(id);
                            $("#ImgContainer").css("background-image", "url('images/imgCuyCargando.jpg')");
                            $("#ImgContainer").show();
                            model.position.x = 0;
                            model.position.y = 0;
                            model.position.z = 0;
                            clock = new THREE.Clock();
                            clockCuyDudando = new THREE.Clock();
                            iniciado = false;
                        }
                        else {
                            model.position.z -= 0.01;
                            model.visible = false;
                            modelCuyChoque.rotation.y = 3.3;
                            modelCuyChoque.position.x = model.position.x;
                            modelCuyChoque.position.y = model.position.y;
                            modelCuyChoque.position.z = posicionZ;
                            modelCuyChoque.visible = true;
                            mixerCuyChoque.update(clockCuyChoque.getDelta());
                        }
                    }
                    else {
                        model.rotation.y = 3.3;
                        model.position.z -= 0.01;
                        model.position.x -= 0.0027;
                        posicionZ = model.position.z;
                    }
                    break;
                case 1:
                    if (model.position.z > 4.5) {
                        cancelAnimationFrame(id);
                        $("#ImgContainer").css("background-image", "url('images/imgCuyCargando.jpg')");
                        $("#ImgContainer").show();
                        model.position.x = 0;
                        model.position.y = 0;
                        model.position.z = 0;
                        clock = new THREE.Clock();
                        clockCuyDudando = new THREE.Clock();
                        iniciado = false;
                    }
                    else {
                        model.rotation.y = 0.4;
                        model.position.z += 0.01;
                        model.position.x += 0.002;
                    }
                    break;
                case 2:
                    if (model.position.z < -1.38) {
                        cancelAnimationFrame(id);
                        $("#ImgContainer").css("background-image", "url('images/imgCuyCargando.jpg')");
                        $("#ImgContainer").show();
                        model.position.x = 0;
                        model.position.y = 0;
                        model.position.z = 0;
                        clock = new THREE.Clock();
                        clockCuyDudando = new THREE.Clock();
                        iniciado = false;
                    }
                    else {
                        model.rotation.y = 1.9;
                        model.position.z -= 0.009;
                        model.position.x += 0.023;
                    }
                    break;
                case 3:
                    if (model.position.z > 3.6) {
                        cancelAnimationFrame(id);
                        $("#ImgContainer").css("background-image", "url('images/imgCuyCargando.jpg')");
                        $("#ImgContainer").show();
                        model.position.x = 0;
                        model.position.y = 0;
                        model.position.z = 0;
                        clock = new THREE.Clock();
                        clockCuyDudando = new THREE.Clock();
                        iniciado = false;
                    }
                    else {
                        model.rotation.y = 0.6;
                        model.position.z += 0.019;
                        model.position.x += 0.0145;
                    }
                    break;
                case 4:
                    if (model.position.z < -2.98) {
                        cancelAnimationFrame(id);
                        $("#ImgContainer").css("background-image", "url('images/imgCuyCargando.jpg')");
                        $("#ImgContainer").show();
                        model.position.x = 0;
                        model.position.y = 0;
                        model.position.z = 0;
                        clock = new THREE.Clock();
                        clockCuyDudando = new THREE.Clock();
                        iniciado = false;
                    }
                    else {
                        model.rotation.y = 2.7;
                        model.position.z -= 0.011;
                        model.position.x += 0.008;
                    }
                    break;
                case 5:
                    if (model.position.z > 3.7) {
                        cancelAnimationFrame(id);
                        $("#ImgContainer").css("background-image", "url('images/imgCuyCargando.jpg')");
                        $("#ImgContainer").show();
                        model.position.x = 0;
                        model.position.y = 0;
                        model.position.z = 0;
                        clock = new THREE.Clock();
                        clockCuyDudando = new THREE.Clock();
                        iniciado = false;
                    }
                    else {
                        model.rotation.y = -0.8;
                        model.position.z += 0.01;
                        model.position.x -= 0.008;
                    }
                    break;
                case 6:
                    if (model.position.z > 4.2) {
                        cancelAnimationFrame(id);
                        $("#ImgContainer").css("background-image", "url('images/imgCuyCargando.jpg')");
                        $("#ImgContainer").show();
                        model.position.x = 0;
                        model.position.y = 0;
                        model.position.z = 0;
                        clock = new THREE.Clock();
                        clockCuyDudando = new THREE.Clock();
                        iniciado = false;
                    }
                    else {
                        model.rotation.y = 0.35;
                        model.position.z += 0.01;
                        model.position.x += 0.0045;
                    }
                    break;
                case 7:
                    if (model.position.z > 1.9) {
                        cancelAnimationFrame(id);
                        $("#ImgContainer").css("background-image", "url('images/imgCuyCargando.jpg')");
                        $("#ImgContainer").show();
                        model.position.x = 0;
                        model.position.y = 0;
                        model.position.z = 0;
                        clock = new THREE.Clock();
                        clockCuyDudando = new THREE.Clock();
                        iniciado = false;
                    }
                    else {
                        model.rotation.y = -1.15;
                        model.position.z += 0.005;
                        model.position.x -= 0.011;
                    }
                    break;
                case 8:
                    if (model.position.z > 4.6) {
                        cancelAnimationFrame(id);
                        $("#ImgContainer").css("background-image", "url('images/imgCuyCargando.jpg')");
                        $("#ImgContainer").show();
                        model.position.x = 0;
                        model.position.y = 0;
                        model.position.z = 0;
                        clock = new THREE.Clock();
                        clockCuyDudando = new THREE.Clock();
                        iniciado = false;
                    }
                    else {
                        model.rotation.y = -0.1;
                        model.position.z += 0.01;
                        //model.position.x +=0.002;
                    }
                    break;
                case 9:
                    if (model.position.z < -0.37) {
                        cancelAnimationFrame(id);
                        $("#ImgContainer").css("background-image", "url('images/imgCuyCargando.jpg')");
                        $("#ImgContainer").show();
                        model.position.x = 0;
                        model.position.y = 0;
                        model.position.z = 0;
                        clock = new THREE.Clock();
                        clockCuyDudando = new THREE.Clock();
                        iniciado = false;
                    }
                    else {
                        model.rotation.y = 1.5;
                        model.position.z -= 0.003;
                        model.position.x += 0.028;
                    }
                    break;
                case 10:
                    if (model.position.z > 4.3) {
                        cancelAnimationFrame(id);
                        $("#ImgContainer").css("background-image", "url('images/imgCuyCargando.jpg')");
                        $("#ImgContainer").show();
                        model.position.x = 0;
                        model.position.y = 0;
                        model.position.z = 0;
                        clock = new THREE.Clock();
                        clockCuyDudando = new THREE.Clock();
                        iniciado = false;
                    }
                    else {
                        model.rotation.y = -0.5;
                        model.position.z += 0.01;
                        model.position.x -= 0.0048;
                    }
                    break;
                case 11:
                    if (model.position.z > 2.7) {
                        cancelAnimationFrame(id);
                        $("#ImgContainer").css("background-image", "url('images/imgCuyCargando.jpg')");
                        $("#ImgContainer").show();
                        model.position.x = 0;
                        model.position.y = 0;
                        model.position.z = 0;
                        clock = new THREE.Clock();
                        clockCuyDudando = new THREE.Clock();
                        iniciado = false;
                    }
                    else {
                        model.rotation.y = 0.85;
                        model.position.z += 0.011;
                        model.position.x += 0.0145;
                    }
                    break;
                case 12:
                    if (model.position.z < -3.4) {
                        cancelAnimationFrame(id);
                        $("#ImgContainer").css("background-image", "url('images/imgCuyCargando.jpg')");
                        $("#ImgContainer").show();
                        model.position.x = 0;
                        model.position.y = 0;
                        model.position.z = 0;
                        clock = new THREE.Clock();
                        clockCuyDudando = new THREE.Clock();
                        iniciado = false;
                    }
                    else {
                        model.rotation.y = -2.65;
                        model.position.z -= 0.008;
                        model.position.x -= 0.0045;
                    }
                    break;
                case 13:
                    if (model.position.z < -1.15) {
                        cancelAnimationFrame(id);
                        $("#ImgContainer").css("background-image", "url('images/imgCuyCargando.jpg')");
                        $("#ImgContainer").show();
                        model.position.x = 0;
                        model.position.y = 0;
                        model.position.z = 0;
                        clock = new THREE.Clock();
                        clockCuyDudando = new THREE.Clock();
                        iniciado = false;
                    }
                    else {
                        model.rotation.y = -1.9;
                        model.position.z -= 0.0053;
                        model.position.x -= 0.018;
                    }
                    break;
                case 14:
                    if (model.position.z < -2.1) {
                        cancelAnimationFrame(id);
                        $("#ImgContainer").css("background-image", "url('images/imgCuyCargando.jpg')");
                        $("#ImgContainer").show();
                        model.position.x = 0;
                        model.position.y = 0;
                        model.position.z = 0;
                        clock = new THREE.Clock();
                        clockCuyDudando = new THREE.Clock();
                        iniciado = false;
                    }
                    else {
                        model.rotation.y = -2.1;
                        model.position.z -= 0.006;
                        model.position.x -= 0.01;
                    }
                    break;
                case 15:
                    if (model.position.z < -3.6) {
                        cancelAnimationFrame(id);
                        $("#ImgContainer").css("background-image", "url('images/imgCuyCargando.jpg')");
                        $("#ImgContainer").show();
                        model.position.x = 0;
                        model.position.y = 0;
                        model.position.z = 0;
                        clock = new THREE.Clock();
                        clockCuyDudando = new THREE.Clock();
                        iniciado = false;
                    }
                    else {
                        model.rotation.y = 3;
                        model.position.z -= 0.01;
                        model.position.x += 0.0005;
                    }
                    break;
                case 16:
                    if (model.position.z > 1.8) {
                        cancelAnimationFrame(id);
                        $("#ImgContainer").css("background-image", "url('images/imgCuyCargando.jpg')");
                        $("#ImgContainer").show();
                        model.position.x = 0;
                        model.position.y = 0;
                        model.position.z = 0;
                        clock = new THREE.Clock();
                        clockCuyDudando = new THREE.Clock();
                        iniciado = false;
                    }
                    else {
                        model.rotation.y = 1;
                        model.position.z += 0.0065;
                        model.position.x += 0.0145;
                    }
                    break;
                case 17:
                    if (model.position.z < -2.8) {
                        cancelAnimationFrame(id);
                        $("#ImgContainer").css("background-image", "url('images/imgCuyCargando.jpg')");
                        $("#ImgContainer").show();
                        model.position.x = 0;
                        model.position.y = 0;
                        model.position.z = 0;
                        clock = new THREE.Clock();
                        clockCuyDudando = new THREE.Clock();
                        iniciado = false;
                    }
                    else {
                        model.rotation.y = -2.4;
                        model.position.z -= 0.01;
                        model.position.x -= 0.01;
                    }
                    break;
                case 18:
                    if (model.position.z < -0.145) {
                        cancelAnimationFrame(id);
                        $("#ImgContainer").css("background-image", "url('images/imgCuyCargando.jpg')");
                        $("#ImgContainer").show();
                        model.position.x = 0;
                        model.position.y = 0;
                        model.position.z = 0;
                        clock = new THREE.Clock();
                        clockCuyDudando = new THREE.Clock();
                        iniciado = false;
                    }
                    else {
                        model.rotation.y = -1.6;
                        model.position.z -= 0.0008;
                        model.position.x -= 0.018;
                    }
                    break;
                case 19:
                    if (model.position.z < -3.4) {
                        cancelAnimationFrame(id);
                        $("#ImgContainer").css("background-image", "url('images/imgCuyCargando.jpg')");
                        $("#ImgContainer").show();
                        model.position.x = 0;
                        model.position.y = 0;
                        model.position.z = 0;
                        clock = new THREE.Clock();
                        clockCuyDudando = new THREE.Clock();
                        iniciado = false;
                    }
                    else {
                        model.rotation.y = 2.7;
                        model.position.z -= 0.011;
                        model.position.x += 0.0038;
                    }
                    break;
                case 20:
                    if (model.position.z > 0.87) {
                        cancelAnimationFrame(id);
                        $("#ImgContainer").css("background-image", "url('images/imgCuyCargando.jpg')");
                        $("#ImgContainer").show();
                        model.position.x = 0;
                        model.position.y = 0;
                        model.position.z = 0;
                        clock = new THREE.Clock();
                        clockCuyDudando = new THREE.Clock();
                        iniciado = false;
                    }
                    else {
                        model.rotation.y = -1.3;
                        model.position.z += 0.0028;
                        model.position.x -= 0.015;
                    }
                    break;
                case 21:
                    if (model.position.z < -2.27) {
                        cancelAnimationFrame(id);
                        $("#ImgContainer").css("background-image", "url('images/imgCuyCargando.jpg')");
                        $("#ImgContainer").show();
                        model.position.x = 0;
                        model.position.y = 0;
                        model.position.z = 0;
                        clock = new THREE.Clock();
                        clockCuyDudando = new THREE.Clock();
                        iniciado = false;
                    }
                    else {
                        model.rotation.y = 2.1;
                        model.position.z -= 0.011;
                        model.position.x += 0.0145;
                    }
                    break;
                case 22:
                    if (model.position.z > 0.765) {
                        cancelAnimationFrame(id);
                        $("#ImgContainer").css("background-image", "url('images/imgCuyCargando.jpg')");
                        $("#ImgContainer").show();
                        model.position.x = 0;
                        model.position.y = 0;
                        model.position.z = 0;
                        clock = new THREE.Clock();
                        clockCuyDudando = new THREE.Clock();
                        iniciado = false;
                    }
                    else {
                        model.rotation.y = 1.3;
                        model.position.z += 0.0025;
                        model.position.x += 0.0145;
                    }
                    break;
                case 23:
                    if (model.position.z > 4.5) {
                        cancelAnimationFrame(id);
                        $("#ImgContainer").css("background-image", "url('images/imgCuyCargando.jpg')");
                        $("#ImgContainer").show();
                        model.position.x = 0;
                        model.position.y = 0;
                        model.position.z = 0;
                        clock = new THREE.Clock();
                        clockCuyDudando = new THREE.Clock();
                        iniciado = false;
                    }
                    else {
                        model.rotation.y = -0.3;
                        model.position.z += 0.01;
                        model.position.x -= 0.0023;
                    }
                    break;
                case 24:
                    if (model.position.z > 2.85) {
                        cancelAnimationFrame(id);
                        $("#ImgContainer").css("background-image", "url('images/imgCuyCargando.jpg')");
                        $("#ImgContainer").show();
                        model.position.x = 0;
                        model.position.y = 0;
                        model.position.z = 0;
                        clock = new THREE.Clock();
                        clockCuyDudando = new THREE.Clock();
                        iniciado = false;
                    }
                    else {
                        model.rotation.y = -0.9;
                        model.position.z += 0.01;
                        model.position.x -= 0.013;
                    }
                    break;
                default:
                // code block
            }
        }
        renderer.render(scene, camera);
    }
}

function iniciar(numeorGanador) {
    ganador=parseInt(numeorGanador);
    // ganador = parseInt(0);
    //ganador=Math.floor((Math.random() * 24));
    $("#ImgContainer").hide();
    animate();
}

function consultarEvento(IdJuego) {
    var url = document.location.origin + "/" + "api/DataEventoResultadoEvento";
    $.ajax({
        url: url,
        type: "POST",
        contentType: "application/json",
        data: JSON.stringify({IdJuego: IdJuego}),
        beforeSend: function () {
        },
        complete: function () {
        },
        success: function (response) {
            if(response.token_animacion != undefined){
                $.each(response.estadistica, function( key, value ) {
                    $("#"+value.TipoValorApuesta).text(value.Repetidos);
                });
                var strUltimos12="";
                var clase="caja1";
                $.each(response.resultado_evento, function( key, value ) {
                    if(key<12){
                        switch (value.valorGanador) {
                            case '1':case '1':case '1':case '1':case '4':case '3':
                                clase="caja1";
                              break;
                            case '2':
                                clase="caja2";
                              break;
                            default:
                                clase="caja1";
                        }
                        strUltimos12+='<tr><th class="caja">'+value.idEvento+'</th><th class="'+clase+'">'+value.valorGanador+'</th></tr>';
                    }
                });
                $("#tablaUltimos").html(strUltimos12);
                iniciado = true;
                iniciar(response.evento_valor_ganador);
            }
            else{

            }
            //setTimeout(function(){ iniciado=false; }, 10000);   
        },
        error: function (jqXHR, textStatus, errorThrown) {
        }
    });
}