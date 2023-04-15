(function () {
  function _toConsumableArray(arr) { return _arrayWithoutHoles(arr) || _iterableToArray(arr) || _unsupportedIterableToArray(arr) || _nonIterableSpread(); }

  function _nonIterableSpread() { throw new TypeError("Invalid attempt to spread non-iterable instance.\nIn order to be iterable, non-array objects must have a [Symbol.iterator]() method."); }

  function _unsupportedIterableToArray(o, minLen) { if (!o) return; if (typeof o === "string") return _arrayLikeToArray(o, minLen); var n = Object.prototype.toString.call(o).slice(8, -1); if (n === "Object" && o.constructor) n = o.constructor.name; if (n === "Map" || n === "Set") return Array.from(o); if (n === "Arguments" || /^(?:Ui|I)nt(?:8|16|32)(?:Clamped)?Array$/.test(n)) return _arrayLikeToArray(o, minLen); }

  function _iterableToArray(iter) { if (typeof Symbol !== "undefined" && iter[Symbol.iterator] != null || iter["@@iterator"] != null) return Array.from(iter); }

  function _arrayWithoutHoles(arr) { if (Array.isArray(arr)) return _arrayLikeToArray(arr); }

  function _arrayLikeToArray(arr, len) { if (len == null || len > arr.length) len = arr.length; for (var i = 0, arr2 = new Array(len); i < len; i++) { arr2[i] = arr[i]; } return arr2; }

  function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }

  function _defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } }

  function _createClass(Constructor, protoProps, staticProps) { if (protoProps) _defineProperties(Constructor.prototype, protoProps); if (staticProps) _defineProperties(Constructor, staticProps); return Constructor; }

  function _inherits(subClass, superClass) { if (typeof superClass !== "function" && superClass !== null) { throw new TypeError("Super expression must either be null or a function"); } subClass.prototype = Object.create(superClass && superClass.prototype, { constructor: { value: subClass, writable: true, configurable: true } }); if (superClass) _setPrototypeOf(subClass, superClass); }

  function _setPrototypeOf(o, p) { _setPrototypeOf = Object.setPrototypeOf || function _setPrototypeOf(o, p) { o.__proto__ = p; return o; }; return _setPrototypeOf(o, p); }

  function _createSuper(Derived) { var hasNativeReflectConstruct = _isNativeReflectConstruct(); return function _createSuperInternal() { var Super = _getPrototypeOf(Derived), result; if (hasNativeReflectConstruct) { var NewTarget = _getPrototypeOf(this).constructor; result = Reflect.construct(Super, arguments, NewTarget); } else { result = Super.apply(this, arguments); } return _possibleConstructorReturn(this, result); }; }

  function _possibleConstructorReturn(self, call) { if (call && (typeof call === "object" || typeof call === "function")) { return call; } else if (call !== void 0) { throw new TypeError("Derived constructors may only return object or undefined"); } return _assertThisInitialized(self); }

  function _assertThisInitialized(self) { if (self === void 0) { throw new ReferenceError("this hasn't been initialised - super() hasn't been called"); } return self; }

  function _isNativeReflectConstruct() { if (typeof Reflect === "undefined" || !Reflect.construct) return false; if (Reflect.construct.sham) return false; if (typeof Proxy === "function") return true; try { Boolean.prototype.valueOf.call(Reflect.construct(Boolean, [], function () {})); return true; } catch (e) { return false; } }

  function _getPrototypeOf(o) { _getPrototypeOf = Object.setPrototypeOf ? Object.getPrototypeOf : function _getPrototypeOf(o) { return o.__proto__ || Object.getPrototypeOf(o); }; return _getPrototypeOf(o); }

  (window["webpackJsonp"] = window["webpackJsonp"] || []).push([["project-page-project-module"], {
    /***/
    "77qd": function qd(module, __webpack_exports__, __webpack_require__) {
      "use strict";

      __webpack_require__.r(__webpack_exports__);
      /* harmony export (binding) */


      __webpack_require__.d(__webpack_exports__, "EProjectStatus", function () {
        return EProjectStatus;
      });

      var EProjectStatus;

      (function (EProjectStatus) {
        EProjectStatus["draft"] = "draft";
        EProjectStatus["published"] = "published";
      })(EProjectStatus || (EProjectStatus = {}));
      /***/

    },

    /***/
    "Eydw": function Eydw(module, __webpack_exports__, __webpack_require__) {
      "use strict";

      __webpack_require__.r(__webpack_exports__);
      /* harmony import */


      var _reducers__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(
      /*! ./reducers */
      "zhHN");
      /* harmony reexport (safe) */


      __webpack_require__.d(__webpack_exports__, "reducers", function () {
        return _reducers__WEBPACK_IMPORTED_MODULE_0__["reducers"];
      });
      /* harmony reexport (safe) */


      __webpack_require__.d(__webpack_exports__, "selectContainerState", function () {
        return _reducers__WEBPACK_IMPORTED_MODULE_0__["selectContainerState"];
      });
      /* harmony import */


      var _effects__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(
      /*! ./effects */
      "peC7");
      /* harmony reexport (safe) */


      __webpack_require__.d(__webpack_exports__, "effects", function () {
        return _effects__WEBPACK_IMPORTED_MODULE_1__["effects"];
      });
      /* harmony import */


      var _services__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(
      /*! ./services */
      "wJCM");
      /* harmony reexport (safe) */


      __webpack_require__.d(__webpack_exports__, "services", function () {
        return _services__WEBPACK_IMPORTED_MODULE_2__["services"];
      }); // export * from './actions';
      // export * from './selectors';
      // export * from './item';
      // export * from './category';

      /***/

    },

    /***/
    "MzbB": function MzbB(module, __webpack_exports__, __webpack_require__) {
      "use strict";

      __webpack_require__.r(__webpack_exports__);
      /* harmony export (binding) */


      __webpack_require__.d(__webpack_exports__, "HeaderComponent", function () {
        return HeaderComponent;
      });
      /* harmony import */


      var _angular_core__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(
      /*! @angular/core */
      "fXoL");
      /* harmony import */


      var _app_core_config__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(
      /*! @app/_core/config */
      "3lvd");
      /* harmony import */


      var _app_shared_components_base_base_component__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(
      /*! @app/_shared/components/base/base.component */
      "rtba");
      /* harmony import */


      var _app_3D_services_app_editor_storage_service__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(
      /*! @app/_3D/services/app-editor-storage.service */
      "SjHM");
      /* harmony import */


      var ng_zorro_antd_button__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(
      /*! ng-zorro-antd/button */
      "OzZK");
      /* harmony import */


      var ng_zorro_antd_core_transition_patch__WEBPACK_IMPORTED_MODULE_5__ = __webpack_require__(
      /*! ng-zorro-antd/core/transition-patch */
      "C2AL");

      var _c0 = ["inputElement"];

      var HeaderComponent = /*#__PURE__*/function (_app_shared_component) {
        _inherits(HeaderComponent, _app_shared_component);

        var _super = _createSuper(HeaderComponent);

        function HeaderComponent(storage, cd) {
          var _this;

          _classCallCheck(this, HeaderComponent);

          _this = _super.call(this);
          _this.storage = storage;
          _this.cd = cd;
          _this.clickSave = new _angular_core__WEBPACK_IMPORTED_MODULE_0__["EventEmitter"]();
          _this.isVisible = false;
          _this.percent = 0;
          _this.renderLoading = true;
          _this.downloadUrl = 'javascript:void(0);';
          _this.downloadAvailable = false;
          _this.mode = 'list';
          _this.isInited = false;
          _this.logo = Object(_app_core_config__WEBPACK_IMPORTED_MODULE_1__["getConfig"])('urls.logo_url');
          _this.link = Object(_app_core_config__WEBPACK_IMPORTED_MODULE_1__["getConfig"])('urls.logo_link');
          return _this;
        }

        _createClass(HeaderComponent, [{
          key: "initFirst",
          value: function initFirst() {
            var _this2 = this;

            if (!this.isInited) {
              this.storage.subcribe('project', function (data) {
                if (data && data.download_source_url) {
                  _this2.downloadAvailable = true;
                  _this2.downloadUrl = data.download_source_url;
                }
              }, true);
              this.storage.subcribe('editorMode', function (mode) {
                _this2.mode = mode;

                _this2.cd.detectChanges();
              }, true); // window['hdStorage'] = this.storage;

              this.isInited = true;
            }
          }
        }, {
          key: "download",
          value: function download(event) {
            if (!this.downloadAvailable) {
              event.preventDefault();
              return false;
            }
          }
        }, {
          key: "save",
          value: function save(event) {
            // console.log(this.editor.data);
            this.clickSave.emit(true);
          }
        }, {
          key: "handleOk",
          value: function handleOk() {
            this.isVisible = false;
          }
        }, {
          key: "handleCancel",
          value: function handleCancel() {
            this.isVisible = false;
          }
        }, {
          key: "onClickUndo",
          value: function onClickUndo() {// this.editor.historyManager.undo();
          }
        }, {
          key: "onClickRedo",
          value: function onClickRedo() {// this.editor.historyManager.redo();
          }
        }]);

        return HeaderComponent;
      }(_app_shared_components_base_base_component__WEBPACK_IMPORTED_MODULE_2__["BaseComponent"]);

      HeaderComponent.ɵfac = function HeaderComponent_Factory(t) {
        return new (t || HeaderComponent)(_angular_core__WEBPACK_IMPORTED_MODULE_0__["ɵɵdirectiveInject"](_app_3D_services_app_editor_storage_service__WEBPACK_IMPORTED_MODULE_3__["AppEditorStorageService"]), _angular_core__WEBPACK_IMPORTED_MODULE_0__["ɵɵdirectiveInject"](_angular_core__WEBPACK_IMPORTED_MODULE_0__["ChangeDetectorRef"]));
      };

      HeaderComponent.ɵcmp = _angular_core__WEBPACK_IMPORTED_MODULE_0__["ɵɵdefineComponent"]({
        type: HeaderComponent,
        selectors: [["app-header"]],
        viewQuery: function HeaderComponent_Query(rf, ctx) {
          if (rf & 1) {
            _angular_core__WEBPACK_IMPORTED_MODULE_0__["ɵɵviewQuery"](_c0, 1);
          }

          if (rf & 2) {
            var _t;

            _angular_core__WEBPACK_IMPORTED_MODULE_0__["ɵɵqueryRefresh"](_t = _angular_core__WEBPACK_IMPORTED_MODULE_0__["ɵɵloadQuery"]()) && (ctx.inputElement = _t.first);
          }
        },
        outputs: {
          clickSave: "clickSave"
        },
        features: [_angular_core__WEBPACK_IMPORTED_MODULE_0__["ɵɵInheritDefinitionFeature"]],
        decls: 17,
        vars: 1,
        consts: [[1, "group-first"], ["href", "{link}", "target", "_blank"], ["alt", "Cretip logo", 1, "logo", 3, "src"], [1, "group-center"], ["nz-button", "", "nzType", "text", 1, "btn", "btn-ghost", "btn-icon", 3, "click"], ["src", "/assets/icons/new-design/header/undo.svg"], ["nz-button", "", "nzType", "text", 1, "btn", "btn-ghost", "btn-icon", "mr-auto", 3, "click"], ["src", "/assets/icons/new-design/header/redo.svg"], ["nz-button", "", "nzType", "text", 1, "btn", "btn-ghost", "btn-icon", "hidden", "invisble", 3, "click"], ["src", "/assets/icons/new-design/header/save.svg"], [1, "group-last"], ["nz-button", "", "nzType", "text", 1, "btn", "btn-primary", "btn-icon", 3, "click"]],
        template: function HeaderComponent_Template(rf, ctx) {
          if (rf & 1) {
            _angular_core__WEBPACK_IMPORTED_MODULE_0__["ɵɵelementStart"](0, "div", 0);

            _angular_core__WEBPACK_IMPORTED_MODULE_0__["ɵɵelementStart"](1, "a", 1);

            _angular_core__WEBPACK_IMPORTED_MODULE_0__["ɵɵelement"](2, "img", 2);

            _angular_core__WEBPACK_IMPORTED_MODULE_0__["ɵɵelementEnd"]();

            _angular_core__WEBPACK_IMPORTED_MODULE_0__["ɵɵelementStart"](3, "div", 3);

            _angular_core__WEBPACK_IMPORTED_MODULE_0__["ɵɵelementStart"](4, "button", 4);

            _angular_core__WEBPACK_IMPORTED_MODULE_0__["ɵɵlistener"]("click", function HeaderComponent_Template_button_click_4_listener() {
              return ctx.onClickUndo();
            });

            _angular_core__WEBPACK_IMPORTED_MODULE_0__["ɵɵelement"](5, "img", 5);

            _angular_core__WEBPACK_IMPORTED_MODULE_0__["ɵɵelementEnd"]();

            _angular_core__WEBPACK_IMPORTED_MODULE_0__["ɵɵelementStart"](6, "button", 6);

            _angular_core__WEBPACK_IMPORTED_MODULE_0__["ɵɵlistener"]("click", function HeaderComponent_Template_button_click_6_listener() {
              return ctx.onClickRedo();
            });

            _angular_core__WEBPACK_IMPORTED_MODULE_0__["ɵɵelement"](7, "img", 7);

            _angular_core__WEBPACK_IMPORTED_MODULE_0__["ɵɵelementEnd"]();

            _angular_core__WEBPACK_IMPORTED_MODULE_0__["ɵɵelementStart"](8, "button", 8);

            _angular_core__WEBPACK_IMPORTED_MODULE_0__["ɵɵlistener"]("click", function HeaderComponent_Template_button_click_8_listener($event) {
              return ctx.save($event);
            });

            _angular_core__WEBPACK_IMPORTED_MODULE_0__["ɵɵelement"](9, "img", 9);

            _angular_core__WEBPACK_IMPORTED_MODULE_0__["ɵɵelementStart"](10, "span");

            _angular_core__WEBPACK_IMPORTED_MODULE_0__["ɵɵtext"](11, "Save");

            _angular_core__WEBPACK_IMPORTED_MODULE_0__["ɵɵelementEnd"]();

            _angular_core__WEBPACK_IMPORTED_MODULE_0__["ɵɵelementEnd"]();

            _angular_core__WEBPACK_IMPORTED_MODULE_0__["ɵɵelementEnd"]();

            _angular_core__WEBPACK_IMPORTED_MODULE_0__["ɵɵelementEnd"]();

            _angular_core__WEBPACK_IMPORTED_MODULE_0__["ɵɵelementStart"](12, "div", 10);

            _angular_core__WEBPACK_IMPORTED_MODULE_0__["ɵɵelementStart"](13, "button", 11);

            _angular_core__WEBPACK_IMPORTED_MODULE_0__["ɵɵlistener"]("click", function HeaderComponent_Template_button_click_13_listener($event) {
              return ctx.save($event);
            });

            _angular_core__WEBPACK_IMPORTED_MODULE_0__["ɵɵelement"](14, "img", 9);

            _angular_core__WEBPACK_IMPORTED_MODULE_0__["ɵɵelementStart"](15, "span");

            _angular_core__WEBPACK_IMPORTED_MODULE_0__["ɵɵtext"](16, "Save");

            _angular_core__WEBPACK_IMPORTED_MODULE_0__["ɵɵelementEnd"]();

            _angular_core__WEBPACK_IMPORTED_MODULE_0__["ɵɵelementEnd"]();

            _angular_core__WEBPACK_IMPORTED_MODULE_0__["ɵɵelementEnd"]();
          }

          if (rf & 2) {
            _angular_core__WEBPACK_IMPORTED_MODULE_0__["ɵɵadvance"](2);

            _angular_core__WEBPACK_IMPORTED_MODULE_0__["ɵɵpropertyInterpolate"]("src", ctx.logo, _angular_core__WEBPACK_IMPORTED_MODULE_0__["ɵɵsanitizeUrl"]);
          }
        },
        directives: [ng_zorro_antd_button__WEBPACK_IMPORTED_MODULE_4__["NzButtonComponent"], ng_zorro_antd_core_transition_patch__WEBPACK_IMPORTED_MODULE_5__["ɵNzTransitionPatchDirective"]],
        styles: ["[_nghost-%COMP%] {\n  display: flex;\n  justify-content: space-between;\n  align-items: center;\n  width: 100%;\n  padding: 0 24px;\n}\n\n.group-first[_ngcontent-%COMP%] {\n  display: flex;\n  justify-content: space-between;\n  width: 576px;\n}\n\n.group-center[_ngcontent-%COMP%] {\n  display: flex;\n  justify-content: space-between;\n  width: 220px;\n  align-items: center;\n}\n\n.group-center[_ngcontent-%COMP%]   .btn[_ngcontent-%COMP%] {\n  margin-right: 8px;\n}\n\n.group-center[_ngcontent-%COMP%]   .btn[_ngcontent-%COMP%]:last-child {\n  margin-left: 8px;\n}\n\n.group-last[_ngcontent-%COMP%] {\n  display: flex;\n  justify-content: space-between;\n  margin-right: 70px;\n}\n\n.logo[_ngcontent-%COMP%] {\n  width: 46px;\n  height: auto;\n}\n\n.btn[_ngcontent-%COMP%] {\n  height: 28px;\n  padding: 4px 16px;\n  line-height: 1.3;\n  border-radius: 4px;\n  cursor: pointer;\n}\n\n.btn-ghost[_ngcontent-%COMP%] {\n  background-color: #1b1818;\n  border: 1px solid #c6c6c6;\n  color: #c6c6c6;\n  border: none;\n}\n\n.btn-ghost[_ngcontent-%COMP%]:hover {\n  background-color: #262222;\n  color: white;\n}\n\n.btn-primary[_ngcontent-%COMP%] {\n  background-color: #4a4ded;\n  color: white;\n  border: none;\n}\n\n.btn-primary[_ngcontent-%COMP%]:hover {\n  background-color: #4a4dedb0;\n}\n\n.btn-icon[_ngcontent-%COMP%] {\n  display: flex;\n  align-items: center;\n}\n\n.btn-icon[_ngcontent-%COMP%]   img[_ngcontent-%COMP%], .btn-icon[_ngcontent-%COMP%]   svg[_ngcontent-%COMP%] {\n  height: 14px;\n}\n\n.btn-icon[_ngcontent-%COMP%]   span[_ngcontent-%COMP%] {\n  margin-left: 8px;\n}\n\n.ant-avatar[_ngcontent-%COMP%] {\n  cursor: pointer;\n  margin-left: 24px;\n}\n\n.mr-auto[_ngcontent-%COMP%] {\n  margin-right: auto;\n}\n\n.invisible[_ngcontent-%COMP%] {\n  opacity: 0;\n}\n/*# sourceMappingURL=data:application/json;base64,eyJ2ZXJzaW9uIjozLCJzb3VyY2VzIjpbIi4uXFwuLlxcLi5cXC4uXFxoZWFkZXIuY29tcG9uZW50LnNjc3MiXSwibmFtZXMiOltdLCJtYXBwaW5ncyI6IkFBRUE7RUFDRSxhQUFBO0VBQ0EsOEJBQUE7RUFDQSxtQkFBQTtFQUNBLFdBQUE7RUFDQSxlQUFBO0FBREY7O0FBSUE7RUFDRSxhQUFBO0VBQ0EsOEJBQUE7RUFDQSxZQUFBO0FBREY7O0FBSUE7RUFDRSxhQUFBO0VBQ0EsOEJBQUE7RUFDQSxZQUFBO0VBQ0EsbUJBQUE7QUFERjs7QUFFRTtFQUNFLGlCQUFBO0FBQUo7O0FBRUU7RUFDRSxnQkFBQTtBQUFKOztBQUlBO0VBQ0UsYUFBQTtFQUNBLDhCQUFBO0VBRUEsa0JBQUE7QUFGRjs7QUFLQTtFQUNFLFdBQUE7RUFDQSxZQUFBO0FBRkY7O0FBS0E7RUFDRSxZQUFBO0VBQ0EsaUJBQUE7RUFFQSxnQkFBQTtFQUNBLGtCQUFBO0VBQ0EsZUFBQTtBQUhGOztBQUtFO0VBQ0UseUJBQUE7RUFDQSx5QkFBQTtFQUNBLGNBQUE7RUFDQSxZQUFBO0FBSEo7O0FBSUk7RUFDRSx5QkFBQTtFQUNBLFlBQUE7QUFGTjs7QUFNRTtFQUNFLHlCQTdEWTtFQThEWixZQUFBO0VBQ0EsWUFBQTtBQUpKOztBQUtJO0VBQ0UsMkJBaEVnQjtBQTZEdEI7O0FBT0U7RUFDRSxhQUFBO0VBQ0EsbUJBQUE7QUFMSjs7QUFNSTs7RUFFRSxZQUFBO0FBSk47O0FBTUk7RUFDRSxnQkFBQTtBQUpOOztBQVNBO0VBQ0UsZUFBQTtFQUNBLGlCQUFBO0FBTkY7O0FBVUE7RUFDRSxrQkFBQTtBQVBGOztBQVNBO0VBQ0UsVUFBQTtBQU5GIiwiZmlsZSI6ImhlYWRlci5jb21wb25lbnQuc2NzcyIsInNvdXJjZXNDb250ZW50IjpbIiRwcmltYXJ5LWNvbG9yOiAjNGE0ZGVkO1xyXG4kcHJpbWFyeS1jb2xvci1ob3ZlcjogIzRhNGRlZGIwO1xyXG46aG9zdCB7XHJcbiAgZGlzcGxheTogZmxleDtcclxuICBqdXN0aWZ5LWNvbnRlbnQ6IHNwYWNlLWJldHdlZW47XHJcbiAgYWxpZ24taXRlbXM6IGNlbnRlcjtcclxuICB3aWR0aDogMTAwJTtcclxuICBwYWRkaW5nOiAwIDI0cHg7XHJcbn1cclxuXHJcbi5ncm91cC1maXJzdCB7XHJcbiAgZGlzcGxheTogZmxleDtcclxuICBqdXN0aWZ5LWNvbnRlbnQ6IHNwYWNlLWJldHdlZW47XHJcbiAgd2lkdGg6IDU3NnB4O1xyXG59XHJcblxyXG4uZ3JvdXAtY2VudGVyIHtcclxuICBkaXNwbGF5OiBmbGV4O1xyXG4gIGp1c3RpZnktY29udGVudDogc3BhY2UtYmV0d2VlbjtcclxuICB3aWR0aDogMjIwcHg7XHJcbiAgYWxpZ24taXRlbXM6IGNlbnRlcjtcclxuICAuYnRuIHtcclxuICAgIG1hcmdpbi1yaWdodDogOHB4O1xyXG4gIH1cclxuICAuYnRuOmxhc3QtY2hpbGQge1xyXG4gICAgbWFyZ2luLWxlZnQ6IDhweDtcclxuICB9XHJcbn1cclxuXHJcbi5ncm91cC1sYXN0IHtcclxuICBkaXNwbGF5OiBmbGV4O1xyXG4gIGp1c3RpZnktY29udGVudDogc3BhY2UtYmV0d2VlbjtcclxuICBcclxuICBtYXJnaW4tcmlnaHQ6IDcwcHg7XHJcbn1cclxuXHJcbi5sb2dvIHtcclxuICB3aWR0aDogNDZweDtcclxuICBoZWlnaHQ6IGF1dG87XHJcbn1cclxuXHJcbi5idG4ge1xyXG4gIGhlaWdodDogMjhweDtcclxuICBwYWRkaW5nOiA0cHggMTZweDtcclxuXHJcbiAgbGluZS1oZWlnaHQ6IDEuMztcclxuICBib3JkZXItcmFkaXVzOiA0cHg7XHJcbiAgY3Vyc29yOiBwb2ludGVyO1xyXG5cclxuICAmLWdob3N0IHtcclxuICAgIGJhY2tncm91bmQtY29sb3I6ICMxYjE4MTg7XHJcbiAgICBib3JkZXI6IDFweCBzb2xpZCAjYzZjNmM2O1xyXG4gICAgY29sb3I6ICNjNmM2YzY7XHJcbiAgICBib3JkZXI6IG5vbmU7XHJcbiAgICAmOmhvdmVyIHtcclxuICAgICAgYmFja2dyb3VuZC1jb2xvcjogIzI2MjIyMjtcclxuICAgICAgY29sb3I6IHdoaXRlO1xyXG4gICAgfVxyXG4gIH1cclxuXHJcbiAgJi1wcmltYXJ5IHtcclxuICAgIGJhY2tncm91bmQtY29sb3I6ICRwcmltYXJ5LWNvbG9yO1xyXG4gICAgY29sb3I6IHdoaXRlO1xyXG4gICAgYm9yZGVyOiBub25lO1xyXG4gICAgJjpob3ZlciB7XHJcbiAgICAgIGJhY2tncm91bmQtY29sb3I6ICRwcmltYXJ5LWNvbG9yLWhvdmVyO1xyXG4gICAgfVxyXG4gIH1cclxuXHJcbiAgJi1pY29uIHtcclxuICAgIGRpc3BsYXk6IGZsZXg7XHJcbiAgICBhbGlnbi1pdGVtczogY2VudGVyO1xyXG4gICAgaW1nLFxyXG4gICAgc3ZnIHtcclxuICAgICAgaGVpZ2h0OiAxNHB4O1xyXG4gICAgfVxyXG4gICAgc3BhbiB7XHJcbiAgICAgIG1hcmdpbi1sZWZ0OiA4cHg7XHJcbiAgICB9XHJcbiAgfVxyXG59XHJcblxyXG4uYW50LWF2YXRhciB7XHJcbiAgY3Vyc29yOiBwb2ludGVyO1xyXG4gIG1hcmdpbi1sZWZ0OiAyNHB4O1xyXG59XHJcblxyXG5cclxuLm1yLWF1dG97XHJcbiAgbWFyZ2luLXJpZ2h0OiBhdXRvO1xyXG59XHJcbi5pbnZpc2libGV7XHJcbiAgb3BhY2l0eTogMDtcclxufVxyXG4iXX0= */"]
      });
      /***/
    },

    /***/
    "PJjP": function PJjP(module, __webpack_exports__, __webpack_require__) {
      "use strict";

      __webpack_require__.r(__webpack_exports__);
      /* harmony export (binding) */


      __webpack_require__.d(__webpack_exports__, "ProjectEditorService", function () {
        return ProjectEditorService;
      });
      /* harmony import */


      var _engines_client_editor_engine__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(
      /*! ../engines/client-editor.engine */
      "5qT6");
      /* harmony import */


      var _libs_project_editor__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(
      /*! ../libs/project-editor */
      "eHQE");
      /* harmony import */


      var _app_editor_service__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(
      /*! ./app-editor.service */
      "B0oX");
      /* harmony import */


      var _angular_core__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(
      /*! @angular/core */
      "fXoL");

      var ProjectEditorService = /*#__PURE__*/function (_app_editor_service__) {
        _inherits(ProjectEditorService, _app_editor_service__);

        var _super2 = _createSuper(ProjectEditorService);

        function ProjectEditorService() {
          var _this3;

          _classCallCheck(this, ProjectEditorService);

          _this3 = _super2.apply(this, arguments);
          _this3.engineClass = _engines_client_editor_engine__WEBPACK_IMPORTED_MODULE_0__["default"];
          _this3.editorClass = _libs_project_editor__WEBPACK_IMPORTED_MODULE_1__["default"];
          return _this3;
        }

        return ProjectEditorService;
      }(_app_editor_service__WEBPACK_IMPORTED_MODULE_2__["AppEditorService"]);

      ProjectEditorService.ɵfac = function ProjectEditorService_Factory(t) {
        return ɵProjectEditorService_BaseFactory(t || ProjectEditorService);
      };

      ProjectEditorService.ɵprov = _angular_core__WEBPACK_IMPORTED_MODULE_3__["ɵɵdefineInjectable"]({
        token: ProjectEditorService,
        factory: ProjectEditorService.ɵfac,
        providedIn: 'root'
      });

      var ɵProjectEditorService_BaseFactory = /*@__PURE__*/_angular_core__WEBPACK_IMPORTED_MODULE_3__["ɵɵgetInheritedFactory"](ProjectEditorService);
      /***/

    },

    /***/
    "Vvw2": function Vvw2(module, __webpack_exports__, __webpack_require__) {
      "use strict";

      __webpack_require__.r(__webpack_exports__);
      /* harmony export (binding) */


      __webpack_require__.d(__webpack_exports__, "ENTRIES_COMPONENTS", function () {
        return ENTRIES_COMPONENTS;
      });
      /* harmony export (binding) */


      __webpack_require__.d(__webpack_exports__, "COMPONENTS", function () {
        return COMPONENTS;
      });
      /* harmony export (binding) */


      __webpack_require__.d(__webpack_exports__, "ProjectRoutingModule", function () {
        return ProjectRoutingModule;
      });
      /* harmony import */


      var _angular_router__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(
      /*! @angular/router */
      "tyNb");
      /* harmony import */


      var _workspace_workspace_component__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(
      /*! ./workspace/workspace.component */
      "lYmp");
      /* harmony import */


      var _header_header_component__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(
      /*! ./header/header.component */
      "MzbB");
      /* harmony import */


      var _angular_core__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(
      /*! @angular/core */
      "fXoL");

      var ENTRIES_COMPONENTS = [];
      var COMPONENTS = [_workspace_workspace_component__WEBPACK_IMPORTED_MODULE_1__["WorkspaceComponent"], _header_header_component__WEBPACK_IMPORTED_MODULE_2__["HeaderComponent"]];
      var routes = [{
        path: '',
        children: [{
          path: ':id/edit',
          component: _workspace_workspace_component__WEBPACK_IMPORTED_MODULE_1__["WorkspaceComponent"]
        }, {
          path: ':id/create',
          component: _workspace_workspace_component__WEBPACK_IMPORTED_MODULE_1__["WorkspaceComponent"]
        }, {
          path: ':id/update',
          component: _workspace_workspace_component__WEBPACK_IMPORTED_MODULE_1__["WorkspaceComponent"]
        }, {
          path: '**',
          redirectTo: '0/update'
        }]
      }];

      var ProjectRoutingModule = function ProjectRoutingModule() {
        _classCallCheck(this, ProjectRoutingModule);
      };

      ProjectRoutingModule.ɵfac = function ProjectRoutingModule_Factory(t) {
        return new (t || ProjectRoutingModule)();
      };

      ProjectRoutingModule.ɵmod = _angular_core__WEBPACK_IMPORTED_MODULE_3__["ɵɵdefineNgModule"]({
        type: ProjectRoutingModule
      });
      ProjectRoutingModule.ɵinj = _angular_core__WEBPACK_IMPORTED_MODULE_3__["ɵɵdefineInjector"]({
        imports: [[_angular_router__WEBPACK_IMPORTED_MODULE_0__["RouterModule"].forChild(routes)], _angular_router__WEBPACK_IMPORTED_MODULE_0__["RouterModule"]]
      });

      (function () {
        (typeof ngJitMode === "undefined" || ngJitMode) && _angular_core__WEBPACK_IMPORTED_MODULE_3__["ɵɵsetNgModuleScope"](ProjectRoutingModule, {
          imports: [_angular_router__WEBPACK_IMPORTED_MODULE_0__["RouterModule"]],
          exports: [_angular_router__WEBPACK_IMPORTED_MODULE_0__["RouterModule"]]
        });
      })();
      /***/

    },

    /***/
    "jikU": function jikU(module, __webpack_exports__, __webpack_require__) {
      "use strict";

      __webpack_require__.r(__webpack_exports__);
      /* harmony import */


      var _model__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(
      /*! ./model */
      "77qd");
      /* harmony reexport (safe) */


      __webpack_require__.d(__webpack_exports__, "EProjectStatus", function () {
        return _model__WEBPACK_IMPORTED_MODULE_0__["EProjectStatus"];
      });
      /* harmony import */


      var _service__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(
      /*! ./service */
      "ywSG");
      /* harmony reexport (safe) */


      __webpack_require__.d(__webpack_exports__, "ProjectService", function () {
        return _service__WEBPACK_IMPORTED_MODULE_1__["ProjectService"];
      });
      /***/

    },

    /***/
    "lYmp": function lYmp(module, __webpack_exports__, __webpack_require__) {
      "use strict";

      __webpack_require__.r(__webpack_exports__);
      /* harmony export (binding) */


      __webpack_require__.d(__webpack_exports__, "WorkspaceComponent", function () {
        return WorkspaceComponent;
      });
      /* harmony import */


      var _app_3D_libs_three_libs__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(
      /*! @app/_3D/libs/three.libs */
      "Mijg");
      /* harmony import */


      var _app_core_helpers_utils__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(
      /*! @app/_core/helpers/utils */
      "KgG6");
      /* harmony import */


      var _app_3D_store_data_type__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(
      /*! @app/_3D/store/data.type */
      "3eSJ");
      /* harmony import */


      var _app_shared_components_base_base_component__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(
      /*! @app/_shared/components/base/base.component */
      "rtba");
      /* harmony import */


      var _app_core_helpers_html_elements__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(
      /*! @app/_core/helpers/html-elements */
      "j/Uu");
      /* harmony import */


      var _app_core_tasks__WEBPACK_IMPORTED_MODULE_5__ = __webpack_require__(
      /*! @app/_core/tasks */
      "Q1au");
      /* harmony import */


      var _app_core_config__WEBPACK_IMPORTED_MODULE_6__ = __webpack_require__(
      /*! @app/_core/config */
      "3lvd");
      /* harmony import */


      var _angular_core__WEBPACK_IMPORTED_MODULE_7__ = __webpack_require__(
      /*! @angular/core */
      "fXoL");
      /* harmony import */


      var _angular_router__WEBPACK_IMPORTED_MODULE_8__ = __webpack_require__(
      /*! @angular/router */
      "tyNb");
      /* harmony import */


      var _app_3D_services_project_editor_service__WEBPACK_IMPORTED_MODULE_9__ = __webpack_require__(
      /*! @app/_3D/services/project-editor.service */
      "PJjP");
      /* harmony import */


      var _app_3D_services_app_editor_event_service__WEBPACK_IMPORTED_MODULE_10__ = __webpack_require__(
      /*! @app/_3D/services/app-editor-event.service */
      "Zjl/");
      /* harmony import */


      var _app_3D_services_app_editor_storage_service__WEBPACK_IMPORTED_MODULE_11__ = __webpack_require__(
      /*! @app/_3D/services/app-editor-storage.service */
      "SjHM");
      /* harmony import */


      var _app_shared_components_panels_mesh_geometry_mesh_geometry_service__WEBPACK_IMPORTED_MODULE_12__ = __webpack_require__(
      /*! @app/_shared/components/panels/mesh-geometry/mesh-geometry.service */
      "gvqx");
      /* harmony import */


      var _app_shared_components_viewport_client_edit_toolbar_client_edit_toolbar_service__WEBPACK_IMPORTED_MODULE_13__ = __webpack_require__(
      /*! @app/_shared/components/viewport/client-edit-toolbar/client-edit-toolbar.service */
      "hbV9");
      /* harmony import */


      var _app_shared_services_modal_confirm_service__WEBPACK_IMPORTED_MODULE_14__ = __webpack_require__(
      /*! @app/_shared/services/modal-confirm.service */
      "z5NX");
      /* harmony import */


      var _app_shared_components_panels_panel_model_object_panel_model_object_service__WEBPACK_IMPORTED_MODULE_15__ = __webpack_require__(
      /*! @app/_shared/components/panels/panel-model-object/panel-model-object.service */
      "HSR2");
      /* harmony import */


      var _app_shared_components_panels_panel_light_panel_light_service__WEBPACK_IMPORTED_MODULE_16__ = __webpack_require__(
      /*! @app/_shared/components/panels/panel-light/panel-light.service */
      "h5aH");
      /* harmony import */


      var _app_shared_components_viewport_editor_toolbar_editor_toolbar_service__WEBPACK_IMPORTED_MODULE_17__ = __webpack_require__(
      /*! @app/_shared/components/viewport/editor-toolbar/editor-toolbar.service */
      "bPXn");
      /* harmony import */


      var _app_shared_components_viewport_viewport_service__WEBPACK_IMPORTED_MODULE_18__ = __webpack_require__(
      /*! @app/_shared/components/viewport/viewport.service */
      "jCUF");
      /* harmony import */


      var _app_shared_components_viewport_vector_controls_vector_controls_service__WEBPACK_IMPORTED_MODULE_19__ = __webpack_require__(
      /*! @app/_shared/components/viewport/vector-controls/vector-controls.service */
      "dKis");
      /* harmony import */


      var _app_store_category__WEBPACK_IMPORTED_MODULE_20__ = __webpack_require__(
      /*! @app/_store/category */
      "aGpf");
      /* harmony import */


      var _app_store_item__WEBPACK_IMPORTED_MODULE_21__ = __webpack_require__(
      /*! @app/_store/item */
      "IZxp");
      /* harmony import */


      var _app_store_project__WEBPACK_IMPORTED_MODULE_22__ = __webpack_require__(
      /*! @app/_store/project */
      "jikU");
      /* harmony import */


      var _app_store_template__WEBPACK_IMPORTED_MODULE_23__ = __webpack_require__(
      /*! @app/_store/template */
      "hbZs");
      /* harmony import */


      var _angular_common__WEBPACK_IMPORTED_MODULE_24__ = __webpack_require__(
      /*! @angular/common */
      "ofXK");
      /* harmony import */


      var ng_zorro_antd_layout__WEBPACK_IMPORTED_MODULE_25__ = __webpack_require__(
      /*! ng-zorro-antd/layout */
      "yW9e");
      /* harmony import */


      var _header_header_component__WEBPACK_IMPORTED_MODULE_26__ = __webpack_require__(
      /*! ../header/header.component */
      "MzbB");
      /* harmony import */


      var _shared_components_editor_drag_drop_dragging_item_dragging_item_component__WEBPACK_IMPORTED_MODULE_27__ = __webpack_require__(
      /*! ../../_shared/components/editor/drag-drop/dragging-item/dragging-item.component */
      "yZhX");
      /* harmony import */


      var _shared_components_editor_drag_drop_dragging_geometry_dragging_geometry_component__WEBPACK_IMPORTED_MODULE_28__ = __webpack_require__(
      /*! ../../_shared/components/editor/drag-drop/dragging-geometry/dragging-geometry.component */
      "lDEp");
      /* harmony import */


      var _shared_components_modals_image_library_image_library_component__WEBPACK_IMPORTED_MODULE_29__ = __webpack_require__(
      /*! ../../_shared/components/modals/image-library/image-library.component */
      "iWfu");
      /* harmony import */


      var _shared_components_panels_mesh_geometry_mesh_geometry_component__WEBPACK_IMPORTED_MODULE_30__ = __webpack_require__(
      /*! ../../_shared/components/panels/mesh-geometry/mesh-geometry.component */
      "DOip");
      /* harmony import */


      var _shared_components_panels_panel_model_object_panel_model_object_component__WEBPACK_IMPORTED_MODULE_31__ = __webpack_require__(
      /*! ../../_shared/components/panels/panel-model-object/panel-model-object.component */
      "6K/U");
      /* harmony import */


      var _shared_components_panels_panel_light_panel_light_component__WEBPACK_IMPORTED_MODULE_32__ = __webpack_require__(
      /*! ../../_shared/components/panels/panel-light/panel-light.component */
      "Rwgc");
      /* harmony import */


      var _shared_components_panels_panel_mesh_customize_panel_mesh_customize_component__WEBPACK_IMPORTED_MODULE_33__ = __webpack_require__(
      /*! ../../_shared/components/panels/panel-mesh-customize/panel-mesh-customize.component */
      "SvSf");
      /* harmony import */


      var _shared_components_editor_sidebar_sidebar_lock_sidebar_lock_component__WEBPACK_IMPORTED_MODULE_34__ = __webpack_require__(
      /*! ../../_shared/components/editor/sidebar/sidebar-lock/sidebar-lock.component */
      "HtlR");
      /* harmony import */


      var _shared_components_editor_sidebar_project_sidebar_project_sidebar_component__WEBPACK_IMPORTED_MODULE_35__ = __webpack_require__(
      /*! ../../_shared/components/editor/sidebar/project-sidebar/project-sidebar.component */
      "bXaS");
      /* harmony import */


      var _shared_components_viewport_client_viewport_component__WEBPACK_IMPORTED_MODULE_36__ = __webpack_require__(
      /*! ../../_shared/components/viewport/client-viewport.component */
      "jz48");

      function WorkspaceComponent_ng_container_0_Template(rf, ctx) {
        if (rf & 1) {
          _angular_core__WEBPACK_IMPORTED_MODULE_7__["ɵɵelementContainer"](0);
        }
      }

      function WorkspaceComponent_ng_template_1_ng_container_4_Template(rf, ctx) {
        if (rf & 1) {
          _angular_core__WEBPACK_IMPORTED_MODULE_7__["ɵɵelementContainer"](0);
        }
      }

      function WorkspaceComponent_ng_template_1_ng_template_5_Template(rf, ctx) {
        if (rf & 1) {
          _angular_core__WEBPACK_IMPORTED_MODULE_7__["ɵɵelementStart"](0, "div", 7);

          _angular_core__WEBPACK_IMPORTED_MODULE_7__["ɵɵelementStart"](1, "h3");

          _angular_core__WEBPACK_IMPORTED_MODULE_7__["ɵɵtext"](2, "Vui l\xF2ng ch\u1EDD gi\xE2y l\xE1t");

          _angular_core__WEBPACK_IMPORTED_MODULE_7__["ɵɵelementEnd"]();

          _angular_core__WEBPACK_IMPORTED_MODULE_7__["ɵɵelementEnd"]();
        }
      }

      function WorkspaceComponent_ng_template_1_ng_template_7_ng_container_0_Template(rf, ctx) {
        if (rf & 1) {
          _angular_core__WEBPACK_IMPORTED_MODULE_7__["ɵɵelementContainer"](0);
        }
      }

      function WorkspaceComponent_ng_template_1_ng_template_7_ng_template_1_Template(rf, ctx) {
        if (rf & 1) {
          _angular_core__WEBPACK_IMPORTED_MODULE_7__["ɵɵelementStart"](0, "div", 9);

          _angular_core__WEBPACK_IMPORTED_MODULE_7__["ɵɵtext"](1, " template Not Found ");

          _angular_core__WEBPACK_IMPORTED_MODULE_7__["ɵɵelementEnd"]();
        }
      }

      function WorkspaceComponent_ng_template_1_ng_template_7_ng_template_3_Template(rf, ctx) {
        if (rf & 1) {
          var _r16 = _angular_core__WEBPACK_IMPORTED_MODULE_7__["ɵɵgetCurrentView"]();

          _angular_core__WEBPACK_IMPORTED_MODULE_7__["ɵɵelementStart"](0, "nz-layout", 10);

          _angular_core__WEBPACK_IMPORTED_MODULE_7__["ɵɵelementStart"](1, "nz-sider", 11);

          _angular_core__WEBPACK_IMPORTED_MODULE_7__["ɵɵlistener"]("nzCollapsedChange", function WorkspaceComponent_ng_template_1_ng_template_7_ng_template_3_Template_nz_sider_nzCollapsedChange_1_listener($event) {
            _angular_core__WEBPACK_IMPORTED_MODULE_7__["ɵɵrestoreView"](_r16);

            var ctx_r15 = _angular_core__WEBPACK_IMPORTED_MODULE_7__["ɵɵnextContext"](3);

            return ctx_r15.nzCollapsedChange($event);
          });

          _angular_core__WEBPACK_IMPORTED_MODULE_7__["ɵɵelement"](2, "app-project-sidebar");

          _angular_core__WEBPACK_IMPORTED_MODULE_7__["ɵɵelementEnd"]();

          _angular_core__WEBPACK_IMPORTED_MODULE_7__["ɵɵelementStart"](3, "nz-content", 12);

          _angular_core__WEBPACK_IMPORTED_MODULE_7__["ɵɵelementStart"](4, "section", 13);

          _angular_core__WEBPACK_IMPORTED_MODULE_7__["ɵɵelement"](5, "app-client-viewport");

          _angular_core__WEBPACK_IMPORTED_MODULE_7__["ɵɵelementEnd"]();

          _angular_core__WEBPACK_IMPORTED_MODULE_7__["ɵɵelementEnd"]();

          _angular_core__WEBPACK_IMPORTED_MODULE_7__["ɵɵelementEnd"]();
        }
      }

      function WorkspaceComponent_ng_template_1_ng_template_7_Template(rf, ctx) {
        if (rf & 1) {
          _angular_core__WEBPACK_IMPORTED_MODULE_7__["ɵɵtemplate"](0, WorkspaceComponent_ng_template_1_ng_template_7_ng_container_0_Template, 1, 0, "ng-container", 0);

          _angular_core__WEBPACK_IMPORTED_MODULE_7__["ɵɵtemplate"](1, WorkspaceComponent_ng_template_1_ng_template_7_ng_template_1_Template, 2, 0, "ng-template", null, 8, _angular_core__WEBPACK_IMPORTED_MODULE_7__["ɵɵtemplateRefExtractor"]);

          _angular_core__WEBPACK_IMPORTED_MODULE_7__["ɵɵtemplate"](3, WorkspaceComponent_ng_template_1_ng_template_7_ng_template_3_Template, 6, 0, "ng-template", null, 5, _angular_core__WEBPACK_IMPORTED_MODULE_7__["ɵɵtemplateRefExtractor"]);
        }

        if (rf & 2) {
          var _r11 = _angular_core__WEBPACK_IMPORTED_MODULE_7__["ɵɵreference"](2);

          var _r13 = _angular_core__WEBPACK_IMPORTED_MODULE_7__["ɵɵreference"](4);

          var ctx_r9 = _angular_core__WEBPACK_IMPORTED_MODULE_7__["ɵɵnextContext"](2);

          _angular_core__WEBPACK_IMPORTED_MODULE_7__["ɵɵproperty"]("ngIf", ctx_r9.mode == "notfound")("ngIfThen", _r11)("ngIfElse", _r13);
        }
      }

      function WorkspaceComponent_ng_template_1_Template(rf, ctx) {
        if (rf & 1) {
          var _r18 = _angular_core__WEBPACK_IMPORTED_MODULE_7__["ɵɵgetCurrentView"]();

          _angular_core__WEBPACK_IMPORTED_MODULE_7__["ɵɵelementStart"](0, "nz-layout");

          _angular_core__WEBPACK_IMPORTED_MODULE_7__["ɵɵelementStart"](1, "nz-header");

          _angular_core__WEBPACK_IMPORTED_MODULE_7__["ɵɵelementStart"](2, "app-header", 3);

          _angular_core__WEBPACK_IMPORTED_MODULE_7__["ɵɵlistener"]("clickSave", function WorkspaceComponent_ng_template_1_Template_app_header_clickSave_2_listener($event) {
            _angular_core__WEBPACK_IMPORTED_MODULE_7__["ɵɵrestoreView"](_r18);

            var ctx_r17 = _angular_core__WEBPACK_IMPORTED_MODULE_7__["ɵɵnextContext"]();

            return ctx_r17.clickSave($event);
          });

          _angular_core__WEBPACK_IMPORTED_MODULE_7__["ɵɵelementEnd"]();

          _angular_core__WEBPACK_IMPORTED_MODULE_7__["ɵɵelementEnd"]();

          _angular_core__WEBPACK_IMPORTED_MODULE_7__["ɵɵelementStart"](3, "nz-content");

          _angular_core__WEBPACK_IMPORTED_MODULE_7__["ɵɵtemplate"](4, WorkspaceComponent_ng_template_1_ng_container_4_Template, 1, 0, "ng-container", 0);

          _angular_core__WEBPACK_IMPORTED_MODULE_7__["ɵɵtemplate"](5, WorkspaceComponent_ng_template_1_ng_template_5_Template, 3, 0, "ng-template", null, 4, _angular_core__WEBPACK_IMPORTED_MODULE_7__["ɵɵtemplateRefExtractor"]);

          _angular_core__WEBPACK_IMPORTED_MODULE_7__["ɵɵtemplate"](7, WorkspaceComponent_ng_template_1_ng_template_7_Template, 5, 3, "ng-template", null, 5, _angular_core__WEBPACK_IMPORTED_MODULE_7__["ɵɵtemplateRefExtractor"]);

          _angular_core__WEBPACK_IMPORTED_MODULE_7__["ɵɵelementEnd"]();

          _angular_core__WEBPACK_IMPORTED_MODULE_7__["ɵɵelementEnd"]();

          _angular_core__WEBPACK_IMPORTED_MODULE_7__["ɵɵelement"](9, "dragging-item");

          _angular_core__WEBPACK_IMPORTED_MODULE_7__["ɵɵelement"](10, "dragging-geometry");

          _angular_core__WEBPACK_IMPORTED_MODULE_7__["ɵɵelement"](11, "modal-image-library", 6);

          _angular_core__WEBPACK_IMPORTED_MODULE_7__["ɵɵelement"](12, "panel-mesh-geometry");

          _angular_core__WEBPACK_IMPORTED_MODULE_7__["ɵɵelement"](13, "panel-model-object");

          _angular_core__WEBPACK_IMPORTED_MODULE_7__["ɵɵelement"](14, "panel-light");

          _angular_core__WEBPACK_IMPORTED_MODULE_7__["ɵɵelement"](15, "app-panel-mesh-customize");

          _angular_core__WEBPACK_IMPORTED_MODULE_7__["ɵɵelement"](16, "app-sidebar-lock");
        }

        if (rf & 2) {
          var _r6 = _angular_core__WEBPACK_IMPORTED_MODULE_7__["ɵɵreference"](6);

          var _r8 = _angular_core__WEBPACK_IMPORTED_MODULE_7__["ɵɵreference"](8);

          var ctx_r2 = _angular_core__WEBPACK_IMPORTED_MODULE_7__["ɵɵnextContext"]();

          _angular_core__WEBPACK_IMPORTED_MODULE_7__["ɵɵadvance"](4);

          _angular_core__WEBPACK_IMPORTED_MODULE_7__["ɵɵproperty"]("ngIf", ctx_r2.isLoading)("ngIfThen", _r6)("ngIfElse", _r8);

          _angular_core__WEBPACK_IMPORTED_MODULE_7__["ɵɵadvance"](7);

          _angular_core__WEBPACK_IMPORTED_MODULE_7__["ɵɵproperty"]("app", ctx_r2.app);
        }
      }

      function WorkspaceComponent_ng_template_3_Template(rf, ctx) {}

      var _id = 0;

      var WorkspaceComponent = /*#__PURE__*/function (_app_shared_component2) {
        _inherits(WorkspaceComponent, _app_shared_component2);

        var _super3 = _createSuper(WorkspaceComponent);

        function WorkspaceComponent(cd, elemRef, activatedRoute, router, editor, events, storage, geoService, toolbar, confirmService, panelModelService, panelLightService, editorToolbar, viewportService, vectorControls, categoryService, itemService, projectService, templateService) {
          var _this4;

          _classCallCheck(this, WorkspaceComponent);

          _this4 = _super3.call(this);
          _this4.cd = cd;
          _this4.elemRef = elemRef;
          _this4.activatedRoute = activatedRoute;
          _this4.router = router;
          _this4.editor = editor;
          _this4.events = events;
          _this4.storage = storage;
          _this4.geoService = geoService;
          _this4.toolbar = toolbar;
          _this4.confirmService = confirmService;
          _this4.panelModelService = panelModelService;
          _this4.panelLightService = panelLightService;
          _this4.editorToolbar = editorToolbar;
          _this4.viewportService = viewportService;
          _this4.vectorControls = vectorControls;
          _this4.categoryService = categoryService;
          _this4.itemService = itemService;
          _this4.projectService = projectService;
          _this4.templateService = templateService;
          _this4.isInited = false;
          _this4.id = 0;
          _this4.mode = 'create';
          _this4.editMode = 'update';
          _this4.isLoading = true;
          _this4.app = null;
          _this4.urlPath = null;
          _this4.projects = [];
          _this4.templates = [];
          _this4.project = null;
          _this4.template = null;
          _this4.defaultThumbnail = _app_3D_libs_three_libs__WEBPACK_IMPORTED_MODULE_0__["TransparentBase64Image"];
          _this4.lockSidebar = false;
          _this4.isLockEventListenner = true;
          _this4.workspaceKey = "projectWorkspace";
          _this4.downloadBtn = Object(_app_core_helpers_html_elements__WEBPACK_IMPORTED_MODULE_4__["A"])(".download", {
            target: "_blank",
            href: "",
            download: "screenshot.png"
          });
          _this4.engineEvent = {
            "load.success": function loadSuccess(e) {
              return e.tasks == 0 && _this4.hideLoading();
            },
            "load.fail": function loadFail(e) {
              return e.tasks == 0 && _this4.hideLoading();
            },
            "object.load.starting": function objectLoadStarting() {
              return _this4.showLoading();
            },
            "object.load.completed": function objectLoadCompleted() {
              _this4.hideLoading();

              Object(_app_core_tasks__WEBPACK_IMPORTED_MODULE_5__["runTask"])('loading.complete');
            },
            "loadmore.progress": function loadmoreProgress(e) {
              return Object(_app_core_tasks__WEBPACK_IMPORTED_MODULE_5__["runTask"])("loading.progress", [e.percent]);
            }
          };

          _this4.appinit = function (e) {
            _this4.app.engine.setControlEngine(_this4.vectorControls.engine);

            _this4.app.editor.detachLight();
          };

          _this4.appBeforeInit = function (e) {
            _this4.app.engine.on(_this4.engineEvent);
          };

          _this4.subEventService = _this4.events.sub(_this4.workspaceKey);
          _this4.editor.events = _this4.subEventService;
          _this4.app = _this4.editor;
          _this4.toolbar = toolbar.sub(_this4.workspaceKey);
          _this4.viewportService = viewportService.sub(_this4.workspaceKey);
          _this4.vectorControls = vectorControls.sub(_this4.workspaceKey);
          _this4.editorToolbar = editorToolbar.sub(_this4.workspaceKey); // window['projectWorkspace'] = this;

          return _this4;
        }

        _createClass(WorkspaceComponent, [{
          key: "initOnce",
          value: function initOnce() {
            var _this5 = this;

            // this.events = this.events.sub(this.workspaceKey);
            this.moduleKey = this.workspaceKey;
            this.storage.assign('project', this.project, function (project) {
              return _this5.project = project;
            });
            this.storage.assign('mode', this.mode, function (mode) {
              return _this5.mode = mode;
            });
            this.storage.assign('editMode', this.editMode, function (mode) {
              return _this5.editMode = mode;
            }); // window['wpStorage'] = this.storage;

            this.viewportService.emit({
              type: 'app.set',
              app: this.app
            }, true); // quan ly khac

            this.router.events.subscribe(function (val) {// see also 
              // console.log(val instanceof NavigationEnd)
            });
            this.registerEventService(this.app, {
              "editor.update.mesh.props": function editorUpdateMeshProps(e) {
                return _this5.geoService.updateProps(e.data);
              },
              "editor.update.model.props": function editorUpdateModelProps(e) {
                return _this5.panelModelService.updateProps(e.data);
              },
              "editor.update.light.props": function editorUpdateLightProps(e) {
                return _this5.panelLightService.updateProps(e.data);
              },
              "editor.update.light.props.target": function editorUpdateLightPropsTarget(e) {
                return _this5.panelLightService.updateTargetProps(e.data);
              },
              "editor.attach:object": function editorAttachObject(e) {
                return _this5.toolbar.show("object", e.secret_key);
              },
              "editor.attach:mesh": function editorAttachMesh(e) {
                return _this5.toolbar.show("mesh", e.secret_key);
              },
              "editor.attach:light": function editorAttachLight(e) {
                return _this5.toolbar.show("light", e.secret_key);
              },
              "editor.delete:light": function editorDeleteLight(e) {
                return _this5.doAction({
                  action: "delete",
                  type: "light",
                  secret_key: e.secret_key
                });
              },
              "editor.delete:object": function editorDeleteObject(e) {
                return _this5.doAction({
                  action: "delete",
                  type: "object",
                  secret_key: e.secret_key
                });
              },
              "editor.detach": function editorDetach(e) {
                return _this5.onDetach();
              },
              "light.showform": function lightShowform(e) {
                return _this5.showLight(e.data);
              },
              beforeinit: this.appBeforeInit,
              init: this.appinit
            });
            this.registerEventService(this.events, {
              "modelitem.drop.confirm": function modelitemDropConfirm(e) {
                return _this5.dropModelItem(e.data);
              },
              "template.import": function templateImport(e) {
                return _this5.importTemplate(e.template);
              },
              "app.loading.show": function appLoadingShow(e) {
                return _this5.showLoading();
              },
              "app.loading.hide": function appLoadingHide(e) {
                return _this5.hideLoading();
              }
            });
            this.registerEventService(this.toolbar, {
              "mode.select": function modeSelect(e) {
                return _this5.app.emit({
                  type: "toolbar.change:mode",
                  mode: e.mode
                });
              },
              "action": function action(e) {
                return _this5.doAction(e.data);
              }
            });
            this.registerEventService(document, {
              'pointerup': function pointerup(e) {
                return _this5.events.emit(e);
              },
              'pointermove': function pointermove(e) {
                return _this5.events.emit(e);
              }
            });
            this.registerEventService(document, {
              'pointerup': function pointerup(e) {
                return _this5.subEventService.emit(e);
              },
              'pointermove': function pointermove(e) {
                return _this5.subEventService.emit(e);
              }
            }); // this.checkDemoData()
          }
        }, {
          key: "onInit",
          value: function onInit() {
            var _this6 = this;

            this.isLockEventListenner = false;
            this.activeEventServiceRegistered(this.app); // this.activeEventServiceRegistered(this.app.engine);

            this.activeEventServiceRegistered(this.events);
            this.activeEventServiceRegistered(this.toolbar);
            this.activeEventServiceRegistered(document);

            if (this.app.engine) {
              this.app.engine.on(this.engineEvent);
            }

            this.vectorControls.emit({
              type: "show",
              value: true
            }, null, true);
            this.editorToolbar.show({
              saveView: function saveView(e) {
                return _this6.app.saveCurrentCameraPosition();
              },
              saveThumbnail: function saveThumbnail(e) {
                return _this6.saveThumbnail();
              },
              exportImage: function exportImage(e) {
                return _this6.exportImage();
              }
            });
            this.preload();
            this.cd.detectChanges();
          }
        }, {
          key: "onDestroy",
          value: function onDestroy() {
            this.isLockEventListenner = true;
            this.deactiveEventServiceRegistered(this.app); // this.activeEventServiceRegistered(this.app.engine);

            this.deactiveEventServiceRegistered(this.events);
            this.deactiveEventServiceRegistered(this.toolbar);
            this.deactiveEventServiceRegistered(document);
            this.vectorControls.emit({
              type: "show",
              value: false
            }, null, true);
            this.editorToolbar.hide();

            if (this.app.engine) {
              this.app.engine.off(this.engineEvent);
            }
          }
        }, {
          key: "showLoading",
          value: function showLoading() {
            if (!this.isFocus) return false;
            this.viewportService.emit("show:loading", null, true);
            this.events.emit("show:sidebar-lock");
          }
        }, {
          key: "hideLoading",
          value: function hideLoading() {
            if (!this.isFocus) return false;
            this.viewportService.emit("hide:loading", true, true);
            this.events.emit("hide:sidebar-lock");
          }
        }, {
          key: "initUpdate",
          value: function initUpdate() {
            if (!this.isFocus) return false;
            this.id = +this.activatedRoute.snapshot.paramMap.get("id");

            if (this.id > 0) {
              this.loadProject(this.id);
            } else {
              this.storage.editorMode = 'notfound';
              this.cd.detectChanges();
            }
          }
        }, {
          key: "initCreate",
          value: function initCreate() {
            if (!this.isFocus) return false;
            this.storage.mode = 'create';
            var data = Object(_app_3D_store_data_type__WEBPACK_IMPORTED_MODULE_2__["getBlankAppData"])();
            this.setProjectData(data); // console.log("create", data);

            this.isLoading = false;
            this.cd.detectChanges();
          }
        }, {
          key: "preload",
          value: function preload() {
            if (!this.isFocus) return false;
            this.secret_id = this.activatedRoute.snapshot.paramMap.get("id");

            if (this.secret_id == Object(_app_core_config__WEBPACK_IMPORTED_MODULE_6__["getConfig"])('data.project.secret_id')) {
              var data = Object(_app_core_config__WEBPACK_IMPORTED_MODULE_6__["getConfig"])('data.project');
              this.storage.project = data;
              this.lazyLoadProject(data.data);
              this.isLoading = false;
              this.storage.mode = 'update';
              this.storage.editMode = Object(_app_core_config__WEBPACK_IMPORTED_MODULE_6__["getConfig"])('mode');
              this.cd.detectChanges();
            } else {
              this.storage.mode = 'notfound';
              this.isLoading = false;
            }
          }
        }, {
          key: "importTemplate",
          value: function importTemplate(template) {
            var _this7 = this;

            if (!this.isFocus) return false;
            this.showLoading();
            setTimeout(function () {
              return _this7.app.importTemplate(template.data);
            }, 100);
          }
        }, {
          key: "clickSave",
          value: function clickSave(event) {
            var _this8 = this;

            if (!this.isFocus) return false;

            if (this.mode == "update") {
              this.project.data = this.app.data;
              this.projectService.update(this.project).subscribe(function (rs) {// lam gi do
              });
            } else if (this.mode == "create") {
              this.project.data = this.app.data;
              this.projectService.create(this.project).subscribe(function (rs) {
                _this8.id = rs.data.id;
                _this8.mode = "update";
                _this8.app.data.id = _this8.id;
              });
            }
          }
        }, {
          key: "loadProject",
          value: function loadProject(id) {
            var _this9 = this;

            if (!this.isFocus) return false;
            this.showLoading(); // var project = this.projectTable.find(id);
            // if (project && !isEmpty(project)) {
            //     this.storage.editorMode = 'update';
            //     this.storage.project = project;
            //     this.isLoading = false;
            //     this.hideLoading();
            //     this.lazyLoadProject(project as ProjectModel);
            //     this.cd.detectChanges();
            // } else {

            this.projectService.get(this.id).subscribe(function (data) {
              _this9.storage.project = data;
              _this9.isLoading = false;

              _this9.hideLoading();

              _this9.lazyLoadProject(data);

              _this9.storage.mode = 'update';

              _this9.cd.detectChanges();
            }, function (error) {
              _this9.storage.mode = 'notfound';

              _this9.hideLoading();

              _this9.cd.detectChanges();
            }); // }
          }
        }, {
          key: "lazyLoadProject",
          value: function lazyLoadProject(project) {
            var _this10 = this;

            var preData = Object(_app_core_helpers_utils__WEBPACK_IMPORTED_MODULE_1__["assignWithout"])({}, project, ['objects', 'meshes', 'models', 'scene']);
            preData.scene = Object(_app_core_helpers_utils__WEBPACK_IMPORTED_MODULE_1__["assignWithout"])({}, project.scene, ['foregrounds', 'background']);
            this.setProjectData(preData);
            Object(_app_core_tasks__WEBPACK_IMPORTED_MODULE_5__["runTask"])('loading.progress', [20]);
            setTimeout(function () {
              if (!project.objects || !project.objects.length) {
                setTimeout(function () {
                  Object(_app_core_tasks__WEBPACK_IMPORTED_MODULE_5__["runTask"])('loading.progress', [50]);
                  setTimeout(function () {
                    Object(_app_core_tasks__WEBPACK_IMPORTED_MODULE_5__["runTask"])('loading.progress', [100]);
                    setTimeout(function () {
                      Object(_app_core_tasks__WEBPACK_IMPORTED_MODULE_5__["runTask"])('loading.complete', [project]);
                    }, 1000);
                  }, 1000);
                }, 500);
              } else {
                _this10.showLoading();
              }
            }, 11);
            setTimeout(function () {
              _this10.setProjectData(project);
            }, 25);
          }
        }, {
          key: "setProjectData",
          value: function setProjectData(data) {
            if (!this.isFocus) return false;
            this.app.setProject(data);
          }
        }, {
          key: "saveThumbnail",
          value: function saveThumbnail() {
            var _this11 = this;

            if (!this.isFocus) return false;
            this.app.editor.unselect();
            this.showLoading();
            setTimeout(function () {
              _this11.app.capture(function (image) {
                _this11.project.thumbnail = image;

                _this11.projectService.updateThumbnail({
                  id: _this11.project.id,
                  thumbnail: _this11.project.thumbnail
                }).subscribe(function (rs) {
                  _this11.hideLoading();
                }, function (e) {
                  _this11.hideLoading();
                });
              });
            }, 1000);
          }
        }, {
          key: "exportImage",
          value: function exportImage() {
            var _this12 = this;

            if (!this.isFocus) return false;
            this.app.editor.unselect();
            this.showLoading();
            setTimeout(function () {
              _this12.app.capture(function (image) {
                _this12.downloadBtn.attr("href", image);

                _this12.downloadBtn.el.click();

                _this12.hideLoading();
              });
            }, 2000);
          }
        }, {
          key: "onMeshAttach",
          value: function onMeshAttach(data) {
            var _this13 = this;

            if (!this.isFocus) return false;
            this.geoService.open(data, function (e) {
              var d = {};

              if (Object(_app_core_helpers_utils__WEBPACK_IMPORTED_MODULE_1__["inArray"])(['props', 'geometry', 'material'], e.key)) {
                d[e.key] = e.data[e.key];

                switch (e.key) {
                  case "props":
                    break;

                  case "geometry":
                    break;

                  case "material":
                    break;

                  default:
                    break;
                }

                _this13.events.emit({
                  type: "mesh.setting.update",
                  secret_key: data.secret_key,
                  data: d
                });
              }
            });
          }
        }, {
          key: "closeAllPanel",
          value: function closeAllPanel() {
            if (!this.isFocus) return false; // this.toolbar.hide();

            this.geoService.close();
            this.panelModelService.close();
            this.panelLightService.close();
          }
        }, {
          key: "onDetach",
          value: function onDetach() {
            if (!this.isFocus) return false;
            this.toolbar.hide();
            this.closeAllPanel();
          }
        }, {
          key: "showLight",
          value: function showLight(data) {
            var _this14 = this;

            if (!this.isFocus) return false;
            this.panelLightService.open(data, function (e) {
              var update = {}; // if(e.type=="params"){

              update[e.type] = {};
              update[e.type][e.name] = e.value; // }

              _this14.app.updateLightDataAndScene(e.secret_key, update);
            });
          }
        }, {
          key: "doAction",
          value: function doAction(data) {
            var _this15 = this;

            if (!this.isFocus) return false;

            if (data.action == "delete") {
              var title = Object(_app_core_helpers_utils__WEBPACK_IMPORTED_MODULE_1__["inArray"])(['object', 'mesh'], data.type) ? "Are you sure delete this object?" : "Are you sure delete this light?";
              this.confirmService.showDeleteConfirm(title, function () {
                if (Object(_app_core_helpers_utils__WEBPACK_IMPORTED_MODULE_1__["inArray"])(['object', 'mesh'], data.type)) {
                  _this15.app.emit({
                    type: "toolbar.delete:object",
                    secret_key: data.secret_key,
                    success: function success() {
                      return _this15.onDetach();
                    }
                  });
                } else if (data.type == "light") {
                  _this15.app.deleteLight(data.secret_key, function () {
                    return _this15.onDetach();
                  });
                }
              });
            } else if (data.action == "edit") {
              var ed = this.app.getEditObjectData(data.secret_key);

              if (ed != null) {
                if (ed.type == "mesh") {
                  this.closeAllPanel();
                  this.geoService.open(ed, function (e) {
                    var d = {};

                    if (Object(_app_core_helpers_utils__WEBPACK_IMPORTED_MODULE_1__["inArray"])(['props', 'geometry', 'material'], e.key)) {
                      d[e.key] = e.data[e.key];

                      switch (e.key) {
                        case "props":
                          break;

                        case "geometry":
                          break;

                        case "material":
                          break;

                        default:
                          break;
                      }

                      _this15.events.emit({
                        type: "mesh.setting.update",
                        secret_key: data.secret_key,
                        data: d
                      });
                    }
                  });
                } else if (ed.type == "model") {
                  this.closeAllPanel();
                  var obj = this.app.engine.getObject(data.secret_key).object;
                  ed.object = obj;
                  this.panelModelService.open(ed, function (e) {
                    if (e.type == "material") {
                      _this15.app.updateModelMeshMaterial(e.secret_key, e.name, e.data);
                    } else if (e.type == "props") {
                      var props = {};
                      props[e.key] = e.data[e.key];

                      _this15.app.updateObjectSettingDataAndScene(e.secret_key, {
                        props: props
                      }, {
                        props: true
                      });
                    }
                  });
                } else if (ed.type == "light") {
                  this.showLight(ed.data);
                }
              }
            } else if (data.action == 'download') {
              var model = this.app.getObject(data.secret_key);

              if (model.type == "model" && model.data.download_source_url != "") {
                var link = document.createElement('a');
                link.setAttribute('target', '_blank');
                link.setAttribute('href', model.data.download_source_url);
                link.setAttribute('download', model.data.name + ".zip");
                document.body.appendChild(link);
                link.click();
                link.remove();
              }
            }
          }
        }, {
          key: "dropModelItem",
          value: function dropModelItem(data) {
            var _this16 = this;

            if (!this.isFocus) return false;
            this.confirmService.showConfirm({
              title: "Drop Item confirm",
              content: "Item's size is bigger than size of Scene. Do you want to continue?"
            }, function (d) {
              _this16.showLoading();

              _this16.events.emit({
                type: 'item.dropped',
                item: data.item,
                success: function success(dat) {
                  _this16.events.emit('viewport.droppable.hide');

                  var size = data.item.size;

                  _this16.app.updateSceneSizeAndFloorAndGridNyChildren(2); // this.app.updateSceneSizeSetting()


                  if (_this16.app.data.scene.floor.above) {
                    data.position.y = _this16.app.data.scene.floor.props.position.y + size.y / 2;
                  } else {
                    data.position.y = size.y / 2;
                  }

                  _this16.app.updateObjectSettingDataAndScene(dat.secret_key, {
                    props: {
                      position: data.position
                    }
                  }, {
                    props: true
                  });

                  var sceneData = _this16.app.getRealSceneSize();

                  var x = sceneData.size.x;
                  var y = sceneData.size.y;
                  var z = sceneData.size.z;
                  var fov = _this16.app.engine.camera.fov;
                  var tan = Math.tan(Object(_app_core_helpers_utils__WEBPACK_IMPORTED_MODULE_1__["degreeToRadians"])(fov / 2));
                  var ds = z / 2 + (x > y ? x : y) / 2 / tan;
                  var dz = ds * 1.5;
                  var far = _this16.app.engine.camera.far > dz ? _this16.app.engine.camera.far : dz;
                  var near = _this16.app.engine.camera.near;

                  if (z >= 50) {
                    near = 1;
                  } else if (z > 20) {
                    near = 0.5;
                  } else if (z > 10) {
                    near = 0.1;
                  }

                  if (near < _this16.app.engine.camera.near) near = _this16.app.engine.camera.near;

                  _this16.app.updateCameraSetting({
                    far: far,
                    near: near,
                    position: {
                      z: ds * 1.5,
                      y: y / 2,
                      x: 0
                    },
                    settings: {
                      position: {
                        type: "custom",
                        custom: {
                          z: ds * 1.5,
                          y: y / 2,
                          x: 0
                        }
                      }
                    }
                  }, true);
                }
              });
            }, function () {
              _this16.events.emit('viewport.droppable.hide');
            });
          }
        }, {
          key: "nzCollapsedChange",
          value: function nzCollapsedChange(event) {
            if (!this.isFocus) return false;
            this.app.updateCanvasSize();
          }
        }, {
          key: "ngAfterViewInit",
          value: function ngAfterViewInit() {
            if (!this.isFocus) return;
            this.app.updateCanvasSize();
          }
        }]);

        return WorkspaceComponent;
      }(_app_shared_components_base_base_component__WEBPACK_IMPORTED_MODULE_3__["BaseComponent"]);

      WorkspaceComponent.ɵfac = function WorkspaceComponent_Factory(t) {
        return new (t || WorkspaceComponent)(_angular_core__WEBPACK_IMPORTED_MODULE_7__["ɵɵdirectiveInject"](_angular_core__WEBPACK_IMPORTED_MODULE_7__["ChangeDetectorRef"]), _angular_core__WEBPACK_IMPORTED_MODULE_7__["ɵɵdirectiveInject"](_angular_core__WEBPACK_IMPORTED_MODULE_7__["ElementRef"]), _angular_core__WEBPACK_IMPORTED_MODULE_7__["ɵɵdirectiveInject"](_angular_router__WEBPACK_IMPORTED_MODULE_8__["ActivatedRoute"]), _angular_core__WEBPACK_IMPORTED_MODULE_7__["ɵɵdirectiveInject"](_angular_router__WEBPACK_IMPORTED_MODULE_8__["Router"]), _angular_core__WEBPACK_IMPORTED_MODULE_7__["ɵɵdirectiveInject"](_app_3D_services_project_editor_service__WEBPACK_IMPORTED_MODULE_9__["ProjectEditorService"]), _angular_core__WEBPACK_IMPORTED_MODULE_7__["ɵɵdirectiveInject"](_app_3D_services_app_editor_event_service__WEBPACK_IMPORTED_MODULE_10__["AppEditorEventService"]), _angular_core__WEBPACK_IMPORTED_MODULE_7__["ɵɵdirectiveInject"](_app_3D_services_app_editor_storage_service__WEBPACK_IMPORTED_MODULE_11__["AppEditorStorageService"]), _angular_core__WEBPACK_IMPORTED_MODULE_7__["ɵɵdirectiveInject"](_app_shared_components_panels_mesh_geometry_mesh_geometry_service__WEBPACK_IMPORTED_MODULE_12__["MeshGeometryService"]), _angular_core__WEBPACK_IMPORTED_MODULE_7__["ɵɵdirectiveInject"](_app_shared_components_viewport_client_edit_toolbar_client_edit_toolbar_service__WEBPACK_IMPORTED_MODULE_13__["ClientEditToolbarService"]), _angular_core__WEBPACK_IMPORTED_MODULE_7__["ɵɵdirectiveInject"](_app_shared_services_modal_confirm_service__WEBPACK_IMPORTED_MODULE_14__["ModalConfirmService"]), _angular_core__WEBPACK_IMPORTED_MODULE_7__["ɵɵdirectiveInject"](_app_shared_components_panels_panel_model_object_panel_model_object_service__WEBPACK_IMPORTED_MODULE_15__["PanelModelObjectService"]), _angular_core__WEBPACK_IMPORTED_MODULE_7__["ɵɵdirectiveInject"](_app_shared_components_panels_panel_light_panel_light_service__WEBPACK_IMPORTED_MODULE_16__["PanelLightService"]), _angular_core__WEBPACK_IMPORTED_MODULE_7__["ɵɵdirectiveInject"](_app_shared_components_viewport_editor_toolbar_editor_toolbar_service__WEBPACK_IMPORTED_MODULE_17__["EditorToolbarService"]), _angular_core__WEBPACK_IMPORTED_MODULE_7__["ɵɵdirectiveInject"](_app_shared_components_viewport_viewport_service__WEBPACK_IMPORTED_MODULE_18__["ViewportService"]), _angular_core__WEBPACK_IMPORTED_MODULE_7__["ɵɵdirectiveInject"](_app_shared_components_viewport_vector_controls_vector_controls_service__WEBPACK_IMPORTED_MODULE_19__["VectorControlsService"]), _angular_core__WEBPACK_IMPORTED_MODULE_7__["ɵɵdirectiveInject"](_app_store_category__WEBPACK_IMPORTED_MODULE_20__["CategoryService"]), _angular_core__WEBPACK_IMPORTED_MODULE_7__["ɵɵdirectiveInject"](_app_store_item__WEBPACK_IMPORTED_MODULE_21__["ItemService"]), _angular_core__WEBPACK_IMPORTED_MODULE_7__["ɵɵdirectiveInject"](_app_store_project__WEBPACK_IMPORTED_MODULE_22__["ProjectService"]), _angular_core__WEBPACK_IMPORTED_MODULE_7__["ɵɵdirectiveInject"](_app_store_template__WEBPACK_IMPORTED_MODULE_23__["TemplateService"]));
      };

      WorkspaceComponent.ɵcmp = _angular_core__WEBPACK_IMPORTED_MODULE_7__["ɵɵdefineComponent"]({
        type: WorkspaceComponent,
        selectors: [["app-workspace"]],
        features: [_angular_core__WEBPACK_IMPORTED_MODULE_7__["ɵɵInheritDefinitionFeature"]],
        decls: 5,
        vars: 3,
        consts: [[4, "ngIf", "ngIfThen", "ngIfElse"], ["thenTemplate", ""], ["elseTemplate", ""], [3, "clickSave"], ["loadingTemplate", ""], ["editorTemplate", ""], [3, "app"], [1, "alert"], ["notFoundTemplate", ""], [1, "alert", "not-found"], [1, "inner-layout"], ["nzWidth", "380px", "nzTheme", "dark", 3, "nzCollapsedChange"], [1, "nz-layout-content"], ["id", "content"]],
        template: function WorkspaceComponent_Template(rf, ctx) {
          if (rf & 1) {
            _angular_core__WEBPACK_IMPORTED_MODULE_7__["ɵɵtemplate"](0, WorkspaceComponent_ng_container_0_Template, 1, 0, "ng-container", 0);

            _angular_core__WEBPACK_IMPORTED_MODULE_7__["ɵɵtemplate"](1, WorkspaceComponent_ng_template_1_Template, 17, 4, "ng-template", null, 1, _angular_core__WEBPACK_IMPORTED_MODULE_7__["ɵɵtemplateRefExtractor"]);

            _angular_core__WEBPACK_IMPORTED_MODULE_7__["ɵɵtemplate"](3, WorkspaceComponent_ng_template_3_Template, 0, 0, "ng-template", null, 2, _angular_core__WEBPACK_IMPORTED_MODULE_7__["ɵɵtemplateRefExtractor"]);
          }

          if (rf & 2) {
            var _r1 = _angular_core__WEBPACK_IMPORTED_MODULE_7__["ɵɵreference"](2);

            var _r3 = _angular_core__WEBPACK_IMPORTED_MODULE_7__["ɵɵreference"](4);

            _angular_core__WEBPACK_IMPORTED_MODULE_7__["ɵɵproperty"]("ngIf", ctx.__show__)("ngIfThen", _r1)("ngIfElse", _r3);
          }
        },
        directives: [_angular_common__WEBPACK_IMPORTED_MODULE_24__["NgIf"], ng_zorro_antd_layout__WEBPACK_IMPORTED_MODULE_25__["NzLayoutComponent"], ng_zorro_antd_layout__WEBPACK_IMPORTED_MODULE_25__["NzHeaderComponent"], _header_header_component__WEBPACK_IMPORTED_MODULE_26__["HeaderComponent"], ng_zorro_antd_layout__WEBPACK_IMPORTED_MODULE_25__["NzContentComponent"], _shared_components_editor_drag_drop_dragging_item_dragging_item_component__WEBPACK_IMPORTED_MODULE_27__["DraggingItemComponent"], _shared_components_editor_drag_drop_dragging_geometry_dragging_geometry_component__WEBPACK_IMPORTED_MODULE_28__["DraggingGeometryComponent"], _shared_components_modals_image_library_image_library_component__WEBPACK_IMPORTED_MODULE_29__["ImageLibraryComponent"], _shared_components_panels_mesh_geometry_mesh_geometry_component__WEBPACK_IMPORTED_MODULE_30__["MeshGeometryComponent"], _shared_components_panels_panel_model_object_panel_model_object_component__WEBPACK_IMPORTED_MODULE_31__["PanelModelObjectComponent"], _shared_components_panels_panel_light_panel_light_component__WEBPACK_IMPORTED_MODULE_32__["PanelLightComponent"], _shared_components_panels_panel_mesh_customize_panel_mesh_customize_component__WEBPACK_IMPORTED_MODULE_33__["PanelMeshCustomizeComponent"], _shared_components_editor_sidebar_sidebar_lock_sidebar_lock_component__WEBPACK_IMPORTED_MODULE_34__["SidebarLockComponent"], ng_zorro_antd_layout__WEBPACK_IMPORTED_MODULE_25__["NzSiderComponent"], _shared_components_editor_sidebar_project_sidebar_project_sidebar_component__WEBPACK_IMPORTED_MODULE_35__["ProjectSidebarComponent"], _shared_components_viewport_client_viewport_component__WEBPACK_IMPORTED_MODULE_36__["ClientViewportComponent"]],
        styles: ["html,\nbody {\n  width: 100vw;\n  height: 100vh;\n  margin: 0;\n  font-family: Roboto, \"Helvetica Neue\", sans-serif;\n  overflow: hidden;\n}\nhtml *,\nbody * {\n  -webkit-user-select: none;\n     -moz-user-select: none;\n          user-select: none;\n}\n.ant-layout-header {\n  display: flex;\n  align-items: center;\n  justify-content: space-between;\n  height: 56px;\n  padding: 8px 0px;\n  line-height: 56px;\n  background-color: #000;\n  z-index: 100;\n}\n.inner-layout {\n  height: 100%;\n}\n.inner-layout .ant-input-affix-wrapper {\n  padding: 2px 12px 2px 12px;\n  border-radius: 5px;\n}\n.inner-layout .ant-tabs {\n  height: 100%;\n}\n.inner-layout .ant-tabs-top .ant-tabs-nav {\n  margin: 0 0 0px 0;\n}\n.inner-layout .ant-tabs-top .ant-tabs-nav:before {\n  border: none;\n}\n.inner-layout .ant-tabs-nav-wrap {\n  background-color: #20242d;\n}\n.inner-layout .ant-tabs-nav-more {\n  background-color: #20242d !important;\n}\n.inner-layout .ant-tabs-nav-more .anticon {\n  color: #fff;\n  font-size: 24px;\n}\n.inner-layout .ant-tabs-tabpane {\n  padding-left: 0 !important;\n}\n.inner-layout .ant-tabs-content-holder {\n  background-color: #363d4b;\n}\n.inner-layout .ant-tabs-content {\n  height: 100%;\n  padding-left: 0 !important;\n}\n.inner-layout .ant-tabs-tab {\n  padding: 12px 24px !important;\n  margin: 0 !important;\n  font-size: 13px;\n  font-weight: 500;\n  color: #fff;\n  text-align: center !important;\n  background-color: #20242d;\n}\n.inner-layout .ant-tabs-tab-btn {\n  text-align: center;\n  font-weight: 400;\n  width: 100%;\n}\n.inner-layout .ant-tabs-tab-btn div {\n  margin-top: 4px;\n}\n.inner-layout .ant-tabs-tab-disabled {\n  display: none;\n}\n.inner-layout .ant-tabs-tab-active {\n  background-color: #363d4b;\n}\n.inner-layout .ant-tabs-tab-active :after,\n.inner-layout .ant-tabs-tab-active :before {\n  content: \"\";\n  position: absolute;\n  width: 8px;\n  height: 8px;\n  z-index: 100;\n}\n.inner-layout .ant-tabs-tab-active :after {\n  background: radial-gradient(circle closest-side, transparent 0, transparent 50%, #363d4b 0) \"200% 200%/400% 400%\";\n  bottom: 0;\n  right: -8px;\n  transform: scaleX(-1);\n}\n.inner-layout .ant-tabs-tab-active :before {\n  background: radial-gradient(circle closest-side, transparent 0, transparent 50%, #363d4b 0) \"200% 200%/400% 400%\";\n  bottom: 0;\n  left: -8px;\n}\n.inner-layout .ant-tabs .ant-tabs-tab:hover {\n  background-color: #2a2f3b;\n}\n.inner-layout .ant-tabs .ant-tabs-tab:hover :after,\n.inner-layout .ant-tabs .ant-tabs-tab:hover :before {\n  content: \"\";\n  position: absolute;\n  width: 8px;\n  height: 8px;\n  z-index: 100;\n}\n.inner-layout .ant-tabs .ant-tabs-tab:hover :after {\n  background: radial-gradient(circle closest-side, transparent 0, transparent 50%, #363d4b 0) \"200% 200%/400% 400%\";\n  bottom: 0;\n  right: -8px;\n  transform: scaleX(-1);\n}\n.inner-layout .ant-tabs .ant-tabs-tab:hover :before {\n  background: radial-gradient(circle closest-side, transparent 0, transparent 50%, #363d4b 0) \"200% 200%/400% 400%\";\n  bottom: 0;\n  left: -8px;\n}\n.inner-layout .ant-tabs .tab-inner {\n  padding: 24px 4px 0 0px !important;\n  height: 100%;\n}\n.inner-layout .ant-tabs .tab-inner .block {\n  margin-bottom: 24px;\n  padding: 0 16px;\n}\n.inner-layout .ant-tabs .tab-inner .store {\n  position: relative;\n  display: block;\n  flex-wrap: wrap;\n  height: calc(100% - 88px);\n  width: 100%;\n  padding: 0 12px 0 16px;\n  overflow-y: scroll;\n}\n.inner-layout .ant-tabs .tab-inner .store--expand {\n  height: auto;\n}\n.inner-layout .ant-tabs .tab-inner .store .gridlayout {\n  width: 100%;\n  height: 100%;\n  position: relative;\n}\n.inner-layout .ant-tabs .tab-inner .store .gridlayout .loading {\n  text-align: center;\n  width: 100%;\n}\n.inner-layout .ant-tabs .tab-inner .store .gridlayout .loading .spinner {\n  --animation-duration: 1000ms;\n  width: var(--size);\n  height: var(--size);\n  display: flex;\n  justify-content: center;\n  align-items: center;\n  gap: 4px;\n  margin: 0 auto;\n}\n.inner-layout .ant-tabs .tab-inner .store .gridlayout .loading .spinner .spinner-item {\n  height: 40%;\n  background-color: var(--clr-spinner);\n  width: calc(var(--size) / 13);\n  -webkit-animation: spinner5 var(--animation-duration) ease-in-out infinite;\n          animation: spinner5 var(--animation-duration) ease-in-out infinite;\n}\n@-webkit-keyframes spinner5 {\n  25% {\n    transform: scaleY(2);\n  }\n  50% {\n    transform: scaleY(1);\n  }\n}\n@keyframes spinner5 {\n  25% {\n    transform: scaleY(2);\n  }\n  50% {\n    transform: scaleY(1);\n  }\n}\n.inner-layout .ant-tabs .tab-inner .store .gridlayout .loading .spinner .spinner-item:nth-child(1) {\n  --clr-spinner: var(--clr1);\n}\n.inner-layout .ant-tabs .tab-inner .store .gridlayout .loading .spinner .spinner-item:nth-child(2) {\n  --clr-spinner: var(--clr3);\n  -webkit-animation-delay: calc(var(--animation-duration) / 10);\n          animation-delay: calc(var(--animation-duration) / 10);\n}\n.inner-layout .ant-tabs .tab-inner .store .gridlayout .loading .spinner .spinner-item:nth-child(3) {\n  --clr-spinner: var(--clr5);\n  -webkit-animation-delay: calc(var(--animation-duration) / 10 * 2);\n          animation-delay: calc(var(--animation-duration) / 10 * 2);\n}\n.inner-layout .ant-tabs .tab-inner .store .gridlayout .loading .spinner .spinner-item:nth-child(4) {\n  --clr-spinner: var(--clr4);\n  -webkit-animation-delay: calc(var(--animation-duration) / 10 * 3);\n          animation-delay: calc(var(--animation-duration) / 10 * 3);\n}\n.inner-layout .ant-tabs .tab-inner .store .gridlayout .loading .spinner .spinner-item:nth-child(5) {\n  --clr-spinner: var(--clr2);\n  -webkit-animation-delay: calc(var(--animation-duration) / 10 * 4);\n          animation-delay: calc(var(--animation-duration) / 10 * 4);\n}\n.inner-layout .ant-tabs .tab-inner .store .item {\n  display: inline-block;\n  width: 31.5%;\n  opacity: 1;\n  background-color: #485164;\n}\n.inner-layout .ant-tabs .tab-inner .store .item-box {\n  height: 100%;\n  width: 100%;\n  display: flex;\n  align-items: center;\n  transition: 0.5s ease;\n  border: 0 solid transparent;\n  position: relative;\n  background: #f6f6f6;\n  cursor: pointer;\n  width: 100%;\n  justify-content: center;\n  -webkit-user-select: none;\n     -moz-user-select: none;\n          user-select: none;\n  background: unset;\n}\n.inner-layout .ant-tabs .tab-inner .store .item-box:hover {\n  background: rgba(0, 0, 0, 0.2);\n  box-shadow: 0 0 11px rgba(33, 33, 33, 0.2);\n}\n.inner-layout .ant-tabs .tab-inner .store .item-box img {\n  width: 100%;\n  max-width: 100%;\n  max-height: 100%;\n}\n.inner-layout .ant-tabs .tab-inner .store::-webkit-scrollbar {\n  width: 6px;\n  background-color: transparent;\n}\n.inner-layout .ant-tabs .tab-inner .store::-webkit-scrollbar-track {\n  box-shadow: none;\n  background-color: transparent;\n}\n.inner-layout .ant-tabs .tab-inner .store::-webkit-scrollbar-thumb {\n  border-radius: 10px;\n  box-shadow: inset 0 0 6px rgba(0, 0, 0, 0.3);\n  background-color: #555;\n}\n.inner-layout .ant-tabs .tab-inner ngx-gridlayout::-webkit-scrollbar {\n  width: 6px;\n  background-color: transparent;\n}\n.inner-layout .ant-tabs .tab-inner ngx-gridlayout::-webkit-scrollbar-track {\n  box-shadow: none;\n  background-color: transparent;\n}\n.inner-layout .ant-tabs .tab-inner ngx-gridlayout::-webkit-scrollbar-thumb {\n  border-radius: 10px;\n  box-shadow: inset 0 0 6px rgba(0, 0, 0, 0.3);\n  background-color: #555;\n}\n.inner-layout .ant-tabs-ink-bar {\n  background-color: #fff;\n  border-right-width: 2px;\n  display: none !important;\n}\n.inner-layout .sub-tab .ant-tabs-tab {\n  padding: 4px 2px !important;\n  margin-right: 8px !important;\n  background-color: transparent;\n  border: 1px solid #495164;\n  border-radius: 4px;\n  width: 84px;\n}\n.inner-layout .sub-tab .ant-tabs-tab-active {\n  background-color: #495164;\n}\n.inner-layout .sub-tab .ant-tabs-tab-active :before,\n.inner-layout .sub-tab .ant-tabs-tab-active :after {\n  visibility: hidden;\n}\n.inner-layout .sub-tab .ant-tabs-tab-btn {\n  text-align: center;\n  font-weight: 400;\n  width: 100%;\n}\n.inner-layout .sub-tab .ant-tabs-tab-btn img {\n  max-height: 15px;\n  width: 100%;\n}\n.inner-layout .sub-tab .ant-tabs-tab-btn div {\n  margin-top: 2px;\n  line-height: 1;\n  font-size: 13px;\n  font-weight: 500;\n  color: #fff;\n  text-align: center !important;\n}\n.inner-layout .sub-tab .ant-tabs-nav-wrap {\n  background-color: transparent;\n  padding-left: 16px;\n  padding-right: 16px;\n}\n.tab-inner.height-50 .ant-tabs-content, .tab-inner.height-50 .ant-tabs, .tab-background.height-50 .ant-tabs-content, .tab-background.height-50 .ant-tabs {\n  height: 50% !important;\n}\n.collection {\n  margin-bottom: 8px;\n}\n.collection__title {\n  color: #fff;\n  font-weight: 700;\n}\n.ant-list-header {\n  padding-top: 0;\n  padding-bottom: 0;\n}\n.ant-popover-inner-content {\n  padding: 16px 0 !important;\n}\n.tag-select__trigger {\n  display: none !important;\n}\n.ant-tabs-nav-list {\n  width: 100% !important;\n}\n.notice-icon .ant-tabs-nav .ant-tabs-tab {\n  width: 100% !important;\n  margin-right: 0;\n}\n.ant-layout-content {\n  height: calc(100vh - 56px);\n}\n.pcr-app {\n  position: absolute !important;\n  top: 48px !important;\n  border-radius: 4px;\n  width: 100% !important;\n}\n.pcr-app .pcr-interaction input {\n  font-weight: 0.95em;\n  font-weight: 500;\n  color: #282828;\n}\n/*# sourceMappingURL=data:application/json;base64,eyJ2ZXJzaW9uIjozLCJzb3VyY2VzIjpbIi4uXFwuLlxcLi5cXF9pbmRleC5zY3NzIl0sIm5hbWVzIjpbXSwibWFwcGluZ3MiOiJBQUFBOztFQUVJLFlBQUE7RUFDQSxhQUFBO0VBQ0EsU0FBQTtFQUNBLGlEQUFBO0VBQ0EsZ0JBQUE7QUFDSjtBQUFJOztFQUNJLHlCQUFBO0tBQUEsc0JBQUE7VUFBQSxpQkFBQTtBQUdSO0FBT0E7RUFDSSxhQUFBO0VBQ0EsbUJBQUE7RUFDQSw4QkFBQTtFQUNBLFlBVFk7RUFVWixnQkFBQTtFQUVBLGlCQVpZO0VBYVosc0JBQUE7RUFDQSxZQUFBO0FBTEo7QUFRQTtFQUNJLFlBQUE7QUFMSjtBQU9JO0VBQ0ksMEJBQUE7RUFDQSxrQkFBQTtBQUxSO0FBUUk7RUFDSSxZQUFBO0FBTlI7QUFTWTtFQUNJLGlCQUFBO0FBUGhCO0FBUWdCO0VBQ0ksWUFBQTtBQU5wQjtBQVdRO0VBQ0kseUJBbkNVO0FBMEJ0QjtBQVlRO0VBQ0ksb0NBQUE7QUFWWjtBQVdZO0VBQ0ksV0FBQTtFQUNBLGVBQUE7QUFUaEI7QUFhUTtFQUNJLDBCQUFBO0FBWFo7QUFhUTtFQUNJLHlCQXBEUztBQXlDckI7QUFhUTtFQUNJLFlBQUE7RUFDQSwwQkFBQTtBQVhaO0FBY1E7RUFDSSw2QkFBQTtFQUNBLG9CQUFBO0VBQ0EsZUFBQTtFQUNBLGdCQUFBO0VBQ0EsV0E3REM7RUE4REQsNkJBQUE7RUFDQSx5QkFoRVU7QUFvRHRCO0FBYVk7RUFDSSxrQkFBQTtFQUNBLGdCQUFBO0VBQ0EsV0FBQTtBQVhoQjtBQVlnQjtFQUNJLGVBQUE7QUFWcEI7QUFlUTtFQUNJLGFBQUE7QUFiWjtBQWdCUTtFQUNJLHlCQWxGUztBQW9FckI7QUFlWTs7RUFFSSxXQUFBO0VBQ0Esa0JBQUE7RUFDQSxVQUFBO0VBQ0EsV0FBQTtFQUNBLFlBQUE7QUFiaEI7QUFlWTtFQUNJLGlIQUFBO0VBRUEsU0FBQTtFQUNBLFdBQUE7RUFDQSxxQkFBQTtBQWRoQjtBQWdCWTtFQUNJLGlIQUFBO0VBRUEsU0FBQTtFQUNBLFVBQUE7QUFmaEI7QUFvQlk7RUFDSSx5QkEzR087QUF5RnZCO0FBbUJnQjs7RUFFSSxXQUFBO0VBQ0Esa0JBQUE7RUFDQSxVQUFBO0VBQ0EsV0FBQTtFQUNBLFlBQUE7QUFqQnBCO0FBbUJnQjtFQUNJLGlIQUFBO0VBRUEsU0FBQTtFQUNBLFdBQUE7RUFDQSxxQkFBQTtBQWxCcEI7QUFvQmdCO0VBQ0ksaUhBQUE7RUFFQSxTQUFBO0VBQ0EsVUFBQTtBQW5CcEI7QUF3QlE7RUFDSSxrQ0FBQTtFQUNBLFlBQUE7QUF0Qlo7QUF3Qlk7RUFDSSxtQkFBQTtFQUNBLGVBQUE7QUF0QmhCO0FBeUJZO0VBQ0ksa0JBQUE7RUFDQSxjQUFBO0VBQ0EsZUFBQTtFQUNBLHlCQUFBO0VBQ0EsV0FBQTtFQUNBLHNCQUFBO0VBQ0Esa0JBQUE7QUF2QmhCO0FBd0JnQjtFQUNJLFlBQUE7QUF0QnBCO0FBeUJnQjtFQUNJLFdBQUE7RUFDQSxZQUFBO0VBRUEsa0JBQUE7QUF4QnBCO0FBeUJvQjtFQUNJLGtCQUFBO0VBQ0EsV0FBQTtBQXZCeEI7QUF5QndCO0VBQ0ksNEJBQUE7RUFDQSxrQkFBQTtFQUNBLG1CQUFBO0VBQ0EsYUFBQTtFQUNBLHVCQUFBO0VBQ0EsbUJBQUE7RUFDQSxRQUFBO0VBQ0EsY0FBQTtBQXZCNUI7QUF3QjRCO0VBQ0ksV0FBQTtFQUNBLG9DQUFBO0VBQ0EsNkJBQUE7RUFDQSwwRUFBQTtVQUFBLGtFQUFBO0FBdEJoQztBQXdCZ0M7RUFDSTtJQUNJLG9CQUFBO0VBdEJ0QztFQXlCa0M7SUFDSSxvQkFBQTtFQXZCdEM7QUFDRjtBQWdCZ0M7RUFDSTtJQUNJLG9CQUFBO0VBdEJ0QztFQXlCa0M7SUFDSSxvQkFBQTtFQXZCdEM7QUFDRjtBQTJCNEI7RUFDSSwwQkFBQTtBQXpCaEM7QUE0QjRCO0VBQ0ksMEJBQUE7RUFDQSw2REFBQTtVQUFBLHFEQUFBO0FBMUJoQztBQTZCNEI7RUFDSSwwQkFBQTtFQUNBLGlFQUFBO1VBQUEseURBQUE7QUEzQmhDO0FBOEI0QjtFQUNJLDBCQUFBO0VBQ0EsaUVBQUE7VUFBQSx5REFBQTtBQTVCaEM7QUErQjRCO0VBQ0ksMEJBQUE7RUFDQSxpRUFBQTtVQUFBLHlEQUFBO0FBN0JoQztBQW1DZ0I7RUFDSSxxQkFBQTtFQUNBLFlBQUE7RUFDQSxVQUFBO0VBQ0EseUJBQUE7QUFqQ3BCO0FBa0NvQjtFQUNJLFlBQUE7RUFDQSxXQUFBO0VBQ0EsYUFBQTtFQUNBLG1CQUFBO0VBQ0EscUJBQUE7RUFDQSwyQkFBQTtFQUNBLGtCQUFBO0VBQ0EsbUJBQUE7RUFDQSxlQUFBO0VBRUEsV0FBQTtFQUNBLHVCQUFBO0VBQ0EseUJBQUE7S0FBQSxzQkFBQTtVQUFBLGlCQUFBO0VBQ0EsaUJBQUE7QUFqQ3hCO0FBbUN3QjtFQUNJLDhCQUFBO0VBQ0EsMENBQUE7QUFqQzVCO0FBb0N3QjtFQUNJLFdBQUE7RUFDQSxlQUFBO0VBQ0EsZ0JBQUE7QUFsQzVCO0FBeUNnQjtFQUNJLFVBQUE7RUFDQSw2QkFBQTtBQXZDcEI7QUEwQ2dCO0VBQ0ksZ0JBQUE7RUFDQSw2QkFBQTtBQXhDcEI7QUEyQ2dCO0VBQ0ksbUJBQUE7RUFDQSw0Q0FBQTtFQUNBLHNCQUFBO0FBekNwQjtBQThDZ0I7RUFDSSxVQUFBO0VBQ0EsNkJBQUE7QUE1Q3BCO0FBK0NnQjtFQUNJLGdCQUFBO0VBQ0EsNkJBQUE7QUE3Q3BCO0FBZ0RnQjtFQUNJLG1CQUFBO0VBQ0EsNENBQUE7RUFDQSxzQkFBQTtBQTlDcEI7QUFtRFE7RUFDSSxzQkE5UkM7RUErUkQsdUJBQUE7RUFDQSx3QkFBQTtBQWpEWjtBQXFEUTtFQUNJLDJCQUFBO0VBQ0EsNEJBQUE7RUFDQSw2QkFBQTtFQUNBLHlCQUFBO0VBQ0Esa0JBQUE7RUFDQSxXQUFBO0FBbkRaO0FBcURZO0VBQ0kseUJBbFRRO0FBK1B4QjtBQW9EZ0I7O0VBRUksa0JBQUE7QUFsRHBCO0FBcURZO0VBQ0ksa0JBQUE7RUFDQSxnQkFBQTtFQUNBLFdBQUE7QUFuRGhCO0FBb0RnQjtFQUNJLGdCQUFBO0VBQ0EsV0FBQTtBQWxEcEI7QUFvRGdCO0VBQ0ksZUFBQTtFQUNBLGNBQUE7RUFDQSxlQUFBO0VBQ0EsZ0JBQUE7RUFDQSxXQWhVUDtFQWlVTyw2QkFBQTtBQWxEcEI7QUFzRFE7RUFDSSw2QkFBQTtFQUNBLGtCQUFBO0VBQ0EsbUJBQUE7QUFwRFo7QUE0RFE7RUFDSSxzQkFBQTtBQXpEWjtBQTZEQTtFQUNJLGtCQUFBO0FBMURKO0FBMkRJO0VBQ0ksV0FBQTtFQUNBLGdCQUFBO0FBekRSO0FBK0RBO0VBQ0ksY0FBQTtFQUNBLGlCQUFBO0FBNURKO0FBK0RBO0VBQ0ksMEJBQUE7QUE1REo7QUErREE7RUFDSSx3QkFBQTtBQTVESjtBQStEQTtFQUNJLHNCQUFBO0FBNURKO0FBK0RBO0VBQ0ksc0JBQUE7RUFDQSxlQUFBO0FBNURKO0FBK0RBO0VBQ0ksMEJBQUE7QUE1REo7QUErREE7RUFDSSw2QkFBQTtFQUNBLG9CQUFBO0VBQ0Esa0JBQUE7RUFDQSxzQkFBQTtBQTVESjtBQTZESTtFQUNJLG1CQUFBO0VBQ0EsZ0JBQUE7RUFDQSxjQUFBO0FBM0RSIiwiZmlsZSI6Il9pbmRleC5zY3NzIiwic291cmNlc0NvbnRlbnQiOlsiaHRtbCxcclxuYm9keSB7XHJcbiAgICB3aWR0aDogMTAwdnc7XHJcbiAgICBoZWlnaHQ6IDEwMHZoO1xyXG4gICAgbWFyZ2luOiAwO1xyXG4gICAgZm9udC1mYW1pbHk6IFJvYm90bywgXCJIZWx2ZXRpY2EgTmV1ZVwiLCBzYW5zLXNlcmlmO1xyXG4gICAgb3ZlcmZsb3c6IGhpZGRlbjtcclxuICAgICoge1xyXG4gICAgICAgIHVzZXItc2VsZWN0OiBub25lO1xyXG4gICAgfVxyXG59XHJcblxyXG4kdGFicy1uYXYtYWN0aXZlLWNvbG9yOiAjNDk1MTY0O1xyXG4kaGVpZ2h0LWhlYWRlcjogNTZweDtcclxuJHRhYnMtY29udGVudC1jb2xvcjogIzM2M2Q0YjtcclxuJHRhYnMtbmF2LWhvdmVyLWNvbG9yOiAjMmEyZjNiO1xyXG4kdGFicy1uYXYtd3JhcC1jb2xvcjogIzIwMjQyZDtcclxuJHRhYnMtY29sb3I6ICNmZmY7XHJcbi5hbnQtbGF5b3V0LWhlYWRlciB7XHJcbiAgICBkaXNwbGF5OiBmbGV4O1xyXG4gICAgYWxpZ24taXRlbXM6IGNlbnRlcjtcclxuICAgIGp1c3RpZnktY29udGVudDogc3BhY2UtYmV0d2VlbjtcclxuICAgIGhlaWdodDogJGhlaWdodC1oZWFkZXI7XHJcbiAgICBwYWRkaW5nOiA4cHggMHB4O1xyXG5cclxuICAgIGxpbmUtaGVpZ2h0OiAkaGVpZ2h0LWhlYWRlcjtcclxuICAgIGJhY2tncm91bmQtY29sb3I6ICMwMDA7XHJcbiAgICB6LWluZGV4OiAxMDA7XHJcbn1cclxuXHJcbi5pbm5lci1sYXlvdXQge1xyXG4gICAgaGVpZ2h0OiAxMDAlO1xyXG5cclxuICAgIC5hbnQtaW5wdXQtYWZmaXgtd3JhcHBlciB7XHJcbiAgICAgICAgcGFkZGluZzogMnB4IDEycHggMnB4IDEycHg7XHJcbiAgICAgICAgYm9yZGVyLXJhZGl1czogNXB4O1xyXG4gICAgfVxyXG5cclxuICAgIC5hbnQtdGFicyB7XHJcbiAgICAgICAgaGVpZ2h0OiAxMDAlO1xyXG5cclxuICAgICAgICAmLXRvcCB7XHJcbiAgICAgICAgICAgIC5hbnQtdGFicy1uYXYge1xyXG4gICAgICAgICAgICAgICAgbWFyZ2luOiAwIDAgMHB4IDA7XHJcbiAgICAgICAgICAgICAgICAmOmJlZm9yZSB7XHJcbiAgICAgICAgICAgICAgICAgICAgYm9yZGVyOiBub25lO1xyXG4gICAgICAgICAgICAgICAgfVxyXG4gICAgICAgICAgICB9XHJcbiAgICAgICAgfVxyXG5cclxuICAgICAgICAmLW5hdi13cmFwIHtcclxuICAgICAgICAgICAgYmFja2dyb3VuZC1jb2xvcjogJHRhYnMtbmF2LXdyYXAtY29sb3I7XHJcbiAgICAgICAgfVxyXG5cclxuICAgICAgICAmLW5hdi1tb3JlIHtcclxuICAgICAgICAgICAgYmFja2dyb3VuZC1jb2xvcjogJHRhYnMtbmF2LXdyYXAtY29sb3IgIWltcG9ydGFudDtcclxuICAgICAgICAgICAgLmFudGljb24ge1xyXG4gICAgICAgICAgICAgICAgY29sb3I6ICNmZmY7XHJcbiAgICAgICAgICAgICAgICBmb250LXNpemU6IDI0cHg7XHJcbiAgICAgICAgICAgIH1cclxuICAgICAgICB9XHJcblxyXG4gICAgICAgICYtdGFicGFuZSB7XHJcbiAgICAgICAgICAgIHBhZGRpbmctbGVmdDogMCAhaW1wb3J0YW50O1xyXG4gICAgICAgIH1cclxuICAgICAgICAmLWNvbnRlbnQtaG9sZGVyIHtcclxuICAgICAgICAgICAgYmFja2dyb3VuZC1jb2xvcjogJHRhYnMtY29udGVudC1jb2xvcjtcclxuICAgICAgICB9XHJcbiAgICAgICAgJi1jb250ZW50IHtcclxuICAgICAgICAgICAgaGVpZ2h0OiAxMDAlO1xyXG4gICAgICAgICAgICBwYWRkaW5nLWxlZnQ6IDAgIWltcG9ydGFudDtcclxuICAgICAgICB9XHJcblxyXG4gICAgICAgICYtdGFiIHtcclxuICAgICAgICAgICAgcGFkZGluZzogMTJweCAyNHB4ICFpbXBvcnRhbnQ7XHJcbiAgICAgICAgICAgIG1hcmdpbjogMCAhaW1wb3J0YW50O1xyXG4gICAgICAgICAgICBmb250LXNpemU6IDEzcHg7XHJcbiAgICAgICAgICAgIGZvbnQtd2VpZ2h0OiA1MDA7XHJcbiAgICAgICAgICAgIGNvbG9yOiAkdGFicy1jb2xvcjtcclxuICAgICAgICAgICAgdGV4dC1hbGlnbjogY2VudGVyICFpbXBvcnRhbnQ7XHJcbiAgICAgICAgICAgIGJhY2tncm91bmQtY29sb3I6ICR0YWJzLW5hdi13cmFwLWNvbG9yO1xyXG4gICAgICAgICAgICAmLWJ0biB7XHJcbiAgICAgICAgICAgICAgICB0ZXh0LWFsaWduOiBjZW50ZXI7XHJcbiAgICAgICAgICAgICAgICBmb250LXdlaWdodDogNDAwO1xyXG4gICAgICAgICAgICAgICAgd2lkdGg6IDEwMCU7XHJcbiAgICAgICAgICAgICAgICBkaXYge1xyXG4gICAgICAgICAgICAgICAgICAgIG1hcmdpbi10b3A6IDRweDtcclxuICAgICAgICAgICAgICAgIH1cclxuICAgICAgICAgICAgfVxyXG4gICAgICAgIH1cclxuXHJcbiAgICAgICAgJi10YWItZGlzYWJsZWQge1xyXG4gICAgICAgICAgICBkaXNwbGF5OiBub25lO1xyXG4gICAgICAgIH1cclxuXHJcbiAgICAgICAgJi10YWItYWN0aXZlIHtcclxuICAgICAgICAgICAgYmFja2dyb3VuZC1jb2xvcjogJHRhYnMtY29udGVudC1jb2xvcjtcclxuICAgICAgICAgICAgOmFmdGVyLFxyXG4gICAgICAgICAgICA6YmVmb3JlIHtcclxuICAgICAgICAgICAgICAgIGNvbnRlbnQ6IFwiXCI7XHJcbiAgICAgICAgICAgICAgICBwb3NpdGlvbjogYWJzb2x1dGU7XHJcbiAgICAgICAgICAgICAgICB3aWR0aDogOHB4O1xyXG4gICAgICAgICAgICAgICAgaGVpZ2h0OiA4cHg7XHJcbiAgICAgICAgICAgICAgICB6LWluZGV4OiAxMDA7XHJcbiAgICAgICAgICAgIH1cclxuICAgICAgICAgICAgOmFmdGVyIHtcclxuICAgICAgICAgICAgICAgIGJhY2tncm91bmQ6IHJhZGlhbC1ncmFkaWVudChjaXJjbGUgY2xvc2VzdC1zaWRlLCB0cmFuc3BhcmVudCAwLCB0cmFuc3BhcmVudCA1MCUsICMzNjNkNGIgMClcclxuICAgICAgICAgICAgICAgICAgICBcIjIwMCUgMjAwJS80MDAlIDQwMCVcIjtcclxuICAgICAgICAgICAgICAgIGJvdHRvbTogMDtcclxuICAgICAgICAgICAgICAgIHJpZ2h0OiAtOHB4O1xyXG4gICAgICAgICAgICAgICAgdHJhbnNmb3JtOiBzY2FsZVgoLTEpO1xyXG4gICAgICAgICAgICB9XHJcbiAgICAgICAgICAgIDpiZWZvcmUge1xyXG4gICAgICAgICAgICAgICAgYmFja2dyb3VuZDogcmFkaWFsLWdyYWRpZW50KGNpcmNsZSBjbG9zZXN0LXNpZGUsIHRyYW5zcGFyZW50IDAsIHRyYW5zcGFyZW50IDUwJSwgIzM2M2Q0YiAwKVxyXG4gICAgICAgICAgICAgICAgICAgIFwiMjAwJSAyMDAlLzQwMCUgNDAwJVwiO1xyXG4gICAgICAgICAgICAgICAgYm90dG9tOiAwO1xyXG4gICAgICAgICAgICAgICAgbGVmdDogLThweDtcclxuICAgICAgICAgICAgfVxyXG4gICAgICAgIH1cclxuXHJcbiAgICAgICAgLmFudC10YWJzLXRhYiB7XHJcbiAgICAgICAgICAgICY6aG92ZXIge1xyXG4gICAgICAgICAgICAgICAgYmFja2dyb3VuZC1jb2xvcjogJHRhYnMtbmF2LWhvdmVyLWNvbG9yO1xyXG4gICAgICAgICAgICAgICAgOmFmdGVyLFxyXG4gICAgICAgICAgICAgICAgOmJlZm9yZSB7XHJcbiAgICAgICAgICAgICAgICAgICAgY29udGVudDogXCJcIjtcclxuICAgICAgICAgICAgICAgICAgICBwb3NpdGlvbjogYWJzb2x1dGU7XHJcbiAgICAgICAgICAgICAgICAgICAgd2lkdGg6IDhweDtcclxuICAgICAgICAgICAgICAgICAgICBoZWlnaHQ6IDhweDtcclxuICAgICAgICAgICAgICAgICAgICB6LWluZGV4OiAxMDA7XHJcbiAgICAgICAgICAgICAgICB9XHJcbiAgICAgICAgICAgICAgICA6YWZ0ZXIge1xyXG4gICAgICAgICAgICAgICAgICAgIGJhY2tncm91bmQ6IHJhZGlhbC1ncmFkaWVudChjaXJjbGUgY2xvc2VzdC1zaWRlLCB0cmFuc3BhcmVudCAwLCB0cmFuc3BhcmVudCA1MCUsICMzNjNkNGIgMClcclxuICAgICAgICAgICAgICAgICAgICAgICAgXCIyMDAlIDIwMCUvNDAwJSA0MDAlXCI7XHJcbiAgICAgICAgICAgICAgICAgICAgYm90dG9tOiAwO1xyXG4gICAgICAgICAgICAgICAgICAgIHJpZ2h0OiAtOHB4O1xyXG4gICAgICAgICAgICAgICAgICAgIHRyYW5zZm9ybTogc2NhbGVYKC0xKTtcclxuICAgICAgICAgICAgICAgIH1cclxuICAgICAgICAgICAgICAgIDpiZWZvcmUge1xyXG4gICAgICAgICAgICAgICAgICAgIGJhY2tncm91bmQ6IHJhZGlhbC1ncmFkaWVudChjaXJjbGUgY2xvc2VzdC1zaWRlLCB0cmFuc3BhcmVudCAwLCB0cmFuc3BhcmVudCA1MCUsICMzNjNkNGIgMClcclxuICAgICAgICAgICAgICAgICAgICAgICAgXCIyMDAlIDIwMCUvNDAwJSA0MDAlXCI7XHJcbiAgICAgICAgICAgICAgICAgICAgYm90dG9tOiAwO1xyXG4gICAgICAgICAgICAgICAgICAgIGxlZnQ6IC04cHg7XHJcbiAgICAgICAgICAgICAgICB9XHJcbiAgICAgICAgICAgIH1cclxuICAgICAgICB9XHJcblxyXG4gICAgICAgIC50YWItaW5uZXIge1xyXG4gICAgICAgICAgICBwYWRkaW5nOiAyNHB4IDRweCAwIDBweCAhaW1wb3J0YW50O1xyXG4gICAgICAgICAgICBoZWlnaHQ6IDEwMCU7XHJcblxyXG4gICAgICAgICAgICAuYmxvY2sge1xyXG4gICAgICAgICAgICAgICAgbWFyZ2luLWJvdHRvbTogMjRweDtcclxuICAgICAgICAgICAgICAgIHBhZGRpbmc6IDAgMTZweDtcclxuICAgICAgICAgICAgfVxyXG5cclxuICAgICAgICAgICAgLnN0b3JlIHtcclxuICAgICAgICAgICAgICAgIHBvc2l0aW9uOiByZWxhdGl2ZTtcclxuICAgICAgICAgICAgICAgIGRpc3BsYXk6IGJsb2NrO1xyXG4gICAgICAgICAgICAgICAgZmxleC13cmFwOiB3cmFwO1xyXG4gICAgICAgICAgICAgICAgaGVpZ2h0OiBjYWxjKDEwMCUgLSA4OHB4KTtcclxuICAgICAgICAgICAgICAgIHdpZHRoOiAxMDAlO1xyXG4gICAgICAgICAgICAgICAgcGFkZGluZzogMCAxMnB4IDAgMTZweDtcclxuICAgICAgICAgICAgICAgIG92ZXJmbG93LXk6IHNjcm9sbDtcclxuICAgICAgICAgICAgICAgICYtLWV4cGFuZCB7XHJcbiAgICAgICAgICAgICAgICAgICAgaGVpZ2h0OiBhdXRvO1xyXG4gICAgICAgICAgICAgICAgfVxyXG5cclxuICAgICAgICAgICAgICAgIC5ncmlkbGF5b3V0IHtcclxuICAgICAgICAgICAgICAgICAgICB3aWR0aDogMTAwJTtcclxuICAgICAgICAgICAgICAgICAgICBoZWlnaHQ6IDEwMCU7XHJcbiAgICAgICAgICAgICAgICAgICAgLy8gcGFkZGluZzogMCAxMnB4IDAgMTZweDtcclxuICAgICAgICAgICAgICAgICAgICBwb3NpdGlvbjogcmVsYXRpdmU7XHJcbiAgICAgICAgICAgICAgICAgICAgLmxvYWRpbmcge1xyXG4gICAgICAgICAgICAgICAgICAgICAgICB0ZXh0LWFsaWduOiBjZW50ZXI7XHJcbiAgICAgICAgICAgICAgICAgICAgICAgIHdpZHRoOiAxMDAlO1xyXG5cclxuICAgICAgICAgICAgICAgICAgICAgICAgLnNwaW5uZXIge1xyXG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgLS1hbmltYXRpb24tZHVyYXRpb246IDEwMDBtcztcclxuICAgICAgICAgICAgICAgICAgICAgICAgICAgIHdpZHRoOiB2YXIoLS1zaXplKTtcclxuICAgICAgICAgICAgICAgICAgICAgICAgICAgIGhlaWdodDogdmFyKC0tc2l6ZSk7XHJcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICBkaXNwbGF5OiBmbGV4O1xyXG4gICAgICAgICAgICAgICAgICAgICAgICAgICAganVzdGlmeS1jb250ZW50OiBjZW50ZXI7XHJcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICBhbGlnbi1pdGVtczogY2VudGVyO1xyXG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgZ2FwOiA0cHg7XHJcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICBtYXJnaW46IDAgYXV0bztcclxuICAgICAgICAgICAgICAgICAgICAgICAgICAgIC5zcGlubmVyLWl0ZW0ge1xyXG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIGhlaWdodDogNDAlO1xyXG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIGJhY2tncm91bmQtY29sb3I6IHZhcigtLWNsci1zcGlubmVyKTtcclxuICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICB3aWR0aDogY2FsYyh2YXIoLS1zaXplKSAvIDEzKTtcclxuICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICBhbmltYXRpb246IHNwaW5uZXI1IHZhcigtLWFuaW1hdGlvbi1kdXJhdGlvbikgZWFzZS1pbi1vdXQgaW5maW5pdGU7XHJcblxyXG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIEBrZXlmcmFtZXMgc3Bpbm5lcjUge1xyXG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAyNSUge1xyXG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgdHJhbnNmb3JtOiBzY2FsZVkoMik7XHJcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIH1cclxuXHJcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIDUwJSB7XHJcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICB0cmFuc2Zvcm06IHNjYWxlWSgxKTtcclxuICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgfVxyXG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIH1cclxuICAgICAgICAgICAgICAgICAgICAgICAgICAgIH1cclxuXHJcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICAuc3Bpbm5lci1pdGVtOm50aC1jaGlsZCgxKSB7XHJcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgLS1jbHItc3Bpbm5lcjogdmFyKC0tY2xyMSk7XHJcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICB9XHJcblxyXG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgLnNwaW5uZXItaXRlbTpudGgtY2hpbGQoMikge1xyXG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIC0tY2xyLXNwaW5uZXI6IHZhcigtLWNscjMpO1xyXG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIGFuaW1hdGlvbi1kZWxheTogY2FsYyh2YXIoLS1hbmltYXRpb24tZHVyYXRpb24pIC8gMTApO1xyXG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgfVxyXG5cclxuICAgICAgICAgICAgICAgICAgICAgICAgICAgIC5zcGlubmVyLWl0ZW06bnRoLWNoaWxkKDMpIHtcclxuICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAtLWNsci1zcGlubmVyOiB2YXIoLS1jbHI1KTtcclxuICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICBhbmltYXRpb24tZGVsYXk6IGNhbGModmFyKC0tYW5pbWF0aW9uLWR1cmF0aW9uKSAvIDEwICogMik7XHJcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICB9XHJcblxyXG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgLnNwaW5uZXItaXRlbTpudGgtY2hpbGQoNCkge1xyXG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIC0tY2xyLXNwaW5uZXI6IHZhcigtLWNscjQpO1xyXG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIGFuaW1hdGlvbi1kZWxheTogY2FsYyh2YXIoLS1hbmltYXRpb24tZHVyYXRpb24pIC8gMTAgKiAzKTtcclxuICAgICAgICAgICAgICAgICAgICAgICAgICAgIH1cclxuXHJcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICAuc3Bpbm5lci1pdGVtOm50aC1jaGlsZCg1KSB7XHJcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgLS1jbHItc3Bpbm5lcjogdmFyKC0tY2xyMik7XHJcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgYW5pbWF0aW9uLWRlbGF5OiBjYWxjKHZhcigtLWFuaW1hdGlvbi1kdXJhdGlvbikgLyAxMCAqIDQpO1xyXG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgfVxyXG4gICAgICAgICAgICAgICAgICAgICAgICB9XHJcbiAgICAgICAgICAgICAgICAgICAgfVxyXG4gICAgICAgICAgICAgICAgfVxyXG5cclxuICAgICAgICAgICAgICAgIC5pdGVtIHtcclxuICAgICAgICAgICAgICAgICAgICBkaXNwbGF5OiBpbmxpbmUtYmxvY2s7XHJcbiAgICAgICAgICAgICAgICAgICAgd2lkdGg6IDMxLjUlO1xyXG4gICAgICAgICAgICAgICAgICAgIG9wYWNpdHk6IDE7XHJcbiAgICAgICAgICAgICAgICAgICAgYmFja2dyb3VuZC1jb2xvcjogIzQ4NTE2NDtcclxuICAgICAgICAgICAgICAgICAgICAmLWJveCB7XHJcbiAgICAgICAgICAgICAgICAgICAgICAgIGhlaWdodDogMTAwJTtcclxuICAgICAgICAgICAgICAgICAgICAgICAgd2lkdGg6IDEwMCU7XHJcbiAgICAgICAgICAgICAgICAgICAgICAgIGRpc3BsYXk6IGZsZXg7XHJcbiAgICAgICAgICAgICAgICAgICAgICAgIGFsaWduLWl0ZW1zOiBjZW50ZXI7XHJcbiAgICAgICAgICAgICAgICAgICAgICAgIHRyYW5zaXRpb246IDAuNXMgZWFzZTtcclxuICAgICAgICAgICAgICAgICAgICAgICAgYm9yZGVyOiAwIHNvbGlkIHRyYW5zcGFyZW50O1xyXG4gICAgICAgICAgICAgICAgICAgICAgICBwb3NpdGlvbjogcmVsYXRpdmU7XHJcbiAgICAgICAgICAgICAgICAgICAgICAgIGJhY2tncm91bmQ6ICNmNmY2ZjY7XHJcbiAgICAgICAgICAgICAgICAgICAgICAgIGN1cnNvcjogcG9pbnRlcjtcclxuXHJcbiAgICAgICAgICAgICAgICAgICAgICAgIHdpZHRoOiAxMDAlO1xyXG4gICAgICAgICAgICAgICAgICAgICAgICBqdXN0aWZ5LWNvbnRlbnQ6IGNlbnRlcjtcclxuICAgICAgICAgICAgICAgICAgICAgICAgdXNlci1zZWxlY3Q6IG5vbmU7XHJcbiAgICAgICAgICAgICAgICAgICAgICAgIGJhY2tncm91bmQ6IHVuc2V0O1xyXG5cclxuICAgICAgICAgICAgICAgICAgICAgICAgJjpob3ZlciB7XHJcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICBiYWNrZ3JvdW5kOiByZ2JhKDAsIDAsIDAsIDAuMik7XHJcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICBib3gtc2hhZG93OiAwIDAgMTFweCByZ2JhKDMzLCAzMywgMzMsIDAuMik7XHJcbiAgICAgICAgICAgICAgICAgICAgICAgIH1cclxuXHJcbiAgICAgICAgICAgICAgICAgICAgICAgIGltZyB7XHJcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICB3aWR0aDogMTAwJTtcclxuICAgICAgICAgICAgICAgICAgICAgICAgICAgIG1heC13aWR0aDogMTAwJTtcclxuICAgICAgICAgICAgICAgICAgICAgICAgICAgIG1heC1oZWlnaHQ6IDEwMCU7XHJcbiAgICAgICAgICAgICAgICAgICAgICAgIH1cclxuICAgICAgICAgICAgICAgICAgICB9XHJcbiAgICAgICAgICAgICAgICB9XHJcbiAgICAgICAgICAgIH1cclxuXHJcbiAgICAgICAgICAgIC5zdG9yZSB7XHJcbiAgICAgICAgICAgICAgICAmOjotd2Via2l0LXNjcm9sbGJhciB7XHJcbiAgICAgICAgICAgICAgICAgICAgd2lkdGg6IDZweDtcclxuICAgICAgICAgICAgICAgICAgICBiYWNrZ3JvdW5kLWNvbG9yOiB0cmFuc3BhcmVudDtcclxuICAgICAgICAgICAgICAgIH1cclxuXHJcbiAgICAgICAgICAgICAgICAmOjotd2Via2l0LXNjcm9sbGJhci10cmFjayB7XHJcbiAgICAgICAgICAgICAgICAgICAgYm94LXNoYWRvdzogbm9uZTtcclxuICAgICAgICAgICAgICAgICAgICBiYWNrZ3JvdW5kLWNvbG9yOiB0cmFuc3BhcmVudDtcclxuICAgICAgICAgICAgICAgIH1cclxuXHJcbiAgICAgICAgICAgICAgICAmOjotd2Via2l0LXNjcm9sbGJhci10aHVtYiB7XHJcbiAgICAgICAgICAgICAgICAgICAgYm9yZGVyLXJhZGl1czogMTBweDtcclxuICAgICAgICAgICAgICAgICAgICBib3gtc2hhZG93OiBpbnNldCAwIDAgNnB4IHJnYmEoMCwgMCwgMCwgMC4zKTtcclxuICAgICAgICAgICAgICAgICAgICBiYWNrZ3JvdW5kLWNvbG9yOiAjNTU1O1xyXG4gICAgICAgICAgICAgICAgfVxyXG4gICAgICAgICAgICB9XHJcblxyXG4gICAgICAgICAgICBuZ3gtZ3JpZGxheW91dCB7XHJcbiAgICAgICAgICAgICAgICAmOjotd2Via2l0LXNjcm9sbGJhciB7XHJcbiAgICAgICAgICAgICAgICAgICAgd2lkdGg6IDZweDtcclxuICAgICAgICAgICAgICAgICAgICBiYWNrZ3JvdW5kLWNvbG9yOiB0cmFuc3BhcmVudDtcclxuICAgICAgICAgICAgICAgIH1cclxuXHJcbiAgICAgICAgICAgICAgICAmOjotd2Via2l0LXNjcm9sbGJhci10cmFjayB7XHJcbiAgICAgICAgICAgICAgICAgICAgYm94LXNoYWRvdzogbm9uZTtcclxuICAgICAgICAgICAgICAgICAgICBiYWNrZ3JvdW5kLWNvbG9yOiB0cmFuc3BhcmVudDtcclxuICAgICAgICAgICAgICAgIH1cclxuXHJcbiAgICAgICAgICAgICAgICAmOjotd2Via2l0LXNjcm9sbGJhci10aHVtYiB7XHJcbiAgICAgICAgICAgICAgICAgICAgYm9yZGVyLXJhZGl1czogMTBweDtcclxuICAgICAgICAgICAgICAgICAgICBib3gtc2hhZG93OiBpbnNldCAwIDAgNnB4IHJnYmEoMCwgMCwgMCwgMC4zKTtcclxuICAgICAgICAgICAgICAgICAgICBiYWNrZ3JvdW5kLWNvbG9yOiAjNTU1O1xyXG4gICAgICAgICAgICAgICAgfVxyXG4gICAgICAgICAgICB9XHJcbiAgICAgICAgfVxyXG5cclxuICAgICAgICAmLWluay1iYXIge1xyXG4gICAgICAgICAgICBiYWNrZ3JvdW5kLWNvbG9yOiAkdGFicy1jb2xvcjtcclxuICAgICAgICAgICAgYm9yZGVyLXJpZ2h0LXdpZHRoOiAycHg7XHJcbiAgICAgICAgICAgIGRpc3BsYXk6IG5vbmUgIWltcG9ydGFudDtcclxuICAgICAgICB9XHJcbiAgICB9XHJcbiAgICAuc3ViLXRhYiB7XHJcbiAgICAgICAgLmFudC10YWJzLXRhYiB7XHJcbiAgICAgICAgICAgIHBhZGRpbmc6IDRweCAycHggIWltcG9ydGFudDtcclxuICAgICAgICAgICAgbWFyZ2luLXJpZ2h0OiA4cHggIWltcG9ydGFudDtcclxuICAgICAgICAgICAgYmFja2dyb3VuZC1jb2xvcjogdHJhbnNwYXJlbnQ7XHJcbiAgICAgICAgICAgIGJvcmRlcjogMXB4IHNvbGlkICR0YWJzLW5hdi1hY3RpdmUtY29sb3I7XHJcbiAgICAgICAgICAgIGJvcmRlci1yYWRpdXM6IDRweDtcclxuICAgICAgICAgICAgd2lkdGg6IDg0cHg7XHJcblxyXG4gICAgICAgICAgICAmLWFjdGl2ZSB7XHJcbiAgICAgICAgICAgICAgICBiYWNrZ3JvdW5kLWNvbG9yOiAkdGFicy1uYXYtYWN0aXZlLWNvbG9yO1xyXG4gICAgICAgICAgICAgICAgOmJlZm9yZSxcclxuICAgICAgICAgICAgICAgIDphZnRlciB7XHJcbiAgICAgICAgICAgICAgICAgICAgdmlzaWJpbGl0eTogaGlkZGVuO1xyXG4gICAgICAgICAgICAgICAgfVxyXG4gICAgICAgICAgICB9XHJcbiAgICAgICAgICAgICYtYnRuIHtcclxuICAgICAgICAgICAgICAgIHRleHQtYWxpZ246IGNlbnRlcjtcclxuICAgICAgICAgICAgICAgIGZvbnQtd2VpZ2h0OiA0MDA7XHJcbiAgICAgICAgICAgICAgICB3aWR0aDogMTAwJTtcclxuICAgICAgICAgICAgICAgIGltZyB7XHJcbiAgICAgICAgICAgICAgICAgICAgbWF4LWhlaWdodDogMTVweDtcclxuICAgICAgICAgICAgICAgICAgICB3aWR0aDogMTAwJTtcclxuICAgICAgICAgICAgICAgIH1cclxuICAgICAgICAgICAgICAgIGRpdiB7XHJcbiAgICAgICAgICAgICAgICAgICAgbWFyZ2luLXRvcDogMnB4O1xyXG4gICAgICAgICAgICAgICAgICAgIGxpbmUtaGVpZ2h0OiAxO1xyXG4gICAgICAgICAgICAgICAgICAgIGZvbnQtc2l6ZTogMTNweDtcclxuICAgICAgICAgICAgICAgICAgICBmb250LXdlaWdodDogNTAwO1xyXG4gICAgICAgICAgICAgICAgICAgIGNvbG9yOiAkdGFicy1jb2xvcjtcclxuICAgICAgICAgICAgICAgICAgICB0ZXh0LWFsaWduOiBjZW50ZXIgIWltcG9ydGFudDtcclxuICAgICAgICAgICAgICAgIH1cclxuICAgICAgICAgICAgfVxyXG4gICAgICAgIH1cclxuICAgICAgICAuYW50LXRhYnMtbmF2LXdyYXAge1xyXG4gICAgICAgICAgICBiYWNrZ3JvdW5kLWNvbG9yOiB0cmFuc3BhcmVudDtcclxuICAgICAgICAgICAgcGFkZGluZy1sZWZ0OiAxNnB4O1xyXG4gICAgICAgICAgICBwYWRkaW5nLXJpZ2h0OiAxNnB4O1xyXG4gICAgICAgIH1cclxuICAgIH1cclxufVxyXG5cclxuXHJcbi50YWItaW5uZXIsIC50YWItYmFja2dyb3VuZCB7XHJcbiAgICAmLmhlaWdodC01MCB7XHJcbiAgICAgICAgLmFudC10YWJzLWNvbnRlbnQsIC5hbnQtdGFicyB7XHJcbiAgICAgICAgICAgIGhlaWdodDogNTAlICFpbXBvcnRhbnQ7XHJcbiAgICAgICAgfVxyXG4gICAgfVxyXG59XHJcbi5jb2xsZWN0aW9uIHtcclxuICAgIG1hcmdpbi1ib3R0b206IDhweDtcclxuICAgICZfX3RpdGxlIHtcclxuICAgICAgICBjb2xvcjogI2ZmZjtcclxuICAgICAgICBmb250LXdlaWdodDogNzAwO1xyXG4gICAgfVxyXG59XHJcblxyXG5cclxuXHJcbi5hbnQtbGlzdC1oZWFkZXIge1xyXG4gICAgcGFkZGluZy10b3A6IDA7XHJcbiAgICBwYWRkaW5nLWJvdHRvbTogMDtcclxufVxyXG5cclxuLmFudC1wb3BvdmVyLWlubmVyLWNvbnRlbnQge1xyXG4gICAgcGFkZGluZzogMTZweCAwICFpbXBvcnRhbnQ7XHJcbn1cclxuXHJcbi50YWctc2VsZWN0X190cmlnZ2VyIHtcclxuICAgIGRpc3BsYXk6IG5vbmUgIWltcG9ydGFudDtcclxufVxyXG5cclxuLmFudC10YWJzLW5hdi1saXN0IHtcclxuICAgIHdpZHRoOiAxMDAlICFpbXBvcnRhbnQ7XHJcbn1cclxuXHJcbi5ub3RpY2UtaWNvbiAuYW50LXRhYnMtbmF2IC5hbnQtdGFicy10YWIge1xyXG4gICAgd2lkdGg6IDEwMCUgIWltcG9ydGFudDtcclxuICAgIG1hcmdpbi1yaWdodDogMDtcclxufVxyXG5cclxuLmFudC1sYXlvdXQtY29udGVudCB7XHJcbiAgICBoZWlnaHQ6IGNhbGMoMTAwdmggLSA1NnB4KTtcclxufVxyXG5cclxuLnBjci1hcHAge1xyXG4gICAgcG9zaXRpb246IGFic29sdXRlICFpbXBvcnRhbnQ7XHJcbiAgICB0b3A6IDQ4cHggIWltcG9ydGFudDtcclxuICAgIGJvcmRlci1yYWRpdXM6IDRweDtcclxuICAgIHdpZHRoOiAxMDAlICFpbXBvcnRhbnQ7XHJcbiAgICAucGNyLWludGVyYWN0aW9uIGlucHV0IHtcclxuICAgICAgICBmb250LXdlaWdodDogMC45NWVtO1xyXG4gICAgICAgIGZvbnQtd2VpZ2h0OiA1MDA7XHJcbiAgICAgICAgY29sb3I6ICMyODI4Mjg7XHJcbiAgICB9XHJcbn1cclxuIl19 */", "#toolview {\n  position: absolute;\n  right: 40px;\n  bottom: 40px;\n}\n#toolview .toolview-inner button {\n  padding: 2px 2px;\n  height: 30px;\n  text-align: center;\n  text-decoration: none;\n  color: #3f4652;\n  border: 1px solid transparent;\n  border-radius: 5px;\n  background-color: transparent;\n  transition: background-color 0.1s ease, width 0.1s ease, opacity 0.1s ease;\n  font-size: 1em;\n  outline: none;\n  box-sizing: border-box;\n  line-height: 18px;\n  background-color: #ffffff;\n  border: 1px solid #ecedee;\n  cursor: pointer;\n  min-width: 80px;\n  font-weight: 700;\n}\n#toolview .toolview-inner button:hover {\n  background-color: #fffeee;\n}\n.dragging :host #toolview {\n  display: none;\n}\n:host :root {\n  --design-zoom: 1;\n}\n#content {\n  height: 100%;\n}\napp-viewport {\n  height: 100%;\n}\n.list-template {\n  height: 100%;\n  overflow-y: auto;\n}\n.list-template .list-header {\n  text-align: center;\n  padding: 50px 0;\n}\n.list-template .list {\n  display: flex;\n  flex-wrap: wrap;\n  margin-right: -15px;\n  margin-left: -15px;\n  max-width: 1200px;\n  margin: 0 auto;\n}\n.list-template .template-item {\n  flex-basis: 0;\n  flex-grow: 1;\n  max-width: 100%;\n  flex: 0 0 25%;\n  max-width: 25%;\n  position: relative;\n  width: 100%;\n  min-height: 1px;\n  padding-right: 15px;\n  padding-left: 15px;\n  padding-bottom: 10px;\n  padding-top: 10px;\n}\n.list-template .template-item .inner {\n  background: #ecedee;\n  transition: all 0.2s ease-in-out;\n  -moz-transition: all 0.2s ease-in-out;\n  -webkit-transition: all 0.2s ease-in-out;\n}\n.list-template .template-item .inner:hover {\n  box-shadow: 0 0 5px #7ebaf5;\n}\n.list-template .template-item .thumbnail {\n  min-height: 100px;\n  display: flex;\n  align-items: center;\n  align-content: center;\n}\n.list-template .template-item .thumbnail img {\n  max-width: 100%;\n  width: 100%;\n  min-height: 100px;\n  -o-object-fit: cover;\n     object-fit: cover;\n}\n.list-template .template-item .detail {\n  padding: 10px;\n}\n.sidebar-lock {\n  display: block;\n  position: fixed;\n  z-index: 100;\n  top: 56px;\n  left: 0;\n  bottom: 0;\n  width: 300px;\n  background: rgba(0, 0, 0, 0.4);\n}\n.sidebar-lock::after {\n  display: table;\n  content: \" \";\n  clear: both;\n}\n/*# sourceMappingURL=data:application/json;base64,eyJ2ZXJzaW9uIjozLCJzb3VyY2VzIjpbIi4uXFwuLlxcLi5cXC4uXFx3b3Jrc3BhY2UuY29tcG9uZW50LnNjc3MiXSwibmFtZXMiOltdLCJtYXBwaW5ncyI6IkFBQUE7RUFDSSxrQkFBQTtFQUNBLFdBQUE7RUFDQSxZQUFBO0FBQ0o7QUFHUTtFQUNJLGdCQUFBO0VBQ0EsWUFBQTtFQUNBLGtCQUFBO0VBQ0EscUJBQUE7RUFDQSxjQUFBO0VBQ0EsNkJBQUE7RUFDQSxrQkFBQTtFQUNBLDZCQUFBO0VBQ0EsMEVBQUE7RUFDQSxjQUFBO0VBQ0EsYUFBQTtFQUNBLHNCQUFBO0VBQ0EsaUJBQUE7RUFDQSx5QkFBQTtFQUNBLHlCQUFBO0VBQ0EsZUFBQTtFQUNBLGVBQUE7RUFDQSxnQkFBQTtBQURaO0FBRVk7RUFDSSx5QkFBQTtBQUFoQjtBQU1BO0VBQ0ksYUFBQTtBQUhKO0FBT0k7RUFDSSxnQkFBQTtBQUpSO0FBT0E7RUFDSSxZQUFBO0FBSko7QUFPQTtFQUNJLFlBQUE7QUFKSjtBQU1BO0VBQ0ksWUFBQTtFQUNBLGdCQUFBO0FBSEo7QUFJSTtFQUNJLGtCQUFBO0VBQ0EsZUFBQTtBQUZSO0FBSUk7RUFHSSxhQUFBO0VBRUEsZUFBQTtFQUNBLG1CQUFBO0VBQ0Esa0JBQUE7RUFDQSxpQkFBQTtFQUNBLGNBQUE7QUFGUjtBQUlJO0VBRUksYUFBQTtFQUdBLFlBQUE7RUFDQSxlQUFBO0VBR0EsYUFBQTtFQUNBLGNBQUE7RUFFQSxrQkFBQTtFQUNBLFdBQUE7RUFDQSxlQUFBO0VBQ0EsbUJBQUE7RUFDQSxrQkFBQTtFQUNBLG9CQUFBO0VBQ0EsaUJBQUE7QUFKUjtBQU1RO0VBQ0ksbUJBQUE7RUFDQSxnQ0FBQTtFQUNBLHFDQUFBO0VBQ0Esd0NBQUE7QUFKWjtBQUtZO0VBQ0ksMkJBQUE7QUFIaEI7QUFNUTtFQUNJLGlCQUFBO0VBQ0EsYUFBQTtFQUNBLG1CQUFBO0VBQ0EscUJBQUE7QUFKWjtBQUtZO0VBQ0ksZUFBQTtFQUNBLFdBQUE7RUFDQSxpQkFBQTtFQUNBLG9CQUFBO0tBQUEsaUJBQUE7QUFIaEI7QUFNUTtFQUNJLGFBQUE7QUFKWjtBQVNBO0VBQ0ksY0FBQTtFQUNBLGVBQUE7RUFDQSxZQUFBO0VBQ0EsU0FBQTtFQUNBLE9BQUE7RUFDQSxTQUFBO0VBQ0EsWUFBQTtFQUVBLDhCQUFBO0FBUEo7QUFRSTtFQUNJLGNBQUE7RUFDQSxZQUFBO0VBQ0EsV0FBQTtBQU5SIiwiZmlsZSI6IndvcmtzcGFjZS5jb21wb25lbnQuc2NzcyIsInNvdXJjZXNDb250ZW50IjpbIiN0b29sdmlldyB7XHJcbiAgICBwb3NpdGlvbjogYWJzb2x1dGU7XHJcbiAgICByaWdodDogNDBweDtcclxuICAgIGJvdHRvbTogNDBweDtcclxuICAgIC50b29sdmlldy1pbm5lciB7XHJcbiAgICAgICAgLy8gYmFja2dyb3VuZC1jb2xvcjogI2ZmZmZmZjtcclxuICAgICAgICAvLyBwYWRkaW5nOiA4cHggMTZweDtcclxuICAgICAgICBidXR0b24ge1xyXG4gICAgICAgICAgICBwYWRkaW5nOiAycHggMnB4O1xyXG4gICAgICAgICAgICBoZWlnaHQ6IDMwcHg7XHJcbiAgICAgICAgICAgIHRleHQtYWxpZ246IGNlbnRlcjtcclxuICAgICAgICAgICAgdGV4dC1kZWNvcmF0aW9uOiBub25lO1xyXG4gICAgICAgICAgICBjb2xvcjogIzNmNDY1MjtcclxuICAgICAgICAgICAgYm9yZGVyOiAxcHggc29saWQgdHJhbnNwYXJlbnQ7XHJcbiAgICAgICAgICAgIGJvcmRlci1yYWRpdXM6IDVweDtcclxuICAgICAgICAgICAgYmFja2dyb3VuZC1jb2xvcjogdHJhbnNwYXJlbnQ7XHJcbiAgICAgICAgICAgIHRyYW5zaXRpb246IGJhY2tncm91bmQtY29sb3IgMC4xcyBlYXNlLCB3aWR0aCAwLjFzIGVhc2UsIG9wYWNpdHkgMC4xcyBlYXNlO1xyXG4gICAgICAgICAgICBmb250LXNpemU6IDFlbTtcclxuICAgICAgICAgICAgb3V0bGluZTogbm9uZTtcclxuICAgICAgICAgICAgYm94LXNpemluZzogYm9yZGVyLWJveDtcclxuICAgICAgICAgICAgbGluZS1oZWlnaHQ6IDE4cHg7XHJcbiAgICAgICAgICAgIGJhY2tncm91bmQtY29sb3I6ICNmZmZmZmY7XHJcbiAgICAgICAgICAgIGJvcmRlcjogMXB4IHNvbGlkICNlY2VkZWU7XHJcbiAgICAgICAgICAgIGN1cnNvcjogcG9pbnRlcjtcclxuICAgICAgICAgICAgbWluLXdpZHRoOiA4MHB4O1xyXG4gICAgICAgICAgICBmb250LXdlaWdodDogNzAwO1xyXG4gICAgICAgICAgICAmOmhvdmVyIHtcclxuICAgICAgICAgICAgICAgIGJhY2tncm91bmQtY29sb3I6ICNmZmZlZWU7XHJcbiAgICAgICAgICAgIH1cclxuICAgICAgICB9XHJcbiAgICB9XHJcbn1cclxuXHJcbi5kcmFnZ2luZyA6aG9zdCAjdG9vbHZpZXcge1xyXG4gICAgZGlzcGxheTogbm9uZTtcclxufVxyXG5cclxuOmhvc3Qge1xyXG4gICAgOnJvb3Qge1xyXG4gICAgICAgIC0tZGVzaWduLXpvb206IDE7XHJcbiAgICB9XHJcbn1cclxuI2NvbnRlbnQge1xyXG4gICAgaGVpZ2h0OiAxMDAlO1xyXG59XHJcblxyXG5hcHAtdmlld3BvcnQge1xyXG4gICAgaGVpZ2h0OiAxMDAlO1xyXG59XHJcbi5saXN0LXRlbXBsYXRlIHtcclxuICAgIGhlaWdodDogMTAwJTtcclxuICAgIG92ZXJmbG93LXk6IGF1dG87XHJcbiAgICAubGlzdC1oZWFkZXJ7XHJcbiAgICAgICAgdGV4dC1hbGlnbjogY2VudGVyO1xyXG4gICAgICAgIHBhZGRpbmc6IDUwcHggMDtcclxuICAgIH1cclxuICAgIC5saXN0IHtcclxuICAgICAgICBkaXNwbGF5OiAtd2Via2l0LWJveDtcclxuICAgICAgICBkaXNwbGF5OiAtbXMtZmxleGJveDtcclxuICAgICAgICBkaXNwbGF5OiBmbGV4O1xyXG4gICAgICAgIC1tcy1mbGV4LXdyYXA6IHdyYXA7XHJcbiAgICAgICAgZmxleC13cmFwOiB3cmFwO1xyXG4gICAgICAgIG1hcmdpbi1yaWdodDogLTE1cHg7XHJcbiAgICAgICAgbWFyZ2luLWxlZnQ6IC0xNXB4O1xyXG4gICAgICAgIG1heC13aWR0aDogMTIwMHB4O1xyXG4gICAgICAgIG1hcmdpbjogMCBhdXRvO1xyXG4gICAgfVxyXG4gICAgLnRlbXBsYXRlLWl0ZW0ge1xyXG4gICAgICAgIC1tcy1mbGV4LXByZWZlcnJlZC1zaXplOiAwO1xyXG4gICAgICAgIGZsZXgtYmFzaXM6IDA7XHJcbiAgICAgICAgLXdlYmtpdC1ib3gtZmxleDogMTtcclxuICAgICAgICAtbXMtZmxleC1wb3NpdGl2ZTogMTtcclxuICAgICAgICBmbGV4LWdyb3c6IDE7XHJcbiAgICAgICAgbWF4LXdpZHRoOiAxMDAlO1xyXG5cclxuICAgICAgICAtbXMtZmxleDogMCAwIDI1JTtcclxuICAgICAgICBmbGV4OiAwIDAgMjUlO1xyXG4gICAgICAgIG1heC13aWR0aDogMjUlO1xyXG5cclxuICAgICAgICBwb3NpdGlvbjogcmVsYXRpdmU7XHJcbiAgICAgICAgd2lkdGg6IDEwMCU7XHJcbiAgICAgICAgbWluLWhlaWdodDogMXB4O1xyXG4gICAgICAgIHBhZGRpbmctcmlnaHQ6IDE1cHg7XHJcbiAgICAgICAgcGFkZGluZy1sZWZ0OiAxNXB4O1xyXG4gICAgICAgIHBhZGRpbmctYm90dG9tOiAxMHB4O1xyXG4gICAgICAgIHBhZGRpbmctdG9wOiAxMHB4O1xyXG5cclxuICAgICAgICAuaW5uZXJ7XHJcbiAgICAgICAgICAgIGJhY2tncm91bmQ6ICNlY2VkZWU7XHJcbiAgICAgICAgICAgIHRyYW5zaXRpb246IGFsbCAwLjJzIGVhc2UtaW4tb3V0O1xyXG4gICAgICAgICAgICAtbW96LXRyYW5zaXRpb246IGFsbCAwLjJzIGVhc2UtaW4tb3V0O1xyXG4gICAgICAgICAgICAtd2Via2l0LXRyYW5zaXRpb246IGFsbCAwLjJzIGVhc2UtaW4tb3V0O1xyXG4gICAgICAgICAgICAmOmhvdmVye1xyXG4gICAgICAgICAgICAgICAgYm94LXNoYWRvdzogMCAwIDVweCByZ2IoMTI2LCAxODYsIDI0NSk7XHJcbiAgICAgICAgICAgIH1cclxuICAgICAgICB9XHJcbiAgICAgICAgLnRodW1ibmFpbHtcclxuICAgICAgICAgICAgbWluLWhlaWdodDogMTAwcHg7XHJcbiAgICAgICAgICAgIGRpc3BsYXk6IGZsZXg7XHJcbiAgICAgICAgICAgIGFsaWduLWl0ZW1zOiBjZW50ZXI7XHJcbiAgICAgICAgICAgIGFsaWduLWNvbnRlbnQ6IGNlbnRlcjtcclxuICAgICAgICAgICAgaW1ne1xyXG4gICAgICAgICAgICAgICAgbWF4LXdpZHRoOiAxMDAlO1xyXG4gICAgICAgICAgICAgICAgd2lkdGg6IDEwMCU7XHJcbiAgICAgICAgICAgICAgICBtaW4taGVpZ2h0OiAxMDBweDtcclxuICAgICAgICAgICAgICAgIG9iamVjdC1maXQ6IGNvdmVyO1xyXG4gICAgICAgICAgICB9XHJcbiAgICAgICAgfVxyXG4gICAgICAgIC5kZXRhaWx7XHJcbiAgICAgICAgICAgIHBhZGRpbmc6IDEwcHg7XHJcblxyXG4gICAgICAgIH1cclxuICAgIH1cclxufVxyXG4uc2lkZWJhci1sb2Nre1xyXG4gICAgZGlzcGxheTogYmxvY2s7XHJcbiAgICBwb3NpdGlvbjogZml4ZWQ7XHJcbiAgICB6LWluZGV4OiAxMDA7XHJcbiAgICB0b3A6IDU2cHg7XHJcbiAgICBsZWZ0OiAwO1xyXG4gICAgYm90dG9tOiAwO1xyXG4gICAgd2lkdGg6IDMwMHB4O1xyXG5cclxuICAgIGJhY2tncm91bmQ6IHJnYmEoMCwgMCwgMCwgMC40KTtcclxuICAgICY6OmFmdGVye1xyXG4gICAgICAgIGRpc3BsYXk6IHRhYmxlO1xyXG4gICAgICAgIGNvbnRlbnQ6IFwiIFwiO1xyXG4gICAgICAgIGNsZWFyOiBib3RoO1xyXG4gICAgfVxyXG59Il19 */"],
        encapsulation: 2
      });
      /***/
    },

    /***/
    "ofkY": function ofkY(module, __webpack_exports__, __webpack_require__) {
      "use strict";

      __webpack_require__.r(__webpack_exports__);
      /* harmony export (binding) */


      __webpack_require__.d(__webpack_exports__, "ProjectModule", function () {
        return ProjectModule;
      });
      /* harmony import */


      var _angular_common__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(
      /*! @angular/common */
      "ofXK");
      /* harmony import */


      var _ngrx_effects__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(
      /*! @ngrx/effects */
      "9jGm");
      /* harmony import */


      var _ngrx_store__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(
      /*! @ngrx/store */
      "l7P3");
      /* harmony import */


      var _shared_shared_module__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(
      /*! ../_shared/shared.module */
      "i2L+");
      /* harmony import */


      var _app_ui_module__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(
      /*! ../app-ui.module */
      "iasb");
      /* harmony import */


      var _auth_auth_module__WEBPACK_IMPORTED_MODULE_5__ = __webpack_require__(
      /*! ../auth/auth.module */
      "Yj9t");
      /* harmony import */


      var _project_routing_module__WEBPACK_IMPORTED_MODULE_6__ = __webpack_require__(
      /*! ./project-routing.module */
      "Vvw2");
      /* harmony import */


      var _angular_cdk_drag_drop__WEBPACK_IMPORTED_MODULE_7__ = __webpack_require__(
      /*! @angular/cdk/drag-drop */
      "5+WD");
      /* harmony import */


      var _store__WEBPACK_IMPORTED_MODULE_8__ = __webpack_require__(
      /*! ./_store */
      "Eydw");
      /* harmony import */


      var ng_zorro_antd_collapse__WEBPACK_IMPORTED_MODULE_9__ = __webpack_require__(
      /*! ng-zorro-antd/collapse */
      "IvDN");
      /* harmony import */


      var _angular_core__WEBPACK_IMPORTED_MODULE_10__ = __webpack_require__(
      /*! @angular/core */
      "fXoL");
      /* harmony import */


      var _workspace_workspace_component__WEBPACK_IMPORTED_MODULE_11__ = __webpack_require__(
      /*! ./workspace/workspace.component */
      "lYmp");
      /* harmony import */


      var _header_header_component__WEBPACK_IMPORTED_MODULE_12__ = __webpack_require__(
      /*! ./header/header.component */
      "MzbB");

      var ProjectModule = function ProjectModule() {
        _classCallCheck(this, ProjectModule);
      };

      ProjectModule.ɵfac = function ProjectModule_Factory(t) {
        return new (t || ProjectModule)();
      };

      ProjectModule.ɵmod = _angular_core__WEBPACK_IMPORTED_MODULE_10__["ɵɵdefineNgModule"]({
        type: ProjectModule
      });
      ProjectModule.ɵinj = _angular_core__WEBPACK_IMPORTED_MODULE_10__["ɵɵdefineInjector"]({
        providers: _toConsumableArray(_store__WEBPACK_IMPORTED_MODULE_8__["services"]),
        imports: [[_angular_cdk_drag_drop__WEBPACK_IMPORTED_MODULE_7__["DragDropModule"], _auth_auth_module__WEBPACK_IMPORTED_MODULE_5__["AuthModule"], _angular_common__WEBPACK_IMPORTED_MODULE_0__["CommonModule"], _app_ui_module__WEBPACK_IMPORTED_MODULE_4__["AppUIModule"], _shared_shared_module__WEBPACK_IMPORTED_MODULE_3__["SharedModule"], _project_routing_module__WEBPACK_IMPORTED_MODULE_6__["ProjectRoutingModule"], _ngrx_store__WEBPACK_IMPORTED_MODULE_2__["StoreModule"].forFeature('projectStore', _store__WEBPACK_IMPORTED_MODULE_8__["reducers"]), _ngrx_effects__WEBPACK_IMPORTED_MODULE_1__["EffectsModule"].forFeature(_store__WEBPACK_IMPORTED_MODULE_8__["effects"]), ng_zorro_antd_collapse__WEBPACK_IMPORTED_MODULE_9__["NzCollapseModule"]]]
      });

      (function () {
        (typeof ngJitMode === "undefined" || ngJitMode) && _angular_core__WEBPACK_IMPORTED_MODULE_10__["ɵɵsetNgModuleScope"](ProjectModule, {
          declarations: [_workspace_workspace_component__WEBPACK_IMPORTED_MODULE_11__["WorkspaceComponent"], _header_header_component__WEBPACK_IMPORTED_MODULE_12__["HeaderComponent"]],
          imports: [_angular_cdk_drag_drop__WEBPACK_IMPORTED_MODULE_7__["DragDropModule"], _auth_auth_module__WEBPACK_IMPORTED_MODULE_5__["AuthModule"], _angular_common__WEBPACK_IMPORTED_MODULE_0__["CommonModule"], _app_ui_module__WEBPACK_IMPORTED_MODULE_4__["AppUIModule"], _shared_shared_module__WEBPACK_IMPORTED_MODULE_3__["SharedModule"], _project_routing_module__WEBPACK_IMPORTED_MODULE_6__["ProjectRoutingModule"], _ngrx_store__WEBPACK_IMPORTED_MODULE_2__["StoreFeatureModule"], _ngrx_effects__WEBPACK_IMPORTED_MODULE_1__["EffectsFeatureModule"], ng_zorro_antd_collapse__WEBPACK_IMPORTED_MODULE_9__["NzCollapseModule"]]
        });
      })();
      /***/

    },

    /***/
    "peC7": function peC7(module, __webpack_exports__, __webpack_require__) {
      "use strict";

      __webpack_require__.r(__webpack_exports__);
      /* harmony export (binding) */


      __webpack_require__.d(__webpack_exports__, "effects", function () {
        return effects;
      }); // import { CollectionEffects } from './collection/effects';


      var effects = [// CollectionEffects,
      ];
      /***/
    },

    /***/
    "tgjP": function tgjP(module, __webpack_exports__, __webpack_require__) {
      "use strict";

      __webpack_require__.r(__webpack_exports__);
      /* harmony export (binding) */


      __webpack_require__.d(__webpack_exports__, "ProjectTableService", function () {
        return ProjectTableService;
      });
      /* harmony import */


      var _app_core_services_lost_db_table_service__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(
      /*! @app/_core/services/lost-db-table.service */
      "X54T");
      /* harmony import */


      var _angular_core__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(
      /*! @angular/core */
      "fXoL");
      /* harmony import */


      var _app_core_services_lost_db_service__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(
      /*! @app/_core/services/lost-db.service */
      "Y0hG");

      var ProjectTableService = /*#__PURE__*/function (_app_core_services_lo) {
        _inherits(ProjectTableService, _app_core_services_lo);

        var _super4 = _createSuper(ProjectTableService);

        function ProjectTableService(dbService) {
          var _this17;

          _classCallCheck(this, ProjectTableService);

          _this17 = _super4.call(this, dbService);
          _this17.dbService = dbService;
          _this17.name = 'projects';
          _this17.columns = {
            id: {
              type: "number",
              autoIncrement: true
            },
            name: {
              type: "string",
              required: true
            },
            category_id: {
              type: "number",
              defVal: 0
            },
            description: {
              type: "string",
              defVal: ""
            },
            status: {
              type: "string",
              defVal: "draft"
            },
            allow_custom: {
              type: "boolean",
              defVal: false
            },
            thumbnail: {
              type: "string",
              defVal: ""
            },
            renderer: {
              type: "object",
              defVal: {}
            },
            scene: {
              type: "object",
              defVal: {}
            },
            composer: {
              type: "object",
              defVal: {}
            },
            shadow: {
              type: "object",
              defVal: {}
            },
            camera: {
              type: "object",
              defVal: {}
            },
            control: {
              type: "object",
              defVal: {}
            },
            lights: {
              type: "array",
              defVal: []
            },
            // objects
            objects: {
              type: "array",
              defVal: []
            },
            // objects
            meshes: {
              type: "array",
              defVal: []
            }
          };

          _this17.init();

          return _this17;
        }

        return ProjectTableService;
      }(_app_core_services_lost_db_table_service__WEBPACK_IMPORTED_MODULE_0__["LostDbTableService"]);

      ProjectTableService.ɵfac = function ProjectTableService_Factory(t) {
        return new (t || ProjectTableService)(_angular_core__WEBPACK_IMPORTED_MODULE_1__["ɵɵinject"](_app_core_services_lost_db_service__WEBPACK_IMPORTED_MODULE_2__["LostDbService"]));
      };

      ProjectTableService.ɵprov = _angular_core__WEBPACK_IMPORTED_MODULE_1__["ɵɵdefineInjectable"]({
        token: ProjectTableService,
        factory: ProjectTableService.ɵfac,
        providedIn: 'root'
      });
      /***/
    },

    /***/
    "wJCM": function wJCM(module, __webpack_exports__, __webpack_require__) {
      "use strict";

      __webpack_require__.r(__webpack_exports__);
      /* harmony export (binding) */


      __webpack_require__.d(__webpack_exports__, "services", function () {
        return services;
      });
      /* harmony import */


      var _app_store_category__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(
      /*! @app/_store/category */
      "aGpf");
      /* harmony import */


      var _app_store_project__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(
      /*! @app/_store/project */
      "jikU");
      /* harmony import */


      var _app_store_project_table__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(
      /*! @app/_store/project/table */
      "tgjP");

      var services = [_app_store_project__WEBPACK_IMPORTED_MODULE_1__["ProjectService"], _app_store_category__WEBPACK_IMPORTED_MODULE_0__["CategoryService"], _app_store_project_table__WEBPACK_IMPORTED_MODULE_2__["ProjectTableService"]];
      /***/
    },

    /***/
    "ywSG": function ywSG(module, __webpack_exports__, __webpack_require__) {
      "use strict";

      __webpack_require__.r(__webpack_exports__);
      /* harmony export (binding) */


      __webpack_require__.d(__webpack_exports__, "ProjectService", function () {
        return ProjectService;
      });
      /* harmony import */


      var _angular_core__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(
      /*! @angular/core */
      "fXoL");
      /* harmony import */


      var _app_core_services_http_service__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(
      /*! @app/_core/services/http.service */
      "9IAc");

      var API_CUSTOMERS_URL = 'projects';

      var ProjectService = /*#__PURE__*/function () {
        function ProjectService(httpService) {
          _classCallCheck(this, ProjectService);

          this.httpService = httpService;
        }

        _createClass(ProjectService, [{
          key: "getAll",
          value: function getAll(params) {
            return this.httpService.get(API_CUSTOMERS_URL + "/list", params);
          } // get(key): Observable<ProjectResultModel> {
          //   return this.httpService.get(`${API_CUSTOMERS_URL}/${key}.json`);
          // }

        }, {
          key: "get",
          value: function get(key) {
            return this.httpService.get("".concat(API_CUSTOMERS_URL, "/detail/").concat(key));
          }
        }, {
          key: "getByCategories",
          value: function getByCategories(params) {
            return this.httpService.get(API_CUSTOMERS_URL + "/categories", params);
          }
        }, {
          key: "create",
          value: function create(model) {
            return this.httpService.post(API_CUSTOMERS_URL + "/create", model);
          }
        }, {
          key: "update",
          value: function update(model) {
            var key = model.id; // return this.httpService.patch(`${API_CUSTOMERS_URL}/${key}.json`, model);
            // return this.httpService.patch(`${API_CUSTOMERS_URL}/actions.json`, model);

            return this.httpService.put("".concat(API_CUSTOMERS_URL, "/update/").concat(key), model);
          }
        }, {
          key: "updateThumbnail",
          value: function updateThumbnail(model) {
            var key = model.id; // return this.httpService.patch(`${API_CUSTOMERS_URL}/${key}.json`, model);
            // return this.httpService.patch(`${API_CUSTOMERS_URL}/actions.json`, model);

            return this.httpService.put("".concat(API_CUSTOMERS_URL, "/thumbnail/").concat(key), model);
          }
        }, {
          key: "delete",
          value: function _delete(key) {
            // return this.httpService.delete(`${API_CUSTOMERS_URL}/${key}`);
            return this.httpService["delete"]("".concat(API_CUSTOMERS_URL, "/delete/").concat(key));
          }
        }, {
          key: "search",
          value: function search(query) {
            return this.httpService.get("".concat(API_CUSTOMERS_URL, "/list"), query);
          }
        }, {
          key: "searchNounProject",
          value: function searchNounProject(query) {
            return this.httpService.get("".concat(API_CUSTOMERS_URL, "/search/nounproject"), query);
          }
        }, {
          key: "render",
          value: function render(params) {
            return this.httpService.download("projects/render", params);
          }
        }, {
          key: "getProjectData",
          value: function getProjectData(url) {
            return this.httpService.getOut(url);
          }
        }, {
          key: "useProject",
          value: function useProject(ProjectId) {
            return this.httpService.post("".concat(API_CUSTOMERS_URL, "/").concat(ProjectId, "/use"), {}, false);
          }
        }]);

        return ProjectService;
      }();

      ProjectService.ɵfac = function ProjectService_Factory(t) {
        return new (t || ProjectService)(_angular_core__WEBPACK_IMPORTED_MODULE_0__["ɵɵinject"](_app_core_services_http_service__WEBPACK_IMPORTED_MODULE_1__["HttpService"]));
      };

      ProjectService.ɵprov = _angular_core__WEBPACK_IMPORTED_MODULE_0__["ɵɵdefineInjectable"]({
        token: ProjectService,
        factory: ProjectService.ɵfac,
        providedIn: 'root'
      });
      /***/
    },

    /***/
    "zhHN": function zhHN(module, __webpack_exports__, __webpack_require__) {
      "use strict";

      __webpack_require__.r(__webpack_exports__);
      /* harmony export (binding) */


      __webpack_require__.d(__webpack_exports__, "reducers", function () {
        return reducers;
      });
      /* harmony export (binding) */


      __webpack_require__.d(__webpack_exports__, "selectContainerState", function () {
        return selectContainerState;
      });
      /* harmony import */


      var _ngrx_store__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(
      /*! @ngrx/store */
      "l7P3");

      var reducers = {};
      var selectContainerState = Object(_ngrx_store__WEBPACK_IMPORTED_MODULE_0__["createFeatureSelector"])('itemStore');
      /***/
    }
  }]);
})();
//# sourceMappingURL=project-page-project-module-es5.js.map