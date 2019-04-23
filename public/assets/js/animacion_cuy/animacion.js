
$.LoadingOverlay("show");
$(".loadingoverlay").css("background-color","rgba(255, 255, 255, 0.2)");

// IPSERVIDOR_WEBSOCKETS="35.237.182.107";
// PUERTO_WEBSOCKETS="888";
IPSERVIDOR_WEBSOCKETS="192.168.1.60";
PUERTO_WEBSOCKETS="50051";

GANADOR_DE_EVENTO="";
iniciado = false;
token="";  /// en consultarevento obtiene valor 
EVENTO_ID="";
ARRAY_PUNTOSCAJAS=[];

ARRAY_PUNTOSCAJAS.push({nombre:26,posicion:{x:-0.30980586278363836,y:0,z:-3.3762877429185947} })
ARRAY_PUNTOSCAJAS.push({nombre:3,posicion:{x:-0.949006568309034,y:0,z:-3.356998701580594}})
ARRAY_PUNTOSCAJAS.push({nombre:35,posicion:{x:-1.4167106765152129,y:0,z:-3.1356755102510894} })
ARRAY_PUNTOSCAJAS.push({nombre:12,posicion:{x:-1.8540938062507262,y:0,z:-2.791641244935619} })
///29 28                                   
ARRAY_PUNTOSCAJAS.push({nombre:28,posicion:{x:-2.3978601268406794,y:0,z:-2.467785601362559}})
ARRAY_PUNTOSCAJAS.push({nombre:7,posicion:{x:-2.765080554750653,y:0,z:-2.0221378996133974} })
ARRAY_PUNTOSCAJAS.push({nombre:29,posicion:{x:-2.9853090380374905,y:0,  z:-1.541500347580593} })
ARRAY_PUNTOSCAJAS.push({nombre:18,posicion:{x:-3.224733808882785,y:0,z:-0.9138055339476931} })
ARRAY_PUNTOSCAJAS.push({nombre:22,posicion:{x:-3.4912757475952065,y:0,z:-0.44938379926419136} })
ARRAY_PUNTOSCAJAS.push({nombre:9,posicion:{x:-3.476497,  y:0 , z:0.23360957} })
ARRAY_PUNTOSCAJAS.push({nombre:31,posicion:{x:-3.35743326 ,y:0,z:0.7374220786} })
ARRAY_PUNTOSCAJAS.push({nombre:14,posicion:{x:-3.28769929 ,y:0,z:1.28942981} })
ARRAY_PUNTOSCAJAS.push({nombre:20,posicion:{x: -2.8653985,y:0,z:1.736809} })
ARRAY_PUNTOSCAJAS.push({nombre:1,posicion:{x:-2.51463235,y:0,z:2.18843981} })
ARRAY_PUNTOSCAJAS.push({nombre:33,posicion:{x: -2.18747530,y:0,z:2.60356937} })
ARRAY_PUNTOSCAJAS.push({nombre:16,posicion:{x: -1.593648, y:0,z:2.85932161} })
///24´
ARRAY_PUNTOSCAJAS.push({nombre:24,posicion:{x:-1.088638265020644,y:0,z:3.2145740703933443} })
ARRAY_PUNTOSCAJAS.push({nombre:5,posicion:{x:-0.5348062371620586,y:0,z:3.301620951663683} })
ARRAY_PUNTOSCAJAS.push({nombre:10,posicion:{x:-0.02302394273425558,y:0,z:3.5234013240937334}    })
ARRAY_PUNTOSCAJAS.push({nombre:23,posicion:{x:0.5254609302769983,y:0,z:3.3041370243871855} })
ARRAY_PUNTOSCAJAS.push({nombre:8,posicion:{x:1.1413224681962724,y:0,z:3.2268432103527904} })
ARRAY_PUNTOSCAJAS.push( { nombre:30 ,posicion:{x:1.6125922448708456,y:0,z:2.9984823398983607}  }   )
ARRAY_PUNTOSCAJAS.push( { nombre:11 ,posicion:{x:2.164808512786406,y:0,z:2.7421715169359664}  }   )
ARRAY_PUNTOSCAJAS.push( { nombre:36 ,posicion:{x:2.651818597146128,y:0,z:2.3733912998766367} }   )
ARRAY_PUNTOSCAJAS.push( { nombre:13 ,posicion:{x:2.9243464869306433,y:0,z:1.831102276556383}  }   )
ARRAY_PUNTOSCAJAS.push( { nombre:27 ,posicion:{x:3.0508343404937066,y:0,z:1.2188483240919867}   }   )
ARRAY_PUNTOSCAJAS.push( { nombre:6 ,posicion:{x:3.32875742450882,y:0,z:0.7543380207997183}  }   )
ARRAY_PUNTOSCAJAS.push( { nombre:34 ,posicion:{x:3.377377358498914,y:0,z:0.12394453640106479}  }   )
ARRAY_PUNTOSCAJAS.push( { nombre:17 ,posicion:{x:3.4183559221406865,y:0,z:-0.36684366594296364}  }   )
ARRAY_PUNTOSCAJAS.push( { nombre:25 ,posicion:{x:3.263097590331593,y:0,z:-0.9840921494909135}  }   )

