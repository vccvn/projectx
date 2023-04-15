(function () {
  (window["webpackJsonp"] = window["webpackJsonp"] || []).push([["default~project-page-project-module~template-page-template-module"], {
    /***/
    "5qT6": function qT6(module, __webpack_exports__, __webpack_require__) {
      "use strict";

      __webpack_require__.r(__webpack_exports__);
      /* harmony export (binding) */


      __webpack_require__.d(__webpack_exports__, "ClientEditorEngine", function () {
        return ClientEditorEngine;
      });
      /* harmony import */


      var _app_core_helpers_es5_class__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(
      /*! @app/_core/helpers/es5.class */
      "pIPj");
      /* harmony import */


      var _app_core_helpers_utils__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(
      /*! @app/_core/helpers/utils */
      "KgG6");
      /* harmony import */


      var _traits_scene__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(
      /*! ../traits/scene */
      "MqQv");
      /* harmony import */


      var _traits_camera__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(
      /*! ../traits/camera */
      "Rvip");
      /* harmony import */


      var _traits_renderer__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(
      /*! ../traits/renderer */
      "EzGa");
      /* harmony import */


      var _traits_controls__WEBPACK_IMPORTED_MODULE_5__ = __webpack_require__(
      /*! ../traits/controls */
      "lHzP");
      /* harmony import */


      var _traits_grid_helper__WEBPACK_IMPORTED_MODULE_6__ = __webpack_require__(
      /*! ../traits/grid-helper */
      "sSy8");
      /* harmony import */


      var _traits_lights__WEBPACK_IMPORTED_MODULE_7__ = __webpack_require__(
      /*! ../traits/lights */
      "VmS1");
      /* harmony import */


      var _traits_object_manager__WEBPACK_IMPORTED_MODULE_8__ = __webpack_require__(
      /*! ../traits/object-manager */
      "Wq+f");
      /* harmony import */


      var _libs_event_dispatcher__WEBPACK_IMPORTED_MODULE_9__ = __webpack_require__(
      /*! ../libs/event-dispatcher */
      "VEC7");
      /* harmony import */


      var _libs_three_libs__WEBPACK_IMPORTED_MODULE_10__ = __webpack_require__(
      /*! ../libs/three.libs */
      "Mijg");
      /* harmony import */


      var _libs_models__WEBPACK_IMPORTED_MODULE_11__ = __webpack_require__(
      /*! ../libs/models */
      "R/UD");
      /* harmony import */


      var _modules_loader__WEBPACK_IMPORTED_MODULE_12__ = __webpack_require__(
      /*! ../modules/loader */
      "gZBz");
      /* harmony import */


      var _modules_composer__WEBPACK_IMPORTED_MODULE_13__ = __webpack_require__(
      /*! ../modules/composer */
      "RyQi");
      /* harmony import */


      var _modules_dynamic_shadows__WEBPACK_IMPORTED_MODULE_14__ = __webpack_require__(
      /*! ../modules/dynamic-shadows */
      "N5rU");
      /* harmony import */


      var _traits_floor__WEBPACK_IMPORTED_MODULE_15__ = __webpack_require__(
      /*! ../traits/floor */
      "aEml");

      var ClientEditorEngine = Object(_app_core_helpers_es5_class__WEBPACK_IMPORTED_MODULE_0__["default"])("ClientEditorEngine").uses(_traits_scene__WEBPACK_IMPORTED_MODULE_2__["default"], _traits_camera__WEBPACK_IMPORTED_MODULE_3__["default"], _traits_renderer__WEBPACK_IMPORTED_MODULE_4__["default"], _traits_controls__WEBPACK_IMPORTED_MODULE_5__["default"], _libs_models__WEBPACK_IMPORTED_MODULE_11__["default"], _traits_lights__WEBPACK_IMPORTED_MODULE_7__["default"], _traits_object_manager__WEBPACK_IMPORTED_MODULE_8__["default"], _traits_floor__WEBPACK_IMPORTED_MODULE_15__["Floor"], _libs_event_dispatcher__WEBPACK_IMPORTED_MODULE_9__["EventDispatcher"], _traits_grid_helper__WEBPACK_IMPORTED_MODULE_6__["default"])({
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
        setData: function setData(data) {
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
          } else {
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
        constructor: function constructor(data) {
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
        renew: function renew(data) {
          this.data = Object(_app_core_helpers_utils__WEBPACK_IMPORTED_MODULE_1__["assignValue"])({}, data);
          this.inited = false;
          this.emit({
            type: "renew"
          });
        },
        updateSettings: function updateSettings() {
          if (this.data) {
            var data = this.data;

            if (Object(_app_core_helpers_utils__WEBPACK_IMPORTED_MODULE_1__["isObject"])(data.scene)) {
              var scene = data.scene;
              this.updateSceneSettings(scene);
              if (Object(_app_core_helpers_utils__WEBPACK_IMPORTED_MODULE_1__["isObject"])(scene.background) && !Object(_app_core_helpers_utils__WEBPACK_IMPORTED_MODULE_1__["isEmpty"])(scene.background)) this.setBackground(scene.background);
              if (Object(_app_core_helpers_utils__WEBPACK_IMPORTED_MODULE_1__["isObject"])(scene.floor) && !Object(_app_core_helpers_utils__WEBPACK_IMPORTED_MODULE_1__["isEmpty"])(scene.floor)) this.updateSceneFloorSetting(scene.floor);
              if (Object(_app_core_helpers_utils__WEBPACK_IMPORTED_MODULE_1__["isObject"])(scene.size) && !Object(_app_core_helpers_utils__WEBPACK_IMPORTED_MODULE_1__["isEmpty"])(scene.size)) this.updateSceneSettings(scene.size);
            }

            if (Object(_app_core_helpers_utils__WEBPACK_IMPORTED_MODULE_1__["isObject"])(data.shadow)) this.updateShadowSettings(data.shadow);
            if (Object(_app_core_helpers_utils__WEBPACK_IMPORTED_MODULE_1__["isObject"])(data.control)) this.updateControlSettings(data.control);
            if (Object(_app_core_helpers_utils__WEBPACK_IMPORTED_MODULE_1__["isObject"])(data.camera)) this.updateMainCameraSettings(data.camera, true);
          }
        },
        reset: function reset(data_) {
          if (Object(_app_core_helpers_utils__WEBPACK_IMPORTED_MODULE_1__["isObject"])(data_)) this.data = Object(_app_core_helpers_utils__WEBPACK_IMPORTED_MODULE_1__["assignValue"])({}, data_);
          this.resetObjects();
          this.resetLights();
          this.updateSettings();
          this.setData(this.data);
          this.emit({
            type: "reset"
          });
        },
        startup: function startup(data) {
          if (this.inited) return this;

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
          this.inited = true; // this.Shadows.init();

          self.ready();

          if (!this.autoRenderStatus) {
            setTimeout(function () {
              self.render();
            }, 500);
          }

          return this;
        },
        canChangeCamera: true,
        setControlEngine: function setControlEngine(controlEngine) {
          if (!Object(_app_core_helpers_utils__WEBPACK_IMPORTED_MODULE_1__["isObject"])(controlEngine) || this.controlEngine == controlEngine) return false;
          this.controlEngine = controlEngine;
          controlEngine.setMainEngine(this);
          var self = this;
          controlEngine.on("controls.change.camera", function (e) {
            self.changeCameraByControlEngine(e.camera);
          });
          controlEngine.refresh();
          setTimeout(function () {
            controlEngine.refresh();
          }, 10000);
        },
        changeCameraByControlEngine: function changeCameraByControlEngine(camera) {
          if (this.canChangeCamera) {
            var mainPosition = this.camera.position;
            var ctrlPosition = camera.position;
            var mainX = mainPosition.x,
                mainY = mainPosition.y,
                mainZ = mainPosition.z;
            var ctrlX = ctrlPosition.x,
                ctrlY = ctrlPosition.y,
                ctrlZ = ctrlPosition.z;
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
      /* harmony default export */

      __webpack_exports__["default"] = ClientEditorEngine;
      /***/
    },

    /***/
    "eHQE": function eHQE(module, __webpack_exports__, __webpack_require__) {
      "use strict";

      __webpack_require__.r(__webpack_exports__);
      /* harmony export (binding) */


      __webpack_require__.d(__webpack_exports__, "ProjectEditor", function () {
        return ProjectEditor;
      });
      /* harmony import */


      var _threejs_three_module_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(
      /*! ../threejs/three.module.js */
      "27o/");
      /* harmony import */


      var _app_core_helpers_es5_class__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(
      /*! @app/_core/helpers/es5.class */
      "pIPj");
      /* harmony import */


      var _event_dispatcher__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(
      /*! ./event-dispatcher */
      "VEC7");
      /* harmony import */


      var _client_editor__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(
      /*! ./client-editor */
      "YzNs");

      var Editor__ = Object(_app_core_helpers_es5_class__WEBPACK_IMPORTED_MODULE_1__["_class"])("ProjectEditor")["extends"](_client_editor__WEBPACK_IMPORTED_MODULE_3__["default"]).uses(_event_dispatcher__WEBPACK_IMPORTED_MODULE_2__["EventDispatcher"])({
        constructor: function constructor(app, engine) {
          this.lightHelperStatus = false;
          this.setup(app, engine);
          this.startup2();
        },
        startup2: function startup2() {
          var scope = this;
          this.on("dbclick", onDblClick);

          function onDblClick(event) {
            var rect = scope.engine.wrapper.getBoundingClientRect();
            scope.onDownPosition.x = event.clientX - rect.left;
            scope.onDownPosition.y = event.clientY - rect.top;
            var pointer = new _threejs_three_module_js__WEBPACK_IMPORTED_MODULE_0__["Vector2"]();
            pointer.x = scope.onDownPosition.x / rect.width * 2 - 1;
            pointer.y = -(scope.onDownPosition.y / rect.height) * 2 + 1;
            var detectObj = scope.selectMeshByPointer(pointer);

            if (detectObj) {
              scope.emit({
                type: "select:mesh",
                mesh: detectObj
              });
            }
          }
        }
      });
      var ProjectEditor = Editor__;
      /* harmony default export */

      __webpack_exports__["default"] = ProjectEditor;
      /***/
    },

    /***/
    "j/Uu": function jUu(module, __webpack_exports__, __webpack_require__) {
      "use strict";

      __webpack_require__.r(__webpack_exports__);
      /* harmony export (binding) */


      __webpack_require__.d(__webpack_exports__, "createElementClass", function () {
        return createElementClass;
      });
      /* harmony export (binding) */


      __webpack_require__.d(__webpack_exports__, "Html", function () {
        return Html;
      });
      /* harmony export (binding) */


      __webpack_require__.d(__webpack_exports__, "A", function () {
        return A;
      });
      /* harmony export (binding) */


      __webpack_require__.d(__webpack_exports__, "Abbr", function () {
        return Abbr;
      });
      /* harmony export (binding) */


      __webpack_require__.d(__webpack_exports__, "Acronym", function () {
        return Acronym;
      });
      /* harmony export (binding) */


      __webpack_require__.d(__webpack_exports__, "Address", function () {
        return Address;
      });
      /* harmony export (binding) */


      __webpack_require__.d(__webpack_exports__, "Applet", function () {
        return Applet;
      });
      /* harmony export (binding) */


      __webpack_require__.d(__webpack_exports__, "Area", function () {
        return Area;
      });
      /* harmony export (binding) */


      __webpack_require__.d(__webpack_exports__, "Article", function () {
        return Article;
      });
      /* harmony export (binding) */


      __webpack_require__.d(__webpack_exports__, "Aside", function () {
        return Aside;
      });
      /* harmony export (binding) */


      __webpack_require__.d(__webpack_exports__, "Audio", function () {
        return Audio;
      });
      /* harmony export (binding) */


      __webpack_require__.d(__webpack_exports__, "B", function () {
        return B;
      });
      /* harmony export (binding) */


      __webpack_require__.d(__webpack_exports__, "Base", function () {
        return Base;
      });
      /* harmony export (binding) */


      __webpack_require__.d(__webpack_exports__, "Basefont", function () {
        return Basefont;
      });
      /* harmony export (binding) */


      __webpack_require__.d(__webpack_exports__, "Bb", function () {
        return Bb;
      });
      /* harmony export (binding) */


      __webpack_require__.d(__webpack_exports__, "Bdo", function () {
        return Bdo;
      });
      /* harmony export (binding) */


      __webpack_require__.d(__webpack_exports__, "Big", function () {
        return Big;
      });
      /* harmony export (binding) */


      __webpack_require__.d(__webpack_exports__, "Blockquote", function () {
        return Blockquote;
      });
      /* harmony export (binding) */


      __webpack_require__.d(__webpack_exports__, "Body", function () {
        return Body;
      });
      /* harmony export (binding) */


      __webpack_require__.d(__webpack_exports__, "Br", function () {
        return Br;
      });
      /* harmony export (binding) */


      __webpack_require__.d(__webpack_exports__, "Button", function () {
        return Button;
      });
      /* harmony export (binding) */


      __webpack_require__.d(__webpack_exports__, "Canvas", function () {
        return Canvas;
      });
      /* harmony export (binding) */


      __webpack_require__.d(__webpack_exports__, "Caption", function () {
        return Caption;
      });
      /* harmony export (binding) */


      __webpack_require__.d(__webpack_exports__, "Center", function () {
        return Center;
      });
      /* harmony export (binding) */


      __webpack_require__.d(__webpack_exports__, "Cite", function () {
        return Cite;
      });
      /* harmony export (binding) */


      __webpack_require__.d(__webpack_exports__, "Code", function () {
        return Code;
      });
      /* harmony export (binding) */


      __webpack_require__.d(__webpack_exports__, "Col", function () {
        return Col;
      });
      /* harmony export (binding) */


      __webpack_require__.d(__webpack_exports__, "Colgroup", function () {
        return Colgroup;
      });
      /* harmony export (binding) */


      __webpack_require__.d(__webpack_exports__, "Command", function () {
        return Command;
      });
      /* harmony export (binding) */


      __webpack_require__.d(__webpack_exports__, "Datagrid", function () {
        return Datagrid;
      });
      /* harmony export (binding) */


      __webpack_require__.d(__webpack_exports__, "Datalist", function () {
        return Datalist;
      });
      /* harmony export (binding) */


      __webpack_require__.d(__webpack_exports__, "Dd", function () {
        return Dd;
      });
      /* harmony export (binding) */


      __webpack_require__.d(__webpack_exports__, "Del", function () {
        return Del;
      });
      /* harmony export (binding) */


      __webpack_require__.d(__webpack_exports__, "Details", function () {
        return Details;
      });
      /* harmony export (binding) */


      __webpack_require__.d(__webpack_exports__, "Dfn", function () {
        return Dfn;
      });
      /* harmony export (binding) */


      __webpack_require__.d(__webpack_exports__, "Dialog", function () {
        return Dialog;
      });
      /* harmony export (binding) */


      __webpack_require__.d(__webpack_exports__, "Dir", function () {
        return Dir;
      });
      /* harmony export (binding) */


      __webpack_require__.d(__webpack_exports__, "Div", function () {
        return Div;
      });
      /* harmony export (binding) */


      __webpack_require__.d(__webpack_exports__, "Dl", function () {
        return Dl;
      });
      /* harmony export (binding) */


      __webpack_require__.d(__webpack_exports__, "Dt", function () {
        return Dt;
      });
      /* harmony export (binding) */


      __webpack_require__.d(__webpack_exports__, "Em", function () {
        return Em;
      });
      /* harmony export (binding) */


      __webpack_require__.d(__webpack_exports__, "Embed", function () {
        return Embed;
      });
      /* harmony export (binding) */


      __webpack_require__.d(__webpack_exports__, "Eventsource", function () {
        return Eventsource;
      });
      /* harmony export (binding) */


      __webpack_require__.d(__webpack_exports__, "Fieldset", function () {
        return Fieldset;
      });
      /* harmony export (binding) */


      __webpack_require__.d(__webpack_exports__, "Figcaption", function () {
        return Figcaption;
      });
      /* harmony export (binding) */


      __webpack_require__.d(__webpack_exports__, "Figure", function () {
        return Figure;
      });
      /* harmony export (binding) */


      __webpack_require__.d(__webpack_exports__, "Font", function () {
        return Font;
      });
      /* harmony export (binding) */


      __webpack_require__.d(__webpack_exports__, "Footer", function () {
        return Footer;
      });
      /* harmony export (binding) */


      __webpack_require__.d(__webpack_exports__, "Form", function () {
        return Form;
      });
      /* harmony export (binding) */


      __webpack_require__.d(__webpack_exports__, "Frame", function () {
        return Frame;
      });
      /* harmony export (binding) */


      __webpack_require__.d(__webpack_exports__, "Frameset", function () {
        return Frameset;
      });
      /* harmony export (binding) */


      __webpack_require__.d(__webpack_exports__, "H1", function () {
        return H1;
      });
      /* harmony export (binding) */


      __webpack_require__.d(__webpack_exports__, "H2", function () {
        return H2;
      });
      /* harmony export (binding) */


      __webpack_require__.d(__webpack_exports__, "H3", function () {
        return H3;
      });
      /* harmony export (binding) */


      __webpack_require__.d(__webpack_exports__, "H4", function () {
        return H4;
      });
      /* harmony export (binding) */


      __webpack_require__.d(__webpack_exports__, "H5", function () {
        return H5;
      });
      /* harmony export (binding) */


      __webpack_require__.d(__webpack_exports__, "H6", function () {
        return H6;
      });
      /* harmony export (binding) */


      __webpack_require__.d(__webpack_exports__, "Head", function () {
        return Head;
      });
      /* harmony export (binding) */


      __webpack_require__.d(__webpack_exports__, "Header", function () {
        return Header;
      });
      /* harmony export (binding) */


      __webpack_require__.d(__webpack_exports__, "Hgroup", function () {
        return Hgroup;
      });
      /* harmony export (binding) */


      __webpack_require__.d(__webpack_exports__, "Hr", function () {
        return Hr;
      });
      /* harmony export (binding) */


      __webpack_require__.d(__webpack_exports__, "I", function () {
        return I;
      });
      /* harmony export (binding) */


      __webpack_require__.d(__webpack_exports__, "Iframe", function () {
        return Iframe;
      });
      /* harmony export (binding) */


      __webpack_require__.d(__webpack_exports__, "Img", function () {
        return Img;
      });
      /* harmony export (binding) */


      __webpack_require__.d(__webpack_exports__, "Input", function () {
        return Input;
      });
      /* harmony export (binding) */


      __webpack_require__.d(__webpack_exports__, "Ins", function () {
        return Ins;
      });
      /* harmony export (binding) */


      __webpack_require__.d(__webpack_exports__, "Isindex", function () {
        return Isindex;
      });
      /* harmony export (binding) */


      __webpack_require__.d(__webpack_exports__, "Kbd", function () {
        return Kbd;
      });
      /* harmony export (binding) */


      __webpack_require__.d(__webpack_exports__, "Keygen", function () {
        return Keygen;
      });
      /* harmony export (binding) */


      __webpack_require__.d(__webpack_exports__, "Label", function () {
        return Label;
      });
      /* harmony export (binding) */


      __webpack_require__.d(__webpack_exports__, "Legend", function () {
        return Legend;
      });
      /* harmony export (binding) */


      __webpack_require__.d(__webpack_exports__, "Li", function () {
        return Li;
      });
      /* harmony export (binding) */


      __webpack_require__.d(__webpack_exports__, "Link", function () {
        return Link;
      });
      /* harmony export (binding) */


      __webpack_require__.d(__webpack_exports__, "Map", function () {
        return Map;
      });
      /* harmony export (binding) */


      __webpack_require__.d(__webpack_exports__, "Mark", function () {
        return Mark;
      });
      /* harmony export (binding) */


      __webpack_require__.d(__webpack_exports__, "Menu", function () {
        return Menu;
      });
      /* harmony export (binding) */


      __webpack_require__.d(__webpack_exports__, "Meta", function () {
        return Meta;
      });
      /* harmony export (binding) */


      __webpack_require__.d(__webpack_exports__, "Meter", function () {
        return Meter;
      });
      /* harmony export (binding) */


      __webpack_require__.d(__webpack_exports__, "Nav", function () {
        return Nav;
      });
      /* harmony export (binding) */


      __webpack_require__.d(__webpack_exports__, "Noframes", function () {
        return Noframes;
      });
      /* harmony export (binding) */


      __webpack_require__.d(__webpack_exports__, "Noscript", function () {
        return Noscript;
      });
      /* harmony export (binding) */


      __webpack_require__.d(__webpack_exports__, "Ol", function () {
        return Ol;
      });
      /* harmony export (binding) */


      __webpack_require__.d(__webpack_exports__, "Optgroup", function () {
        return Optgroup;
      });
      /* harmony export (binding) */


      __webpack_require__.d(__webpack_exports__, "Option", function () {
        return Option;
      });
      /* harmony export (binding) */


      __webpack_require__.d(__webpack_exports__, "Output", function () {
        return Output;
      });
      /* harmony export (binding) */


      __webpack_require__.d(__webpack_exports__, "P", function () {
        return P;
      });
      /* harmony export (binding) */


      __webpack_require__.d(__webpack_exports__, "Param", function () {
        return Param;
      });
      /* harmony export (binding) */


      __webpack_require__.d(__webpack_exports__, "Pre", function () {
        return Pre;
      });
      /* harmony export (binding) */


      __webpack_require__.d(__webpack_exports__, "Progress", function () {
        return Progress;
      });
      /* harmony export (binding) */


      __webpack_require__.d(__webpack_exports__, "Q", function () {
        return Q;
      });
      /* harmony export (binding) */


      __webpack_require__.d(__webpack_exports__, "Rp", function () {
        return Rp;
      });
      /* harmony export (binding) */


      __webpack_require__.d(__webpack_exports__, "Rt", function () {
        return Rt;
      });
      /* harmony export (binding) */


      __webpack_require__.d(__webpack_exports__, "Ruby", function () {
        return Ruby;
      });
      /* harmony export (binding) */


      __webpack_require__.d(__webpack_exports__, "S", function () {
        return S;
      });
      /* harmony export (binding) */


      __webpack_require__.d(__webpack_exports__, "Samp", function () {
        return Samp;
      });
      /* harmony export (binding) */


      __webpack_require__.d(__webpack_exports__, "Script", function () {
        return Script;
      });
      /* harmony export (binding) */


      __webpack_require__.d(__webpack_exports__, "Section", function () {
        return Section;
      });
      /* harmony export (binding) */


      __webpack_require__.d(__webpack_exports__, "Select", function () {
        return Select;
      });
      /* harmony export (binding) */


      __webpack_require__.d(__webpack_exports__, "Small", function () {
        return Small;
      });
      /* harmony export (binding) */


      __webpack_require__.d(__webpack_exports__, "Source", function () {
        return Source;
      });
      /* harmony export (binding) */


      __webpack_require__.d(__webpack_exports__, "Span", function () {
        return Span;
      });
      /* harmony export (binding) */


      __webpack_require__.d(__webpack_exports__, "Strike", function () {
        return Strike;
      });
      /* harmony export (binding) */


      __webpack_require__.d(__webpack_exports__, "Strong", function () {
        return Strong;
      });
      /* harmony export (binding) */


      __webpack_require__.d(__webpack_exports__, "Style", function () {
        return Style;
      });
      /* harmony export (binding) */


      __webpack_require__.d(__webpack_exports__, "Sub", function () {
        return Sub;
      });
      /* harmony export (binding) */


      __webpack_require__.d(__webpack_exports__, "Sup", function () {
        return Sup;
      });
      /* harmony export (binding) */


      __webpack_require__.d(__webpack_exports__, "Table", function () {
        return Table;
      });
      /* harmony export (binding) */


      __webpack_require__.d(__webpack_exports__, "Tbody", function () {
        return Tbody;
      });
      /* harmony export (binding) */


      __webpack_require__.d(__webpack_exports__, "Td", function () {
        return Td;
      });
      /* harmony export (binding) */


      __webpack_require__.d(__webpack_exports__, "Textarea", function () {
        return Textarea;
      });
      /* harmony export (binding) */


      __webpack_require__.d(__webpack_exports__, "Tfoot", function () {
        return Tfoot;
      });
      /* harmony export (binding) */


      __webpack_require__.d(__webpack_exports__, "Th", function () {
        return Th;
      });
      /* harmony export (binding) */


      __webpack_require__.d(__webpack_exports__, "Thead", function () {
        return Thead;
      });
      /* harmony export (binding) */


      __webpack_require__.d(__webpack_exports__, "Time", function () {
        return Time;
      });
      /* harmony export (binding) */


      __webpack_require__.d(__webpack_exports__, "Title", function () {
        return Title;
      });
      /* harmony export (binding) */


      __webpack_require__.d(__webpack_exports__, "Tr", function () {
        return Tr;
      });
      /* harmony export (binding) */


      __webpack_require__.d(__webpack_exports__, "Track", function () {
        return Track;
      });
      /* harmony export (binding) */


      __webpack_require__.d(__webpack_exports__, "Tt", function () {
        return Tt;
      });
      /* harmony export (binding) */


      __webpack_require__.d(__webpack_exports__, "U", function () {
        return U;
      });
      /* harmony export (binding) */


      __webpack_require__.d(__webpack_exports__, "Ul", function () {
        return Ul;
      });
      /* harmony export (binding) */


      __webpack_require__.d(__webpack_exports__, "Video", function () {
        return Video;
      });
      /* harmony export (binding) */


      __webpack_require__.d(__webpack_exports__, "Wbr", function () {
        return Wbr;
      });
      /* harmony export (binding) */


      __webpack_require__.d(__webpack_exports__, "a", function () {
        return a;
      });
      /* harmony export (binding) */


      __webpack_require__.d(__webpack_exports__, "abbr", function () {
        return abbr;
      });
      /* harmony export (binding) */


      __webpack_require__.d(__webpack_exports__, "acronym", function () {
        return acronym;
      });
      /* harmony export (binding) */


      __webpack_require__.d(__webpack_exports__, "address", function () {
        return address;
      });
      /* harmony export (binding) */


      __webpack_require__.d(__webpack_exports__, "applet", function () {
        return applet;
      });
      /* harmony export (binding) */


      __webpack_require__.d(__webpack_exports__, "area", function () {
        return area;
      });
      /* harmony export (binding) */


      __webpack_require__.d(__webpack_exports__, "article", function () {
        return article;
      });
      /* harmony export (binding) */


      __webpack_require__.d(__webpack_exports__, "aside", function () {
        return aside;
      });
      /* harmony export (binding) */


      __webpack_require__.d(__webpack_exports__, "audio", function () {
        return audio;
      });
      /* harmony export (binding) */


      __webpack_require__.d(__webpack_exports__, "b", function () {
        return b;
      });
      /* harmony export (binding) */


      __webpack_require__.d(__webpack_exports__, "base", function () {
        return base;
      });
      /* harmony export (binding) */


      __webpack_require__.d(__webpack_exports__, "basefont", function () {
        return basefont;
      });
      /* harmony export (binding) */


      __webpack_require__.d(__webpack_exports__, "bb", function () {
        return bb;
      });
      /* harmony export (binding) */


      __webpack_require__.d(__webpack_exports__, "bdo", function () {
        return bdo;
      });
      /* harmony export (binding) */


      __webpack_require__.d(__webpack_exports__, "big", function () {
        return big;
      });
      /* harmony export (binding) */


      __webpack_require__.d(__webpack_exports__, "blockquote", function () {
        return blockquote;
      });
      /* harmony export (binding) */


      __webpack_require__.d(__webpack_exports__, "body", function () {
        return body;
      });
      /* harmony export (binding) */


      __webpack_require__.d(__webpack_exports__, "br", function () {
        return br;
      });
      /* harmony export (binding) */


      __webpack_require__.d(__webpack_exports__, "button", function () {
        return button;
      });
      /* harmony export (binding) */


      __webpack_require__.d(__webpack_exports__, "canvas", function () {
        return canvas;
      });
      /* harmony export (binding) */


      __webpack_require__.d(__webpack_exports__, "caption", function () {
        return caption;
      });
      /* harmony export (binding) */


      __webpack_require__.d(__webpack_exports__, "center", function () {
        return center;
      });
      /* harmony export (binding) */


      __webpack_require__.d(__webpack_exports__, "cite", function () {
        return cite;
      });
      /* harmony export (binding) */


      __webpack_require__.d(__webpack_exports__, "code", function () {
        return code;
      });
      /* harmony export (binding) */


      __webpack_require__.d(__webpack_exports__, "col", function () {
        return col;
      });
      /* harmony export (binding) */


      __webpack_require__.d(__webpack_exports__, "colgroup", function () {
        return colgroup;
      });
      /* harmony export (binding) */


      __webpack_require__.d(__webpack_exports__, "command", function () {
        return command;
      });
      /* harmony export (binding) */


      __webpack_require__.d(__webpack_exports__, "datagrid", function () {
        return datagrid;
      });
      /* harmony export (binding) */


      __webpack_require__.d(__webpack_exports__, "datalist", function () {
        return datalist;
      });
      /* harmony export (binding) */


      __webpack_require__.d(__webpack_exports__, "dd", function () {
        return dd;
      });
      /* harmony export (binding) */


      __webpack_require__.d(__webpack_exports__, "del", function () {
        return del;
      });
      /* harmony export (binding) */


      __webpack_require__.d(__webpack_exports__, "details", function () {
        return details;
      });
      /* harmony export (binding) */


      __webpack_require__.d(__webpack_exports__, "dfn", function () {
        return dfn;
      });
      /* harmony export (binding) */


      __webpack_require__.d(__webpack_exports__, "dialog", function () {
        return dialog;
      });
      /* harmony export (binding) */


      __webpack_require__.d(__webpack_exports__, "dir", function () {
        return dir;
      });
      /* harmony export (binding) */


      __webpack_require__.d(__webpack_exports__, "div", function () {
        return div;
      });
      /* harmony export (binding) */


      __webpack_require__.d(__webpack_exports__, "dl", function () {
        return dl;
      });
      /* harmony export (binding) */


      __webpack_require__.d(__webpack_exports__, "dt", function () {
        return dt;
      });
      /* harmony export (binding) */


      __webpack_require__.d(__webpack_exports__, "em", function () {
        return em;
      });
      /* harmony export (binding) */


      __webpack_require__.d(__webpack_exports__, "embed", function () {
        return embed;
      });
      /* harmony export (binding) */


      __webpack_require__.d(__webpack_exports__, "eventsource", function () {
        return eventsource;
      });
      /* harmony export (binding) */


      __webpack_require__.d(__webpack_exports__, "fieldset", function () {
        return fieldset;
      });
      /* harmony export (binding) */


      __webpack_require__.d(__webpack_exports__, "figcaption", function () {
        return figcaption;
      });
      /* harmony export (binding) */


      __webpack_require__.d(__webpack_exports__, "figure", function () {
        return figure;
      });
      /* harmony export (binding) */


      __webpack_require__.d(__webpack_exports__, "font", function () {
        return font;
      });
      /* harmony export (binding) */


      __webpack_require__.d(__webpack_exports__, "footer", function () {
        return footer;
      });
      /* harmony export (binding) */


      __webpack_require__.d(__webpack_exports__, "form", function () {
        return form;
      });
      /* harmony export (binding) */


      __webpack_require__.d(__webpack_exports__, "frame", function () {
        return frame;
      });
      /* harmony export (binding) */


      __webpack_require__.d(__webpack_exports__, "frameset", function () {
        return frameset;
      });
      /* harmony export (binding) */


      __webpack_require__.d(__webpack_exports__, "h1", function () {
        return h1;
      });
      /* harmony export (binding) */


      __webpack_require__.d(__webpack_exports__, "h2", function () {
        return h2;
      });
      /* harmony export (binding) */


      __webpack_require__.d(__webpack_exports__, "h3", function () {
        return h3;
      });
      /* harmony export (binding) */


      __webpack_require__.d(__webpack_exports__, "h4", function () {
        return h4;
      });
      /* harmony export (binding) */


      __webpack_require__.d(__webpack_exports__, "h5", function () {
        return h5;
      });
      /* harmony export (binding) */


      __webpack_require__.d(__webpack_exports__, "h6", function () {
        return h6;
      });
      /* harmony export (binding) */


      __webpack_require__.d(__webpack_exports__, "head", function () {
        return head;
      });
      /* harmony export (binding) */


      __webpack_require__.d(__webpack_exports__, "header", function () {
        return header;
      });
      /* harmony export (binding) */


      __webpack_require__.d(__webpack_exports__, "hgroup", function () {
        return hgroup;
      });
      /* harmony export (binding) */


      __webpack_require__.d(__webpack_exports__, "hr", function () {
        return hr;
      });
      /* harmony export (binding) */


      __webpack_require__.d(__webpack_exports__, "i", function () {
        return i;
      });
      /* harmony export (binding) */


      __webpack_require__.d(__webpack_exports__, "iframe", function () {
        return iframe;
      });
      /* harmony export (binding) */


      __webpack_require__.d(__webpack_exports__, "img", function () {
        return img;
      });
      /* harmony export (binding) */


      __webpack_require__.d(__webpack_exports__, "input", function () {
        return input;
      });
      /* harmony export (binding) */


      __webpack_require__.d(__webpack_exports__, "ins", function () {
        return ins;
      });
      /* harmony export (binding) */


      __webpack_require__.d(__webpack_exports__, "isindex", function () {
        return isindex;
      });
      /* harmony export (binding) */


      __webpack_require__.d(__webpack_exports__, "kbd", function () {
        return kbd;
      });
      /* harmony export (binding) */


      __webpack_require__.d(__webpack_exports__, "keygen", function () {
        return keygen;
      });
      /* harmony export (binding) */


      __webpack_require__.d(__webpack_exports__, "label", function () {
        return label;
      });
      /* harmony export (binding) */


      __webpack_require__.d(__webpack_exports__, "legend", function () {
        return legend;
      });
      /* harmony export (binding) */


      __webpack_require__.d(__webpack_exports__, "li", function () {
        return li;
      });
      /* harmony export (binding) */


      __webpack_require__.d(__webpack_exports__, "link", function () {
        return link;
      });
      /* harmony export (binding) */


      __webpack_require__.d(__webpack_exports__, "map", function () {
        return map;
      });
      /* harmony export (binding) */


      __webpack_require__.d(__webpack_exports__, "mark", function () {
        return mark;
      });
      /* harmony export (binding) */


      __webpack_require__.d(__webpack_exports__, "menu", function () {
        return menu;
      });
      /* harmony export (binding) */


      __webpack_require__.d(__webpack_exports__, "meta", function () {
        return meta;
      });
      /* harmony export (binding) */


      __webpack_require__.d(__webpack_exports__, "meter", function () {
        return meter;
      });
      /* harmony export (binding) */


      __webpack_require__.d(__webpack_exports__, "nav", function () {
        return nav;
      });
      /* harmony export (binding) */


      __webpack_require__.d(__webpack_exports__, "noframes", function () {
        return noframes;
      });
      /* harmony export (binding) */


      __webpack_require__.d(__webpack_exports__, "noscript", function () {
        return noscript;
      });
      /* harmony export (binding) */


      __webpack_require__.d(__webpack_exports__, "ol", function () {
        return ol;
      });
      /* harmony export (binding) */


      __webpack_require__.d(__webpack_exports__, "optgroup", function () {
        return optgroup;
      });
      /* harmony export (binding) */


      __webpack_require__.d(__webpack_exports__, "option", function () {
        return option;
      });
      /* harmony export (binding) */


      __webpack_require__.d(__webpack_exports__, "output", function () {
        return output;
      });
      /* harmony export (binding) */


      __webpack_require__.d(__webpack_exports__, "p", function () {
        return p;
      });
      /* harmony export (binding) */


      __webpack_require__.d(__webpack_exports__, "param", function () {
        return param;
      });
      /* harmony export (binding) */


      __webpack_require__.d(__webpack_exports__, "pre", function () {
        return pre;
      });
      /* harmony export (binding) */


      __webpack_require__.d(__webpack_exports__, "progress", function () {
        return progress;
      });
      /* harmony export (binding) */


      __webpack_require__.d(__webpack_exports__, "q", function () {
        return q;
      });
      /* harmony export (binding) */


      __webpack_require__.d(__webpack_exports__, "rp", function () {
        return rp;
      });
      /* harmony export (binding) */


      __webpack_require__.d(__webpack_exports__, "rt", function () {
        return rt;
      });
      /* harmony export (binding) */


      __webpack_require__.d(__webpack_exports__, "ruby", function () {
        return ruby;
      });
      /* harmony export (binding) */


      __webpack_require__.d(__webpack_exports__, "s", function () {
        return s;
      });
      /* harmony export (binding) */


      __webpack_require__.d(__webpack_exports__, "samp", function () {
        return samp;
      });
      /* harmony export (binding) */


      __webpack_require__.d(__webpack_exports__, "script", function () {
        return script;
      });
      /* harmony export (binding) */


      __webpack_require__.d(__webpack_exports__, "section", function () {
        return section;
      });
      /* harmony export (binding) */


      __webpack_require__.d(__webpack_exports__, "select", function () {
        return select;
      });
      /* harmony export (binding) */


      __webpack_require__.d(__webpack_exports__, "small", function () {
        return small;
      });
      /* harmony export (binding) */


      __webpack_require__.d(__webpack_exports__, "source", function () {
        return source;
      });
      /* harmony export (binding) */


      __webpack_require__.d(__webpack_exports__, "span", function () {
        return span;
      });
      /* harmony export (binding) */


      __webpack_require__.d(__webpack_exports__, "strike", function () {
        return strike;
      });
      /* harmony export (binding) */


      __webpack_require__.d(__webpack_exports__, "strong", function () {
        return strong;
      });
      /* harmony export (binding) */


      __webpack_require__.d(__webpack_exports__, "style", function () {
        return style;
      });
      /* harmony export (binding) */


      __webpack_require__.d(__webpack_exports__, "sub", function () {
        return sub;
      });
      /* harmony export (binding) */


      __webpack_require__.d(__webpack_exports__, "sup", function () {
        return sup;
      });
      /* harmony export (binding) */


      __webpack_require__.d(__webpack_exports__, "table", function () {
        return table;
      });
      /* harmony export (binding) */


      __webpack_require__.d(__webpack_exports__, "tbody", function () {
        return tbody;
      });
      /* harmony export (binding) */


      __webpack_require__.d(__webpack_exports__, "td", function () {
        return td;
      });
      /* harmony export (binding) */


      __webpack_require__.d(__webpack_exports__, "textarea", function () {
        return textarea;
      });
      /* harmony export (binding) */


      __webpack_require__.d(__webpack_exports__, "tfoot", function () {
        return tfoot;
      });
      /* harmony export (binding) */


      __webpack_require__.d(__webpack_exports__, "th", function () {
        return th;
      });
      /* harmony export (binding) */


      __webpack_require__.d(__webpack_exports__, "thead", function () {
        return thead;
      });
      /* harmony export (binding) */


      __webpack_require__.d(__webpack_exports__, "time", function () {
        return time;
      });
      /* harmony export (binding) */


      __webpack_require__.d(__webpack_exports__, "title", function () {
        return title;
      });
      /* harmony export (binding) */


      __webpack_require__.d(__webpack_exports__, "tr", function () {
        return tr;
      });
      /* harmony export (binding) */


      __webpack_require__.d(__webpack_exports__, "track", function () {
        return track;
      });
      /* harmony export (binding) */


      __webpack_require__.d(__webpack_exports__, "tt", function () {
        return tt;
      });
      /* harmony export (binding) */


      __webpack_require__.d(__webpack_exports__, "u", function () {
        return u;
      });
      /* harmony export (binding) */


      __webpack_require__.d(__webpack_exports__, "ul", function () {
        return ul;
      });
      /* harmony export (binding) */


      __webpack_require__.d(__webpack_exports__, "video", function () {
        return video;
      });
      /* harmony export (binding) */


      __webpack_require__.d(__webpack_exports__, "wbr", function () {
        return wbr;
      });
      /* harmony import */


      var _utils__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(
      /*! ./utils */
      "KgG6");
      /* harmony import */


      var _es5_class__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(
      /*! ./es5.class */
      "pIPj");
      /* harmony import */


      var _dom__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(
      /*! ./dom */
      "d9Ql"); // import Dom, { $, Query, query } from './dom.js';


      function checkImageURL(url) {
        return url.match(/\.(jpeg|jpg|gif|png|svg)$/) != null || url.match(/^(http|https)\:\/\//) != null;
      }
      /**
       * Tạo một lớp đối tượng
       * @param {string} tag tên thẻ bạn muốn khởi tạo
       * @returns {Html}
       */


      function createElementClass(tag, properties) {
        var prop = {};

        if (Object(_utils__WEBPACK_IMPORTED_MODULE_0__["isObject"])(properties)) {
          for (var key in properties) {
            if (Object.hasOwnProperty.call(properties, key)) {
              var fn = properties[key];

              if (key == "constructor") {
                if (typeof fn == "function") prop.__constructor__ = fn;
              } else {
                prop[key] = fn;
              }
            }
          }
        }

        var t = tag.toLowerCase();
        var classProps = {
          $tagName: tag,
          constructor: function constructor() {
            var args = Object(_utils__WEBPACK_IMPORTED_MODULE_0__["getArguments"])(arguments);

            if (args.length && Object(_utils__WEBPACK_IMPORTED_MODULE_0__["isString"])(args[0])) {
              if (args[0].match(/^(\.|\#|\[|\:)[A-Za-z_\-]+/i) !== null) {
                var a = Object(_dom__WEBPACK_IMPORTED_MODULE_2__["getDomInf"])(args[0]);

                if (a.isElement) {
                  if (a.isDefault) {
                    args[0] = tag.toLowerCase() + args[0];
                  } else {
                    args[0] = this.tagName + args[0].substr(a.tagName.length);
                  }
                } else {
                  args.unshift(this.tagName);
                }
              } else {
                args.unshift(this.tagName);

                if (args[0].match(/^\{.*\}$/i) !== null) {
                  args[0] = args[0].substr(1, args[0].length - 2);
                }
              }
            } else {
              args.unshift(this.tagName);
            }

            this.setElement.apply(this, args);
          }
        };
        classProps['const$is' + _utils__WEBPACK_IMPORTED_MODULE_0__["Str"].ucfirst(t)] = true;

        if (t == 'img') {
          Object(_utils__WEBPACK_IMPORTED_MODULE_0__["assignValue"])(classProps, {
            $isImage: true,
            $srcSync: false,
            $src: null,
            inits: '__src_init__',
            onGet$src: function onGet$src(value) {// return this.val();
            },
            onset$src: function onset$src(value) {
              if (this.srcSync) this.attr('src', value);
            },
            __src_init__: function __src_init__() {
              this.src = this.attr('src');
              var self = this;
              this.on('change', function (e) {
                var value = this.attr('src');

                if (value != self.src) {
                  self.valueSync = false;
                  self.src = value;
                  self.srcSync = true;
                }
              });
              this.srcSync = true;
            },
            constructor: function constructor() {
              var args = Object(_utils__WEBPACK_IMPORTED_MODULE_0__["getArguments"])(arguments);
              var src = null;
              var createArgs = [];
              var attrs = {};
              var hasTag = false;

              for (var index = 0; index < args.length; index++) {
                var vl = args[index];

                if (index == 0) {
                  if (Object(_utils__WEBPACK_IMPORTED_MODULE_0__["isString"])(vl)) {
                    if (checkImageURL(vl)) {
                      src = vl;
                      createArgs.unshift(this.tagName);
                    } else {
                      var a = Object(_dom__WEBPACK_IMPORTED_MODULE_2__["getDomInf"])(vl);

                      if (a.isElement) {
                        if (a.isDefault) {
                          createArgs.push(tag.toLowerCase() + args[0]);
                          hasTag = true;
                        } else {
                          createArgs.push(this.tagName + args[0].substr(a.tagName.length));
                          hasTag = true;
                        }
                      } else {
                        createArgs.unshift(this.tagName);
                      }
                    }
                  } else {
                    createArgs.unshift(this.tagName);
                    Object(_utils__WEBPACK_IMPORTED_MODULE_0__["assignValue"])(attrs, vl);
                  }
                } else {
                  if (Object(_utils__WEBPACK_IMPORTED_MODULE_0__["isString"])(vl)) {
                    if (!src && checkImageURL(vl)) {
                      src = vl;
                    } else {
                      attrs.alt = vl;
                    }
                  } else if (Object(_utils__WEBPACK_IMPORTED_MODULE_0__["isObject"])(vl)) {
                    Object(_utils__WEBPACK_IMPORTED_MODULE_0__["assignValue"])(attrs, vl);
                  }
                }
              }

              if (src && !attrs.src) attrs.src = src;
              createArgs.push(attrs);
              this.setElement.apply(this, createArgs);
            }
          });
        } else if (t == 'input') {
          Object(_utils__WEBPACK_IMPORTED_MODULE_0__["assignValue"])(classProps, {
            $valueSync: false,
            $value: null,
            inits: '__value_init__',
            onGet$Value: function onGet$Value(value) {// return this.val();
            },
            onset$value: function onset$value(value) {
              if (this.valueSync) this.val(value);
            },
            __value_init__: function __value_init__() {
              this.value = this.val();
              var self = this;
              this.on('change', function (e) {
                var value = this.val();

                if (value != self.value) {
                  self.valueSync = false;
                  self.value = value;
                  self.valueSync = true;
                }
              });
              this.valueSync = true;
            },
            constructor: function constructor() {
              var args = Object(_utils__WEBPACK_IMPORTED_MODULE_0__["getArguments"])(arguments); // nếu nhập vào ("select", "name", "value", data)

              var createArgs = [];
              var domEls = [];

              if (args.length) {
                if (Object(_utils__WEBPACK_IMPORTED_MODULE_0__["isObject"])(args[0]) && !args[0].isDom) {
                  createArgs.push(args[0]);
                } else {
                  var inputOptions = {
                    type: "",
                    name: "",
                    value: "",
                    "default": "",
                    data: {}
                  };
                  var s = 0;
                  var domEls = [];

                  for (var index = 0; index < args.length; index++) {
                    var vl = args[index];

                    if (Object(_utils__WEBPACK_IMPORTED_MODULE_0__["isString"])(vl)) {
                      var vlow = String(vl).toLowerCase();

                      if (!s) {
                        var a = Object(_dom__WEBPACK_IMPORTED_MODULE_2__["getDomInf"])(vl);

                        if (_dom__WEBPACK_IMPORTED_MODULE_2__["inputTypes"].indexOf(vlow) !== -1 || _dom__WEBPACK_IMPORTED_MODULE_2__["inputTags"].indexOf(vlow) !== -1) {
                          inputOptions.type = vlow;
                          s++;
                        } else if (a.isElement) {
                          var tg = a.tagName.toLowerCase();

                          if (_dom__WEBPACK_IMPORTED_MODULE_2__["inputTypes"].indexOf(tg) !== -1) {
                            inputOptions.type = tg;
                          } else if (_dom__WEBPACK_IMPORTED_MODULE_2__["inputTags"].indexOf(tg) != -1) {
                            inputOptions.type = tg;
                          }

                          s++;

                          if (!Object(_utils__WEBPACK_IMPORTED_MODULE_0__["isEmpty"])(a.attrs)) {
                            Object(_utils__WEBPACK_IMPORTED_MODULE_0__["assignValue"])(inputOptions, a.attrs);
                          }

                          ;
                          if (!Object(_utils__WEBPACK_IMPORTED_MODULE_0__["isEmpty"])(a.props)) Object(_utils__WEBPACK_IMPORTED_MODULE_0__["assignValue"])(inputOptions, a.props);

                          if (a.className) {
                            inputOptions.className = a.className;
                          }

                          if (a.id) {
                            inputOptions.id = a.id;
                          }
                        } else {
                          inputOptions.name = vl;
                          s++;
                        }
                      } else if (index < 3) {
                        if ((inputOptions.name && _dom__WEBPACK_IMPORTED_MODULE_2__["inputTypes"].indexOf(vlow) !== -1 || _dom__WEBPACK_IMPORTED_MODULE_2__["inputTags"].indexOf(vlow) !== -1) && !inputOptions.type) {
                          inputOptions.type = vlow;
                        } else if (!inputOptions.name && vl.match(/^[A-z_]+[A-z_\[\]0-9\.\-]*$/i) != null) {
                          inputOptions.name = vl;
                        } else {
                          inputOptions.value = vl;
                        }
                      }
                    } else if (Object(_utils__WEBPACK_IMPORTED_MODULE_0__["isObject"])(vl)) {
                      if (vl.isDom) {
                        domEls.push(vl);
                      } else {
                        Object(_utils__WEBPACK_IMPORTED_MODULE_0__["assignValue"])(inputOptions, vl);
                      }
                    }
                  }

                  if (!inputOptions.type) inputOptions.type = 'text';
                  createArgs.push(inputOptions);
                }
              }

              if (createArgs.length) {
                var elem = input1.apply(this, createArgs);
                var el = elem.el;

                if (el) {
                  if (!el.id && this.id) el.id = this.id;
                  if (!el.className && this.className) el.className = this.className;
                  this.el = el;

                  if (!Object(_utils__WEBPACK_IMPORTED_MODULE_0__["isEmpty"])(elem.dynamicAttrs)) {
                    this.addDynamicAttr(elem.dynamicAttrs);
                  } // console.log(this, args, elem.contents);


                  if (elem.tag == 'select' && !Object(_utils__WEBPACK_IMPORTED_MODULE_0__["isEmpty"])(elem.contents)) {
                    this.setHtml(Object(_dom__WEBPACK_IMPORTED_MODULE_2__["default"])('div', elem.contents).html());
                  }

                  if (!Object(_utils__WEBPACK_IMPORTED_MODULE_0__["isEmpty"])(elem.events)) {
                    this.on(elem.events);
                  } // DoanDepTrai


                  if (!Object(_utils__WEBPACK_IMPORTED_MODULE_0__["isEmpty"])(elem.methods)) {
                    for (var method in elem.methods) {
                      if (Object.hasOwnProperty.call(elem.methods, method)) {
                        var fn = elem.methods[method]; // console.log(method, fn)

                        Object(_utils__WEBPACK_IMPORTED_MODULE_0__["_defineProperty"])(this, method, fn);
                      }
                    }
                  }

                  if (this._pendingContents.length) {
                    while (this._pendingContents.length) {
                      var a = this._pendingContents.shift();

                      this[a.key] = a.content;
                      this.append(a.content);
                    }
                  }
                }
              }
            }
          });
        }

        var $class = Object(_es5_class__WEBPACK_IMPORTED_MODULE_1__["default"])(_utils__WEBPACK_IMPORTED_MODULE_0__["Str"].ucfirst(tag), false)["extends"](_dom__WEBPACK_IMPORTED_MODULE_2__["default"]).uses(prop)(classProps);
        return $class;
      }

      function createHtmlElementFunction(tag) {
        var tagName = tag.toLowerCase();

        var fn = function fn() {
          for (var _len = arguments.length, args = new Array(_len), _key = 0; _key < _len; _key++) {
            args[_key] = arguments[_key];
          }

          if (args.length && Object(_utils__WEBPACK_IMPORTED_MODULE_0__["isString"])(args[0])) {
            if (args[0].match(/^(\.|\#|\[|\:)[A-Za-z_\-]+/i) !== null) {
              var a = Object(_dom__WEBPACK_IMPORTED_MODULE_2__["getDomInf"])(args[0]);

              if (a.isElement) {
                if (a.isDefault) {
                  args[0] = tag.toLowerCase() + args[0];
                } else {
                  args[0] = tagName + args[0].substr(a.tagName.length);
                }
              } else {
                args.unshift(tagName);
              }
            } else {
              args.unshift(tagName);

              if (args[0].match(/^\{.*\}$/i) !== null) {
                args[0] = args[0].substr(1, args[0].length - 2);
              }
            }
          } else {
            args.unshift(tagName);
          }

          return Object(_dom__WEBPACK_IMPORTED_MODULE_2__["createEl"]).apply(void 0, args);
        };

        if (tagName == "input") {
          fn = function fn() {
            var createArgs = [];
            var domEls = [];

            for (var _len2 = arguments.length, args = new Array(_len2), _key2 = 0; _key2 < _len2; _key2++) {
              args[_key2] = arguments[_key2];
            }

            if (args.length) {
              if (Object(_utils__WEBPACK_IMPORTED_MODULE_0__["isObject"])(args[0]) && !args[0].isDom) {
                createArgs.push(args[0]);
              } else {
                var inputOptions = {
                  type: "",
                  name: "",
                  value: "",
                  "default": "",
                  data: {}
                };
                var s = 0;
                var domEls = [];

                for (var index = 0; index < args.length; index++) {
                  var vl = args[index];

                  if (Object(_utils__WEBPACK_IMPORTED_MODULE_0__["isString"])(vl)) {
                    var vlow = String(vl).toLowerCase();

                    if (!s) {
                      var a = Object(_dom__WEBPACK_IMPORTED_MODULE_2__["getDomInf"])(vl);

                      if (_dom__WEBPACK_IMPORTED_MODULE_2__["inputTypes"].indexOf(vlow) !== -1 || _dom__WEBPACK_IMPORTED_MODULE_2__["inputTags"].indexOf(vlow) !== -1) {
                        inputOptions.type = vlow;
                        s++;
                      } else if (a.isElement) {
                        var tg = a.tagName.toLowerCase();

                        if (_dom__WEBPACK_IMPORTED_MODULE_2__["inputTypes"].indexOf(tg) !== -1) {
                          inputOptions.type = tg;
                        } else if (_dom__WEBPACK_IMPORTED_MODULE_2__["inputTags"].indexOf(tg) != -1) {
                          inputOptions.type = tg;
                        }

                        s++;

                        if (!Object(_utils__WEBPACK_IMPORTED_MODULE_0__["isEmpty"])(a.attrs)) {
                          Object(_utils__WEBPACK_IMPORTED_MODULE_0__["assignValue"])(inputOptions, a.attrs);
                        }

                        ;
                        if (!Object(_utils__WEBPACK_IMPORTED_MODULE_0__["isEmpty"])(a.props)) Object(_utils__WEBPACK_IMPORTED_MODULE_0__["assignValue"])(inputOptions, a.props);

                        if (a.className) {
                          inputOptions.className = a.className;
                        }

                        if (a.id) {
                          inputOptions.id = a.id;
                        }
                      } else {
                        inputOptions.name = vl;
                        s++;
                      }
                    } else if (index < 3) {
                      if ((inputOptions.name && _dom__WEBPACK_IMPORTED_MODULE_2__["inputTypes"].indexOf(vlow) !== -1 || _dom__WEBPACK_IMPORTED_MODULE_2__["inputTags"].indexOf(vlow) !== -1) && !inputOptions.type) {
                        inputOptions.type = vlow;
                      } else if (!inputOptions.name && vl.match(/^[A-z_]+[A-z_\[\]0-9\.\-]*$/i) != null) {
                        inputOptions.name = vl;
                      } else {
                        inputOptions.value = vl;
                      }
                    }
                  } else if (Object(_utils__WEBPACK_IMPORTED_MODULE_0__["isObject"])(vl)) {
                    if (vl.isDom) {
                      domEls.push(vl);
                    } else {
                      Object(_utils__WEBPACK_IMPORTED_MODULE_0__["assignValue"])(inputOptions, vl);
                    }
                  }
                }

                if (!inputOptions.type) inputOptions.type = 'text';
                createArgs.push(inputOptions);
              }
            }

            if (createArgs.length) {
              return input2(createArgs);
            } else {
              return input2({
                type: "text"
              });
            }
          };
        } else if (tagName == "img") {
          fn = function fn() {
            var src = null;
            var createArgs = [];
            var attrs = {};
            var hasTag = false;

            for (var _len3 = arguments.length, args = new Array(_len3), _key3 = 0; _key3 < _len3; _key3++) {
              args[_key3] = arguments[_key3];
            }

            for (var index = 0; index < args.length; index++) {
              var vl = args[index];

              if (index == 0) {
                if (Object(_utils__WEBPACK_IMPORTED_MODULE_0__["isString"])(vl)) {
                  if (checkImageURL(vl)) {
                    src = vl;
                    createArgs.unshift(tagName);
                  } else {
                    var a = Object(_dom__WEBPACK_IMPORTED_MODULE_2__["getDomInf"])(vl);

                    if (a.isElement) {
                      if (a.isDefault) {
                        createArgs.push(tag.toLowerCase() + args[0]);
                        hasTag = true;
                      } else {
                        createArgs.push(tagName + args[0].substr(a.tagName.length));
                        hasTag = true;
                      }
                    } else {
                      createArgs.unshift(tagName);
                    }
                  }
                } else {
                  createArgs.unshift(tagName);
                  Object(_utils__WEBPACK_IMPORTED_MODULE_0__["assignValue"])(attrs, vl);
                }
              } else {
                if (Object(_utils__WEBPACK_IMPORTED_MODULE_0__["isString"])(vl)) {
                  if (!src && checkImageURL(vl)) {
                    src = vl;
                  } else {
                    attrs.alt = vl;
                  }
                } else if (Object(_utils__WEBPACK_IMPORTED_MODULE_0__["isObject"])(vl)) {
                  Object(_utils__WEBPACK_IMPORTED_MODULE_0__["assignValue"])(attrs, vl);
                }
              }
            }

            if (src && !attrs.src) attrs.src = src;
            createArgs.push(attrs);
            return Object(_dom__WEBPACK_IMPORTED_MODULE_2__["createEl"]).apply(void 0, args);
          };
        }

        return fn;
      }

      function input1(args) {
        if (typeof args == "object") {
          var tagName = 'input';
          var attrs = {};
          var content = null;
          var value = null;
          var type = "text";
          var ignore = [];
          var data = [];
          var boot = null,
              init = null;

          for (var prop in args) {
            if (args.hasOwnProperty(prop)) {
              var val = args[prop];

              var _p = prop.toLowerCase();

              if (_p == 'type') {
                var v = typeof val == 'string' ? val.toLowerCase() : 'text';
                type = v;

                if (v == 'textarea') {
                  tagName = v;
                  ignore.push("type", "value");
                } else if (v == "select") {
                  tagName = "select";
                  ignore.push("type", "value", "data");
                } else {
                  attrs[_p] = v;
                }
              } else if (ignore.indexOf(_p) >= 0) {// next
              } else if (_p == "init") {
                init = val;
              } else if (_p == "boot") {
                boot = val;
              } else {
                attrs[prop] = val;
              }

              if (_p == 'value') {
                value = val;
              } else if (_p == 'data') {
                data = val;
              }
            }
          }

          var attributes = {};

          for (var key in attrs) {
            if (attrs.hasOwnProperty(key)) {
              var va = attrs[key];

              if (ignore.indexOf(key.toLowerCase()) >= 0) {// next
              } else {
                attributes[key] = va;
              }
            }
          }

          if (type == 'select') {
            content = [];

            if (typeof data == "object") {
              for (var vl in data) {
                if (data.hasOwnProperty(vl)) {
                  var text = data[vl];
                  var _option = {
                    value: vl
                  };

                  if (vl == value) {
                    _option.selected = "selected";
                  }

                  content.push(Object(_dom__WEBPACK_IMPORTED_MODULE_2__["createEl"])('option', text, _option));
                }
              }
            }
          } else if (type == "textarea") {
            content = value;
          } else {
            content = attributes;
          }

          return _dom__WEBPACK_IMPORTED_MODULE_2__["create"].call(this, tagName, attributes, content, boot, init);
        }

        return null;
      }

      ;

      function input2(args) {
        if (typeof args == "object") {
          var tagName = 'input';
          var attrs = {};
          var content = null;
          var value = null;
          var type = "text";
          var ignore = [];
          var data = [];
          var boot = null,
              init = null;

          for (var prop in args) {
            if (args.hasOwnProperty(prop)) {
              var val = args[prop];

              var _p2 = prop.toLowerCase();

              if (_p2 == 'type') {
                var v = typeof val == 'string' ? val.toLowerCase() : 'text';
                type = v;

                if (v == 'textarea') {
                  tagName = v;
                  ignore.push("type", "value");
                } else if (v == "select") {
                  tagName = "select";
                  ignore.push("type", "value", "data");
                } else {
                  attrs[_p2] = v;
                }
              } else if (ignore.indexOf(_p2) >= 0) {// next
              } else if (_p2 == "init") {
                init = val;
              } else if (_p2 == "boot") {
                boot = val;
              } else {
                attrs[prop] = val;
              }

              if (_p2 == 'value') {
                value = val;
              } else if (_p2 == 'data') {
                data = val;
              }
            }
          }

          var attributes = {};

          for (var key in attrs) {
            if (attrs.hasOwnProperty(key)) {
              var va = attrs[key];

              if (ignore.indexOf(key.toLowerCase()) >= 0) {// next
              } else {
                attributes[key] = va;
              }
            }
          }

          if (type == 'select') {
            content = [];

            if (typeof data == "object") {
              for (var vl in data) {
                if (data.hasOwnProperty(vl)) {
                  var text = data[vl];
                  var _option2 = {
                    value: vl
                  };

                  if (vl == value) {
                    _option2.selected = "selected";
                  }

                  content.push(Object(_dom__WEBPACK_IMPORTED_MODULE_2__["createEl"])('option', text, _option2));
                }
              }
            }
          } else if (type == "textarea") {
            content = value;
          } else {
            content = attributes;
          }

          return Object(_dom__WEBPACK_IMPORTED_MODULE_2__["createEl"])(tagName, attributes, content, boot, init);
        }

        return null;
      }

      ;
      var A = createElementClass("a"),
          Abbr = createElementClass("abbr"),
          Acronym = createElementClass("acronym"),
          Address = createElementClass("address"),
          Applet = createElementClass("applet"),
          Area = createElementClass("area"),
          Article = createElementClass("article"),
          Aside = createElementClass("aside"),
          Audio = createElementClass("audio");
      var B = createElementClass("b"),
          Base = createElementClass("base"),
          Basefont = createElementClass("basefont"),
          Bb = createElementClass("bb"),
          Bdo = createElementClass("bdo"),
          Big = createElementClass("big"),
          Blockquote = createElementClass("blockquote"),
          Body = createElementClass("body"),
          Br = createElementClass("br"),
          Button = createElementClass("button");
      var Canvas = createElementClass("canvas"),
          Caption = createElementClass("caption"),
          Center = createElementClass("center"),
          Cite = createElementClass("cite"),
          Code = createElementClass("code"),
          Col = createElementClass("col"),
          Colgroup = createElementClass("colgroup"),
          Command = createElementClass("command");
      var Datagrid = createElementClass("datagrid"),
          Datalist = createElementClass("datalist"),
          Dd = createElementClass("dd"),
          Del = createElementClass("del"),
          Details = createElementClass("details"),
          Dfn = createElementClass("dfn"),
          Dialog = createElementClass("dialog"),
          Dir = createElementClass("dir"),
          Div = createElementClass("div"),
          Dl = createElementClass("dl"),
          Dt = createElementClass("dt");
      var Em = createElementClass("em"),
          Embed = createElementClass("embed"),
          Eventsource = createElementClass("eventsource");
      var Fieldset = createElementClass("fieldset"),
          Figcaption = createElementClass("figcaption"),
          Figure = createElementClass("figure"),
          Font = createElementClass("font"),
          Footer = createElementClass("footer"),
          Form = createElementClass("form"),
          Frame = createElementClass("frame"),
          Frameset = createElementClass("frameset");
      var H1 = createElementClass("h1"),
          H2 = createElementClass("h2"),
          H3 = createElementClass("h3"),
          H4 = createElementClass("h4"),
          H5 = createElementClass("h5"),
          H6 = createElementClass("h6"),
          Head = createElementClass("head"),
          Header = createElementClass("header"),
          Hgroup = createElementClass("hgroup"),
          Hr = createElementClass("hr");
      var I = createElementClass("i"),
          Iframe = createElementClass("iframe"),
          Img = createElementClass("img"),
          Input = createElementClass("input"),
          Ins = createElementClass("ins"),
          Isindex = createElementClass("isindex");
      var Kbd = createElementClass("kbd"),
          Keygen = createElementClass("keygen");
      var Label = createElementClass("label"),
          Legend = createElementClass("legend"),
          Li = createElementClass("li"),
          Link = createElementClass("link");
      var Map = createElementClass("map"),
          Mark = createElementClass("mark"),
          Menu = createElementClass("menu"),
          Meta = createElementClass("meta"),
          Meter = createElementClass("meter");
      var Nav = createElementClass("nav"),
          Noframes = createElementClass("noframes"),
          Noscript = createElementClass("noscript");
      var Ol = createElementClass("ol"),
          Optgroup = createElementClass("optgroup"),
          Option = createElementClass("option"),
          Output = createElementClass("output");
      var P = createElementClass("p"),
          Param = createElementClass("param"),
          Pre = createElementClass("pre"),
          Progress = createElementClass("progress");
      var Q = createElementClass("q");
      var Rp = createElementClass("rp"),
          Rt = createElementClass("rt"),
          Ruby = createElementClass("ruby"),
          S = createElementClass("s");
      var Samp = createElementClass("samp"),
          Script = createElementClass("script"),
          Section = createElementClass("section"),
          Select = createElementClass("select"),
          Small = createElementClass("small"),
          Source = createElementClass("source"),
          Span = createElementClass("span"),
          Strike = createElementClass("strike"),
          Strong = createElementClass("strong"),
          Style = createElementClass("style"),
          Sub = createElementClass("sub"),
          Sup = createElementClass("sup");
      var Table = createElementClass("table"),
          Tbody = createElementClass("tbody"),
          Td = createElementClass("td"),
          Textarea = createElementClass("textarea"),
          Tfoot = createElementClass("tfoot"),
          Th = createElementClass("th"),
          Thead = createElementClass("thead"),
          Time = createElementClass("time"),
          Title = createElementClass("title"),
          Tr = createElementClass("tr"),
          Track = createElementClass("track"),
          Tt = createElementClass("tt");
      var U = createElementClass("u"),
          Ul = createElementClass("ul");
      var Video = createElementClass("video");
      var Wbr = createElementClass("wbr");
      var a = createHtmlElementFunction("a"),
          abbr = createHtmlElementFunction("abbr"),
          acronym = createHtmlElementFunction("acronym"),
          address = createHtmlElementFunction("address"),
          applet = createHtmlElementFunction("applet"),
          area = createHtmlElementFunction("area"),
          article = createHtmlElementFunction("article"),
          aside = createHtmlElementFunction("aside"),
          audio = createHtmlElementFunction("audio"),
          b = createHtmlElementFunction("b"),
          base = createHtmlElementFunction("base"),
          basefont = createHtmlElementFunction("basefont"),
          bb = createHtmlElementFunction("bb"),
          bdo = createHtmlElementFunction("bdo"),
          big = createHtmlElementFunction("big"),
          blockquote = createHtmlElementFunction("blockquote"),
          body = createHtmlElementFunction("body"),
          br = createHtmlElementFunction("br"),
          button = createHtmlElementFunction("button"),
          canvas = createHtmlElementFunction("canvas"),
          caption = createHtmlElementFunction("caption"),
          center = createHtmlElementFunction("center"),
          cite = createHtmlElementFunction("cite"),
          code = createHtmlElementFunction("code"),
          col = createHtmlElementFunction("col"),
          colgroup = createHtmlElementFunction("colgroup"),
          command = createHtmlElementFunction("command"),
          datagrid = createHtmlElementFunction("datagrid"),
          datalist = createHtmlElementFunction("datalist"),
          dd = createHtmlElementFunction("dd"),
          del = createHtmlElementFunction("del"),
          details = createHtmlElementFunction("details"),
          dfn = createHtmlElementFunction("dfn"),
          dialog = createHtmlElementFunction("dialog"),
          dir = createHtmlElementFunction("dir"),
          div = createHtmlElementFunction("div"),
          dl = createHtmlElementFunction("dl"),
          dt = createHtmlElementFunction("dt"),
          em = createHtmlElementFunction("em"),
          embed = createHtmlElementFunction("embed"),
          eventsource = createHtmlElementFunction("eventsource"),
          fieldset = createHtmlElementFunction("fieldset"),
          figcaption = createHtmlElementFunction("figcaption"),
          figure = createHtmlElementFunction("figure"),
          font = createHtmlElementFunction("font"),
          footer = createHtmlElementFunction("footer"),
          form = createHtmlElementFunction("form"),
          frame = createHtmlElementFunction("frame"),
          frameset = createHtmlElementFunction("frameset"),
          h1 = createHtmlElementFunction("h1"),
          h2 = createHtmlElementFunction("h2"),
          h3 = createHtmlElementFunction("h3"),
          h4 = createHtmlElementFunction("h4"),
          h5 = createHtmlElementFunction("h5"),
          h6 = createHtmlElementFunction("h6"),
          head = createHtmlElementFunction("head"),
          header = createHtmlElementFunction("header"),
          hgroup = createHtmlElementFunction("hgroup"),
          hr = createHtmlElementFunction("hr"),
          i = createHtmlElementFunction("i"),
          iframe = createHtmlElementFunction("iframe"),
          img = createHtmlElementFunction("img"),
          input = createHtmlElementFunction("input"),
          ins = createHtmlElementFunction("ins"),
          isindex = createHtmlElementFunction("isindex"),
          kbd = createHtmlElementFunction("kbd"),
          keygen = createHtmlElementFunction("keygen"),
          label = createHtmlElementFunction("label"),
          legend = createHtmlElementFunction("legend"),
          li = createHtmlElementFunction("li"),
          link = createHtmlElementFunction("link"),
          map = createHtmlElementFunction("map"),
          mark = createHtmlElementFunction("mark"),
          menu = createHtmlElementFunction("menu"),
          meta = createHtmlElementFunction("meta"),
          meter = createHtmlElementFunction("meter"),
          nav = createHtmlElementFunction("nav"),
          noframes = createHtmlElementFunction("noframes"),
          noscript = createHtmlElementFunction("noscript"),
          ol = createHtmlElementFunction("ol"),
          optgroup = createHtmlElementFunction("optgroup"),
          option = createHtmlElementFunction("option"),
          output = createHtmlElementFunction("output"),
          p = createHtmlElementFunction("p"),
          param = createHtmlElementFunction("param"),
          pre = createHtmlElementFunction("pre"),
          progress = createHtmlElementFunction("progress"),
          q = createHtmlElementFunction("q"),
          rp = createHtmlElementFunction("rp"),
          rt = createHtmlElementFunction("rt"),
          ruby = createHtmlElementFunction("ruby"),
          s = createHtmlElementFunction("s"),
          samp = createHtmlElementFunction("samp"),
          script = createHtmlElementFunction("script"),
          section = createHtmlElementFunction("section"),
          select = createHtmlElementFunction("select"),
          small = createHtmlElementFunction("small"),
          source = createHtmlElementFunction("source"),
          span = createHtmlElementFunction("span"),
          strike = createHtmlElementFunction("strike"),
          strong = createHtmlElementFunction("strong"),
          style = createHtmlElementFunction("style"),
          sub = createHtmlElementFunction("sub"),
          sup = createHtmlElementFunction("sup"),
          table = createHtmlElementFunction("table"),
          tbody = createHtmlElementFunction("tbody"),
          td = createHtmlElementFunction("td"),
          textarea = createHtmlElementFunction("textarea"),
          tfoot = createHtmlElementFunction("tfoot"),
          th = createHtmlElementFunction("th"),
          thead = createHtmlElementFunction("thead"),
          time = createHtmlElementFunction("time"),
          title = createHtmlElementFunction("title"),
          tr = createHtmlElementFunction("tr"),
          track = createHtmlElementFunction("track"),
          tt = createHtmlElementFunction("tt"),
          u = createHtmlElementFunction("u"),
          ul = createHtmlElementFunction("ul"),
          video = createHtmlElementFunction("video"),
          wbr = createHtmlElementFunction("wbr");
      /**
       * Tạo đối tượng dom
       * @param {string|object} selector
       * @param {string|Element|string[]|Element[]} children
       * @param {object} attributes
       * @returns {DomFactory}
       * @note {string} Đoạn này thật ra không cần thiết. nhưng viết bào để trình soạn thảo sử dụng gợi ỳ
       */

      var Html = function () {
        var $class = Object(_es5_class__WEBPACK_IMPORTED_MODULE_1__["_class"])("Html")["extends"](_dom__WEBPACK_IMPORTED_MODULE_2__["default"])({
          const$isHtml: true,
          __call: function __call() {
            return Object(_dom__WEBPACK_IMPORTED_MODULE_2__["createEl"]).apply(void 0, arguments);
          }
        });
        return $class;
      }();

      Html["static"]({
        A: A,
        Abbr: Abbr,
        Acronym: Acronym,
        Address: Address,
        Applet: Applet,
        Area: Area,
        Article: Article,
        Aside: Aside,
        Audio: Audio,
        B: B,
        Base: Base,
        Basefont: Basefont,
        Bb: Bb,
        Bdo: Bdo,
        Big: Big,
        Blockquote: Blockquote,
        Body: Body,
        Br: Br,
        Button: Button,
        Canvas: Canvas,
        Caption: Caption,
        Center: Center,
        Cite: Cite,
        Code: Code,
        Col: Col,
        Colgroup: Colgroup,
        Command: Command,
        Datagrid: Datagrid,
        Datalist: Datalist,
        Dd: Dd,
        Del: Del,
        Details: Details,
        Dfn: Dfn,
        Dialog: Dialog,
        Dir: Dir,
        Div: Div,
        Dl: Dl,
        Dt: Dt,
        Em: Em,
        Embed: Embed,
        Eventsource: Eventsource,
        Fieldset: Fieldset,
        Figcaption: Figcaption,
        Figure: Figure,
        Font: Font,
        Footer: Footer,
        Form: Form,
        Frame: Frame,
        Frameset: Frameset,
        H1: H1,
        H2: H2,
        H3: H3,
        H4: H4,
        H5: H5,
        H6: H6,
        Head: Head,
        Header: Header,
        Hgroup: Hgroup,
        Hr: Hr,
        I: I,
        Iframe: Iframe,
        Img: Img,
        Input: Input,
        Ins: Ins,
        Isindex: Isindex,
        Kbd: Kbd,
        Keygen: Keygen,
        Label: Label,
        Legend: Legend,
        Li: Li,
        Link: Link,
        Map: Map,
        Mark: Mark,
        Menu: Menu,
        Meta: Meta,
        Meter: Meter,
        Nav: Nav,
        Noframes: Noframes,
        Noscript: Noscript,
        Ol: Ol,
        Optgroup: Optgroup,
        Option: Option,
        Output: Output,
        P: P,
        Param: Param,
        Pre: Pre,
        Progress: Progress,
        Q: Q,
        Rp: Rp,
        Rt: Rt,
        Ruby: Ruby,
        S: S,
        Samp: Samp,
        Script: Script,
        Section: Section,
        Select: Select,
        Small: Small,
        Source: Source,
        Span: Span,
        Strike: Strike,
        Strong: Strong,
        Style: Style,
        Sub: Sub,
        Sup: Sup,
        Table: Table,
        Tbody: Tbody,
        Td: Td,
        Textarea: Textarea,
        Tfoot: Tfoot,
        Th: Th,
        Thead: Thead,
        Time: Time,
        Title: Title,
        Tr: Tr,
        Track: Track,
        Tt: Tt,
        U: U,
        Ul: Ul,
        Video: Video,
        Wbr: Wbr,
        a: a,
        abbr: abbr,
        acronym: acronym,
        address: address,
        applet: applet,
        area: area,
        article: article,
        aside: aside,
        audio: audio,
        b: b,
        base: base,
        basefont: basefont,
        bb: bb,
        bdo: bdo,
        big: big,
        blockquote: blockquote,
        body: body,
        br: br,
        button: button,
        canvas: canvas,
        caption: caption,
        center: center,
        cite: cite,
        code: code,
        col: col,
        colgroup: colgroup,
        command: command,
        datagrid: datagrid,
        datalist: datalist,
        dd: dd,
        del: del,
        details: details,
        dfn: dfn,
        dialog: dialog,
        dir: dir,
        div: div,
        dl: dl,
        dt: dt,
        em: em,
        embed: embed,
        eventsource: eventsource,
        fieldset: fieldset,
        figcaption: figcaption,
        figure: figure,
        font: font,
        footer: footer,
        form: form,
        frame: frame,
        frameset: frameset,
        h1: h1,
        h2: h2,
        h3: h3,
        h4: h4,
        h5: h5,
        h6: h6,
        head: head,
        header: header,
        hgroup: hgroup,
        hr: hr,
        i: i,
        iframe: iframe,
        img: img,
        input: input,
        ins: ins,
        isindex: isindex,
        kbd: kbd,
        keygen: keygen,
        label: label,
        legend: legend,
        li: li,
        link: link,
        map: map,
        mark: mark,
        menu: menu,
        meta: meta,
        meter: meter,
        nav: nav,
        noframes: noframes,
        noscript: noscript,
        ol: ol,
        optgroup: optgroup,
        option: option,
        output: output,
        p: p,
        param: param,
        pre: pre,
        progress: progress,
        q: q,
        rp: rp,
        rt: rt,
        ruby: ruby,
        s: s,
        samp: samp,
        script: script,
        section: section,
        select: select,
        small: small,
        source: source,
        span: span,
        strike: strike,
        strong: strong,
        style: style,
        sub: sub,
        sup: sup,
        table: table,
        tbody: tbody,
        td: td,
        textarea: textarea,
        tfoot: tfoot,
        th: th,
        thead: thead,
        time: time,
        title: title,
        tr: tr,
        track: track,
        tt: tt,
        u: u,
        ul: ul,
        video: video,
        wbr: wbr
      });
      /* harmony default export */

      __webpack_exports__["default"] = Html;
      /***/
    }
  }]);
})();
//# sourceMappingURL=default~project-page-project-module~template-page-template-module-es5.js.map