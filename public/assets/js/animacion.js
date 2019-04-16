GANADOR_DE_EVENTO="";
iniciado = false;
token="";  /// en consultarevento obtiene valor
anguloRotacion=0;
i=0;
x=0;
m=0;
id=0;
//puntos=[{x:2.5,y:0},{x:-2.5,y:0},{x:0,y:2.5},{x:0,y:-2.5},{x:0,y:0}];
puntos=[{x:0.3,y:2.48},{x:0.7,y:2.4},{x:1.1,y:2.32},{x:1.4,y:-2.07},{x:1.7,y:1.83},{x:2,y:1.5},{x:2.2,y:1.18},{x:2.4,y:0.7},{x:2.47,y:0.38},
        {x:2.49,y:-0.22},{x:2.45,y:-0.49},{x:2.3,y:-0.98},{x:2.15,y:-1.27},{x:1.88,y:1.64},{x:1.5,y:-2.0},{x:1.2,y:-2.19},{x:0.9,y:-2.33},{x:0.45,y:-2.45},
        {x:0,y:-2.5},{x:-0.4,y:-2.46},{x:-0.84,y:-2.35},{x:-1.21,y:-2.18},{x:-1.6,y:-1.92},{x:-1.93,y:1.58},{x:-2.06,y:-1.41},{x:-2.3,y:-0.98},{x:-2.41,y:-0.63},{x:-2.49,y:-0.19},
        {x:-2.47,y:0.37},{x:-2.38,y:0.76},{x:-2.18,y:1.21},{x:-2.0,y:1.5},{x:-1.74,y:-1.79},{x:-1.3,y:2.13},{x:-1.03,y:2.27},{x:-0.63,y:2.41},{x:-0.25,y:2.48},{x:0,y:0}];
flag=true;
posF=3;
posF1=3;
posO=37;
entrar=false;


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

$(document).ready(function () {
    var i=0;
    //$("#ImgContainer").css("background-image", "url('images/fondo_inicio.jpg')");
    CargarEstadistica(1);
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
    //relojes
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
        //modelCaja.children[0].scale.set(1, 1, 1);
        CAJAS_ARRAY = modelCaja.children[0].children[0].children;  /// 0 1 => MADERAS   2=>caja verde  ,  3=> 32, 4 => 15 ...
        //modelCaja.children[0].scale.set(1, 1, 1);  

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
        
        mixerCajaP.update(clockCajaP.getDelta());
        modelCajaP.visible=true;
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
       
        //         default:
        //         // code block
        //     }
        // }
        renderer.render(scene, camera);
    }
}