ARRAY_PUNTOSCAJAS.push( { nombre:2 ,posicion: {x:3.037643184345156,y:0,z:-1.5227852729244755} }   )
ARRAY_PUNTOSCAJAS.push( { nombre:21 ,posicion:{x:2.7196177221423063,y:0,z:-1.959217585937729}  }   )
ARRAY_PUNTOSCAJAS.push( { nombre:4 ,posicion: {x:2.3607702253224208,y:0,z:-2.3638512662486857} }   )
ARRAY_PUNTOSCAJAS.push( { nombre:19 ,posicion: {x:2.002183195861022,y:0,z:-2.910166458303999} }   )
ARRAY_PUNTOSCAJAS.push( { nombre:15 ,posicion:{x:1.448259415771182,y:0,z:-3.172386117998001} }   )
ARRAY_PUNTOSCAJAS.push( { nombre:32 ,posicion: {x:0.931038104276527,y:0,z:-3.348998139977028} }   )

ARRAY_PUNTOSCAJAS.push( { nombre:0 ,posicion: {x:0.21479664977962323,y:0,z:-2.8940485718326103} }   )

$(document).ready(function () {
    // CargarEstadistica(1);
});

if (WEBGL.isWebGLAvailable() === false) {
    document.body.appendChild(WEBGL.getWebGLErrorMessage());
}
var scene, renderer, camera, stats;
var model, modelCajaP,modelCuyDudando, modelChoque, modelCaja, skeleton, mixer, mixerCaja,mixerCuyDudando,mixerCajaP, clock;
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

INICIAR_RENDER();

function INICIAR_RENDER() {
    clock = new THREE.Clock();
    clockCuyDudando = new THREE.Clock();
    clockCajaP = new THREE.Clock();
    clockCuyChoque = new THREE.Clock();
    var container = document.getElementById('container');
    camera = new THREE.PerspectiveCamera(60, window.innerWidth / window.innerHeight, 1, 100);
    camera.position.set(0, 10, 0);
//coontroles 
    //controls
    controls = new THREE.OrbitControls(camera);
    controls.rotateSpeed = 1.0;
    controls.zoomSpeed = 1.2;
    controls.panSpeed = 0.8;

    //escena
    scene = new THREE.Scene();
    scene.background = new THREE.Color(0xa0a0a0);
    scene.fog = new THREE.Fog(0xa0a0a0, 10, 50);
    var hemiLight = new THREE.HemisphereLight(0xffffff, 0x444444);
    hemiLight.position.set(0, 20, 0);
    scene.add(hemiLight);
    var dirLight = new THREE.DirectionalLight(0xffffff);
    dirLight.position.set(-3, 15, -10);
    dirLight.castShadow = true;
    dirLight.shadow.camera.top = 2;
    dirLight.shadow.camera.bottom = -2;
    dirLight.shadow.camera.left = -2;
    dirLight.shadow.camera.right = 2;
    dirLight.shadow.camera.near = 0.1;
    dirLight.shadow.camera.far = 40;

    dirLight.shadow.mapSize.height=2048;
    dirLight.shadow.mapSize.height=2048;
    scene.add(dirLight);
    // var axesHelper = new THREE.AxesHelper( 5,5,5 );
    // scene.add( axesHelper );
    // controls = new THREE.OrbitControls(camera);
     controls.autoRotate = true;
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
    CAJAS_ARRAY = [];
    var loaderCaja = new THREE.GLTFLoader();
    // $.LoadingOverlay("show");
    loaderCaja.load('images/cajasFFF.glb', function (gltfCaja) {
        
        modelCaja = gltfCaja.scenes[0];
        modelCaja.traverse(function (object) {
            if (object instanceof THREE.Mesh) {
                object.castShadow = true;
            }
        });
        modelCaja.scale.set(0.005, 0.005, 0.005);

        // modelCaja.position.z=0.8


        modelCaja.name ="TABLA_CAJAS";
        //modelCaja.position.set(-15,0,0);
        scene.add(modelCaja);
        skeleton = new THREE.SkeletonHelper(modelCaja);
        cargar_archivos();
        modelCaja.children[0].children[0].rotation.y = 180 * (Math.PI / 180); ////rotar cajas para que caja X verde este arriba

        modelCaja.children[0].children[1].receiveShadow=true;
        CAJAS_ARRAY = modelCaja.children[0].children[0].children;  /// 0 1 => MADERAS   2=>caja verde  ,  3=> 32, 4 => 15 ...
    });
    renderer = new THREE.WebGLRenderer({antialias: true});
    renderer.setPixelRatio(window.devicePixelRatio);
    renderer.setSize(window.innerWidth, window.innerHeight);
    renderer.gammaOutput = true;
    renderer.gammaFactor = 2.2;
    renderer.shadowMap.enabled = true;
    container.appendChild(renderer.domElement);
}



