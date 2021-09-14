(window["webpackJsonp"] = window["webpackJsonp"] || []).push([[11], {

    /***/
    "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/views/purchases/VoucherStatus.vue?vue&type=script&lang=js&":
    /*!*****************************************************************************************************************************************************************************!*\
      !*** ./node_modules/babel-loader/lib??ref--4-0!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/views/purchases/VoucherStatus.vue?vue&type=script&lang=js& ***!
      \*****************************************************************************************************************************************************************************/
    /*! exports provided: default */
    /***/ (function (module, __webpack_exports__, __webpack_require__) {

        "use strict";
        __webpack_require__.r(__webpack_exports__);
        /* harmony import */
        var vuex__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! vuex */ "./node_modules/vuex/dist/vuex.esm.js");
        /* harmony import */
        var vue__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! vue */ "./node_modules/vue/dist/vue.common.js");
        /* harmony import */
        var vue__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(vue__WEBPACK_IMPORTED_MODULE_1__);

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


        /* harmony default export */
        __webpack_exports__["default"] = ({
            name: 'AirtimeStatus',
            data: function data() {
                return {
                    steps: 3,
                    timerCount: 30,
                    timerEnabled: true
                };
            },
            beforeRouteUpdate: function beforeRouteUpdate(to, from, next) {
                // react to route changes...
                // don't forget to call next()
                this.checkVoucherStatus(this.$route.params.id);
                next();
            },
            computed: _objectSpread(_objectSpread({}, Object(vuex__WEBPACK_IMPORTED_MODULE_0__["mapGetters"])("Purchases", ["status", "errors"])), {}, {
                completed: function completed() {
                    return this.status.payment.status === 'Complete' && this.status.payment.stk_request.status === 'Paid';
                }
            }),
            watch: {
                timerEnabled: function timerEnabled(value) {
                    var _this = this;

                    if (value) {
                        setTimeout(function () {
                            _this.timerCount--;
                        }, 1000);
                    }
                },
                timerCount: {
                    handler: function handler(value) {
                        var _this2 = this;

                        if (value > 0 && this.timerEnabled) {
                            setTimeout(function () {
                                _this2.timerCount--;
                            }, 1000);
                        }

                        if (value === 0) {
                            this.checkVoucherStatus(this.$route.params.id);
                            this.timerEnabled = false;
                        }
                    },
                    immediate: true // This ensures the watcher is triggered upon creation

                }
            },
            mounted: function mounted() {
                this.checkVoucherStatus(this.$route.params.id);
                this.timerEnabled = true;
            },
            methods: _objectSpread(_objectSpread({}, Object(vuex__WEBPACK_IMPORTED_MODULE_0__["mapActions"])('Purchases', ["checkVoucherStatus"])), {}, {
                getColour: function getColour(status) {
                    status = status.toLowerCase().trim();
                    return ['success', 'paid', 'complete'].includes(status) ? 'success' : ['pending', 'sent'].includes(status) ? 'secondary' : status === 'reimbursed' ? 'warning' : status === 'failed' ? 'danger' : 'primary';
                }
            })
        });

        /***/
    }),

    /***/
    "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/views/purchases/VoucherStatus.vue?vue&type=template&id=16a1a934&":
    /*!*********************************************************************************************************************************************************************************************************************!*\
      !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/views/purchases/VoucherStatus.vue?vue&type=template&id=16a1a934& ***!
      \*********************************************************************************************************************************************************************************************************************/
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
                "CContainer",
                [
                    _c(
                        "CRow",
                        {staticClass: "justify-content-center"},
                        [
                            _c(
                                "CCol",
                                {attrs: {col: "12", md: "6"}},
                                [
                                    _vm.status
                                        ? _c(
                                            "CCard",
                                            [
                                                _c(
                                                    "CCardHeader",
                                                    [
                                                        _c("CIcon", {
                                                            attrs: {name: "cil-justify-center"}
                                                        }),
                                                        _vm._v("\n                    Voucher "),
                                                        _c("small", [_vm._v("Status")]),
                                                        _vm._v(" "),
                                                        _vm.timerEnabled
                                                            ? _c(
                                                                "span",
                                                                {staticClass: "text-right float-right"},
                                                                [
                                                                    _vm._v(
                                                                        "Refreshing in " + _vm._s(_vm.timerCount)
                                                                    )
                                                                ]
                                                            )
                                                            : _vm._e()
                                                    ],
                                                    1
                                                ),
                                                _vm._v(" "),
                                                _c("CCardBody", [
                                                    _vm.status.payment.stk_request
                                                        ? _c(
                                                            "div",
                                                            [
                                                                _c(
                                                                    "CAlert",
                                                                    {
                                                                        attrs: {
                                                                            color: _vm.getColour(
                                                                                _vm.status.payment.stk_request.status
                                                                            ),
                                                                            show: ""
                                                                        }
                                                                    },
                                                                    [
                                                                        _c("h4", {staticClass: "alert-heading"}, [
                                                                            _vm._v("STK Push")
                                                                        ]),
                                                                        _vm._v(" "),
                                                                        _c("p", [
                                                                            _vm._v(
                                                                                "\n                                " +
                                                                                _vm._s(
                                                                                    _vm.status.payment.stk_request
                                                                                        .status
                                                                                ) +
                                                                                "\n\n                                "
                                                                            ),
                                                                            _vm.status.payment.stk_request.status ===
                                                                            "Failed"
                                                                                ? _c("span", [
                                                                                    _vm._v(
                                                                                        "\n                                    - "
                                                                                    ),
                                                                                    _c("b", [
                                                                                        _vm._v(
                                                                                            _vm._s(
                                                                                                _vm.status.payment.stk_request
                                                                                                    .response.ResultDesc
                                                                                            )
                                                                                        )
                                                                                    ])
                                                                                ])
                                                                                : _vm._e()
                                                                        ]),
                                                                        _vm._v(" "),
                                                                        _c("hr"),
                                                                        _vm._v(" "),
                                                                        _c("p", {staticClass: "mb-0"}, [
                                                                            _vm._v(
                                                                                "\n                                " +
                                                                                _vm._s(
                                                                                    _vm._f("moment")(
                                                                                        _vm.status.payment.stk_request
                                                                                            .updated_at,
                                                                                        "from"
                                                                                    )
                                                                                ) +
                                                                                "\n                            "
                                                                            )
                                                                        ])
                                                                    ]
                                                                )
                                                            ],
                                                            1
                                                        )
                                                        : _vm._e()
                                                ]),
                                                _vm._v(" "),
                                                _c("CCardBody", [
                                                    _vm.status.payment
                                                        ? _c(
                                                            "div",
                                                            [
                                                                _c(
                                                                    "CAlert",
                                                                    {
                                                                        attrs: {
                                                                            color: _vm.getColour(
                                                                                _vm.status.payment.status
                                                                            ),
                                                                            show: ""
                                                                        }
                                                                    },
                                                                    [
                                                                        _c("h4", {staticClass: "alert-heading"}, [
                                                                            _vm._v("Payment")
                                                                        ]),
                                                                        _vm._v(" "),
                                                                        _c("p", [
                                                                            _vm._v(
                                                                                "\n                                " +
                                                                                _vm._s(_vm.status.payment.status) +
                                                                                "\n                            "
                                                                            )
                                                                        ]),
                                                                        _vm._v(" "),
                                                                        _c("hr"),
                                                                        _vm._v(" "),
                                                                        _c("p", {staticClass: "mb-0"}, [
                                                                            _vm._v(
                                                                                "\n                                " +
                                                                                _vm._s(
                                                                                    _vm._f("moment")(
                                                                                        _vm.status.payment.updated_at,
                                                                                        "from"
                                                                                    )
                                                                                ) +
                                                                                "\n                            "
                                                                            )
                                                                        ])
                                                                    ]
                                                                )
                                                            ],
                                                            1
                                                        )
                                                        : _vm._e()
                                                ]),
                                                _vm._v(" "),
                                                _c("CCardBody", [
                                                    _vm.completed
                                                        ? _c(
                                                            "div",
                                                            [
                                                                _c(
                                                                    "CButton",
                                                                    {
                                                                        attrs: {
                                                                            to: {name: "finances"},
                                                                            color: "success",
                                                                            size: "sm"
                                                                        }
                                                                    },
                                                                    [
                                                                        _c("CIcon", {
                                                                            attrs: {name: "cil-info"}
                                                                        }),
                                                                        _vm._v(
                                                                            "\n                            Check voucher balance\n                        "
                                                                        )
                                                                    ],
                                                                    1
                                                                )
                                                            ],
                                                            1
                                                        )
                                                        : _vm._e()
                                                ])
                                            ],
                                            1
                                        )
                                        : _c(
                                            "CCard",
                                            [
                                                _c(
                                                    "CCardBody",
                                                    [
                                                        _c(
                                                            "CCardHeader",
                                                            [
                                                                _c("CIcon", {
                                                                    attrs: {name: "cil-justify-center"}
                                                                }),
                                                                _vm._v("\n                        Voucher "),
                                                                _c("small", [_vm._v("Status")]),
                                                                _vm._v(" "),
                                                                _vm.timerEnabled
                                                                    ? _c(
                                                                        "span",
                                                                        {staticClass: "text-right float-right"},
                                                                        [
                                                                            _vm._v(
                                                                                "Refreshing in " +
                                                                                _vm._s(_vm.timerCount)
                                                                            )
                                                                        ]
                                                                    )
                                                                    : _vm._e()
                                                            ],
                                                            1
                                                        ),
                                                        _vm._v(" "),
                                                        _c("CCardText", [
                                                            _c("b", [_vm._v("Oops!")]),
                                                            _vm._v(
                                                                "\n\n                        The item you are looking for does not exist.\n                    "
                                                            )
                                                        ]),
                                                        _vm._v(" "),
                                                        _c(
                                                            "CButton",
                                                            {
                                                                attrs: {
                                                                    to: {name: "dashboard"},
                                                                    color: "danger",
                                                                    size: "sm"
                                                                }
                                                            },
                                                            [
                                                                _c("CIcon", {attrs: {name: "cil-ban"}}),
                                                                _vm._v(
                                                                    "\n                        Go home\n                    "
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
    "./resources/js/views/purchases/VoucherStatus.vue":
    /*!********************************************************!*\
      !*** ./resources/js/views/purchases/VoucherStatus.vue ***!
      \********************************************************/
    /*! exports provided: default */
    /***/ (function (module, __webpack_exports__, __webpack_require__) {

        "use strict";
        __webpack_require__.r(__webpack_exports__);
        /* harmony import */
        var _VoucherStatus_vue_vue_type_template_id_16a1a934___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./VoucherStatus.vue?vue&type=template&id=16a1a934& */ "./resources/js/views/purchases/VoucherStatus.vue?vue&type=template&id=16a1a934&");
        /* harmony import */
        var _VoucherStatus_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./VoucherStatus.vue?vue&type=script&lang=js& */ "./resources/js/views/purchases/VoucherStatus.vue?vue&type=script&lang=js&");
        /* empty/unused harmony star reexport *//* harmony import */
        var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");


        /* normalize component */

        var component = Object(_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__["default"])(
            _VoucherStatus_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__["default"],
            _VoucherStatus_vue_vue_type_template_id_16a1a934___WEBPACK_IMPORTED_MODULE_0__["render"],
            _VoucherStatus_vue_vue_type_template_id_16a1a934___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"],
            false,
            null,
            null,
            null
        )

        /* hot reload */
        if (false) {
            var api;
        }
        component.options.__file = "resources/js/views/purchases/VoucherStatus.vue"
        /* harmony default export */
        __webpack_exports__["default"] = (component.exports);

        /***/
    }),

    /***/
    "./resources/js/views/purchases/VoucherStatus.vue?vue&type=script&lang=js&":
    /*!*********************************************************************************!*\
      !*** ./resources/js/views/purchases/VoucherStatus.vue?vue&type=script&lang=js& ***!
      \*********************************************************************************/
    /*! exports provided: default */
    /***/ (function (module, __webpack_exports__, __webpack_require__) {

        "use strict";
        __webpack_require__.r(__webpack_exports__);
        /* harmony import */
        var _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_VoucherStatus_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/babel-loader/lib??ref--4-0!../../../../node_modules/vue-loader/lib??vue-loader-options!./VoucherStatus.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/views/purchases/VoucherStatus.vue?vue&type=script&lang=js&");
        /* empty/unused harmony star reexport */ /* harmony default export */
        __webpack_exports__["default"] = (_node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_VoucherStatus_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__["default"]);

        /***/
    }),

    /***/
    "./resources/js/views/purchases/VoucherStatus.vue?vue&type=template&id=16a1a934&":
    /*!***************************************************************************************!*\
      !*** ./resources/js/views/purchases/VoucherStatus.vue?vue&type=template&id=16a1a934& ***!
      \***************************************************************************************/
    /*! exports provided: render, staticRenderFns */
    /***/ (function (module, __webpack_exports__, __webpack_require__) {

        "use strict";
        __webpack_require__.r(__webpack_exports__);
        /* harmony import */
        var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_VoucherStatus_vue_vue_type_template_id_16a1a934___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../node_modules/vue-loader/lib??vue-loader-options!./VoucherStatus.vue?vue&type=template&id=16a1a934& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/views/purchases/VoucherStatus.vue?vue&type=template&id=16a1a934&");
        /* harmony reexport (safe) */
        __webpack_require__.d(__webpack_exports__, "render", function () {
            return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_VoucherStatus_vue_vue_type_template_id_16a1a934___WEBPACK_IMPORTED_MODULE_0__["render"];
        });

        /* harmony reexport (safe) */
        __webpack_require__.d(__webpack_exports__, "staticRenderFns", function () {
            return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_VoucherStatus_vue_vue_type_template_id_16a1a934___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"];
        });


        /***/
    })

}]);
