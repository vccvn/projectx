(window["webpackJsonp"] = window["webpackJsonp"] || []).push([["common"],{

/***/ "5qT6":
/*!*****************************************************!*\
  !*** ./src/app/_3D/engines/client-editor.engine.ts ***!
  \*****************************************************/
/*! exports provided: default, ClientEditorEngine */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "ClientEditorEngine", function() { return ClientEditorEngine; });
/* harmony import */ var _app_core_helpers_es5_class__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @app/_core/helpers/es5.class */ "pIPj");
/* harmony import */ var _app_core_helpers_utils__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! @app/_core/helpers/utils */ "KgG6");
/* harmony import */ var _traits_scene__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ../traits/scene */ "MqQv");
/* harmony import */ var _traits_camera__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ../traits/camera */ "Rvip");
/* harmony import */ var _traits_renderer__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! ../traits/renderer */ "EzGa");
/* harmony import */ var _traits_controls__WEBPACK_IMPORTED_MODULE_5__ = __webpack_require__(/*! ../traits/controls */ "lHzP");
/* harmony import */ var _traits_grid_helper__WEBPACK_IMPORTED_MODULE_6__ = __webpack_require__(/*! ../traits/grid-helper */ "sSy8");
/* harmony import */ var _traits_lights__WEBPACK_IMPORTED_MODULE_7__ = __webpack_require__(/*! ../traits/lights */ "VmS1");
/* harmony import */ var _traits_object_manager__WEBPACK_IMPORTED_MODULE_8__ = __webpack_require__(/*! ../traits/object-manager */ "Wq+f");
/* harmony import */ var _libs_event_dispatcher__WEBPACK_IMPORTED_MODULE_9__ = __webpack_require__(/*! ../libs/event-dispatcher */ "VEC7");
/* harmony import */ var _libs_three_libs__WEBPACK_IMPORTED_MODULE_10__ = __webpack_require__(/*! ../libs/three.libs */ "Mijg");
/* harmony import */ var _libs_models__WEBPACK_IMPORTED_MODULE_11__ = __webpack_require__(/*! ../libs/models */ "R/UD");
/* harmony import */ var _modules_loader__WEBPACK_IMPORTED_MODULE_12__ = __webpack_require__(/*! ../modules/loader */ "gZBz");
/* harmony import */ var _modules_composer__WEBPACK_IMPORTED_MODULE_13__ = __webpack_require__(/*! ../modules/composer */ "RyQi");
/* harmony import */ var _modules_dynamic_shadows__WEBPACK_IMPORTED_MODULE_14__ = __webpack_require__(/*! ../modules/dynamic-shadows */ "N5rU");
/* harmony import */ var _traits_floor__WEBPACK_IMPORTED_MODULE_15__ = __webpack_require__(/*! ../traits/floor */ "aEml");
















