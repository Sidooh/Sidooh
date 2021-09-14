(window["webpackJsonp"] = window["webpackJsonp"] || []).push([[2], {

    /***/
    "./node_modules/@coreui/utils/src/deep-objects-merge.js":
    /*!**************************************************************!*\
      !*** ./node_modules/@coreui/utils/src/deep-objects-merge.js ***!
      \**************************************************************/
    /*! exports provided: default */
    /***/ (function (module, __webpack_exports__, __webpack_require__) {

        "use strict";
        __webpack_require__.r(__webpack_exports__);
        const deepObjectsMerge = (target, source) => {
            // Iterate through `source` properties and if an `Object` set property to merge of `target` and `source` properties
            for (const key of Object.keys(source)) {
                if (source[key] instanceof Object) {
                    Object.assign(source[key], deepObjectsMerge(target[key], source[key]))
                }
            }

            // Join `target` and modified `source`
            Object.assign(target || {}, source)
            return target
        }

        /* harmony default export */
        __webpack_exports__["default"] = (deepObjectsMerge);


        /***/
    }),

    /***/
    "./node_modules/@coreui/utils/src/get-color.js":
    /*!*****************************************************!*\
      !*** ./node_modules/@coreui/utils/src/get-color.js ***!
      \*****************************************************/
    /*! exports provided: default */
    /***/ (function (module, __webpack_exports__, __webpack_require__) {

        "use strict";
        __webpack_require__.r(__webpack_exports__);
        /* harmony import */
        var _get_style__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./get-style */ "./node_modules/@coreui/utils/src/get-style.js");


        const getColor = (rawProperty, element = document.body) => {
            const property = `--${rawProperty}`
            const style = Object(_get_style__WEBPACK_IMPORTED_MODULE_0__["default"])(property, element)
            return style ? style : rawProperty
        }

        /* harmony default export */
        __webpack_exports__["default"] = (getColor);


        /***/
    }),

    /***/
    "./node_modules/@coreui/utils/src/get-css-custom-properties.js":
    /*!*********************************************************************!*\
      !*** ./node_modules/@coreui/utils/src/get-css-custom-properties.js ***!
      \*********************************************************************/
    /*! exports provided: default */
    /***/ (function (module, __webpack_exports__, __webpack_require__) {

        "use strict";
        __webpack_require__.r(__webpack_exports__);
        /**
         * --------------------------------------------------------------------------
         * Licensed under MIT (https://coreui.io/license)
         * @returns {string} css custom property name
         * --------------------------------------------------------------------------
         */
        const getCssCustomProperties = () => {
            const cssCustomProperties = {}
            const sheets = document.styleSheets
            let cssText = ''
            for (let i = sheets.length - 1; i > -1; i--) {
                const rules = sheets[i].cssRules
                for (let j = rules.length - 1; j > -1; j--) {
                    if (rules[j].selectorText === '.ie-custom-properties') {
                        // eslint-disable-next-line prefer-destructuring
                        cssText = rules[j].cssText
                        break
                    }
                }

                if (cssText) {
                    break
                }
            }

            // eslint-disable-next-line unicorn/prefer-string-slice
            cssText = cssText.substring(
                cssText.lastIndexOf('{') + 1,
                cssText.lastIndexOf('}')
            )

            cssText.split(';').forEach(property => {
                if (property) {
                    const name = property.split(': ')[0]
                    const value = property.split(': ')[1]
                    if (name && value) {
                        cssCustomProperties[`--${name.trim()}`] = value.trim()
                    }
                }
            })
            return cssCustomProperties
        }

        /* harmony default export */
        __webpack_exports__["default"] = (getCssCustomProperties);


        /***/
    }),

    /***/
    "./node_modules/@coreui/utils/src/get-style.js":
    /*!*****************************************************!*\
      !*** ./node_modules/@coreui/utils/src/get-style.js ***!
      \*****************************************************/
    /*! exports provided: default */
    /***/ (function (module, __webpack_exports__, __webpack_require__) {

        "use strict";
        __webpack_require__.r(__webpack_exports__);
        /* harmony import */
        var _get_css_custom_properties__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./get-css-custom-properties */ "./node_modules/@coreui/utils/src/get-css-custom-properties.js");


        const minIEVersion = 10
        const isIE1x = () => Boolean(document.documentMode) && document.documentMode >= minIEVersion
        const isCustomProperty = property => property.match(/^--.*/i)

        const getStyle = (property, element = document.body) => {
            let style

            if (isCustomProperty(property) && isIE1x()) {
                const cssCustomProperties = Object(_get_css_custom_properties__WEBPACK_IMPORTED_MODULE_0__["default"])()
                style = cssCustomProperties[property]
            } else {
                style = window.getComputedStyle(element, null).getPropertyValue(property).replace(/^\s/, '')
            }

            return style
        }

        /* harmony default export */
        __webpack_exports__["default"] = (getStyle);


        /***/
    }),

    /***/
    "./node_modules/@coreui/utils/src/hex-to-rgb.js":
    /*!******************************************************!*\
      !*** ./node_modules/@coreui/utils/src/hex-to-rgb.js ***!
      \******************************************************/
    /*! exports provided: default */
    /***/ (function (module, __webpack_exports__, __webpack_require__) {

        "use strict";
        __webpack_require__.r(__webpack_exports__);
        /* eslint-disable no-magic-numbers */
        const hexToRgb = color => {
            if (typeof color === 'undefined') {
                throw new TypeError('Hex color is not defined')
            }

            const hex = color.match(/^#(?:[0-9a-f]{3}){1,2}$/i)

            if (!hex) {
                throw new Error(`${color} is not a valid hex color`)
            }

            let r
            let g
            let b

            if (color.length === 7) {
                r = parseInt(color.slice(1, 3), 16)
                g = parseInt(color.slice(3, 5), 16)
                b = parseInt(color.slice(5, 7), 16)
            } else {
                r = parseInt(color.slice(1, 2), 16)
                g = parseInt(color.slice(2, 3), 16)
                b = parseInt(color.slice(3, 5), 16)
            }

            return `rgba(${r}, ${g}, ${b})`
        }

        /* harmony default export */
        __webpack_exports__["default"] = (hexToRgb);


        /***/
    }),

    /***/
    "./node_modules/@coreui/utils/src/hex-to-rgba.js":
    /*!*******************************************************!*\
      !*** ./node_modules/@coreui/utils/src/hex-to-rgba.js ***!
      \*******************************************************/
    /*! exports provided: default */
    /***/ (function (module, __webpack_exports__, __webpack_require__) {

        "use strict";
        __webpack_require__.r(__webpack_exports__);
        /* eslint-disable no-magic-numbers */
        const hexToRgba = (color, opacity = 100) => {
            if (typeof color === 'undefined') {
                throw new TypeError('Hex color is not defined')
            }

            const hex = color.match(/^#(?:[0-9a-f]{3}){1,2}$/i)

            if (!hex) {
                throw new Error(`${color} is not a valid hex color`)
            }

            let r
            let g
            let b

            if (color.length === 7) {
                r = parseInt(color.slice(1, 3), 16)
                g = parseInt(color.slice(3, 5), 16)
                b = parseInt(color.slice(5, 7), 16)
            } else {
                r = parseInt(color.slice(1, 2), 16)
                g = parseInt(color.slice(2, 3), 16)
                b = parseInt(color.slice(3, 5), 16)
            }

            return `rgba(${r}, ${g}, ${b}, ${opacity / 100})`
        }

        /* harmony default export */
        __webpack_exports__["default"] = (hexToRgba);


        /***/
    }),

    /***/
    "./node_modules/@coreui/utils/src/index.js":
    /*!*************************************************!*\
      !*** ./node_modules/@coreui/utils/src/index.js ***!
      \*************************************************/
    /*! exports provided: default, deepObjectsMerge, getColor, getStyle, hexToRgb, hexToRgba, makeUid, omitByKeys, pickByKeys, rgbToHex */
    /***/ (function (module, __webpack_exports__, __webpack_require__) {

        "use strict";
        __webpack_require__.r(__webpack_exports__);
        /* harmony import */
        var _deep_objects_merge__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./deep-objects-merge */ "./node_modules/@coreui/utils/src/deep-objects-merge.js");
        /* harmony reexport (safe) */
        __webpack_require__.d(__webpack_exports__, "deepObjectsMerge", function () {
            return _deep_objects_merge__WEBPACK_IMPORTED_MODULE_0__["default"];
        });

        /* harmony import */
        var _get_color__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./get-color */ "./node_modules/@coreui/utils/src/get-color.js");
        /* harmony reexport (safe) */
        __webpack_require__.d(__webpack_exports__, "getColor", function () {
            return _get_color__WEBPACK_IMPORTED_MODULE_1__["default"];
        });

        /* harmony import */
        var _get_style__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./get-style */ "./node_modules/@coreui/utils/src/get-style.js");
        /* harmony reexport (safe) */
        __webpack_require__.d(__webpack_exports__, "getStyle", function () {
            return _get_style__WEBPACK_IMPORTED_MODULE_2__["default"];
        });

        /* harmony import */
        var _hex_to_rgb__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ./hex-to-rgb */ "./node_modules/@coreui/utils/src/hex-to-rgb.js");
        /* harmony reexport (safe) */
        __webpack_require__.d(__webpack_exports__, "hexToRgb", function () {
            return _hex_to_rgb__WEBPACK_IMPORTED_MODULE_3__["default"];
        });

        /* harmony import */
        var _hex_to_rgba__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! ./hex-to-rgba */ "./node_modules/@coreui/utils/src/hex-to-rgba.js");
        /* harmony reexport (safe) */
        __webpack_require__.d(__webpack_exports__, "hexToRgba", function () {
            return _hex_to_rgba__WEBPACK_IMPORTED_MODULE_4__["default"];
        });

        /* harmony import */
        var _make_uid__WEBPACK_IMPORTED_MODULE_5__ = __webpack_require__(/*! ./make-uid */ "./node_modules/@coreui/utils/src/make-uid.js");
        /* harmony reexport (safe) */
        __webpack_require__.d(__webpack_exports__, "makeUid", function () {
            return _make_uid__WEBPACK_IMPORTED_MODULE_5__["default"];
        });

        /* harmony import */
        var _omit_by_keys__WEBPACK_IMPORTED_MODULE_6__ = __webpack_require__(/*! ./omit-by-keys */ "./node_modules/@coreui/utils/src/omit-by-keys.js");
        /* harmony reexport (safe) */
        __webpack_require__.d(__webpack_exports__, "omitByKeys", function () {
            return _omit_by_keys__WEBPACK_IMPORTED_MODULE_6__["default"];
        });

        /* harmony import */
        var _pick_by_keys__WEBPACK_IMPORTED_MODULE_7__ = __webpack_require__(/*! ./pick-by-keys */ "./node_modules/@coreui/utils/src/pick-by-keys.js");
        /* harmony reexport (safe) */
        __webpack_require__.d(__webpack_exports__, "pickByKeys", function () {
            return _pick_by_keys__WEBPACK_IMPORTED_MODULE_7__["default"];
        });

        /* harmony import */
        var _rgb_to_hex__WEBPACK_IMPORTED_MODULE_8__ = __webpack_require__(/*! ./rgb-to-hex */ "./node_modules/@coreui/utils/src/rgb-to-hex.js");
        /* harmony reexport (safe) */
        __webpack_require__.d(__webpack_exports__, "rgbToHex", function () {
            return _rgb_to_hex__WEBPACK_IMPORTED_MODULE_8__["default"];
        });


        const utils = {
            deepObjectsMerge: _deep_objects_merge__WEBPACK_IMPORTED_MODULE_0__["default"],
            getColor: _get_color__WEBPACK_IMPORTED_MODULE_1__["default"],
            getStyle: _get_style__WEBPACK_IMPORTED_MODULE_2__["default"],
            hexToRgb: _hex_to_rgb__WEBPACK_IMPORTED_MODULE_3__["default"],
            hexToRgba: _hex_to_rgba__WEBPACK_IMPORTED_MODULE_4__["default"],
            makeUid: _make_uid__WEBPACK_IMPORTED_MODULE_5__["default"],
            omitByKeys: _omit_by_keys__WEBPACK_IMPORTED_MODULE_6__["default"],
            pickByKeys: _pick_by_keys__WEBPACK_IMPORTED_MODULE_7__["default"],
            rgbToHex: _rgb_to_hex__WEBPACK_IMPORTED_MODULE_8__["default"]
        }

        /* harmony default export */
        __webpack_exports__["default"] = (utils);


        /***/
    }),

    /***/
    "./node_modules/@coreui/utils/src/make-uid.js":
    /*!****************************************************!*\
      !*** ./node_modules/@coreui/utils/src/make-uid.js ***!
      \****************************************************/
    /*! exports provided: default */
    /***/ (function (module, __webpack_exports__, __webpack_require__) {

        "use strict";
        __webpack_require__.r(__webpack_exports__);
//function for UI releted ID assignment, due to one in 10^15 probability of duplication
        const makeUid = () => {
            const key = Math.random().toString(36).substr(2)
            return 'uid-' + key
        }

        /* harmony default export */
        __webpack_exports__["default"] = (makeUid);

        /***/
    }),

    /***/
    "./node_modules/@coreui/utils/src/omit-by-keys.js":
    /*!********************************************************!*\
      !*** ./node_modules/@coreui/utils/src/omit-by-keys.js ***!
      \********************************************************/
    /*! exports provided: default */
    /***/ (function (module, __webpack_exports__, __webpack_require__) {

        "use strict";
        __webpack_require__.r(__webpack_exports__);
        const omitByKeys = (originalObject, keys) => {
            var newObj = {}
            var objKeys = Object.keys(originalObject)
            for (var i = 0; i < objKeys.length; i++) {
                !keys.includes(objKeys[i]) && (newObj[objKeys[i]] = originalObject[objKeys[i]])
            }
            return newObj
        }

        /* harmony default export */
        __webpack_exports__["default"] = (omitByKeys);

        /***/
    }),

    /***/
    "./node_modules/@coreui/utils/src/pick-by-keys.js":
    /*!********************************************************!*\
      !*** ./node_modules/@coreui/utils/src/pick-by-keys.js ***!
      \********************************************************/
    /*! exports provided: default */
    /***/ (function (module, __webpack_exports__, __webpack_require__) {

        "use strict";
        __webpack_require__.r(__webpack_exports__);
        const pickByKeys = (originalObject, keys) => {
            var newObj = {}
            for (var i = 0; i < keys.length; i++) {
                newObj[keys[i]] = originalObject[keys[i]]
            }
            return newObj
        }

        /* harmony default export */
        __webpack_exports__["default"] = (pickByKeys);

        /***/
    }),

    /***/
    "./node_modules/@coreui/utils/src/rgb-to-hex.js":
    /*!******************************************************!*\
      !*** ./node_modules/@coreui/utils/src/rgb-to-hex.js ***!
      \******************************************************/
    /*! exports provided: default */
    /***/ (function (module, __webpack_exports__, __webpack_require__) {

        "use strict";
        __webpack_require__.r(__webpack_exports__);
        /* eslint-disable no-magic-numbers */
        const rgbToHex = color => {
            if (typeof color === 'undefined') {
                throw new TypeError('Hex color is not defined')
            }

            if (color === 'transparent') {
                return '#00000000'
            }

            const rgb = color.match(/^rgba?[\s+]?\([\s+]?(\d+)[\s+]?,[\s+]?(\d+)[\s+]?,[\s+]?(\d+)[\s+]?/i)

            if (!rgb) {
                throw new Error(`${color} is not a valid rgb color`)
            }

            const r = `0${parseInt(rgb[1], 10).toString(16)}`
            const g = `0${parseInt(rgb[2], 10).toString(16)}`
            const b = `0${parseInt(rgb[3], 10).toString(16)}`

            return `#${r.slice(-2)}${g.slice(-2)}${b.slice(-2)}`
        }

        /* harmony default export */
        __webpack_exports__["default"] = (rgbToHex);


        /***/
    }),

    /***/
    "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/CChartLineSimple.vue?vue&type=script&lang=js&":
    /*!***************************************************************************************************************************************************************************!*\
      !*** ./node_modules/babel-loader/lib??ref--4-0!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/components/CChartLineSimple.vue?vue&type=script&lang=js& ***!
      \***************************************************************************************************************************************************************************/
    /*! exports provided: default */
    /***/ (function (module, __webpack_exports__, __webpack_require__) {

        "use strict";
        __webpack_require__.r(__webpack_exports__);
        /* harmony import */
        var _coreui_vue_chartjs__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @coreui/vue-chartjs */ "./node_modules/@coreui/vue-chartjs/dist/coreui-vue-chartjs.common.js");
        /* harmony import */
        var _coreui_vue_chartjs__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_coreui_vue_chartjs__WEBPACK_IMPORTED_MODULE_0__);
        /* harmony import */
        var _coreui_utils_src__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! @coreui/utils/src */ "./node_modules/@coreui/utils/src/index.js");

        function ownKeys(object, enumerableOnly) {
            var keys = Object.keys(object);
            if (Object.getOwnPropertySymbols) {
                var symbols = Object.getOwnPropertySymbols(object);
                if (enumerableOnly) symbols = symbols.filter(function (sym) {
                    return Object.getOwnPropertyDescriptor(object, sym).enumerable;
                });
                keys.push.apply(keys, symbols);
            }
            return keys;
        }

        function _objectSpread(target) {
            for (var i = 1; i < arguments.length; i++) {
                var source = arguments[i] != null ? arguments[i] : {};
                if (i % 2) {
                    ownKeys(Object(source), true).forEach(function (key) {
                        _defineProperty(target, key, source[key]);
                    });
                } else if (Object.getOwnPropertyDescriptors) {
                    Object.defineProperties(target, Object.getOwnPropertyDescriptors(source));
                } else {
                    ownKeys(Object(source)).forEach(function (key) {
                        Object.defineProperty(target, key, Object.getOwnPropertyDescriptor(source, key));
                    });
                }
            }
            return target;
        }

        function _defineProperty(obj, key, value) {
            if (key in obj) {
                Object.defineProperty(obj, key, {value: value, enumerable: true, configurable: true, writable: true});
            } else {
                obj[key] = value;
            }
            return obj;
        }

