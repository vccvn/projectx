(function () {
  function _defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } }

  function _createClass(Constructor, protoProps, staticProps) { if (protoProps) _defineProperties(Constructor.prototype, protoProps); if (staticProps) _defineProperties(Constructor, staticProps); return Constructor; }

  function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }

  (window["webpackJsonp"] = window["webpackJsonp"] || []).push([["auth-auth-module"], {
    /***/
    "/WaZ": function WaZ(module, __webpack_exports__, __webpack_require__) {
      "use strict";

      __webpack_require__.r(__webpack_exports__);
      /* harmony export (binding) */


      __webpack_require__.d(__webpack_exports__, "AuthActionTypes", function () {
        return AuthActionTypes;
      });
      /* harmony export (binding) */


      __webpack_require__.d(__webpack_exports__, "Login", function () {
        return Login;
      });
      /* harmony export (binding) */


      __webpack_require__.d(__webpack_exports__, "LoginSuccess", function () {
        return LoginSuccess;
      });
      /* harmony export (binding) */


      __webpack_require__.d(__webpack_exports__, "LoginFailure", function () {
        return LoginFailure;
      });

      var AuthActionTypes;

      (function (AuthActionTypes) {
        AuthActionTypes["LOGIN"] = "[Auth] Login";
        AuthActionTypes["LOGIN_SUCCESS"] = "[Auth] Login Success";
        AuthActionTypes["LOGIN_FAILURE"] = "[Auth] Login Failure";
      })(AuthActionTypes || (AuthActionTypes = {}));

      var Login = function Login(payload) {
        _classCallCheck(this, Login);

        this.payload = payload;
        this.type = AuthActionTypes.LOGIN;
      };

      var LoginSuccess = function LoginSuccess(payload) {
        _classCallCheck(this, LoginSuccess);

        this.payload = payload;
        this.type = AuthActionTypes.LOGIN_SUCCESS;
      };

      var LoginFailure = function LoginFailure(payload) {
        _classCallCheck(this, LoginFailure);

        this.payload = payload;
        this.type = AuthActionTypes.LOGIN_FAILURE;
      };
      /***/

    },

    /***/
    "6epW": function epW(module, __webpack_exports__, __webpack_require__) {
      "use strict";

      __webpack_require__.r(__webpack_exports__);
      /* harmony export (binding) */


      __webpack_require__.d(__webpack_exports__, "COMPONENTS", function () {
        return COMPONENTS;
      });
      /* harmony export (binding) */


      __webpack_require__.d(__webpack_exports__, "AuthRoutingModule", function () {
        return AuthRoutingModule;
      });
      /* harmony import */


      var _angular_router__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(
      /*! @angular/router */
      "tyNb");
      /* harmony import */


      var _login_login_component__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(
      /*! ./login/login.component */
      "bsvf");
      /* harmony import */


      var _core_guards__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(
      /*! ../_core/guards */
      "IvES");
      /* harmony import */


      var _layout_layout_component__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(
      /*! ./layout/layout.component */
      "EQsV");
      /* harmony import */


      var _angular_core__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(
      /*! @angular/core */
      "fXoL");

      var routes = [{
        path: '',
        component: _layout_layout_component__WEBPACK_IMPORTED_MODULE_3__["LayoutAuthComponent"],
        canActivate: [_core_guards__WEBPACK_IMPORTED_MODULE_2__["UnAuthGuard"]],
        children: [{
          path: 'login',
          component: _login_login_component__WEBPACK_IMPORTED_MODULE_1__["LoginComponent"]
        }]
      }];
      var COMPONENTS = [_login_login_component__WEBPACK_IMPORTED_MODULE_1__["LoginComponent"], _layout_layout_component__WEBPACK_IMPORTED_MODULE_3__["LayoutAuthComponent"]];

      var AuthRoutingModule = function AuthRoutingModule() {
        _classCallCheck(this, AuthRoutingModule);
      };

      AuthRoutingModule.ɵfac = function AuthRoutingModule_Factory(t) {
        return new (t || AuthRoutingModule)();
      };

      AuthRoutingModule.ɵmod = _angular_core__WEBPACK_IMPORTED_MODULE_4__["ɵɵdefineNgModule"]({
        type: AuthRoutingModule
      });
      AuthRoutingModule.ɵinj = _angular_core__WEBPACK_IMPORTED_MODULE_4__["ɵɵdefineInjector"]({
        imports: [[_angular_router__WEBPACK_IMPORTED_MODULE_0__["RouterModule"].forChild(routes)], _angular_router__WEBPACK_IMPORTED_MODULE_0__["RouterModule"]]
      });

      (function () {
        (typeof ngJitMode === "undefined" || ngJitMode) && _angular_core__WEBPACK_IMPORTED_MODULE_4__["ɵɵsetNgModuleScope"](AuthRoutingModule, {
          imports: [_angular_router__WEBPACK_IMPORTED_MODULE_0__["RouterModule"]],
          exports: [_angular_router__WEBPACK_IMPORTED_MODULE_0__["RouterModule"]]
        });
      })();
      /***/

    },

    /***/
    "DvZs": function DvZs(module, __webpack_exports__, __webpack_require__) {
      "use strict";

      __webpack_require__.r(__webpack_exports__);
      /* harmony import */


      var _auth_actions__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(
      /*! ./auth.actions */
      "/WaZ");
      /* harmony reexport (safe) */


      __webpack_require__.d(__webpack_exports__, "AuthActionTypes", function () {
        return _auth_actions__WEBPACK_IMPORTED_MODULE_0__["AuthActionTypes"];
      });
      /* harmony reexport (safe) */


      __webpack_require__.d(__webpack_exports__, "Login", function () {
        return _auth_actions__WEBPACK_IMPORTED_MODULE_0__["Login"];
      });
      /* harmony reexport (safe) */


      __webpack_require__.d(__webpack_exports__, "LoginSuccess", function () {
        return _auth_actions__WEBPACK_IMPORTED_MODULE_0__["LoginSuccess"];
      });
      /* harmony reexport (safe) */


      __webpack_require__.d(__webpack_exports__, "LoginFailure", function () {
        return _auth_actions__WEBPACK_IMPORTED_MODULE_0__["LoginFailure"];
      });
      /* harmony import */


      var _auth_effects__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(
      /*! ./auth.effects */
      "OW08");
      /* harmony reexport (safe) */


      __webpack_require__.d(__webpack_exports__, "AuthEffects", function () {
        return _auth_effects__WEBPACK_IMPORTED_MODULE_1__["AuthEffects"];
      });
      /* harmony import */


      var _auth_reducer__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(
      /*! ./auth.reducer */
      "qkvP");
      /* harmony reexport (safe) */


      __webpack_require__.d(__webpack_exports__, "initialState", function () {
        return _auth_reducer__WEBPACK_IMPORTED_MODULE_2__["initialState"];
      });
      /* harmony reexport (safe) */


      __webpack_require__.d(__webpack_exports__, "reducer", function () {
        return _auth_reducer__WEBPACK_IMPORTED_MODULE_2__["reducer"];
      });
      /* harmony reexport (safe) */


      __webpack_require__.d(__webpack_exports__, "selectAuthState", function () {
        return _auth_reducer__WEBPACK_IMPORTED_MODULE_2__["selectAuthState"];
      });
      /* harmony import */


      var _auth_selectors__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(
      /*! ./auth.selectors */
      "Xd88");
      /* harmony reexport (safe) */


      __webpack_require__.d(__webpack_exports__, "getIsAuthenticating", function () {
        return _auth_selectors__WEBPACK_IMPORTED_MODULE_3__["getIsAuthenticating"];
      });
      /***/

    },

    /***/
    "EQsV": function EQsV(module, __webpack_exports__, __webpack_require__) {
      "use strict";

      __webpack_require__.r(__webpack_exports__);
      /* harmony export (binding) */


      __webpack_require__.d(__webpack_exports__, "LayoutAuthComponent", function () {
        return LayoutAuthComponent;
      });
      /* harmony import */


      var _angular_core__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(
      /*! @angular/core */
      "fXoL");
      /* harmony import */


      var _angular_router__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(
      /*! @angular/router */
      "tyNb");

      var LayoutAuthComponent = function LayoutAuthComponent() {
        _classCallCheck(this, LayoutAuthComponent);
      };

      LayoutAuthComponent.ɵfac = function LayoutAuthComponent_Factory(t) {
        return new (t || LayoutAuthComponent)();
      };

      LayoutAuthComponent.ɵcmp = _angular_core__WEBPACK_IMPORTED_MODULE_0__["ɵɵdefineComponent"]({
        type: LayoutAuthComponent,
        selectors: [["app-layout-auth"]],
        decls: 1,
        vars: 0,
        template: function LayoutAuthComponent_Template(rf, ctx) {
          if (rf & 1) {
            _angular_core__WEBPACK_IMPORTED_MODULE_0__["ɵɵelement"](0, "router-outlet");
          }
        },
        directives: [_angular_router__WEBPACK_IMPORTED_MODULE_1__["RouterOutlet"]],
        styles: ["[_nghost-%COMP%]     .container {\n  display: flex;\n  flex-direction: column;\n  min-height: 100%;\n  background: #f0f2f5;\n}\n[_nghost-%COMP%]     .langs {\n  width: 100%;\n  height: 40px;\n  line-height: 44px;\n  text-align: right;\n}\n[_nghost-%COMP%]     .langs .anticon {\n  margin-top: 24px;\n  margin-right: 24px;\n  font-size: 14px;\n  vertical-align: top;\n  cursor: pointer;\n}\n[_nghost-%COMP%]     .wrap {\n  flex: 1;\n  padding: 32px 0;\n}\n[_nghost-%COMP%]     .ant-form-item {\n  margin-bottom: 24px;\n}\n@media (min-width: 768px) {\n  [_nghost-%COMP%]     .container {\n    background-image: url(\"https://gw.alipayobjects.com/zos/rmsportal/TVYTbAXWheQpRcWDaDMu.svg\");\n    background-repeat: no-repeat;\n    background-position: center 110px;\n    background-size: 100%;\n  }\n  [_nghost-%COMP%]     .wrap {\n    padding: 32px 0 24px;\n  }\n}\n[_nghost-%COMP%]     .top {\n  text-align: center;\n}\n[_nghost-%COMP%]     .header {\n  height: 44px;\n  line-height: 44px;\n}\n[_nghost-%COMP%]     .header a {\n  text-decoration: none;\n}\n[_nghost-%COMP%]     .logo {\n  height: 44px;\n  margin-right: 16px;\n}\n[_nghost-%COMP%]     .title {\n  position: relative;\n  color: #000000;\n  font-weight: 600;\n  font-size: 33px;\n  font-family: \"Myriad Pro\", \"Helvetica Neue\", Arial, Helvetica, sans-serif;\n  vertical-align: middle;\n}\n[_nghost-%COMP%]     .desc {\n  margin-top: 12px;\n  margin-bottom: 40px;\n  color: #000000;\n  font-size: 16px;\n}\n/*# sourceMappingURL=data:application/json;base64,eyJ2ZXJzaW9uIjozLCJzb3VyY2VzIjpbIi4uXFwuLlxcLi5cXC4uXFxsYXlvdXQuY29tcG9uZW50LnNjc3MiXSwibmFtZXMiOltdLCJtYXBwaW5ncyI6IkFBRUk7RUFDRSxhQUFBO0VBQ0Esc0JBQUE7RUFDQSxnQkFBQTtFQUNBLG1CQUFBO0FBRE47QUFJSTtFQUNFLFdBQUE7RUFDQSxZQUFBO0VBQ0EsaUJBQUE7RUFDQSxpQkFBQTtBQUZOO0FBSU07RUFDRSxnQkFBQTtFQUNBLGtCQUFBO0VBQ0EsZUFBQTtFQUNBLG1CQUFBO0VBQ0EsZUFBQTtBQUZSO0FBTUk7RUFDRSxPQUFBO0VBQ0EsZUFBQTtBQUpOO0FBT0k7RUFDRSxtQkFBQTtBQUxOO0FBUUk7RUFDRTtJQUNFLDRGQUFBO0lBQ0EsNEJBQUE7SUFDQSxpQ0FBQTtJQUNBLHFCQUFBO0VBTk47RUFTSTtJQUNFLG9CQUFBO0VBUE47QUFDRjtBQVVJO0VBQ0Usa0JBQUE7QUFSTjtBQVdJO0VBQ0UsWUFBQTtFQUNBLGlCQUFBO0FBVE47QUFXTTtFQUNFLHFCQUFBO0FBVFI7QUFhSTtFQUNFLFlBQUE7RUFDQSxrQkFBQTtBQVhOO0FBY0k7RUFDRSxrQkFBQTtFQUNBLGNBQUE7RUFDQSxnQkFBQTtFQUNBLGVBQUE7RUFDQSx5RUFBQTtFQUNBLHNCQUFBO0FBWk47QUFlSTtFQUNFLGdCQUFBO0VBQ0EsbUJBQUE7RUFDQSxjQUFBO0VBQ0EsZUFBQTtBQWJOIiwiZmlsZSI6ImxheW91dC5jb21wb25lbnQuc2NzcyIsInNvdXJjZXNDb250ZW50IjpbIjpob3N0IHtcclxuICA6Om5nLWRlZXAge1xyXG4gICAgLmNvbnRhaW5lciB7XHJcbiAgICAgIGRpc3BsYXk6IGZsZXg7XHJcbiAgICAgIGZsZXgtZGlyZWN0aW9uOiBjb2x1bW47XHJcbiAgICAgIG1pbi1oZWlnaHQ6IDEwMCU7XHJcbiAgICAgIGJhY2tncm91bmQ6ICNmMGYyZjU7XHJcbiAgICB9XHJcblxyXG4gICAgLmxhbmdzIHtcclxuICAgICAgd2lkdGg6IDEwMCU7XHJcbiAgICAgIGhlaWdodDogNDBweDtcclxuICAgICAgbGluZS1oZWlnaHQ6IDQ0cHg7XHJcbiAgICAgIHRleHQtYWxpZ246IHJpZ2h0O1xyXG5cclxuICAgICAgLmFudGljb24ge1xyXG4gICAgICAgIG1hcmdpbi10b3A6IDI0cHg7XHJcbiAgICAgICAgbWFyZ2luLXJpZ2h0OiAyNHB4O1xyXG4gICAgICAgIGZvbnQtc2l6ZTogMTRweDtcclxuICAgICAgICB2ZXJ0aWNhbC1hbGlnbjogdG9wO1xyXG4gICAgICAgIGN1cnNvcjogcG9pbnRlcjtcclxuICAgICAgfVxyXG4gICAgfVxyXG5cclxuICAgIC53cmFwIHtcclxuICAgICAgZmxleDogMTtcclxuICAgICAgcGFkZGluZzogMzJweCAwO1xyXG4gICAgfVxyXG5cclxuICAgIC5hbnQtZm9ybS1pdGVtIHtcclxuICAgICAgbWFyZ2luLWJvdHRvbTogMjRweDtcclxuICAgIH1cclxuXHJcbiAgICBAbWVkaWEgKG1pbi13aWR0aDogNzY4cHgpIHtcclxuICAgICAgLmNvbnRhaW5lciB7XHJcbiAgICAgICAgYmFja2dyb3VuZC1pbWFnZTogdXJsKCdodHRwczovL2d3LmFsaXBheW9iamVjdHMuY29tL3pvcy9ybXNwb3J0YWwvVFZZVGJBWFdoZVFwUmNXRGFETXUuc3ZnJyk7XHJcbiAgICAgICAgYmFja2dyb3VuZC1yZXBlYXQ6IG5vLXJlcGVhdDtcclxuICAgICAgICBiYWNrZ3JvdW5kLXBvc2l0aW9uOiBjZW50ZXIgMTEwcHg7XHJcbiAgICAgICAgYmFja2dyb3VuZC1zaXplOiAxMDAlO1xyXG4gICAgICB9XHJcblxyXG4gICAgICAud3JhcCB7XHJcbiAgICAgICAgcGFkZGluZzogMzJweCAwIDI0cHg7XHJcbiAgICAgIH1cclxuICAgIH1cclxuXHJcbiAgICAudG9wIHtcclxuICAgICAgdGV4dC1hbGlnbjogY2VudGVyO1xyXG4gICAgfVxyXG5cclxuICAgIC5oZWFkZXIge1xyXG4gICAgICBoZWlnaHQ6IDQ0cHg7XHJcbiAgICAgIGxpbmUtaGVpZ2h0OiA0NHB4O1xyXG5cclxuICAgICAgYSB7XHJcbiAgICAgICAgdGV4dC1kZWNvcmF0aW9uOiBub25lO1xyXG4gICAgICB9XHJcbiAgICB9XHJcblxyXG4gICAgLmxvZ28ge1xyXG4gICAgICBoZWlnaHQ6IDQ0cHg7XHJcbiAgICAgIG1hcmdpbi1yaWdodDogMTZweDtcclxuICAgIH1cclxuXHJcbiAgICAudGl0bGUge1xyXG4gICAgICBwb3NpdGlvbjogcmVsYXRpdmU7XHJcbiAgICAgIGNvbG9yOiAjMDAwMDAwO1xyXG4gICAgICBmb250LXdlaWdodDogNjAwO1xyXG4gICAgICBmb250LXNpemU6IDMzcHg7XHJcbiAgICAgIGZvbnQtZmFtaWx5OiAnTXlyaWFkIFBybycsICdIZWx2ZXRpY2EgTmV1ZScsIEFyaWFsLCBIZWx2ZXRpY2EsIHNhbnMtc2VyaWY7XHJcbiAgICAgIHZlcnRpY2FsLWFsaWduOiBtaWRkbGU7XHJcbiAgICB9XHJcblxyXG4gICAgLmRlc2Mge1xyXG4gICAgICBtYXJnaW4tdG9wOiAxMnB4O1xyXG4gICAgICBtYXJnaW4tYm90dG9tOiA0MHB4O1xyXG4gICAgICBjb2xvcjogIzAwMDAwMDtcclxuICAgICAgZm9udC1zaXplOiAxNnB4O1xyXG4gICAgfVxyXG4gIH1cclxufVxyXG4iXX0= */"]
      });
      /***/
    },

    /***/
    "LS6v": function LS6v(module, __webpack_exports__, __webpack_require__) {
      "use strict";

      __webpack_require__.r(__webpack_exports__);
      /* harmony export (binding) */


      __webpack_require__.d(__webpack_exports__, "AuthComponent", function () {
        return AuthComponent;
      });
      /* harmony import */


      var _angular_core__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(
      /*! @angular/core */
      "fXoL");
      /* harmony import */


      var _angular_router__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(
      /*! @angular/router */
      "tyNb");

      var AuthComponent = function AuthComponent() {
        _classCallCheck(this, AuthComponent);
      };

      AuthComponent.ɵfac = function AuthComponent_Factory(t) {
        return new (t || AuthComponent)();
      };

      AuthComponent.ɵcmp = _angular_core__WEBPACK_IMPORTED_MODULE_0__["ɵɵdefineComponent"]({
        type: AuthComponent,
        selectors: [["app-auth"]],
        decls: 1,
        vars: 0,
        template: function AuthComponent_Template(rf, ctx) {
          if (rf & 1) {
            _angular_core__WEBPACK_IMPORTED_MODULE_0__["ɵɵelement"](0, "router-outlet");
          }
        },
        directives: [_angular_router__WEBPACK_IMPORTED_MODULE_1__["RouterOutlet"]],
        styles: ["\n/*# sourceMappingURL=data:application/json;base64,eyJ2ZXJzaW9uIjozLCJzb3VyY2VzIjpbXSwibmFtZXMiOltdLCJtYXBwaW5ncyI6IiIsImZpbGUiOiJhdXRoLmNvbXBvbmVudC5zY3NzIn0= */"]
      });
      /***/
    },

    /***/
    "OW08": function OW08(module, __webpack_exports__, __webpack_require__) {
      "use strict";

      __webpack_require__.r(__webpack_exports__);
      /* harmony export (binding) */


      __webpack_require__.d(__webpack_exports__, "AuthEffects", function () {
        return AuthEffects;
      });
      /* harmony import */


      var tslib__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(
      /*! tslib */
      "mrSG");
      /* harmony import */


      var _ngrx_effects__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(
      /*! @ngrx/effects */
      "9jGm");
      /* harmony import */


      var rxjs_operators__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(
      /*! rxjs/operators */
      "kU1M");
      /* harmony import */


      var _auth_actions__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(
      /*! ./auth.actions */
      "/WaZ");
      /* harmony import */


      var rxjs__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(
      /*! rxjs */
      "qCKp");
      /* harmony import */


      var _angular_core__WEBPACK_IMPORTED_MODULE_5__ = __webpack_require__(
      /*! @angular/core */
      "fXoL");
      /* harmony import */


      var _services__WEBPACK_IMPORTED_MODULE_6__ = __webpack_require__(
      /*! ../services */
      "bTys");
      /* harmony import */


      var _app_core_services_setting_setting_service__WEBPACK_IMPORTED_MODULE_7__ = __webpack_require__(
      /*! @app/_core/services/setting/setting.service */
      "uEm4");
      /* harmony import */


      var _angular_router__WEBPACK_IMPORTED_MODULE_8__ = __webpack_require__(
      /*! @angular/router */
      "tyNb");

      var AuthActionTypes = _auth_actions__WEBPACK_IMPORTED_MODULE_3__.AuthActionTypes;

      var AuthEffects = function AuthEffects(actions$, authenticationService, settingService, router) {
        var _this = this;

        _classCallCheck(this, AuthEffects);

        this.actions$ = actions$;
        this.authenticationService = authenticationService;
        this.settingService = settingService;
        this.router = router;
        this.login$ = this.actions$.pipe(Object(_ngrx_effects__WEBPACK_IMPORTED_MODULE_1__["ofType"])(AuthActionTypes.LOGIN), Object(rxjs_operators__WEBPACK_IMPORTED_MODULE_2__["map"])(function (action) {
          return action.payload;
        }), Object(rxjs_operators__WEBPACK_IMPORTED_MODULE_2__["switchMap"])(function (payload) {
          return _this.authenticationService.login(payload.email, payload.password).pipe(Object(rxjs_operators__WEBPACK_IMPORTED_MODULE_2__["map"])(function (user) {
            return new _auth_actions__WEBPACK_IMPORTED_MODULE_3__["LoginSuccess"](user);
          }), Object(rxjs_operators__WEBPACK_IMPORTED_MODULE_2__["catchError"])(function (error) {
            return Object(rxjs__WEBPACK_IMPORTED_MODULE_4__["of"])(new _auth_actions__WEBPACK_IMPORTED_MODULE_3__["LoginFailure"]({
              error: error
            }));
          }));
        }));
        this.loginSuccess$ = this.actions$.pipe(Object(_ngrx_effects__WEBPACK_IMPORTED_MODULE_1__["ofType"])(AuthActionTypes.LOGIN_SUCCESS), Object(rxjs_operators__WEBPACK_IMPORTED_MODULE_2__["tap"])(function (res) {
          _this.settingService.setUser(res.payload);

          _this.router.navigate(['p/teams']);
        }));
      };

      AuthEffects.ɵfac = function AuthEffects_Factory(t) {
        return new (t || AuthEffects)(_angular_core__WEBPACK_IMPORTED_MODULE_5__["ɵɵinject"](_ngrx_effects__WEBPACK_IMPORTED_MODULE_1__["Actions"]), _angular_core__WEBPACK_IMPORTED_MODULE_5__["ɵɵinject"](_services__WEBPACK_IMPORTED_MODULE_6__["AuthenticationService"]), _angular_core__WEBPACK_IMPORTED_MODULE_5__["ɵɵinject"](_app_core_services_setting_setting_service__WEBPACK_IMPORTED_MODULE_7__["SettingService"]), _angular_core__WEBPACK_IMPORTED_MODULE_5__["ɵɵinject"](_angular_router__WEBPACK_IMPORTED_MODULE_8__["Router"]));
      };

      AuthEffects.ɵprov = _angular_core__WEBPACK_IMPORTED_MODULE_5__["ɵɵdefineInjectable"]({
        token: AuthEffects,
        factory: AuthEffects.ɵfac
      });
      Object(tslib__WEBPACK_IMPORTED_MODULE_0__["__decorate"])([Object(_ngrx_effects__WEBPACK_IMPORTED_MODULE_1__["Effect"])()], AuthEffects.prototype, "login$", void 0);
      Object(tslib__WEBPACK_IMPORTED_MODULE_0__["__decorate"])([Object(_ngrx_effects__WEBPACK_IMPORTED_MODULE_1__["Effect"])({
        dispatch: false
      })], AuthEffects.prototype, "loginSuccess$", void 0);
      /***/
    },

    /***/
    "Xd88": function Xd88(module, __webpack_exports__, __webpack_require__) {
      "use strict";

      __webpack_require__.r(__webpack_exports__);
      /* harmony export (binding) */


      __webpack_require__.d(__webpack_exports__, "getIsAuthenticating", function () {
        return getIsAuthenticating;
      });
      /* harmony import */


      var _auth_reducer__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(
      /*! ./auth.reducer */
      "qkvP");
      /* harmony import */


      var _ngrx_store__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(
      /*! @ngrx/store */
      "l7P3");

      var getIsAuthenticating = Object(_ngrx_store__WEBPACK_IMPORTED_MODULE_1__["createSelector"])(_auth_reducer__WEBPACK_IMPORTED_MODULE_0__["selectAuthState"], function (state) {
        return state.isAuthenticating;
      });
      /***/
    },

    /***/
    "Yj9t": function Yj9t(module, __webpack_exports__, __webpack_require__) {
      "use strict";

      __webpack_require__.r(__webpack_exports__);
      /* harmony export (binding) */


      __webpack_require__.d(__webpack_exports__, "AuthModule", function () {
        return AuthModule;
      });
      /* harmony import */


      var _angular_common__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(
      /*! @angular/common */
      "ofXK");
      /* harmony import */


      var _auth_routing_module__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(
      /*! ./auth-routing.module */
      "6epW");
      /* harmony import */


      var _ngrx_store__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(
      /*! @ngrx/store */
      "l7P3");
      /* harmony import */


      var _ngrx_effects__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(
      /*! @ngrx/effects */
      "9jGm");
      /* harmony import */


      var _store__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(
      /*! ./store */
      "DvZs");
      /* harmony import */


      var _auth_component__WEBPACK_IMPORTED_MODULE_5__ = __webpack_require__(
      /*! ./auth.component */
      "LS6v");
      /* harmony import */


      var _angular_forms__WEBPACK_IMPORTED_MODULE_6__ = __webpack_require__(
      /*! @angular/forms */
      "3Pt+");
      /* harmony import */


      var _shared_shared_module__WEBPACK_IMPORTED_MODULE_7__ = __webpack_require__(
      /*! ../_shared/shared.module */
      "i2L+");
      /* harmony import */


      var _app_ui_module__WEBPACK_IMPORTED_MODULE_8__ = __webpack_require__(
      /*! ../app-ui.module */
      "iasb");
      /* harmony import */


      var _angular_core__WEBPACK_IMPORTED_MODULE_9__ = __webpack_require__(
      /*! @angular/core */
      "fXoL");
      /* harmony import */


      var _login_login_component__WEBPACK_IMPORTED_MODULE_10__ = __webpack_require__(
      /*! ./login/login.component */
      "bsvf");
      /* harmony import */


      var _layout_layout_component__WEBPACK_IMPORTED_MODULE_11__ = __webpack_require__(
      /*! ./layout/layout.component */
      "EQsV");

      var AuthModule = function AuthModule() {
        _classCallCheck(this, AuthModule);
      };

      AuthModule.ɵfac = function AuthModule_Factory(t) {
        return new (t || AuthModule)();
      };

      AuthModule.ɵmod = _angular_core__WEBPACK_IMPORTED_MODULE_9__["ɵɵdefineNgModule"]({
        type: AuthModule
      });
      AuthModule.ɵinj = _angular_core__WEBPACK_IMPORTED_MODULE_9__["ɵɵdefineInjector"]({
        providers: [],
        imports: [[_angular_forms__WEBPACK_IMPORTED_MODULE_6__["ReactiveFormsModule"], _angular_forms__WEBPACK_IMPORTED_MODULE_6__["FormsModule"], _angular_common__WEBPACK_IMPORTED_MODULE_0__["CommonModule"], _auth_routing_module__WEBPACK_IMPORTED_MODULE_1__["AuthRoutingModule"], _shared_shared_module__WEBPACK_IMPORTED_MODULE_7__["SharedModule"], _app_ui_module__WEBPACK_IMPORTED_MODULE_8__["AppUIModule"], _ngrx_effects__WEBPACK_IMPORTED_MODULE_3__["EffectsModule"].forFeature([_store__WEBPACK_IMPORTED_MODULE_4__["AuthEffects"]]), _ngrx_store__WEBPACK_IMPORTED_MODULE_2__["StoreModule"].forFeature('authStore', _store__WEBPACK_IMPORTED_MODULE_4__["reducer"])]]
      });

      (function () {
        (typeof ngJitMode === "undefined" || ngJitMode) && _angular_core__WEBPACK_IMPORTED_MODULE_9__["ɵɵsetNgModuleScope"](AuthModule, {
          declarations: [_auth_component__WEBPACK_IMPORTED_MODULE_5__["AuthComponent"], _login_login_component__WEBPACK_IMPORTED_MODULE_10__["LoginComponent"], _layout_layout_component__WEBPACK_IMPORTED_MODULE_11__["LayoutAuthComponent"]],
          imports: [_angular_forms__WEBPACK_IMPORTED_MODULE_6__["ReactiveFormsModule"], _angular_forms__WEBPACK_IMPORTED_MODULE_6__["FormsModule"], _angular_common__WEBPACK_IMPORTED_MODULE_0__["CommonModule"], _auth_routing_module__WEBPACK_IMPORTED_MODULE_1__["AuthRoutingModule"], _shared_shared_module__WEBPACK_IMPORTED_MODULE_7__["SharedModule"], _app_ui_module__WEBPACK_IMPORTED_MODULE_8__["AppUIModule"], _ngrx_effects__WEBPACK_IMPORTED_MODULE_3__["EffectsFeatureModule"], _ngrx_store__WEBPACK_IMPORTED_MODULE_2__["StoreFeatureModule"]]
        });
      })();
      /***/

    },

    /***/
    "bsvf": function bsvf(module, __webpack_exports__, __webpack_require__) {
      "use strict";

      __webpack_require__.r(__webpack_exports__);
      /* harmony export (binding) */


      __webpack_require__.d(__webpack_exports__, "LoginComponent", function () {
        return LoginComponent;
      });
      /* harmony import */


      var _store__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(
      /*! ../store */
      "DvZs");
      /* harmony import */


      var _angular_forms__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(
      /*! @angular/forms */
      "3Pt+");
      /* harmony import */


      var _angular_core__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(
      /*! @angular/core */
      "fXoL");
      /* harmony import */


      var _ngrx_store__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(
      /*! @ngrx/store */
      "l7P3");
      /* harmony import */


      var ng_zorro_antd_form__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(
      /*! ng-zorro-antd/form */
      "ocnv");
      /* harmony import */


      var _angular_common__WEBPACK_IMPORTED_MODULE_5__ = __webpack_require__(
      /*! @angular/common */
      "ofXK");
      /* harmony import */


      var ng_zorro_antd_grid__WEBPACK_IMPORTED_MODULE_6__ = __webpack_require__(
      /*! ng-zorro-antd/grid */
      "B+r4");
      /* harmony import */


      var ng_zorro_antd_core_transition_patch__WEBPACK_IMPORTED_MODULE_7__ = __webpack_require__(
      /*! ng-zorro-antd/core/transition-patch */
      "C2AL");
      /* harmony import */


      var ng_zorro_antd_input__WEBPACK_IMPORTED_MODULE_8__ = __webpack_require__(
      /*! ng-zorro-antd/input */
      "PTRe");
      /* harmony import */


      var ng_zorro_antd_button__WEBPACK_IMPORTED_MODULE_9__ = __webpack_require__(
      /*! ng-zorro-antd/button */
      "OzZK");
      /* harmony import */


      var ng_zorro_antd_core_wave__WEBPACK_IMPORTED_MODULE_10__ = __webpack_require__(
      /*! ng-zorro-antd/core/wave */
      "RwU8");
      /* harmony import */


      var ng_zorro_antd_alert__WEBPACK_IMPORTED_MODULE_11__ = __webpack_require__(
      /*! ng-zorro-antd/alert */
      "Wfee");

      function LoginComponent_nz_alert_7_Template(rf, ctx) {
        if (rf & 1) {
          _angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵelement"](0, "nz-alert", 11);
        }

        if (rf & 2) {
          var ctx_r0 = _angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵnextContext"]();

          _angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵproperty"]("nzType", "error")("nzMessage", ctx_r0.error)("nzShowIcon", true);
        }
      }

      var LoginComponent = /*#__PURE__*/function () {
        function LoginComponent(store, formBuilder) {
          _classCallCheck(this, LoginComponent);

          this.store = store;
          this.formBuilder = formBuilder;
          this.submitted = false;
          this.error = false;
        }

        _createClass(LoginComponent, [{
          key: "ngOnInit",
          value: function ngOnInit() {
            this.loginForm = this.formBuilder.group({
              email: ['', _angular_forms__WEBPACK_IMPORTED_MODULE_1__["Validators"].required],
              password: ['', _angular_forms__WEBPACK_IMPORTED_MODULE_1__["Validators"].required],
              remember: [false, _angular_forms__WEBPACK_IMPORTED_MODULE_1__["Validators"].required]
            });
            this.isAuthenticating$ = this.store.select(_store__WEBPACK_IMPORTED_MODULE_0__["getIsAuthenticating"]);
          }
        }, {
          key: "f",
          get: function get() {
            if (typeof this.loginForm !== 'undefined') {
              return this.loginForm.controls;
            }
          }
        }, {
          key: "onSubmit",
          value: function onSubmit() {
            this.submitted = true;

            if (this.loginForm.valid) {
              var actionPayload = {
                email: this.f.email.value,
                password: this.f.password.value
              };
              this.store.dispatch(new _store__WEBPACK_IMPORTED_MODULE_0__["Login"](actionPayload));
            }
          }
        }]);

        return LoginComponent;
      }();

      LoginComponent.ɵfac = function LoginComponent_Factory(t) {
        return new (t || LoginComponent)(_angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵdirectiveInject"](_ngrx_store__WEBPACK_IMPORTED_MODULE_3__["Store"]), _angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵdirectiveInject"](_angular_forms__WEBPACK_IMPORTED_MODULE_1__["FormBuilder"]));
      };

      LoginComponent.ɵcmp = _angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵdefineComponent"]({
        type: LoginComponent,
        selectors: [["app-login"]],
        decls: 21,
        vars: 6,
        consts: [[1, "login-wrapper"], ["nz-form", "", "role", "form", 3, "formGroup", "ngSubmit"], [1, "title"], [1, "hint"], [1, "login-group"], ["class", "mb-lg", 3, "nzType", "nzMessage", "nzShowIcon", 4, "ngIf"], ["nzSize", "large", "nzPrefixIcon", "user"], ["nz-input", "", "formControlName", "email", "placeholder", "Email"], ["nzSize", "large", "nzPrefixIcon", "lock"], ["nz-input", "", "type", "password", "formControlName", "password", "placeholder", "Password"], ["nz-button", "", "type", "submit", "nzType", "primary", "nzSize", "large", "nzBlock", "", 3, "nzLoading"], [1, "mb-lg", 3, "nzType", "nzMessage", "nzShowIcon"]],
        template: function LoginComponent_Template(rf, ctx) {
          if (rf & 1) {
            _angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵelementStart"](0, "div", 0);

            _angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵelementStart"](1, "form", 1);

            _angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵlistener"]("ngSubmit", function LoginComponent_Template_form_ngSubmit_1_listener() {
              return ctx.onSubmit();
            });

            _angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵelementStart"](2, "section", 2);

            _angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵtext"](3, " Brandgos ");

            _angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵelementStart"](4, "h5", 3);

            _angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵtext"](5, "Make your logo");

            _angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵelementEnd"]();

            _angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵelementEnd"]();

            _angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵelementStart"](6, "div", 4);

            _angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵtemplate"](7, LoginComponent_nz_alert_7_Template, 1, 3, "nz-alert", 5);

            _angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵelementStart"](8, "nz-form-item");

            _angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵelementStart"](9, "nz-form-control");

            _angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵelementStart"](10, "nz-input-group", 6);

            _angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵelement"](11, "input", 7);

            _angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵelementEnd"]();

            _angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵelementEnd"]();

            _angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵelementEnd"]();

            _angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵelementStart"](12, "nz-form-item");

            _angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵelementStart"](13, "nz-form-control");

            _angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵelementStart"](14, "nz-input-group", 8);

            _angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵelement"](15, "input", 9);

            _angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵelementEnd"]();

            _angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵelementEnd"]();

            _angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵelementEnd"]();

            _angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵelement"](16, "nz-form-item");

            _angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵelementStart"](17, "nz-form-item");

            _angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵelementStart"](18, "button", 10);

            _angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵpipe"](19, "async");

            _angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵtext"](20);

            _angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵelementEnd"]();

            _angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵelementEnd"]();

            _angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵelementEnd"]();

            _angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵelementEnd"]();

            _angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵelementEnd"]();
          }

          if (rf & 2) {
            _angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵadvance"](1);

            _angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵproperty"]("formGroup", ctx.loginForm);

            _angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵadvance"](6);

            _angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵproperty"]("ngIf", ctx.error);

            _angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵadvance"](11);

            _angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵproperty"]("nzLoading", _angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵpipeBind1"](19, 4, ctx.isAuthenticating$));

            _angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵadvance"](2);

            _angular_core__WEBPACK_IMPORTED_MODULE_2__["ɵɵtextInterpolate1"](" ", "Login", " ");
          }
        },
        directives: [_angular_forms__WEBPACK_IMPORTED_MODULE_1__["ɵangular_packages_forms_forms_ba"], _angular_forms__WEBPACK_IMPORTED_MODULE_1__["NgControlStatusGroup"], ng_zorro_antd_form__WEBPACK_IMPORTED_MODULE_4__["NzFormDirective"], _angular_forms__WEBPACK_IMPORTED_MODULE_1__["FormGroupDirective"], _angular_common__WEBPACK_IMPORTED_MODULE_5__["NgIf"], ng_zorro_antd_grid__WEBPACK_IMPORTED_MODULE_6__["NzRowDirective"], ng_zorro_antd_form__WEBPACK_IMPORTED_MODULE_4__["NzFormItemComponent"], ng_zorro_antd_grid__WEBPACK_IMPORTED_MODULE_6__["NzColDirective"], ng_zorro_antd_form__WEBPACK_IMPORTED_MODULE_4__["NzFormControlComponent"], ng_zorro_antd_core_transition_patch__WEBPACK_IMPORTED_MODULE_7__["ɵNzTransitionPatchDirective"], ng_zorro_antd_input__WEBPACK_IMPORTED_MODULE_8__["NzInputGroupComponent"], ng_zorro_antd_input__WEBPACK_IMPORTED_MODULE_8__["NzInputDirective"], _angular_forms__WEBPACK_IMPORTED_MODULE_1__["DefaultValueAccessor"], _angular_forms__WEBPACK_IMPORTED_MODULE_1__["NgControlStatus"], _angular_forms__WEBPACK_IMPORTED_MODULE_1__["FormControlName"], ng_zorro_antd_button__WEBPACK_IMPORTED_MODULE_9__["NzButtonComponent"], ng_zorro_antd_core_wave__WEBPACK_IMPORTED_MODULE_10__["NzWaveDirective"], ng_zorro_antd_alert__WEBPACK_IMPORTED_MODULE_11__["NzAlertComponent"]],
        pipes: [_angular_common__WEBPACK_IMPORTED_MODULE_5__["AsyncPipe"]],
        styles: [".login-wrapper[_ngcontent-%COMP%] {\n  display: flex;\n  height: 100%;\n  background: url(/assets/images/bg.svg);\n  background-size: 100%;\n  background-position: 25.2rem 0;\n  background-repeat: no-repeat;\n}\n\nform[_ngcontent-%COMP%] {\n  background: #fafafa;\n  background: var(--clr-login-background-color, #fafafa);\n  position: relative;\n  display: flex;\n  flex-direction: column;\n  justify-content: center;\n  padding: 1.2rem 3rem;\n  height: auto;\n  min-height: 100vh;\n  width: 25.2rem;\n}\n\n.title[_ngcontent-%COMP%] {\n  font-weight: 400;\n}\n\n.title[_ngcontent-%COMP%]   .welcome[_ngcontent-%COMP%] {\n  line-height: 1.8rem;\n  font-weight: 400;\n  font-size: 1.2rem;\n}\n\n.title[_ngcontent-%COMP%]   .hint[_ngcontent-%COMP%] {\n  color: #000;\n  color: var(--clr-login-title-color, #000);\n  margin-top: 1.5rem;\n  font-size: 1rem;\n  font-weight: 300;\n}\n\n.login-group[_ngcontent-%COMP%] {\n  display: flex;\n  flex-direction: column;\n  padding: 2.4rem 0 0;\n}\n/*# sourceMappingURL=data:application/json;base64,eyJ2ZXJzaW9uIjozLCJzb3VyY2VzIjpbIi4uXFwuLlxcLi5cXC4uXFxsb2dpbi5jb21wb25lbnQuc2NzcyJdLCJuYW1lcyI6W10sIm1hcHBpbmdzIjoiQUFBQTtFQUVFLGFBQUE7RUFDQSxZQUFBO0VBQ0Esc0NBQUE7RUFDQSxxQkFBQTtFQUNBLDhCQUFBO0VBQ0EsNEJBQUE7QUFDRjs7QUFDQTtFQUNFLG1CQUFBO0VBQ0Esc0RBQUE7RUFDQSxrQkFBQTtFQUVBLGFBQUE7RUFHQSxzQkFBQTtFQUVBLHVCQUFBO0VBQ0Esb0JBQUE7RUFDQSxZQUFBO0VBQ0EsaUJBQUE7RUFDQSxjQUFBO0FBRUY7O0FBQUE7RUFDRSxnQkFBQTtBQUdGOztBQUZFO0VBQ0UsbUJBQUE7RUFDQSxnQkFBQTtFQUNBLGlCQUFBO0FBSUo7O0FBRkU7RUFDRSxXQUFBO0VBQ0EseUNBQUE7RUFDQSxrQkFBQTtFQUNBLGVBQUE7RUFDQSxnQkFBQTtBQUlKOztBQURBO0VBRUUsYUFBQTtFQUdBLHNCQUFBO0VBQ0EsbUJBQUE7QUFJRiIsImZpbGUiOiJsb2dpbi5jb21wb25lbnQuc2NzcyIsInNvdXJjZXNDb250ZW50IjpbIi5sb2dpbi13cmFwcGVyIHtcclxuICBkaXNwbGF5OiAtd2Via2l0LWJveDtcclxuICBkaXNwbGF5OiBmbGV4O1xyXG4gIGhlaWdodDogMTAwJTtcclxuICBiYWNrZ3JvdW5kOiB1cmwoL2Fzc2V0cy9pbWFnZXMvYmcuc3ZnKTtcclxuICBiYWNrZ3JvdW5kLXNpemU6IDEwMCU7XHJcbiAgYmFja2dyb3VuZC1wb3NpdGlvbjogMjUuMnJlbSAwO1xyXG4gIGJhY2tncm91bmQtcmVwZWF0OiBuby1yZXBlYXQ7XHJcbn1cclxuZm9ybSB7XHJcbiAgYmFja2dyb3VuZDogI2ZhZmFmYTtcclxuICBiYWNrZ3JvdW5kOiB2YXIoLS1jbHItbG9naW4tYmFja2dyb3VuZC1jb2xvciwgI2ZhZmFmYSk7XHJcbiAgcG9zaXRpb246IHJlbGF0aXZlO1xyXG4gIGRpc3BsYXk6IC13ZWJraXQtYm94O1xyXG4gIGRpc3BsYXk6IGZsZXg7XHJcbiAgLXdlYmtpdC1ib3gtb3JpZW50OiB2ZXJ0aWNhbDtcclxuICAtd2Via2l0LWJveC1kaXJlY3Rpb246IG5vcm1hbDtcclxuICBmbGV4LWRpcmVjdGlvbjogY29sdW1uO1xyXG4gIC13ZWJraXQtYm94LXBhY2s6IGNlbnRlcjtcclxuICBqdXN0aWZ5LWNvbnRlbnQ6IGNlbnRlcjtcclxuICBwYWRkaW5nOiAxLjJyZW0gM3JlbTtcclxuICBoZWlnaHQ6IGF1dG87XHJcbiAgbWluLWhlaWdodDogMTAwdmg7XHJcbiAgd2lkdGg6IDI1LjJyZW07XHJcbn1cclxuLnRpdGxlIHtcclxuICBmb250LXdlaWdodDogNDAwO1xyXG4gIC53ZWxjb21lIHtcclxuICAgIGxpbmUtaGVpZ2h0OiAxLjhyZW07XHJcbiAgICBmb250LXdlaWdodDogNDAwO1xyXG4gICAgZm9udC1zaXplOiAxLjJyZW07XHJcbiAgfVxyXG4gIC5oaW50IHtcclxuICAgIGNvbG9yOiAjMDAwO1xyXG4gICAgY29sb3I6IHZhcigtLWNsci1sb2dpbi10aXRsZS1jb2xvciwgIzAwMCk7XHJcbiAgICBtYXJnaW4tdG9wOiAxLjVyZW07XHJcbiAgICBmb250LXNpemU6IDFyZW07XHJcbiAgICBmb250LXdlaWdodDogMzAwO1xyXG4gIH1cclxufVxyXG4ubG9naW4tZ3JvdXAge1xyXG4gIGRpc3BsYXk6IC13ZWJraXQtYm94O1xyXG4gIGRpc3BsYXk6IGZsZXg7XHJcbiAgLXdlYmtpdC1ib3gtb3JpZW50OiB2ZXJ0aWNhbDtcclxuICAtd2Via2l0LWJveC1kaXJlY3Rpb246IG5vcm1hbDtcclxuICBmbGV4LWRpcmVjdGlvbjogY29sdW1uO1xyXG4gIHBhZGRpbmc6IDIuNHJlbSAwIDA7XHJcbn1cclxuIl19 */"]
      });
      /***/
    },

    /***/
    "qkvP": function qkvP(module, __webpack_exports__, __webpack_require__) {
      "use strict";

      __webpack_require__.r(__webpack_exports__);
      /* harmony export (binding) */


      __webpack_require__.d(__webpack_exports__, "initialState", function () {
        return initialState;
      });
      /* harmony export (binding) */


      __webpack_require__.d(__webpack_exports__, "reducer", function () {
        return reducer;
      });
      /* harmony export (binding) */


      __webpack_require__.d(__webpack_exports__, "selectAuthState", function () {
        return selectAuthState;
      });
      /* harmony import */


      var _auth_actions__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(
      /*! ./auth.actions */
      "/WaZ");
      /* harmony import */


      var _ngrx_store__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(
      /*! @ngrx/store */
      "l7P3");

      var initialState = {
        user: null,
        errorMessage: null,
        isAuthenticating: false,
        isAuthenticated: false
      };

      function reducer() {
        var state = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : initialState;
        var action = arguments.length > 1 ? arguments[1] : undefined;

        switch (action.type) {
          case _auth_actions__WEBPACK_IMPORTED_MODULE_0__["AuthActionTypes"].LOGIN:
            return Object.assign(Object.assign({}, state), {
              isAuthenticating: true,
              errorMessage: null,
              isAuthenticated: false
            });

          case _auth_actions__WEBPACK_IMPORTED_MODULE_0__["AuthActionTypes"].LOGIN_SUCCESS:
            return Object.assign(Object.assign({}, state), {
              errorMessage: null,
              isAuthenticated: true,
              isAuthenticating: false,
              user: {
                accessToken: action.payload.accessToken,
                id: action.payload.id,
                email: action.payload.email,
                username: action.payload.username
              }
            });

          case _auth_actions__WEBPACK_IMPORTED_MODULE_0__["AuthActionTypes"].LOGIN_FAILURE:
            return Object.assign(Object.assign({}, state), {
              errorMessage: action.payload.error,
              isAuthenticating: false
            });

          default:
            return state;
        }
      }

      var selectAuthState = Object(_ngrx_store__WEBPACK_IMPORTED_MODULE_1__["createFeatureSelector"])('authStore');
      /***/
    }
  }]);
})();
//# sourceMappingURL=auth-auth-module-es5.js.map