const ClientEditorEngine = Object(_app_core_helpers_es5_class__WEBPACK_IMPORTED_MODULE_0__["default"])("ClientEditorEngine").uses(_traits_scene__WEBPACK_IMPORTED_MODULE_2__["default"], _traits_camera__WEBPACK_IMPORTED_MODULE_3__["default"], _traits_renderer__WEBPACK_IMPORTED_MODULE_4__["default"], _traits_controls__WEBPACK_IMPORTED_MODULE_5__["default"], _libs_models__WEBPACK_IMPORTED_MODULE_11__["default"], _traits_lights__WEBPACK_IMPORTED_MODULE_7__["default"], _traits_object_manager__WEBPACK_IMPORTED_MODULE_8__["default"], _traits_floor__WEBPACK_IMPORTED_MODULE_15__["Floor"], _libs_event_dispatcher__WEBPACK_IMPORTED_MODULE_9__["EventDispatcher"], _traits_grid_helper__WEBPACK_IMPORTED_MODULE_6__["default"])({
    data: {},
    options: {},
    Mesh: {},
    Geometry: {},
    Material: {},
    Light: {},
    Composer: {},
    Shadows: {},
    inited: false,
    $controlEngine: null,
    setData: function (data) {
        if (data.composer && !Object(_app_core_helpers_utils__WEBPACK_IMPORTED_MODULE_1__["isEmpty"])(data.composer)) {
            this.composer = new _modules_composer__WEBPACK_IMPORTED_MODULE_13__["default"](this, data.composer);
        }
        if (data.lights && Object(_app_core_helpers_utils__WEBPACK_IMPORTED_MODULE_1__["isArray"])(data.lights)) {
            this.addLights(data.lights);
        }
        if (data.models && Object(_app_core_helpers_utils__WEBPACK_IMPORTED_MODULE_1__["isArray"])(data.models)) {
            this.addModels(data.models);
        }
        if (data.meshes && Object(_app_core_helpers_utils__WEBPACK_IMPORTED_MODULE_1__["isArray"])(data.meshes)) {
            this.addMeshes(data.meshes);
        }
        if (data.objects && (Object(_app_core_helpers_utils__WEBPACK_IMPORTED_MODULE_1__["isArray"])(data.objects) || Object(_app_core_helpers_utils__WEBPACK_IMPORTED_MODULE_1__["isObject"])(data.objects))) {
            this.addObjects(data.objects);
        }
        else {
            this.emit("object.load.completed");
        }
        if (data.grids && Object(_app_core_helpers_utils__WEBPACK_IMPORTED_MODULE_1__["isArray"])(data.grids)) {
            this.addGrids(data.grids);
        }
        if (data.cameras && Object(_app_core_helpers_utils__WEBPACK_IMPORTED_MODULE_1__["isArray"])(data.cameras)) {
            this.addCameras(data.cameras);
        }
        if (data.floor && Object(_app_core_helpers_utils__WEBPACK_IMPORTED_MODULE_1__["isArray"])(data.floor)) {
            this.addFloor(data.floor);
        }
        if (data.controls && Object(_app_core_helpers_utils__WEBPACK_IMPORTED_MODULE_1__["isArray"])(data.controls)) {
            this.addControls(data.controls);
        }
        this.updateSettings();
        this.emit('setdata', data);
    },
    /**
     * Hàm khởi tạo
     * @param {Dom} viewport
     * @param {*} data
     */
    constructor: function (data) {
        if (data && Object(_app_core_helpers_utils__WEBPACK_IMPORTED_MODULE_1__["isObject"])(data)) {
            this.data = data;
        }
        this.Geometry = _libs_three_libs__WEBPACK_IMPORTED_MODULE_10__["Geometries"];
        this.Material = _libs_three_libs__WEBPACK_IMPORTED_MODULE_10__["Materials"];
        this.Mesh = _libs_three_libs__WEBPACK_IMPORTED_MODULE_10__["Meshes"];
        this.Light = _libs_three_libs__WEBPACK_IMPORTED_MODULE_10__["LightLib"];
        this.Loader = new _modules_loader__WEBPACK_IMPORTED_MODULE_12__["default"](this);
        var self = this;
        var focusIn = false;
        this.on('pointerdown', function (e) {
            self.canChangeCamera = false;
            focusIn = true;
        }, false);
        document.addEventListener('pointerup', function (e) {
            if (focusIn) {
                self.canChangeCamera = true;
                focusIn = false;
            }
        }, false);
        this.on("object.added", function (e) {
            if (Object(_app_core_helpers_utils__WEBPACK_IMPORTED_MODULE_1__["isObject"])(self.controlEngine) && self.controlEngine.refresh) {
                self.controlEngine.refresh();
            }
        });
    },
    renew: function (data) {
        this.data = Object(_app_core_helpers_utils__WEBPACK_IMPORTED_MODULE_1__["assignValue"])({}, data);
        this.inited = false;
        this.emit({
            type: "renew"
        });
    },
    updateSettings: function () {
        if (this.data) {
            var data = this.data;
            if (Object(_app_core_helpers_utils__WEBPACK_IMPORTED_MODULE_1__["isObject"])(data.scene)) {
                var scene = data.scene;
                this.updateSceneSettings(scene);
                if (Object(_app_core_helpers_utils__WEBPACK_IMPORTED_MODULE_1__["isObject"])(scene.background) && !Object(_app_core_helpers_utils__WEBPACK_IMPORTED_MODULE_1__["isEmpty"])(scene.background))
                    this.setBackground(scene.background);
                if (Object(_app_core_helpers_utils__WEBPACK_IMPORTED_MODULE_1__["isObject"])(scene.floor) && !Object(_app_core_helpers_utils__WEBPACK_IMPORTED_MODULE_1__["isEmpty"])(scene.floor))
                    this.updateSceneFloorSetting(scene.floor);
                if (Object(_app_core_helpers_utils__WEBPACK_IMPORTED_MODULE_1__["isObject"])(scene.size) && !Object(_app_core_helpers_utils__WEBPACK_IMPORTED_MODULE_1__["isEmpty"])(scene.size))
                    this.updateSceneSettings(scene.size);
            }
            if (Object(_app_core_helpers_utils__WEBPACK_IMPORTED_MODULE_1__["isObject"])(data.shadow))
                this.updateShadowSettings(data.shadow);
            if (Object(_app_core_helpers_utils__WEBPACK_IMPORTED_MODULE_1__["isObject"])(data.control))
                this.updateControlSettings(data.control);
            if (Object(_app_core_helpers_utils__WEBPACK_IMPORTED_MODULE_1__["isObject"])(data.camera))
                this.updateMainCameraSettings(data.camera, true);
        }
    },
    reset: function (data_) {
        if (Object(_app_core_helpers_utils__WEBPACK_IMPORTED_MODULE_1__["isObject"])(data_))
            this.data = Object(_app_core_helpers_utils__WEBPACK_IMPORTED_MODULE_1__["assignValue"])({}, data_);
        this.resetObjects();
        this.resetLights();
        this.updateSettings();
        this.setData(this.data);
        this.emit({
            type: "reset"
        });
    },
    startup: function startup(data) {
        if (this.inited)
            return this;
        if (data && Object(_app_core_helpers_utils__WEBPACK_IMPORTED_MODULE_1__["isObject"])(data)) {
            this.data = data;
        }
        this.Shadows = new _modules_dynamic_shadows__WEBPACK_IMPORTED_MODULE_14__["default"](this, this.data.shadow || this.data.shadows || {});
        this.emit('startup', this.data);
        this.initScene(this.data.scene || {});
        this.setMainCamera(this.data.camera || {});
        this.createRenderer(this.data.renderer || {}, this.data.shadow ? this.data.shadow.enabled : true);
        this.camera.updateProjectionMatrix();
        this.setMainControl(this.data.control || {});
        this.updateSettings();
        var self = this;
        this.inited = true;
        // this.Shadows.init();
        self.ready();
        if (!this.autoRenderStatus) {
            setTimeout(function () {
                self.render();
            }, 500);
        }
        return this;
    },
    canChangeCamera: true,
    setControlEngine: function (controlEngine) {
        if (!Object(_app_core_helpers_utils__WEBPACK_IMPORTED_MODULE_1__["isObject"])(controlEngine) || this.controlEngine == controlEngine)
            return false;
        this.controlEngine = controlEngine;
        controlEngine.setMainEngine(this);
        var self = this;
        controlEngine.on("controls.change.camera", function (e) {
            self.changeCameraByControlEngine(e.camera);
        });
        controlEngine.refresh();
        setTimeout(() => {
            controlEngine.refresh();
        }, 10000);
    },
    changeCameraByControlEngine: function (camera) {
        if (this.canChangeCamera) {
            var mainPosition = this.camera.position;
            var ctrlPosition = camera.position;
            var mainX = mainPosition.x, mainY = mainPosition.y, mainZ = mainPosition.z;
            var ctrlX = ctrlPosition.x, ctrlY = ctrlPosition.y, ctrlZ = ctrlPosition.z;
            var mainDistance = Math.sqrt(Math.pow(mainX, 2) + Math.pow(mainY, 2) + Math.pow(mainZ, 2));
            var ctrlDistance = Math.sqrt(Math.pow(ctrlX, 2) + Math.pow(ctrlY, 2) + Math.pow(ctrlZ, 2));
            var ratio = mainDistance / ctrlDistance;
            mainPosition.x = ctrlPosition.x * ratio;
            mainPosition.y = ctrlPosition.y * ratio;
            mainPosition.z = ctrlPosition.z * ratio;
            this.camera.lookAt(0, 0, 0);
            if (this.control.highPerformance && this.controlCanTurnOffShadow) {
                this.startDeactiveShadowTimer(500, "control");
            }
            this.refresh();
        }
    }
});
/* harmony default export */ __webpack_exports__["default"] = (ClientEditorEngine);