//
//
//
//
//
//
//
//


        /* harmony default export */
        __webpack_exports__["default"] = ({
            name: 'CChartLineSimple',
            components: {
                CChartLine: _coreui_vue_chartjs__WEBPACK_IMPORTED_MODULE_0__["CChartLine"]
            },
            props: _objectSpread(_objectSpread({}, _coreui_vue_chartjs__WEBPACK_IMPORTED_MODULE_0__["CChartLine"].props), {}, {
                borderColor: {
                    type: String,
                    "default": 'rgba(255,255,255,.55)'
                },
                backgroundColor: {
                    type: String,
                    "default": 'transparent'
                },
                dataPoints: {
                    type: Array,
                    "default": function _default() {
                        return [10, 22, 34, 46, 58, 70, 46, 23, 45, 78, 34, 12];
                    }
                },
                label: {
                    type: String,
                    "default": 'Sales'
                },
                pointed: Boolean,
                pointHoverBackgroundColor: String
            }),
            computed: {
                pointHoverColor: function pointHoverColor() {
                    if (this.pointHoverBackgroundColor) {
                        return this.pointHoverBackgroundColor;
                    } else if (this.backgroundColor !== 'transparent') {
                        return this.backgroundColor;
                    }

                    return this.borderColor;
                },
                defaultDatasets: function defaultDatasets() {
                    return [{
                        data: this.dataPoints,
                        borderColor: Object(_coreui_utils_src__WEBPACK_IMPORTED_MODULE_1__["getColor"])(this.borderColor),
                        backgroundColor: Object(_coreui_utils_src__WEBPACK_IMPORTED_MODULE_1__["getColor"])(this.backgroundColor),
                        pointBackgroundColor: Object(_coreui_utils_src__WEBPACK_IMPORTED_MODULE_1__["getColor"])(this.pointHoverColor),
                        pointHoverBackgroundColor: Object(_coreui_utils_src__WEBPACK_IMPORTED_MODULE_1__["getColor"])(this.pointHoverColor),
                        label: this.label
                    }];
                },
                pointedOptions: function pointedOptions() {
                    return {
                        scales: {
                            xAxes: [{
                                offset: true,
                                gridLines: {
                                    color: 'transparent',
                                    zeroLineColor: 'transparent'
                                },
                                ticks: {
                                    fontSize: 2,
                                    fontColor: 'transparent'
                                }
                            }],
                            yAxes: [{
                                display: false,
                                ticks: {
                                    display: false,
                                    min: Math.min.apply(Math, this.dataPoints) - 5,
                                    max: Math.max.apply(Math, this.dataPoints) + 5
                                }
                            }]
                        },
                        elements: {
                            line: {
                                borderWidth: 1
                            },
                            point: {
                                radius: 4,
                                hitRadius: 10,
                                hoverRadius: 4
                            }
                        }
                    };
                },
                straightOptions: function straightOptions() {
                    return {
                        scales: {
                            xAxes: [{
                                display: false
                            }],
                            yAxes: [{
                                display: false
                            }]
                        },
                        elements: {
                            line: {
                                borderWidth: 2
                            },
                            point: {
                                radius: 0,
                                hitRadius: 10,
                                hoverRadius: 4
                            }
                        }
                    };
                },
                defaultOptions: function defaultOptions() {
                    var options = this.pointed ? this.pointedOptions : this.straightOptions;
                    return Object.assign({}, options, {
                        maintainAspectRatio: false,
                        legend: {
                            display: false
                        }
                    });
                },
                computedDatasets: function computedDatasets() {
                    return Object(_coreui_utils_src__WEBPACK_IMPORTED_MODULE_1__["deepObjectsMerge"])(this.defaultDatasets, this.datasets || {});
                },
                computedOptions: function computedOptions() {
                    return Object(_coreui_utils_src__WEBPACK_IMPORTED_MODULE_1__["deepObjectsMerge"])(this.defaultOptions, this.options || {});
                }
            }
        });

        /***/
    }),

    /***/
    "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/views/Home.vue?vue&type=script&lang=js&":
    /*!**********************************************************************************************************************************************************!*\
      !*** ./node_modules/babel-loader/lib??ref--4-0!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/views/Home.vue?vue&type=script&lang=js& ***!
      \**********************************************************************************************************************************************************/
    /*! exports provided: default */
    /***/ (function (module, __webpack_exports__, __webpack_require__) {

        "use strict";
        __webpack_require__.r(__webpack_exports__);
        /* harmony import */
        var _coreui_vue_chartjs__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @coreui/vue-chartjs */ "./node_modules/@coreui/vue-chartjs/dist/coreui-vue-chartjs.common.js");
        /* harmony import */
        var _coreui_vue_chartjs__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_coreui_vue_chartjs__WEBPACK_IMPORTED_MODULE_0__);
        /* harmony import */
        var vuex__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! vuex */ "./node_modules/vuex/dist/vuex.esm.js");
        /* harmony import */
        var _components_CChartLineSimple__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ../components/CChartLineSimple */ "./resources/js/components/CChartLineSimple.vue");
        /* harmony import */
        var _helpers_misc_helpers__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ../helpers/misc-helpers */ "./resources/js/helpers/misc-helpers.js");

        function ownKeys(object, enumerableOnly) {
            var keys = Object.keys(object);
            if (Object.getOwnPropertySymbols) {
                var symbols = Object.getOwnPropertySymbols(object);
                if (enumerableOnly) symbols = symbols.filter(function (sym) {
                    return Object.getOwnPropertyDescriptor(object, sym).enumerable;
                });
                keys.push.apply(keys, symbols);
            }
            return keys;
        }

        function _objectSpread(target) {
            for (var i = 1; i < arguments.length; i++) {
                var source = arguments[i] != null ? arguments[i] : {};
                if (i % 2) {
                    ownKeys(Object(source), true).forEach(function (key) {
                        _defineProperty(target, key, source[key]);
                    });
                } else if (Object.getOwnPropertyDescriptors) {
                    Object.defineProperties(target, Object.getOwnPropertyDescriptors(source));
                } else {
                    ownKeys(Object(source)).forEach(function (key) {
                        Object.defineProperty(target, key, Object.getOwnPropertyDescriptor(source, key));
                    });
                }
            }
            return target;
        }

        function _defineProperty(obj, key, value) {
            if (key in obj) {
                Object.defineProperty(obj, key, {value: value, enumerable: true, configurable: true, writable: true});
            } else {
                obj[key] = value;
            }
            return obj;
        }

