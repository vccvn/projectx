(function () {
  function _slicedToArray(arr, i) { return _arrayWithHoles(arr) || _iterableToArrayLimit(arr, i) || _unsupportedIterableToArray(arr, i) || _nonIterableRest(); }

  function _nonIterableRest() { throw new TypeError("Invalid attempt to destructure non-iterable instance.\nIn order to be iterable, non-array objects must have a [Symbol.iterator]() method."); }

  function _iterableToArrayLimit(arr, i) { var _i = arr == null ? null : typeof Symbol !== "undefined" && arr[Symbol.iterator] || arr["@@iterator"]; if (_i == null) return; var _arr = []; var _n = true; var _d = false; var _s, _e; try { for (_i = _i.call(arr); !(_n = (_s = _i.next()).done); _n = true) { _arr.push(_s.value); if (i && _arr.length === i) break; } } catch (err) { _d = true; _e = err; } finally { try { if (!_n && _i["return"] != null) _i["return"](); } finally { if (_d) throw _e; } } return _arr; }

  function _arrayWithHoles(arr) { if (Array.isArray(arr)) return arr; }

  function _toConsumableArray(arr) { return _arrayWithoutHoles(arr) || _iterableToArray(arr) || _unsupportedIterableToArray(arr) || _nonIterableSpread(); }

  function _nonIterableSpread() { throw new TypeError("Invalid attempt to spread non-iterable instance.\nIn order to be iterable, non-array objects must have a [Symbol.iterator]() method."); }

  function _unsupportedIterableToArray(o, minLen) { if (!o) return; if (typeof o === "string") return _arrayLikeToArray(o, minLen); var n = Object.prototype.toString.call(o).slice(8, -1); if (n === "Object" && o.constructor) n = o.constructor.name; if (n === "Map" || n === "Set") return Array.from(o); if (n === "Arguments" || /^(?:Ui|I)nt(?:8|16|32)(?:Clamped)?Array$/.test(n)) return _arrayLikeToArray(o, minLen); }

  function _iterableToArray(iter) { if (typeof Symbol !== "undefined" && iter[Symbol.iterator] != null || iter["@@iterator"] != null) return Array.from(iter); }

  function _arrayWithoutHoles(arr) { if (Array.isArray(arr)) return _arrayLikeToArray(arr); }

  function _arrayLikeToArray(arr, len) { if (len == null || len > arr.length) len = arr.length; for (var i = 0, arr2 = new Array(len); i < len; i++) { arr2[i] = arr[i]; } return arr2; }

  function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }

  function _defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } }

  function _createClass(Constructor, protoProps, staticProps) { if (protoProps) _defineProperties(Constructor.prototype, protoProps); if (staticProps) _defineProperties(Constructor, staticProps); return Constructor; }

  (window["webpackJsonp"] = window["webpackJsonp"] || []).push([["default~item-page-item-module~project-page-project-module~template-page-template-module"], {
    /***/
    "5+WD": function WD(module, __webpack_exports__, __webpack_require__) {
      "use strict";

      __webpack_require__.r(__webpack_exports__);
      /* harmony export (binding) */


      __webpack_require__.d(__webpack_exports__, "CDK_DRAG_CONFIG", function () {
        return CDK_DRAG_CONFIG;
      });
      /* harmony export (binding) */


      __webpack_require__.d(__webpack_exports__, "CDK_DRAG_HANDLE", function () {
        return CDK_DRAG_HANDLE;
      });
      /* harmony export (binding) */


      __webpack_require__.d(__webpack_exports__, "CDK_DRAG_PARENT", function () {
        return CDK_DRAG_PARENT;
      });
      /* harmony export (binding) */


      __webpack_require__.d(__webpack_exports__, "CDK_DRAG_PLACEHOLDER", function () {
        return CDK_DRAG_PLACEHOLDER;
      });
      /* harmony export (binding) */


      __webpack_require__.d(__webpack_exports__, "CDK_DRAG_PREVIEW", function () {
        return CDK_DRAG_PREVIEW;
      });
      /* harmony export (binding) */


      __webpack_require__.d(__webpack_exports__, "CDK_DROP_LIST", function () {
        return CDK_DROP_LIST;
      });
      /* harmony export (binding) */


      __webpack_require__.d(__webpack_exports__, "CDK_DROP_LIST_GROUP", function () {
        return CDK_DROP_LIST_GROUP;
      });
      /* harmony export (binding) */


      __webpack_require__.d(__webpack_exports__, "CdkDrag", function () {
        return CdkDrag;
      });
      /* harmony export (binding) */


      __webpack_require__.d(__webpack_exports__, "CdkDragHandle", function () {
        return CdkDragHandle;
      });
      /* harmony export (binding) */


      __webpack_require__.d(__webpack_exports__, "CdkDragPlaceholder", function () {
        return CdkDragPlaceholder;
      });
      /* harmony export (binding) */


      __webpack_require__.d(__webpack_exports__, "CdkDragPreview", function () {
        return CdkDragPreview;
      });
      /* harmony export (binding) */


      __webpack_require__.d(__webpack_exports__, "CdkDropList", function () {
        return CdkDropList;
      });
      /* harmony export (binding) */


      __webpack_require__.d(__webpack_exports__, "CdkDropListGroup", function () {
        return CdkDropListGroup;
      });
      /* harmony export (binding) */


      __webpack_require__.d(__webpack_exports__, "DragDrop", function () {
        return DragDrop;
      });
      /* harmony export (binding) */


      __webpack_require__.d(__webpack_exports__, "DragDropModule", function () {
        return DragDropModule;
      });
      /* harmony export (binding) */


      __webpack_require__.d(__webpack_exports__, "DragDropRegistry", function () {
        return DragDropRegistry;
      });
      /* harmony export (binding) */


      __webpack_require__.d(__webpack_exports__, "DragRef", function () {
        return DragRef;
      });
      /* harmony export (binding) */


      __webpack_require__.d(__webpack_exports__, "DropListRef", function () {
        return DropListRef;
      });
      /* harmony export (binding) */


      __webpack_require__.d(__webpack_exports__, "copyArrayItem", function () {
        return copyArrayItem;
      });
      /* harmony export (binding) */


      __webpack_require__.d(__webpack_exports__, "moveItemInArray", function () {
        return moveItemInArray;
      });
      /* harmony export (binding) */


      __webpack_require__.d(__webpack_exports__, "transferArrayItem", function () {
        return transferArrayItem;
      });
      /* harmony import */


      var _angular_core__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(
      /*! @angular/core */
      "fXoL");
      /* harmony import */


      var _angular_common__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(
      /*! @angular/common */
      "ofXK");
      /* harmony import */


      var _angular_cdk_scrolling__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(
      /*! @angular/cdk/scrolling */
      "vxfF");
      /* harmony import */


      var _angular_cdk_platform__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(
      /*! @angular/cdk/platform */
      "nLfN");
      /* harmony import */


      var _angular_cdk_coercion__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(
      /*! @angular/cdk/coercion */
      "8LU1");
      /* harmony import */


      var rxjs__WEBPACK_IMPORTED_MODULE_5__ = __webpack_require__(
      /*! rxjs */
      "qCKp");
      /* harmony import */


      var rxjs_operators__WEBPACK_IMPORTED_MODULE_6__ = __webpack_require__(
      /*! rxjs/operators */
      "kU1M");
      /* harmony import */


      var _angular_cdk_bidi__WEBPACK_IMPORTED_MODULE_7__ = __webpack_require__(
      /*! @angular/cdk/bidi */
      "cH1L");
      /**
       * @license
       * Copyright Google LLC All Rights Reserved.
       *
       * Use of this source code is governed by an MIT-style license that can be
       * found in the LICENSE file at https://angular.io/license
       */

      /**
       * Shallow-extends a stylesheet object with another stylesheet object.
       * @docs-private
       */


      function extendStyles(dest, source) {
        for (var key in source) {
          if (source.hasOwnProperty(key)) {
            dest[key] = source[key];
          }
        }

        return dest;
      }
      /**
       * Toggles whether the native drag interactions should be enabled for an element.
       * @param element Element on which to toggle the drag interactions.
       * @param enable Whether the drag interactions should be enabled.
       * @docs-private
       */


      function toggleNativeDragInteractions(element, enable) {
        var userSelect = enable ? '' : 'none';
        extendStyles(element.style, {
          touchAction: enable ? '' : 'none',
          webkitUserDrag: enable ? '' : 'none',
          webkitTapHighlightColor: enable ? '' : 'transparent',
          userSelect: userSelect,
          msUserSelect: userSelect,
          webkitUserSelect: userSelect,
          MozUserSelect: userSelect
        });
      }
      /**
       * Toggles whether an element is visible while preserving its dimensions.
       * @param element Element whose visibility to toggle
       * @param enable Whether the element should be visible.
       * @docs-private
       */


      function toggleVisibility(element, enable) {
        var styles = element.style;
        styles.position = enable ? '' : 'fixed';
        styles.top = styles.opacity = enable ? '' : '0';
        styles.left = enable ? '' : '-999em';
      }
      /**
       * @license
       * Copyright Google LLC All Rights Reserved.
       *
       * Use of this source code is governed by an MIT-style license that can be
       * found in the LICENSE file at https://angular.io/license
       */

      /** Parses a CSS time value to milliseconds. */


      function parseCssTimeUnitsToMs(value) {
        // Some browsers will return it in seconds, whereas others will return milliseconds.
        var multiplier = value.toLowerCase().indexOf('ms') > -1 ? 1 : 1000;
        return parseFloat(value) * multiplier;
      }
      /** Gets the transform transition duration, including the delay, of an element in milliseconds. */


      function getTransformTransitionDurationInMs(element) {
        var computedStyle = getComputedStyle(element);
        var transitionedProperties = parseCssPropertyValue(computedStyle, 'transition-property');
        var property = transitionedProperties.find(function (prop) {
          return prop === 'transform' || prop === 'all';
        }); // If there's no transition for `all` or `transform`, we shouldn't do anything.

        if (!property) {
          return 0;
        } // Get the index of the property that we're interested in and match
        // it up to the same index in `transition-delay` and `transition-duration`.


        var propertyIndex = transitionedProperties.indexOf(property);
        var rawDurations = parseCssPropertyValue(computedStyle, 'transition-duration');
        var rawDelays = parseCssPropertyValue(computedStyle, 'transition-delay');
        return parseCssTimeUnitsToMs(rawDurations[propertyIndex]) + parseCssTimeUnitsToMs(rawDelays[propertyIndex]);
      }
      /** Parses out multiple values from a computed style into an array. */


      function parseCssPropertyValue(computedStyle, name) {
        var value = computedStyle.getPropertyValue(name);
        return value.split(',').map(function (part) {
          return part.trim();
        });
      }
      /**
       * @license
       * Copyright Google LLC All Rights Reserved.
       *
       * Use of this source code is governed by an MIT-style license that can be
       * found in the LICENSE file at https://angular.io/license
       */

      /** Gets a mutable version of an element's bounding `ClientRect`. */


      function getMutableClientRect(element) {
        var clientRect = element.getBoundingClientRect(); // We need to clone the `clientRect` here, because all the values on it are readonly
        // and we need to be able to update them. Also we can't use a spread here, because
        // the values on a `ClientRect` aren't own properties. See:
        // https://developer.mozilla.org/en-US/docs/Web/API/Element/getBoundingClientRect#Notes

        return {
          top: clientRect.top,
          right: clientRect.right,
          bottom: clientRect.bottom,
          left: clientRect.left,
          width: clientRect.width,
          height: clientRect.height
        };
      }
      /**
       * Checks whether some coordinates are within a `ClientRect`.
       * @param clientRect ClientRect that is being checked.
       * @param x Coordinates along the X axis.
       * @param y Coordinates along the Y axis.
       */


      function isInsideClientRect(clientRect, x, y) {
        var top = clientRect.top,
            bottom = clientRect.bottom,
            left = clientRect.left,
            right = clientRect.right;
        return y >= top && y <= bottom && x >= left && x <= right;
      }
      /**
       * Updates the top/left positions of a `ClientRect`, as well as their bottom/right counterparts.
       * @param clientRect `ClientRect` that should be updated.
       * @param top Amount to add to the `top` position.
       * @param left Amount to add to the `left` position.
       */


      function adjustClientRect(clientRect, top, left) {
        clientRect.top += top;
        clientRect.bottom = clientRect.top + clientRect.height;
        clientRect.left += left;
        clientRect.right = clientRect.left + clientRect.width;
      }
      /**
       * Checks whether the pointer coordinates are close to a ClientRect.
       * @param rect ClientRect to check against.
       * @param threshold Threshold around the ClientRect.
       * @param pointerX Coordinates along the X axis.
       * @param pointerY Coordinates along the Y axis.
       */


      function isPointerNearClientRect(rect, threshold, pointerX, pointerY) {
        var top = rect.top,
            right = rect.right,
            bottom = rect.bottom,
            left = rect.left,
            width = rect.width,
            height = rect.height;
        var xThreshold = width * threshold;
        var yThreshold = height * threshold;
        return pointerY > top - yThreshold && pointerY < bottom + yThreshold && pointerX > left - xThreshold && pointerX < right + xThreshold;
      }
      /**
       * @license
       * Copyright Google LLC All Rights Reserved.
       *
       * Use of this source code is governed by an MIT-style license that can be
       * found in the LICENSE file at https://angular.io/license
       */

      /** Keeps track of the scroll position and dimensions of the parents of an element. */


      var ParentPositionTracker = /*#__PURE__*/function () {
        function ParentPositionTracker(_document, _viewportRuler) {
          _classCallCheck(this, ParentPositionTracker);

          this._document = _document;
          this._viewportRuler = _viewportRuler;
          /** Cached positions of the scrollable parent elements. */

          this.positions = new Map();
        }
        /** Clears the cached positions. */


        _createClass(ParentPositionTracker, [{
          key: "clear",
          value: function clear() {
            this.positions.clear();
          }
          /** Caches the positions. Should be called at the beginning of a drag sequence. */

        }, {
          key: "cache",
          value: function cache(elements) {
            var _this = this;

            this.clear();
            this.positions.set(this._document, {
              scrollPosition: this._viewportRuler.getViewportScrollPosition()
            });
            elements.forEach(function (element) {
              _this.positions.set(element, {
                scrollPosition: {
                  top: element.scrollTop,
                  left: element.scrollLeft
                },
                clientRect: getMutableClientRect(element)
              });
            });
          }
          /** Handles scrolling while a drag is taking place. */

        }, {
          key: "handleScroll",
          value: function handleScroll(event) {
            var target = event.target;
            var cachedPosition = this.positions.get(target);

            if (!cachedPosition) {
              return null;
            } // Used when figuring out whether an element is inside the scroll parent. If the scrolled
            // parent is the `document`, we use the `documentElement`, because IE doesn't support
            // `contains` on the `document`.


            var scrolledParentNode = target === this._document ? target.documentElement : target;
            var scrollPosition = cachedPosition.scrollPosition;
            var newTop;
            var newLeft;

            if (target === this._document) {
              var viewportScrollPosition = this._viewportRuler.getViewportScrollPosition();

              newTop = viewportScrollPosition.top;
              newLeft = viewportScrollPosition.left;
            } else {
              newTop = target.scrollTop;
              newLeft = target.scrollLeft;
            }

            var topDifference = scrollPosition.top - newTop;
            var leftDifference = scrollPosition.left - newLeft; // Go through and update the cached positions of the scroll
            // parents that are inside the element that was scrolled.

            this.positions.forEach(function (position, node) {
              if (position.clientRect && target !== node && scrolledParentNode.contains(node)) {
                adjustClientRect(position.clientRect, topDifference, leftDifference);
              }
            });
            scrollPosition.top = newTop;
            scrollPosition.left = newLeft;
            return {
              top: topDifference,
              left: leftDifference
            };
          }
        }]);

        return ParentPositionTracker;
      }();
      /**
       * @license
       * Copyright Google LLC All Rights Reserved.
       *
       * Use of this source code is governed by an MIT-style license that can be
       * found in the LICENSE file at https://angular.io/license
       */

      /** Creates a deep clone of an element. */


      function deepCloneNode(node) {
        var clone = node.cloneNode(true);
        var descendantsWithId = clone.querySelectorAll('[id]');
        var nodeName = node.nodeName.toLowerCase(); // Remove the `id` to avoid having multiple elements with the same id on the page.

        clone.removeAttribute('id');

        for (var i = 0; i < descendantsWithId.length; i++) {
          descendantsWithId[i].removeAttribute('id');
        }

        if (nodeName === 'canvas') {
          transferCanvasData(node, clone);
        } else if (nodeName === 'input' || nodeName === 'select' || nodeName === 'textarea') {
          transferInputData(node, clone);
        }

        transferData('canvas', node, clone, transferCanvasData);
        transferData('input, textarea, select', node, clone, transferInputData);
        return clone;
      }
      /** Matches elements between an element and its clone and allows for their data to be cloned. */


      function transferData(selector, node, clone, callback) {
        var descendantElements = node.querySelectorAll(selector);

        if (descendantElements.length) {
          var cloneElements = clone.querySelectorAll(selector);

          for (var i = 0; i < descendantElements.length; i++) {
            callback(descendantElements[i], cloneElements[i]);
          }
        }
      } // Counter for unique cloned radio button names.


      var cloneUniqueId = 0;
      /** Transfers the data of one input element to another. */

      function transferInputData(source, clone) {
        // Browsers throw an error when assigning the value of a file input programmatically.
        if (clone.type !== 'file') {
          clone.value = source.value;
        } // Radio button `name` attributes must be unique for radio button groups
        // otherwise original radio buttons can lose their checked state
        // once the clone is inserted in the DOM.


        if (clone.type === 'radio' && clone.name) {
          clone.name = "mat-clone-".concat(clone.name, "-").concat(cloneUniqueId++);
        }
      }
      /** Transfers the data of one canvas element to another. */


      function transferCanvasData(source, clone) {
        var context = clone.getContext('2d');

        if (context) {
          // In some cases `drawImage` can throw (e.g. if the canvas size is 0x0).
          // We can't do much about it so just ignore the error.
          try {
            context.drawImage(source, 0, 0);
          } catch (_a) {}
        }
      }
      /**
       * @license
       * Copyright Google LLC All Rights Reserved.
       *
       * Use of this source code is governed by an MIT-style license that can be
       * found in the LICENSE file at https://angular.io/license
       */

      /** Options that can be used to bind a passive event listener. */


      var passiveEventListenerOptions = Object(_angular_cdk_platform__WEBPACK_IMPORTED_MODULE_3__["normalizePassiveListenerOptions"])({
        passive: true
      });
      /** Options that can be used to bind an active event listener. */

      var activeEventListenerOptions = Object(_angular_cdk_platform__WEBPACK_IMPORTED_MODULE_3__["normalizePassiveListenerOptions"])({
        passive: false
      });
      /**
       * Time in milliseconds for which to ignore mouse events, after
       * receiving a touch event. Used to avoid doing double work for
       * touch devices where the browser fires fake mouse events, in
       * addition to touch events.
       */

      var MOUSE_EVENT_IGNORE_TIME = 800;
      /**
       * Reference to a draggable item. Used to manipulate or dispose of the item.
       */

      var DragRef = /*#__PURE__*/function () {
        function DragRef(element, _config, _document, _ngZone, _viewportRuler, _dragDropRegistry) {
          var _this2 = this;

          _classCallCheck(this, DragRef);

          this._config = _config;
          this._document = _document;
          this._ngZone = _ngZone;
          this._viewportRuler = _viewportRuler;
          this._dragDropRegistry = _dragDropRegistry;
          /**
           * CSS `transform` applied to the element when it isn't being dragged. We need a
           * passive transform in order for the dragged element to retain its new position
           * after the user has stopped dragging and because we need to know the relative
           * position in case they start dragging again. This corresponds to `element.style.transform`.
           */

          this._passiveTransform = {
            x: 0,
            y: 0
          };
          /** CSS `transform` that is applied to the element while it's being dragged. */

          this._activeTransform = {
            x: 0,
            y: 0
          };
          /** Emits when the item is being moved. */

          this._moveEvents = new rxjs__WEBPACK_IMPORTED_MODULE_5__["Subject"]();
          /** Subscription to pointer movement events. */

          this._pointerMoveSubscription = rxjs__WEBPACK_IMPORTED_MODULE_5__["Subscription"].EMPTY;
          /** Subscription to the event that is dispatched when the user lifts their pointer. */

          this._pointerUpSubscription = rxjs__WEBPACK_IMPORTED_MODULE_5__["Subscription"].EMPTY;
          /** Subscription to the viewport being scrolled. */

          this._scrollSubscription = rxjs__WEBPACK_IMPORTED_MODULE_5__["Subscription"].EMPTY;
          /** Subscription to the viewport being resized. */

          this._resizeSubscription = rxjs__WEBPACK_IMPORTED_MODULE_5__["Subscription"].EMPTY;
          /** Cached reference to the boundary element. */

          this._boundaryElement = null;
          /** Whether the native dragging interactions have been enabled on the root element. */

          this._nativeInteractionsEnabled = true;
          /** Elements that can be used to drag the draggable item. */

          this._handles = [];
          /** Registered handles that are currently disabled. */

          this._disabledHandles = new Set();
          /** Layout direction of the item. */

          this._direction = 'ltr';
          /**
           * Amount of milliseconds to wait after the user has put their
           * pointer down before starting to drag the element.
           */

          this.dragStartDelay = 0;
          this._disabled = false;
          /** Emits as the drag sequence is being prepared. */

          this.beforeStarted = new rxjs__WEBPACK_IMPORTED_MODULE_5__["Subject"]();
          /** Emits when the user starts dragging the item. */

          this.started = new rxjs__WEBPACK_IMPORTED_MODULE_5__["Subject"]();
          /** Emits when the user has released a drag item, before any animations have started. */

          this.released = new rxjs__WEBPACK_IMPORTED_MODULE_5__["Subject"]();
          /** Emits when the user stops dragging an item in the container. */

          this.ended = new rxjs__WEBPACK_IMPORTED_MODULE_5__["Subject"]();
          /** Emits when the user has moved the item into a new container. */

          this.entered = new rxjs__WEBPACK_IMPORTED_MODULE_5__["Subject"]();
          /** Emits when the user removes the item its container by dragging it into another container. */

          this.exited = new rxjs__WEBPACK_IMPORTED_MODULE_5__["Subject"]();
          /** Emits when the user drops the item inside a container. */

          this.dropped = new rxjs__WEBPACK_IMPORTED_MODULE_5__["Subject"]();
          /**
           * Emits as the user is dragging the item. Use with caution,
           * because this event will fire for every pixel that the user has dragged.
           */

          this.moved = this._moveEvents;
          /** Handler for the `mousedown`/`touchstart` events. */

          this._pointerDown = function (event) {
            _this2.beforeStarted.next(); // Delegate the event based on whether it started from a handle or the element itself.


            if (_this2._handles.length) {
              var targetHandle = _this2._handles.find(function (handle) {
                var target = event.target;
                return !!target && (target === handle || handle.contains(target));
              });

              if (targetHandle && !_this2._disabledHandles.has(targetHandle) && !_this2.disabled) {
                _this2._initializeDragSequence(targetHandle, event);
              }
            } else if (!_this2.disabled) {
              _this2._initializeDragSequence(_this2._rootElement, event);
            }
          };
          /** Handler that is invoked when the user moves their pointer after they've initiated a drag. */


          this._pointerMove = function (event) {
            var pointerPosition = _this2._getPointerPositionOnPage(event);

            if (!_this2._hasStartedDragging) {
              var distanceX = Math.abs(pointerPosition.x - _this2._pickupPositionOnPage.x);
              var distanceY = Math.abs(pointerPosition.y - _this2._pickupPositionOnPage.y);
              var isOverThreshold = distanceX + distanceY >= _this2._config.dragStartThreshold; // Only start dragging after the user has moved more than the minimum distance in either
              // direction. Note that this is preferrable over doing something like `skip(minimumDistance)`
              // in the `pointerMove` subscription, because we're not guaranteed to have one move event
              // per pixel of movement (e.g. if the user moves their pointer quickly).

              if (isOverThreshold) {
                var isDelayElapsed = Date.now() >= _this2._dragStartTime + _this2._getDragStartDelay(event);

                var container = _this2._dropContainer;

                if (!isDelayElapsed) {
                  _this2._endDragSequence(event);

                  return;
                } // Prevent other drag sequences from starting while something in the container is still
                // being dragged. This can happen while we're waiting for the drop animation to finish
                // and can cause errors, because some elements might still be moving around.


                if (!container || !container.isDragging() && !container.isReceiving()) {
                  // Prevent the default action as soon as the dragging sequence is considered as
                  // "started" since waiting for the next event can allow the device to begin scrolling.
                  event.preventDefault();
                  _this2._hasStartedDragging = true;

                  _this2._ngZone.run(function () {
                    return _this2._startDragSequence(event);
                  });
                }
              }

              return;
            } // We only need the preview dimensions if we have a boundary element.


            if (_this2._boundaryElement) {
              // Cache the preview element rect if we haven't cached it already or if
              // we cached it too early before the element dimensions were computed.
              if (!_this2._previewRect || !_this2._previewRect.width && !_this2._previewRect.height) {
                _this2._previewRect = (_this2._preview || _this2._rootElement).getBoundingClientRect();
              }
            } // We prevent the default action down here so that we know that dragging has started. This is
            // important for touch devices where doing this too early can unnecessarily block scrolling,
            // if there's a dragging delay.


            event.preventDefault();

            var constrainedPointerPosition = _this2._getConstrainedPointerPosition(pointerPosition);

            _this2._hasMoved = true;
            _this2._lastKnownPointerPosition = pointerPosition;

            _this2._updatePointerDirectionDelta(constrainedPointerPosition);

            if (_this2._dropContainer) {
              _this2._updateActiveDropContainer(constrainedPointerPosition, pointerPosition);
            } else {
              var activeTransform = _this2._activeTransform;
              activeTransform.x = constrainedPointerPosition.x - _this2._pickupPositionOnPage.x + _this2._passiveTransform.x;
              activeTransform.y = constrainedPointerPosition.y - _this2._pickupPositionOnPage.y + _this2._passiveTransform.y;

              _this2._applyRootElementTransform(activeTransform.x, activeTransform.y); // Apply transform as attribute if dragging and svg element to work for IE


              if (typeof SVGElement !== 'undefined' && _this2._rootElement instanceof SVGElement) {
                var appliedTransform = "translate(".concat(activeTransform.x, " ").concat(activeTransform.y, ")");

                _this2._rootElement.setAttribute('transform', appliedTransform);
              }
            } // Since this event gets fired for every pixel while dragging, we only
            // want to fire it if the consumer opted into it. Also we have to
            // re-enter the zone because we run all of the events on the outside.


            if (_this2._moveEvents.observers.length) {
              _this2._ngZone.run(function () {
                _this2._moveEvents.next({
                  source: _this2,
                  pointerPosition: constrainedPointerPosition,
                  event: event,
                  distance: _this2._getDragDistance(constrainedPointerPosition),
                  delta: _this2._pointerDirectionDelta
                });
              });
            }
          };
          /** Handler that is invoked when the user lifts their pointer up, after initiating a drag. */


          this._pointerUp = function (event) {
            _this2._endDragSequence(event);
          };

          this.withRootElement(element).withParent(_config.parentDragRef || null);
          this._parentPositions = new ParentPositionTracker(_document, _viewportRuler);

          _dragDropRegistry.registerDragItem(this);
        }
        /** Whether starting to drag this element is disabled. */


        _createClass(DragRef, [{
          key: "disabled",
          get: function get() {
            return this._disabled || !!(this._dropContainer && this._dropContainer.disabled);
          },
          set: function set(value) {
            var newValue = Object(_angular_cdk_coercion__WEBPACK_IMPORTED_MODULE_4__["coerceBooleanProperty"])(value);

            if (newValue !== this._disabled) {
              this._disabled = newValue;

              this._toggleNativeDragInteractions();

              this._handles.forEach(function (handle) {
                return toggleNativeDragInteractions(handle, newValue);
              });
            }
          }
          /**
           * Returns the element that is being used as a placeholder
           * while the current element is being dragged.
           */

        }, {
          key: "getPlaceholderElement",
          value: function getPlaceholderElement() {
            return this._placeholder;
          }
          /** Returns the root draggable element. */

        }, {
          key: "getRootElement",
          value: function getRootElement() {
            return this._rootElement;
          }
          /**
           * Gets the currently-visible element that represents the drag item.
           * While dragging this is the placeholder, otherwise it's the root element.
           */

        }, {
          key: "getVisibleElement",
          value: function getVisibleElement() {
            return this.isDragging() ? this.getPlaceholderElement() : this.getRootElement();
          }
          /** Registers the handles that can be used to drag the element. */

        }, {
          key: "withHandles",
          value: function withHandles(handles) {
            var _this3 = this;

            this._handles = handles.map(function (handle) {
              return Object(_angular_cdk_coercion__WEBPACK_IMPORTED_MODULE_4__["coerceElement"])(handle);
            });

            this._handles.forEach(function (handle) {
              return toggleNativeDragInteractions(handle, _this3.disabled);
            });

            this._toggleNativeDragInteractions(); // Delete any lingering disabled handles that may have been destroyed. Note that we re-create
            // the set, rather than iterate over it and filter out the destroyed handles, because while
            // the ES spec allows for sets to be modified while they're being iterated over, some polyfills
            // use an array internally which may throw an error.


            var disabledHandles = new Set();

            this._disabledHandles.forEach(function (handle) {
              if (_this3._handles.indexOf(handle) > -1) {
                disabledHandles.add(handle);
              }
            });

            this._disabledHandles = disabledHandles;
            return this;
          }
          /**
           * Registers the template that should be used for the drag preview.
           * @param template Template that from which to stamp out the preview.
           */

        }, {
          key: "withPreviewTemplate",
          value: function withPreviewTemplate(template) {
            this._previewTemplate = template;
            return this;
          }
          /**
           * Registers the template that should be used for the drag placeholder.
           * @param template Template that from which to stamp out the placeholder.
           */

        }, {
          key: "withPlaceholderTemplate",
          value: function withPlaceholderTemplate(template) {
            this._placeholderTemplate = template;
            return this;
          }
          /**
           * Sets an alternate drag root element. The root element is the element that will be moved as
           * the user is dragging. Passing an alternate root element is useful when trying to enable
           * dragging on an element that you might not have access to.
           */

        }, {
          key: "withRootElement",
          value: function withRootElement(rootElement) {
            var _this4 = this;

            var element = Object(_angular_cdk_coercion__WEBPACK_IMPORTED_MODULE_4__["coerceElement"])(rootElement);

            if (element !== this._rootElement) {
              if (this._rootElement) {
                this._removeRootElementListeners(this._rootElement);
              }

              this._ngZone.runOutsideAngular(function () {
                element.addEventListener('mousedown', _this4._pointerDown, activeEventListenerOptions);
                element.addEventListener('touchstart', _this4._pointerDown, passiveEventListenerOptions);
              });

              this._initialTransform = undefined;
              this._rootElement = element;
            }

            if (typeof SVGElement !== 'undefined' && this._rootElement instanceof SVGElement) {
              this._ownerSVGElement = this._rootElement.ownerSVGElement;
            }

            return this;
          }
          /**
           * Element to which the draggable's position will be constrained.
           */

        }, {
          key: "withBoundaryElement",
          value: function withBoundaryElement(boundaryElement) {
            var _this5 = this;

            this._boundaryElement = boundaryElement ? Object(_angular_cdk_coercion__WEBPACK_IMPORTED_MODULE_4__["coerceElement"])(boundaryElement) : null;

            this._resizeSubscription.unsubscribe();

            if (boundaryElement) {
              this._resizeSubscription = this._viewportRuler.change(10).subscribe(function () {
                return _this5._containInsideBoundaryOnResize();
              });
            }

            return this;
          }
          /** Sets the parent ref that the ref is nested in.  */

        }, {
          key: "withParent",
          value: function withParent(parent) {
            this._parentDragRef = parent;
            return this;
          }
          /** Removes the dragging functionality from the DOM element. */

        }, {
          key: "dispose",
          value: function dispose() {
            this._removeRootElementListeners(this._rootElement); // Do this check before removing from the registry since it'll
            // stop being considered as dragged once it is removed.


            if (this.isDragging()) {
              // Since we move out the element to the end of the body while it's being
              // dragged, we have to make sure that it's removed if it gets destroyed.
              removeNode(this._rootElement);
            }

            removeNode(this._anchor);

            this._destroyPreview();

            this._destroyPlaceholder();

            this._dragDropRegistry.removeDragItem(this);

            this._removeSubscriptions();

            this.beforeStarted.complete();
            this.started.complete();
            this.released.complete();
            this.ended.complete();
            this.entered.complete();
            this.exited.complete();
            this.dropped.complete();

            this._moveEvents.complete();

            this._handles = [];

            this._disabledHandles.clear();

            this._dropContainer = undefined;

            this._resizeSubscription.unsubscribe();

            this._parentPositions.clear();

            this._boundaryElement = this._rootElement = this._ownerSVGElement = this._placeholderTemplate = this._previewTemplate = this._anchor = this._parentDragRef = null;
          }
          /** Checks whether the element is currently being dragged. */

        }, {
          key: "isDragging",
          value: function isDragging() {
            return this._hasStartedDragging && this._dragDropRegistry.isDragging(this);
          }
          /** Resets a standalone drag item to its initial position. */

        }, {
          key: "reset",
          value: function reset() {
            this._rootElement.style.transform = this._initialTransform || '';
            this._activeTransform = {
              x: 0,
              y: 0
            };
            this._passiveTransform = {
              x: 0,
              y: 0
            };
          }
          /**
           * Sets a handle as disabled. While a handle is disabled, it'll capture and interrupt dragging.
           * @param handle Handle element that should be disabled.
           */

        }, {
          key: "disableHandle",
          value: function disableHandle(handle) {
            if (!this._disabledHandles.has(handle) && this._handles.indexOf(handle) > -1) {
              this._disabledHandles.add(handle);

              toggleNativeDragInteractions(handle, true);
            }
          }
          /**
           * Enables a handle, if it has been disabled.
           * @param handle Handle element to be enabled.
           */

        }, {
          key: "enableHandle",
          value: function enableHandle(handle) {
            if (this._disabledHandles.has(handle)) {
              this._disabledHandles["delete"](handle);

              toggleNativeDragInteractions(handle, this.disabled);
            }
          }
          /** Sets the layout direction of the draggable item. */

        }, {
          key: "withDirection",
          value: function withDirection(direction) {
            this._direction = direction;
            return this;
          }
          /** Sets the container that the item is part of. */

        }, {
          key: "_withDropContainer",
          value: function _withDropContainer(container) {
            this._dropContainer = container;
          }
          /**
           * Gets the current position in pixels the draggable outside of a drop container.
           */

        }, {
          key: "getFreeDragPosition",
          value: function getFreeDragPosition() {
            var position = this.isDragging() ? this._activeTransform : this._passiveTransform;
            return {
              x: position.x,
              y: position.y
            };
          }
          /**
           * Sets the current position in pixels the draggable outside of a drop container.
           * @param value New position to be set.
           */

        }, {
          key: "setFreeDragPosition",
          value: function setFreeDragPosition(value) {
            this._activeTransform = {
              x: 0,
              y: 0
            };
            this._passiveTransform.x = value.x;
            this._passiveTransform.y = value.y;

            if (!this._dropContainer) {
              this._applyRootElementTransform(value.x, value.y);
            }

            return this;
          }
          /** Updates the item's sort order based on the last-known pointer position. */

        }, {
          key: "_sortFromLastPointerPosition",
          value: function _sortFromLastPointerPosition() {
            var position = this._lastKnownPointerPosition;

            if (position && this._dropContainer) {
              this._updateActiveDropContainer(this._getConstrainedPointerPosition(position), position);
            }
          }
          /** Unsubscribes from the global subscriptions. */

        }, {
          key: "_removeSubscriptions",
          value: function _removeSubscriptions() {
            this._pointerMoveSubscription.unsubscribe();

            this._pointerUpSubscription.unsubscribe();

            this._scrollSubscription.unsubscribe();
          }
          /** Destroys the preview element and its ViewRef. */

        }, {
          key: "_destroyPreview",
          value: function _destroyPreview() {
            if (this._preview) {
              removeNode(this._preview);
            }

            if (this._previewRef) {
              this._previewRef.destroy();
            }

            this._preview = this._previewRef = null;
          }
          /** Destroys the placeholder element and its ViewRef. */

        }, {
          key: "_destroyPlaceholder",
          value: function _destroyPlaceholder() {
            if (this._placeholder) {
              removeNode(this._placeholder);
            }

            if (this._placeholderRef) {
              this._placeholderRef.destroy();
            }

            this._placeholder = this._placeholderRef = null;
          }
          /**
           * Clears subscriptions and stops the dragging sequence.
           * @param event Browser event object that ended the sequence.
           */

        }, {
          key: "_endDragSequence",
          value: function _endDragSequence(event) {
            var _this6 = this;

            // Note that here we use `isDragging` from the service, rather than from `this`.
            // The difference is that the one from the service reflects whether a dragging sequence
            // has been initiated, whereas the one on `this` includes whether the user has passed
            // the minimum dragging threshold.
            if (!this._dragDropRegistry.isDragging(this)) {
              return;
            }

            this._removeSubscriptions();

            this._dragDropRegistry.stopDragging(this);

            this._toggleNativeDragInteractions();

            if (this._handles) {
              this._rootElement.style.webkitTapHighlightColor = this._rootElementTapHighlight;
            }

            if (!this._hasStartedDragging) {
              return;
            }

            this.released.next({
              source: this
            });

            if (this._dropContainer) {
              // Stop scrolling immediately, instead of waiting for the animation to finish.
              this._dropContainer._stopScrolling();

              this._animatePreviewToPlaceholder().then(function () {
                _this6._cleanupDragArtifacts(event);

                _this6._cleanupCachedDimensions();

                _this6._dragDropRegistry.stopDragging(_this6);
              });
            } else {
              // Convert the active transform into a passive one. This means that next time
              // the user starts dragging the item, its position will be calculated relatively
              // to the new passive transform.
              this._passiveTransform.x = this._activeTransform.x;
              this._passiveTransform.y = this._activeTransform.y;

              this._ngZone.run(function () {
                _this6.ended.next({
                  source: _this6,
                  distance: _this6._getDragDistance(_this6._getPointerPositionOnPage(event))
                });
              });

              this._cleanupCachedDimensions();

              this._dragDropRegistry.stopDragging(this);
            }
          }
          /** Starts the dragging sequence. */

        }, {
          key: "_startDragSequence",
          value: function _startDragSequence(event) {
            if (isTouchEvent(event)) {
              this._lastTouchEventTime = Date.now();
            }

            this._toggleNativeDragInteractions();

            var dropContainer = this._dropContainer;

            if (dropContainer) {
              var element = this._rootElement;
              var parent = element.parentNode;

              var preview = this._preview = this._createPreviewElement();

              var placeholder = this._placeholder = this._createPlaceholderElement();

              var anchor = this._anchor = this._anchor || this._document.createComment(''); // Needs to happen before the root element is moved.


              var shadowRoot = this._getShadowRoot(); // Insert an anchor node so that we can restore the element's position in the DOM.


              parent.insertBefore(anchor, element); // We move the element out at the end of the body and we make it hidden, because keeping it in
              // place will throw off the consumer's `:last-child` selectors. We can't remove the element
              // from the DOM completely, because iOS will stop firing all subsequent events in the chain.

              toggleVisibility(element, false);

              this._document.body.appendChild(parent.replaceChild(placeholder, element));

              getPreviewInsertionPoint(this._document, shadowRoot).appendChild(preview);
              this.started.next({
                source: this
              }); // Emit before notifying the container.

              dropContainer.start();
              this._initialContainer = dropContainer;
              this._initialIndex = dropContainer.getItemIndex(this);
            } else {
              this.started.next({
                source: this
              });
              this._initialContainer = this._initialIndex = undefined;
            } // Important to run after we've called `start` on the parent container
            // so that it has had time to resolve its scrollable parents.


            this._parentPositions.cache(dropContainer ? dropContainer.getScrollableParents() : []);
          }
          /**
           * Sets up the different variables and subscriptions
           * that will be necessary for the dragging sequence.
           * @param referenceElement Element that started the drag sequence.
           * @param event Browser event object that started the sequence.
           */

        }, {
          key: "_initializeDragSequence",
          value: function _initializeDragSequence(referenceElement, event) {
            var _this7 = this;

            // Stop propagation if the item is inside another
            // draggable so we don't start multiple drag sequences.
            if (this._parentDragRef) {
              event.stopPropagation();
            }

            var isDragging = this.isDragging();
            var isTouchSequence = isTouchEvent(event);
            var isAuxiliaryMouseButton = !isTouchSequence && event.button !== 0;
            var rootElement = this._rootElement;
            var isSyntheticEvent = !isTouchSequence && this._lastTouchEventTime && this._lastTouchEventTime + MOUSE_EVENT_IGNORE_TIME > Date.now(); // If the event started from an element with the native HTML drag&drop, it'll interfere
            // with our own dragging (e.g. `img` tags do it by default). Prevent the default action
            // to stop it from happening. Note that preventing on `dragstart` also seems to work, but
            // it's flaky and it fails if the user drags it away quickly. Also note that we only want
            // to do this for `mousedown` since doing the same for `touchstart` will stop any `click`
            // events from firing on touch devices.

            if (event.target && event.target.draggable && event.type === 'mousedown') {
              event.preventDefault();
            } // Abort if the user is already dragging or is using a mouse button other than the primary one.


            if (isDragging || isAuxiliaryMouseButton || isSyntheticEvent) {
              return;
            } // If we've got handles, we need to disable the tap highlight on the entire root element,
            // otherwise iOS will still add it, even though all the drag interactions on the handle
            // are disabled.


            if (this._handles.length) {
              this._rootElementTapHighlight = rootElement.style.webkitTapHighlightColor || '';
              rootElement.style.webkitTapHighlightColor = 'transparent';
            }

            this._hasStartedDragging = this._hasMoved = false; // Avoid multiple subscriptions and memory leaks when multi touch
            // (isDragging check above isn't enough because of possible temporal and/or dimensional delays)

            this._removeSubscriptions();

            this._pointerMoveSubscription = this._dragDropRegistry.pointerMove.subscribe(this._pointerMove);
            this._pointerUpSubscription = this._dragDropRegistry.pointerUp.subscribe(this._pointerUp);
            this._scrollSubscription = this._dragDropRegistry.scroll.subscribe(function (scrollEvent) {
              _this7._updateOnScroll(scrollEvent);
            });

            if (this._boundaryElement) {
              this._boundaryRect = getMutableClientRect(this._boundaryElement);
            } // If we have a custom preview we can't know ahead of time how large it'll be so we position
            // it next to the cursor. The exception is when the consumer has opted into making the preview
            // the same size as the root element, in which case we do know the size.


            var previewTemplate = this._previewTemplate;
            this._pickupPositionInElement = previewTemplate && previewTemplate.template && !previewTemplate.matchSize ? {
              x: 0,
              y: 0
            } : this._getPointerPositionInElement(referenceElement, event);

            var pointerPosition = this._pickupPositionOnPage = this._lastKnownPointerPosition = this._getPointerPositionOnPage(event);

            this._pointerDirectionDelta = {
              x: 0,
              y: 0
            };
            this._pointerPositionAtLastDirectionChange = {
              x: pointerPosition.x,
              y: pointerPosition.y
            };
            this._dragStartTime = Date.now();

            this._dragDropRegistry.startDragging(this, event);
          }
          /** Cleans up the DOM artifacts that were added to facilitate the element being dragged. */

        }, {
          key: "_cleanupDragArtifacts",
          value: function _cleanupDragArtifacts(event) {
            var _this8 = this;

            // Restore the element's visibility and insert it at its old position in the DOM.
            // It's important that we maintain the position, because moving the element around in the DOM
            // can throw off `NgFor` which does smart diffing and re-creates elements only when necessary,
            // while moving the existing elements in all other cases.
            toggleVisibility(this._rootElement, true);

            this._anchor.parentNode.replaceChild(this._rootElement, this._anchor);

            this._destroyPreview();

            this._destroyPlaceholder();

            this._boundaryRect = this._previewRect = undefined; // Re-enter the NgZone since we bound `document` events on the outside.

            this._ngZone.run(function () {
              var container = _this8._dropContainer;
              var currentIndex = container.getItemIndex(_this8);

              var pointerPosition = _this8._getPointerPositionOnPage(event);

              var distance = _this8._getDragDistance(_this8._getPointerPositionOnPage(event));

              var isPointerOverContainer = container._isOverContainer(pointerPosition.x, pointerPosition.y);

              _this8.ended.next({
                source: _this8,
                distance: distance
              });

              _this8.dropped.next({
                item: _this8,
                currentIndex: currentIndex,
                previousIndex: _this8._initialIndex,
                container: container,
                previousContainer: _this8._initialContainer,
                isPointerOverContainer: isPointerOverContainer,
                distance: distance
              });

              container.drop(_this8, currentIndex, _this8._initialIndex, _this8._initialContainer, isPointerOverContainer, distance);
              _this8._dropContainer = _this8._initialContainer;
            });
          }
          /**
           * Updates the item's position in its drop container, or moves it
           * into a new one, depending on its current drag position.
           */

        }, {
          key: "_updateActiveDropContainer",
          value: function _updateActiveDropContainer(_ref, _ref2) {
            var _this9 = this;

            var x = _ref.x,
                y = _ref.y;
            var rawX = _ref2.x,
                rawY = _ref2.y;

            // Drop container that draggable has been moved into.
            var newContainer = this._initialContainer._getSiblingContainerFromPosition(this, x, y); // If we couldn't find a new container to move the item into, and the item has left its
            // initial container, check whether the it's over the initial container. This handles the
            // case where two containers are connected one way and the user tries to undo dragging an
            // item into a new container.


            if (!newContainer && this._dropContainer !== this._initialContainer && this._initialContainer._isOverContainer(x, y)) {
              newContainer = this._initialContainer;
            }

            if (newContainer && newContainer !== this._dropContainer) {
              this._ngZone.run(function () {
                // Notify the old container that the item has left.
                _this9.exited.next({
                  item: _this9,
                  container: _this9._dropContainer
                });

                _this9._dropContainer.exit(_this9); // Notify the new container that the item has entered.


                _this9._dropContainer = newContainer;

                _this9._dropContainer.enter(_this9, x, y, newContainer === _this9._initialContainer && // If we're re-entering the initial container and sorting is disabled,
                // put item the into its starting index to begin with.
                newContainer.sortingDisabled ? _this9._initialIndex : undefined);

                _this9.entered.next({
                  item: _this9,
                  container: newContainer,
                  currentIndex: newContainer.getItemIndex(_this9)
                });
              });
            }

            this._dropContainer._startScrollingIfNecessary(rawX, rawY);

            this._dropContainer._sortItem(this, x, y, this._pointerDirectionDelta);

            this._preview.style.transform = getTransform(x - this._pickupPositionInElement.x, y - this._pickupPositionInElement.y);
          }
          /**
           * Creates the element that will be rendered next to the user's pointer
           * and will be used as a preview of the element that is being dragged.
           */

        }, {
          key: "_createPreviewElement",
          value: function _createPreviewElement() {
            var previewConfig = this._previewTemplate;
            var previewClass = this.previewClass;
            var previewTemplate = previewConfig ? previewConfig.template : null;
            var preview;

            if (previewTemplate && previewConfig) {
              // Measure the element before we've inserted the preview
              // since the insertion could throw off the measurement.
              var rootRect = previewConfig.matchSize ? this._rootElement.getBoundingClientRect() : null;
              var viewRef = previewConfig.viewContainer.createEmbeddedView(previewTemplate, previewConfig.context);
              viewRef.detectChanges();
              preview = getRootNode(viewRef, this._document);
              this._previewRef = viewRef;

              if (previewConfig.matchSize) {
                matchElementSize(preview, rootRect);
              } else {
                preview.style.transform = getTransform(this._pickupPositionOnPage.x, this._pickupPositionOnPage.y);
              }
            } else {
              var element = this._rootElement;
              preview = deepCloneNode(element);
              matchElementSize(preview, element.getBoundingClientRect());
            }

            extendStyles(preview.style, {
              // It's important that we disable the pointer events on the preview, because
              // it can throw off the `document.elementFromPoint` calls in the `CdkDropList`.
              pointerEvents: 'none',
              // We have to reset the margin, because it can throw off positioning relative to the viewport.
              margin: '0',
              position: 'fixed',
              top: '0',
              left: '0',
              zIndex: "".concat(this._config.zIndex || 1000)
            });
            toggleNativeDragInteractions(preview, false);
            preview.classList.add('cdk-drag-preview');
            preview.setAttribute('dir', this._direction);

            if (previewClass) {
              if (Array.isArray(previewClass)) {
                previewClass.forEach(function (className) {
                  return preview.classList.add(className);
                });
              } else {
                preview.classList.add(previewClass);
              }
            }

            return preview;
          }
          /**
           * Animates the preview element from its current position to the location of the drop placeholder.
           * @returns Promise that resolves when the animation completes.
           */

        }, {
          key: "_animatePreviewToPlaceholder",
          value: function _animatePreviewToPlaceholder() {
            var _this10 = this;

            // If the user hasn't moved yet, the transitionend event won't fire.
            if (!this._hasMoved) {
              return Promise.resolve();
            }

            var placeholderRect = this._placeholder.getBoundingClientRect(); // Apply the class that adds a transition to the preview.


            this._preview.classList.add('cdk-drag-animating'); // Move the preview to the placeholder position.


            this._preview.style.transform = getTransform(placeholderRect.left, placeholderRect.top); // If the element doesn't have a `transition`, the `transitionend` event won't fire. Since
            // we need to trigger a style recalculation in order for the `cdk-drag-animating` class to
            // apply its style, we take advantage of the available info to figure out whether we need to
            // bind the event in the first place.

            var duration = getTransformTransitionDurationInMs(this._preview);

            if (duration === 0) {
              return Promise.resolve();
            }

            return this._ngZone.runOutsideAngular(function () {
              return new Promise(function (resolve) {
                var handler = function handler(event) {
                  if (!event || event.target === _this10._preview && event.propertyName === 'transform') {
                    _this10._preview.removeEventListener('transitionend', handler);

                    resolve();
                    clearTimeout(timeout);
                  }
                }; // If a transition is short enough, the browser might not fire the `transitionend` event.
                // Since we know how long it's supposed to take, add a timeout with a 50% buffer that'll
                // fire if the transition hasn't completed when it was supposed to.


                var timeout = setTimeout(handler, duration * 1.5);

                _this10._preview.addEventListener('transitionend', handler);
              });
            });
          }
          /** Creates an element that will be shown instead of the current element while dragging. */

        }, {
          key: "_createPlaceholderElement",
          value: function _createPlaceholderElement() {
            var placeholderConfig = this._placeholderTemplate;
            var placeholderTemplate = placeholderConfig ? placeholderConfig.template : null;
            var placeholder;

            if (placeholderTemplate) {
              this._placeholderRef = placeholderConfig.viewContainer.createEmbeddedView(placeholderTemplate, placeholderConfig.context);

              this._placeholderRef.detectChanges();

              placeholder = getRootNode(this._placeholderRef, this._document);
            } else {
              placeholder = deepCloneNode(this._rootElement);
            }

            placeholder.classList.add('cdk-drag-placeholder');
            return placeholder;
          }
          /**
           * Figures out the coordinates at which an element was picked up.
           * @param referenceElement Element that initiated the dragging.
           * @param event Event that initiated the dragging.
           */

        }, {
          key: "_getPointerPositionInElement",
          value: function _getPointerPositionInElement(referenceElement, event) {
            var elementRect = this._rootElement.getBoundingClientRect();

            var handleElement = referenceElement === this._rootElement ? null : referenceElement;
            var referenceRect = handleElement ? handleElement.getBoundingClientRect() : elementRect;
            var point = isTouchEvent(event) ? event.targetTouches[0] : event;

            var scrollPosition = this._getViewportScrollPosition();

            var x = point.pageX - referenceRect.left - scrollPosition.left;
            var y = point.pageY - referenceRect.top - scrollPosition.top;
            return {
              x: referenceRect.left - elementRect.left + x,
              y: referenceRect.top - elementRect.top + y
            };
          }
          /** Determines the point of the page that was touched by the user. */

        }, {
          key: "_getPointerPositionOnPage",
          value: function _getPointerPositionOnPage(event) {
            var scrollPosition = this._getViewportScrollPosition();

            var point = isTouchEvent(event) ? event.touches[0] || event.changedTouches[0] || {
              pageX: 0,
              pageY: 0
            } : event;
            var x = point.pageX - scrollPosition.left;
            var y = point.pageY - scrollPosition.top; // if dragging SVG element, try to convert from the screen coordinate system to the SVG
            // coordinate system

            if (this._ownerSVGElement) {
              var svgMatrix = this._ownerSVGElement.getScreenCTM();

              if (svgMatrix) {
                var svgPoint = this._ownerSVGElement.createSVGPoint();

                svgPoint.x = x;
                svgPoint.y = y;
                return svgPoint.matrixTransform(svgMatrix.inverse());
              }
            }

            return {
              x: x,
              y: y
            };
          }
          /** Gets the pointer position on the page, accounting for any position constraints. */

        }, {
          key: "_getConstrainedPointerPosition",
          value: function _getConstrainedPointerPosition(point) {
            var dropContainerLock = this._dropContainer ? this._dropContainer.lockAxis : null;

            var _ref3 = this.constrainPosition ? this.constrainPosition(point, this) : point,
                x = _ref3.x,
                y = _ref3.y;

            if (this.lockAxis === 'x' || dropContainerLock === 'x') {
              y = this._pickupPositionOnPage.y;
            } else if (this.lockAxis === 'y' || dropContainerLock === 'y') {
              x = this._pickupPositionOnPage.x;
            }

            if (this._boundaryRect) {
              var _this$_pickupPosition = this._pickupPositionInElement,
                  pickupX = _this$_pickupPosition.x,
                  pickupY = _this$_pickupPosition.y;
              var boundaryRect = this._boundaryRect;
              var previewRect = this._previewRect;
              var minY = boundaryRect.top + pickupY;
              var maxY = boundaryRect.bottom - (previewRect.height - pickupY);
              var minX = boundaryRect.left + pickupX;
              var maxX = boundaryRect.right - (previewRect.width - pickupX);
              x = clamp(x, minX, maxX);
              y = clamp(y, minY, maxY);
            }

            return {
              x: x,
              y: y
            };
          }
          /** Updates the current drag delta, based on the user's current pointer position on the page. */

        }, {
          key: "_updatePointerDirectionDelta",
          value: function _updatePointerDirectionDelta(pointerPositionOnPage) {
            var x = pointerPositionOnPage.x,
                y = pointerPositionOnPage.y;
            var delta = this._pointerDirectionDelta;
            var positionSinceLastChange = this._pointerPositionAtLastDirectionChange; // Amount of pixels the user has dragged since the last time the direction changed.

            var changeX = Math.abs(x - positionSinceLastChange.x);
            var changeY = Math.abs(y - positionSinceLastChange.y); // Because we handle pointer events on a per-pixel basis, we don't want the delta
            // to change for every pixel, otherwise anything that depends on it can look erratic.
            // To make the delta more consistent, we track how much the user has moved since the last
            // delta change and we only update it after it has reached a certain threshold.

            if (changeX > this._config.pointerDirectionChangeThreshold) {
              delta.x = x > positionSinceLastChange.x ? 1 : -1;
              positionSinceLastChange.x = x;
            }

            if (changeY > this._config.pointerDirectionChangeThreshold) {
              delta.y = y > positionSinceLastChange.y ? 1 : -1;
              positionSinceLastChange.y = y;
            }

            return delta;
          }
          /** Toggles the native drag interactions, based on how many handles are registered. */

        }, {
          key: "_toggleNativeDragInteractions",
          value: function _toggleNativeDragInteractions() {
            if (!this._rootElement || !this._handles) {
              return;
            }

            var shouldEnable = this._handles.length > 0 || !this.isDragging();

            if (shouldEnable !== this._nativeInteractionsEnabled) {
              this._nativeInteractionsEnabled = shouldEnable;
              toggleNativeDragInteractions(this._rootElement, shouldEnable);
            }
          }
          /** Removes the manually-added event listeners from the root element. */

        }, {
          key: "_removeRootElementListeners",
          value: function _removeRootElementListeners(element) {
            element.removeEventListener('mousedown', this._pointerDown, activeEventListenerOptions);
            element.removeEventListener('touchstart', this._pointerDown, passiveEventListenerOptions);
          }
          /**
           * Applies a `transform` to the root element, taking into account any existing transforms on it.
           * @param x New transform value along the X axis.
           * @param y New transform value along the Y axis.
           */

        }, {
          key: "_applyRootElementTransform",
          value: function _applyRootElementTransform(x, y) {
            var transform = getTransform(x, y); // Cache the previous transform amount only after the first drag sequence, because
            // we don't want our own transforms to stack on top of each other.

            if (this._initialTransform == null) {
              this._initialTransform = this._rootElement.style.transform || '';
            } // Preserve the previous `transform` value, if there was one. Note that we apply our own
            // transform before the user's, because things like rotation can affect which direction
            // the element will be translated towards.


            this._rootElement.style.transform = this._initialTransform ? transform + ' ' + this._initialTransform : transform;
          }
          /**
           * Gets the distance that the user has dragged during the current drag sequence.
           * @param currentPosition Current position of the user's pointer.
           */

        }, {
          key: "_getDragDistance",
          value: function _getDragDistance(currentPosition) {
            var pickupPosition = this._pickupPositionOnPage;

            if (pickupPosition) {
              return {
                x: currentPosition.x - pickupPosition.x,
                y: currentPosition.y - pickupPosition.y
              };
            }

            return {
              x: 0,
              y: 0
            };
          }
          /** Cleans up any cached element dimensions that we don't need after dragging has stopped. */

        }, {
          key: "_cleanupCachedDimensions",
          value: function _cleanupCachedDimensions() {
            this._boundaryRect = this._previewRect = undefined;

            this._parentPositions.clear();
          }
          /**
           * Checks whether the element is still inside its boundary after the viewport has been resized.
           * If not, the position is adjusted so that the element fits again.
           */

        }, {
          key: "_containInsideBoundaryOnResize",
          value: function _containInsideBoundaryOnResize() {
            var _this$_passiveTransfo = this._passiveTransform,
                x = _this$_passiveTransfo.x,
                y = _this$_passiveTransfo.y;

            if (x === 0 && y === 0 || this.isDragging() || !this._boundaryElement) {
              return;
            }

            var boundaryRect = this._boundaryElement.getBoundingClientRect();

            var elementRect = this._rootElement.getBoundingClientRect(); // It's possible that the element got hidden away after dragging (e.g. by switching to a
            // different tab). Don't do anything in this case so we don't clear the user's position.


            if (boundaryRect.width === 0 && boundaryRect.height === 0 || elementRect.width === 0 && elementRect.height === 0) {
              return;
            }

            var leftOverflow = boundaryRect.left - elementRect.left;
            var rightOverflow = elementRect.right - boundaryRect.right;
            var topOverflow = boundaryRect.top - elementRect.top;
            var bottomOverflow = elementRect.bottom - boundaryRect.bottom; // If the element has become wider than the boundary, we can't
            // do much to make it fit so we just anchor it to the left.

            if (boundaryRect.width > elementRect.width) {
              if (leftOverflow > 0) {
                x += leftOverflow;
              }

              if (rightOverflow > 0) {
                x -= rightOverflow;
              }
            } else {
              x = 0;
            } // If the element has become taller than the boundary, we can't
            // do much to make it fit so we just anchor it to the top.


            if (boundaryRect.height > elementRect.height) {
              if (topOverflow > 0) {
                y += topOverflow;
              }

              if (bottomOverflow > 0) {
                y -= bottomOverflow;
              }
            } else {
              y = 0;
            }

            if (x !== this._passiveTransform.x || y !== this._passiveTransform.y) {
              this.setFreeDragPosition({
                y: y,
                x: x
              });
            }
          }
          /** Gets the drag start delay, based on the event type. */

        }, {
          key: "_getDragStartDelay",
          value: function _getDragStartDelay(event) {
            var value = this.dragStartDelay;

            if (typeof value === 'number') {
              return value;
            } else if (isTouchEvent(event)) {
              return value.touch;
            }

            return value ? value.mouse : 0;
          }
          /** Updates the internal state of the draggable element when scrolling has occurred. */

        }, {
          key: "_updateOnScroll",
          value: function _updateOnScroll(event) {
            var scrollDifference = this._parentPositions.handleScroll(event);

            if (scrollDifference) {
              var target = event.target; // ClientRect dimensions are based on the scroll position of the page and its parent node so
              // we have to update the cached boundary ClientRect if the user has scrolled. Check for
              // the `document` specifically since IE doesn't support `contains` on it.

              if (this._boundaryRect && (target === this._document || target !== this._boundaryElement && target.contains(this._boundaryElement))) {
                adjustClientRect(this._boundaryRect, scrollDifference.top, scrollDifference.left);
              }

              this._pickupPositionOnPage.x += scrollDifference.left;
              this._pickupPositionOnPage.y += scrollDifference.top; // If we're in free drag mode, we have to update the active transform, because
              // it isn't relative to the viewport like the preview inside a drop list.

              if (!this._dropContainer) {
                this._activeTransform.x -= scrollDifference.left;
                this._activeTransform.y -= scrollDifference.top;

                this._applyRootElementTransform(this._activeTransform.x, this._activeTransform.y);
              }
            }
          }
          /** Gets the scroll position of the viewport. */

        }, {
          key: "_getViewportScrollPosition",
          value: function _getViewportScrollPosition() {
            var cachedPosition = this._parentPositions.positions.get(this._document);

            return cachedPosition ? cachedPosition.scrollPosition : this._viewportRuler.getViewportScrollPosition();
          }
          /**
           * Lazily resolves and returns the shadow root of the element. We do this in a function, rather
           * than saving it in property directly on init, because we want to resolve it as late as possible
           * in order to ensure that the element has been moved into the shadow DOM. Doing it inside the
           * constructor might be too early if the element is inside of something like `ngFor` or `ngIf`.
           */

        }, {
          key: "_getShadowRoot",
          value: function _getShadowRoot() {
            if (this._cachedShadowRoot === undefined) {
              this._cachedShadowRoot = Object(_angular_cdk_platform__WEBPACK_IMPORTED_MODULE_3__["_getShadowRoot"])(this._rootElement);
            }

            return this._cachedShadowRoot;
          }
        }]);

        return DragRef;
      }();
      /**
       * Gets a 3d `transform` that can be applied to an element.
       * @param x Desired position of the element along the X axis.
       * @param y Desired position of the element along the Y axis.
       */


      function getTransform(x, y) {
        // Round the transforms since some browsers will
        // blur the elements for sub-pixel transforms.
        return "translate3d(".concat(Math.round(x), "px, ").concat(Math.round(y), "px, 0)");
      }
      /** Clamps a value between a minimum and a maximum. */


      function clamp(value, min, max) {
        return Math.max(min, Math.min(max, value));
      }
      /**
       * Helper to remove a node from the DOM and to do all the necessary null checks.
       * @param node Node to be removed.
       */


      function removeNode(node) {
        if (node && node.parentNode) {
          node.parentNode.removeChild(node);
        }
      }
      /** Determines whether an event is a touch event. */


      function isTouchEvent(event) {
        // This function is called for every pixel that the user has dragged so we need it to be
        // as fast as possible. Since we only bind mouse events and touch events, we can assume
        // that if the event's name starts with `t`, it's a touch event.
        return event.type[0] === 't';
      }
      /** Gets the element into which the drag preview should be inserted. */


      function getPreviewInsertionPoint(documentRef, shadowRoot) {
        // We can't use the body if the user is in fullscreen mode,
        // because the preview will render under the fullscreen element.
        // TODO(crisbeto): dedupe this with the `FullscreenOverlayContainer` eventually.
        return shadowRoot || documentRef.fullscreenElement || documentRef.webkitFullscreenElement || documentRef.mozFullScreenElement || documentRef.msFullscreenElement || documentRef.body;
      }
      /**
       * Gets the root HTML element of an embedded view.
       * If the root is not an HTML element it gets wrapped in one.
       */


      function getRootNode(viewRef, _document) {
        var rootNodes = viewRef.rootNodes;

        if (rootNodes.length === 1 && rootNodes[0].nodeType === _document.ELEMENT_NODE) {
          return rootNodes[0];
        }

        var wrapper = _document.createElement('div');

        rootNodes.forEach(function (node) {
          return wrapper.appendChild(node);
        });
        return wrapper;
      }
      /**
       * Matches the target element's size to the source's size.
       * @param target Element that needs to be resized.
       * @param sourceRect Dimensions of the source element.
       */


      function matchElementSize(target, sourceRect) {
        target.style.width = "".concat(sourceRect.width, "px");
        target.style.height = "".concat(sourceRect.height, "px");
        target.style.transform = getTransform(sourceRect.left, sourceRect.top);
      }
      /**
       * @license
       * Copyright Google LLC All Rights Reserved.
       *
       * Use of this source code is governed by an MIT-style license that can be
       * found in the LICENSE file at https://angular.io/license
       */

      /**
       * Moves an item one index in an array to another.
       * @param array Array in which to move the item.
       * @param fromIndex Starting index of the item.
       * @param toIndex Index to which the item should be moved.
       */


      function moveItemInArray(array, fromIndex, toIndex) {
        var from = clamp$1(fromIndex, array.length - 1);
        var to = clamp$1(toIndex, array.length - 1);

        if (from === to) {
          return;
        }

        var target = array[from];
        var delta = to < from ? -1 : 1;

        for (var i = from; i !== to; i += delta) {
          array[i] = array[i + delta];
        }

        array[to] = target;
      }
      /**
       * Moves an item from one array to another.
       * @param currentArray Array from which to transfer the item.
       * @param targetArray Array into which to put the item.
       * @param currentIndex Index of the item in its current array.
       * @param targetIndex Index at which to insert the item.
       */


      function transferArrayItem(currentArray, targetArray, currentIndex, targetIndex) {
        var from = clamp$1(currentIndex, currentArray.length - 1);
        var to = clamp$1(targetIndex, targetArray.length);

        if (currentArray.length) {
          targetArray.splice(to, 0, currentArray.splice(from, 1)[0]);
        }
      }
      /**
       * Copies an item from one array to another, leaving it in its
       * original position in current array.
       * @param currentArray Array from which to copy the item.
       * @param targetArray Array into which is copy the item.
       * @param currentIndex Index of the item in its current array.
       * @param targetIndex Index at which to insert the item.
       *
       */


      function copyArrayItem(currentArray, targetArray, currentIndex, targetIndex) {
        var to = clamp$1(targetIndex, targetArray.length);

        if (currentArray.length) {
          targetArray.splice(to, 0, currentArray[currentIndex]);
        }
      }
      /** Clamps a number between zero and a maximum. */


      function clamp$1(value, max) {
        return Math.max(0, Math.min(max, value));
      }
      /**
       * @license
       * Copyright Google LLC All Rights Reserved.
       *
       * Use of this source code is governed by an MIT-style license that can be
       * found in the LICENSE file at https://angular.io/license
       */

      /**
       * Proximity, as a ratio to width/height, at which a
       * dragged item will affect the drop container.
       */


      var DROP_PROXIMITY_THRESHOLD = 0.05;
      /**
       * Proximity, as a ratio to width/height at which to start auto-scrolling the drop list or the
       * viewport. The value comes from trying it out manually until it feels right.
       */

      var SCROLL_PROXIMITY_THRESHOLD = 0.05;
      /**
       * Reference to a drop list. Used to manipulate or dispose of the container.
       */

      var DropListRef = /*#__PURE__*/function () {
        function DropListRef(element, _dragDropRegistry, _document, _ngZone, _viewportRuler) {
          var _this11 = this;

          _classCallCheck(this, DropListRef);

          this._dragDropRegistry = _dragDropRegistry;
          this._ngZone = _ngZone;
          this._viewportRuler = _viewportRuler;
          /** Whether starting a dragging sequence from this container is disabled. */

          this.disabled = false;
          /** Whether sorting items within the list is disabled. */

          this.sortingDisabled = false;
          /**
           * Whether auto-scrolling the view when the user
           * moves their pointer close to the edges is disabled.
           */

          this.autoScrollDisabled = false;
          /** Number of pixels to scroll for each frame when auto-scrolling an element. */

          this.autoScrollStep = 2;
          /**
           * Function that is used to determine whether an item
           * is allowed to be moved into a drop container.
           */

          this.enterPredicate = function () {
            return true;
          };
          /** Functions that is used to determine whether an item can be sorted into a particular index. */


          this.sortPredicate = function () {
            return true;
          };
          /** Emits right before dragging has started. */


          this.beforeStarted = new rxjs__WEBPACK_IMPORTED_MODULE_5__["Subject"]();
          /**
           * Emits when the user has moved a new drag item into this container.
           */

          this.entered = new rxjs__WEBPACK_IMPORTED_MODULE_5__["Subject"]();
          /**
           * Emits when the user removes an item from the container
           * by dragging it into another container.
           */

          this.exited = new rxjs__WEBPACK_IMPORTED_MODULE_5__["Subject"]();
          /** Emits when the user drops an item inside the container. */

          this.dropped = new rxjs__WEBPACK_IMPORTED_MODULE_5__["Subject"]();
          /** Emits as the user is swapping items while actively dragging. */

          this.sorted = new rxjs__WEBPACK_IMPORTED_MODULE_5__["Subject"]();
          /** Whether an item in the list is being dragged. */

          this._isDragging = false;
          /** Cache of the dimensions of all the items inside the container. */

          this._itemPositions = [];
          /**
           * Keeps track of the item that was last swapped with the dragged item, as well as what direction
           * the pointer was moving in when the swap occured and whether the user's pointer continued to
           * overlap with the swapped item after the swapping occurred.
           */

          this._previousSwap = {
            drag: null,
            delta: 0,
            overlaps: false
          };
          /** Draggable items in the container. */

          this._draggables = [];
          /** Drop lists that are connected to the current one. */

          this._siblings = [];
          /** Direction in which the list is oriented. */

          this._orientation = 'vertical';
          /** Connected siblings that currently have a dragged item. */

          this._activeSiblings = new Set();
          /** Layout direction of the drop list. */

          this._direction = 'ltr';
          /** Subscription to the window being scrolled. */

          this._viewportScrollSubscription = rxjs__WEBPACK_IMPORTED_MODULE_5__["Subscription"].EMPTY;
          /** Vertical direction in which the list is currently scrolling. */

          this._verticalScrollDirection = 0
          /* NONE */
          ;
          /** Horizontal direction in which the list is currently scrolling. */

          this._horizontalScrollDirection = 0
          /* NONE */
          ;
          /** Used to signal to the current auto-scroll sequence when to stop. */

          this._stopScrollTimers = new rxjs__WEBPACK_IMPORTED_MODULE_5__["Subject"]();
          /** Shadow root of the current element. Necessary for `elementFromPoint` to resolve correctly. */

          this._cachedShadowRoot = null;
          /** Starts the interval that'll auto-scroll the element. */

          this._startScrollInterval = function () {
            _this11._stopScrolling();

            Object(rxjs__WEBPACK_IMPORTED_MODULE_5__["interval"])(0, rxjs__WEBPACK_IMPORTED_MODULE_5__["animationFrameScheduler"]).pipe(Object(rxjs_operators__WEBPACK_IMPORTED_MODULE_6__["takeUntil"])(_this11._stopScrollTimers)).subscribe(function () {
              var node = _this11._scrollNode;
              var scrollStep = _this11.autoScrollStep;

              if (_this11._verticalScrollDirection === 1
              /* UP */
              ) {
                incrementVerticalScroll(node, -scrollStep);
              } else if (_this11._verticalScrollDirection === 2
              /* DOWN */
              ) {
                incrementVerticalScroll(node, scrollStep);
              }

              if (_this11._horizontalScrollDirection === 1
              /* LEFT */
              ) {
                incrementHorizontalScroll(node, -scrollStep);
              } else if (_this11._horizontalScrollDirection === 2
              /* RIGHT */
              ) {
                incrementHorizontalScroll(node, scrollStep);
              }
            });
          };

          this.element = Object(_angular_cdk_coercion__WEBPACK_IMPORTED_MODULE_4__["coerceElement"])(element);
          this._document = _document;
          this.withScrollableParents([this.element]);

          _dragDropRegistry.registerDropContainer(this);

          this._parentPositions = new ParentPositionTracker(_document, _viewportRuler);
        }
        /** Removes the drop list functionality from the DOM element. */


        _createClass(DropListRef, [{
          key: "dispose",
          value: function dispose() {
            this._stopScrolling();

            this._stopScrollTimers.complete();

            this._viewportScrollSubscription.unsubscribe();

            this.beforeStarted.complete();
            this.entered.complete();
            this.exited.complete();
            this.dropped.complete();
            this.sorted.complete();

            this._activeSiblings.clear();

            this._scrollNode = null;

            this._parentPositions.clear();

            this._dragDropRegistry.removeDropContainer(this);
          }
          /** Whether an item from this list is currently being dragged. */

        }, {
          key: "isDragging",
          value: function isDragging() {
            return this._isDragging;
          }
          /** Starts dragging an item. */

        }, {
          key: "start",
          value: function start() {
            this._draggingStarted();

            this._notifyReceivingSiblings();
          }
          /**
           * Emits an event to indicate that the user moved an item into the container.
           * @param item Item that was moved into the container.
           * @param pointerX Position of the item along the X axis.
           * @param pointerY Position of the item along the Y axis.
           * @param index Index at which the item entered. If omitted, the container will try to figure it
           *   out automatically.
           */

        }, {
          key: "enter",
          value: function enter(item, pointerX, pointerY, index) {
            this._draggingStarted(); // If sorting is disabled, we want the item to return to its starting
            // position if the user is returning it to its initial container.


            var newIndex;

            if (index == null) {
              newIndex = this.sortingDisabled ? this._draggables.indexOf(item) : -1;

              if (newIndex === -1) {
                // We use the coordinates of where the item entered the drop
                // zone to figure out at which index it should be inserted.
                newIndex = this._getItemIndexFromPointerPosition(item, pointerX, pointerY);
              }
            } else {
              newIndex = index;
            }

            var activeDraggables = this._activeDraggables;
            var currentIndex = activeDraggables.indexOf(item);
            var placeholder = item.getPlaceholderElement();
            var newPositionReference = activeDraggables[newIndex]; // If the item at the new position is the same as the item that is being dragged,
            // it means that we're trying to restore the item to its initial position. In this
            // case we should use the next item from the list as the reference.

            if (newPositionReference === item) {
              newPositionReference = activeDraggables[newIndex + 1];
            } // Since the item may be in the `activeDraggables` already (e.g. if the user dragged it
            // into another container and back again), we have to ensure that it isn't duplicated.


            if (currentIndex > -1) {
              activeDraggables.splice(currentIndex, 1);
            } // Don't use items that are being dragged as a reference, because
            // their element has been moved down to the bottom of the body.


            if (newPositionReference && !this._dragDropRegistry.isDragging(newPositionReference)) {
              var element = newPositionReference.getRootElement();
              element.parentElement.insertBefore(placeholder, element);
              activeDraggables.splice(newIndex, 0, item);
            } else if (this._shouldEnterAsFirstChild(pointerX, pointerY)) {
              var reference = activeDraggables[0].getRootElement();
              reference.parentNode.insertBefore(placeholder, reference);
              activeDraggables.unshift(item);
            } else {
              Object(_angular_cdk_coercion__WEBPACK_IMPORTED_MODULE_4__["coerceElement"])(this.element).appendChild(placeholder);
              activeDraggables.push(item);
            } // The transform needs to be cleared so it doesn't throw off the measurements.


            placeholder.style.transform = ''; // Note that the positions were already cached when we called `start` above,
            // but we need to refresh them since the amount of items has changed and also parent rects.

            this._cacheItemPositions();

            this._cacheParentPositions(); // Notify siblings at the end so that the item has been inserted into the `activeDraggables`.


            this._notifyReceivingSiblings();

            this.entered.next({
              item: item,
              container: this,
              currentIndex: this.getItemIndex(item)
            });
          }
          /**
           * Removes an item from the container after it was dragged into another container by the user.
           * @param item Item that was dragged out.
           */

        }, {
          key: "exit",
          value: function exit(item) {
            this._reset();

            this.exited.next({
              item: item,
              container: this
            });
          }
          /**
           * Drops an item into this container.
           * @param item Item being dropped into the container.
           * @param currentIndex Index at which the item should be inserted.
           * @param previousIndex Index of the item when dragging started.
           * @param previousContainer Container from which the item got dragged in.
           * @param isPointerOverContainer Whether the user's pointer was over the
           *    container when the item was dropped.
           * @param distance Distance the user has dragged since the start of the dragging sequence.
           */

        }, {
          key: "drop",
          value: function drop(item, currentIndex, previousIndex, previousContainer, isPointerOverContainer, distance) {
            this._reset();

            this.dropped.next({
              item: item,
              currentIndex: currentIndex,
              previousIndex: previousIndex,
              container: this,
              previousContainer: previousContainer,
              isPointerOverContainer: isPointerOverContainer,
              distance: distance
            });
          }
          /**
           * Sets the draggable items that are a part of this list.
           * @param items Items that are a part of this list.
           */

        }, {
          key: "withItems",
          value: function withItems(items) {
            var _this12 = this;

            var previousItems = this._draggables;
            this._draggables = items;
            items.forEach(function (item) {
              return item._withDropContainer(_this12);
            });

            if (this.isDragging()) {
              var draggedItems = previousItems.filter(function (item) {
                return item.isDragging();
              }); // If all of the items being dragged were removed
              // from the list, abort the current drag sequence.

              if (draggedItems.every(function (item) {
                return items.indexOf(item) === -1;
              })) {
                this._reset();
              } else {
                this._cacheItems();
              }
            }

            return this;
          }
          /** Sets the layout direction of the drop list. */

        }, {
          key: "withDirection",
          value: function withDirection(direction) {
            this._direction = direction;
            return this;
          }
          /**
           * Sets the containers that are connected to this one. When two or more containers are
           * connected, the user will be allowed to transfer items between them.
           * @param connectedTo Other containers that the current containers should be connected to.
           */

        }, {
          key: "connectedTo",
          value: function connectedTo(_connectedTo) {
            this._siblings = _connectedTo.slice();
            return this;
          }
          /**
           * Sets the orientation of the container.
           * @param orientation New orientation for the container.
           */

        }, {
          key: "withOrientation",
          value: function withOrientation(orientation) {
            this._orientation = orientation;
            return this;
          }
          /**
           * Sets which parent elements are can be scrolled while the user is dragging.
           * @param elements Elements that can be scrolled.
           */

        }, {
          key: "withScrollableParents",
          value: function withScrollableParents(elements) {
            var element = Object(_angular_cdk_coercion__WEBPACK_IMPORTED_MODULE_4__["coerceElement"])(this.element); // We always allow the current element to be scrollable
            // so we need to ensure that it's in the array.

            this._scrollableElements = elements.indexOf(element) === -1 ? [element].concat(_toConsumableArray(elements)) : elements.slice();
            return this;
          }
          /** Gets the scrollable parents that are registered with this drop container. */

        }, {
          key: "getScrollableParents",
          value: function getScrollableParents() {
            return this._scrollableElements;
          }
          /**
           * Figures out the index of an item in the container.
           * @param item Item whose index should be determined.
           */

        }, {
          key: "getItemIndex",
          value: function getItemIndex(item) {
            if (!this._isDragging) {
              return this._draggables.indexOf(item);
            } // Items are sorted always by top/left in the cache, however they flow differently in RTL.
            // The rest of the logic still stands no matter what orientation we're in, however
            // we need to invert the array when determining the index.


            var items = this._orientation === 'horizontal' && this._direction === 'rtl' ? this._itemPositions.slice().reverse() : this._itemPositions;
            return findIndex(items, function (currentItem) {
              return currentItem.drag === item;
            });
          }
          /**
           * Whether the list is able to receive the item that
           * is currently being dragged inside a connected drop list.
           */

        }, {
          key: "isReceiving",
          value: function isReceiving() {
            return this._activeSiblings.size > 0;
          }
          /**
           * Sorts an item inside the container based on its position.
           * @param item Item to be sorted.
           * @param pointerX Position of the item along the X axis.
           * @param pointerY Position of the item along the Y axis.
           * @param pointerDelta Direction in which the pointer is moving along each axis.
           */

        }, {
          key: "_sortItem",
          value: function _sortItem(item, pointerX, pointerY, pointerDelta) {
            // Don't sort the item if sorting is disabled or it's out of range.
            if (this.sortingDisabled || !this._clientRect || !isPointerNearClientRect(this._clientRect, DROP_PROXIMITY_THRESHOLD, pointerX, pointerY)) {
              return;
            }

            var siblings = this._itemPositions;

            var newIndex = this._getItemIndexFromPointerPosition(item, pointerX, pointerY, pointerDelta);

            if (newIndex === -1 && siblings.length > 0) {
              return;
            }

            var isHorizontal = this._orientation === 'horizontal';
            var currentIndex = findIndex(siblings, function (currentItem) {
              return currentItem.drag === item;
            });
            var siblingAtNewPosition = siblings[newIndex];
            var currentPosition = siblings[currentIndex].clientRect;
            var newPosition = siblingAtNewPosition.clientRect;
            var delta = currentIndex > newIndex ? 1 : -1; // How many pixels the item's placeholder should be offset.

            var itemOffset = this._getItemOffsetPx(currentPosition, newPosition, delta); // How many pixels all the other items should be offset.


            var siblingOffset = this._getSiblingOffsetPx(currentIndex, siblings, delta); // Save the previous order of the items before moving the item to its new index.
            // We use this to check whether an item has been moved as a result of the sorting.


            var oldOrder = siblings.slice(); // Shuffle the array in place.

            moveItemInArray(siblings, currentIndex, newIndex);
            this.sorted.next({
              previousIndex: currentIndex,
              currentIndex: newIndex,
              container: this,
              item: item
            });
            siblings.forEach(function (sibling, index) {
              // Don't do anything if the position hasn't changed.
              if (oldOrder[index] === sibling) {
                return;
              }

              var isDraggedItem = sibling.drag === item;
              var offset = isDraggedItem ? itemOffset : siblingOffset;
              var elementToOffset = isDraggedItem ? item.getPlaceholderElement() : sibling.drag.getRootElement(); // Update the offset to reflect the new position.

              sibling.offset += offset; // Since we're moving the items with a `transform`, we need to adjust their cached
              // client rects to reflect their new position, as well as swap their positions in the cache.
              // Note that we shouldn't use `getBoundingClientRect` here to update the cache, because the
              // elements may be mid-animation which will give us a wrong result.

              if (isHorizontal) {
                // Round the transforms since some browsers will
                // blur the elements, for sub-pixel transforms.
                elementToOffset.style.transform = "translate3d(".concat(Math.round(sibling.offset), "px, 0, 0)");
                adjustClientRect(sibling.clientRect, 0, offset);
              } else {
                elementToOffset.style.transform = "translate3d(0, ".concat(Math.round(sibling.offset), "px, 0)");
                adjustClientRect(sibling.clientRect, offset, 0);
              }
            }); // Note that it's important that we do this after the client rects have been adjusted.

            this._previousSwap.overlaps = isInsideClientRect(newPosition, pointerX, pointerY);
            this._previousSwap.drag = siblingAtNewPosition.drag;
            this._previousSwap.delta = isHorizontal ? pointerDelta.x : pointerDelta.y;
          }
          /**
           * Checks whether the user's pointer is close to the edges of either the
           * viewport or the drop list and starts the auto-scroll sequence.
           * @param pointerX User's pointer position along the x axis.
           * @param pointerY User's pointer position along the y axis.
           */

        }, {
          key: "_startScrollingIfNecessary",
          value: function _startScrollingIfNecessary(pointerX, pointerY) {
            var _this13 = this;

            if (this.autoScrollDisabled) {
              return;
            }

            var scrollNode;
            var verticalScrollDirection = 0
            /* NONE */
            ;
            var horizontalScrollDirection = 0
            /* NONE */
            ; // Check whether we should start scrolling any of the parent containers.

            this._parentPositions.positions.forEach(function (position, element) {
              // We have special handling for the `document` below. Also this would be
              // nicer with a  for...of loop, but it requires changing a compiler flag.
              if (element === _this13._document || !position.clientRect || scrollNode) {
                return;
              }

              if (isPointerNearClientRect(position.clientRect, DROP_PROXIMITY_THRESHOLD, pointerX, pointerY)) {
                var _getElementScrollDire = getElementScrollDirections(element, position.clientRect, pointerX, pointerY);

                var _getElementScrollDire2 = _slicedToArray(_getElementScrollDire, 2);

                verticalScrollDirection = _getElementScrollDire2[0];
                horizontalScrollDirection = _getElementScrollDire2[1];

                if (verticalScrollDirection || horizontalScrollDirection) {
                  scrollNode = element;
                }
              }
            }); // Otherwise check if we can start scrolling the viewport.


            if (!verticalScrollDirection && !horizontalScrollDirection) {
              var _this$_viewportRuler$ = this._viewportRuler.getViewportSize(),
                  width = _this$_viewportRuler$.width,
                  height = _this$_viewportRuler$.height;

              var clientRect = {
                width: width,
                height: height,
                top: 0,
                right: width,
                bottom: height,
                left: 0
              };
              verticalScrollDirection = getVerticalScrollDirection(clientRect, pointerY);
              horizontalScrollDirection = getHorizontalScrollDirection(clientRect, pointerX);
              scrollNode = window;
            }

            if (scrollNode && (verticalScrollDirection !== this._verticalScrollDirection || horizontalScrollDirection !== this._horizontalScrollDirection || scrollNode !== this._scrollNode)) {
              this._verticalScrollDirection = verticalScrollDirection;
              this._horizontalScrollDirection = horizontalScrollDirection;
              this._scrollNode = scrollNode;

              if ((verticalScrollDirection || horizontalScrollDirection) && scrollNode) {
                this._ngZone.runOutsideAngular(this._startScrollInterval);
              } else {
                this._stopScrolling();
              }
            }
          }
          /** Stops any currently-running auto-scroll sequences. */

        }, {
          key: "_stopScrolling",
          value: function _stopScrolling() {
            this._stopScrollTimers.next();
          }
          /** Starts the dragging sequence within the list. */

        }, {
          key: "_draggingStarted",
          value: function _draggingStarted() {
            var styles = Object(_angular_cdk_coercion__WEBPACK_IMPORTED_MODULE_4__["coerceElement"])(this.element).style;
            this.beforeStarted.next();
            this._isDragging = true; // We need to disable scroll snapping while the user is dragging, because it breaks automatic
            // scrolling. The browser seems to round the value based on the snapping points which means
            // that we can't increment/decrement the scroll position.

            this._initialScrollSnap = styles.msScrollSnapType || styles.scrollSnapType || '';
            styles.scrollSnapType = styles.msScrollSnapType = 'none';

            this._cacheItems();

            this._viewportScrollSubscription.unsubscribe();

            this._listenToScrollEvents();
          }
          /** Caches the positions of the configured scrollable parents. */

        }, {
          key: "_cacheParentPositions",
          value: function _cacheParentPositions() {
            var element = Object(_angular_cdk_coercion__WEBPACK_IMPORTED_MODULE_4__["coerceElement"])(this.element);

            this._parentPositions.cache(this._scrollableElements); // The list element is always in the `scrollableElements`
            // so we can take advantage of the cached `ClientRect`.


            this._clientRect = this._parentPositions.positions.get(element).clientRect;
          }
          /** Refreshes the position cache of the items and sibling containers. */

        }, {
          key: "_cacheItemPositions",
          value: function _cacheItemPositions() {
            var isHorizontal = this._orientation === 'horizontal';
            this._itemPositions = this._activeDraggables.map(function (drag) {
              var elementToMeasure = drag.getVisibleElement();
              return {
                drag: drag,
                offset: 0,
                clientRect: getMutableClientRect(elementToMeasure)
              };
            }).sort(function (a, b) {
              return isHorizontal ? a.clientRect.left - b.clientRect.left : a.clientRect.top - b.clientRect.top;
            });
          }
          /** Resets the container to its initial state. */

        }, {
          key: "_reset",
          value: function _reset() {
            var _this14 = this;

            this._isDragging = false;
            var styles = Object(_angular_cdk_coercion__WEBPACK_IMPORTED_MODULE_4__["coerceElement"])(this.element).style;
            styles.scrollSnapType = styles.msScrollSnapType = this._initialScrollSnap; // TODO(crisbeto): may have to wait for the animations to finish.

            this._activeDraggables.forEach(function (item) {
              var rootElement = item.getRootElement();

              if (rootElement) {
                rootElement.style.transform = '';
              }
            });

            this._siblings.forEach(function (sibling) {
              return sibling._stopReceiving(_this14);
            });

            this._activeDraggables = [];
            this._itemPositions = [];
            this._previousSwap.drag = null;
            this._previousSwap.delta = 0;
            this._previousSwap.overlaps = false;

            this._stopScrolling();

            this._viewportScrollSubscription.unsubscribe();

            this._parentPositions.clear();
          }
          /**
           * Gets the offset in pixels by which the items that aren't being dragged should be moved.
           * @param currentIndex Index of the item currently being dragged.
           * @param siblings All of the items in the list.
           * @param delta Direction in which the user is moving.
           */

        }, {
          key: "_getSiblingOffsetPx",
          value: function _getSiblingOffsetPx(currentIndex, siblings, delta) {
            var isHorizontal = this._orientation === 'horizontal';
            var currentPosition = siblings[currentIndex].clientRect;
            var immediateSibling = siblings[currentIndex + delta * -1];
            var siblingOffset = currentPosition[isHorizontal ? 'width' : 'height'] * delta;

            if (immediateSibling) {
              var start = isHorizontal ? 'left' : 'top';
              var end = isHorizontal ? 'right' : 'bottom'; // Get the spacing between the start of the current item and the end of the one immediately
              // after it in the direction in which the user is dragging, or vice versa. We add it to the
              // offset in order to push the element to where it will be when it's inline and is influenced
              // by the `margin` of its siblings.

              if (delta === -1) {
                siblingOffset -= immediateSibling.clientRect[start] - currentPosition[end];
              } else {
                siblingOffset += currentPosition[start] - immediateSibling.clientRect[end];
              }
            }

            return siblingOffset;
          }
          /**
           * Gets the offset in pixels by which the item that is being dragged should be moved.
           * @param currentPosition Current position of the item.
           * @param newPosition Position of the item where the current item should be moved.
           * @param delta Direction in which the user is moving.
           */

        }, {
          key: "_getItemOffsetPx",
          value: function _getItemOffsetPx(currentPosition, newPosition, delta) {
            var isHorizontal = this._orientation === 'horizontal';
            var itemOffset = isHorizontal ? newPosition.left - currentPosition.left : newPosition.top - currentPosition.top; // Account for differences in the item width/height.

            if (delta === -1) {
              itemOffset += isHorizontal ? newPosition.width - currentPosition.width : newPosition.height - currentPosition.height;
            }

            return itemOffset;
          }
          /**
           * Checks if pointer is entering in the first position
           * @param pointerX Position of the user's pointer along the X axis.
           * @param pointerY Position of the user's pointer along the Y axis.
           */

        }, {
          key: "_shouldEnterAsFirstChild",
          value: function _shouldEnterAsFirstChild(pointerX, pointerY) {
            if (!this._activeDraggables.length) {
              return false;
            }

            var itemPositions = this._itemPositions;
            var isHorizontal = this._orientation === 'horizontal'; // `itemPositions` are sorted by position while `activeDraggables` are sorted by child index
            // check if container is using some sort of "reverse" ordering (eg: flex-direction: row-reverse)

            var reversed = itemPositions[0].drag !== this._activeDraggables[0];

            if (reversed) {
              var lastItemRect = itemPositions[itemPositions.length - 1].clientRect;
              return isHorizontal ? pointerX >= lastItemRect.right : pointerY >= lastItemRect.bottom;
            } else {
              var firstItemRect = itemPositions[0].clientRect;
              return isHorizontal ? pointerX <= firstItemRect.left : pointerY <= firstItemRect.top;
            }
          }
          /**
           * Gets the index of an item in the drop container, based on the position of the user's pointer.
           * @param item Item that is being sorted.
           * @param pointerX Position of the user's pointer along the X axis.
           * @param pointerY Position of the user's pointer along the Y axis.
           * @param delta Direction in which the user is moving their pointer.
           */

        }, {
          key: "_getItemIndexFromPointerPosition",
          value: function _getItemIndexFromPointerPosition(item, pointerX, pointerY, delta) {
            var _this15 = this;

            var isHorizontal = this._orientation === 'horizontal';
            var index = findIndex(this._itemPositions, function (_ref4, _, array) {
              var drag = _ref4.drag,
                  clientRect = _ref4.clientRect;

              if (drag === item) {
                // If there's only one item left in the container, it must be
                // the dragged item itself so we use it as a reference.
                return array.length < 2;
              }

              if (delta) {
                var direction = isHorizontal ? delta.x : delta.y; // If the user is still hovering over the same item as last time, their cursor hasn't left
                // the item after we made the swap, and they didn't change the direction in which they're
                // dragging, we don't consider it a direction swap.

                if (drag === _this15._previousSwap.drag && _this15._previousSwap.overlaps && direction === _this15._previousSwap.delta) {
                  return false;
                }
              }

              return isHorizontal ? // Round these down since most browsers report client rects with
              // sub-pixel precision, whereas the pointer coordinates are rounded to pixels.
              pointerX >= Math.floor(clientRect.left) && pointerX < Math.floor(clientRect.right) : pointerY >= Math.floor(clientRect.top) && pointerY < Math.floor(clientRect.bottom);
            });
            return index === -1 || !this.sortPredicate(index, item, this) ? -1 : index;
          }
          /** Caches the current items in the list and their positions. */

        }, {
          key: "_cacheItems",
          value: function _cacheItems() {
            this._activeDraggables = this._draggables.slice();

            this._cacheItemPositions();

            this._cacheParentPositions();
          }
          /**
           * Checks whether the user's pointer is positioned over the container.
           * @param x Pointer position along the X axis.
           * @param y Pointer position along the Y axis.
           */

        }, {
          key: "_isOverContainer",
          value: function _isOverContainer(x, y) {
            return this._clientRect != null && isInsideClientRect(this._clientRect, x, y);
          }
          /**
           * Figures out whether an item should be moved into a sibling
           * drop container, based on its current position.
           * @param item Drag item that is being moved.
           * @param x Position of the item along the X axis.
           * @param y Position of the item along the Y axis.
           */

        }, {
          key: "_getSiblingContainerFromPosition",
          value: function _getSiblingContainerFromPosition(item, x, y) {
            return this._siblings.find(function (sibling) {
              return sibling._canReceive(item, x, y);
            });
          }
          /**
           * Checks whether the drop list can receive the passed-in item.
           * @param item Item that is being dragged into the list.
           * @param x Position of the item along the X axis.
           * @param y Position of the item along the Y axis.
           */

        }, {
          key: "_canReceive",
          value: function _canReceive(item, x, y) {
            if (!this._clientRect || !isInsideClientRect(this._clientRect, x, y) || !this.enterPredicate(item, this)) {
              return false;
            }

            var elementFromPoint = this._getShadowRoot().elementFromPoint(x, y); // If there's no element at the pointer position, then
            // the client rect is probably scrolled out of the view.


            if (!elementFromPoint) {
              return false;
            }

            var nativeElement = Object(_angular_cdk_coercion__WEBPACK_IMPORTED_MODULE_4__["coerceElement"])(this.element); // The `ClientRect`, that we're using to find the container over which the user is
            // hovering, doesn't give us any information on whether the element has been scrolled
            // out of the view or whether it's overlapping with other containers. This means that
            // we could end up transferring the item into a container that's invisible or is positioned
            // below another one. We use the result from `elementFromPoint` to get the top-most element
            // at the pointer position and to find whether it's one of the intersecting drop containers.

            return elementFromPoint === nativeElement || nativeElement.contains(elementFromPoint);
          }
          /**
           * Called by one of the connected drop lists when a dragging sequence has started.
           * @param sibling Sibling in which dragging has started.
           */

        }, {
          key: "_startReceiving",
          value: function _startReceiving(sibling, items) {
            var _this16 = this;

            var activeSiblings = this._activeSiblings;

            if (!activeSiblings.has(sibling) && items.every(function (item) {
              // Note that we have to add an exception to the `enterPredicate` for items that started off
              // in this drop list. The drag ref has logic that allows an item to return to its initial
              // container, if it has left the initial container and none of the connected containers
              // allow it to enter. See `DragRef._updateActiveDropContainer` for more context.
              return _this16.enterPredicate(item, _this16) || _this16._draggables.indexOf(item) > -1;
            })) {
              activeSiblings.add(sibling);

              this._cacheParentPositions();

              this._listenToScrollEvents();
            }
          }
          /**
           * Called by a connected drop list when dragging has stopped.
           * @param sibling Sibling whose dragging has stopped.
           */

        }, {
          key: "_stopReceiving",
          value: function _stopReceiving(sibling) {
            this._activeSiblings["delete"](sibling);

            this._viewportScrollSubscription.unsubscribe();
          }
          /**
           * Starts listening to scroll events on the viewport.
           * Used for updating the internal state of the list.
           */

        }, {
          key: "_listenToScrollEvents",
          value: function _listenToScrollEvents() {
            var _this17 = this;

            this._viewportScrollSubscription = this._dragDropRegistry.scroll.subscribe(function (event) {
              if (_this17.isDragging()) {
                var scrollDifference = _this17._parentPositions.handleScroll(event);

                if (scrollDifference) {
                  // Since we know the amount that the user has scrolled we can shift all of the
                  // client rectangles ourselves. This is cheaper than re-measuring everything and
                  // we can avoid inconsistent behavior where we might be measuring the element before
                  // its position has changed.
                  _this17._itemPositions.forEach(function (_ref5) {
                    var clientRect = _ref5.clientRect;
                    adjustClientRect(clientRect, scrollDifference.top, scrollDifference.left);
                  }); // We need two loops for this, because we want all of the cached
                  // positions to be up-to-date before we re-sort the item.


                  _this17._itemPositions.forEach(function (_ref6) {
                    var drag = _ref6.drag;

                    if (_this17._dragDropRegistry.isDragging(drag)) {
                      // We need to re-sort the item manually, because the pointer move
                      // events won't be dispatched while the user is scrolling.
                      drag._sortFromLastPointerPosition();
                    }
                  });
                }
              } else if (_this17.isReceiving()) {
                _this17._cacheParentPositions();
              }
            });
          }
          /**
           * Lazily resolves and returns the shadow root of the element. We do this in a function, rather
           * than saving it in property directly on init, because we want to resolve it as late as possible
           * in order to ensure that the element has been moved into the shadow DOM. Doing it inside the
           * constructor might be too early if the element is inside of something like `ngFor` or `ngIf`.
           */

        }, {
          key: "_getShadowRoot",
          value: function _getShadowRoot() {
            if (!this._cachedShadowRoot) {
              var shadowRoot = Object(_angular_cdk_platform__WEBPACK_IMPORTED_MODULE_3__["_getShadowRoot"])(Object(_angular_cdk_coercion__WEBPACK_IMPORTED_MODULE_4__["coerceElement"])(this.element));
              this._cachedShadowRoot = shadowRoot || this._document;
            }

            return this._cachedShadowRoot;
          }
          /** Notifies any siblings that may potentially receive the item. */

        }, {
          key: "_notifyReceivingSiblings",
          value: function _notifyReceivingSiblings() {
            var _this18 = this;

            var draggedItems = this._activeDraggables.filter(function (item) {
              return item.isDragging();
            });

            this._siblings.forEach(function (sibling) {
              return sibling._startReceiving(_this18, draggedItems);
            });
          }
        }]);

        return DropListRef;
      }();
      /**
       * Finds the index of an item that matches a predicate function. Used as an equivalent
       * of `Array.prototype.findIndex` which isn't part of the standard Google typings.
       * @param array Array in which to look for matches.
       * @param predicate Function used to determine whether an item is a match.
       */


      function findIndex(array, predicate) {
        for (var i = 0; i < array.length; i++) {
          if (predicate(array[i], i, array)) {
            return i;
          }
        }

        return -1;
      }
      /**
       * Increments the vertical scroll position of a node.
       * @param node Node whose scroll position should change.
       * @param amount Amount of pixels that the `node` should be scrolled.
       */


      function incrementVerticalScroll(node, amount) {
        if (node === window) {
          node.scrollBy(0, amount);
        } else {
          // Ideally we could use `Element.scrollBy` here as well, but IE and Edge don't support it.
          node.scrollTop += amount;
        }
      }
      /**
       * Increments the horizontal scroll position of a node.
       * @param node Node whose scroll position should change.
       * @param amount Amount of pixels that the `node` should be scrolled.
       */


      function incrementHorizontalScroll(node, amount) {
        if (node === window) {
          node.scrollBy(amount, 0);
        } else {
          // Ideally we could use `Element.scrollBy` here as well, but IE and Edge don't support it.
          node.scrollLeft += amount;
        }
      }
      /**
       * Gets whether the vertical auto-scroll direction of a node.
       * @param clientRect Dimensions of the node.
       * @param pointerY Position of the user's pointer along the y axis.
       */


      function getVerticalScrollDirection(clientRect, pointerY) {
        var top = clientRect.top,
            bottom = clientRect.bottom,
            height = clientRect.height;
        var yThreshold = height * SCROLL_PROXIMITY_THRESHOLD;

        if (pointerY >= top - yThreshold && pointerY <= top + yThreshold) {
          return 1
          /* UP */
          ;
        } else if (pointerY >= bottom - yThreshold && pointerY <= bottom + yThreshold) {
          return 2
          /* DOWN */
          ;
        }

        return 0
        /* NONE */
        ;
      }
      /**
       * Gets whether the horizontal auto-scroll direction of a node.
       * @param clientRect Dimensions of the node.
       * @param pointerX Position of the user's pointer along the x axis.
       */


      function getHorizontalScrollDirection(clientRect, pointerX) {
        var left = clientRect.left,
            right = clientRect.right,
            width = clientRect.width;
        var xThreshold = width * SCROLL_PROXIMITY_THRESHOLD;

        if (pointerX >= left - xThreshold && pointerX <= left + xThreshold) {
          return 1
          /* LEFT */
          ;
        } else if (pointerX >= right - xThreshold && pointerX <= right + xThreshold) {
          return 2
          /* RIGHT */
          ;
        }

        return 0
        /* NONE */
        ;
      }
      /**
       * Gets the directions in which an element node should be scrolled,
       * assuming that the user's pointer is already within it scrollable region.
       * @param element Element for which we should calculate the scroll direction.
       * @param clientRect Bounding client rectangle of the element.
       * @param pointerX Position of the user's pointer along the x axis.
       * @param pointerY Position of the user's pointer along the y axis.
       */


      function getElementScrollDirections(element, clientRect, pointerX, pointerY) {
        var computedVertical = getVerticalScrollDirection(clientRect, pointerY);
        var computedHorizontal = getHorizontalScrollDirection(clientRect, pointerX);
        var verticalScrollDirection = 0
        /* NONE */
        ;
        var horizontalScrollDirection = 0
        /* NONE */
        ; // Note that we here we do some extra checks for whether the element is actually scrollable in
        // a certain direction and we only assign the scroll direction if it is. We do this so that we
        // can allow other elements to be scrolled, if the current element can't be scrolled anymore.
        // This allows us to handle cases where the scroll regions of two scrollable elements overlap.

        if (computedVertical) {
          var scrollTop = element.scrollTop;

          if (computedVertical === 1
          /* UP */
          ) {
            if (scrollTop > 0) {
              verticalScrollDirection = 1
              /* UP */
              ;
            }
          } else if (element.scrollHeight - scrollTop > element.clientHeight) {
            verticalScrollDirection = 2
            /* DOWN */
            ;
          }
        }

        if (computedHorizontal) {
          var scrollLeft = element.scrollLeft;

          if (computedHorizontal === 1
          /* LEFT */
          ) {
            if (scrollLeft > 0) {
              horizontalScrollDirection = 1
              /* LEFT */
              ;
            }
          } else if (element.scrollWidth - scrollLeft > element.clientWidth) {
            horizontalScrollDirection = 2
            /* RIGHT */
            ;
          }
        }

        return [verticalScrollDirection, horizontalScrollDirection];
      }
      /**
       * @license
       * Copyright Google LLC All Rights Reserved.
       *
       * Use of this source code is governed by an MIT-style license that can be
       * found in the LICENSE file at https://angular.io/license
       */

      /** Event options that can be used to bind an active, capturing event. */


      var activeCapturingEventOptions = Object(_angular_cdk_platform__WEBPACK_IMPORTED_MODULE_3__["normalizePassiveListenerOptions"])({
        passive: false,
        capture: true
      });
      /**
       * Service that keeps track of all the drag item and drop container
       * instances, and manages global event listeners on the `document`.
       * @docs-private
       */
      // Note: this class is generic, rather than referencing CdkDrag and CdkDropList directly, in order
      // to avoid circular imports. If we were to reference them here, importing the registry into the
      // classes that are registering themselves will introduce a circular import.

      var DragDropRegistry = /*#__PURE__*/function () {
        function DragDropRegistry(_ngZone, _document) {
          var _this19 = this;

          _classCallCheck(this, DragDropRegistry);

          this._ngZone = _ngZone;
          /** Registered drop container instances. */

          this._dropInstances = new Set();
          /** Registered drag item instances. */

          this._dragInstances = new Set();
          /** Drag item instances that are currently being dragged. */

          this._activeDragInstances = [];
          /** Keeps track of the event listeners that we've bound to the `document`. */

          this._globalListeners = new Map();
          /**
           * Predicate function to check if an item is being dragged.  Moved out into a property,
           * because it'll be called a lot and we don't want to create a new function every time.
           */

          this._draggingPredicate = function (item) {
            return item.isDragging();
          };
          /**
           * Emits the `touchmove` or `mousemove` events that are dispatched
           * while the user is dragging a drag item instance.
           */


          this.pointerMove = new rxjs__WEBPACK_IMPORTED_MODULE_5__["Subject"]();
          /**
           * Emits the `touchend` or `mouseup` events that are dispatched
           * while the user is dragging a drag item instance.
           */

          this.pointerUp = new rxjs__WEBPACK_IMPORTED_MODULE_5__["Subject"]();
          /** Emits when the viewport has been scrolled while the user is dragging an item. */

          this.scroll = new rxjs__WEBPACK_IMPORTED_MODULE_5__["Subject"]();
          /**
           * Event listener that will prevent the default browser action while the user is dragging.
           * @param event Event whose default action should be prevented.
           */

          this._preventDefaultWhileDragging = function (event) {
            if (_this19._activeDragInstances.length > 0) {
              event.preventDefault();
            }
          };
          /** Event listener for `touchmove` that is bound even if no dragging is happening. */


          this._persistentTouchmoveListener = function (event) {
            if (_this19._activeDragInstances.length > 0) {
              // Note that we only want to prevent the default action after dragging has actually started.
              // Usually this is the same time at which the item is added to the `_activeDragInstances`,
              // but it could be pushed back if the user has set up a drag delay or threshold.
              if (_this19._activeDragInstances.some(_this19._draggingPredicate)) {
                event.preventDefault();
              }

              _this19.pointerMove.next(event);
            }
          };

          this._document = _document;
        }
        /** Adds a drop container to the registry. */


        _createClass(DragDropRegistry, [{
          key: "registerDropContainer",
          value: function registerDropContainer(drop) {
            if (!this._dropInstances.has(drop)) {
              this._dropInstances.add(drop);
            }
          }
          /** Adds a drag item instance to the registry. */

        }, {
          key: "registerDragItem",
          value: function registerDragItem(drag) {
            var _this20 = this;

            this._dragInstances.add(drag); // The `touchmove` event gets bound once, ahead of time, because WebKit
            // won't preventDefault on a dynamically-added `touchmove` listener.
            // See https://bugs.webkit.org/show_bug.cgi?id=184250.


            if (this._dragInstances.size === 1) {
              this._ngZone.runOutsideAngular(function () {
                // The event handler has to be explicitly active,
                // because newer browsers make it passive by default.
                _this20._document.addEventListener('touchmove', _this20._persistentTouchmoveListener, activeCapturingEventOptions);
              });
            }
          }
          /** Removes a drop container from the registry. */

        }, {
          key: "removeDropContainer",
          value: function removeDropContainer(drop) {
            this._dropInstances["delete"](drop);
          }
          /** Removes a drag item instance from the registry. */

        }, {
          key: "removeDragItem",
          value: function removeDragItem(drag) {
            this._dragInstances["delete"](drag);

            this.stopDragging(drag);

            if (this._dragInstances.size === 0) {
              this._document.removeEventListener('touchmove', this._persistentTouchmoveListener, activeCapturingEventOptions);
            }
          }
          /**
           * Starts the dragging sequence for a drag instance.
           * @param drag Drag instance which is being dragged.
           * @param event Event that initiated the dragging.
           */

        }, {
          key: "startDragging",
          value: function startDragging(drag, event) {
            var _this21 = this;

            // Do not process the same drag twice to avoid memory leaks and redundant listeners
            if (this._activeDragInstances.indexOf(drag) > -1) {
              return;
            }

            this._activeDragInstances.push(drag);

            if (this._activeDragInstances.length === 1) {
              var _isTouchEvent = event.type.startsWith('touch'); // We explicitly bind __active__ listeners here, because newer browsers will default to
              // passive ones for `mousemove` and `touchmove`. The events need to be active, because we
              // use `preventDefault` to prevent the page from scrolling while the user is dragging.


              this._globalListeners.set(_isTouchEvent ? 'touchend' : 'mouseup', {
                handler: function handler(e) {
                  return _this21.pointerUp.next(e);
                },
                options: true
              }).set('scroll', {
                handler: function handler(e) {
                  return _this21.scroll.next(e);
                },
                // Use capturing so that we pick up scroll changes in any scrollable nodes that aren't
                // the document. See https://github.com/angular/components/issues/17144.
                options: true
              }) // Preventing the default action on `mousemove` isn't enough to disable text selection
              // on Safari so we need to prevent the selection event as well. Alternatively this can
              // be done by setting `user-select: none` on the `body`, however it has causes a style
              // recalculation which can be expensive on pages with a lot of elements.
              .set('selectstart', {
                handler: this._preventDefaultWhileDragging,
                options: activeCapturingEventOptions
              }); // We don't have to bind a move event for touch drag sequences, because
              // we already have a persistent global one bound from `registerDragItem`.


              if (!_isTouchEvent) {
                this._globalListeners.set('mousemove', {
                  handler: function handler(e) {
                    return _this21.pointerMove.next(e);
                  },
                  options: activeCapturingEventOptions
                });
              }

              this._ngZone.runOutsideAngular(function () {
                _this21._globalListeners.forEach(function (config, name) {
                  _this21._document.addEventListener(name, config.handler, config.options);
                });
              });
            }
          }
          /** Stops dragging a drag item instance. */

        }, {
          key: "stopDragging",
          value: function stopDragging(drag) {
            var index = this._activeDragInstances.indexOf(drag);

            if (index > -1) {
              this._activeDragInstances.splice(index, 1);

              if (this._activeDragInstances.length === 0) {
                this._clearGlobalListeners();
              }
            }
          }
          /** Gets whether a drag item instance is currently being dragged. */

        }, {
          key: "isDragging",
          value: function isDragging(drag) {
            return this._activeDragInstances.indexOf(drag) > -1;
          }
        }, {
          key: "ngOnDestroy",
          value: function ngOnDestroy() {
            var _this22 = this;

            this._dragInstances.forEach(function (instance) {
              return _this22.removeDragItem(instance);
            });

            this._dropInstances.forEach(function (instance) {
              return _this22.removeDropContainer(instance);
            });

            this._clearGlobalListeners();

            this.pointerMove.complete();
            this.pointerUp.complete();
          }
          /** Clears out the global event listeners from the `document`. */

        }, {
          key: "_clearGlobalListeners",
          value: function _clearGlobalListeners() {
            var _this23 = this;

            this._globalListeners.forEach(function (config, name) {
              _this23._document.removeEventListener(name, config.handler, config.options);
            });

            this._globalListeners.clear();
          }
        }]);

        return DragDropRegistry;
      }();

      DragDropRegistry.ɵfac = function DragDropRegistry_Factory(t) {
        return new (t || DragDropRegistry)(_angular_core__WEBPACK_IMPORTED_MODULE_0__["ɵɵinject"](_angular_core__WEBPACK_IMPORTED_MODULE_0__["NgZone"]), _angular_core__WEBPACK_IMPORTED_MODULE_0__["ɵɵinject"](_angular_common__WEBPACK_IMPORTED_MODULE_1__["DOCUMENT"]));
      };

      DragDropRegistry.ɵprov = Object(_angular_core__WEBPACK_IMPORTED_MODULE_0__["ɵɵdefineInjectable"])({
        factory: function DragDropRegistry_Factory() {
          return new DragDropRegistry(Object(_angular_core__WEBPACK_IMPORTED_MODULE_0__["ɵɵinject"])(_angular_core__WEBPACK_IMPORTED_MODULE_0__["NgZone"]), Object(_angular_core__WEBPACK_IMPORTED_MODULE_0__["ɵɵinject"])(_angular_common__WEBPACK_IMPORTED_MODULE_1__["DOCUMENT"]));
        },
        token: DragDropRegistry,
        providedIn: "root"
      });

      DragDropRegistry.ctorParameters = function () {
        return [{
          type: _angular_core__WEBPACK_IMPORTED_MODULE_0__["NgZone"]
        }, {
          type: undefined,
          decorators: [{
            type: _angular_core__WEBPACK_IMPORTED_MODULE_0__["Inject"],
            args: [_angular_common__WEBPACK_IMPORTED_MODULE_1__["DOCUMENT"]]
          }]
        }];
      };

      (function () {
        (typeof ngDevMode === "undefined" || ngDevMode) && _angular_core__WEBPACK_IMPORTED_MODULE_0__["ɵsetClassMetadata"](DragDropRegistry, [{
          type: _angular_core__WEBPACK_IMPORTED_MODULE_0__["Injectable"],
          args: [{
            providedIn: 'root'
          }]
        }], function () {
          return [{
            type: _angular_core__WEBPACK_IMPORTED_MODULE_0__["NgZone"]
          }, {
            type: undefined,
            decorators: [{
              type: _angular_core__WEBPACK_IMPORTED_MODULE_0__["Inject"],
              args: [_angular_common__WEBPACK_IMPORTED_MODULE_1__["DOCUMENT"]]
            }]
          }];
        }, null);
      })();
      /**
       * @license
       * Copyright Google LLC All Rights Reserved.
       *
       * Use of this source code is governed by an MIT-style license that can be
       * found in the LICENSE file at https://angular.io/license
       */

      /** Default configuration to be used when creating a `DragRef`. */


      var DEFAULT_CONFIG = {
        dragStartThreshold: 5,
        pointerDirectionChangeThreshold: 5
      };
      /**
       * Service that allows for drag-and-drop functionality to be attached to DOM elements.
       */

      var DragDrop = /*#__PURE__*/function () {
        function DragDrop(_document, _ngZone, _viewportRuler, _dragDropRegistry) {
          _classCallCheck(this, DragDrop);

          this._document = _document;
          this._ngZone = _ngZone;
          this._viewportRuler = _viewportRuler;
          this._dragDropRegistry = _dragDropRegistry;
        }
        /**
         * Turns an element into a draggable item.
         * @param element Element to which to attach the dragging functionality.
         * @param config Object used to configure the dragging behavior.
         */


        _createClass(DragDrop, [{
          key: "createDrag",
          value: function createDrag(element) {
            var config = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : DEFAULT_CONFIG;
            return new DragRef(element, config, this._document, this._ngZone, this._viewportRuler, this._dragDropRegistry);
          }
          /**
           * Turns an element into a drop list.
           * @param element Element to which to attach the drop list functionality.
           */

        }, {
          key: "createDropList",
          value: function createDropList(element) {
            return new DropListRef(element, this._dragDropRegistry, this._document, this._ngZone, this._viewportRuler);
          }
        }]);

        return DragDrop;
      }();

      DragDrop.ɵfac = function DragDrop_Factory(t) {
        return new (t || DragDrop)(_angular_core__WEBPACK_IMPORTED_MODULE_0__["ɵɵinject"](_angular_common__WEBPACK_IMPORTED_MODULE_1__["DOCUMENT"]), _angular_core__WEBPACK_IMPORTED_MODULE_0__["ɵɵinject"](_angular_core__WEBPACK_IMPORTED_MODULE_0__["NgZone"]), _angular_core__WEBPACK_IMPORTED_MODULE_0__["ɵɵinject"](_angular_cdk_scrolling__WEBPACK_IMPORTED_MODULE_2__["ViewportRuler"]), _angular_core__WEBPACK_IMPORTED_MODULE_0__["ɵɵinject"](DragDropRegistry));
      };

      DragDrop.ɵprov = Object(_angular_core__WEBPACK_IMPORTED_MODULE_0__["ɵɵdefineInjectable"])({
        factory: function DragDrop_Factory() {
          return new DragDrop(Object(_angular_core__WEBPACK_IMPORTED_MODULE_0__["ɵɵinject"])(_angular_common__WEBPACK_IMPORTED_MODULE_1__["DOCUMENT"]), Object(_angular_core__WEBPACK_IMPORTED_MODULE_0__["ɵɵinject"])(_angular_core__WEBPACK_IMPORTED_MODULE_0__["NgZone"]), Object(_angular_core__WEBPACK_IMPORTED_MODULE_0__["ɵɵinject"])(_angular_cdk_scrolling__WEBPACK_IMPORTED_MODULE_2__["ViewportRuler"]), Object(_angular_core__WEBPACK_IMPORTED_MODULE_0__["ɵɵinject"])(DragDropRegistry));
        },
        token: DragDrop,
        providedIn: "root"
      });

      DragDrop.ctorParameters = function () {
        return [{
          type: undefined,
          decorators: [{
            type: _angular_core__WEBPACK_IMPORTED_MODULE_0__["Inject"],
            args: [_angular_common__WEBPACK_IMPORTED_MODULE_1__["DOCUMENT"]]
          }]
        }, {
          type: _angular_core__WEBPACK_IMPORTED_MODULE_0__["NgZone"]
        }, {
          type: _angular_cdk_scrolling__WEBPACK_IMPORTED_MODULE_2__["ViewportRuler"]
        }, {
          type: DragDropRegistry
        }];
      };

      (function () {
        (typeof ngDevMode === "undefined" || ngDevMode) && _angular_core__WEBPACK_IMPORTED_MODULE_0__["ɵsetClassMetadata"](DragDrop, [{
          type: _angular_core__WEBPACK_IMPORTED_MODULE_0__["Injectable"],
          args: [{
            providedIn: 'root'
          }]
        }], function () {
          return [{
            type: undefined,
            decorators: [{
              type: _angular_core__WEBPACK_IMPORTED_MODULE_0__["Inject"],
              args: [_angular_common__WEBPACK_IMPORTED_MODULE_1__["DOCUMENT"]]
            }]
          }, {
            type: _angular_core__WEBPACK_IMPORTED_MODULE_0__["NgZone"]
          }, {
            type: _angular_cdk_scrolling__WEBPACK_IMPORTED_MODULE_2__["ViewportRuler"]
          }, {
            type: DragDropRegistry
          }];
        }, null);
      })();
      /**
       * @license
       * Copyright Google LLC All Rights Reserved.
       *
       * Use of this source code is governed by an MIT-style license that can be
       * found in the LICENSE file at https://angular.io/license
       */

      /**
       * Injection token that can be used for a `CdkDrag` to provide itself as a parent to the
       * drag-specific child directive (`CdkDragHandle`, `CdkDragPreview` etc.). Used primarily
       * to avoid circular imports.
       * @docs-private
       */


      var CDK_DRAG_PARENT = new _angular_core__WEBPACK_IMPORTED_MODULE_0__["InjectionToken"]('CDK_DRAG_PARENT');
      /**
       * @license
       * Copyright Google LLC All Rights Reserved.
       *
       * Use of this source code is governed by an MIT-style license that can be
       * found in the LICENSE file at https://angular.io/license
       */

      /**
       * @license
       * Copyright Google LLC All Rights Reserved.
       *
       * Use of this source code is governed by an MIT-style license that can be
       * found in the LICENSE file at https://angular.io/license
       */

      /**
       * Injection token that can be used to reference instances of `CdkDropListGroup`. It serves as
       * alternative token to the actual `CdkDropListGroup` class which could cause unnecessary
       * retention of the class and its directive metadata.
       */

      var CDK_DROP_LIST_GROUP = new _angular_core__WEBPACK_IMPORTED_MODULE_0__["InjectionToken"]('CdkDropListGroup');
      /**
       * Declaratively connects sibling `cdkDropList` instances together. All of the `cdkDropList`
       * elements that are placed inside a `cdkDropListGroup` will be connected to each other
       * automatically. Can be used as an alternative to the `cdkDropListConnectedTo` input
       * from `cdkDropList`.
       */

      var CdkDropListGroup = /*#__PURE__*/function () {
        function CdkDropListGroup() {
          _classCallCheck(this, CdkDropListGroup);

          /** Drop lists registered inside the group. */
          this._items = new Set();
          this._disabled = false;
        }
        /** Whether starting a dragging sequence from inside this group is disabled. */


        _createClass(CdkDropListGroup, [{
          key: "disabled",
          get: function get() {
            return this._disabled;
          },
          set: function set(value) {
            this._disabled = Object(_angular_cdk_coercion__WEBPACK_IMPORTED_MODULE_4__["coerceBooleanProperty"])(value);
          }
        }, {
          key: "ngOnDestroy",
          value: function ngOnDestroy() {
            this._items.clear();
          }
        }]);

        return CdkDropListGroup;
      }();

      CdkDropListGroup.ɵfac = function CdkDropListGroup_Factory(t) {
        return new (t || CdkDropListGroup)();
      };

      CdkDropListGroup.ɵdir = _angular_core__WEBPACK_IMPORTED_MODULE_0__["ɵɵdefineDirective"]({
        type: CdkDropListGroup,
        selectors: [["", "cdkDropListGroup", ""]],
        inputs: {
          disabled: ["cdkDropListGroupDisabled", "disabled"]
        },
        exportAs: ["cdkDropListGroup"],
        features: [_angular_core__WEBPACK_IMPORTED_MODULE_0__["ɵɵProvidersFeature"]([{
          provide: CDK_DROP_LIST_GROUP,
          useExisting: CdkDropListGroup
        }])]
      });
      CdkDropListGroup.propDecorators = {
        disabled: [{
          type: _angular_core__WEBPACK_IMPORTED_MODULE_0__["Input"],
          args: ['cdkDropListGroupDisabled']
        }]
      };

      (function () {
        (typeof ngDevMode === "undefined" || ngDevMode) && _angular_core__WEBPACK_IMPORTED_MODULE_0__["ɵsetClassMetadata"](CdkDropListGroup, [{
          type: _angular_core__WEBPACK_IMPORTED_MODULE_0__["Directive"],
          args: [{
            selector: '[cdkDropListGroup]',
            exportAs: 'cdkDropListGroup',
            providers: [{
              provide: CDK_DROP_LIST_GROUP,
              useExisting: CdkDropListGroup
            }]
          }]
        }], function () {
          return [];
        }, {
          disabled: [{
            type: _angular_core__WEBPACK_IMPORTED_MODULE_0__["Input"],
            args: ['cdkDropListGroupDisabled']
          }]
        });
      })();
      /**
       * @license
       * Copyright Google LLC All Rights Reserved.
       *
       * Use of this source code is governed by an MIT-style license that can be
       * found in the LICENSE file at https://angular.io/license
       */

      /**
       * Injection token that can be used to configure the
       * behavior of the drag&drop-related components.
       */


      var CDK_DRAG_CONFIG = new _angular_core__WEBPACK_IMPORTED_MODULE_0__["InjectionToken"]('CDK_DRAG_CONFIG');
      /**
       * @license
       * Copyright Google LLC All Rights Reserved.
       *
       * Use of this source code is governed by an MIT-style license that can be
       * found in the LICENSE file at https://angular.io/license
       */

      /**
       * Asserts that a particular node is an element.
       * @param node Node to be checked.
       * @param name Name to attach to the error message.
       */

      function assertElementNode(node, name) {
        if (node.nodeType !== 1) {
          throw Error("".concat(name, " must be attached to an element node. ") + "Currently attached to \"".concat(node.nodeName, "\"."));
        }
      }
      /**
       * @license
       * Copyright Google LLC All Rights Reserved.
       *
       * Use of this source code is governed by an MIT-style license that can be
       * found in the LICENSE file at https://angular.io/license
       */

      /** Counter used to generate unique ids for drop zones. */


      var _uniqueIdCounter = 0;
      /**
       * Injection token that can be used to reference instances of `CdkDropList`. It serves as
       * alternative token to the actual `CdkDropList` class which could cause unnecessary
       * retention of the class and its directive metadata.
       */

      var CDK_DROP_LIST = new _angular_core__WEBPACK_IMPORTED_MODULE_0__["InjectionToken"]('CdkDropList');
      var ɵ0 = undefined;
      /** Container that wraps a set of draggable items. */

      var CdkDropList = /*#__PURE__*/function () {
        function CdkDropList(
        /** Element that the drop list is attached to. */
        element, dragDrop, _changeDetectorRef, _scrollDispatcher, _dir, _group, config) {
          var _this24 = this;

          _classCallCheck(this, CdkDropList);

          this.element = element;
          this._changeDetectorRef = _changeDetectorRef;
          this._scrollDispatcher = _scrollDispatcher;
          this._dir = _dir;
          this._group = _group;
          /** Emits when the list has been destroyed. */

          this._destroyed = new rxjs__WEBPACK_IMPORTED_MODULE_5__["Subject"]();
          /**
           * Other draggable containers that this container is connected to and into which the
           * container's items can be transferred. Can either be references to other drop containers,
           * or their unique IDs.
           */

          this.connectedTo = [];
          /**
           * Unique ID for the drop zone. Can be used as a reference
           * in the `connectedTo` of another `CdkDropList`.
           */

          this.id = "cdk-drop-list-".concat(_uniqueIdCounter++);
          /**
           * Function that is used to determine whether an item
           * is allowed to be moved into a drop container.
           */

          this.enterPredicate = function () {
            return true;
          };
          /** Functions that is used to determine whether an item can be sorted into a particular index. */


          this.sortPredicate = function () {
            return true;
          };
          /** Emits when the user drops an item inside the container. */


          this.dropped = new _angular_core__WEBPACK_IMPORTED_MODULE_0__["EventEmitter"]();
          /**
           * Emits when the user has moved a new drag item into this container.
           */

          this.entered = new _angular_core__WEBPACK_IMPORTED_MODULE_0__["EventEmitter"]();
          /**
           * Emits when the user removes an item from the container
           * by dragging it into another container.
           */

          this.exited = new _angular_core__WEBPACK_IMPORTED_MODULE_0__["EventEmitter"]();
          /** Emits as the user is swapping items while actively dragging. */

          this.sorted = new _angular_core__WEBPACK_IMPORTED_MODULE_0__["EventEmitter"]();
          /**
           * Keeps track of the items that are registered with this container. Historically we used to
           * do this with a `ContentChildren` query, however queries don't handle transplanted views very
           * well which means that we can't handle cases like dragging the headers of a `mat-table`
           * correctly. What we do instead is to have the items register themselves with the container
           * and then we sort them based on their position in the DOM.
           */

          this._unsortedItems = new Set();

          if (typeof ngDevMode === 'undefined' || ngDevMode) {
            assertElementNode(element.nativeElement, 'cdkDropList');
          }

          this._dropListRef = dragDrop.createDropList(element);
          this._dropListRef.data = this;

          if (config) {
            this._assignDefaults(config);
          }

          this._dropListRef.enterPredicate = function (drag, drop) {
            return _this24.enterPredicate(drag.data, drop.data);
          };

          this._dropListRef.sortPredicate = function (index, drag, drop) {
            return _this24.sortPredicate(index, drag.data, drop.data);
          };

          this._setupInputSyncSubscription(this._dropListRef);

          this._handleEvents(this._dropListRef);

          CdkDropList._dropLists.push(this);

          if (_group) {
            _group._items.add(this);
          }
        }
        /** Whether starting a dragging sequence from this container is disabled. */


        _createClass(CdkDropList, [{
          key: "disabled",
          get: function get() {
            return this._disabled || !!this._group && this._group.disabled;
          },
          set: function set(value) {
            // Usually we sync the directive and ref state right before dragging starts, in order to have
            // a single point of failure and to avoid having to use setters for everything. `disabled` is
            // a special case, because it can prevent the `beforeStarted` event from firing, which can lock
            // the user in a disabled state, so we also need to sync it as it's being set.
            this._dropListRef.disabled = this._disabled = Object(_angular_cdk_coercion__WEBPACK_IMPORTED_MODULE_4__["coerceBooleanProperty"])(value);
          }
          /** Registers an items with the drop list. */

        }, {
          key: "addItem",
          value: function addItem(item) {
            this._unsortedItems.add(item);

            if (this._dropListRef.isDragging()) {
              this._syncItemsWithRef();
            }
          }
          /** Removes an item from the drop list. */

        }, {
          key: "removeItem",
          value: function removeItem(item) {
            this._unsortedItems["delete"](item);

            if (this._dropListRef.isDragging()) {
              this._syncItemsWithRef();
            }
          }
          /** Gets the registered items in the list, sorted by their position in the DOM. */

        }, {
          key: "getSortedItems",
          value: function getSortedItems() {
            return Array.from(this._unsortedItems).sort(function (a, b) {
              var documentPosition = a._dragRef.getVisibleElement().compareDocumentPosition(b._dragRef.getVisibleElement()); // `compareDocumentPosition` returns a bitmask so we have to use a bitwise operator.
              // https://developer.mozilla.org/en-US/docs/Web/API/Node/compareDocumentPosition
              // tslint:disable-next-line:no-bitwise


              return documentPosition & Node.DOCUMENT_POSITION_FOLLOWING ? -1 : 1;
            });
          }
        }, {
          key: "ngOnDestroy",
          value: function ngOnDestroy() {
            var index = CdkDropList._dropLists.indexOf(this);

            if (index > -1) {
              CdkDropList._dropLists.splice(index, 1);
            }

            if (this._group) {
              this._group._items["delete"](this);
            }

            this._unsortedItems.clear();

            this._dropListRef.dispose();

            this._destroyed.next();

            this._destroyed.complete();
          }
          /** Syncs the inputs of the CdkDropList with the options of the underlying DropListRef. */

        }, {
          key: "_setupInputSyncSubscription",
          value: function _setupInputSyncSubscription(ref) {
            var _this25 = this;

            if (this._dir) {
              this._dir.change.pipe(Object(rxjs_operators__WEBPACK_IMPORTED_MODULE_6__["startWith"])(this._dir.value), Object(rxjs_operators__WEBPACK_IMPORTED_MODULE_6__["takeUntil"])(this._destroyed)).subscribe(function (value) {
                return ref.withDirection(value);
              });
            }

            ref.beforeStarted.subscribe(function () {
              var siblings = Object(_angular_cdk_coercion__WEBPACK_IMPORTED_MODULE_4__["coerceArray"])(_this25.connectedTo).map(function (drop) {
                if (typeof drop === 'string') {
                  var correspondingDropList = CdkDropList._dropLists.find(function (list) {
                    return list.id === drop;
                  });

                  if (!correspondingDropList && (typeof ngDevMode === 'undefined' || ngDevMode)) {
                    console.warn("CdkDropList could not find connected drop list with id \"".concat(drop, "\""));
                  }

                  return correspondingDropList;
                }

                return drop;
              });

              if (_this25._group) {
                _this25._group._items.forEach(function (drop) {
                  if (siblings.indexOf(drop) === -1) {
                    siblings.push(drop);
                  }
                });
              } // Note that we resolve the scrollable parents here so that we delay the resolution
              // as long as possible, ensuring that the element is in its final place in the DOM.


              if (!_this25._scrollableParentsResolved) {
                var scrollableParents = _this25._scrollDispatcher.getAncestorScrollContainers(_this25.element).map(function (scrollable) {
                  return scrollable.getElementRef().nativeElement;
                });

                _this25._dropListRef.withScrollableParents(scrollableParents); // Only do this once since it involves traversing the DOM and the parents
                // shouldn't be able to change without the drop list being destroyed.


                _this25._scrollableParentsResolved = true;
              }

              ref.disabled = _this25.disabled;
              ref.lockAxis = _this25.lockAxis;
              ref.sortingDisabled = Object(_angular_cdk_coercion__WEBPACK_IMPORTED_MODULE_4__["coerceBooleanProperty"])(_this25.sortingDisabled);
              ref.autoScrollDisabled = Object(_angular_cdk_coercion__WEBPACK_IMPORTED_MODULE_4__["coerceBooleanProperty"])(_this25.autoScrollDisabled);
              ref.autoScrollStep = Object(_angular_cdk_coercion__WEBPACK_IMPORTED_MODULE_4__["coerceNumberProperty"])(_this25.autoScrollStep, 2);
              ref.connectedTo(siblings.filter(function (drop) {
                return drop && drop !== _this25;
              }).map(function (list) {
                return list._dropListRef;
              })).withOrientation(_this25.orientation);
            });
          }
          /** Handles events from the underlying DropListRef. */

        }, {
          key: "_handleEvents",
          value: function _handleEvents(ref) {
            var _this26 = this;

            ref.beforeStarted.subscribe(function () {
              _this26._syncItemsWithRef();

              _this26._changeDetectorRef.markForCheck();
            });
            ref.entered.subscribe(function (event) {
              _this26.entered.emit({
                container: _this26,
                item: event.item.data,
                currentIndex: event.currentIndex
              });
            });
            ref.exited.subscribe(function (event) {
              _this26.exited.emit({
                container: _this26,
                item: event.item.data
              });

              _this26._changeDetectorRef.markForCheck();
            });
            ref.sorted.subscribe(function (event) {
              _this26.sorted.emit({
                previousIndex: event.previousIndex,
                currentIndex: event.currentIndex,
                container: _this26,
                item: event.item.data
              });
            });
            ref.dropped.subscribe(function (event) {
              _this26.dropped.emit({
                previousIndex: event.previousIndex,
                currentIndex: event.currentIndex,
                previousContainer: event.previousContainer.data,
                container: event.container.data,
                item: event.item.data,
                isPointerOverContainer: event.isPointerOverContainer,
                distance: event.distance
              }); // Mark for check since all of these events run outside of change
              // detection and we're not guaranteed for something else to have triggered it.


              _this26._changeDetectorRef.markForCheck();
            });
          }
          /** Assigns the default input values based on a provided config object. */

        }, {
          key: "_assignDefaults",
          value: function _assignDefaults(config) {
            var lockAxis = config.lockAxis,
                draggingDisabled = config.draggingDisabled,
                sortingDisabled = config.sortingDisabled,
                listAutoScrollDisabled = config.listAutoScrollDisabled,
                listOrientation = config.listOrientation;
            this.disabled = draggingDisabled == null ? false : draggingDisabled;
            this.sortingDisabled = sortingDisabled == null ? false : sortingDisabled;
            this.autoScrollDisabled = listAutoScrollDisabled == null ? false : listAutoScrollDisabled;
            this.orientation = listOrientation || 'vertical';

            if (lockAxis) {
              this.lockAxis = lockAxis;
            }
          }
          /** Syncs up the registered drag items with underlying drop list ref. */

        }, {
          key: "_syncItemsWithRef",
          value: function _syncItemsWithRef() {
            this._dropListRef.withItems(this.getSortedItems().map(function (item) {
              return item._dragRef;
            }));
          }
        }]);

        return CdkDropList;
      }();

      CdkDropList.ɵfac = function CdkDropList_Factory(t) {
        return new (t || CdkDropList)(_angular_core__WEBPACK_IMPORTED_MODULE_0__["ɵɵdirectiveInject"](_angular_core__WEBPACK_IMPORTED_MODULE_0__["ElementRef"]), _angular_core__WEBPACK_IMPORTED_MODULE_0__["ɵɵdirectiveInject"](DragDrop), _angular_core__WEBPACK_IMPORTED_MODULE_0__["ɵɵdirectiveInject"](_angular_core__WEBPACK_IMPORTED_MODULE_0__["ChangeDetectorRef"]), _angular_core__WEBPACK_IMPORTED_MODULE_0__["ɵɵdirectiveInject"](_angular_cdk_scrolling__WEBPACK_IMPORTED_MODULE_2__["ScrollDispatcher"]), _angular_core__WEBPACK_IMPORTED_MODULE_0__["ɵɵdirectiveInject"](_angular_cdk_bidi__WEBPACK_IMPORTED_MODULE_7__["Directionality"], 8), _angular_core__WEBPACK_IMPORTED_MODULE_0__["ɵɵdirectiveInject"](CDK_DROP_LIST_GROUP, 12), _angular_core__WEBPACK_IMPORTED_MODULE_0__["ɵɵdirectiveInject"](CDK_DRAG_CONFIG, 8));
      };

      CdkDropList.ɵdir = _angular_core__WEBPACK_IMPORTED_MODULE_0__["ɵɵdefineDirective"]({
        type: CdkDropList,
        selectors: [["", "cdkDropList", ""], ["cdk-drop-list"]],
        hostAttrs: [1, "cdk-drop-list"],
        hostVars: 7,
        hostBindings: function CdkDropList_HostBindings(rf, ctx) {
          if (rf & 2) {
            _angular_core__WEBPACK_IMPORTED_MODULE_0__["ɵɵattribute"]("id", ctx.id);

            _angular_core__WEBPACK_IMPORTED_MODULE_0__["ɵɵclassProp"]("cdk-drop-list-disabled", ctx.disabled)("cdk-drop-list-dragging", ctx._dropListRef.isDragging())("cdk-drop-list-receiving", ctx._dropListRef.isReceiving());
          }
        },
        inputs: {
          connectedTo: ["cdkDropListConnectedTo", "connectedTo"],
          id: "id",
          enterPredicate: ["cdkDropListEnterPredicate", "enterPredicate"],
          sortPredicate: ["cdkDropListSortPredicate", "sortPredicate"],
          disabled: ["cdkDropListDisabled", "disabled"],
          sortingDisabled: ["cdkDropListSortingDisabled", "sortingDisabled"],
          autoScrollDisabled: ["cdkDropListAutoScrollDisabled", "autoScrollDisabled"],
          orientation: ["cdkDropListOrientation", "orientation"],
          lockAxis: ["cdkDropListLockAxis", "lockAxis"],
          data: ["cdkDropListData", "data"],
          autoScrollStep: ["cdkDropListAutoScrollStep", "autoScrollStep"]
        },
        outputs: {
          dropped: "cdkDropListDropped",
          entered: "cdkDropListEntered",
          exited: "cdkDropListExited",
          sorted: "cdkDropListSorted"
        },
        exportAs: ["cdkDropList"],
        features: [_angular_core__WEBPACK_IMPORTED_MODULE_0__["ɵɵProvidersFeature"]([// Prevent child drop lists from picking up the same group as their parent.
        {
          provide: CDK_DROP_LIST_GROUP,
          useValue: ɵ0
        }, {
          provide: CDK_DROP_LIST,
          useExisting: CdkDropList
        }])]
      });
      /** Keeps track of the drop lists that are currently on the page. */

      CdkDropList._dropLists = [];

      CdkDropList.ctorParameters = function () {
        return [{
          type: _angular_core__WEBPACK_IMPORTED_MODULE_0__["ElementRef"]
        }, {
          type: DragDrop
        }, {
          type: _angular_core__WEBPACK_IMPORTED_MODULE_0__["ChangeDetectorRef"]
        }, {
          type: _angular_cdk_scrolling__WEBPACK_IMPORTED_MODULE_2__["ScrollDispatcher"]
        }, {
          type: _angular_cdk_bidi__WEBPACK_IMPORTED_MODULE_7__["Directionality"],
          decorators: [{
            type: _angular_core__WEBPACK_IMPORTED_MODULE_0__["Optional"]
          }]
        }, {
          type: CdkDropListGroup,
          decorators: [{
            type: _angular_core__WEBPACK_IMPORTED_MODULE_0__["Optional"]
          }, {
            type: _angular_core__WEBPACK_IMPORTED_MODULE_0__["Inject"],
            args: [CDK_DROP_LIST_GROUP]
          }, {
            type: _angular_core__WEBPACK_IMPORTED_MODULE_0__["SkipSelf"]
          }]
        }, {
          type: undefined,
          decorators: [{
            type: _angular_core__WEBPACK_IMPORTED_MODULE_0__["Optional"]
          }, {
            type: _angular_core__WEBPACK_IMPORTED_MODULE_0__["Inject"],
            args: [CDK_DRAG_CONFIG]
          }]
        }];
      };

      CdkDropList.propDecorators = {
        connectedTo: [{
          type: _angular_core__WEBPACK_IMPORTED_MODULE_0__["Input"],
          args: ['cdkDropListConnectedTo']
        }],
        data: [{
          type: _angular_core__WEBPACK_IMPORTED_MODULE_0__["Input"],
          args: ['cdkDropListData']
        }],
        orientation: [{
          type: _angular_core__WEBPACK_IMPORTED_MODULE_0__["Input"],
          args: ['cdkDropListOrientation']
        }],
        id: [{
          type: _angular_core__WEBPACK_IMPORTED_MODULE_0__["Input"]
        }],
        lockAxis: [{
          type: _angular_core__WEBPACK_IMPORTED_MODULE_0__["Input"],
          args: ['cdkDropListLockAxis']
        }],
        disabled: [{
          type: _angular_core__WEBPACK_IMPORTED_MODULE_0__["Input"],
          args: ['cdkDropListDisabled']
        }],
        sortingDisabled: [{
          type: _angular_core__WEBPACK_IMPORTED_MODULE_0__["Input"],
          args: ['cdkDropListSortingDisabled']
        }],
        enterPredicate: [{
          type: _angular_core__WEBPACK_IMPORTED_MODULE_0__["Input"],
          args: ['cdkDropListEnterPredicate']
        }],
        sortPredicate: [{
          type: _angular_core__WEBPACK_IMPORTED_MODULE_0__["Input"],
          args: ['cdkDropListSortPredicate']
        }],
        autoScrollDisabled: [{
          type: _angular_core__WEBPACK_IMPORTED_MODULE_0__["Input"],
          args: ['cdkDropListAutoScrollDisabled']
        }],
        autoScrollStep: [{
          type: _angular_core__WEBPACK_IMPORTED_MODULE_0__["Input"],
          args: ['cdkDropListAutoScrollStep']
        }],
        dropped: [{
          type: _angular_core__WEBPACK_IMPORTED_MODULE_0__["Output"],
          args: ['cdkDropListDropped']
        }],
        entered: [{
          type: _angular_core__WEBPACK_IMPORTED_MODULE_0__["Output"],
          args: ['cdkDropListEntered']
        }],
        exited: [{
          type: _angular_core__WEBPACK_IMPORTED_MODULE_0__["Output"],
          args: ['cdkDropListExited']
        }],
        sorted: [{
          type: _angular_core__WEBPACK_IMPORTED_MODULE_0__["Output"],
          args: ['cdkDropListSorted']
        }]
      };

      (function () {
        (typeof ngDevMode === "undefined" || ngDevMode) && _angular_core__WEBPACK_IMPORTED_MODULE_0__["ɵsetClassMetadata"](CdkDropList, [{
          type: _angular_core__WEBPACK_IMPORTED_MODULE_0__["Directive"],
          args: [{
            selector: '[cdkDropList], cdk-drop-list',
            exportAs: 'cdkDropList',
            providers: [// Prevent child drop lists from picking up the same group as their parent.
            {
              provide: CDK_DROP_LIST_GROUP,
              useValue: ɵ0
            }, {
              provide: CDK_DROP_LIST,
              useExisting: CdkDropList
            }],
            host: {
              'class': 'cdk-drop-list',
              '[attr.id]': 'id',
              '[class.cdk-drop-list-disabled]': 'disabled',
              '[class.cdk-drop-list-dragging]': '_dropListRef.isDragging()',
              '[class.cdk-drop-list-receiving]': '_dropListRef.isReceiving()'
            }
          }]
        }], function () {
          return [{
            type: _angular_core__WEBPACK_IMPORTED_MODULE_0__["ElementRef"]
          }, {
            type: DragDrop
          }, {
            type: _angular_core__WEBPACK_IMPORTED_MODULE_0__["ChangeDetectorRef"]
          }, {
            type: _angular_cdk_scrolling__WEBPACK_IMPORTED_MODULE_2__["ScrollDispatcher"]
          }, {
            type: _angular_cdk_bidi__WEBPACK_IMPORTED_MODULE_7__["Directionality"],
            decorators: [{
              type: _angular_core__WEBPACK_IMPORTED_MODULE_0__["Optional"]
            }]
          }, {
            type: CdkDropListGroup,
            decorators: [{
              type: _angular_core__WEBPACK_IMPORTED_MODULE_0__["Optional"]
            }, {
              type: _angular_core__WEBPACK_IMPORTED_MODULE_0__["Inject"],
              args: [CDK_DROP_LIST_GROUP]
            }, {
              type: _angular_core__WEBPACK_IMPORTED_MODULE_0__["SkipSelf"]
            }]
          }, {
            type: undefined,
            decorators: [{
              type: _angular_core__WEBPACK_IMPORTED_MODULE_0__["Optional"]
            }, {
              type: _angular_core__WEBPACK_IMPORTED_MODULE_0__["Inject"],
              args: [CDK_DRAG_CONFIG]
            }]
          }];
        }, {
          connectedTo: [{
            type: _angular_core__WEBPACK_IMPORTED_MODULE_0__["Input"],
            args: ['cdkDropListConnectedTo']
          }],
          id: [{
            type: _angular_core__WEBPACK_IMPORTED_MODULE_0__["Input"]
          }],
          enterPredicate: [{
            type: _angular_core__WEBPACK_IMPORTED_MODULE_0__["Input"],
            args: ['cdkDropListEnterPredicate']
          }],
          sortPredicate: [{
            type: _angular_core__WEBPACK_IMPORTED_MODULE_0__["Input"],
            args: ['cdkDropListSortPredicate']
          }],
          dropped: [{
            type: _angular_core__WEBPACK_IMPORTED_MODULE_0__["Output"],
            args: ['cdkDropListDropped']
          }],
          entered: [{
            type: _angular_core__WEBPACK_IMPORTED_MODULE_0__["Output"],
            args: ['cdkDropListEntered']
          }],
          exited: [{
            type: _angular_core__WEBPACK_IMPORTED_MODULE_0__["Output"],
            args: ['cdkDropListExited']
          }],
          sorted: [{
            type: _angular_core__WEBPACK_IMPORTED_MODULE_0__["Output"],
            args: ['cdkDropListSorted']
          }],
          disabled: [{
            type: _angular_core__WEBPACK_IMPORTED_MODULE_0__["Input"],
            args: ['cdkDropListDisabled']
          }],
          sortingDisabled: [{
            type: _angular_core__WEBPACK_IMPORTED_MODULE_0__["Input"],
            args: ['cdkDropListSortingDisabled']
          }],
          autoScrollDisabled: [{
            type: _angular_core__WEBPACK_IMPORTED_MODULE_0__["Input"],
            args: ['cdkDropListAutoScrollDisabled']
          }],
          orientation: [{
            type: _angular_core__WEBPACK_IMPORTED_MODULE_0__["Input"],
            args: ['cdkDropListOrientation']
          }],
          lockAxis: [{
            type: _angular_core__WEBPACK_IMPORTED_MODULE_0__["Input"],
            args: ['cdkDropListLockAxis']
          }],
          data: [{
            type: _angular_core__WEBPACK_IMPORTED_MODULE_0__["Input"],
            args: ['cdkDropListData']
          }],
          autoScrollStep: [{
            type: _angular_core__WEBPACK_IMPORTED_MODULE_0__["Input"],
            args: ['cdkDropListAutoScrollStep']
          }]
        });
      })();
      /**
       * @license
       * Copyright Google LLC All Rights Reserved.
       *
       * Use of this source code is governed by an MIT-style license that can be
       * found in the LICENSE file at https://angular.io/license
       */

      /**
       * Injection token that can be used to reference instances of `CdkDragHandle`. It serves as
       * alternative token to the actual `CdkDragHandle` class which could cause unnecessary
       * retention of the class and its directive metadata.
       */


      var CDK_DRAG_HANDLE = new _angular_core__WEBPACK_IMPORTED_MODULE_0__["InjectionToken"]('CdkDragHandle');
      /** Handle that can be used to drag a CdkDrag instance. */

      var CdkDragHandle = /*#__PURE__*/function () {
        function CdkDragHandle(element, parentDrag) {
          _classCallCheck(this, CdkDragHandle);

          this.element = element;
          /** Emits when the state of the handle has changed. */

          this._stateChanges = new rxjs__WEBPACK_IMPORTED_MODULE_5__["Subject"]();
          this._disabled = false;

          if (typeof ngDevMode === 'undefined' || ngDevMode) {
            assertElementNode(element.nativeElement, 'cdkDragHandle');
          }

          this._parentDrag = parentDrag;
        }
        /** Whether starting to drag through this handle is disabled. */


        _createClass(CdkDragHandle, [{
          key: "disabled",
          get: function get() {
            return this._disabled;
          },
          set: function set(value) {
            this._disabled = Object(_angular_cdk_coercion__WEBPACK_IMPORTED_MODULE_4__["coerceBooleanProperty"])(value);

            this._stateChanges.next(this);
          }
        }, {
          key: "ngOnDestroy",
          value: function ngOnDestroy() {
            this._stateChanges.complete();
          }
        }]);

        return CdkDragHandle;
      }();

      CdkDragHandle.ɵfac = function CdkDragHandle_Factory(t) {
        return new (t || CdkDragHandle)(_angular_core__WEBPACK_IMPORTED_MODULE_0__["ɵɵdirectiveInject"](_angular_core__WEBPACK_IMPORTED_MODULE_0__["ElementRef"]), _angular_core__WEBPACK_IMPORTED_MODULE_0__["ɵɵdirectiveInject"](CDK_DRAG_PARENT, 12));
      };

      CdkDragHandle.ɵdir = _angular_core__WEBPACK_IMPORTED_MODULE_0__["ɵɵdefineDirective"]({
        type: CdkDragHandle,
        selectors: [["", "cdkDragHandle", ""]],
        hostAttrs: [1, "cdk-drag-handle"],
        inputs: {
          disabled: ["cdkDragHandleDisabled", "disabled"]
        },
        features: [_angular_core__WEBPACK_IMPORTED_MODULE_0__["ɵɵProvidersFeature"]([{
          provide: CDK_DRAG_HANDLE,
          useExisting: CdkDragHandle
        }])]
      });

      CdkDragHandle.ctorParameters = function () {
        return [{
          type: _angular_core__WEBPACK_IMPORTED_MODULE_0__["ElementRef"]
        }, {
          type: undefined,
          decorators: [{
            type: _angular_core__WEBPACK_IMPORTED_MODULE_0__["Inject"],
            args: [CDK_DRAG_PARENT]
          }, {
            type: _angular_core__WEBPACK_IMPORTED_MODULE_0__["Optional"]
          }, {
            type: _angular_core__WEBPACK_IMPORTED_MODULE_0__["SkipSelf"]
          }]
        }];
      };

      CdkDragHandle.propDecorators = {
        disabled: [{
          type: _angular_core__WEBPACK_IMPORTED_MODULE_0__["Input"],
          args: ['cdkDragHandleDisabled']
        }]
      };

      (function () {
        (typeof ngDevMode === "undefined" || ngDevMode) && _angular_core__WEBPACK_IMPORTED_MODULE_0__["ɵsetClassMetadata"](CdkDragHandle, [{
          type: _angular_core__WEBPACK_IMPORTED_MODULE_0__["Directive"],
          args: [{
            selector: '[cdkDragHandle]',
            host: {
              'class': 'cdk-drag-handle'
            },
            providers: [{
              provide: CDK_DRAG_HANDLE,
              useExisting: CdkDragHandle
            }]
          }]
        }], function () {
          return [{
            type: _angular_core__WEBPACK_IMPORTED_MODULE_0__["ElementRef"]
          }, {
            type: undefined,
            decorators: [{
              type: _angular_core__WEBPACK_IMPORTED_MODULE_0__["Inject"],
              args: [CDK_DRAG_PARENT]
            }, {
              type: _angular_core__WEBPACK_IMPORTED_MODULE_0__["Optional"]
            }, {
              type: _angular_core__WEBPACK_IMPORTED_MODULE_0__["SkipSelf"]
            }]
          }];
        }, {
          disabled: [{
            type: _angular_core__WEBPACK_IMPORTED_MODULE_0__["Input"],
            args: ['cdkDragHandleDisabled']
          }]
        });
      })();
      /**
       * @license
       * Copyright Google LLC All Rights Reserved.
       *
       * Use of this source code is governed by an MIT-style license that can be
       * found in the LICENSE file at https://angular.io/license
       */

      /**
       * Injection token that can be used to reference instances of `CdkDragPlaceholder`. It serves as
       * alternative token to the actual `CdkDragPlaceholder` class which could cause unnecessary
       * retention of the class and its directive metadata.
       */


      var CDK_DRAG_PLACEHOLDER = new _angular_core__WEBPACK_IMPORTED_MODULE_0__["InjectionToken"]('CdkDragPlaceholder');
      /**
       * Element that will be used as a template for the placeholder of a CdkDrag when
       * it is being dragged. The placeholder is displayed in place of the element being dragged.
       */

      var CdkDragPlaceholder = function CdkDragPlaceholder(templateRef) {
        _classCallCheck(this, CdkDragPlaceholder);

        this.templateRef = templateRef;
      };

      CdkDragPlaceholder.ɵfac = function CdkDragPlaceholder_Factory(t) {
        return new (t || CdkDragPlaceholder)(_angular_core__WEBPACK_IMPORTED_MODULE_0__["ɵɵdirectiveInject"](_angular_core__WEBPACK_IMPORTED_MODULE_0__["TemplateRef"]));
      };

      CdkDragPlaceholder.ɵdir = _angular_core__WEBPACK_IMPORTED_MODULE_0__["ɵɵdefineDirective"]({
        type: CdkDragPlaceholder,
        selectors: [["ng-template", "cdkDragPlaceholder", ""]],
        inputs: {
          data: "data"
        },
        features: [_angular_core__WEBPACK_IMPORTED_MODULE_0__["ɵɵProvidersFeature"]([{
          provide: CDK_DRAG_PLACEHOLDER,
          useExisting: CdkDragPlaceholder
        }])]
      });

      CdkDragPlaceholder.ctorParameters = function () {
        return [{
          type: _angular_core__WEBPACK_IMPORTED_MODULE_0__["TemplateRef"]
        }];
      };

      CdkDragPlaceholder.propDecorators = {
        data: [{
          type: _angular_core__WEBPACK_IMPORTED_MODULE_0__["Input"]
        }]
      };

      (function () {
        (typeof ngDevMode === "undefined" || ngDevMode) && _angular_core__WEBPACK_IMPORTED_MODULE_0__["ɵsetClassMetadata"](CdkDragPlaceholder, [{
          type: _angular_core__WEBPACK_IMPORTED_MODULE_0__["Directive"],
          args: [{
            selector: 'ng-template[cdkDragPlaceholder]',
            providers: [{
              provide: CDK_DRAG_PLACEHOLDER,
              useExisting: CdkDragPlaceholder
            }]
          }]
        }], function () {
          return [{
            type: _angular_core__WEBPACK_IMPORTED_MODULE_0__["TemplateRef"]
          }];
        }, {
          data: [{
            type: _angular_core__WEBPACK_IMPORTED_MODULE_0__["Input"]
          }]
        });
      })();
      /**
       * @license
       * Copyright Google LLC All Rights Reserved.
       *
       * Use of this source code is governed by an MIT-style license that can be
       * found in the LICENSE file at https://angular.io/license
       */

      /**
       * Injection token that can be used to reference instances of `CdkDragPreview`. It serves as
       * alternative token to the actual `CdkDragPreview` class which could cause unnecessary
       * retention of the class and its directive metadata.
       */


      var CDK_DRAG_PREVIEW = new _angular_core__WEBPACK_IMPORTED_MODULE_0__["InjectionToken"]('CdkDragPreview');
      /**
       * Element that will be used as a template for the preview
       * of a CdkDrag when it is being dragged.
       */

      var CdkDragPreview = /*#__PURE__*/function () {
        function CdkDragPreview(templateRef) {
          _classCallCheck(this, CdkDragPreview);

          this.templateRef = templateRef;
          this._matchSize = false;
        }
        /** Whether the preview should preserve the same size as the item that is being dragged. */


        _createClass(CdkDragPreview, [{
          key: "matchSize",
          get: function get() {
            return this._matchSize;
          },
          set: function set(value) {
            this._matchSize = Object(_angular_cdk_coercion__WEBPACK_IMPORTED_MODULE_4__["coerceBooleanProperty"])(value);
          }
        }]);

        return CdkDragPreview;
      }();

      CdkDragPreview.ɵfac = function CdkDragPreview_Factory(t) {
        return new (t || CdkDragPreview)(_angular_core__WEBPACK_IMPORTED_MODULE_0__["ɵɵdirectiveInject"](_angular_core__WEBPACK_IMPORTED_MODULE_0__["TemplateRef"]));
      };

      CdkDragPreview.ɵdir = _angular_core__WEBPACK_IMPORTED_MODULE_0__["ɵɵdefineDirective"]({
        type: CdkDragPreview,
        selectors: [["ng-template", "cdkDragPreview", ""]],
        inputs: {
          matchSize: "matchSize",
          data: "data"
        },
        features: [_angular_core__WEBPACK_IMPORTED_MODULE_0__["ɵɵProvidersFeature"]([{
          provide: CDK_DRAG_PREVIEW,
          useExisting: CdkDragPreview
        }])]
      });

      CdkDragPreview.ctorParameters = function () {
        return [{
          type: _angular_core__WEBPACK_IMPORTED_MODULE_0__["TemplateRef"]
        }];
      };

      CdkDragPreview.propDecorators = {
        data: [{
          type: _angular_core__WEBPACK_IMPORTED_MODULE_0__["Input"]
        }],
        matchSize: [{
          type: _angular_core__WEBPACK_IMPORTED_MODULE_0__["Input"]
        }]
      };

      (function () {
        (typeof ngDevMode === "undefined" || ngDevMode) && _angular_core__WEBPACK_IMPORTED_MODULE_0__["ɵsetClassMetadata"](CdkDragPreview, [{
          type: _angular_core__WEBPACK_IMPORTED_MODULE_0__["Directive"],
          args: [{
            selector: 'ng-template[cdkDragPreview]',
            providers: [{
              provide: CDK_DRAG_PREVIEW,
              useExisting: CdkDragPreview
            }]
          }]
        }], function () {
          return [{
            type: _angular_core__WEBPACK_IMPORTED_MODULE_0__["TemplateRef"]
          }];
        }, {
          matchSize: [{
            type: _angular_core__WEBPACK_IMPORTED_MODULE_0__["Input"]
          }],
          data: [{
            type: _angular_core__WEBPACK_IMPORTED_MODULE_0__["Input"]
          }]
        });
      })();
      /**
       * @license
       * Copyright Google LLC All Rights Reserved.
       *
       * Use of this source code is governed by an MIT-style license that can be
       * found in the LICENSE file at https://angular.io/license
       */


      var DRAG_HOST_CLASS = 'cdk-drag';
      /** Element that can be moved inside a CdkDropList container. */

      var CdkDrag = /*#__PURE__*/function () {
        function CdkDrag(
        /** Element that the draggable is attached to. */
        element,
        /** Droppable container that the draggable is a part of. */
        dropContainer,
        /**
         * @deprecated `_document` parameter no longer being used and will be removed.
         * @breaking-change 12.0.0
         */
        _document, _ngZone, _viewContainerRef, config, _dir, dragDrop, _changeDetectorRef, _selfHandle, _parentDrag) {
          var _this27 = this;

          _classCallCheck(this, CdkDrag);

          this.element = element;
          this.dropContainer = dropContainer;
          this._ngZone = _ngZone;
          this._viewContainerRef = _viewContainerRef;
          this._dir = _dir;
          this._changeDetectorRef = _changeDetectorRef;
          this._selfHandle = _selfHandle;
          this._parentDrag = _parentDrag;
          this._destroyed = new rxjs__WEBPACK_IMPORTED_MODULE_5__["Subject"]();
          /** Emits when the user starts dragging the item. */

          this.started = new _angular_core__WEBPACK_IMPORTED_MODULE_0__["EventEmitter"]();
          /** Emits when the user has released a drag item, before any animations have started. */

          this.released = new _angular_core__WEBPACK_IMPORTED_MODULE_0__["EventEmitter"]();
          /** Emits when the user stops dragging an item in the container. */

          this.ended = new _angular_core__WEBPACK_IMPORTED_MODULE_0__["EventEmitter"]();
          /** Emits when the user has moved the item into a new container. */

          this.entered = new _angular_core__WEBPACK_IMPORTED_MODULE_0__["EventEmitter"]();
          /** Emits when the user removes the item its container by dragging it into another container. */

          this.exited = new _angular_core__WEBPACK_IMPORTED_MODULE_0__["EventEmitter"]();
          /** Emits when the user drops the item inside a container. */

          this.dropped = new _angular_core__WEBPACK_IMPORTED_MODULE_0__["EventEmitter"]();
          /**
           * Emits as the user is dragging the item. Use with caution,
           * because this event will fire for every pixel that the user has dragged.
           */

          this.moved = new rxjs__WEBPACK_IMPORTED_MODULE_5__["Observable"](function (observer) {
            var subscription = _this27._dragRef.moved.pipe(Object(rxjs_operators__WEBPACK_IMPORTED_MODULE_6__["map"])(function (movedEvent) {
              return {
                source: _this27,
                pointerPosition: movedEvent.pointerPosition,
                event: movedEvent.event,
                delta: movedEvent.delta,
                distance: movedEvent.distance
              };
            })).subscribe(observer);

            return function () {
              subscription.unsubscribe();
            };
          });
          this._dragRef = dragDrop.createDrag(element, {
            dragStartThreshold: config && config.dragStartThreshold != null ? config.dragStartThreshold : 5,
            pointerDirectionChangeThreshold: config && config.pointerDirectionChangeThreshold != null ? config.pointerDirectionChangeThreshold : 5,
            zIndex: config === null || config === void 0 ? void 0 : config.zIndex
          });
          this._dragRef.data = this; // We have to keep track of the drag instances in order to be able to match an element to
          // a drag instance. We can't go through the global registry of `DragRef`, because the root
          // element could be different.

          CdkDrag._dragInstances.push(this);

          if (config) {
            this._assignDefaults(config);
          } // Note that usually the container is assigned when the drop list is picks up the item, but in
          // some cases (mainly transplanted views with OnPush, see #18341) we may end up in a situation
          // where there are no items on the first change detection pass, but the items get picked up as
          // soon as the user triggers another pass by dragging. This is a problem, because the item would
          // have to switch from standalone mode to drag mode in the middle of the dragging sequence which
          // is too late since the two modes save different kinds of information. We work around it by
          // assigning the drop container both from here and the list.


          if (dropContainer) {
            this._dragRef._withDropContainer(dropContainer._dropListRef);

            dropContainer.addItem(this);
          }

          this._syncInputs(this._dragRef);

          this._handleEvents(this._dragRef);
        }
        /** Whether starting to drag this element is disabled. */


        _createClass(CdkDrag, [{
          key: "disabled",
          get: function get() {
            return this._disabled || this.dropContainer && this.dropContainer.disabled;
          },
          set: function set(value) {
            this._disabled = Object(_angular_cdk_coercion__WEBPACK_IMPORTED_MODULE_4__["coerceBooleanProperty"])(value);
            this._dragRef.disabled = this._disabled;
          }
          /**
           * Returns the element that is being used as a placeholder
           * while the current element is being dragged.
           */

        }, {
          key: "getPlaceholderElement",
          value: function getPlaceholderElement() {
            return this._dragRef.getPlaceholderElement();
          }
          /** Returns the root draggable element. */

        }, {
          key: "getRootElement",
          value: function getRootElement() {
            return this._dragRef.getRootElement();
          }
          /** Resets a standalone drag item to its initial position. */

        }, {
          key: "reset",
          value: function reset() {
            this._dragRef.reset();
          }
          /**
           * Gets the pixel coordinates of the draggable outside of a drop container.
           */

        }, {
          key: "getFreeDragPosition",
          value: function getFreeDragPosition() {
            return this._dragRef.getFreeDragPosition();
          }
        }, {
          key: "ngAfterViewInit",
          value: function ngAfterViewInit() {
            var _this28 = this;

            // We need to wait for the zone to stabilize, in order for the reference
            // element to be in the proper place in the DOM. This is mostly relevant
            // for draggable elements inside portals since they get stamped out in
            // their original DOM position and then they get transferred to the portal.
            this._ngZone.onStable.pipe(Object(rxjs_operators__WEBPACK_IMPORTED_MODULE_6__["take"])(1), Object(rxjs_operators__WEBPACK_IMPORTED_MODULE_6__["takeUntil"])(this._destroyed)).subscribe(function () {
              _this28._updateRootElement(); // Listen for any newly-added handles.


              _this28._handles.changes.pipe(Object(rxjs_operators__WEBPACK_IMPORTED_MODULE_6__["startWith"])(_this28._handles), // Sync the new handles with the DragRef.
              Object(rxjs_operators__WEBPACK_IMPORTED_MODULE_6__["tap"])(function (handles) {
                var childHandleElements = handles.filter(function (handle) {
                  return handle._parentDrag === _this28;
                }).map(function (handle) {
                  return handle.element;
                }); // Usually handles are only allowed to be a descendant of the drag element, but if
                // the consumer defined a different drag root, we should allow the drag element
                // itself to be a handle too.

                if (_this28._selfHandle && _this28.rootElementSelector) {
                  childHandleElements.push(_this28.element);
                }

                _this28._dragRef.withHandles(childHandleElements);
              }), // Listen if the state of any of the handles changes.
              Object(rxjs_operators__WEBPACK_IMPORTED_MODULE_6__["switchMap"])(function (handles) {
                return Object(rxjs__WEBPACK_IMPORTED_MODULE_5__["merge"]).apply(void 0, _toConsumableArray(handles.map(function (item) {
                  return item._stateChanges.pipe(Object(rxjs_operators__WEBPACK_IMPORTED_MODULE_6__["startWith"])(item));
                })));
              }), Object(rxjs_operators__WEBPACK_IMPORTED_MODULE_6__["takeUntil"])(_this28._destroyed)).subscribe(function (handleInstance) {
                // Enabled/disable the handle that changed in the DragRef.
                var dragRef = _this28._dragRef;
                var handle = handleInstance.element.nativeElement;
                handleInstance.disabled ? dragRef.disableHandle(handle) : dragRef.enableHandle(handle);
              });

              if (_this28.freeDragPosition) {
                _this28._dragRef.setFreeDragPosition(_this28.freeDragPosition);
              }
            });
          }
        }, {
          key: "ngOnChanges",
          value: function ngOnChanges(changes) {
            var rootSelectorChange = changes['rootElementSelector'];
            var positionChange = changes['freeDragPosition']; // We don't have to react to the first change since it's being
            // handled in `ngAfterViewInit` where it needs to be deferred.

            if (rootSelectorChange && !rootSelectorChange.firstChange) {
              this._updateRootElement();
            } // Skip the first change since it's being handled in `ngAfterViewInit`.


            if (positionChange && !positionChange.firstChange && this.freeDragPosition) {
              this._dragRef.setFreeDragPosition(this.freeDragPosition);
            }
          }
        }, {
          key: "ngOnDestroy",
          value: function ngOnDestroy() {
            if (this.dropContainer) {
              this.dropContainer.removeItem(this);
            }

            var index = CdkDrag._dragInstances.indexOf(this);

            if (index > -1) {
              CdkDrag._dragInstances.splice(index, 1);
            }

            this._destroyed.next();

            this._destroyed.complete();

            this._dragRef.dispose();
          }
          /** Syncs the root element with the `DragRef`. */

        }, {
          key: "_updateRootElement",
          value: function _updateRootElement() {
            var element = this.element.nativeElement;
            var rootElement = this.rootElementSelector ? getClosestMatchingAncestor(element, this.rootElementSelector) : element;

            if (rootElement && (typeof ngDevMode === 'undefined' || ngDevMode)) {
              assertElementNode(rootElement, 'cdkDrag');
            }

            this._dragRef.withRootElement(rootElement || element);
          }
          /** Gets the boundary element, based on the `boundaryElement` value. */

        }, {
          key: "_getBoundaryElement",
          value: function _getBoundaryElement() {
            var boundary = this.boundaryElement;

            if (!boundary) {
              return null;
            }

            if (typeof boundary === 'string') {
              return getClosestMatchingAncestor(this.element.nativeElement, boundary);
            }

            var element = Object(_angular_cdk_coercion__WEBPACK_IMPORTED_MODULE_4__["coerceElement"])(boundary);

            if ((typeof ngDevMode === 'undefined' || ngDevMode) && !element.contains(this.element.nativeElement)) {
              throw Error('Draggable element is not inside of the node passed into cdkDragBoundary.');
            }

            return element;
          }
          /** Syncs the inputs of the CdkDrag with the options of the underlying DragRef. */

        }, {
          key: "_syncInputs",
          value: function _syncInputs(ref) {
            var _this29 = this;

            ref.beforeStarted.subscribe(function () {
              if (!ref.isDragging()) {
                var dir = _this29._dir;
                var dragStartDelay = _this29.dragStartDelay;
                var placeholder = _this29._placeholderTemplate ? {
                  template: _this29._placeholderTemplate.templateRef,
                  context: _this29._placeholderTemplate.data,
                  viewContainer: _this29._viewContainerRef
                } : null;
                var preview = _this29._previewTemplate ? {
                  template: _this29._previewTemplate.templateRef,
                  context: _this29._previewTemplate.data,
                  matchSize: _this29._previewTemplate.matchSize,
                  viewContainer: _this29._viewContainerRef
                } : null;
                ref.disabled = _this29.disabled;
                ref.lockAxis = _this29.lockAxis;
                ref.dragStartDelay = typeof dragStartDelay === 'object' && dragStartDelay ? dragStartDelay : Object(_angular_cdk_coercion__WEBPACK_IMPORTED_MODULE_4__["coerceNumberProperty"])(dragStartDelay);
                ref.constrainPosition = _this29.constrainPosition;
                ref.previewClass = _this29.previewClass;
                ref.withBoundaryElement(_this29._getBoundaryElement()).withPlaceholderTemplate(placeholder).withPreviewTemplate(preview);

                if (dir) {
                  ref.withDirection(dir.value);
                }
              }
            }); // This only needs to be resolved once.

            ref.beforeStarted.pipe(Object(rxjs_operators__WEBPACK_IMPORTED_MODULE_6__["take"])(1)).subscribe(function () {
              var _a, _b; // If we managed to resolve a parent through DI, use it.


              if (_this29._parentDrag) {
                ref.withParent(_this29._parentDrag._dragRef);
                return;
              } // Otherwise fall back to resolving the parent by looking up the DOM. This can happen if
              // the item was projected into another item by something like `ngTemplateOutlet`.


              var parent = _this29.element.nativeElement.parentElement;

              while (parent) {
                // `classList` needs to be null checked, because IE doesn't have it on some elements.
                if ((_a = parent.classList) === null || _a === void 0 ? void 0 : _a.contains(DRAG_HOST_CLASS)) {
                  ref.withParent(((_b = CdkDrag._dragInstances.find(function (drag) {
                    return drag.element.nativeElement === parent;
                  })) === null || _b === void 0 ? void 0 : _b._dragRef) || null);
                  break;
                }

                parent = parent.parentElement;
              }
            });
          }
          /** Handles the events from the underlying `DragRef`. */

        }, {
          key: "_handleEvents",
          value: function _handleEvents(ref) {
            var _this30 = this;

            ref.started.subscribe(function () {
              _this30.started.emit({
                source: _this30
              }); // Since all of these events run outside of change detection,
              // we need to ensure that everything is marked correctly.


              _this30._changeDetectorRef.markForCheck();
            });
            ref.released.subscribe(function () {
              _this30.released.emit({
                source: _this30
              });
            });
            ref.ended.subscribe(function (event) {
              _this30.ended.emit({
                source: _this30,
                distance: event.distance
              }); // Since all of these events run outside of change detection,
              // we need to ensure that everything is marked correctly.


              _this30._changeDetectorRef.markForCheck();
            });
            ref.entered.subscribe(function (event) {
              _this30.entered.emit({
                container: event.container.data,
                item: _this30,
                currentIndex: event.currentIndex
              });
            });
            ref.exited.subscribe(function (event) {
              _this30.exited.emit({
                container: event.container.data,
                item: _this30
              });
            });
            ref.dropped.subscribe(function (event) {
              _this30.dropped.emit({
                previousIndex: event.previousIndex,
                currentIndex: event.currentIndex,
                previousContainer: event.previousContainer.data,
                container: event.container.data,
                isPointerOverContainer: event.isPointerOverContainer,
                item: _this30,
                distance: event.distance
              });
            });
          }
          /** Assigns the default input values based on a provided config object. */

        }, {
          key: "_assignDefaults",
          value: function _assignDefaults(config) {
            var lockAxis = config.lockAxis,
                dragStartDelay = config.dragStartDelay,
                constrainPosition = config.constrainPosition,
                previewClass = config.previewClass,
                boundaryElement = config.boundaryElement,
                draggingDisabled = config.draggingDisabled,
                rootElementSelector = config.rootElementSelector;
            this.disabled = draggingDisabled == null ? false : draggingDisabled;
            this.dragStartDelay = dragStartDelay || 0;

            if (lockAxis) {
              this.lockAxis = lockAxis;
            }

            if (constrainPosition) {
              this.constrainPosition = constrainPosition;
            }

            if (previewClass) {
              this.previewClass = previewClass;
            }

            if (boundaryElement) {
              this.boundaryElement = boundaryElement;
            }

            if (rootElementSelector) {
              this.rootElementSelector = rootElementSelector;
            }
          }
        }]);

        return CdkDrag;
      }();

      CdkDrag.ɵfac = function CdkDrag_Factory(t) {
        return new (t || CdkDrag)(_angular_core__WEBPACK_IMPORTED_MODULE_0__["ɵɵdirectiveInject"](_angular_core__WEBPACK_IMPORTED_MODULE_0__["ElementRef"]), _angular_core__WEBPACK_IMPORTED_MODULE_0__["ɵɵdirectiveInject"](CDK_DROP_LIST, 12), _angular_core__WEBPACK_IMPORTED_MODULE_0__["ɵɵdirectiveInject"](_angular_common__WEBPACK_IMPORTED_MODULE_1__["DOCUMENT"]), _angular_core__WEBPACK_IMPORTED_MODULE_0__["ɵɵdirectiveInject"](_angular_core__WEBPACK_IMPORTED_MODULE_0__["NgZone"]), _angular_core__WEBPACK_IMPORTED_MODULE_0__["ɵɵdirectiveInject"](_angular_core__WEBPACK_IMPORTED_MODULE_0__["ViewContainerRef"]), _angular_core__WEBPACK_IMPORTED_MODULE_0__["ɵɵdirectiveInject"](CDK_DRAG_CONFIG, 8), _angular_core__WEBPACK_IMPORTED_MODULE_0__["ɵɵdirectiveInject"](_angular_cdk_bidi__WEBPACK_IMPORTED_MODULE_7__["Directionality"], 8), _angular_core__WEBPACK_IMPORTED_MODULE_0__["ɵɵdirectiveInject"](DragDrop), _angular_core__WEBPACK_IMPORTED_MODULE_0__["ɵɵdirectiveInject"](_angular_core__WEBPACK_IMPORTED_MODULE_0__["ChangeDetectorRef"]), _angular_core__WEBPACK_IMPORTED_MODULE_0__["ɵɵdirectiveInject"](CDK_DRAG_HANDLE, 10), _angular_core__WEBPACK_IMPORTED_MODULE_0__["ɵɵdirectiveInject"](CDK_DRAG_PARENT, 12));
      };

      CdkDrag.ɵdir = _angular_core__WEBPACK_IMPORTED_MODULE_0__["ɵɵdefineDirective"]({
        type: CdkDrag,
        selectors: [["", "cdkDrag", ""]],
        contentQueries: function CdkDrag_ContentQueries(rf, ctx, dirIndex) {
          if (rf & 1) {
            _angular_core__WEBPACK_IMPORTED_MODULE_0__["ɵɵcontentQuery"](dirIndex, CDK_DRAG_PREVIEW, 1);

            _angular_core__WEBPACK_IMPORTED_MODULE_0__["ɵɵcontentQuery"](dirIndex, CDK_DRAG_PLACEHOLDER, 1);

            _angular_core__WEBPACK_IMPORTED_MODULE_0__["ɵɵcontentQuery"](dirIndex, CDK_DRAG_HANDLE, 1);
          }

          if (rf & 2) {
            var _t;

            _angular_core__WEBPACK_IMPORTED_MODULE_0__["ɵɵqueryRefresh"](_t = _angular_core__WEBPACK_IMPORTED_MODULE_0__["ɵɵloadQuery"]()) && (ctx._previewTemplate = _t.first);
            _angular_core__WEBPACK_IMPORTED_MODULE_0__["ɵɵqueryRefresh"](_t = _angular_core__WEBPACK_IMPORTED_MODULE_0__["ɵɵloadQuery"]()) && (ctx._placeholderTemplate = _t.first);
            _angular_core__WEBPACK_IMPORTED_MODULE_0__["ɵɵqueryRefresh"](_t = _angular_core__WEBPACK_IMPORTED_MODULE_0__["ɵɵloadQuery"]()) && (ctx._handles = _t);
          }
        },
        hostAttrs: [1, "cdk-drag"],
        hostVars: 4,
        hostBindings: function CdkDrag_HostBindings(rf, ctx) {
          if (rf & 2) {
            _angular_core__WEBPACK_IMPORTED_MODULE_0__["ɵɵclassProp"]("cdk-drag-disabled", ctx.disabled)("cdk-drag-dragging", ctx._dragRef.isDragging());
          }
        },
        inputs: {
          disabled: ["cdkDragDisabled", "disabled"],
          dragStartDelay: ["cdkDragStartDelay", "dragStartDelay"],
          lockAxis: ["cdkDragLockAxis", "lockAxis"],
          constrainPosition: ["cdkDragConstrainPosition", "constrainPosition"],
          previewClass: ["cdkDragPreviewClass", "previewClass"],
          boundaryElement: ["cdkDragBoundary", "boundaryElement"],
          rootElementSelector: ["cdkDragRootElement", "rootElementSelector"],
          data: ["cdkDragData", "data"],
          freeDragPosition: ["cdkDragFreeDragPosition", "freeDragPosition"]
        },
        outputs: {
          started: "cdkDragStarted",
          released: "cdkDragReleased",
          ended: "cdkDragEnded",
          entered: "cdkDragEntered",
          exited: "cdkDragExited",
          dropped: "cdkDragDropped",
          moved: "cdkDragMoved"
        },
        exportAs: ["cdkDrag"],
        features: [_angular_core__WEBPACK_IMPORTED_MODULE_0__["ɵɵProvidersFeature"]([{
          provide: CDK_DRAG_PARENT,
          useExisting: CdkDrag
        }]), _angular_core__WEBPACK_IMPORTED_MODULE_0__["ɵɵNgOnChangesFeature"]]
      });
      CdkDrag._dragInstances = [];

      CdkDrag.ctorParameters = function () {
        return [{
          type: _angular_core__WEBPACK_IMPORTED_MODULE_0__["ElementRef"]
        }, {
          type: undefined,
          decorators: [{
            type: _angular_core__WEBPACK_IMPORTED_MODULE_0__["Inject"],
            args: [CDK_DROP_LIST]
          }, {
            type: _angular_core__WEBPACK_IMPORTED_MODULE_0__["Optional"]
          }, {
            type: _angular_core__WEBPACK_IMPORTED_MODULE_0__["SkipSelf"]
          }]
        }, {
          type: undefined,
          decorators: [{
            type: _angular_core__WEBPACK_IMPORTED_MODULE_0__["Inject"],
            args: [_angular_common__WEBPACK_IMPORTED_MODULE_1__["DOCUMENT"]]
          }]
        }, {
          type: _angular_core__WEBPACK_IMPORTED_MODULE_0__["NgZone"]
        }, {
          type: _angular_core__WEBPACK_IMPORTED_MODULE_0__["ViewContainerRef"]
        }, {
          type: undefined,
          decorators: [{
            type: _angular_core__WEBPACK_IMPORTED_MODULE_0__["Optional"]
          }, {
            type: _angular_core__WEBPACK_IMPORTED_MODULE_0__["Inject"],
            args: [CDK_DRAG_CONFIG]
          }]
        }, {
          type: _angular_cdk_bidi__WEBPACK_IMPORTED_MODULE_7__["Directionality"],
          decorators: [{
            type: _angular_core__WEBPACK_IMPORTED_MODULE_0__["Optional"]
          }]
        }, {
          type: DragDrop
        }, {
          type: _angular_core__WEBPACK_IMPORTED_MODULE_0__["ChangeDetectorRef"]
        }, {
          type: CdkDragHandle,
          decorators: [{
            type: _angular_core__WEBPACK_IMPORTED_MODULE_0__["Optional"]
          }, {
            type: _angular_core__WEBPACK_IMPORTED_MODULE_0__["Self"]
          }, {
            type: _angular_core__WEBPACK_IMPORTED_MODULE_0__["Inject"],
            args: [CDK_DRAG_HANDLE]
          }]
        }, {
          type: CdkDrag,
          decorators: [{
            type: _angular_core__WEBPACK_IMPORTED_MODULE_0__["Optional"]
          }, {
            type: _angular_core__WEBPACK_IMPORTED_MODULE_0__["SkipSelf"]
          }, {
            type: _angular_core__WEBPACK_IMPORTED_MODULE_0__["Inject"],
            args: [CDK_DRAG_PARENT]
          }]
        }];
      };

      CdkDrag.propDecorators = {
        _handles: [{
          type: _angular_core__WEBPACK_IMPORTED_MODULE_0__["ContentChildren"],
          args: [CDK_DRAG_HANDLE, {
            descendants: true
          }]
        }],
        _previewTemplate: [{
          type: _angular_core__WEBPACK_IMPORTED_MODULE_0__["ContentChild"],
          args: [CDK_DRAG_PREVIEW]
        }],
        _placeholderTemplate: [{
          type: _angular_core__WEBPACK_IMPORTED_MODULE_0__["ContentChild"],
          args: [CDK_DRAG_PLACEHOLDER]
        }],
        data: [{
          type: _angular_core__WEBPACK_IMPORTED_MODULE_0__["Input"],
          args: ['cdkDragData']
        }],
        lockAxis: [{
          type: _angular_core__WEBPACK_IMPORTED_MODULE_0__["Input"],
          args: ['cdkDragLockAxis']
        }],
        rootElementSelector: [{
          type: _angular_core__WEBPACK_IMPORTED_MODULE_0__["Input"],
          args: ['cdkDragRootElement']
        }],
        boundaryElement: [{
          type: _angular_core__WEBPACK_IMPORTED_MODULE_0__["Input"],
          args: ['cdkDragBoundary']
        }],
        dragStartDelay: [{
          type: _angular_core__WEBPACK_IMPORTED_MODULE_0__["Input"],
          args: ['cdkDragStartDelay']
        }],
        freeDragPosition: [{
          type: _angular_core__WEBPACK_IMPORTED_MODULE_0__["Input"],
          args: ['cdkDragFreeDragPosition']
        }],
        disabled: [{
          type: _angular_core__WEBPACK_IMPORTED_MODULE_0__["Input"],
          args: ['cdkDragDisabled']
        }],
        constrainPosition: [{
          type: _angular_core__WEBPACK_IMPORTED_MODULE_0__["Input"],
          args: ['cdkDragConstrainPosition']
        }],
        previewClass: [{
          type: _angular_core__WEBPACK_IMPORTED_MODULE_0__["Input"],
          args: ['cdkDragPreviewClass']
        }],
        started: [{
          type: _angular_core__WEBPACK_IMPORTED_MODULE_0__["Output"],
          args: ['cdkDragStarted']
        }],
        released: [{
          type: _angular_core__WEBPACK_IMPORTED_MODULE_0__["Output"],
          args: ['cdkDragReleased']
        }],
        ended: [{
          type: _angular_core__WEBPACK_IMPORTED_MODULE_0__["Output"],
          args: ['cdkDragEnded']
        }],
        entered: [{
          type: _angular_core__WEBPACK_IMPORTED_MODULE_0__["Output"],
          args: ['cdkDragEntered']
        }],
        exited: [{
          type: _angular_core__WEBPACK_IMPORTED_MODULE_0__["Output"],
          args: ['cdkDragExited']
        }],
        dropped: [{
          type: _angular_core__WEBPACK_IMPORTED_MODULE_0__["Output"],
          args: ['cdkDragDropped']
        }],
        moved: [{
          type: _angular_core__WEBPACK_IMPORTED_MODULE_0__["Output"],
          args: ['cdkDragMoved']
        }]
      };

      (function () {
        (typeof ngDevMode === "undefined" || ngDevMode) && _angular_core__WEBPACK_IMPORTED_MODULE_0__["ɵsetClassMetadata"](CdkDrag, [{
          type: _angular_core__WEBPACK_IMPORTED_MODULE_0__["Directive"],
          args: [{
            selector: '[cdkDrag]',
            exportAs: 'cdkDrag',
            host: {
              'class': DRAG_HOST_CLASS,
              '[class.cdk-drag-disabled]': 'disabled',
              '[class.cdk-drag-dragging]': '_dragRef.isDragging()'
            },
            providers: [{
              provide: CDK_DRAG_PARENT,
              useExisting: CdkDrag
            }]
          }]
        }], function () {
          return [{
            type: _angular_core__WEBPACK_IMPORTED_MODULE_0__["ElementRef"]
          }, {
            type: undefined,
            decorators: [{
              type: _angular_core__WEBPACK_IMPORTED_MODULE_0__["Inject"],
              args: [CDK_DROP_LIST]
            }, {
              type: _angular_core__WEBPACK_IMPORTED_MODULE_0__["Optional"]
            }, {
              type: _angular_core__WEBPACK_IMPORTED_MODULE_0__["SkipSelf"]
            }]
          }, {
            type: undefined,
            decorators: [{
              type: _angular_core__WEBPACK_IMPORTED_MODULE_0__["Inject"],
              args: [_angular_common__WEBPACK_IMPORTED_MODULE_1__["DOCUMENT"]]
            }]
          }, {
            type: _angular_core__WEBPACK_IMPORTED_MODULE_0__["NgZone"]
          }, {
            type: _angular_core__WEBPACK_IMPORTED_MODULE_0__["ViewContainerRef"]
          }, {
            type: undefined,
            decorators: [{
              type: _angular_core__WEBPACK_IMPORTED_MODULE_0__["Optional"]
            }, {
              type: _angular_core__WEBPACK_IMPORTED_MODULE_0__["Inject"],
              args: [CDK_DRAG_CONFIG]
            }]
          }, {
            type: _angular_cdk_bidi__WEBPACK_IMPORTED_MODULE_7__["Directionality"],
            decorators: [{
              type: _angular_core__WEBPACK_IMPORTED_MODULE_0__["Optional"]
            }]
          }, {
            type: DragDrop
          }, {
            type: _angular_core__WEBPACK_IMPORTED_MODULE_0__["ChangeDetectorRef"]
          }, {
            type: CdkDragHandle,
            decorators: [{
              type: _angular_core__WEBPACK_IMPORTED_MODULE_0__["Optional"]
            }, {
              type: _angular_core__WEBPACK_IMPORTED_MODULE_0__["Self"]
            }, {
              type: _angular_core__WEBPACK_IMPORTED_MODULE_0__["Inject"],
              args: [CDK_DRAG_HANDLE]
            }]
          }, {
            type: CdkDrag,
            decorators: [{
              type: _angular_core__WEBPACK_IMPORTED_MODULE_0__["Optional"]
            }, {
              type: _angular_core__WEBPACK_IMPORTED_MODULE_0__["SkipSelf"]
            }, {
              type: _angular_core__WEBPACK_IMPORTED_MODULE_0__["Inject"],
              args: [CDK_DRAG_PARENT]
            }]
          }];
        }, {
          started: [{
            type: _angular_core__WEBPACK_IMPORTED_MODULE_0__["Output"],
            args: ['cdkDragStarted']
          }],
          released: [{
            type: _angular_core__WEBPACK_IMPORTED_MODULE_0__["Output"],
            args: ['cdkDragReleased']
          }],
          ended: [{
            type: _angular_core__WEBPACK_IMPORTED_MODULE_0__["Output"],
            args: ['cdkDragEnded']
          }],
          entered: [{
            type: _angular_core__WEBPACK_IMPORTED_MODULE_0__["Output"],
            args: ['cdkDragEntered']
          }],
          exited: [{
            type: _angular_core__WEBPACK_IMPORTED_MODULE_0__["Output"],
            args: ['cdkDragExited']
          }],
          dropped: [{
            type: _angular_core__WEBPACK_IMPORTED_MODULE_0__["Output"],
            args: ['cdkDragDropped']
          }],
          moved: [{
            type: _angular_core__WEBPACK_IMPORTED_MODULE_0__["Output"],
            args: ['cdkDragMoved']
          }],
          disabled: [{
            type: _angular_core__WEBPACK_IMPORTED_MODULE_0__["Input"],
            args: ['cdkDragDisabled']
          }],
          dragStartDelay: [{
            type: _angular_core__WEBPACK_IMPORTED_MODULE_0__["Input"],
            args: ['cdkDragStartDelay']
          }],
          lockAxis: [{
            type: _angular_core__WEBPACK_IMPORTED_MODULE_0__["Input"],
            args: ['cdkDragLockAxis']
          }],
          constrainPosition: [{
            type: _angular_core__WEBPACK_IMPORTED_MODULE_0__["Input"],
            args: ['cdkDragConstrainPosition']
          }],
          previewClass: [{
            type: _angular_core__WEBPACK_IMPORTED_MODULE_0__["Input"],
            args: ['cdkDragPreviewClass']
          }],
          boundaryElement: [{
            type: _angular_core__WEBPACK_IMPORTED_MODULE_0__["Input"],
            args: ['cdkDragBoundary']
          }],
          rootElementSelector: [{
            type: _angular_core__WEBPACK_IMPORTED_MODULE_0__["Input"],
            args: ['cdkDragRootElement']
          }],
          _handles: [{
            type: _angular_core__WEBPACK_IMPORTED_MODULE_0__["ContentChildren"],
            args: [CDK_DRAG_HANDLE, {
              descendants: true
            }]
          }],
          _previewTemplate: [{
            type: _angular_core__WEBPACK_IMPORTED_MODULE_0__["ContentChild"],
            args: [CDK_DRAG_PREVIEW]
          }],
          _placeholderTemplate: [{
            type: _angular_core__WEBPACK_IMPORTED_MODULE_0__["ContentChild"],
            args: [CDK_DRAG_PLACEHOLDER]
          }],
          data: [{
            type: _angular_core__WEBPACK_IMPORTED_MODULE_0__["Input"],
            args: ['cdkDragData']
          }],
          freeDragPosition: [{
            type: _angular_core__WEBPACK_IMPORTED_MODULE_0__["Input"],
            args: ['cdkDragFreeDragPosition']
          }]
        });
      })();
      /** Gets the closest ancestor of an element that matches a selector. */


      function getClosestMatchingAncestor(element, selector) {
        var currentElement = element.parentElement;

        while (currentElement) {
          // IE doesn't support `matches` so we have to fall back to `msMatchesSelector`.
          if (currentElement.matches ? currentElement.matches(selector) : currentElement.msMatchesSelector(selector)) {
            return currentElement;
          }

          currentElement = currentElement.parentElement;
        }

        return null;
      }
      /**
       * @license
       * Copyright Google LLC All Rights Reserved.
       *
       * Use of this source code is governed by an MIT-style license that can be
       * found in the LICENSE file at https://angular.io/license
       */


      var DragDropModule = function DragDropModule() {
        _classCallCheck(this, DragDropModule);
      };

      DragDropModule.ɵfac = function DragDropModule_Factory(t) {
        return new (t || DragDropModule)();
      };

      DragDropModule.ɵmod = _angular_core__WEBPACK_IMPORTED_MODULE_0__["ɵɵdefineNgModule"]({
        type: DragDropModule
      });
      DragDropModule.ɵinj = _angular_core__WEBPACK_IMPORTED_MODULE_0__["ɵɵdefineInjector"]({
        providers: [DragDrop],
        imports: [_angular_cdk_scrolling__WEBPACK_IMPORTED_MODULE_2__["CdkScrollableModule"]]
      });

      (function () {
        (typeof ngJitMode === "undefined" || ngJitMode) && _angular_core__WEBPACK_IMPORTED_MODULE_0__["ɵɵsetNgModuleScope"](DragDropModule, {
          declarations: function declarations() {
            return [CdkDropList, CdkDropListGroup, CdkDrag, CdkDragHandle, CdkDragPreview, CdkDragPlaceholder];
          },
          exports: function exports() {
            return [_angular_cdk_scrolling__WEBPACK_IMPORTED_MODULE_2__["CdkScrollableModule"], CdkDropList, CdkDropListGroup, CdkDrag, CdkDragHandle, CdkDragPreview, CdkDragPlaceholder];
          }
        });
      })();

      (function () {
        (typeof ngDevMode === "undefined" || ngDevMode) && _angular_core__WEBPACK_IMPORTED_MODULE_0__["ɵsetClassMetadata"](DragDropModule, [{
          type: _angular_core__WEBPACK_IMPORTED_MODULE_0__["NgModule"],
          args: [{
            declarations: [CdkDropList, CdkDropListGroup, CdkDrag, CdkDragHandle, CdkDragPreview, CdkDragPlaceholder],
            exports: [_angular_cdk_scrolling__WEBPACK_IMPORTED_MODULE_2__["CdkScrollableModule"], CdkDropList, CdkDropListGroup, CdkDrag, CdkDragHandle, CdkDragPreview, CdkDragPlaceholder],
            providers: [DragDrop]
          }]
        }], null, null);
      })();
      /**
       * @license
       * Copyright Google LLC All Rights Reserved.
       *
       * Use of this source code is governed by an MIT-style license that can be
       * found in the LICENSE file at https://angular.io/license
       */

      /**
       * Generated bundle index. Do not edit.
       */
      //# sourceMappingURL=drag-drop.js.map

      /***/

    },

    /***/
    "IvDN": function IvDN(module, __webpack_exports__, __webpack_require__) {
      "use strict";

      __webpack_require__.r(__webpack_exports__);
      /* harmony export (binding) */


      __webpack_require__.d(__webpack_exports__, "NzCollapseComponent", function () {
        return NzCollapseComponent;
      });
      /* harmony export (binding) */


      __webpack_require__.d(__webpack_exports__, "NzCollapseModule", function () {
        return NzCollapseModule;
      });
      /* harmony export (binding) */


      __webpack_require__.d(__webpack_exports__, "NzCollapsePanelComponent", function () {
        return NzCollapsePanelComponent;
      });
      /* harmony import */


      var tslib__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(
      /*! tslib */
      "mrSG");
      /* harmony import */


      var _angular_core__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(
      /*! @angular/core */
      "fXoL");
      /* harmony import */


      var ng_zorro_antd_core_animation__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(
      /*! ng-zorro-antd/core/animation */
      "GR68");
      /* harmony import */


      var ng_zorro_antd_core_config__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(
      /*! ng-zorro-antd/core/config */
      "2Suw");
      /* harmony import */


      var ng_zorro_antd_core_no_animation__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(
      /*! ng-zorro-antd/core/no-animation */
      "YF2q");
      /* harmony import */


      var ng_zorro_antd_core_util__WEBPACK_IMPORTED_MODULE_5__ = __webpack_require__(
      /*! ng-zorro-antd/core/util */
      "/KA4");
      /* harmony import */


      var rxjs__WEBPACK_IMPORTED_MODULE_6__ = __webpack_require__(
      /*! rxjs */
      "qCKp");
      /* harmony import */


      var rxjs_operators__WEBPACK_IMPORTED_MODULE_7__ = __webpack_require__(
      /*! rxjs/operators */
      "kU1M");
      /* harmony import */


      var _angular_cdk_bidi__WEBPACK_IMPORTED_MODULE_8__ = __webpack_require__(
      /*! @angular/cdk/bidi */
      "cH1L");
      /* harmony import */


      var _angular_common__WEBPACK_IMPORTED_MODULE_9__ = __webpack_require__(
      /*! @angular/common */
      "ofXK");
      /* harmony import */


      var ng_zorro_antd_core_outlet__WEBPACK_IMPORTED_MODULE_10__ = __webpack_require__(
      /*! ng-zorro-antd/core/outlet */
      "pdGh");
      /* harmony import */


      var ng_zorro_antd_icon__WEBPACK_IMPORTED_MODULE_11__ = __webpack_require__(
      /*! ng-zorro-antd/icon */
      "FwiY");
      /**
       * Use of this source code is governed by an MIT-style license that can be
       * found in the LICENSE file at https://github.com/NG-ZORRO/ng-zorro-antd/blob/master/LICENSE
       */


      var _c0 = ["*"];

      function NzCollapsePanelComponent_ng_container_1_ng_container_1_Template(rf, ctx) {
        if (rf & 1) {
          _angular_core__WEBPACK_IMPORTED_MODULE_1__["ɵɵelementContainerStart"](0);

          _angular_core__WEBPACK_IMPORTED_MODULE_1__["ɵɵelement"](1, "i", 6);

          _angular_core__WEBPACK_IMPORTED_MODULE_1__["ɵɵelementContainerEnd"]();
        }

        if (rf & 2) {
          var expandedIcon_r4 = ctx.$implicit;

          var ctx_r3 = _angular_core__WEBPACK_IMPORTED_MODULE_1__["ɵɵnextContext"](2);

          _angular_core__WEBPACK_IMPORTED_MODULE_1__["ɵɵadvance"](1);

          _angular_core__WEBPACK_IMPORTED_MODULE_1__["ɵɵproperty"]("nzType", expandedIcon_r4 || "right")("nzRotate", ctx_r3.nzActive ? 90 : 0);
        }
      }

      function NzCollapsePanelComponent_ng_container_1_Template(rf, ctx) {
        if (rf & 1) {
          _angular_core__WEBPACK_IMPORTED_MODULE_1__["ɵɵelementContainerStart"](0);

          _angular_core__WEBPACK_IMPORTED_MODULE_1__["ɵɵtemplate"](1, NzCollapsePanelComponent_ng_container_1_ng_container_1_Template, 2, 2, "ng-container", 2);

          _angular_core__WEBPACK_IMPORTED_MODULE_1__["ɵɵelementContainerEnd"]();
        }

        if (rf & 2) {
          var ctx_r0 = _angular_core__WEBPACK_IMPORTED_MODULE_1__["ɵɵnextContext"]();

          _angular_core__WEBPACK_IMPORTED_MODULE_1__["ɵɵadvance"](1);

          _angular_core__WEBPACK_IMPORTED_MODULE_1__["ɵɵproperty"]("nzStringTemplateOutlet", ctx_r0.nzExpandedIcon);
        }
      }

      function NzCollapsePanelComponent_ng_container_2_Template(rf, ctx) {
        if (rf & 1) {
          _angular_core__WEBPACK_IMPORTED_MODULE_1__["ɵɵelementContainerStart"](0);

          _angular_core__WEBPACK_IMPORTED_MODULE_1__["ɵɵtext"](1);

          _angular_core__WEBPACK_IMPORTED_MODULE_1__["ɵɵelementContainerEnd"]();
        }

        if (rf & 2) {
          var ctx_r1 = _angular_core__WEBPACK_IMPORTED_MODULE_1__["ɵɵnextContext"]();

          _angular_core__WEBPACK_IMPORTED_MODULE_1__["ɵɵadvance"](1);

          _angular_core__WEBPACK_IMPORTED_MODULE_1__["ɵɵtextInterpolate"](ctx_r1.nzHeader);
        }
      }

      function NzCollapsePanelComponent_div_3_ng_container_1_Template(rf, ctx) {
        if (rf & 1) {
          _angular_core__WEBPACK_IMPORTED_MODULE_1__["ɵɵelementContainerStart"](0);

          _angular_core__WEBPACK_IMPORTED_MODULE_1__["ɵɵtext"](1);

          _angular_core__WEBPACK_IMPORTED_MODULE_1__["ɵɵelementContainerEnd"]();
        }

        if (rf & 2) {
          var ctx_r5 = _angular_core__WEBPACK_IMPORTED_MODULE_1__["ɵɵnextContext"](2);

          _angular_core__WEBPACK_IMPORTED_MODULE_1__["ɵɵadvance"](1);

          _angular_core__WEBPACK_IMPORTED_MODULE_1__["ɵɵtextInterpolate"](ctx_r5.nzExtra);
        }
      }

      function NzCollapsePanelComponent_div_3_Template(rf, ctx) {
        if (rf & 1) {
          _angular_core__WEBPACK_IMPORTED_MODULE_1__["ɵɵelementStart"](0, "div", 7);

          _angular_core__WEBPACK_IMPORTED_MODULE_1__["ɵɵtemplate"](1, NzCollapsePanelComponent_div_3_ng_container_1_Template, 2, 1, "ng-container", 2);

          _angular_core__WEBPACK_IMPORTED_MODULE_1__["ɵɵelementEnd"]();
        }

        if (rf & 2) {
          var ctx_r2 = _angular_core__WEBPACK_IMPORTED_MODULE_1__["ɵɵnextContext"]();

          _angular_core__WEBPACK_IMPORTED_MODULE_1__["ɵɵadvance"](1);

          _angular_core__WEBPACK_IMPORTED_MODULE_1__["ɵɵproperty"]("nzStringTemplateOutlet", ctx_r2.nzExtra);
        }
      }

      var NZ_CONFIG_MODULE_NAME = 'collapse';

      var NzCollapseComponent = /*#__PURE__*/function () {
        function NzCollapseComponent(nzConfigService, cdr, elementRef, directionality) {
          var _this31 = this;

          _classCallCheck(this, NzCollapseComponent);

          this.nzConfigService = nzConfigService;
          this.cdr = cdr;
          this.elementRef = elementRef;
          this.directionality = directionality;
          this._nzModuleName = NZ_CONFIG_MODULE_NAME;
          this.nzAccordion = false;
          this.nzBordered = true;
          this.nzGhost = false;
          this.nzExpandIconPosition = 'left';
          this.dir = 'ltr';
          this.listOfNzCollapsePanelComponent = [];
          this.destroy$ = new rxjs__WEBPACK_IMPORTED_MODULE_6__["Subject"](); // TODO: move to host after View Engine deprecation

          this.elementRef.nativeElement.classList.add('ant-collapse');
          this.nzConfigService.getConfigChangeEventForComponent(NZ_CONFIG_MODULE_NAME).pipe(Object(rxjs_operators__WEBPACK_IMPORTED_MODULE_7__["takeUntil"])(this.destroy$)).subscribe(function () {
            _this31.cdr.markForCheck();
          });
        }

        _createClass(NzCollapseComponent, [{
          key: "ngOnInit",
          value: function ngOnInit() {
            var _this32 = this;

            var _a;

            (_a = this.directionality.change) === null || _a === void 0 ? void 0 : _a.pipe(Object(rxjs_operators__WEBPACK_IMPORTED_MODULE_7__["takeUntil"])(this.destroy$)).subscribe(function (direction) {
              _this32.dir = direction;

              _this32.cdr.detectChanges();
            });
            this.dir = this.directionality.value;
          }
        }, {
          key: "addPanel",
          value: function addPanel(value) {
            this.listOfNzCollapsePanelComponent.push(value);
          }
        }, {
          key: "removePanel",
          value: function removePanel(value) {
            this.listOfNzCollapsePanelComponent.splice(this.listOfNzCollapsePanelComponent.indexOf(value), 1);
          }
        }, {
          key: "click",
          value: function click(collapse) {
            if (this.nzAccordion && !collapse.nzActive) {
              this.listOfNzCollapsePanelComponent.filter(function (item) {
                return item !== collapse;
              }).forEach(function (item) {
                if (item.nzActive) {
                  item.nzActive = false;
                  item.nzActiveChange.emit(item.nzActive);
                  item.markForCheck();
                }
              });
            }

            collapse.nzActive = !collapse.nzActive;
            collapse.nzActiveChange.emit(collapse.nzActive);
          }
        }, {
          key: "ngOnDestroy",
          value: function ngOnDestroy() {
            this.destroy$.next();
            this.destroy$.complete();
          }
        }]);

        return NzCollapseComponent;
      }();

      NzCollapseComponent.ɵfac = function NzCollapseComponent_Factory(t) {
        return new (t || NzCollapseComponent)(_angular_core__WEBPACK_IMPORTED_MODULE_1__["ɵɵdirectiveInject"](ng_zorro_antd_core_config__WEBPACK_IMPORTED_MODULE_3__["NzConfigService"]), _angular_core__WEBPACK_IMPORTED_MODULE_1__["ɵɵdirectiveInject"](_angular_core__WEBPACK_IMPORTED_MODULE_1__["ChangeDetectorRef"]), _angular_core__WEBPACK_IMPORTED_MODULE_1__["ɵɵdirectiveInject"](_angular_core__WEBPACK_IMPORTED_MODULE_1__["ElementRef"]), _angular_core__WEBPACK_IMPORTED_MODULE_1__["ɵɵdirectiveInject"](_angular_cdk_bidi__WEBPACK_IMPORTED_MODULE_8__["Directionality"], 8));
      };

      NzCollapseComponent.ɵcmp = _angular_core__WEBPACK_IMPORTED_MODULE_1__["ɵɵdefineComponent"]({
        type: NzCollapseComponent,
        selectors: [["nz-collapse"]],
        hostVars: 10,
        hostBindings: function NzCollapseComponent_HostBindings(rf, ctx) {
          if (rf & 2) {
            _angular_core__WEBPACK_IMPORTED_MODULE_1__["ɵɵclassProp"]("ant-collapse-icon-position-left", ctx.nzExpandIconPosition === "left")("ant-collapse-icon-position-right", ctx.nzExpandIconPosition === "right")("ant-collapse-ghost", ctx.nzGhost)("ant-collapse-borderless", !ctx.nzBordered)("ant-collapse-rtl", ctx.dir === "rtl");
          }
        },
        inputs: {
          nzAccordion: "nzAccordion",
          nzBordered: "nzBordered",
          nzGhost: "nzGhost",
          nzExpandIconPosition: "nzExpandIconPosition"
        },
        exportAs: ["nzCollapse"],
        ngContentSelectors: _c0,
        decls: 1,
        vars: 0,
        template: function NzCollapseComponent_Template(rf, ctx) {
          if (rf & 1) {
            _angular_core__WEBPACK_IMPORTED_MODULE_1__["ɵɵprojectionDef"]();

            _angular_core__WEBPACK_IMPORTED_MODULE_1__["ɵɵprojection"](0);
          }
        },
        encapsulation: 2,
        changeDetection: 0
      });

      NzCollapseComponent.ctorParameters = function () {
        return [{
          type: ng_zorro_antd_core_config__WEBPACK_IMPORTED_MODULE_3__["NzConfigService"]
        }, {
          type: _angular_core__WEBPACK_IMPORTED_MODULE_1__["ChangeDetectorRef"]
        }, {
          type: _angular_core__WEBPACK_IMPORTED_MODULE_1__["ElementRef"]
        }, {
          type: _angular_cdk_bidi__WEBPACK_IMPORTED_MODULE_8__["Directionality"],
          decorators: [{
            type: _angular_core__WEBPACK_IMPORTED_MODULE_1__["Optional"]
          }]
        }];
      };

      NzCollapseComponent.propDecorators = {
        nzAccordion: [{
          type: _angular_core__WEBPACK_IMPORTED_MODULE_1__["Input"]
        }],
        nzBordered: [{
          type: _angular_core__WEBPACK_IMPORTED_MODULE_1__["Input"]
        }],
        nzGhost: [{
          type: _angular_core__WEBPACK_IMPORTED_MODULE_1__["Input"]
        }],
        nzExpandIconPosition: [{
          type: _angular_core__WEBPACK_IMPORTED_MODULE_1__["Input"]
        }]
      };
      Object(tslib__WEBPACK_IMPORTED_MODULE_0__["__decorate"])([Object(ng_zorro_antd_core_config__WEBPACK_IMPORTED_MODULE_3__["WithConfig"])(), Object(ng_zorro_antd_core_util__WEBPACK_IMPORTED_MODULE_5__["InputBoolean"])(), Object(tslib__WEBPACK_IMPORTED_MODULE_0__["__metadata"])("design:type", Boolean)], NzCollapseComponent.prototype, "nzAccordion", void 0);
      Object(tslib__WEBPACK_IMPORTED_MODULE_0__["__decorate"])([Object(ng_zorro_antd_core_config__WEBPACK_IMPORTED_MODULE_3__["WithConfig"])(), Object(ng_zorro_antd_core_util__WEBPACK_IMPORTED_MODULE_5__["InputBoolean"])(), Object(tslib__WEBPACK_IMPORTED_MODULE_0__["__metadata"])("design:type", Boolean)], NzCollapseComponent.prototype, "nzBordered", void 0);
      Object(tslib__WEBPACK_IMPORTED_MODULE_0__["__decorate"])([Object(ng_zorro_antd_core_config__WEBPACK_IMPORTED_MODULE_3__["WithConfig"])(), Object(ng_zorro_antd_core_util__WEBPACK_IMPORTED_MODULE_5__["InputBoolean"])(), Object(tslib__WEBPACK_IMPORTED_MODULE_0__["__metadata"])("design:type", Boolean)], NzCollapseComponent.prototype, "nzGhost", void 0);
      /**
       * Use of this source code is governed by an MIT-style license that can be
       * found in the LICENSE file at https://github.com/NG-ZORRO/ng-zorro-antd/blob/master/LICENSE
       */

      var NZ_CONFIG_MODULE_NAME$1 = 'collapsePanel';

      var NzCollapsePanelComponent = /*#__PURE__*/function () {
        function NzCollapsePanelComponent(nzConfigService, cdr, nzCollapseComponent, elementRef, noAnimation) {
          var _this33 = this;

          _classCallCheck(this, NzCollapsePanelComponent);

          this.nzConfigService = nzConfigService;
          this.cdr = cdr;
          this.nzCollapseComponent = nzCollapseComponent;
          this.elementRef = elementRef;
          this.noAnimation = noAnimation;
          this._nzModuleName = NZ_CONFIG_MODULE_NAME$1;
          this.nzActive = false;
          this.nzDisabled = false;
          this.nzShowArrow = true;
          this.nzActiveChange = new _angular_core__WEBPACK_IMPORTED_MODULE_1__["EventEmitter"]();
          this.destroy$ = new rxjs__WEBPACK_IMPORTED_MODULE_6__["Subject"](); // TODO: move to host after View Engine deprecation

          this.elementRef.nativeElement.classList.add('ant-collapse-item');
          this.nzConfigService.getConfigChangeEventForComponent(NZ_CONFIG_MODULE_NAME$1).pipe(Object(rxjs_operators__WEBPACK_IMPORTED_MODULE_7__["takeUntil"])(this.destroy$)).subscribe(function () {
            _this33.cdr.markForCheck();
          });
        }

        _createClass(NzCollapsePanelComponent, [{
          key: "clickHeader",
          value: function clickHeader() {
            if (!this.nzDisabled) {
              this.nzCollapseComponent.click(this);
            }
          }
        }, {
          key: "markForCheck",
          value: function markForCheck() {
            this.cdr.markForCheck();
          }
        }, {
          key: "ngOnInit",
          value: function ngOnInit() {
            this.nzCollapseComponent.addPanel(this);
          }
        }, {
          key: "ngOnDestroy",
          value: function ngOnDestroy() {
            this.destroy$.next();
            this.destroy$.complete();
            this.nzCollapseComponent.removePanel(this);
          }
        }]);

        return NzCollapsePanelComponent;
      }();

      NzCollapsePanelComponent.ɵfac = function NzCollapsePanelComponent_Factory(t) {
        return new (t || NzCollapsePanelComponent)(_angular_core__WEBPACK_IMPORTED_MODULE_1__["ɵɵdirectiveInject"](ng_zorro_antd_core_config__WEBPACK_IMPORTED_MODULE_3__["NzConfigService"]), _angular_core__WEBPACK_IMPORTED_MODULE_1__["ɵɵdirectiveInject"](_angular_core__WEBPACK_IMPORTED_MODULE_1__["ChangeDetectorRef"]), _angular_core__WEBPACK_IMPORTED_MODULE_1__["ɵɵdirectiveInject"](NzCollapseComponent, 1), _angular_core__WEBPACK_IMPORTED_MODULE_1__["ɵɵdirectiveInject"](_angular_core__WEBPACK_IMPORTED_MODULE_1__["ElementRef"]), _angular_core__WEBPACK_IMPORTED_MODULE_1__["ɵɵdirectiveInject"](ng_zorro_antd_core_no_animation__WEBPACK_IMPORTED_MODULE_4__["NzNoAnimationDirective"], 8));
      };

      NzCollapsePanelComponent.ɵcmp = _angular_core__WEBPACK_IMPORTED_MODULE_1__["ɵɵdefineComponent"]({
        type: NzCollapsePanelComponent,
        selectors: [["nz-collapse-panel"]],
        hostVars: 6,
        hostBindings: function NzCollapsePanelComponent_HostBindings(rf, ctx) {
          if (rf & 2) {
            _angular_core__WEBPACK_IMPORTED_MODULE_1__["ɵɵclassProp"]("ant-collapse-no-arrow", !ctx.nzShowArrow)("ant-collapse-item-active", ctx.nzActive)("ant-collapse-item-disabled", ctx.nzDisabled);
          }
        },
        inputs: {
          nzActive: "nzActive",
          nzDisabled: "nzDisabled",
          nzShowArrow: "nzShowArrow",
          nzExtra: "nzExtra",
          nzHeader: "nzHeader",
          nzExpandedIcon: "nzExpandedIcon"
        },
        outputs: {
          nzActiveChange: "nzActiveChange"
        },
        exportAs: ["nzCollapsePanel"],
        ngContentSelectors: _c0,
        decls: 7,
        vars: 8,
        consts: [["role", "tab", 1, "ant-collapse-header", 3, "click"], [4, "ngIf"], [4, "nzStringTemplateOutlet"], ["class", "ant-collapse-extra", 4, "ngIf"], [1, "ant-collapse-content"], [1, "ant-collapse-content-box"], ["nz-icon", "", 1, "ant-collapse-arrow", 3, "nzType", "nzRotate"], [1, "ant-collapse-extra"]],
        template: function NzCollapsePanelComponent_Template(rf, ctx) {
          if (rf & 1) {
            _angular_core__WEBPACK_IMPORTED_MODULE_1__["ɵɵprojectionDef"]();

            _angular_core__WEBPACK_IMPORTED_MODULE_1__["ɵɵelementStart"](0, "div", 0);

            _angular_core__WEBPACK_IMPORTED_MODULE_1__["ɵɵlistener"]("click", function NzCollapsePanelComponent_Template_div_click_0_listener() {
              return ctx.clickHeader();
            });

            _angular_core__WEBPACK_IMPORTED_MODULE_1__["ɵɵtemplate"](1, NzCollapsePanelComponent_ng_container_1_Template, 2, 1, "ng-container", 1);

            _angular_core__WEBPACK_IMPORTED_MODULE_1__["ɵɵtemplate"](2, NzCollapsePanelComponent_ng_container_2_Template, 2, 1, "ng-container", 2);

            _angular_core__WEBPACK_IMPORTED_MODULE_1__["ɵɵtemplate"](3, NzCollapsePanelComponent_div_3_Template, 2, 1, "div", 3);

            _angular_core__WEBPACK_IMPORTED_MODULE_1__["ɵɵelementEnd"]();

            _angular_core__WEBPACK_IMPORTED_MODULE_1__["ɵɵelementStart"](4, "div", 4);

            _angular_core__WEBPACK_IMPORTED_MODULE_1__["ɵɵelementStart"](5, "div", 5);

            _angular_core__WEBPACK_IMPORTED_MODULE_1__["ɵɵprojection"](6);

            _angular_core__WEBPACK_IMPORTED_MODULE_1__["ɵɵelementEnd"]();

            _angular_core__WEBPACK_IMPORTED_MODULE_1__["ɵɵelementEnd"]();
          }

          if (rf & 2) {
            _angular_core__WEBPACK_IMPORTED_MODULE_1__["ɵɵattribute"]("aria-expanded", ctx.nzActive);

            _angular_core__WEBPACK_IMPORTED_MODULE_1__["ɵɵadvance"](1);

            _angular_core__WEBPACK_IMPORTED_MODULE_1__["ɵɵproperty"]("ngIf", ctx.nzShowArrow);

            _angular_core__WEBPACK_IMPORTED_MODULE_1__["ɵɵadvance"](1);

            _angular_core__WEBPACK_IMPORTED_MODULE_1__["ɵɵproperty"]("nzStringTemplateOutlet", ctx.nzHeader);

            _angular_core__WEBPACK_IMPORTED_MODULE_1__["ɵɵadvance"](1);

            _angular_core__WEBPACK_IMPORTED_MODULE_1__["ɵɵproperty"]("ngIf", ctx.nzExtra);

            _angular_core__WEBPACK_IMPORTED_MODULE_1__["ɵɵadvance"](1);

            _angular_core__WEBPACK_IMPORTED_MODULE_1__["ɵɵclassProp"]("ant-collapse-content-active", ctx.nzActive);

            _angular_core__WEBPACK_IMPORTED_MODULE_1__["ɵɵproperty"]("@.disabled", ctx.noAnimation == null ? null : ctx.noAnimation.nzNoAnimation)("@collapseMotion", ctx.nzActive ? "expanded" : "hidden");
          }
        },
        directives: [_angular_common__WEBPACK_IMPORTED_MODULE_9__["NgIf"], ng_zorro_antd_core_outlet__WEBPACK_IMPORTED_MODULE_10__["NzStringTemplateOutletDirective"], ng_zorro_antd_icon__WEBPACK_IMPORTED_MODULE_11__["NzIconDirective"]],
        encapsulation: 2,
        data: {
          animation: [ng_zorro_antd_core_animation__WEBPACK_IMPORTED_MODULE_2__["collapseMotion"]]
        },
        changeDetection: 0
      });

      NzCollapsePanelComponent.ctorParameters = function () {
        return [{
          type: ng_zorro_antd_core_config__WEBPACK_IMPORTED_MODULE_3__["NzConfigService"]
        }, {
          type: _angular_core__WEBPACK_IMPORTED_MODULE_1__["ChangeDetectorRef"]
        }, {
          type: NzCollapseComponent,
          decorators: [{
            type: _angular_core__WEBPACK_IMPORTED_MODULE_1__["Host"]
          }]
        }, {
          type: _angular_core__WEBPACK_IMPORTED_MODULE_1__["ElementRef"]
        }, {
          type: ng_zorro_antd_core_no_animation__WEBPACK_IMPORTED_MODULE_4__["NzNoAnimationDirective"],
          decorators: [{
            type: _angular_core__WEBPACK_IMPORTED_MODULE_1__["Optional"]
          }]
        }];
      };

      NzCollapsePanelComponent.propDecorators = {
        nzActive: [{
          type: _angular_core__WEBPACK_IMPORTED_MODULE_1__["Input"]
        }],
        nzDisabled: [{
          type: _angular_core__WEBPACK_IMPORTED_MODULE_1__["Input"]
        }],
        nzShowArrow: [{
          type: _angular_core__WEBPACK_IMPORTED_MODULE_1__["Input"]
        }],
        nzExtra: [{
          type: _angular_core__WEBPACK_IMPORTED_MODULE_1__["Input"]
        }],
        nzHeader: [{
          type: _angular_core__WEBPACK_IMPORTED_MODULE_1__["Input"]
        }],
        nzExpandedIcon: [{
          type: _angular_core__WEBPACK_IMPORTED_MODULE_1__["Input"]
        }],
        nzActiveChange: [{
          type: _angular_core__WEBPACK_IMPORTED_MODULE_1__["Output"]
        }]
      };
      Object(tslib__WEBPACK_IMPORTED_MODULE_0__["__decorate"])([Object(ng_zorro_antd_core_util__WEBPACK_IMPORTED_MODULE_5__["InputBoolean"])(), Object(tslib__WEBPACK_IMPORTED_MODULE_0__["__metadata"])("design:type", Object)], NzCollapsePanelComponent.prototype, "nzActive", void 0);
      Object(tslib__WEBPACK_IMPORTED_MODULE_0__["__decorate"])([Object(ng_zorro_antd_core_util__WEBPACK_IMPORTED_MODULE_5__["InputBoolean"])(), Object(tslib__WEBPACK_IMPORTED_MODULE_0__["__metadata"])("design:type", Object)], NzCollapsePanelComponent.prototype, "nzDisabled", void 0);
      Object(tslib__WEBPACK_IMPORTED_MODULE_0__["__decorate"])([Object(ng_zorro_antd_core_config__WEBPACK_IMPORTED_MODULE_3__["WithConfig"])(), Object(ng_zorro_antd_core_util__WEBPACK_IMPORTED_MODULE_5__["InputBoolean"])(), Object(tslib__WEBPACK_IMPORTED_MODULE_0__["__metadata"])("design:type", Boolean)], NzCollapsePanelComponent.prototype, "nzShowArrow", void 0);

      (function () {
        (typeof ngDevMode === "undefined" || ngDevMode) && _angular_core__WEBPACK_IMPORTED_MODULE_1__["ɵsetClassMetadata"](NzCollapseComponent, [{
          type: _angular_core__WEBPACK_IMPORTED_MODULE_1__["Component"],
          args: [{
            selector: 'nz-collapse',
            exportAs: 'nzCollapse',
            changeDetection: _angular_core__WEBPACK_IMPORTED_MODULE_1__["ChangeDetectionStrategy"].OnPush,
            encapsulation: _angular_core__WEBPACK_IMPORTED_MODULE_1__["ViewEncapsulation"].None,
            template: "\n    <ng-content></ng-content>\n  ",
            host: {
              '[class.ant-collapse-icon-position-left]': "nzExpandIconPosition === 'left'",
              '[class.ant-collapse-icon-position-right]': "nzExpandIconPosition === 'right'",
              '[class.ant-collapse-ghost]': "nzGhost",
              '[class.ant-collapse-borderless]': '!nzBordered',
              '[class.ant-collapse-rtl]': "dir === 'rtl'"
            }
          }]
        }], function () {
          return [{
            type: ng_zorro_antd_core_config__WEBPACK_IMPORTED_MODULE_3__["NzConfigService"]
          }, {
            type: _angular_core__WEBPACK_IMPORTED_MODULE_1__["ChangeDetectorRef"]
          }, {
            type: _angular_core__WEBPACK_IMPORTED_MODULE_1__["ElementRef"]
          }, {
            type: _angular_cdk_bidi__WEBPACK_IMPORTED_MODULE_8__["Directionality"],
            decorators: [{
              type: _angular_core__WEBPACK_IMPORTED_MODULE_1__["Optional"]
            }]
          }];
        }, {
          nzAccordion: [{
            type: _angular_core__WEBPACK_IMPORTED_MODULE_1__["Input"]
          }],
          nzBordered: [{
            type: _angular_core__WEBPACK_IMPORTED_MODULE_1__["Input"]
          }],
          nzGhost: [{
            type: _angular_core__WEBPACK_IMPORTED_MODULE_1__["Input"]
          }],
          nzExpandIconPosition: [{
            type: _angular_core__WEBPACK_IMPORTED_MODULE_1__["Input"]
          }]
        });
      })();

      (function () {
        (typeof ngDevMode === "undefined" || ngDevMode) && _angular_core__WEBPACK_IMPORTED_MODULE_1__["ɵsetClassMetadata"](NzCollapsePanelComponent, [{
          type: _angular_core__WEBPACK_IMPORTED_MODULE_1__["Component"],
          args: [{
            selector: 'nz-collapse-panel',
            exportAs: 'nzCollapsePanel',
            changeDetection: _angular_core__WEBPACK_IMPORTED_MODULE_1__["ChangeDetectionStrategy"].OnPush,
            encapsulation: _angular_core__WEBPACK_IMPORTED_MODULE_1__["ViewEncapsulation"].None,
            animations: [ng_zorro_antd_core_animation__WEBPACK_IMPORTED_MODULE_2__["collapseMotion"]],
            template: "\n    <div role=\"tab\" [attr.aria-expanded]=\"nzActive\" class=\"ant-collapse-header\" (click)=\"clickHeader()\">\n      <ng-container *ngIf=\"nzShowArrow\">\n        <ng-container *nzStringTemplateOutlet=\"nzExpandedIcon; let expandedIcon\">\n          <i nz-icon [nzType]=\"expandedIcon || 'right'\" class=\"ant-collapse-arrow\" [nzRotate]=\"nzActive ? 90 : 0\"></i>\n        </ng-container>\n      </ng-container>\n      <ng-container *nzStringTemplateOutlet=\"nzHeader\">{{ nzHeader }}</ng-container>\n      <div class=\"ant-collapse-extra\" *ngIf=\"nzExtra\">\n        <ng-container *nzStringTemplateOutlet=\"nzExtra\">{{ nzExtra }}</ng-container>\n      </div>\n    </div>\n    <div\n      class=\"ant-collapse-content\"\n      [class.ant-collapse-content-active]=\"nzActive\"\n      [@.disabled]=\"noAnimation?.nzNoAnimation\"\n      [@collapseMotion]=\"nzActive ? 'expanded' : 'hidden'\"\n    >\n      <div class=\"ant-collapse-content-box\">\n        <ng-content></ng-content>\n      </div>\n    </div>\n  ",
            host: {
              '[class.ant-collapse-no-arrow]': '!nzShowArrow',
              '[class.ant-collapse-item-active]': 'nzActive',
              '[class.ant-collapse-item-disabled]': 'nzDisabled'
            }
          }]
        }], function () {
          return [{
            type: ng_zorro_antd_core_config__WEBPACK_IMPORTED_MODULE_3__["NzConfigService"]
          }, {
            type: _angular_core__WEBPACK_IMPORTED_MODULE_1__["ChangeDetectorRef"]
          }, {
            type: NzCollapseComponent,
            decorators: [{
              type: _angular_core__WEBPACK_IMPORTED_MODULE_1__["Host"]
            }]
          }, {
            type: _angular_core__WEBPACK_IMPORTED_MODULE_1__["ElementRef"]
          }, {
            type: ng_zorro_antd_core_no_animation__WEBPACK_IMPORTED_MODULE_4__["NzNoAnimationDirective"],
            decorators: [{
              type: _angular_core__WEBPACK_IMPORTED_MODULE_1__["Optional"]
            }]
          }];
        }, {
          nzActive: [{
            type: _angular_core__WEBPACK_IMPORTED_MODULE_1__["Input"]
          }],
          nzDisabled: [{
            type: _angular_core__WEBPACK_IMPORTED_MODULE_1__["Input"]
          }],
          nzShowArrow: [{
            type: _angular_core__WEBPACK_IMPORTED_MODULE_1__["Input"]
          }],
          nzActiveChange: [{
            type: _angular_core__WEBPACK_IMPORTED_MODULE_1__["Output"]
          }],
          nzExtra: [{
            type: _angular_core__WEBPACK_IMPORTED_MODULE_1__["Input"]
          }],
          nzHeader: [{
            type: _angular_core__WEBPACK_IMPORTED_MODULE_1__["Input"]
          }],
          nzExpandedIcon: [{
            type: _angular_core__WEBPACK_IMPORTED_MODULE_1__["Input"]
          }]
        });
      })();
      /**
       * Use of this source code is governed by an MIT-style license that can be
       * found in the LICENSE file at https://github.com/NG-ZORRO/ng-zorro-antd/blob/master/LICENSE
       */


      var NzCollapseModule = function NzCollapseModule() {
        _classCallCheck(this, NzCollapseModule);
      };

      NzCollapseModule.ɵfac = function NzCollapseModule_Factory(t) {
        return new (t || NzCollapseModule)();
      };

      NzCollapseModule.ɵmod = _angular_core__WEBPACK_IMPORTED_MODULE_1__["ɵɵdefineNgModule"]({
        type: NzCollapseModule
      });
      NzCollapseModule.ɵinj = _angular_core__WEBPACK_IMPORTED_MODULE_1__["ɵɵdefineInjector"]({
        imports: [[_angular_cdk_bidi__WEBPACK_IMPORTED_MODULE_8__["BidiModule"], _angular_common__WEBPACK_IMPORTED_MODULE_9__["CommonModule"], ng_zorro_antd_icon__WEBPACK_IMPORTED_MODULE_11__["NzIconModule"], ng_zorro_antd_core_outlet__WEBPACK_IMPORTED_MODULE_10__["NzOutletModule"], ng_zorro_antd_core_no_animation__WEBPACK_IMPORTED_MODULE_4__["NzNoAnimationModule"]]]
      });

      (function () {
        (typeof ngJitMode === "undefined" || ngJitMode) && _angular_core__WEBPACK_IMPORTED_MODULE_1__["ɵɵsetNgModuleScope"](NzCollapseModule, {
          declarations: function declarations() {
            return [NzCollapsePanelComponent, NzCollapseComponent];
          },
          imports: function imports() {
            return [_angular_cdk_bidi__WEBPACK_IMPORTED_MODULE_8__["BidiModule"], _angular_common__WEBPACK_IMPORTED_MODULE_9__["CommonModule"], ng_zorro_antd_icon__WEBPACK_IMPORTED_MODULE_11__["NzIconModule"], ng_zorro_antd_core_outlet__WEBPACK_IMPORTED_MODULE_10__["NzOutletModule"], ng_zorro_antd_core_no_animation__WEBPACK_IMPORTED_MODULE_4__["NzNoAnimationModule"]];
          },
          exports: function exports() {
            return [NzCollapsePanelComponent, NzCollapseComponent];
          }
        });
      })();

      (function () {
        (typeof ngDevMode === "undefined" || ngDevMode) && _angular_core__WEBPACK_IMPORTED_MODULE_1__["ɵsetClassMetadata"](NzCollapseModule, [{
          type: _angular_core__WEBPACK_IMPORTED_MODULE_1__["NgModule"],
          args: [{
            declarations: [NzCollapsePanelComponent, NzCollapseComponent],
            exports: [NzCollapsePanelComponent, NzCollapseComponent],
            imports: [_angular_cdk_bidi__WEBPACK_IMPORTED_MODULE_8__["BidiModule"], _angular_common__WEBPACK_IMPORTED_MODULE_9__["CommonModule"], ng_zorro_antd_icon__WEBPACK_IMPORTED_MODULE_11__["NzIconModule"], ng_zorro_antd_core_outlet__WEBPACK_IMPORTED_MODULE_10__["NzOutletModule"], ng_zorro_antd_core_no_animation__WEBPACK_IMPORTED_MODULE_4__["NzNoAnimationModule"]]
          }]
        }], null, null);
      })();
      /**
       * Use of this source code is governed by an MIT-style license that can be
       * found in the LICENSE file at https://github.com/NG-ZORRO/ng-zorro-antd/blob/master/LICENSE
       */

      /**
       * Generated bundle index. Do not edit.
       */
      //# sourceMappingURL=ng-zorro-antd-collapse.js.map

      /***/

    },

    /***/
    "Lql1": function Lql1(module, __webpack_exports__, __webpack_require__) {
      "use strict";

      __webpack_require__.r(__webpack_exports__);
      /* harmony export (binding) */


      __webpack_require__.d(__webpack_exports__, "CategoryService", function () {
        return CategoryService;
      });
      /* harmony import */


      var _angular_core__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(
      /*! @angular/core */
      "fXoL");
      /* harmony import */


      var _app_core_services_http_service__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(
      /*! @app/_core/services/http.service */
      "9IAc"); // import { CategoryResultsModel, CategoryResultModel } from './results.model';


      var API_CUSTOMERS_URL = 'categories';

      var CategoryService = /*#__PURE__*/function () {
        function CategoryService(httpService) {
          _classCallCheck(this, CategoryService);

          this.httpService = httpService;
        }

        _createClass(CategoryService, [{
          key: "getAll",
          value: function getAll(params) {
            return this.httpService.get(API_CUSTOMERS_URL + "/list", params);
          } // get(key): Observable<CategoryResultModel> {
          //   return this.httpService.get(`${API_CUSTOMERS_URL}/${key}.json`);
          // }

        }, {
          key: "get",
          value: function get(key) {
            return this.httpService.get("".concat(API_CUSTOMERS_URL, "/").concat(key));
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

            return this.httpService.patch("".concat(API_CUSTOMERS_URL, "/update"), model);
          }
        }, {
          key: "delete",
          value: function _delete(key) {
            return this.httpService["delete"]("".concat(API_CUSTOMERS_URL, "/").concat(key)); // return this.httpService.delete(`${API_CUSTOMERS_URL}/actions.json`);
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
            return this.httpService.download(API_CUSTOMERS_URL + "/render", params);
          }
        }, {
          key: "getCategoryData",
          value: function getCategoryData(url) {
            return this.httpService.getOut(url);
          }
        }, {
          key: "useCategory",
          value: function useCategory(CategoryId) {
            return this.httpService.post("".concat(API_CUSTOMERS_URL, "/").concat(CategoryId, "/use"), {}, false);
          }
        }]);

        return CategoryService;
      }();

      CategoryService.ɵfac = function CategoryService_Factory(t) {
        return new (t || CategoryService)(_angular_core__WEBPACK_IMPORTED_MODULE_0__["ɵɵinject"](_app_core_services_http_service__WEBPACK_IMPORTED_MODULE_1__["HttpService"]));
      };

      CategoryService.ɵprov = _angular_core__WEBPACK_IMPORTED_MODULE_0__["ɵɵdefineInjectable"]({
        token: CategoryService,
        factory: CategoryService.ɵfac,
        providedIn: 'root'
      });
      /***/
    },

    /***/
    "Q1au": function Q1au(module, __webpack_exports__, __webpack_require__) {
      "use strict";

      __webpack_require__.r(__webpack_exports__);
      /* harmony export (binding) */


      __webpack_require__.d(__webpack_exports__, "__3DHubTaskManager__", function () {
        return __3DHubTaskManager__;
      });
      /* harmony export (binding) */


      __webpack_require__.d(__webpack_exports__, "getTaskManager", function () {
        return getTaskManager;
      });
      /* harmony export (binding) */


      __webpack_require__.d(__webpack_exports__, "addTask", function () {
        return addTask;
      });
      /* harmony export (binding) */


      __webpack_require__.d(__webpack_exports__, "removeTask", function () {
        return removeTask;
      });
      /* harmony export (binding) */


      __webpack_require__.d(__webpack_exports__, "hasTask", function () {
        return hasTask;
      });
      /* harmony export (binding) */


      __webpack_require__.d(__webpack_exports__, "runTask", function () {
        return runTask;
      });
      /* harmony import */


      var _helpers_utils__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(
      /*! ./helpers/utils */
      "KgG6");

      var NO_VALUE = _helpers_utils__WEBPACK_IMPORTED_MODULE_0__["Str"].rand();

      var __3DHubTaskManager__ = typeof window['__3DHubTaskManager__'] != "undefined" && Object(_helpers_utils__WEBPACK_IMPORTED_MODULE_0__["isObject"])(window['__3DHubTaskManager__']) ? window['__3DHubTaskManager__'] : {
        tasks: {},
        add: function add(task, callable) {
          if (!Object(_helpers_utils__WEBPACK_IMPORTED_MODULE_0__["objectHasKey"])(this.tasks, task)) this.tasks[task] = [];
          return Object(_helpers_utils__WEBPACK_IMPORTED_MODULE_0__["isCallable"])(callable) && this.tasks[task].push(callable) ? true : false;
        },
        has: function has(task, callable) {
          if (!Object(_helpers_utils__WEBPACK_IMPORTED_MODULE_0__["objectHasKey"])(this.tasks, task)) return false;
          if (!this.tasks[task].length) return false;
          if (callable) return this.tasks[task].indexOf(callable) != -1;
          return true;
        },
        remove: function remove(task, callable) {
          if (!Object(_helpers_utils__WEBPACK_IMPORTED_MODULE_0__["objectHasKey"])(this.tasks, task)) return false;
          if (!this.tasks[task].length) return false;

          if (callable) {
            var i = this.tasks[task].indexOf(callable);

            if (i != -1) {
              this.tasks[task].splice(callable, 1);
              return true;
            }

            return false;
          }

          this.tasks[task].splice(0);
          delete this.tasks[task];
          return true;
        },
        run: function run(task, args) {
          if (!Object(_helpers_utils__WEBPACK_IMPORTED_MODULE_0__["objectHasKey"])(this.tasks, task)) return false;
          if (!this.tasks[task].length) return false;
          var a = args && Object(_helpers_utils__WEBPACK_IMPORTED_MODULE_0__["isArray"])(args) ? args : [];

          if (this.tasks[task].length == 1) {
            var _this$tasks$task;

            return Object(_helpers_utils__WEBPACK_IMPORTED_MODULE_0__["isCallable"])(this.tasks[task][0]) ? (_this$tasks$task = this.tasks[task])[0].apply(_this$tasks$task, _toConsumableArray(a)) : null;
          }

          var r = [];

          for (var index = 0; index < this.tasks[task].length; index++) {
            var callable = this.tasks[task][index];

            if (Object(_helpers_utils__WEBPACK_IMPORTED_MODULE_0__["isCallable"])(callable)) {
              r.push(callable.apply(void 0, _toConsumableArray(a)));
            }
          }

          return r;
        }
      };

      var getTaskManager = function getTaskManager() {
        return __3DHubTaskManager__;
      };

      var addTask = function addTask(task, callable) {
        return __3DHubTaskManager__.add(task, callable);
      };

      var removeTask = function removeTask(task, callable) {
        return __3DHubTaskManager__.remove(task, callable);
      };

      var hasTask = function hasTask(task, callable) {
        return __3DHubTaskManager__.has(task, callable);
      };

      var runTask = function runTask(task, args) {
        return __3DHubTaskManager__.run(task, args);
      };
      /***/

    },

    /***/
    "XC+3": function XC3(module, __webpack_exports__, __webpack_require__) {
      "use strict";

      __webpack_require__.r(__webpack_exports__);
      /* harmony export (binding) */


      __webpack_require__.d(__webpack_exports__, "ECategoryStatus", function () {
        return ECategoryStatus;
      });

      var ECategoryStatus;

      (function (ECategoryStatus) {
        ECategoryStatus["draft"] = "draft";
        ECategoryStatus["published"] = "published";
      })(ECategoryStatus || (ECategoryStatus = {}));
      /***/

    },

    /***/
    "YzNs": function YzNs(module, __webpack_exports__, __webpack_require__) {
      "use strict";

      __webpack_require__.r(__webpack_exports__);
      /* harmony import */


      var _app_core_helpers_utils__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(
      /*! @app/_core/helpers/utils */
      "KgG6");
      /* harmony import */


      var three__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(
      /*! three */
      "Womt");
      /* harmony import */


      var _app_core_helpers_es5_class__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(
      /*! @app/_core/helpers/es5.class */
      "pIPj");
      /* harmony import */


      var _editor__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(
      /*! ./editor */
      "Lhzb");
      /* harmony import */


      var _app_core_helpers_html_elements__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(
      /*! @app/_core/helpers/html-elements */
      "j/Uu");

      var Editor__ = Object(_app_core_helpers_es5_class__WEBPACK_IMPORTED_MODULE_2__["_class"])("ClientEditor")["extends"](_editor__WEBPACK_IMPORTED_MODULE_3__["default"])({
        transformMode: "basic",
        hasSelectedObject: false,
        posInfo: null,
        constructor: function constructor(app, engine) {
          this.setup(app, engine);
        },
        startup: function startup() {
          var scope = this;
          this.on('pointerdown', onPointerDown);
          this.on('pointerup', onPointerUp);
          this.on('pointermove', onPointerMove);

          (function () {
            window.addEventListener('keydown', function (event) {
              switch (event.keyCode) {
                case 81:
                  // Q
                  scope.executeCommand("space");
                  break;

                case 16:
                  // Shift
                  scope.executeCommand("snap");
                  break;

                case 46:
                  // delete
                  scope.deleteAttach();
                  break;

                default:
                  break;
              }
            });
          })();

          function onPointerDown(event) {
            scope.poiterDowsStatus = true;
            var rect = scope.engine.wrapper.getBoundingClientRect();
            scope.onDownPosition.x = event.clientX - rect.left;
            scope.onDownPosition.y = event.clientY - rect.top; //
            // console.log("point down");

            if (!scope.selected || scope.transformMode != "basic" || scope.selected.isLight || scope.currentTargetControl && scope.currentTargetControl == scope.control.object) {
              scope.app.canTransferEventToControls = true;
              return;
            }

            var pointer = new three__WEBPACK_IMPORTED_MODULE_1__["Vector2"]();
            pointer.x = scope.onDownPosition.x / rect.width * 2 - 1;
            pointer.y = -(scope.onDownPosition.y / rect.height) * 2 + 1;
            var detectObj = scope.selectObjectByPointer(pointer);

            if (detectObj && detectObj == scope.selected && !detectObj.isLight) {
              event.preventDefault();
              scope.engine.control.enabled = false;
              scope.control.enabled = false;
              scope.hasSelectedObject = true;
              scope.setObjectMovable(scope.selected);
              scope.app.canTransferEventToControls = false; // console.log("has obj");
            } else {
              scope.engine.control.enabled = true;
              scope.control.enabled = true;
              scope.hasSelectedObject = false; // scope.app.canTransferEventToControls = true;
              // console.log("no obj");
            }
          }

          function onPointerUp(event) {
            scope.app.canTransferEventToControls = true;

            if (scope.poiterDowsStatus) {
              if (scope.hasSelectedObject) {
                this.emit({
                  type: "object.changed",
                  data: scope.selected,
                  mode: "translate"
                });
                scope.engine.control.enabled = true;
                scope.control.enabled = true;
                scope.hasSelectedObject = false; // do somehing

                scope.removeObjectMovable();
                scope.poiterDowsStatus = false;
                return;
              }

              var rect = scope.engine.wrapper.getBoundingClientRect();
              scope.onUpPosition.x = event.clientX - rect.left;
              scope.onUpPosition.y = event.clientY - rect.top; // console.log(scope.onUpPosition.x, scope.onUpPosition.y)

              if (scope.onUpPosition.x < 0 || scope.onUpPosition.y < 0) {
                // scope.app.canTransferEventToControls = true;
                // console.log("out wp");
                return;
              }

              if (scope.onDownPosition.distanceTo(scope.onUpPosition) === 0) {
                scope.pointer.x = scope.onUpPosition.x / rect.width * 2 - 1;
                scope.pointer.y = -(scope.onUpPosition.y / rect.height) * 2 + 1;
                scope.setCurrentObjectByPointer(scope.pointer); // console.log("check current");
              } else {// scope.app.canTransferEventToControls = true;
              }
            } // else if (scope.hasSelectedObject) {
            //     scope.engine.control.enabled = true;
            //     scope.control.enabled = true;
            //     scope.hasSelectedObject = false;
            //     // do somehing
            //     scope.removeObjectMovable();
            //     setTimeout(function(){
            //         scope.app.canTransferEventToControls = true;
            //     }, 1);
            //     return;
            // }
            else {// scope.app.canTransferEventToControls = true;
              // console.log("nm");
            }

            scope.poiterDowsStatus = false;
          }

          function onPointerMove(event) {
            if (scope.poiterDowsStatus) {// scope.turnOffShadow();
            }

            if (scope.hasSelectedObject) {
              // var rect = scope.engine.wrapper.getBoundingClientRect();
              var pointer = new three__WEBPACK_IMPORTED_MODULE_1__["Vector2"]();
              pointer.x = event.clientX;
              pointer.y = event.clientY; // scope.app.canTransferEventToControls = false;

              scope.checkObjectMovablePosition(pointer);
              return;
            }
          }

          this.ready();
          this.setEngineData();
          this.emit({
            type: "startup",
            data: Object(_app_core_helpers_utils__WEBPACK_IMPORTED_MODULE_0__["getTimeStamp"])()
          });
          this.posInfo = Object(_app_core_helpers_html_elements__WEBPACK_IMPORTED_MODULE_4__["Div"])("#" + this.getInstanceID(), {
            style: {
              display: 'none',
              position: "absolute",
              opacity: 0,
              zIndex: 1000,
              width: "120px"
            },
            setPos: function setPos() {
              for (var _len = arguments.length, args = new Array(_len), _key = 0; _key < _len; _key++) {
                args[_key] = arguments[_key];
              }

              if (args.length >= 3) {
                this.callChildren("setX", [args[0]]);
                this.callChildren("setY", [args[1]]);
                this.callChildren("setZ", [args[2]]);
              } else if (args.length >= 1) {
                if (Object(_app_core_helpers_utils__WEBPACK_IMPORTED_MODULE_0__["isObject"])(args[0])) {
                  if (typeof args[0].x != "undefined") this.callChildren("setX", [args[0].x]);
                  if (typeof args[0].y != "undefined") this.callChildren("setY", [args[0].y]);
                  if (typeof args[0].z != "undefined") this.callChildren("setZ", [args[0].z]);
                }
              }
            },
            children: [Object(_app_core_helpers_html_elements__WEBPACK_IMPORTED_MODULE_4__["Div"])(".x", [Object(_app_core_helpers_html_elements__WEBPACK_IMPORTED_MODULE_4__["Span"])(".label", "x"), Object(_app_core_helpers_html_elements__WEBPACK_IMPORTED_MODULE_4__["Span"])(".space", " "), Object(_app_core_helpers_html_elements__WEBPACK_IMPORTED_MODULE_4__["Span"])(".value", {
              setX: function setX(x) {
                this.html(x);
              }
            })]), Object(_app_core_helpers_html_elements__WEBPACK_IMPORTED_MODULE_4__["Div"])(".y", [Object(_app_core_helpers_html_elements__WEBPACK_IMPORTED_MODULE_4__["Span"])(".label", "y"), Object(_app_core_helpers_html_elements__WEBPACK_IMPORTED_MODULE_4__["Span"])(".space", " "), Object(_app_core_helpers_html_elements__WEBPACK_IMPORTED_MODULE_4__["Span"])(".value", {
              setY: function setY(x) {
                this.html(x);
              }
            })]), Object(_app_core_helpers_html_elements__WEBPACK_IMPORTED_MODULE_4__["Div"])(".z", [Object(_app_core_helpers_html_elements__WEBPACK_IMPORTED_MODULE_4__["Span"])(".label", "z"), Object(_app_core_helpers_html_elements__WEBPACK_IMPORTED_MODULE_4__["Span"])(".space", " "), Object(_app_core_helpers_html_elements__WEBPACK_IMPORTED_MODULE_4__["Span"])(".value", {
              setZ: function setZ(x) {
                this.html(x);
              }
            })])]
          });
          document.body.appendChild(this.posInfo.el);
        },
        updateDropAreaAreas: function updateDropAreaAreas(sceneSize, floorPositionY, addItemAboveFloor) {
          var self = this;
          Object(_app_core_helpers_utils__WEBPACK_IMPORTED_MODULE_0__["assignValue"])(this.sceneSize, sceneSize); // this.checkMovingEngine();

          if (this.areaObjects.length) {
            this.areaObjects.map(function (o) {
              self.moving.remove(o); // self.scene.remove(o);
            });
          }

          var xStart = -sceneSize.width / 2,
              xEnd = sceneSize.width / 2,
              zStart = -sceneSize.depth / 2,
              zEnd = sceneSize.depth / 2;
          var colRow = this.dragMoveColRows;
          var areaWidth = sceneSize.width / colRow;
          var areaDepth = sceneSize.depth / colRow;
          var areaHeight = (areaDepth < areaWidth ? areaDepth : areaWidth) / 5;
          xStart += areaWidth / 2;
          xEnd -= areaWidth / 2;
          zStart += areaDepth / 2;
          zEnd -= areaDepth / 2;
          var y = addItemAboveFloor && Object(_app_core_helpers_utils__WEBPACK_IMPORTED_MODULE_0__["isNumber"])(floorPositionY) ? floorPositionY : 0;
          this.dropPosY = y;
          var boxOrigin = this.engine.Mesh.get({
            geometry: {
              type: "box",
              width: areaWidth,
              height: areaHeight,
              depth: areaDepth
            },
            material: {
              type: "basic",
              params: {
                opacity: 0
              },
              props: {
                transparent: true,
                visible: false
              }
            },
            props: {
              visible: false
            }
          });
          var xC = 0;
          var zC = 0;

          while (xC <= xEnd) {
            // if (i > 10000) break;
            // i++;
            var zz = zC;

            while (zz <= zEnd) {
              // if (j > 10000) break;
              // j++;
              var box = boxOrigin.clone(true);
              box.position.x = xC;
              box.position.y = y;
              box.position.z = zz;
              this.areaObjects.push(box);
              zz += areaDepth;
            }

            xC += areaWidth;
          }

          xC = -areaWidth;
          zC = 0;

          while (xC >= xStart) {
            var _zz = zC;

            while (_zz <= zEnd) {
              // if (j > 10000) break;
              // j++;
              var _box = boxOrigin.clone(true);

              _box.position.x = xC;
              _box.position.y = y;
              _box.position.z = _zz;
              this.areaObjects.push(_box);
              _zz += areaDepth;
            }

            xC -= areaWidth;
          }

          xC = 0;
          zC = -areaDepth;

          while (xC <= xEnd) {
            var _zz2 = zC;

            while (_zz2 >= zStart) {
              // if (j > 10000) break;
              // j++;
              var _box2 = boxOrigin.clone(true);

              _box2.position.x = xC;
              _box2.position.y = y;
              _box2.position.z = _zz2;
              this.areaObjects.push(_box2);
              _zz2 -= areaDepth;
            }

            xC += areaWidth;
          }

          xC = -areaWidth;
          zC = -areaDepth;

          while (xC >= xStart) {
            var _zz3 = zC;

            while (_zz3 >= zStart) {
              // if (j > 10000) break;
              // j++;
              var _box3 = boxOrigin.clone(true);

              _box3.position.x = xC;
              _box3.position.y = y;
              _box3.position.z = _zz3;
              this.areaObjects.push(_box3);
              _zz3 -= areaDepth;
            }

            xC -= areaWidth;
          } // var self = this;


          this.areaObjects.map(function (b) {
            self.moving.add(b); // self.scene.add(b);
          });
        },
        setObjectMovable: function setObjectMovable(item, itemPosition) {
          this.hasDroppablePosition = true;
          var box = new three__WEBPACK_IMPORTED_MODULE_1__["Box3"]().setFromObject(item); // box.getCenter(obj.position); // this re-sets the mesh position

          var dimensions = new three__WEBPACK_IMPORTED_MODULE_1__["Vector3"]();
          var size = box.getSize(dimensions);
          this.itemSize = size;
          this.dropPreviewCustomObject = true;
          this.itemShadowObject = item;
          this.areaObjects.map(function (area) {
            area.position.y = item.position.y;
          }); // this.moving.checkCamera();

          this.turnOffShadow(1000); // this.refresh();

          if (itemPosition) {
            this.checkObjectMovablePosition(itemPosition);
          }
        },
        removeObjectMovable: function removeObjectMovable() {
          if (!this.hasDroppablePosition) return false;
          this.itemShadowObject = null;
          this.hasDroppablePosition = false;
          var y = this.dropPosY;
          this.areaObjects.map(function (area) {
            area.position.y = y;
          });
        },
        checkObjectMovablePosition: function checkObjectMovablePosition(pointer) {
          var scope = this;
          if (!this.hasDroppablePosition) return false; // scope.poiterDowsStatus = false;

          var rect = scope.engine.wrapper.getBoundingClientRect();
          var x = pointer.x - rect.left;
          var y = pointer.y - rect.top; // console.log("check", x, y)

          if (x < 0 || y < 0) return;
          pointer.x = x / rect.width * 2 - 1;
          pointer.y = -(y / rect.height) * 2 + 1;
          this.movingRaycaster.setFromCamera(pointer, this.engine.camera);
          var intersects = this.movingRaycaster.intersectObjects(this.areaObjects, true); // objects

          if (intersects.length > 0) {
            var object = intersects[0].object;
            var obj = this.closestAreaScene(object);

            if (obj) {
              if (this.itemShadowObject) {
                var o = {
                  x: this.itemShadowObject.position.x,
                  z: this.itemShadowObject.position.z
                },
                    n = {
                  x: obj.position.x,
                  z: obj.position.z
                };
                var a = o.x != n.x || o.z != n.z;
                var b = n.x >= -(this.sceneSize.width - this.itemSize.x) / 2 && n.x <= (this.sceneSize.width - this.itemSize.x) / 2;
                var c = n.z >= -(this.sceneSize.depth - this.itemSize.z) / 2 && n.z <= (this.sceneSize.depth - this.itemSize.z) / 2;

                if (a && b && c) {
                  var pos = {
                    x: n.x,
                    y: this.itemShadowObject.position.y,
                    z: n.z
                  };
                  this.posInfo.css({
                    display: "block",
                    opacity: 1,
                    top: pointer.y + 20 + "px",
                    left: pointer.x + 20 + "px"
                  });
                  this.posInfo.setPos(pos);
                  Object(_app_core_helpers_utils__WEBPACK_IMPORTED_MODULE_0__["assignValue"])(this.itemShadowObject.position, n);
                  this.emit({
                    type: "object.position.move",
                    position: pos
                  });
                  scope.updateHelperByObject(this.itemShadowObject);
                  this.turnOffShadow(1000);
                  this.refresh();
                } else {
                  this.posInfo.css({
                    display: "none"
                  });
                }
              } else {
                this.posInfo.css({
                  display: "none"
                });
              }
            } else {
              this.turnOffShadow(1000);
              this.refresh();
            }
          } else {
            this.posInfo.css({
              display: "none"
            });
          }
        },
        updateHelperByObject: function updateHelperByObject(object) {
          var scope = this;

          if (object !== undefined) {
            var helper = scope.helpers[object.id];

            if (helper !== undefined && helper.isSkeletonHelper !== true) {
              if (object.position) helper.position.copy(object.position);
              if (object.rotation) helper.rotation.copy(object.rotation);
              if (object.scale) helper.scale.copy(object.scale);
              helper.update();
            } // signals.refreshSidebarObject3D.dispatch(object);
            // scope.engine.refresh();

          }
        },
        addObject: function addObject(object) {
          this.objects.push(object);
          this.setCurrentObject(object);
        },
        addLight: function addLight(light) {
          if (Object(_app_core_helpers_utils__WEBPACK_IMPORTED_MODULE_0__["isObject"])(light) && light.isLight) {
            var helper = this.getHelper(light);

            if (helper) {
              helper.position.copy(light.position);
              this.scene.add(helper);
              helper.visible = false;

              if (helper.children) {
                for (var index = 0; index < helper.children.length; index++) {
                  var child = helper.children[index];
                  var i = this.pickers.indexOf(child);

                  if (i == -1) {
                    this.pickers.push(child);
                  }
                }
              }
            }

            if (light.target) {
              light.target.position.y = this.engine.dropbyPositionY;
              this.scene.add(light.target);
            }

            this.lights.push(light); // this.setCurrentLight(light);
          }
        },
        setCurrent: function setCurrent(object) {
          if (!object) {
            if (this.selected) {
              if (this.selected.isTargetControlObject) {
                this.detactLightTargetControl();
              } else if (this.currentLightt) {
                this.unsetCurrentLight();
              } else {
                this.unsetCurrentObject();
              }
            } // else {


            this.control.detach(); // }
            // this.selected = null;

            this.engine.refresh();
            return this;
          }

          if (this.selected === object) return;
          var uuid = null;
          uuid = object.uuid;
          this.selected = object;

          if (!object.isLight) {
            this.setCurrentObject(object);
          } else {
            this.setCurrentLight(object);
          } // this.config.setKey( 'selected', uuid );
          // this.signals.objectSelected.dispatch( object );


          this.engine.refresh();
        },
        setCurrentObject: function setCurrentObject(object3D) {
          if (this.currentLight) {
            this.unsetCurrentLight();
          }

          if (this.currentObject) {
            this.unsetCurrentObject();
          }

          this.currentObject = object3D;
          this.selected = object3D;
          var helper = this.getHelper(object3D);
          this.helper = helper; // this.control.attach(object3D);

          this.scene.remove(helper);
          this.scene.add(helper);
          this.dispatchEvent({
            type: 'object.set-current',
            object: object3D,
            mode: this.transformMode
          });
          this.engine.refresh();
          return false;
        },
        setCurrentLight: function setCurrentLight(light) {
          if (!light) {
            console.warn("Lỗi kkho có ligh");
            return;
          }

          if (this.currentLight) {
            this.unsetCurrentLight();
          }

          if (this.currentObject) {
            this.unsetCurrentObject();
          }

          this.currentLight = light;
          this.control.detach();
          this.control.attach(light);
          this.selected = light;

          if (!light.targetControlObject) {
            var targetControl = this.getLightTargetControlObject(light);

            if (targetControl) {
              light.targetControlObject = targetControl;
              this.scene.remove(targetControl);
              this.scene.add(targetControl);
            }
          }

          this.dispatchEvent({
            type: 'light.set-current',
            light: light,
            mode: this.control.mode
          });
        },
        unsetCurrentLight: function unsetCurrentLight() {
          this.detachLight();
          this.dispatchEvent({
            type: 'light.unset-current',
            mode: this.control.mode
          });
        },
        unsetCurrentObject: function unsetCurrentObject() {
          this.detachObject();
          this.dispatchEvent({
            type: 'object.unset-current',
            mode: this.control.mode
          });
        },

        /**
         * chọn object
         * @param {Vector3} pointer diểm click
         * @returns
         */
        selectObjectByPointer: function selectObjectByPointer(pointer) {
          var scope = this;
          this.raycaster.setFromCamera(pointer, this.engine.camera);
          /**
           * thứ tự ưu tiên
           * 1 object
           * 2 target
           * 3 light
           */

          var intersects = this.raycaster.intersectObjects(this.objects, true); // objects

          if (intersects.length > 0) {
            var object = intersects[0].object;
            var obj = this.closestObjectInScene(object);

            if (obj) {
              return obj;
            }
          }

          var targetIntersects = this.raycaster.intersectObjects(this.targets, true);

          if (targetIntersects.length) {
            var target = this.closestLightTargetControlInScene(targetIntersects[0].object);

            if (target) {
              // this.attachLightTargetControl(target);
              return target;
            }
          } // ligjy


          var lightIntersects = this.raycaster.intersectObjects(this.lights, true);

          if (lightIntersects.length > 0) {
            var _object = lightIntersects[0].object;
            var light = this.closestLightInScene(_object);

            if (light) {
              return light;
            }
          }

          var pickerIntersects = this.raycaster.intersectObjects(this.pickers, true);

          if (pickerIntersects.length > 0) {
            var _object2 = pickerIntersects[0].object;

            var _light = this.closestLightInScene(_object2);

            if (_light) {
              return _light;
            }
          }

          return null;
        },

        /**
         * chọn object
         * @param {Vector3} pointer diểm click
         * @returns
         */
        setCurrentObjectByPointer: function setCurrentObjectByPointer(pointer) {
          var scope = this;
          this.raycaster.setFromCamera(pointer, this.engine.camera);
          /**
           * thứ tự ưu tiên
           * 1 object
           * 2 target
           * 3 light
           */

          if (!this.lightHelperStatus) {
            var intersects = this.raycaster.intersectObjects(this.objects, true); // objects

            if (intersects.length > 0) {
              var object = intersects[0].object;
              var obj = this.closestObjectInScene(object);

              if (obj) {
                if (obj !== this.selected) {
                  if (this.currentObject && this.currentObject != obj) {
                    this.setCurrent(null);
                  }

                  this.transformMode = 'basic';
                  this.setCurrent(obj); // scope.app.canTransferEventToControls = true;
                }

                return;
              }
            }
          } else {
            var targetIntersects = this.raycaster.intersectObjects(this.targets, true);

            if (targetIntersects.length) {
              var target = this.closestLightTargetControlInScene(targetIntersects[0].object);

              if (target) {
                this.transformMode = 'basic';
                this.attachLightTargetControl(target); // scope.app.canTransferEventToControls = true;

                return;
              }
            } /// light


            if (this.currentLight && this.currentTargetControl && this.currentTargetControl.light == this.currentLight) {
              this.detactLightTargetControl();
              this.transformMode = 'basic';
              this.control.attach(this.currentLight); // scope.app.canTransferEventToControls = true;
            } else {
              this.detactLightTargetControl();
            } // ligjy


            var lightIntersects = this.raycaster.intersectObjects(this.lights, true);

            if (lightIntersects.length > 0) {
              var _object3 = lightIntersects[0].object;
              var light = this.closestLightInScene(_object3);

              if (light) {
                if (light != this.control.object) {
                  if (this.currentLight && this.currentLight != light) {
                    this.setCurrent(null);
                  }

                  this.setCurrent(light);
                  this.transformMode = 'basic';
                } // scope.app.canTransferEventToControls = true;


                return;
              }
            }

            var pickerIntersects = this.raycaster.intersectObjects(this.pickers, true);

            if (pickerIntersects.length > 0) {
              var _object4 = pickerIntersects[0].object;

              var _light2 = this.closestLightInScene(_object4);

              if (_light2) {
                if (_light2 != this.control.object) {
                  if (this.currentLight && this.currentLight != _light2) {
                    this.setCurrent(null);
                  }

                  this.setCurrent(_light2);
                  this.transformMode = 'basic';
                } // scope.app.canTransferEventToControls = true;


                return;
              }
            }
          }

          if (this.currentLight) this.detachLight();
          if (this.currentObject) this.detachObject();

          if (this.currentTargetControl) {
            this.scene.remove(this.currentTargetControl); // this.select(null);
          }

          this.transformMode = 'basic';
          this.control.detach();
          this.setCurrent(null);
          this.select(null);
          this.selected = null; // this.engine.refresh();
        },
        unselect: function unselect() {
          this.transformMode = 'basic';
          this.control.detach();
          this.setCurrent(null);
          this.select(null);
          this.selected = null;
        },

        /**
         * tìm object trong bảng
         * @param {Object} obj
         * @returns {Object#d|Group|Mesh}
         */
        closestLightTargetControlInScene: function closestLightTargetControlInScene(obj) {
          if (Object(_app_core_helpers_utils__WEBPACK_IMPORTED_MODULE_0__["isObject"])(obj) && !obj.isScene && this.currentLight) {
            var light = this.currentLight;

            for (var i = 0; i < this.targets.length; i++) {
              var sobj = this.targets[i];
              if (obj == sobj && sobj.light == light) return sobj;
            }

            if (obj.parent) {
              return this.closestLightInScene(obj.parent);
            }
          }

          return null;
        },
        isSelected: function isSelected(object) {
          return object == this.selected ? true : object.isScene || !object.parent ? false : this.isSelected(object.parent);
        },
        attachObject: function attachObject(object3D) {
          if (this.currentLight) {
            this.detachLight();
          }

          if (this.currentObject) {
            this.detachObject();
          }

          this.currentObject = object3D;
          var helper = this.getHelper(object3D);
          this.helper = helper;
          this.control.attach(object3D);
          this.scene.remove(helper);
          this.scene.add(helper); // this.dispatchEvent({
          //     type: 'object.attach',
          //     object: object3D,
          //     mode: this.control.mode
          // });
          // this.engine.refresh();

          return false;
        },
        detachObject: function detachObject() {
          this.control.detach();

          if (this.helper) {
            this.helper.position.set(0, 0, 0);
            this.helper.rotation.set(0, 0, 0);
            this.helper.scale.set(1, 1, 1);
            this.scene.remove(this.helper);
          }

          var obj = this.currentObject;
          this.currentObject = null; // this.dispatchEvent({
          //     type: 'object.detach',
          //     object: obj
          // });

          this.engine.refresh();
        },
        attachLight: function attachLight(light) {
          if (!light) {
            console.warn("Lỗi kkho có ligh");
            return;
          }

          if (this.currentObject) {
            this.detachObject();
          }

          if (this.currentLight) {
            this.detachLight();
          }

          this.currentLight = light;
          this.control.attach(light);
          var targetControl = this.getLightTargetControlObject(light);

          if (targetControl) {
            this.scene.remove(targetControl);
            this.scene.add(targetControl);
          } // this.dispatchEvent({
          //     type: 'light.attach',
          //     light: light,
          //     mode: this.control.mode
          // });

        },
        detachLight: function detachLight() {
          this.control.detach();
          var obj = this.currentLight;
          var targetControl = this.getLightTargetControlObject(obj);

          if (targetControl) {
            this.scene.remove(targetControl);
          }

          this.currentLight = null;
          this.selected = null; // this.dispatchEvent({
          //     type: 'light.detach',
          //     light: obj
          // });
        },
        executeCommand: function executeCommand(command) {
          if (!this.control.object) {
            if (this.selected) {
              if (!this.selected.isLight) {
                this.attachObject(this.selected);
              } else {
                this.attachLight(this.selected);
              }

              this.transformMode = command;
            }
          }

          if (this.control.object && this.control.object.isTargetControlObject) {
            command = 'translate';
          }

          switch (command) {
            case "space":
              this.control.setSpace(this.control.space === "local" ? "world" : "local");
              break;

            case "snap":
              this.control.setTranslationSnap(100);
              this.control.setRotationSnap(three__WEBPACK_IMPORTED_MODULE_1__["MathUtils"].degToRad(15));
              this.control.setScaleSnap(0.25);
              break;

            case 'unsnap':
              this.control.setTranslationSnap(null);
              this.control.setRotationSnap(null);
              this.control.setScaleSnap(null);
              break;

            case "translate":
              this.control.setMode("translate");
              break;

            case "rotate":
              this.control.setMode("rotate");
              break;

            case "scale":
              this.control.setMode("scale");
              break;

            case "upsize":
              this.control.setSize(this.control.size + 0.1);
              break;

            case "downsize":
              this.control.setSize(Math.max(this.control.size - 0.1, 0.1));
              break;

            case "toggle:x":
              this.control.showX = !this.control.showX;
              break;

            case "toggle:y":
              this.control.showY = !this.control.showY;
              break;

            case "toggle:z":
              this.control.showZ = !this.control.showZ;
              break;

            case "enable":
              this.control.enabled = !this.control.enabled;
              break;

            default:
              break;
          }

          this.engine.refresh();
        }
      });
      var ClientEditor = Editor__;
      /* harmony default export */

      __webpack_exports__["default"] = ClientEditor;
      /***/
    },

    /***/
    "ZWsj": function ZWsj(module, __webpack_exports__, __webpack_require__) {
      "use strict";

      __webpack_require__.r(__webpack_exports__);
      /* harmony export (binding) */


      __webpack_require__.d(__webpack_exports__, "CategoryResultsModel", function () {
        return CategoryResultsModel;
      });
      /* harmony export (binding) */


      __webpack_require__.d(__webpack_exports__, "CategoryResultModel", function () {
        return CategoryResultModel;
      });

      var CategoryResultsModel = function CategoryResultsModel() {
        _classCallCheck(this, CategoryResultsModel);
      };

      var CategoryResultModel = function CategoryResultModel() {
        _classCallCheck(this, CategoryResultModel);
      };
      /***/

    },

    /***/
    "aGpf": function aGpf(module, __webpack_exports__, __webpack_require__) {
      "use strict";

      __webpack_require__.r(__webpack_exports__);
      /* harmony import */


      var _model__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(
      /*! ./model */
      "XC+3");
      /* harmony reexport (safe) */


      __webpack_require__.d(__webpack_exports__, "ECategoryStatus", function () {
        return _model__WEBPACK_IMPORTED_MODULE_0__["ECategoryStatus"];
      });
      /* harmony import */


      var _results_model__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(
      /*! ./results.model */
      "ZWsj");
      /* harmony reexport (safe) */


      __webpack_require__.d(__webpack_exports__, "CategoryResultsModel", function () {
        return _results_model__WEBPACK_IMPORTED_MODULE_1__["CategoryResultsModel"];
      });
      /* harmony reexport (safe) */


      __webpack_require__.d(__webpack_exports__, "CategoryResultModel", function () {
        return _results_model__WEBPACK_IMPORTED_MODULE_1__["CategoryResultModel"];
      });
      /* harmony import */


      var _service__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(
      /*! ./service */
      "Lql1");
      /* harmony reexport (safe) */


      __webpack_require__.d(__webpack_exports__, "CategoryService", function () {
        return _service__WEBPACK_IMPORTED_MODULE_2__["CategoryService"];
      });
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
          for (var _len2 = arguments.length, args = new Array(_len2), _key2 = 0; _key2 < _len2; _key2++) {
            args[_key2] = arguments[_key2];
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

            for (var _len3 = arguments.length, args = new Array(_len3), _key3 = 0; _key3 < _len3; _key3++) {
              args[_key3] = arguments[_key3];
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

            for (var _len4 = arguments.length, args = new Array(_len4), _key4 = 0; _key4 < _len4; _key4++) {
              args[_key4] = arguments[_key4];
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
//# sourceMappingURL=default~item-page-item-module~project-page-project-module~template-page-template-module-es5.js.map