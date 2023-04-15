import { assignValue, assignWithout, date, getTimeStamp, isNumber, isObject, queueTask } from '@app/_core/helpers/utils';
import * as THREE from 'three';

import Props, { parseParams } from '../libs/props';
import { registerAnimationTask } from '../libs/animation-loop';
import Object2Image from '../modules/object-image';

// import self.animation from '../libs/animation-loop';

const Renderer = {
    width: 300,
    height: 300,
    aspect: 1,
    renderer: null,
    composer: null,
    fps: 0,
    wrapper: null,


    animationTasks: null,



    /**
     * @var {boolean} autoRenderMode Tự động gửi yêu cầu tạo hoạt cảnh
     */
    autoRenderMode: false,
    autoRenderStatus: false,
    autoRenderTimerStatus: false,
    autoRenderTimerStart: false,
    autoRenderCountdown: 0,
    autoRenderTimerMilisecond: 3000,
    autoRenderDistance: 10,
    controlChangeAnimateStatus: false,

    deactiveShadowStatus: false,
    deactiveShadowTimeMstart: false,
    deactiveShadowTimeMilisecond: 5000,
    deactiveShadowTimeMilisecondHP: 1000,
    deactiveShadowTimeCountdown: 0,


    wheelAnimationStatus: false,
    wheelAnimationTimeMstart: false,
    wheelAnimationTimeMilisecond: 500,
    wheelAnimationTimeCountdown: 300,


    autoRenderQueueTask: null,
    inWrapper: false,
    pointerPosition: {
        x: 0,
        y: 0
    },
    pointerStart: false,

    lastAnimateData: "0",
    currentAnimateData: "1",
    controlCanUpdate: true,
    controlCanTurnOffShadow: true,


    animation: null,

    boots: ["renderBoot"],

    /**
     * chạy các thiết lập khi đối tượng dc khởi tạo
     */
    renderBoot: function () {
        this.animation = registerAnimationTask(this.getInstanceID())
        this.pointerPosition = {
            x: 0,
            y: 0
        };
        var self = this;

        this.animationTasks = {
            animate: function animate() {
                if (!self.autoRenderStatus) return false;
                if (self.control && (self.control.enableDamping || (self.data && self.data.control.enableDamping)) && typeof self.control.update == "function" && !self.controlChangingByFPSStatus) {
                    self.control.update();
                }
                self.render();
            },
            timeoutAnimate: function () {
                // this.render();
                if (self.autoRenderCountdown > 0) {
                    if (self.control && (self.control.enableDamping || (self.data && self.data.control.enableDamping)) && typeof self.control.update == "function") {
                        self.control.update();
                    }

                    self.render();
                    var currentTime = getTimeStamp();
                    // self.wrapper.showMessage("time: " + currentTime + ", " + "time left: " + (self.autoRenderCountdown - (currentTime - self.autoRenderTimerStart)))
                    if (self.autoRenderTimerStatus && currentTime - self.autoRenderTimerStart >= self.autoRenderCountdown) {
                        self.autoRenderTimerStatus = false;
                        self.autoRenderCountdown = 0;
                        self.animation.remove("timeoutAnimate");
                    }

                }
            },

            controlChangeAnimate: function () {
                // this.render();
                if (self.control && (self.control.enableDamping || (self.data && self.data.control.enableDamping)) && typeof self.control.update == "function") {
                    self.control.update();
                }
                self.render();

                var d: any = {
                    position: assignValue({}, self.camera.position),
                    // quaternion: assignValue({}, self.camera.quaternion),
                    rotation: assignValue({}, self.camera.rotation)
                };
                var c = JSON.stringify(d);
                if (c == self.lastAnimateData) {
                    self.controlChangeAnimateStatus = false;
                    self.animation.remove("controlChangeAnimate");
                    self.emit("controls.change.camera.animate.end");
                }

                self.lastAnimateData = self.currentAnimateData;
                self.currentAnimateData = c;
                self.emit({
                    type: "controls.change.camera",
                    camera: self.camera
                });

            },

            activeShadowAfter: function () {
                var currentTime = getTimeStamp();
                var cond = self.deactiveShadowStatus && (
                    (self.deactiveShadowMode == "system" && self.controlEnableDamping && self.lastAnimateData == self.currentAnimateData) ||
                    currentTime - self.deactiveShadowTimeMstart >= self.deactiveShadowTimeCountdown
                );
                if (cond) {
                    self.deactiveShadowStatus = false;
                    self.deactiveShadowTimeCountdown = 0;
                    if (self.controlCanTurnOffShadow) {
                        self.Shadows.restore();
                        self.refresh();

                    }
                    self.animation.remove("activeShadowAfter");

                    self.deactiveShadowMode = "system";
                    if(typeof self.deactiveCompleteHandle == "function"){
                        self.deactiveCompleteHandle();
                        self.deactiveCompleteHandle = null;
                    }
                }
            },

            wheelAnimation: function () {
                var currentTime = getTimeStamp();

                if (self.wheelAnimationStatus && (currentTime - self.wheelAnimationTimeMstart >= self.wheelAnimationTimeCountdown)) {
                    self.wheelAnimationStatus = false;
                    self.wheelAnimationTimeCountdown = 0;

                    self.controlCanTurnOffShadow = true;

                    self.animation.remove("wheelAnimation");

                    if (!self.deactiveShadowStatus) {
                        self.Shadows.restore();
                        self.refresh();

                    }
                }
            }
        };

    },



    render: function () {
        if (this.composer != null) {
            this.composer.render();
        } else if (this.renderer) {
            this.renderer.render(this.scene, this.camera);
            if (this.showSceneHelper && this.sceneHelper) {
                this.renderer.render(this.sceneHelper, this.camera);
            }
        }
        return this;
    },


    refresh: function () {
        if (this.autoRenderStatus || (this.autoRenderTimerStatus && this.autoRenderCountdown)) return false;
        this.render();
    },

    capture: function(){
        this.hideGridHelper();
        var imageCaptured = Object2Image.getImageByCustomSceneAndCamera(this.scene, this.camera, this.width, this.height);
        this.showGridHelper()
        return imageCaptured;
    },

    createRenderer: function (opts?: any) {
        var self = this;
        var opt = typeof opts == "object" ? opts : {};
        Props.parse(opt);
        var params = isObject(opt.params) ? opt.params : { antialias: true };

        var renderer = new THREE.WebGLRenderer(params);
            renderer.setPixelRatio(window.devicePixelRatio);
            renderer.setSize(window.innerWidth, window.innerHeight);
            renderer.toneMapping = THREE.ACESFilmicToneMapping;
            renderer.toneMappingExposure = 1;
            renderer.outputEncoding = THREE.sRGBEncoding;
            
            renderer.shadowMap.enabled = this.data.shadow.enabled?true:false;
            renderer.shadowMap.type = THREE.PCFSoftShadowMap;
        
            // container.appendChild(renderer.domElement);

        this.renderer = renderer;


        if (this.wrapper) {
            var rect = this.wrapper.getBoundingClientRect();
            var width = rect.width;
            var height = rect.height;
            this.setSize(width || "screen", height || undefined);
        } else {
            this.setSize(opt.width || "screen", opt.height || undefined);
        }

        return this;
    },

    updateShadowSettings: function (setting) {
        if (isObject(setting)) {
            var oldEnabled = this.data.shadow.enabled;
            var oldPcss = this.data.shadow.pcss;

            assignValue(this.data.shadow, setting);
            for (const key in setting) {
                if (Object.prototype.hasOwnProperty.call(setting, key)) {
                    const vl = setting[key];
                    if (key == "enabled") {
                        this.renderer.shadowMap.enabled = vl;
                    } else if (key == "pcss") {
                        if (oldEnabled) {
                            if (vl) {
                                this.Shadows.active();
                            } else {
                                this.Shadows.deactive();
                            }
                        } else if (!vl) {
                            this.Shadows.deactive();
                        }
                    }
                }
            }

        }
    },

    start: function () {
        var self = this;
        this.emit('start');
        if (!self.animation.has("animate", self.animationTasks.animate))
            self.animation.add("animate", self.animationTasks.animate);
    },

    ready: function () {
        var self = this;

        this.emit('ready', {
            renderer: this.renderer, scene: this.scene, camera: this.camera
        }, true);

        if (this.data.autoStart || this.data.autoRefresh || this.data.autoAnimate || (this.data.renderer && (this.data.renderer.autoStart || this.data.renderer.autoRefresh || this.data.renderer.autoAnimate))) {
            this.autoRenderStatus = true;
            this.autoRenderMode = true;

            this.start();
        } else {


            this.render();
        };

        var wrapper = this.wrapper;
        function start(e) {
            if (self.controlCanUpdate) {

                if (self.control.autoUpdateScene && !self.autoRenderMode) {
                    if (!self.controlChangeAnimateStatus) {
                        // nếu có dumping
                        if (self.controlEnableDamping && !self.autoRenderStatus) {
                            // self.control.enableDamping = true;
                            // nếu có hiệu năng cao thì tắt dổ bóng
                            if (self.control.highPerformance && self.controlCanTurnOffShadow) {
                                self.startDeactiveShadowTimer(self.deactiveShadowTimeMilisecond, "system");
                            }
                            // self.startChangeAnimate(self.autoRenderTimerMilisecond);
                        }
                        else {
                            // nếu có hiệu năng cao thì tắt dổ bóng
                            if (self.control.highPerformance && self.controlCanTurnOffShadow) {
                                self.startDeactiveShadowTimer(self.deactiveShadowTimeMilisecondHP, "system");
                            }
                        }
                    }
                    else if (self.controlCanTurnOffShadow) {
                        self.startDeactiveShadowTimer(self.deactiveShadowTimeMilisecond, "system");
                    }


                }

            }
            // self.startDeactiveShadowTimer(self.deactiveShadowTimeMilisecond);
        }
        function move(e) {
            if (self.controlCanUpdate) {

                if (self.control.autoUpdateScene && !self.autoRenderMode) {
                    if (!self.controlChangeAnimateStatus) {
                        // nếu có dumping
                        if (self.controlEnableDamping && !self.autoRenderStatus) {
                            self.control.enableDamping = true;
                            // nếu có hiệu năng cao thì tắt dổ bóng
                            if (self.control.highPerformance && self.controlCanTurnOffShadow) {
                                self.startDeactiveShadowTimer(self.deactiveShadowTimeMilisecond, "system");
                            }
                            self.startChangeAnimate(self.autoRenderTimerMilisecond);
                        }
                        else {
                            // nếu có hiệu năng cao thì tắt dổ bóng
                            if (self.control.highPerformance && self.controlCanTurnOffShadow) {
                                self.startDeactiveShadowTimer(self.deactiveShadowTimeMilisecondHP, "system");
                            }
                            self.refresh();
                            self.emit({
                                type: "controls.change.camera",
                                camera: self.camera
                            });
                        }
                    }
                    else if (self.controlCanTurnOffShadow) {
                        self.startDeactiveShadowTimer(self.deactiveShadowTimeMilisecond, "system");
                    }


                }

            }
        }
        function end(e) {
            self.emit("controls.change.camera.end");
        }
        if (this.control) {
            this.control.addEventListener('start', start);
            this.control.addEventListener('change', move);
            this.control.addEventListener('end', end);

        }

        this.on('wheel', function (event) {
            self.startWheelAnimate();
        })


        return this;
    },



    setWrapper: function setWrapper(wrapperElement: Element) {
        this.wrapper = wrapperElement;
        this.wrapper.appendChild(this.getCanvas());
        this.updateCanvasSize();
        var self = this;
        // setTimeout(function(){
        //     self.updateCanvasSize();
        // }, 10);


    },

    getCanvas: function getCanvas() {
        return this.renderer.domElement;
    },

    setSize: function (width?: any, height?: any) {
        this.emit('setSize', width, height);
        if (typeof width == "undefined") {
            return this;
        }
        if (width == "screen") {
            this.width = window.innerWidth;
            this.height = window.innerHeight;
            
        } else if (isNumber(width) && width > 0) {
            this.width = Number(width);
            this.height = isNumber(height) ? Number(height) : this.width;
        }
        else if (document.getElementById(width)) {
            var el = document.getElementById(width);
            var w = el.clientWidth;
            var h = el.clientHeight;
            this.width = Number(w);
            this.height = isNumber(h) ? Number(h) : this.width;

        }

        this.aspect = this.width / this.height;
        this.renderer.setSize(this.width, this.height);
        this.camera.aspect = this.aspect;
        this.camera.updateProjectionMatrix();
        this.emit('size.setted', width, height);
        return this;
    },

    updateCanvasSize(e?: any): boolean {
        if (this.data.renderer.autoResize || typeof this.data.renderer.autoResize == "undefined") {
            this.width = window.innerWidth;
            this.height = window.innerHeight;

            if (this.wrapper) {
                var rect = this.wrapper.getBoundingClientRect();
                var width = rect.width;
                var height = rect.height;
                if (isNumber(width) && width > 0) {
                    this.width = width;
                    this.height = height;
                }
            }
            this.aspect = this.width / this.height;
            this.renderer.setSize(this.width, this.height);
            this.camera.aspect = this.aspect;
            this.camera.updateProjectionMatrix();

            this.refresh();
            this.emit('canvas.size.update', e);
            return true;

        } else {
            // this.emit('resize', e);

            return false;
        }
    },

    windowResize: function (e) {
        var status = this.updateCanvasSize(e);

        if (status) {
            this.emit('resize', e);
            this.refresh();
        } else {
            this.emit('resize', e);
        }

        return this;
    },

    updateWrapperSize: function () {

    },

    /**
     * khởi dộng trình auto render
     * @param {int} timer thời gian render tự dộng
     * @param {int} checkDistance thời gian cách nhau giữa 2 lần kiềm tra trạng thái
     */
    startAnimateTimer: function (timer?: any, checkDistance?: any) {
        var self = this;
        self.autoRenderTimerStart = getTimeStamp();
        // this.wrapper.showMessage("time: " + self.autoRenderTimerStart)
        if (self.autoRenderCountdown <= 0) {
            this.autoRenderTimerStatus = true;

            if (!self.animation.has("timeoutAnimate", self.animationTasks.timeoutAnimate)) {
                self.animation.add("timeoutAnimate", self.animationTasks.timeoutAnimate);
            }

            // console.log('start: ' + date('time'));
        }
        self.autoRenderCountdown = timer;
    },

    /**
     * khởi dộng trình auto render
     * @param {int} timer thời gian render tự dộng
     * @param {int} checkDistance thời gian cách nhau giữa 2 lần kiềm tra trạng thái
     */
    startChangeAnimate: function () {
        var self = this;
        if (!this.controlChangeAnimateStatus) {
            // this.render();
            this.controlChangeAnimateStatus = true;
            if (!self.animation.has("controlChangeAnimate", self.animationTasks.controlChangeAnimate)) {
                self.animation.add("controlChangeAnimate", self.animationTasks.controlChangeAnimate);
            }
        }
    },

    /**
     * khởi dộng trình auto render
     * @param {int} timer thời gian render tự dộng
     * @param {int} checkDistance thời gian cách nhau giữa 2 lần kiềm tra trạng thái
     */
    startWheelAnimate: function () {
        var self = this;
        this.wheelAnimationTimeMstart = getTimeStamp();
        if (!this.wheelAnimationStatus) {
            self.controlCanTurnOffShadow = false;
            self.wheelAnimationTimeCountdown = 300;
            // this.render();
            this.wheelAnimationStatus = true;
            if (!self.animation.has("wheelAnimation", self.animationTasks.wheelAnimation)) {
                self.Shadows.off();
                self.animation.add("wheelAnimation", self.animationTasks.wheelAnimation);
            }
        }
    },
    deactiveShadowMode: "system",
    deactiveCompleteHandle: null,
    /**
     * khởi dộng trình auto render
     * @param {int} timer thời gian render tự dộng
     * @param {int} checkDistance thời gian cách nhau giữa 2 lần kiềm tra trạng thái
     */
    startDeactiveShadowTimer: function (timer?: any, mode?:string, onComplete?:()=>any) {
        var self = this;
        self.deactiveShadowTimeMstart = getTimeStamp();
        if(typeof onComplete == "function") self.deactiveCompleteHandle = onComplete;
        if(mode) this.deactiveShadowMode = mode;
        // this.wrapper.showMessage("time: " + self.autoRenderTimerStart)
        if (!this.deactiveShadowStatus) {
            this.deactiveShadowStatus = true;
            if (!self.animation.has("activeShadowAfter", self.animationTasks.activeShadowAfter)) {
                if (self.controlCanTurnOffShadow) {
                    self.Shadows.off();
                }
                self.animation.add("activeShadowAfter", self.animationTasks.activeShadowAfter);
            }
        }
        self.deactiveShadowTimeCountdown = self.deactiveShadowTimeCountdown > timer?self.deactiveShadowTimeCountdown:timer;
    }
};

export default Renderer;