//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//


        /* harmony default export */
        __webpack_exports__["default"] = ({
            name: "Home",
            components: {
                CChartLineSimple: _components_CChartLineSimple__WEBPACK_IMPORTED_MODULE_2__["default"],
                CChartLine: _coreui_vue_chartjs__WEBPACK_IMPORTED_MODULE_0__["CChartLine"]
            },
            data: function data() {
                return {
                    miscHelpers: _helpers_misc_helpers__WEBPACK_IMPORTED_MODULE_3__["default"],
                    fields: [{
                        key: 'id'
                        /*_style: { width: '40%'}*/

                    }, {
                        key: 'type'
                    }, {
                        key: 'description'
                    }, {
                        key: 'amount'
                    }, {
                        key: 'status'
                    }, {
                        key: 'created_at'
                    }],
                    options: {
                        maintainAspectRatio: false,
                        interaction: {
                            mode: 'index',
                            intersect: false
                        },
                        stacked: false,
                        scales: {
                            y: {
                                type: 'linear',
                                display: true,
                                position: 'left'
                            },
                            y1: {
                                type: 'linear',
                                display: true,
                                position: 'right',
                                // grid line settings
                                grid: {
                                    drawOnChartArea: false // only want the grid lines for one axis to show up

                                }
                            }
                        }
                    }
                };
            },
            created: function created() {
                var _this = this;

                this.fetchTransactions().then(function () {
                    // TODO: If chart ends up null can we display no data instead of blank chart?
                    _this.processTransactionChartData();
                }); // this.groupReferrals('y');

                this.fetchReferrals().then(function () {// this.processReferralChartData()
                });
                this.fetchEarnings();
            },
            destroyed: function destroyed() {//TODO: Maybe add this after setting up data persistence
                // this.resetState()
            },
            computed: _objectSpread(_objectSpread(_objectSpread(_objectSpread({}, Object(vuex__WEBPACK_IMPORTED_MODULE_1__["mapGetters"])('TransactionsIndex', {
                transactions: 'data',
                transactionsChartData: 'chartData',
                transactionsQuery: 'query',
                transactionsTotal: "total",
                transactionsLoading: "loading"
            })), Object(vuex__WEBPACK_IMPORTED_MODULE_1__["mapGetters"])('ReferralsIndex', {
                referrals: 'data',
                referralsChartData: 'chartData',
                activeReferrals: 'activeReferrals'
            })), Object(vuex__WEBPACK_IMPORTED_MODULE_1__["mapGetters"])('EarningsIndex', {
                earnings: 'data'
            })), {}, {
                chartLabels: function chartLabels() {
                    return this.transactionsChartData.map(function (a) {
                        return a.date;
                    });
                },
                chartData1: function chartData1() {
                    return this.transactionsChartData.map(function (a) {
                        return a.amount;
                    });
                },
                chartData2: function chartData2() {
                    return this.transactionsChartData.map(function (a) {
                        return a.count;
                    });
                },
                totalAmount: function totalAmount() {
                    return _.sum(this.transactions.map(function (a) {
                        return a.amount;
                    }));
                },
                totalAmountToday: function totalAmountToday() {
                    var _this2 = this;

                    return _.sum(this.transactions.filter(function (item) {
                        return _this2.isToday(new Date(item.created_at));
                    }).map(function (a) {
                        return a.amount;
                    }));
                },
                totalAmountThisMonth: function totalAmountThisMonth() {
                    var _this3 = this;

                    return _.sum(this.transactions.filter(function (item) {
                        return _this3.isThisMonth(new Date(item.created_at));
                    }).map(function (a) {
                        return a.amount;
                    }));
                },
                todayTransactions: function todayTransactions() {
                    var _this4 = this;

                    return this.transactions.filter(function (item) {
                        return _this4.isToday(new Date(item.created_at));
                    });
                },
                totalTransactions: function totalTransactions() {
                    return this.transactions.length;
                },
                totalTransactionsToday: function totalTransactionsToday() {
                    return this.todayTransactions.length;
                },
                totalTransactionsThisMonth: function totalTransactionsThisMonth() {
                    var _this5 = this;

                    return this.transactions.filter(function (item) {
                        return _this5.isThisMonth(new Date(item.created_at));
                    }).length;
                },
                recentTransactions: function recentTransactions() {
                    return !_.isEmpty(this.todayTransactions) ? this.todayTransactions.sort(function (a, b) {
                        return b.id - a.id;
                    }) : this.transactions.sort(function (a, b) {
                        return b.id - a.id;
                    });
                },
                todayActiveReferrals: function todayActiveReferrals() {
                    var _this6 = this;

                    return this.activeReferrals.filter(function (item) {
                        return _this6.isToday(new Date(item.updated_at));
                    }).length + '';
                },
                last7DaysActiveReferrals: function last7DaysActiveReferrals() {
                    var _this7 = this;

                    return this.activeReferrals.filter(function (item) {
                        return _this7.isLast7Days(new Date(item.updated_at));
                    }).length + '';
                },
                last30DaysActiveReferrals: function last30DaysActiveReferrals() {
                    var _this8 = this;

                    return this.activeReferrals.filter(function (item) {
                        return _this8.isLast30Days(new Date(item.updated_at));
                    }).length + '';
                },
                totalActiveReferrals: function totalActiveReferrals() {
                    return this.activeReferrals.length + '';
                },
                referralChartLabels: function referralChartLabels() {
                    return this.referralsChartData.map(function (a) {
                        return a.date;
                    });
                },
                referralChartData: function referralChartData() {
                    return this.referralsChartData.map(function (a) {
                        return a.count;
                    });
                },
                todayEarnings: function todayEarnings() {
                    var _this9 = this;

                    return _.sum(this.earnings.filter(function (item) {
                        return _this9.isToday(new Date(item.created_at));
                    }).map(function (a) {
                        return parseFloat(a.earnings);
                    })).toFixed(2);
                },
                last7DaysEarnings: function last7DaysEarnings() {
                    var _this10 = this;

                    return _.sum(this.earnings.filter(function (item) {
                        return _this10.isLast7Days(new Date(item.created_at));
                    }).map(function (a) {
                        return parseFloat(a.earnings);
                    })).toFixed(2);
                },
                last30DaysEarnings: function last30DaysEarnings() {
                    var _this11 = this;

                    return _.sum(this.earnings.filter(function (item) {
                        return _this11.isLast30Days(new Date(item.created_at));
                    }).map(function (a) {
                        return parseFloat(a.earnings);
                    })).toFixed(2);
                },
                totalEarnings: function totalEarnings() {
                    return _.sum(this.earnings.map(function (a) {
                        return parseFloat(a.earnings);
                    })).toFixed(2);
                },
                datasets: function datasets() {
                    return [{
                        data: this.chartData1,
                        backgroundColor: '#008',
                        borderColor: '#00c',
                        label: 'Amount',
                        fill: false
                    }, {
                        data: this.chartData2,
                        backgroundColor: '#080',
                        borderColor: '#0c0',
                        label: 'Count',
                        fill: false
                    }];
                }
            }),
            methods: _objectSpread(_objectSpread(_objectSpread(_objectSpread(_objectSpread({}, Object(vuex__WEBPACK_IMPORTED_MODULE_1__["mapActions"])('TransactionsIndex', {
                fetchTransactions: 'fetchData',
                processTransactionChartData: 'processChartData',
                setTransactionsQuery: 'setQuery',
                resetState: 'resetState'
            })), Object(vuex__WEBPACK_IMPORTED_MODULE_1__["mapActions"])('ReferralsIndex', {
                fetchReferrals: 'fetchData',
                setReferralsQuery: 'setQuery',
                processReferralChartData: 'processChartData'
            })), Object(vuex__WEBPACK_IMPORTED_MODULE_1__["mapActions"])('EarningsIndex', {
                fetchEarnings: 'fetchData'
            })), Object(vuex__WEBPACK_IMPORTED_MODULE_1__["mapActions"])('loader', ['reset'])), {}, {
                groupTransactions: function groupTransactions(e) {
                    // const q = Object.assign({}, this.transactionsQuery, {group: e});
                    // or
                    var q = _objectSpread(_objectSpread({}, this.transactionsQuery), {}, {
                        group: e
                    });

                    this.setTransactionsQuery(q);
                    this.processTransactionChartData();
                },
                groupReferrals: function groupReferrals(e) {
                    var q = Object.assign({}, this.referralsQuery, {
                        group: e,
                        yearLimit: false
                    }); // or
                    // const q = {...this.transactionsQuery, { group: e} }

                    this.setReferralsQuery(q);
                    this.processReferralChartData();
                },
                reloadChart: function reloadChart() {
                    var _this12 = this;

                    this.fetchTransactions().then(function () {
                        _this12.processTransactionChartData();
                    });
                },
                //TODO: Move the below to date helper
                isToday: function isToday(someDate) {
                    var today = new Date();
                    return someDate.getDate() == today.getDate() && someDate.getMonth() == today.getMonth() && someDate.getFullYear() == today.getFullYear();
                },
                isLast7Days: function isLast7Days(someDate) {
                    var sevenDaysAgo = new Date();
                    sevenDaysAgo.setDate(sevenDaysAgo.getDate() - 7);
                    return someDate >= sevenDaysAgo;
                },
                isLast30Days: function isLast30Days(someDate) {
                    var monthAgo = new Date();
                    monthAgo.setDate(monthAgo.getDate() - 30);
                    return someDate >= monthAgo;
                },
                isThisMonth: function isThisMonth(someDate) {
                    var today = new Date();
                    return someDate.getMonth() == today.getMonth() && someDate.getFullYear() == today.getFullYear();
                },
                rowClicked: function rowClicked(item, index, e) {
                    var detailsClick = arguments.length > 3 && arguments[3] !== undefined ? arguments[3] : false;
                    this.$emit('row-clicked', item, index, e);
                }
            })
        });

        /***/
    }),

    /***/
    "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/CChartLineSimple.vue?vue&type=template&id=4de6fc4c&":
    /*!*******************************************************************************************************************************************************************************************************************!*\
      !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/components/CChartLineSimple.vue?vue&type=template&id=4de6fc4c& ***!
      \*******************************************************************************************************************************************************************************************************************/
    /*! exports provided: render, staticRenderFns */
    /***/ (function (module, __webpack_exports__, __webpack_require__) {

        "use strict";
        __webpack_require__.r(__webpack_exports__);
        /* harmony export (binding) */
        __webpack_require__.d(__webpack_exports__, "render", function () {
            return render;
        });
        /* harmony export (binding) */
        __webpack_require__.d(__webpack_exports__, "staticRenderFns", function () {
            return staticRenderFns;
        });
        var render = function () {
            var _vm = this
            var _h = _vm.$createElement
            var _c = _vm._self._c || _h
            return _c("CChartLine", {
                attrs: {
                    datasets: _vm.computedDatasets,
                    labels: _vm.labels,
                    options: _vm.computedOptions
                }
            })
        }
        var staticRenderFns = []
        render._withStripped = true


        /***/
    }),

    /***/
    "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/views/Home.vue?vue&type=template&id=63cd6604&scoped=true&":
    /*!**************************************************************************************************************************************************************************************************************!*\
      !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/views/Home.vue?vue&type=template&id=63cd6604&scoped=true& ***!
      \**************************************************************************************************************************************************************************************************************/
    /*! exports provided: render, staticRenderFns */
    /***/ (function (module, __webpack_exports__, __webpack_require__) {

        "use strict";
        __webpack_require__.r(__webpack_exports__);
        /* harmony export (binding) */
        __webpack_require__.d(__webpack_exports__, "render", function () {
            return render;
        });
        /* harmony export (binding) */
        __webpack_require__.d(__webpack_exports__, "staticRenderFns", function () {
            return staticRenderFns;
        });
        var render = function () {
            var _vm = this
            var _h = _vm.$createElement
            var _c = _vm._self._c || _h
            return _c(
                "div",
                [
                    _c(
                        "CRow",
                        [
                            _c("CCol", {attrs: {col: "12"}}, [
                                _c("h4", {staticClass: "card-title"}, [_vm._v("Invites")])
                            ]),
                            _vm._v(" "),
                            _c(
                                "CCol",
                                {attrs: {col: "12", lg: "3", sm: "6"}},
                                [
                                    _c("CWidgetIcon", {
                                        attrs: {
                                            header: _vm.todayActiveReferrals,
                                            color: "gradient-primary",
                                            text: "Today"
                                        }
                                    })
                                ],
                                1
                            ),
                            _vm._v(" "),
                            _c(
                                "CCol",
                                {attrs: {col: "12", lg: "3", sm: "6"}},
                                [
                                    _c("CWidgetIcon", {
                                        attrs: {
                                            header: _vm.last7DaysActiveReferrals,
                                            color: "gradient-secondary",
                                            text: "Past 7 days"
                                        }
                                    })
                                ],
                                1
                            ),
                            _vm._v(" "),
                            _c(
                                "CCol",
                                {attrs: {col: "12", lg: "3", sm: "6"}},
                                [
                                    _c("CWidgetIcon", {
                                        attrs: {
                                            header: _vm.last30DaysActiveReferrals,
                                            color: "gradient-info",
                                            text: "Past 30 days"
                                        }
                                    })
                                ],
                                1
                            ),
                            _vm._v(" "),
                            _c(
                                "CCol",
                                {attrs: {col: "12", lg: "3", sm: "6"}},
                                [
                                    _c("CWidgetIcon", {
                                        attrs: {
                                            header: _vm.totalActiveReferrals,
                                            color: "gradient-warning",
                                            text: "Total"
                                        }
                                    })
                                ],
                                1
                            )
                        ],
                        1
                    ),
                    _vm._v(" "),
                    _c(
                        "CRow",
                        [
                            _c("CCol", {attrs: {col: "12"}}, [
                                _c("h4", {staticClass: "card-title"}, [_vm._v("Earnings")])
                            ]),
                            _vm._v(" "),
                            _c(
                                "CCol",
                                {attrs: {col: "12", lg: "3", sm: "6"}},
                                [
                                    _c("CWidgetIcon", {
                                        attrs: {
                                            header: _vm._f("numFormat")(_vm.todayEarnings, "0,0.00"),
                                            color: "gradient-primary",
                                            text: "Today"
                                        }
                                    })
                                ],
                                1
                            ),
                            _vm._v(" "),
                            _c(
                                "CCol",
                                {attrs: {col: "12", lg: "3", sm: "6"}},
                                [
                                    _c("CWidgetIcon", {
                                        attrs: {
                                            header: _vm._f("numFormat")(_vm.last7DaysEarnings, "0,0.00"),
                                            color: "gradient-secondary",
                                            text: "Past 7 days"
                                        }
                                    })
                                ],
                                1
                            ),
                            _vm._v(" "),
                            _c(
                                "CCol",
                                {attrs: {col: "12", lg: "3", sm: "6"}},
                                [
                                    _c("CWidgetIcon", {
                                        attrs: {
                                            header: _vm._f("numFormat")(_vm.last30DaysEarnings, "0,0.00"),
                                            color: "gradient-info",
                                            text: "Past 30 days"
                                        }
                                    })
                                ],
                                1
                            ),
                            _vm._v(" "),
                            _c(
                                "CCol",
                                {attrs: {col: "12", lg: "3", sm: "6"}},
                                [
                                    _c("CWidgetIcon", {
                                        attrs: {
                                            header: _vm._f("numFormat")(_vm.totalEarnings, "0,0.00"),
                                            color: "gradient-warning",
                                            text: "Total"
                                        }
                                    })
                                ],
                                1
                            )
                        ],
                        1
                    ),
                    _vm._v(" "),
                    _c(
                        "CCard",
                        [
                            _c(
                                "CCardBody",
                                [
                                    _c(
                                        "CRow",
                                        [
                                            _c("CCol", {staticClass: "col-sm-5"}, [
                                                _c("h4", {staticClass: "card-title mb-0"}, [
                                                    _vm._v("Transactions Summary")
                                                ]),
                                                _vm._v(" "),
                                                _c("div", {staticClass: "small text-muted"}, [
                                                    _vm._v(
                                                        _vm._s(
                                                            _vm.transactionsQuery.group === "d"
                                                                ? "Transactions done today"
                                                                : _vm.transactionsQuery.group === "m"
                                                                    ? "Transactions done this month"
                                                                    : "Transactions done this year"
                                                        ) + "\n                    "
                                                    )
                                                ])
                                            ]),
                                            _vm._v(" "),
                                            _c(
                                                "CCol",
                                                {staticClass: "d-none d-md-block col-sm-7"},
                                                [
                                                    _c(
                                                        "button",
                                                        {
                                                            staticClass: "btn float-right btn-primary",
                                                            attrs: {disabled: ""},
                                                            on: {click: _vm.reloadChart}
                                                        },
                                                        [_c("CIcon", {attrs: {name: "cil-reload"}})],
                                                        1
                                                    ),
                                                    _vm._v(" "),
                                                    _c(
                                                        "CButtonGroup",
                                                        {staticClass: "float-right mr-3 btn-group"},
                                                        [
                                                            _c(
                                                                "CButton",
                                                                {
                                                                    staticClass: "btn mx-0 btn-outline-secondary",
                                                                    class: [
                                                                        _vm.transactionsQuery.group === "d"
                                                                            ? "active"
                                                                            : ""
                                                                    ],
                                                                    on: {
                                                                        click: function ($event) {
                                                                            return _vm.groupTransactions("d")
                                                                        }
                                                                    }
                                                                },
                                                                [
                                                                    _vm._v(
                                                                        "\n                            Day\n                        "
                                                                    )
                                                                ]
                                                            ),
                                                            _vm._v(" "),
                                                            _c(
                                                                "button",
                                                                {
                                                                    staticClass: "btn mx-0 btn-outline-secondary",
                                                                    class: [
                                                                        _vm.transactionsQuery.group === "m"
                                                                            ? "active"
                                                                            : ""
                                                                    ],
                                                                    on: {
                                                                        click: function ($event) {
                                                                            return _vm.groupTransactions("m")
                                                                        }
                                                                    }
                                                                },
                                                                [
                                                                    _vm._v(
                                                                        "\n                            Month\n                        "
                                                                    )
                                                                ]
                                                            ),
                                                            _vm._v(" "),
                                                            _c(
                                                                "button",
                                                                {
                                                                    staticClass: "btn mx-0 btn-outline-secondary",
                                                                    class: [
                                                                        _vm.transactionsQuery.group === "y"
                                                                            ? "active"
                                                                            : ""
                                                                    ],
                                                                    on: {
                                                                        click: function ($event) {
                                                                            return _vm.groupTransactions("y")
                                                                        }
                                                                    }
                                                                },
                                                                [
                                                                    _vm._v(
                                                                        "\n                            Year\n                        "
                                                                    )
                                                                ]
                                                            )
                                                        ],
                                                        1
                                                    )
                                                ],
                                                1
                                            )
                                        ],
                                        1
                                    ),
                                    _vm._v(" "),
                                    _c("CChartLine", {
                                        staticStyle: {height: "300px", "margin-top": "40px"},
                                        attrs: {
                                            datasets: _vm.datasets,
                                            labels: _vm.chartLabels,
                                            options: _vm.options
                                        }
                                    })
                                ],
                                1
                            ),
                            _vm._v(" "),
                            _c(
                                "CCardFooter",
                                [
                                    _c(
                                        "CRow",
                                        {staticClass: "text-center"},
                                        [
                                            _c(
                                                "CCol",
                                                {attrs: {sclass: "mb-sm-2 mb-0 col-sm-12 col-md"}},
                                                [
                                                    _c("div", {staticClass: "text-muted"}, [
                                                        _vm._v("Total Transactions")
                                                    ]),
                                                    _vm._v(" "),
                                                    _c("strong", [_vm._v(_vm._s(_vm.totalTransactions))]),
                                                    _vm._v(" "),
                                                    _c("span", {attrs: {title: "Today's Transactions"}}, [
                                                        _vm._v("(" + _vm._s(_vm.totalTransactionsToday) + ")")
                                                    ]),
                                                    _vm._v(" "),
                                                    _c("CProgress", {
                                                        staticClass: "progress-xs mt-2",
                                                        attrs: {
                                                            precision: 1,
                                                            value: _vm.totalTransactionsToday,
                                                            color: "success"
                                                        }
                                                    })
                                                ],
                                                1
                                            ),
                                            _vm._v(" "),
                                            _c(
                                                "CCol",
                                                {attrs: {sclass: "mb-sm-2 mb-0 col-sm-12 col-md"}},
                                                [
                                                    _c("div", {staticClass: "text-muted"}, [
                                                        _vm._v("Total Amounts")
                                                    ]),
                                                    _vm._v(" "),
                                                    _c("strong", [
                                                        _vm._v(
                                                            _vm._s(_vm._f("numFormat")(_vm.totalAmount, "0,0.00"))
                                                        )
                                                    ]),
                                                    _vm._v(" "),
                                                    _c("span", {attrs: {title: "Today's Transactions"}}, [
                                                        _vm._v(
                                                            "(" +
                                                            _vm._s(
                                                                _vm._f("numFormat")(
                                                                    _vm.totalAmountToday,
                                                                    "0,0.00"
                                                                )
                                                            ) +
                                                            ")"
                                                        )
                                                    ]),
                                                    _vm._v(" "),
                                                    _c("CProgress", {
                                                        staticClass: "progress-xs mt-2",
                                                        attrs: {
                                                            precision: 1,
                                                            value: _vm.totalAmountToday,
                                                            color: "success"
                                                        }
                                                    })
                                                ],
                                                1
                                            )
                                        ],
                                        1
                                    )
                                ],
                                1
                            )
                        ],
                        1
                    ),
                    _vm._v(" "),
                    _c(
                        "CCard",
                        [
                            _c(
                                "CCardHeader",
                                [
                                    _vm._t("header", [
                                        _c("CIcon", {attrs: {name: "cil-grid"}}),
                                        _vm._v("\n                Recent Transactions\n            ")
                                    ])
                                ],
                                2
                            ),
                            _vm._v(" "),
                            _c(
                                "CCardBody",
                                [
                                    _c("CDataTable", {
                                        attrs: {
                                            fields: _vm.fields,
                                            items: _vm.recentTransactions,
                                            "items-per-page": 8,
                                            pagination: {doubleArrows: false, align: "center"},
                                            "clickable-rows": "",
                                            hover: "",
                                            "items-per-page-select": "",
                                            sorter: "",
                                            striped: "",
                                            "table-filter": ""
                                        },
                                        on: {"row-clicked": _vm.rowClicked},
                                        scopedSlots: _vm._u([
                                            {
                                                key: "status",
                                                fn: function (data) {
                                                    return [
                                                        _c(
                                                            "td",
                                                            [
                                                                _c(
                                                                    "CBadge",
                                                                    {
                                                                        attrs: {
                                                                            color: _vm.miscHelpers.getBadge(
                                                                                data.item.status
                                                                            )
                                                                        }
                                                                    },
                                                                    [
                                                                        _vm._v(
                                                                            "\n                            " +
                                                                            _vm._s(data.item.status) +
                                                                            "\n                        "
                                                                        )
                                                                    ]
                                                                )
                                                            ],
                                                            1
                                                        )
                                                    ]
                                                }
                                            }
                                        ])
                                    })
                                ],
                                1
                            )
                        ],
                        1
                    )
                ],
                1
            )
        }
        var staticRenderFns = []
        render._withStripped = true


        /***/
    }),

    /***/
    "./resources/js/components/CChartLineSimple.vue":
    /*!******************************************************!*\
      !*** ./resources/js/components/CChartLineSimple.vue ***!
      \******************************************************/
    /*! exports provided: default */
    /***/ (function (module, __webpack_exports__, __webpack_require__) {

        "use strict";
        __webpack_require__.r(__webpack_exports__);
        /* harmony import */
        var _CChartLineSimple_vue_vue_type_template_id_4de6fc4c___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./CChartLineSimple.vue?vue&type=template&id=4de6fc4c& */ "./resources/js/components/CChartLineSimple.vue?vue&type=template&id=4de6fc4c&");
        /* harmony import */
        var _CChartLineSimple_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./CChartLineSimple.vue?vue&type=script&lang=js& */ "./resources/js/components/CChartLineSimple.vue?vue&type=script&lang=js&");
        /* empty/unused harmony star reexport *//* harmony import */
        var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");


        /* normalize component */

        var component = Object(_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__["default"])(
            _CChartLineSimple_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__["default"],
            _CChartLineSimple_vue_vue_type_template_id_4de6fc4c___WEBPACK_IMPORTED_MODULE_0__["render"],
            _CChartLineSimple_vue_vue_type_template_id_4de6fc4c___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"],
            false,
            null,
            null,
            null
        )

        /* hot reload */
        if (false) {
            var api;
        }
        component.options.__file = "resources/js/components/CChartLineSimple.vue"
        /* harmony default export */
        __webpack_exports__["default"] = (component.exports);

        /***/
    }),

    /***/
    "./resources/js/components/CChartLineSimple.vue?vue&type=script&lang=js&":
    /*!*******************************************************************************!*\
      !*** ./resources/js/components/CChartLineSimple.vue?vue&type=script&lang=js& ***!
      \*******************************************************************************/
    /*! exports provided: default */
    /***/ (function (module, __webpack_exports__, __webpack_require__) {

        "use strict";
        __webpack_require__.r(__webpack_exports__);
        /* harmony import */
        var _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_CChartLineSimple_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../node_modules/babel-loader/lib??ref--4-0!../../../node_modules/vue-loader/lib??vue-loader-options!./CChartLineSimple.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/CChartLineSimple.vue?vue&type=script&lang=js&");
        /* empty/unused harmony star reexport */ /* harmony default export */
        __webpack_exports__["default"] = (_node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_CChartLineSimple_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__["default"]);

        /***/
    }),

    /***/
    "./resources/js/components/CChartLineSimple.vue?vue&type=template&id=4de6fc4c&":
    /*!*************************************************************************************!*\
      !*** ./resources/js/components/CChartLineSimple.vue?vue&type=template&id=4de6fc4c& ***!
      \*************************************************************************************/
    /*! exports provided: render, staticRenderFns */
    /***/ (function (module, __webpack_exports__, __webpack_require__) {

        "use strict";
        __webpack_require__.r(__webpack_exports__);
        /* harmony import */
        var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_CChartLineSimple_vue_vue_type_template_id_4de6fc4c___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../node_modules/vue-loader/lib??vue-loader-options!./CChartLineSimple.vue?vue&type=template&id=4de6fc4c& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/CChartLineSimple.vue?vue&type=template&id=4de6fc4c&");
        /* harmony reexport (safe) */
        __webpack_require__.d(__webpack_exports__, "render", function () {
            return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_CChartLineSimple_vue_vue_type_template_id_4de6fc4c___WEBPACK_IMPORTED_MODULE_0__["render"];
        });

        /* harmony reexport (safe) */
        __webpack_require__.d(__webpack_exports__, "staticRenderFns", function () {
            return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_CChartLineSimple_vue_vue_type_template_id_4de6fc4c___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"];
        });


        /***/
    }),

    /***/
    "./resources/js/views/Home.vue":
    /*!*************************************!*\
      !*** ./resources/js/views/Home.vue ***!
      \*************************************/
    /*! exports provided: default */
    /***/ (function (module, __webpack_exports__, __webpack_require__) {

        "use strict";
        __webpack_require__.r(__webpack_exports__);
        /* harmony import */
        var _Home_vue_vue_type_template_id_63cd6604_scoped_true___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./Home.vue?vue&type=template&id=63cd6604&scoped=true& */ "./resources/js/views/Home.vue?vue&type=template&id=63cd6604&scoped=true&");
        /* harmony import */
        var _Home_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./Home.vue?vue&type=script&lang=js& */ "./resources/js/views/Home.vue?vue&type=script&lang=js&");
        /* empty/unused harmony star reexport *//* harmony import */
        var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");


        /* normalize component */

        var component = Object(_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__["default"])(
            _Home_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__["default"],
            _Home_vue_vue_type_template_id_63cd6604_scoped_true___WEBPACK_IMPORTED_MODULE_0__["render"],
            _Home_vue_vue_type_template_id_63cd6604_scoped_true___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"],
            false,
            null,
            "63cd6604",
            null
        )

        /* hot reload */
        if (false) {
            var api;
        }
        component.options.__file = "resources/js/views/Home.vue"
        /* harmony default export */
        __webpack_exports__["default"] = (component.exports);

        /***/
    }),

    /***/
    "./resources/js/views/Home.vue?vue&type=script&lang=js&":
    /*!**************************************************************!*\
      !*** ./resources/js/views/Home.vue?vue&type=script&lang=js& ***!
      \**************************************************************/
    /*! exports provided: default */
    /***/ (function (module, __webpack_exports__, __webpack_require__) {

        "use strict";
        __webpack_require__.r(__webpack_exports__);
        /* harmony import */
        var _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_Home_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../node_modules/babel-loader/lib??ref--4-0!../../../node_modules/vue-loader/lib??vue-loader-options!./Home.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/views/Home.vue?vue&type=script&lang=js&");
        /* empty/unused harmony star reexport */ /* harmony default export */
        __webpack_exports__["default"] = (_node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_Home_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__["default"]);

        /***/
    }),

    /***/
    "./resources/js/views/Home.vue?vue&type=template&id=63cd6604&scoped=true&":
    /*!********************************************************************************!*\
      !*** ./resources/js/views/Home.vue?vue&type=template&id=63cd6604&scoped=true& ***!
      \********************************************************************************/
    /*! exports provided: render, staticRenderFns */
    /***/ (function (module, __webpack_exports__, __webpack_require__) {

        "use strict";
        __webpack_require__.r(__webpack_exports__);
        /* harmony import */
        var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_Home_vue_vue_type_template_id_63cd6604_scoped_true___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../node_modules/vue-loader/lib??vue-loader-options!./Home.vue?vue&type=template&id=63cd6604&scoped=true& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/views/Home.vue?vue&type=template&id=63cd6604&scoped=true&");
        /* harmony reexport (safe) */
        __webpack_require__.d(__webpack_exports__, "render", function () {
            return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_Home_vue_vue_type_template_id_63cd6604_scoped_true___WEBPACK_IMPORTED_MODULE_0__["render"];
        });

        /* harmony reexport (safe) */
        __webpack_require__.d(__webpack_exports__, "staticRenderFns", function () {
            return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_Home_vue_vue_type_template_id_63cd6604_scoped_true___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"];
        });


        /***/
    })

}]);
