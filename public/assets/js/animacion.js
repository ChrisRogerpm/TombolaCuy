iniciado = false;
token="";
anguloRotacion=0;
i=0;
x=0;
m=0;
puntos=[{x:2.5,y:0},{x:-2.5,y:0},{x:0,y:2.5},{x:0,y:-2.5}];
flag=true;
pos=3;
pos1=3;
$(document).ready(function () {
    var i=0;
    $("#ImgContainer").css("background-image", "url('images/imgCuyInicio.jpg')");
    //CargarEstadistica(1);
    $("#ImgContainer").hide();

    // setInterval(function () {
    //     if(i==10){
    //         location.reload();
    //     }
    //     if (iniciado == false) {
    //         consultarEvento(1);
    //     }
    // }, 1000);


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
    //relojes
    clock = new THREE.Clock();
    clockCuyDudando = new THREE.Clock();
    clockCuyChoque = new THREE.Clock();

    var container = document.getElementById('container');
    camera = new THREE.PerspectiveCamera(60, window.innerWidth / window.innerHeight, 1, 100);
    camera.position.set(0, 10, 0);
    
    //escena
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


    var axesHelper = new THREE.AxesHelper( 5,5,5 );
    scene.add( axesHelper );

    // controls = new THREE.OrbitControls(camera);
    // controls.autoRotate = true;
    // controls.autoRotateSpeed = 10;
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
        //cargar los demas modelos
        // CUY CAMINANDO				
        loader.load('images/cuy6.glb', function (gltf) {
            model = gltf.scenes[0];
            model.traverse(function (object) {
                if (object instanceof THREE.Mesh) {
                    object.castShadow = true
                }
            });
            model.scale.set(0.5, 0.5, 0.5);
            model.position.set(0, 0, 0);
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
            model.position.set(0, 0, 0);
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
            model.position.set(0, 0, 0);
            scene.add(modelCuyChoque);
            skeleton = new THREE.SkeletonHelper(model);
            var animations = gltf.animations;
            mixerCuyChoque = new THREE.AnimationMixer(modelCuyChoque);
            mixerCuyChoque.clipAction(animations[0]).play();
            loaded = true;
        });
    });
    

    renderer = new THREE.WebGLRenderer({antialias: true});
    renderer.setPixelRatio(window.devicePixelRatio);
    renderer.setSize(window.innerWidth, window.innerHeight);
    renderer.gammaOutput = true;
    renderer.gammaFactor = 2.2;
    renderer.shadowMap.enabled = true;
    container.appendChild(renderer.domElement);
}