/***/ }),

/***/ "eHQE":
/*!********************************************!*\
  !*** ./src/app/_3D/libs/project-editor.ts ***!
  \********************************************/
/*! exports provided: ProjectEditor, default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "ProjectEditor", function() { return ProjectEditor; });
/* harmony import */ var three__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! three */ "Womt");
/* harmony import */ var _app_core_helpers_es5_class__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! @app/_core/helpers/es5.class */ "pIPj");
/* harmony import */ var _event_dispatcher__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./event-dispatcher */ "VEC7");
/* harmony import */ var _client_editor__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ./client-editor */ "YzNs");




const Editor__ = Object(_app_core_helpers_es5_class__WEBPACK_IMPORTED_MODULE_1__["_class"])("ProjectEditor").extends(_client_editor__WEBPACK_IMPORTED_MODULE_3__["default"]).uses(_event_dispatcher__WEBPACK_IMPORTED_MODULE_2__["EventDispatcher"])({
    constructor: function constructor(app, engine) {
        this.lightHelperStatus = false;
        this.setup(app, engine);
        this.startup2();
    },
    startup2: function () {
        var scope = this;
        this.on("dbclick", onDblClick);
        function onDblClick(event) {
            var rect = scope.engine.wrapper.getBoundingClientRect();
            scope.onDownPosition.x = event.clientX - rect.left;
            scope.onDownPosition.y = event.clientY - rect.top;
            const pointer = new three__WEBPACK_IMPORTED_MODULE_0__["Vector2"]();
            pointer.x = (scope.onDownPosition.x / rect.width) * 2 - 1;
            pointer.y = -(scope.onDownPosition.y / rect.height) * 2 + 1;
            const detectObj = scope.selectMeshByPointer(pointer);
            if (detectObj) {
                scope.emit({
                    type: "select:mesh",
                    mesh: detectObj
                });
            }
        }
    }
});
const ProjectEditor = Editor__;
/* harmony default export */ __webpack_exports__["default"] = (ProjectEditor);


/***/ })

}]);
//# sourceMappingURL=common-es2015.js.map