import { assignValue, isNumber } from '@app/_core/helpers/utils';
// import Dom from '../../libs/dom.js';
import * as THREE from 'three';

import { OrbitControls } from '@app/_3D/threejs/jsm/controls/OrbitControls.js';
// import Meshes from '@app/_3D/libs/meshes';
import Dom from '@app/_core/helpers/dom';
import { Meshes } from '../libs/three.libs';
// import LoaderLib from '../libs/LoaderLib.js';
var deploy = false;
var Object2Image = (function () {
    var O2i = function () {
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


        

        var root = document.getElementById("object2image");
        if (root) {
            root.appendChild(renderer.domElement);
        }
        var camera = new THREE.PerspectiveCamera(45, WIDTH / HEIGHT, 0.25, 10000);
        camera.position.set(0, 0.3, 1.4);

        var controls = new OrbitControls(camera, renderer.domElement);
        controls.addEventListener("change", function (e) {
            render();
        });

        var ambient = new THREE.AmbientLight(0xffffff, 0.5);
        scene.add(ambient);

        var pointLight = new THREE.PointLight(0x4444cc, 0.3);
        pointLight.position.set(0, -10, 0);
        scene.add(pointLight);

        var directionallight = new THREE.DirectionalLight(0xFFE0B5, 0.4);
        assignValue(directionallight, {
            position: { x: 40, y: 40, z: 30 },
            castShadow: true,
            shadow: {
                mapSize: {
                    width: 4096,
                    height: 4096
                },
                camera: {
                    near: 0.1,
                    far: 100,
                    left: 10,
                    right: -10,
                    top: 10,
                    bottom: -10
                },
                darkness: 0.1,
                bias: -0.0002,
                radius: 5
            }
        });
        var directionallight2 = new THREE.DirectionalLight(0xFFE0B5, 0.4);
        assignValue(directionallight2, {
            position: { x: 40, y: 40, z: 30 }
        });

        scene.add(directionallight);

        scene.add(directionallight2);


        function render() {
            renderer.render(scene, camera);
        }

        this.width = WIDTH;
        this.height = HEIGHT;

        /**
         * set kích thước ảnh
         * @param {int} width do rộng ảnh
         * @param {int} height độ cao ảnh
         */
        this.setSize = function setSize(width?:any, height?:any) {
            if (!isNumber(width)) return false;
            if (!isNumber(height)) height = width;
            this.width = width;
            this.height = height;
            camera.aspect = width / height;
            camera.updateProjectionMatrix();

            renderer.setSize(width, height);

            // render();

        };

        /**
         * lấy url ảnh
         * @param {object} object doi tuong 3D
         * @param {int} width 
         * @param {int} height 
         * @returns {string}
         */
        this.getImage = function (object?:any, width?:any, height?:any) {
            this.setSize(width, height);
            if (!object) {

            }
            var obj = object.clone(true);
            obj.position.set(0, 0, 0);
            var box = new THREE.Box3().setFromObject(obj);
            box.center(obj.position); // this re-sets the mesh position
            var size = box.getSize();

            obj.position.multiplyScalar(-1);
            var pivot = new THREE.Object3D();

            pivot.add(obj);
            pivot.position.set(0, 0, 0);
            try {
                var rad = Math.PI / 8;
                var d = size.z / 2;
                var s = size.x > size.y ? size.x : size.y;
                s += s * 0.1;
                s /= 2;
                var tan = Math.tan(rad);
                var z = s / tan + d;
                camera.position.x = z * 0.7;
                camera.position.y = z * 0.2;
                camera.position.z = z;
                camera.lookAt(0, 0, 0);
            } catch (error) {
                console.log(error);
            }



            scene.add(pivot);

            render();

            var url = renderer.domElement.toDataURL();
            scene.remove(pivot);
            render();
            return url;
        };

        this.getImageByCustomSceneAndCamera = function(scene, camera, width, height){
            renderer.setSize(width, height);

            renderer.render(scene, camera);

            var url = renderer.domElement.toDataURL();

            renderer.setSize(this.width, this.height);

            return url;
        };

        this.get2DMap = function (map?:any, cropWidth?:any, cropHeight?:any) {
            if (map) {
                // map.flipY = false;
                if (cropWidth) {
                    if (!cropHeight) cropHeight = cropWidth;
                    // console.log(cropWidth, cropHeight)
                    var w = map.image.width;
                    var h = map.image.height;

                    // console.log(map.image)
                    var sw = w, sh = h;
                    var g = w / h;
                    var k = cropWidth / cropHeight;
                    if (g < k) { // vd anhr la 3:4 resize là 4:3

                        sw = cropWidth / 100;
                        sh = sw / g;
                    } else {
                        sh = cropHeight / 100;
                        sw = sh * g;
                    }

                    var mesh = Meshes.get({
                        geometry: {
                            type: "plane",
                            params: {
                                width: sw,
                                height: sh
                            }
                        },
                        material: {
                            type: "physical",
                            params: {
                                depthWrite: false,
                                side: THREE.DoubleSide,
                                map: map
                            }
                        }
                    });
                    scene.add(mesh);

                    var minImg = w > h ? h : w;
                    var minCrop = cropWidth > cropHeight ? cropHeight : cropWidth;
                    var min = minImg < minCrop ? minImg : minCrop;


                    self.setSize(cropWidth, cropHeight);

                    
                    var rad = Math.PI / 8;
                    var tan = Math.tan(rad);
                    var z = (minCrop/2/100) / tan;
                    camera.position.x = 0;
                    camera.position.y = 0;
                    camera.position.z = z;
                    // console.log(sw, sh, tan, z)
                    camera.lookAt(0, 0, 0);

                    scene.add(mesh);

                    render();
                    var url = renderer.domElement.toDataURL();
                    scene.remove(mesh);
                    render();
                    return url;
                } else {

                    var width = map.image.width;
                    var height = map.image.height;
                    var g = width / height;

                    if(height > 1000 || width > 1000){
                        if(g > 1){
                            width = 1000;
                            height = width / g;
                        }else{
                            height = 1000;
                            width = height * g;
                        }
                        return this.get2DMap(map, width, height);
                    }

                    var w = width, h = height;
                    
                    
                    var min = w > h ? h : w;

                    this.setSize(min, min);
                    var rad = Math.PI / 8;
                    var tan = Math.tan(rad);
                    var z = min / tan;
                    camera.position.x = 0;
                    camera.position.y = 0;
                    camera.position.z = z;
                    camera.lookAt(0, 0, 0);
                    var mesh = Meshes.get({
                        geometry: {
                            type: "plane",
                            params: {
                                width: w,
                                height: h
                            }
                        },
                        material: {
                            type: "physical",
                            params: {
                                depthWrite: false,
                                side: THREE.DoubleSide,
                                map: map
                            }
                        }
                    });
                    scene.add(mesh);

                    render();
                    var url = renderer.domElement.toDataURL();
                    scene.remove(mesh);
                    render();
                    return url;

                }
                


            }
            // test
            // console.log('end');
            return null;
        };



        this.resizeImage = function (dataURL?:any, width?:any, height?:any, callback?:any) {
            var url = null;

            var map = new THREE.Texture();
            var image = document.createElement('img');;
            image.src = dataURL;
            image.onload = function () {
                map.image = image;
                // JPEGs can't have an alpha channel, so memory can be saved by storing them as RGB.
                const isJPEG = dataURL.search(/\.jpe?g($|\?)/i) > 0 || dataURL.search(/^data\:image\/jpeg/) === 0;

                map.format = isJPEG ? THREE.RGBFormat : THREE.RGBAFormat;
                map.needsUpdate = true;

                var w = map.image.width;
                var h = map.image.height;

                var sw = w, sh = h;
                var g = w / h;
                var k = width / height;
                if (g < k) { // vd anhr la 3:4 resize là 4:3

                    sw = width;
                    sh = w / g;
                } else {
                    sh = height;
                    sw = sh * g;
                }

                var mesh = Meshes.get({
                    geometry: {
                        type: "plane",
                        params: {
                            width: sw,
                            height: sh
                        }
                    },
                    material: {
                        type: "physical",
                        params: {
                            depthWrite: false,
                            side: THREE.DoubleSide,
                            map: map
                        }
                    }
                });
                scene.add(mesh);


                var minImg = w > h ? h : w;
                var minCrop = width > height ? height : width;
                var min = minImg < minCrop ? minImg : minCrop;


                self.setSize(width, height);

                var rad = Math.PI / 8;
                var tan = Math.tan(rad);
                var z = minCrop / tan;
                camera.position.x = 0;
                camera.position.y = 0;
                camera.position.z = z;
                camera.lookAt(0, 0, 0);

                render();

                url = renderer.domElement.toDataURL();
                scene.remove(mesh);
                render();
                if (typeof callback == "function") {
                    callback(url);
                }


            }

            return null;
        };


    };

    if (!deploy) {
        deploy = true;
        var imgDom = Dom("#object2image", null, { style: { display: "nome" } });
        // window['objimgdom'] = imgDom;
        document.body.appendChild(imgDom.el);
        imgDom.css("display", "none");
    }
    return new O2i();
}());

export default Object2Image;

export { Object2Image };