function animate1() {
    //console.log(model.position);
    $("#ImgContainer").hide();
    id = requestAnimationFrame(animate);
    if (loaded) {
        mixer.update(clock.getDelta());
        mixerCuyDudando.update(clockCuyDudando.getDelta());
        model.visible = true;
        // if (clock.getElapsedTime() <= 8) {
        //     if (clock.getElapsedTime() <= 3) {                                
        //         modelCuyDudando.visible = true;
        //         model.visible = false;
        //         modelCuyChoque.visible = false;
        //     }
        //     else {
        //         if(model.rotation.y < anguloRotacion){
        //             //console.log(model.rotation.y,clock.getElapsedTime());
        //             modelCuyDudando.visible = false;
        //             model.visible = true;
        //             model.rotation.y += 0.05;
        //         }
        //         else{
        //             modelCuyDudando.visible = true;
        //             modelCuyDudando.rotation.y = model.rotation.y;
        //             model.visible = false;
        //             modelCuyChoque.visible = false;
        //         }                
        //     }
        // }
        // else {
        //     modelCuyDudando.visible = false;
        //     switch (ganador) {
        //         case 0:
        //             // model.visible = false; 
        //             // modelCuyChoque.visible=true; 
        //             // mixerCuyChoque.update(clockCuyChoque.getDelta());            			                   
        //             if (model.position.z < -2.5) {
        //                 if (model.position.z < -3.5) {
        //                     cancelAnimationFrame(id);
        //                     $("#ImgContainer").css("background-image", "url('images/0.jpg')");
        //                     $("#ImgContainer").show();
        //                     model.position.x = 0;
        //                     model.position.y = 0;
        //                     model.position.z = 0;
        //                     clock = new THREE.Clock();
        //                     clockCuyDudando = new THREE.Clock();
        //                     clockCuyChoque=new THREE.Clock();
        //                     CerrarEvento(1,token);
        //                     token = "";
        //                     iniciado = false;
        //                 }
        //                 else {
        //                     model.position.z -= 0.01;
        //                     model.visible = false;
        //                     modelCuyChoque.rotation.y = 3.3;
        //                     modelCuyChoque.position.x = model.position.x;
        //                     modelCuyChoque.position.y = model.position.y;
        //                     modelCuyChoque.position.z = posicionZ;
        //                     modelCuyChoque.visible = true;
        //                     mixerCuyChoque.update(clockCuyChoque.getDelta());
        //                 }
        //             }
        //             else {
        //                 //model.rotation.y = 3.3;
        //                 model.position.z -= 0.01;
        //                 model.position.x -= 0.0027;
        //                 posicionZ = model.position.z;
        //             }
        //             break;
        //         case 1:
        //             if (model.position.z > 4.5) {
        //                 cancelAnimationFrame(id);
        //                 $("#ImgContainer").css("background-image", "url('images/1.jpg')");
        //                 $("#ImgContainer").show();
        //                 model.position.x = 0;
        //                 model.position.y = 0;
        //                 model.position.z = 0;
        //                 clock = new THREE.Clock();
        //                 clockCuyDudando = new THREE.Clock();
        //                 CerrarEvento(1,token);
        //                 token = "";
        //                 iniciado = false;
        //             }
        //             else {                                
        //                 //model.rotation.y = 0.4;                        
        //                 model.position.z += 0.01;
        //                 model.position.x += 0.002;
        //             }
        //             break;
        //         case 2:
        //             if (model.position.z < -1.38) {
        //                 cancelAnimationFrame(id);
        //                 $("#ImgContainer").css("background-image", "url('images/2.jpg')");
        //                 $("#ImgContainer").show();
        //                 model.position.x = 0;
        //                 model.position.y = 0;
        //                 model.position.z = 0;
        //                 clock = new THREE.Clock();
        //                 clockCuyDudando = new THREE.Clock();
        //                 CerrarEvento(1,token);
        //                 token = "";
        //                 iniciado = false;
        //             }
        //             else {
        //                 //model.rotation.y = 1.9;
        //                 model.position.z -= 0.009;
        //                 model.position.x += 0.023;
        //             }
        //             break;
        //         case 3:
        //             if (model.position.z > 3.6) {
        //                 cancelAnimationFrame(id);
        //                 $("#ImgContainer").css("background-image", "url('images/3.jpg')");
        //                 $("#ImgContainer").show();
        //                 model.position.x = 0;
        //                 model.position.y = 0;
        //                 model.position.z = 0;
        //                 clock = new THREE.Clock();
        //                 clockCuyDudando = new THREE.Clock();
        //                 CerrarEvento(1,token);
        //                 token = "";
        //                 iniciado = false;
        //             }
        //             else {
        //                 //model.rotation.y = 0.6;
        //                 model.position.z += 0.019;
        //                 model.position.x += 0.0145;
        //             }
        //             break;
        //         case 4:
        //             if (model.position.z < -2.98) {
        //                 cancelAnimationFrame(id);
        //                 $("#ImgContainer").css("background-image", "url('images/4.jpg')");
        //                 $("#ImgContainer").show();
        //                 model.position.x = 0;
        //                 model.position.y = 0;
        //                 model.position.z = 0;
        //                 clock = new THREE.Clock();
        //                 clockCuyDudando = new THREE.Clock();
        //                 CerrarEvento(1,token);
        //                 token = "";
        //                 iniciado = false;
        //             }
        //             else {
        //                 //model.rotation.y = 2.7;
        //                 model.position.z -= 0.011;
        //                 model.position.x += 0.008;
        //             }
        //             break;
        //         case 5:
        //             if (model.position.z > 3.7) {
        //                 cancelAnimationFrame(id);
        //                 $("#ImgContainer").css("background-image", "url('images/5.jpg')");
        //                 $("#ImgContainer").show();
        //                 model.position.x = 0;
        //                 model.position.y = 0;
        //                 model.position.z = 0;
        //                 clock = new THREE.Clock();
        //                 clockCuyDudando = new THREE.Clock();
        //                 CerrarEvento(1,token);
        //                 token = "";
        //                 iniciado = false;
        //             }
        //             else {
        //                 //model.rotation.y = -0.8;
        //                 model.position.z += 0.01;
        //                 model.position.x -= 0.008;
        //             }
        //             break;
        //         case 6:
        //             if (model.position.z > 4.2) {
        //                 cancelAnimationFrame(id);
        //                 $("#ImgContainer").css("background-image", "url('images/6.jpg')");
        //                 $("#ImgContainer").show();
        //                 model.position.x = 0;
        //                 model.position.y = 0;
        //                 model.position.z = 0;
        //                 clock = new THREE.Clock();
        //                 clockCuyDudando = new THREE.Clock();
        //                 CerrarEvento(1,token);
        //                 token = "";
        //                 iniciado = false;
        //             }
        //             else {
        //                 //model.rotation.y = 0.35;
        //                 model.position.z += 0.01;
        //                 model.position.x += 0.0045;
        //             }
        //             break;
        //         case 7:
        //             if (model.position.z > 1.9) {
        //                 cancelAnimationFrame(id);
        //                 $("#ImgContainer").css("background-image", "url('images/7.jpg')");
        //                 $("#ImgContainer").show();
        //                 model.position.x = 0;
        //                 model.position.y = 0;
        //                 model.position.z = 0;
        //                 clock = new THREE.Clock();
        //                 clockCuyDudando = new THREE.Clock();
        //                 CerrarEvento(1,token);
        //                 token = "";
        //                 iniciado = false;
        //             }
        //             else {
        //                 //model.rotation.y = -1.15;
        //                 model.position.z += 0.005;
        //                 model.position.x -= 0.011;
        //             }
        //             break;
        //         case 8:
        //             if (model.position.z > 4.6) {
        //                 cancelAnimationFrame(id);
        //                 $("#ImgContainer").css("background-image", "url('images/8.jpg')");
        //                 $("#ImgContainer").show();
        //                 model.position.x = 0;
        //                 model.position.y = 0;
        //                 model.position.z = 0;
        //                 clock = new THREE.Clock();
        //                 clockCuyDudando = new THREE.Clock();
        //                 CerrarEvento(1,token);
        //                 token = "";
        //                 iniciado = false;
        //             }
        //             else {
        //                 //model.rotation.y = -0.1;
        //                 model.position.z += 0.01;
        //                 //model.position.x +=0.002;
        //             }
        //             break;
        //         case 9:
        //             if (model.position.z < -0.37) {
        //                 cancelAnimationFrame(id);
        //                 $("#ImgContainer").css("background-image", "url('images/9.jpg')");
        //                 $("#ImgContainer").show();
        //                 model.position.x = 0;
        //                 model.position.y = 0;
        //                 model.position.z = 0;
        //                 clock = new THREE.Clock();
        //                 clockCuyDudando = new THREE.Clock();
        //                 CerrarEvento(1,token);
        //                 token = "";
        //                 iniciado = false;
        //             }
        //             else {
        //                 //model.rotation.y = 1.5;
        //                 model.position.z -= 0.003;
        //                 model.position.x += 0.028;
        //             }
        //             break;
        //         case 10:
        //             if (model.position.z > 4.3) {
        //                 cancelAnimationFrame(id);
        //                 $("#ImgContainer").css("background-image", "url('images/10.jpg')");
        //                 $("#ImgContainer").show();
        //                 model.position.x = 0;
        //                 model.position.y = 0;
        //                 model.position.z = 0;
        //                 clock = new THREE.Clock();
        //                 clockCuyDudando = new THREE.Clock();
        //                 CerrarEvento(1,token);
        //                 token = "";
        //                 iniciado = false;
        //             }
        //             else {
        //                // model.rotation.y = -0.5;
        //                 model.position.z += 0.01;
        //                 model.position.x -= 0.0048;
        //             }
        //             break;
        //         case 11:
        //             if (model.position.z > 2.7) {
        //                 cancelAnimationFrame(id);
        //                 $("#ImgContainer").css("background-image", "url('images/11.jpg')");
        //                 $("#ImgContainer").show();
        //                 model.position.x = 0;
        //                 model.position.y = 0;
        //                 model.position.z = 0;
        //                 clock = new THREE.Clock();
        //                 clockCuyDudando = new THREE.Clock();
        //                 CerrarEvento(1,token);
        //                 token = "";
        //                 iniciado = false;
        //             }
        //             else {
        //                 //model.rotation.y = 0.85;
        //                 model.position.z += 0.011;
        //                 model.position.x += 0.0145;
        //             }
        //             break;
        //         case 12:
        //             if (model.position.z < -3.4) {
        //                 cancelAnimationFrame(id);
        //                 $("#ImgContainer").css("background-image", "url('images/12.jpg')");
        //                 $("#ImgContainer").show();
        //                 model.position.x = 0;
        //                 model.position.y = 0;
        //                 model.position.z = 0;
        //                 clock = new THREE.Clock();
        //                 clockCuyDudando = new THREE.Clock();
        //                 CerrarEvento(1,token);
        //                 token = "";
        //                 iniciado = false;
        //             }
        //             else {
        //                 //model.rotation.y = -2.65;
        //                 model.position.z -= 0.008;
        //                 model.position.x -= 0.0045;
        //             }
        //             break;
        //         case 13:
        //             if (model.position.z < -1.15) {
        //                 cancelAnimationFrame(id);
        //                 $("#ImgContainer").css("background-image", "url('images/13.jpg')");
        //                 $("#ImgContainer").show();
        //                 model.position.x = 0;
        //                 model.position.y = 0;
        //                 model.position.z = 0;
        //                 clock = new THREE.Clock();
        //                 clockCuyDudando = new THREE.Clock();
        //                 CerrarEvento(1,token);
        //                 token = "";
        //                 iniciado = false;
        //             }
        //             else {
        //                 //model.rotation.y = -1.9;
        //                 model.position.z -= 0.0053;
        //                 model.position.x -= 0.018;
        //             }
        //             break;
        //         case 14:
        //             if (model.position.z < -2.1) {
        //                 cancelAnimationFrame(id);
        //                 $("#ImgContainer").css("background-image", "url('images/14.jpg')");
        //                 $("#ImgContainer").show();
        //                 model.position.x = 0;
        //                 model.position.y = 0;
        //                 model.position.z = 0;
        //                 clock = new THREE.Clock();
        //                 clockCuyDudando = new THREE.Clock();
        //                 CerrarEvento(1,token);
        //                 token = "";
        //                 iniciado = false;
        //             }
        //             else {
        //                 //model.rotation.y = -2.1;
        //                 model.position.z -= 0.006;
        //                 model.position.x -= 0.01;
        //             }
        //             break;
        //         case 15:
        //             if (model.position.z < -3.6) {
        //                 cancelAnimationFrame(id);
        //                 $("#ImgContainer").css("background-image", "url('images/15.jpg')");
        //                 $("#ImgContainer").show();
        //                 model.position.x = 0;
        //                 model.position.y = 0;
        //                 model.position.z = 0;
        //                 clock = new THREE.Clock();
        //                 clockCuyDudando = new THREE.Clock();
        //                 CerrarEvento(1,token);
        //                 token = "";
        //                 iniciado = false;
        //             }
        //             else {
        //                 //model.rotation.y = 3;
        //                 model.position.z -= 0.01;
        //                 model.position.x += 0.0005;
        //             }
        //             break;
        //         case 16:
        //             if (model.position.z > 1.8) {
        //                 cancelAnimationFrame(id);
        //                 $("#ImgContainer").css("background-image", "url('images/16.jpg')");
        //                 $("#ImgContainer").show();
        //                 model.position.x = 0;
        //                 model.position.y = 0;
        //                 model.position.z = 0;
        //                 clock = new THREE.Clock();
        //                 clockCuyDudando = new THREE.Clock();
        //                 CerrarEvento(1,token);
        //                 token = "";
        //                 iniciado = false;
        //             }
        //             else {
        //                // model.rotation.y = 1;
        //                 model.position.z += 0.0065;
        //                 model.position.x += 0.0145;
        //             }
        //             break;
        //         case 17:
        //             if (model.position.z < -2.8) {
        //                 cancelAnimationFrame(id);
        //                 $("#ImgContainer").css("background-image", "url('images/17.jpg')");
        //                 $("#ImgContainer").show();
        //                 model.position.x = 0;
        //                 model.position.y = 0;
        //                 model.position.z = 0;
        //                 clock = new THREE.Clock();
        //                 clockCuyDudando = new THREE.Clock();
        //                 CerrarEvento(1,token);
        //                 token = "";
        //                 iniciado = false;
        //             }
        //             else {
        //                 //model.rotation.y = -2.4;
        //                 model.position.z -= 0.01;
        //                 model.position.x -= 0.01;
        //             }
        //             break;
        //         case 18:
        //             if (model.position.z < -0.145) {
        //                 cancelAnimationFrame(id);
        //                 $("#ImgContainer").css("background-image", "url('images/18.jpg')");
        //                 $("#ImgContainer").show();
        //                 model.position.x = 0;
        //                 model.position.y = 0;
        //                 model.position.z = 0;
        //                 clock = new THREE.Clock();
        //                 clockCuyDudando = new THREE.Clock();
        //                 CerrarEvento(1,token);
        //                 token = "";
        //                 iniciado = false;
        //             }
        //             else {
        //                 //model.rotation.y = -1.6;
        //                 model.position.z -= 0.0008;
        //                 model.position.x -= 0.018;
        //             }
        //             break;
        //         case 19:
        //             if (model.position.z < -3.4) {
        //                 cancelAnimationFrame(id);
        //                 $("#ImgContainer").css("background-image", "url('images/19.jpg')");
        //                 $("#ImgContainer").show();
        //                 model.position.x = 0;
        //                 model.position.y = 0;
        //                 model.position.z = 0;
        //                 clock = new THREE.Clock();
        //                 clockCuyDudando = new THREE.Clock();
        //                 CerrarEvento(1,token);
        //                 token = "";
        //                 iniciado = false;
        //             }
        //             else {
        //                 //model.rotation.y = 2.7;
        //                 model.position.z -= 0.011;
        //                 model.position.x += 0.0038;
        //             }
        //             break;
        //         case 20:
        //             if (model.position.z > 0.87) {
        //                 cancelAnimationFrame(id);
        //                 $("#ImgContainer").css("background-image", "url('images/20.jpg')");
        //                 $("#ImgContainer").show();
        //                 model.position.x = 0;
        //                 model.position.y = 0;
        //                 model.position.z = 0;
        //                 clock = new THREE.Clock();
        //                 clockCuyDudando = new THREE.Clock();
        //                 CerrarEvento(1,token);
        //                 token = "";
        //                 iniciado = false;
        //             }
        //             else {
        //                 //model.rotation.y = -1.3;
        //                 model.position.z += 0.0028;
        //                 model.position.x -= 0.015;
        //             }
        //             break;
        //         case 21:
        //             if (model.position.z < -2.27) {
        //                 cancelAnimationFrame(id);
        //                 $("#ImgContainer").css("background-image", "url('images/21.jpg')");
        //                 $("#ImgContainer").show();
        //                 model.position.x = 0;
        //                 model.position.y = 0;
        //                 model.position.z = 0;
        //                 clock = new THREE.Clock();
        //                 clockCuyDudando = new THREE.Clock();
        //                 CerrarEvento(1,token);
        //                 token = "";
        //                 iniciado = false;
        //             }
        //             else {
        //                 //model.rotation.y = 2.1;
        //                 model.position.z -= 0.011;
        //                 model.position.x += 0.0145;
        //             }
        //             break;
        //         case 22:
        //             if (model.position.z > 0.765) {
        //                 cancelAnimationFrame(id);
        //                 $("#ImgContainer").css("background-image", "url('images/22.jpg')");
        //                 $("#ImgContainer").show();
        //                 model.position.x = 0;
        //                 model.position.y = 0;
        //                 model.position.z = 0;
        //                 clock = new THREE.Clock();
        //                 clockCuyDudando = new THREE.Clock();
        //                 CerrarEvento(1,token);
        //                 token = "";
        //                 iniciado = false;
        //             }
        //             else {
        //                 //model.rotation.y = 1.3;
        //                 model.position.z += 0.0025;
        //                 model.position.x += 0.0145;
        //             }
        //             break;
        //         case 23:
        //             if (model.position.z > 4.5) {
        //                 cancelAnimationFrame(id);
        //                 $("#ImgContainer").css("background-image", "url('images/23.jpg')");
        //                 $("#ImgContainer").show();
        //                 model.position.x = 0;
        //                 model.position.y = 0;
        //                 model.position.z = 0;
        //                 clock = new THREE.Clock();
        //                 clockCuyDudando = new THREE.Clock();
        //                 CerrarEvento(1,token);
        //                 token = "";
        //                 iniciado = false;
        //             }
        //             else {
        //                 //model.rotation.y = -0.3;
        //                 model.position.z += 0.01;
        //                 model.position.x -= 0.0023;
        //             }
        //             break;
        //         case 24:
        //             if (model.position.z > 2.85) {
        //                 cancelAnimationFrame(id);
        //                 $("#ImgContainer").css("background-image", "url('images/24.jpg')");
        //                 $("#ImgContainer").show();
        //                 model.position.x = 0;
        //                 model.position.y = 0;
        //                 model.position.z = 0;
        //                 clock = new THREE.Clock();
        //                 clockCuyDudando = new THREE.Clock();
        //                 CerrarEvento(1,token);
        //                 token = "";
        //                 iniciado = false;
        //             }
        //             else {
        //                 //model.rotation.y = -0.9;
        //                 model.position.z += 0.01;
        //                 model.position.x -= 0.013;
        //             }
        //             break;
        //         default:
        //         // code block
        //     }
        // }
        renderer.render(scene, camera);
    }
}