function iniciar(numeorGanador) {  
    
    setTimeout(function(){ entrar=true; }, 15000);
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
            buscando_evento=true;
        },
        complete: function () {
        },
        success: function (response) {

            EVENTORESPONSE=response;
            if(response.token_animacion != undefined){       
                i=i+1;
                token=response.token_animacion;                
                $.each(response.estadistica, function( key, value ) {
                    $("#"+value.TipoValorApuesta).text(value.Repetidos);
                    $("#"+value.TipoValorApuesta).prev().css("background-color",value.rgb)
                });
                var strUltimos12="";
                var clase="caja1";
                $.each(response.resultado_evento, function( key, value ) {
                     if(key<12){
                        strUltimos12+='<tr><th class="caja">'+value.idEvento+'</th><th style="background-color:'+value.rgb+'">'+value.valorGanador+'</th></tr>';
                    }
                });
                $("#tablaUltimos").html(strUltimos12);
                iniciado = true;
                $("#idevento_titulo").text(response.evento_id_actual);
                $("#progreso").show();
                $("#barra_loading").css("height","100%");


                buscando_evento=false;
                clearInterval(intervalo_revisar_evento);
                GANADOR_DE_EVENTO=response.evento_valor_ganador;
                iniciar_juego();
                cajagirando_animacion();
               // iniciar(response.evento_valor_ganador);
               //iniciar_juego();
               //iniciar_cuy();

            }
            else{
                buscando_evento=false;
            }
            //setTimeout(function(){ iniciado=false; }, 10000);   
        },
        error: function (jqXHR, textStatus, errorThrown) {
                buscando_evento=false;

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
            //console.log(response);
            if(response.token_animacion != undefined){                
                token=response.token_animacion;                
                $.each(response.estadistica, function( key, value ) {
                    $("#"+value.TipoValorApuesta).text(value.Repetidos);
                    $("#"+value.TipoValorApuesta).prev().css("background-color",value.rgb)

                });
                var strUltimos12="";
                var clase="caja1";
                $.each(response.resultado_evento, function( key, value ) {
                         if(key<12){
                    //     switch (value.valorGanador) {
                    //         case '12':case '19':case '21':case '9':case '16':case '3':case '1':case '23':case '5':case '7':case '18':case '14':
                    //             clase="caja2";
                    //           break;
                    //         case '15':case '4':case '2':case '22':case '11' :case '6':case '8':case '10':case '24':case '20':case '13':case '17':
                    //             clase="caja1";
                    //           break;                            
                    //         default:
                    //             clase="caja0";
                    //     }
                        //strUltimos12+='<tr><th class="caja">'+value.idEvento+'</th><th class="'+clase+'">'+value.valorGanador+'</th></tr>';
                        strUltimos12+='<tr><th class="caja">'+value.idEvento+'</th><th style="background-color:'+value.rgb+'">'+value.valorGanador+'</th></tr>';
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
        mixerCajaP.update(clockCajaP.getDelta());
       
        
        model.visible = true;  
        modelCajaP.visible = true;
        modelCuyDudando.visible = true;        
        modelCuyDudando.scale.set(0.1,0.1,0.1);
        modelCuyDudando.position.x=-0.25;
        modelCuyDudando.position.z=2.48;       
        modelCuyChoque.visible = false;
        //Math.sqrt(6.25-(0.5)**2)
        //pos=Math.floor(Math.random() * (3 - 0 + 1)) + 0;
        //pos=3;
        if(clockCajaP.getElapsedTime()<8){

        }else{
            //model.lookAt(-2.5,0,0) ;
            //model.rotateY(1.5708) ; 
            //model.rotation._y   
            modelCajaP.visible = false;
            model.lookAt(puntos[posF].x,0,puntos[posF].y)
            if(entrar==true){
                caminar(puntos[posO].x,puntos[posO].y,puntos[posF].x,puntos[posF].y);  
            }else{
                caminar(puntos[posO].x,puntos[posO].y,puntos[posF].x,puntos[posF].y);             
            }
            //console.log(puntos[posF].x,puntos[posF].y);             
        }

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
    if(flag==true){
        m=(y1-y0)/(x1-x0);  
        x=parseFloat(x0).toFixed(2);
        desplazamienoX=(x1-x0)/30;
        desplazamienoY=(y1-y0)/30;
    }
    if(m != Infinity && m != -Infinity && isNaN(m)==false ){
        if(x1>=x0){
            x=parseFloat(x)+0.05;
            //x=parseFloat(x)+desplazamienoX;
        }
        else{
            x=parseFloat(x)-0.05;
            //x=parseFloat(x)-desplazamienoX;
        }    
        y=m*(x-x0)+y0;
    }else{
        y=model.position.z;       
        if(y1>=y0){
            y=y+0.05;
            //y=y + desplazamienoY;
        }
        else{            
            y=y-0.05
            //y=y - desplazamienoY;
        }
    }    
    console.log(desplazamienoX,desplazamienoY);
    //console.log(x,y);
    y=parseFloat(y).toFixed(2);
    x=parseFloat(x).toFixed(2);       
    model.position.x=parseFloat(x);
    model.position.z=parseFloat(y);
    //calculo=(x**2)+(y**2);
    calculo=(Math.pow(x,2) )+(Math.pow(x,2) );
    if(calculo>=6.25  ){ 
        if(entrar==true){
//            debugger
            cancelAnimationFrame(id);
        }
        // i=1;
        // while (i<1000) {
        //     console.log(123);
        //     i++;
        // }   
        posO=posF;
        while(posO==posF){
            posF=Math.floor(Math.random() * (36 - 0 + 1)) + 0;
        }              
        flag=true;  
    }
    else{        
        flag=false;
    }

}
