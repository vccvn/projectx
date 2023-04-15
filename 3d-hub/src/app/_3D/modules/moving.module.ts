import * as THREE from 'three';
import {isObject, Str} from '@app/_core/helpers/utils';
import {LightLib} from '@app/_3D/libs/three.libs';
import Dom from '@app/_core/helpers/dom';
export class MovingModule {
    renderer: any;
    scene: any;
    camera: any;
    id: string;
    dom: any;
    constructor(){
        this.id = 'dom-' + Str.rand();
        this.dom = Dom("#"+this.id, {style:{display:"none"}});
        document.body.appendChild(this.dom.el);
        this.dom.css("display", "none");
        var scene = new THREE.Scene();
        var renderer = new THREE.WebGLRenderer({ antialias: true, alpha: true });
        renderer.setClearColor(0x000000, 0); // the default

        const WIDTH = 120, HEIGHT = 120;

        var self = this;
        renderer.setPixelRatio(window.devicePixelRatio);
        renderer.setSize(WIDTH, HEIGHT);
        // renderer.toneMapping = THREE.ACESFilmicToneMapping;
        renderer.outputEncoding = THREE.sRGBEncoding;
        renderer.toneMappingExposure = 0.85;
        renderer.shadowMap.enabled = true;
        renderer.shadowMap.type = THREE.PCFSoftShadowMap;
        renderer.colorManagement = true;
        

        var directionalLight = LightLib.get({
            type: "Directionallight",
            params: {
                color: "#FFE0B5",
                intensity: 1
            },
            props: {
                position: {
                    x: 6,
                    y: 3,
                    z: 3
                }
            }
        });
        scene.add(directionalLight);
        


        var camera = new THREE.PerspectiveCamera(45, WIDTH / HEIGHT, 0.25, 10000);
        camera.position.set(0, 0.3, 1.4);
        this.renderer = renderer;
        this.scene = scene;
        this.camera = camera;
        var root = document.getElementById(this.id);
        if (root) {
            root.appendChild(renderer.domElement);
        }
 
    }

    updateSize(width, height){
        this.renderer.setSize(width, height);
        let aspect = width / height;
        // this.renderer.setSize(this.width, this.height);
        this.camera.aspect = aspect;
        this.camera.updateProjectionMatrix();
    }

    updateCamera(camera){
        let propKeys = {
            position: ['x', 'y', 'z'],
            rotation: ['x', 'y', 'z'],
            up: ['x', 'y', 'z'],
            quaternion: ['x', 'y', 'z', 'z']
            
        }
        for (const key in propKeys) {
            if (Object.prototype.hasOwnProperty.call(propKeys, key)) {
                const arrKeys = propKeys[key];
                arrKeys.map(s => this.camera[key][s]=camera[key][s]);
            }
        }
        if(this.camera.fov != camera.fov || this.camera.aspect != camera.aspect){
            this.camera.fov = camera.fov;
            this.camera.aspect = camera.aspect;
            this.camera.updateProjectionMatrix();
        }
    }
    render(){
        this.renderer.render(this.scene, this.camera);
    }
    add(object){
        this.scene.add(object);
    }
    remove(object){
        this.scene.remove(object);
    }
    
}