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

init();

function init() {
    clock = new THREE.Clock();
    clockCuyDudando = new THREE.Clock();
    clockCajaP = new THREE.Clock();
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
    // var axesHelper = new THREE.AxesHelper( 5,5,5 );
    // scene.add( axesHelper );
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
    CAJAS_ARRAY = [];
    var loaderCaja = new THREE.GLTFLoader();
    $.LoadingOverlay("show");
    loaderCaja.load('images/cajasFFF.glb', function (gltfCaja) {
        
        modelCaja = gltfCaja.scenes[0];
        modelCaja.traverse(function (object) {
            if (object instanceof THREE.Mesh) {
                object.castShadow = true;
            }
        });
        modelCaja.scale.set(0.005, 0.005, 0.005);
        modelCaja.name ="TABLA_CAJAS";
        //modelCaja.position.set(-15,0,0);
        scene.add(modelCaja);
        skeleton = new THREE.SkeletonHelper(modelCaja);
        cargar_archivos();
        modelCaja.children[0].children[0].rotation.y = 180 * (Math.PI / 180); ////rotar cajas para que caja X verde este arriba
        //modelCaja.children[0].children[0].position.y = 410
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




function CerrarEvento(IdJuego,token_animacion,IdEvento) {
    var url = document.location.origin + "/" + "api/ConfirmacionToken";
    $.ajax({
        url: url,
        type: "POST",
        contentType: "application/json",
        data: JSON.stringify({IdJuego: IdJuego,token:token_animacion
            ,IdEvento:EVENTO_ID}),
        beforeSend: function () {
        },
        complete: function () {
        },
        success: function (response) {  
          //  windows.reload()
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
            aaa=response;        
            //if(response.evento.token_animacion != undefined){                
                token=response.token_animacion;                
                $.each(response.estadistica, function( key, value ) {
                    $("#"+value.valorapuesta).text(value.Repetidos);
                    $("#"+value.valorapuesta).prev().css("background-color",value.rgb)

                });
                var strUltimos12="";
                var clase="caja1";
                $.each(response.resultado_evento, function( key, value ) {
                    if(key<12){
                              strUltimos12+='<tr><th class="caja">'+value.idEvento+'</th><th style="background-color:'+value.rgb+'">'+value.valorGanador+'</th></tr>';
                    }
                });
                $("#tablaUltimos").html(strUltimos12);
            //}
            //else{
            //}
                if(typeof response.evento!="undefined"){
                        EVENTO_ID= response.evento.evento_id_actual;
                        GANADOR_DE_EVENTO = response.evento_valor_ganador;
                        TIEMPO_GIRO_CAJA=10000;
                        TIEMPO_CUY = 20000;
                        $("#termotetro_para_iniciar").show();

                        EVENTO_ACTUAL=response.evento;

                          if(socket!=null && socket.readyState==1){
                                console.warn("YA CONECTADO, pedir hora")
                                 pedir_hora_server();
                         }else{
                              console.warn("INICIANDO CONEXIÓN ");
                                connectarWebSockets(IPSERVIDOR_WEBSOCKETS,PUERTO_WEBSOCKETS);  ///en archivo ClaseWebSockets.js
                         }   
                        //pedir_hora_server();

                        ahora=moment(new Date());//.format("YYYY-MM-DD HH:mm:ss a");

                       //  FECHA_FIN_EVENTO=response.evento.fecha_evento_fin_actual;
                       //  FECHA_FIN_EVENTO=moment(FECHA_FIN_EVENTO, "YYYY-MM-DD HH:mm:ss a");
                       //  segundos_finevento=FECHA_FIN_EVENTO.diff(ahora,'seconds');

                       //  FECHA_ANIMACION=response.evento.fecha_animacion;
                       //  FECHA_ANIMACION=moment(FECHA_ANIMACION, "YYYY-MM-DD HH:mm:ss a");
                       //  console.info(moment(FECHA_ANIMACION).format("YYYY-MM-DD HH:mm:ss a"));
                       //  console.info(moment(ahora).format("YYYY-MM-DD HH:mm:ss a"));
                       //  segundos_total=FECHA_ANIMACION.diff(ahora,'seconds');
                       //  console.info(segundos_total);
                      

                       // if(segundos_total>0){ ///fuera rango animacion
                       //       con_segundos=0;
                       //         //$("#barra_loading_tpi").css("width","14%");
                       //         intervalo_loading_inicio=setInterval(function(){
                       //              porcentaje=(con_segundos*100)/segundos_total;
                       //              //console.warn(porcentaje);
                       //              $("#barra_loading_tpi").css("width",(porcentaje)+"%");
                       //              if(porcentaje==100){
                       //                  clearInterval(intervalo_loading_inicio);
                       //                  $("#idevento_titulo").text(EVENTO_ID);
                       //                  $("#barra_loading").css("height","100%");
                       //                  fechaFinEvento=response.fecha_evento_fin_actual;
                       //                  $("#termotetro_para_iniciar").hide();
                       //                  buscando_evento=false;
                       //                  GANADOR_DE_EVENTO = response.evento.evento_valor_ganador;
                       //                  TIEMPO_GIRO_CAJA=4500;
                       //                  TIEMPO_CUY = 20000;
                       //                  INICIO_ANIMACION_CUY();////////////////////////////////////////
                       //              }
                       //              con_segundos=con_segundos+0.5;
                       //         },1000)
                       // }else{
                       //  console.log("esperando fecha fin evento actual,para recargar");
                       //      iii=0;
                       //      intervalo_fin_evento=setInterval(function(){
                       //          if(iii>segundos_finevento){
                       //              CargarEstadistica(1);
                       //              clearInterval(intervalo_fin_evento);
                       //          }
                       //          iii++;
                       //     },1000);
                       // } 
                      
                }


        },
        error: function (jqXHR, textStatus, errorThrown) {
        }
    });
}