CONSULTADO_EVENTO=false;
function CargarEstadistica(IdJuego) {    
    var url = document.location.origin + "/" + "api/DataEventoResultadoEventoFk";
    $.ajax({
        url: url,
        type: "POST",
        contentType: "application/json",
        data: JSON.stringify({IdJuego: IdJuego}),
        beforeSend: function () {
          CONSULTADO_EVENTO=true;
        },
        complete: function () {
        },
        success: function (response) { 

               ocultar_toasr_nohay_evento();
               ocultar_toasr_servidor_error()
                
            CONSULTADO_EVENTO=false;
            aaa=response;        
            token=response.token_animacion;             
            $.each(response.estadistica, function( key, value ) {
                $("#"+value.valorapuesta).text(value.Repetidos);
                $("#"+value.valorapuesta).prev().css("background-color",value.rgb)
                $("#"+value.valorapuesta).prev().css("color",value.rgbLetra)


            });
            var strUltimos12="";
            $.each(response.resultado_evento, function( key, value ) {
                if(key<12){
                          strUltimos12+='<tr><th class="caja">'+value.idEvento+'</th><th style="color:'+value.rgbLetra+';background-color:'+value.rgb+'">'+value.valorGanador+'</th></tr>';
                }
            });
            $("#tablaUltimos").html(strUltimos12);


            $("#imagen_cargando").hide();
            $.LoadingOverlay("hide");

            if(typeof response.evento!="undefined"){
                if(response.evento.evento_id_actual!=""){
                    EVENTO_ACTUAL=response.evento;

                    EVENTO_ID= EVENTO_ACTUAL.evento_id_actual;
                    GANADOR_DE_EVENTO = EVENTO_ACTUAL.evento_valor_ganador;
                    TIEMPO_GIRO_CAJA=4000;//EVENTO_ACTUAL.tiempo_giro_caja;
                    TIEMPO_CUY = 20000;//EVENTO_ACTUAL.tiempo_cuy_moviendo;
                    $("#termotetro_para_iniciar").show();

                    if(socket!=null && socket.readyState==1){
                          inicio_pedir_hora=performance.now();
                          pedir_hora=true;
                          timeout_pedir_hora=setInterval(function(){
                                if(pedir_hora){
                                    crear_toastr_websockets_error();
                                }
                                else{
                                    clearInterval(timeout_pedir_hora);
                                }
                          },1000);
                          console.warn("YA CONECTADO, pedir hora");
                          pedir_hora_server();///INICIO_ANIMACION_CUY despues de recibir hora de servidor
                    }
                    else{
                          console.warn("INICIANDO CONEXIÓN ");
                          CONECTADO__A_SERVIDORWEBSOCKET=false;
                          inicio_intento_conexion=performance.now();
                          connectarWebSockets(IPSERVIDOR_WEBSOCKETS,PUERTO_WEBSOCKETS);  ///en archivo ClaseWebSockets.js
                            revisar_ya_conecto=setInterval(function(){
                                    if(CONECTADO__A_SERVIDORWEBSOCKET){
                                        if(typeof toasr_websockets_error!="undefined"){
                                            toasr_websockets_error.hide();
                                        }
                                        clearInterval(revisar_ya_conecto);
                                    }
                                    else{
                                       crear_toastr_websockets_error();
                                    }
                            },1000);
                    }   
                }
                else{

                    crear_toasr_nohay_evento();
               
                  console.warn("No hay evento activo");
                  setTimeout(function(){
                    CargarEstadistica(1);
                  },1000)
                }
            }////fin if eresponse evento
        },
        error: function (jqXHR, textStatus, errorThrown) {
          CONSULTADO_EVENTO=false;
         ocultar_toasr_nohay_evento();
          crear_toasr_servidor_error();
          setTimeout(function(){
            CargarEstadistica(1);
          }
            ,1500)

        }
    });
}

function crear_toastr_websockets_error(){
    if(typeof toasr_websockets_error=="undefined"){
        toastr.options = {
          timeOut: 0,
          extendedTimeOut: 0,
          tapToDismiss: false
        };
        toasr_websockets_error=toastr.error("Conectando a Servidor...");
    }
    else{
        toasr_websockets_error.show()}
}

function crear_toasr_nohay_evento(){
  if(typeof toasr_nohay_evento=="undefined"){
                                toastr.options = {
                                  timeOut: 0,
                                  extendedTimeOut: 0,
                                  tapToDismiss: false
                                };
                                toasr_nohay_evento=toastr.error("No hay Evento Activo...");
                            }
            else{toasr_nohay_evento.show()}
}

function crear_toasr_servidor_error(){
  if(typeof toasr_servidor_error=="undefined"){
                                toastr.options = {
                                  timeOut: 0,
                                  extendedTimeOut: 0,
                                  tapToDismiss: false
                                };
                                toasr_servidor_error=toastr.error("Error Servidor...");
                            }
            else{toasr_servidor_error.show()}
}
function ocultar_toasr_nohay_evento(){
    if(typeof toasr_nohay_evento!="undefined"){
                    toasr_nohay_evento.hide();
                }
}
function ocultar_toasr_servidor_error(){ 
     if(typeof toasr_servidor_error!="undefined"){
        toasr_servidor_error.hide();
    }
}