function iniciar(numeorGanador) {  
      
    ganador=parseInt(numeorGanador);
    // ganador = parseInt(0);
    //ganador=Math.floor((Math.random() * 24));
    if(ganador==1){anguloRotacion=6.5;}
    if(ganador==8){anguloRotacion=6.2;}
    if(ganador==23){anguloRotacion=6;}    
    if(ganador==10){anguloRotacion=5.7;}    
    if(ganador==5){anguloRotacion=5.5;}    
    if(ganador==24){anguloRotacion=5.25;}    
    if(ganador==7){anguloRotacion=5.1;}    
    if(ganador==20){anguloRotacion=4.9;}    
    if(ganador==18){anguloRotacion=4.69;}    
    if(ganador==13){anguloRotacion=4.5;}    
    if(ganador==14){anguloRotacion=4.3;}    
    if(ganador==17){anguloRotacion=3.9;}    
    if(ganador==12){anguloRotacion=3.7;}    
    if(ganador==0){anguloRotacion=3.3;}    
    if(ganador==15){anguloRotacion=3.0;}    
    if(ganador==19){anguloRotacion=2.7;}    
    if(ganador==4){anguloRotacion=2.4;}    
    if(ganador==21){anguloRotacion=2.1;}    
    if(ganador==2){anguloRotacion=1.8;}    
    if(ganador==9){anguloRotacion=1.5;}    
    if(ganador==22){anguloRotacion=1.3;}    
    if(ganador==16){anguloRotacion=7.2;}    
    if(ganador==11){anguloRotacion=7.0;}    
    if(ganador==3){anguloRotacion=6.7;}    
    if(ganador==6){anguloRotacion=6.6;}    
    $("#ImgContainer").hide();
    // clock = new THREE.Clock();
    // clockCuyDudando = new THREE.Clock();
    // clockCuyChoque = new THREE.Clock();
    if(model!=undefined){
        model.rotation.y=0;
    }
    if(modelCuyDudando!=undefined){
        modelCuyDudando.rotation.y=0;
    }
    
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
            //console.log(response);
            if(response.token_animacion != undefined){       
                i=i+1;
                token=response.token_animacion;                
                $.each(response.estadistica, function( key, value ) {
                    $("#"+value.TipoValorApuesta).text(value.Repetidos);
                });
                var strUltimos12="";
                var clase="caja1";
                $.each(response.resultado_evento, function( key, value ) {
                    if(key<12){
                        switch (value.valorGanador) {
                            case '12':case '19':case '21':case '9':case '16':case '3':case '1':case '23':case '5':case '7':case '18':case '14':
                                clase="caja2";
                              break;
                            case '15':case '4':case '2':case '22':case '11':case '6':case '8':case '10':case '24':case '20':case '13':case '17':
                                clase="caja1";
                              break;                            
                            default:
                                clase="caja0";
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

function CerrarEvento(IdJuego,token_animacion) {
    var url = document.location.origin + "/" + "api/ConfirmacionToken";
    $.ajax({
        url: url,
        type: "POST",
        contentType: "application/json",
        data: JSON.stringify({IdJuego: IdJuego,token:token_animacion}),
        beforeSend: function () {
        },
        complete: function () {
        },
        success: function (response) {  
            //console.log(response);
            //alert("muerto");                                               
        },
        error: function (jqXHR, textStatus, errorThrown) {
        }
    });
}
function CargarEstadistica(IdJuego) {    
    var url = document.location.origin + "/" + "api/DataEventoResultadoEventoFk";
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
            //console.log(response);
            if(response.token_animacion != undefined){                
                token=response.token_animacion;                
                $.each(response.estadistica, function( key, value ) {
                    $("#"+value.TipoValorApuesta).text(value.Repetidos);
                });
                var strUltimos12="";
                var clase="caja1";
                $.each(response.resultado_evento, function( key, value ) {
                    if(key<12){
                        switch (value.valorGanador) {
                            case '12':case '19':case '21':case '9':case '16':case '3':case '1':case '23':case '5':case '7':case '18':case '14':
                                clase="caja2";
                              break;
                            case '15':case '4':case '2':case '22':case '11':case '6':case '8':case '10':case '24':case '20':case '13':case '17':
                                clase="caja1";
                              break;                            
                            default:
                                clase="caja0";
                        }
                        strUltimos12+='<tr><th class="caja">'+value.idEvento+'</th><th class="'+clase+'">'+value.valorGanador+'</th></tr>';
                    }
                });
                $("#tablaUltimos").html(strUltimos12);
            }
            else{

            }
            //setTimeout(function(){ iniciado=false; }, 10000);   
        },
        error: function (jqXHR, textStatus, errorThrown) {
        }
    });
}

function animate() {
    $("#ImgContainer").hide();
    id = requestAnimationFrame(animate);
    if (loaded) {        
        mixer.update(clock.getDelta());
        mixerCuyDudando.update(clockCuyDudando.getDelta());
        model.visible = true;        
        modelCuyDudando.visible = false;        
        modelCuyChoque.visible = false;

        //pos=Math.floor(Math.random() * (3 - 0 + 1)) + 0;
        //pos=3;
        newPos=caminar(model.position.x,model.position.z,puntos[pos].x,puntos[pos].y);  

        // if(respuesta==true){
        //     debugger
        //     caminar(0,0,puntos[pos-1].x,puntos[pos-1].y);
        // }
        // else{
        //     respuesta=caminar(0,0,puntos[pos].x,puntos[pos].y);
        // }        
        
        //console.log(model.position.x,model.position.z);  
        renderer.render(scene, camera);
    }
}
function caminar(x0,y0,x1,y1){
    //debugger
    if(flag==true){
        m=(y1-y0)/(x1-x0);
          
    }
    if(m != Infinity && m != -Infinity){
        if(x1>=0){
            x=x+0.1;
        }
        else{
            x=x-0.1;
        }
        y=m*(x-x0)+y0;
    }else{
        y=model.position.z;       
        if(y1>=0){
            y=y+0.1;
        }
        else{            
            y=y-0.1;
        }
    }
    
    model.position.x=x;
    model.position.z=y;

    calculo=(x**2)+(y**2);
    if(calculo>=9  && pos == pos1 ){
        
        pos=Math.floor(Math.random() * (3 - 0 + 1)) + 0;
        //console.log(pos1,pos);
        model.position.x=parseInt(model.position.x);
        model.position.z=parseInt(model.position.z);
        console.log(model.position.x,model.position.z);
        debugger
        flag=true;  
        //debugger
        //console.log(puntos[pos]);
    }
    else{
        if( calculo<9){
            pos1=pos;
        }
        pos=pos;
        flag=false;
    }

}
