(window["webpackJsonp"] = window["webpackJsonp"] || []).push([[1], {

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
    "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/CChartBarSimple.vue?vue&type=script&lang=js&":
    /*!**************************************************************************************************************************************************************************!*\
      !*** ./node_modules/babel-loader/lib??ref--4-0!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/components/CChartBarSimple.vue?vue&type=script&lang=js& ***!
      \**************************************************************************************************************************************************************************/
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
            name: 'CChartBarSimple',
            components: {
                CChartBar: _coreui_vue_chartjs__WEBPACK_IMPORTED_MODULE_0__["CChartBar"]
            },
            props: _objectSpread(_objectSpread({}, _coreui_vue_chartjs__WEBPACK_IMPORTED_MODULE_0__["CChartBar"].props), {}, {
                backgroundColor: {
                    type: String,
                    "default": 'rgba(0,0,0,.2)'
                },
                pointHoverBackgroundColor: String,
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
                pointed: Boolean
            }),
            computed: {
                defaultDatasets: function defaultDatasets() {
                    return [{
                        data: this.dataPoints,
                        backgroundColor: Object(_coreui_utils_src__WEBPACK_IMPORTED_MODULE_1__["getColor"])(this.backgroundColor),
                        pointHoverBackgroundColor: Object(_coreui_utils_src__WEBPACK_IMPORTED_MODULE_1__["getColor"])(this.pointHoverBackgroundColor),
                        label: this.label,
                        barPercentage: 0.5,
                        categoryPercentage: 1
                    }];
                },
                defaultOptions: function defaultOptions() {
                    return {
                        maintainAspectRatio: false,
                        legend: {
                            display: false
                        },
                        scales: {
                            xAxes: [{
                                display: false
                            }],
                            yAxes: [{
                                display: false
                            }]
                        }
                    };
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
    "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/views/accounts/Index.vue?vue&type=script&lang=js&":
    /*!********************************************************************************************************************************************************************!*\
      !*** ./node_modules/babel-loader/lib??ref--4-0!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/views/accounts/Index.vue?vue&type=script&lang=js& ***!
      \********************************************************************************************************************************************************************/
    /*! exports provided: default */
    /***/ (function (module, __webpack_exports__, __webpack_require__) {

        "use strict";
        __webpack_require__.r(__webpack_exports__);
        /* harmony import */
        var vuex__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! vuex */ "./node_modules/vuex/dist/vuex.esm.js");
        /* harmony import */
        var _components_CChartBarSimple__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ../../components/CChartBarSimple */ "./resources/js/components/CChartBarSimple.vue");

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


        /* harmony default export */
        __webpack_exports__["default"] = ({
            name: "Index",
            components: {
                CChartBarSimple: _components_CChartBarSimple__WEBPACK_IMPORTED_MODULE_1__["default"]
            },
            data: function data() {
                return {
                    items: {
                        CURRENT: {
                            icon: 'cil-userFollow',
                            colour: 'gradient-success'
                        },
                        INTEREST: {
                            icon: 'cil-chartPie',
                            colour: 'gradient-primary'
                        },
                        SAVINGS: {
                            icon: 'cil-speedometer',
                            colour: 'gradient-warning'
                        }
                    },
                    fields: [// {key: 'id', /*_style: { width: '40%'}*/},
                        // {key: 'type',},
                        // {key: 'description'},
                        {
                            key: 'earnings',
                            label: 'amount'
                        }, {
                            key: 'type'
                        }, {
                            key: 'created_at',
                            label: 'Date'
                        } // {key: 'description'},
                        // {key: 'content', format: 'trim:100'},
                        // {key: 'created_at', label: 'Created', format: 'date:d/m/Y'},
                        // {key: 'author_id', label: 'Author', type: 'relationship'},
                        // {key: 'stage_id', label: 'Stage', type: 'relationship'},
                        // {key: 'approved_by', label: 'Approver', type: 'relationship'},
                        // {
                        //     key: 'show_details',
                        //     label: '',
                        //     _style: { width: '1%' },
                        //     sorter: false,
                        //     filter: false
                        // }
                    ]
                };
            },
            mounted: function mounted() {
                this.getAccountBalances();
                this.getEarnings();
            },
            destroyed: function destroyed() {//TODO: Maybe add this after setting up data persistence
                // this.resetState()
            },
            computed: _objectSpread(_objectSpread(_objectSpread({}, Object(vuex__WEBPACK_IMPORTED_MODULE_0__["mapGetters"])('Accounts', ['balances'])), Object(vuex__WEBPACK_IMPORTED_MODULE_0__["mapGetters"])('EarningsIndex', ['earnings', 'myEarnings', 'myInviteEarnings'])), {}, {
                myTotalEarnings: function myTotalEarnings() {
                    return this.myEarnings + this.myInviteEarnings;
                }
            }),
            methods: _objectSpread(_objectSpread(_objectSpread({}, Object(vuex__WEBPACK_IMPORTED_MODULE_0__["mapActions"])('Accounts', ['getAccountBalances', 'getEarningsSummary'])), Object(vuex__WEBPACK_IMPORTED_MODULE_0__["mapActions"])('EarningsIndex', {
                getEarnings: "fetchData"
            })), {}, {
                isToday: function isToday(someDate) {
                    var today = new Date();
                    return someDate.getDate() == today.getDate() && someDate.getMonth() == today.getMonth() && someDate.getFullYear() == today.getFullYear();
                },
                isThisMonth: function isThisMonth(someDate) {
                    var today = new Date();
                    return someDate.getMonth() == today.getMonth() && someDate.getFullYear() == today.getFullYear();
                },
                rowClicked: function rowClicked(item, index, e) {
                    var detailsClick = arguments.length > 3 && arguments[3] !== undefined ? arguments[3] : false;
                    this.$emit('row-clicked', item, index, e);
                },
                getBadge: function getBadge(status) {
                    status = status.toLowerCase();
                    return status === 'self' ? 'success' : status === 'referral' ? 'primary' : status === 'reimbursed' ? 'warning' : status === 'failed' ? 'danger' : 'secondary';
                },
                getColour: function getColour(type) {
                    return this.items[type].colour;
                },
                getIcon: function getIcon(type) {
                    return this.items[type].icon;
                }
            })
        });

        /***/
    }),

    /***/
    "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/CChartBarSimple.vue?vue&type=template&id=1b6ecc0f&":
    /*!******************************************************************************************************************************************************************************************************************!*\
      !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/components/CChartBarSimple.vue?vue&type=template&id=1b6ecc0f& ***!
      \******************************************************************************************************************************************************************************************************************/
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
            return _c("CChartBar", {
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
    "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/views/accounts/Index.vue?vue&type=template&id=241ca0f0&scoped=true&":
    /*!************************************************************************************************************************************************************************************************************************!*\
      !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/views/accounts/Index.vue?vue&type=template&id=241ca0f0&scoped=true& ***!
      \************************************************************************************************************************************************************************************************************************/
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
                    _c("CCardText", [_vm._v("Account Balances")]),
                    _vm._v(" "),
                    _c(
                        "CCardGroup",
                        {staticClass: "mb-4"},
                        [
                            _c(
                                "CWidgetProgressIcon",
                                {
                                    attrs: {
                                        header: _vm._f("numFormat")(
                                            _vm.balances.voucher.balance,
                                            "0,0"
                                        ),
                                        color: "gradient-info",
                                        inverse: "",
                                        text: "VOUCHER"
                                    }
                                },
                                [_c("CIcon", {attrs: {height: "36", name: "cil-people"}})],
                                1
                            ),
                            _vm._v(" "),
                            _vm._l(_vm.balances.sub_accounts, function (acc) {
                                return _c(
                                    "CWidgetProgressIcon",
                                    {
                                        attrs: {
                                            color: _vm.getColour(acc.type),
                                            header: _vm._f("numFormat")(acc.balance, "0,0.0000"),
                                            text: acc.type
                                        }
                                    },
                                    [
                                        _c("CIcon", {
                                            attrs: {name: _vm.getIcon(acc.type), height: "36"}
                                        })
                                    ],
                                    1
                                )
                            })
                        ],
                        2
                    ),
                    _vm._v(" "),
                    _c("CCardText", [_vm._v("Earnings")]),
                    _vm._v(" "),
                    _c(
                        "CRow",
                        [
                            _c(
                                "CCol",
                                {attrs: {lg: "4", sm: "4"}},
                                [
                                    _c(
                                        "CWidgetSimple",
                                        {
                                            attrs: {
                                                text: _vm._f("numFormat")(_vm.myTotalEarnings, "0,0.00"),
                                                header: "Total"
                                            }
                                        },
                                        [
                                            _c("CChartBarSimple", {
                                                staticStyle: {height: "40px"},
                                                attrs: {"background-color": "info"}
                                            })
                                        ],
                                        1
                                    )
                                ],
                                1
                            ),
                            _vm._v(" "),
                            _c(
                                "CCol",
                                {attrs: {lg: "4", sm: "4"}},
                                [
                                    _c(
                                        "CWidgetSimple",
                                        {
                                            attrs: {
                                                text: _vm._f("numFormat")(_vm.myEarnings, "0,0.00"),
                                                header: "Self"
                                            }
                                        },
                                        [
                                            _c("CChartBarSimple", {
                                                staticStyle: {height: "40px"},
                                                attrs: {"background-color": "primary"}
                                            })
                                        ],
                                        1
                                    )
                                ],
                                1
                            ),
                            _vm._v(" "),
                            _c(
                                "CCol",
                                {attrs: {lg: "4", sm: "4"}},
                                [
                                    _c(
                                        "CWidgetSimple",
                                        {
                                            attrs: {
                                                text: _vm._f("numFormat")(_vm.myInviteEarnings, "0,0.00"),
                                                header: "Invites"
                                            }
                                        },
                                        [
                                            _c("CChartBarSimple", {
                                                staticStyle: {height: "40px"},
                                                attrs: {"background-color": "success"}
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
            )
        }
        var staticRenderFns = []
        render._withStripped = true


        /***/
    }),

    /***/
    "./resources/js/components/CChartBarSimple.vue":
    /*!*****************************************************!*\
      !*** ./resources/js/components/CChartBarSimple.vue ***!
      \*****************************************************/
    /*! exports provided: default */
    /***/ (function (module, __webpack_exports__, __webpack_require__) {

        "use strict";
        __webpack_require__.r(__webpack_exports__);
        /* harmony import */
        var _CChartBarSimple_vue_vue_type_template_id_1b6ecc0f___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./CChartBarSimple.vue?vue&type=template&id=1b6ecc0f& */ "./resources/js/components/CChartBarSimple.vue?vue&type=template&id=1b6ecc0f&");
        /* harmony import */
        var _CChartBarSimple_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./CChartBarSimple.vue?vue&type=script&lang=js& */ "./resources/js/components/CChartBarSimple.vue?vue&type=script&lang=js&");
        /* empty/unused harmony star reexport *//* harmony import */
        var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");


        /* normalize component */

        var component = Object(_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__["default"])(
            _CChartBarSimple_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__["default"],
            _CChartBarSimple_vue_vue_type_template_id_1b6ecc0f___WEBPACK_IMPORTED_MODULE_0__["render"],
            _CChartBarSimple_vue_vue_type_template_id_1b6ecc0f___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"],
            false,
            null,
            null,
            null
        )

        /* hot reload */
        if (false) {
            var api;
        }
        component.options.__file = "resources/js/components/CChartBarSimple.vue"
        /* harmony default export */
        __webpack_exports__["default"] = (component.exports);

        /***/
    }),

    /***/
    "./resources/js/components/CChartBarSimple.vue?vue&type=script&lang=js&":
    /*!******************************************************************************!*\
      !*** ./resources/js/components/CChartBarSimple.vue?vue&type=script&lang=js& ***!
      \******************************************************************************/
    /*! exports provided: default */
    /***/ (function (module, __webpack_exports__, __webpack_require__) {

        "use strict";
        __webpack_require__.r(__webpack_exports__);
        /* harmony import */
        var _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_CChartBarSimple_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../node_modules/babel-loader/lib??ref--4-0!../../../node_modules/vue-loader/lib??vue-loader-options!./CChartBarSimple.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/CChartBarSimple.vue?vue&type=script&lang=js&");
        /* empty/unused harmony star reexport */ /* harmony default export */
        __webpack_exports__["default"] = (_node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_CChartBarSimple_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__["default"]);

        /***/
    }),

    /***/
    "./resources/js/components/CChartBarSimple.vue?vue&type=template&id=1b6ecc0f&":
    /*!************************************************************************************!*\
      !*** ./resources/js/components/CChartBarSimple.vue?vue&type=template&id=1b6ecc0f& ***!
      \************************************************************************************/
    /*! exports provided: render, staticRenderFns */
    /***/ (function (module, __webpack_exports__, __webpack_require__) {

        "use strict";
        __webpack_require__.r(__webpack_exports__);
        /* harmony import */
        var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_CChartBarSimple_vue_vue_type_template_id_1b6ecc0f___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../node_modules/vue-loader/lib??vue-loader-options!./CChartBarSimple.vue?vue&type=template&id=1b6ecc0f& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/CChartBarSimple.vue?vue&type=template&id=1b6ecc0f&");
        /* harmony reexport (safe) */
        __webpack_require__.d(__webpack_exports__, "render", function () {
            return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_CChartBarSimple_vue_vue_type_template_id_1b6ecc0f___WEBPACK_IMPORTED_MODULE_0__["render"];
        });

        /* harmony reexport (safe) */
        __webpack_require__.d(__webpack_exports__, "staticRenderFns", function () {
            return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_CChartBarSimple_vue_vue_type_template_id_1b6ecc0f___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"];
        });


        /***/
    }),

    /***/
    "./resources/js/views/accounts/Index.vue":
    /*!***********************************************!*\
      !*** ./resources/js/views/accounts/Index.vue ***!
      \***********************************************/
    /*! exports provided: default */
    /***/ (function (module, __webpack_exports__, __webpack_require__) {

        "use strict";
        __webpack_require__.r(__webpack_exports__);
        /* harmony import */
        var _Index_vue_vue_type_template_id_241ca0f0_scoped_true___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./Index.vue?vue&type=template&id=241ca0f0&scoped=true& */ "./resources/js/views/accounts/Index.vue?vue&type=template&id=241ca0f0&scoped=true&");
        /* harmony import */
        var _Index_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./Index.vue?vue&type=script&lang=js& */ "./resources/js/views/accounts/Index.vue?vue&type=script&lang=js&");
        /* empty/unused harmony star reexport *//* harmony import */
        var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");


        /* normalize component */

        var component = Object(_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__["default"])(
            _Index_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__["default"],
            _Index_vue_vue_type_template_id_241ca0f0_scoped_true___WEBPACK_IMPORTED_MODULE_0__["render"],
            _Index_vue_vue_type_template_id_241ca0f0_scoped_true___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"],
            false,
            null,
            "241ca0f0",
            null
        )

        /* hot reload */
        if (false) {
            var api;
        }
        component.options.__file = "resources/js/views/accounts/Index.vue"
        /* harmony default export */
        __webpack_exports__["default"] = (component.exports);

        /***/
    }),

    /***/
    "./resources/js/views/accounts/Index.vue?vue&type=script&lang=js&":
    /*!************************************************************************!*\
      !*** ./resources/js/views/accounts/Index.vue?vue&type=script&lang=js& ***!
      \************************************************************************/
    /*! exports provided: default */
    /***/ (function (module, __webpack_exports__, __webpack_require__) {

        "use strict";
        __webpack_require__.r(__webpack_exports__);
        /* harmony import */
        var _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_Index_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/babel-loader/lib??ref--4-0!../../../../node_modules/vue-loader/lib??vue-loader-options!./Index.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/views/accounts/Index.vue?vue&type=script&lang=js&");
        /* empty/unused harmony star reexport */ /* harmony default export */
        __webpack_exports__["default"] = (_node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_Index_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__["default"]);

        /***/
    }),

    /***/
    "./resources/js/views/accounts/Index.vue?vue&type=template&id=241ca0f0&scoped=true&":
    /*!******************************************************************************************!*\
      !*** ./resources/js/views/accounts/Index.vue?vue&type=template&id=241ca0f0&scoped=true& ***!
      \******************************************************************************************/
    /*! exports provided: render, staticRenderFns */
    /***/ (function (module, __webpack_exports__, __webpack_require__) {

        "use strict";
        __webpack_require__.r(__webpack_exports__);
        /* harmony import */
        var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_Index_vue_vue_type_template_id_241ca0f0_scoped_true___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../node_modules/vue-loader/lib??vue-loader-options!./Index.vue?vue&type=template&id=241ca0f0&scoped=true& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/views/accounts/Index.vue?vue&type=template&id=241ca0f0&scoped=true&");
        /* harmony reexport (safe) */
        __webpack_require__.d(__webpack_exports__, "render", function () {
            return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_Index_vue_vue_type_template_id_241ca0f0_scoped_true___WEBPACK_IMPORTED_MODULE_0__["render"];
        });

        /* harmony reexport (safe) */
        __webpack_require__.d(__webpack_exports__, "staticRenderFns", function () {
            return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_Index_vue_vue_type_template_id_241ca0f0_scoped_true___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"];
        });


        /***/
    })

}]);
