(window["webpackJsonp"] = window["webpackJsonp"] || []).push([[3], {

    /***/
    "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/views/auth/Login.vue?vue&type=script&lang=js&":
    /*!****************************************************************************************************************************************************************!*\
      !*** ./node_modules/babel-loader/lib??ref--4-0!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/views/auth/Login.vue?vue&type=script&lang=js& ***!
      \****************************************************************************************************************************************************************/
    /*! exports provided: default */
    /***/ (function (module, __webpack_exports__, __webpack_require__) {

        "use strict";
        __webpack_require__.r(__webpack_exports__);
        /* harmony import */
        var _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @babel/runtime/regenerator */ "./node_modules/@babel/runtime/regenerator/index.js");
        /* harmony import */
        var _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0__);
        /* harmony import */
        var vuex__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! vuex */ "./node_modules/vuex/dist/vuex.esm.js");
        /* harmony import */
        var _Loader__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ../Loader */ "./resources/js/views/Loader.vue");


        function asyncGeneratorStep(gen, resolve, reject, _next, _throw, key, arg) {
            try {
                var info = gen[key](arg);
                var value = info.value;
            } catch (error) {
                reject(error);
                return;
            }
            if (info.done) {
                resolve(value);
            } else {
                Promise.resolve(value).then(_next, _throw);
            }
        }

        function _asyncToGenerator(fn) {
            return function () {
                var self = this, args = arguments;
                return new Promise(function (resolve, reject) {
                    var gen = fn.apply(self, args);

                    function _next(value) {
                        asyncGeneratorStep(gen, resolve, reject, _next, _throw, "next", value);
                    }

                    function _throw(err) {
                        asyncGeneratorStep(gen, resolve, reject, _next, _throw, "throw", err);
                    }

                    _next(undefined);
                });
            };
        }

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


        /* harmony default export */
        __webpack_exports__["default"] = ({
            name: 'Login',
            components: {
                Loader: _Loader__WEBPACK_IMPORTED_MODULE_2__["default"]
            },
            data: function data() {
                return {
                    form: {
                        phone: "",
                        password: ""
                    },
                    showError: false,
                    message: '',
                    error: null
                };
            },
            computed: _objectSpread(_objectSpread({}, Object(vuex__WEBPACK_IMPORTED_MODULE_1__["mapState"])('loader', ['loading'])), Object(vuex__WEBPACK_IMPORTED_MODULE_1__["mapGetters"])("auth", ["isAuthenticated", "errors"])),
            created: function created() {
                if (this.isAuthenticated) {
                    this.$router.push('/');
                }
            },
            destroyed: function destroyed() {
                this.reset();
            },
            methods: _objectSpread(_objectSpread({}, Object(vuex__WEBPACK_IMPORTED_MODULE_1__["mapActions"])('auth', ["login", "reset"])), {}, {
                checkPhone: function checkPhone(phoneObject) {
                    if (phoneObject.valid) {
                        var safRegex = /^(?:\+?254|0)?((?:(?:7(?:(?:[01249][0-9])|(?:5[789])|(?:6[89])))|(?:1(?:[1][0-5])))[0-9]{6})$/;

                        if (safRegex.test(phoneObject.number)) {
                            this.validPhoneInput = true;
                            this.error = null;
                            this.form.phone = phoneObject.number.replace("+", "");
                        } else {
                            this.validPhoneInput = false;
                            this.error = "Only Safaricom numbers are currently supported. Please try again.";
                        }
                    }
                },
                submit: function submit() {
                    var _this = this;

                    return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default.a.mark(function _callee() {
                        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default.a.wrap(function _callee$(_context) {
                            while (1) {
                                switch (_context.prev = _context.next) {
                                    case 0:
                                        _context.prev = 0;
                                        _context.next = 3;
                                        return _this.login(_this.form).then(function (d) {
                                            console.log('success', d);
                                            _this.showError = false;

                                            _this.$router.push('/');
                                        }, function (error) {
                                            console.log('error', error);

                                            if (error.error) {
                                                _this.showError = true;
                                            }

                                            _this.loading = false;
                                            _this.message = error.response && error.response.data || error.message || error.error || error.toString();
                                        });

                                    case 3:
                                        _context.next = 9;
                                        break;

                                    case 5:
                                        _context.prev = 5;
                                        _context.t0 = _context["catch"](0);
                                        console.log('loginVueError', _context.t0);
                                        _this.showError = true;

                                    case 9:
                                    case "end":
                                        return _context.stop();
                                }
                            }
                        }, _callee, null, [[0, 5]]);
                    }))();
                }
            })
        });

        /***/
    }),

    /***/
    "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/views/auth/Login.vue?vue&type=template&id=46ec553e&":
    /*!********************************************************************************************************************************************************************************************************!*\
      !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/views/auth/Login.vue?vue&type=template&id=46ec553e& ***!
      \********************************************************************************************************************************************************************************************************/
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
                {staticClass: "c-app flex-row align-items-center"},
                [
                    _c(
                        "CContainer",
                        [
                            _c(
                                "CRow",
                                {staticClass: "justify-content-center"},
                                [
                                    _c("loader", {attrs: {"is-visible": _vm.loading}}),
                                    _vm._v(" "),
                                    _c(
                                        "CCol",
                                        {attrs: {md: "8"}},
                                        [
                                            _c(
                                                "CCardGroup",
                                                [
                                                    _c(
                                                        "CCard",
                                                        {staticClass: "p-4"},
                                                        [
                                                            _c(
                                                                "CCardBody",
                                                                [
                                                                    _c(
                                                                        "CForm",
                                                                        {
                                                                            on: {
                                                                                submit: function ($event) {
                                                                                    $event.preventDefault()
                                                                                    return _vm.submit($event)
                                                                                }
                                                                            }
                                                                        },
                                                                        [
                                                                            _c("h1", [_vm._v("Login")]),
                                                                            _vm._v(" "),
                                                                            _c("p", {staticClass: "text-muted"}, [
                                                                                _vm._v("Sign In to your account")
                                                                            ]),
                                                                            _vm._v(" "),
                                                                            _c("p", {staticClass: "alert-info"}, [
                                                                                _vm._v(
                                                                                    "If this is your first time accessing the web portal, please\n                                    register first."
                                                                                )
                                                                            ]),
                                                                            _vm._v(" "),
                                                                            _vm.showError
                                                                                ? _c(
                                                                                    "p",
                                                                                    {
                                                                                        staticClass: "alert-warning",
                                                                                        attrs: {id: "error"}
                                                                                    },
                                                                                    [
                                                                                        _vm._v(
                                                                                            "Username or Password is\n                                    incorrect"
                                                                                        )
                                                                                    ]
                                                                                )
                                                                                : _vm._e(),
                                                                            _vm._v(" "),
                                                                            _c("vue-tel-input", {
                                                                                staticClass: "mt-3",
                                                                                attrs: {invalidMsg: _vm.error},
                                                                                on: {validate: _vm.checkPhone}
                                                                            }),
                                                                            _vm._v(" "),
                                                                            _vm.errors.phone
                                                                                ? _c(
                                                                                    "p",
                                                                                    {
                                                                                        staticClass: "alert-warning",
                                                                                        attrs: {id: "phoneError"}
                                                                                    },
                                                                                    [
                                                                                        _vm._v(
                                                                                            "\n                                    " +
                                                                                            _vm._s(_vm.errors.phone[0]) +
                                                                                            "\n                                "
                                                                                        )
                                                                                    ]
                                                                                )
                                                                                : _vm._e(),
                                                                            _vm._v(" "),
                                                                            _c("CInput", {
                                                                                staticClass: "mt-3 mb-0",
                                                                                attrs: {
                                                                                    autocomplete: "curent-password",
                                                                                    placeholder: "Password",
                                                                                    type: "password"
                                                                                },
                                                                                scopedSlots: _vm._u([
                                                                                    {
                                                                                        key: "prepend-content",
                                                                                        fn: function () {
                                                                                            return [
                                                                                                _c("CIcon", {
                                                                                                    attrs: {name: "cil-lock-locked"}
                                                                                                })
                                                                                            ]
                                                                                        },
                                                                                        proxy: true
                                                                                    }
                                                                                ]),
                                                                                model: {
                                                                                    value: _vm.form.password,
                                                                                    callback: function ($$v) {
                                                                                        _vm.$set(_vm.form, "password", $$v)
                                                                                    },
                                                                                    expression: "form.password"
                                                                                }
                                                                            }),
                                                                            _vm._v(" "),
                                                                            _vm.errors.password
                                                                                ? _c(
                                                                                    "p",
                                                                                    {
                                                                                        staticClass: "alert-warning",
                                                                                        attrs: {id: "passwordError"}
                                                                                    },
                                                                                    [
                                                                                        _vm._v(
                                                                                            "\n                                    " +
                                                                                            _vm._s(_vm.errors.password[0]) +
                                                                                            "\n                                "
                                                                                        )
                                                                                    ]
                                                                                )
                                                                                : _vm._e(),
                                                                            _vm._v(" "),
                                                                            _c(
                                                                                "CRow",
                                                                                [
                                                                                    _c(
                                                                                        "CCol",
                                                                                        {
                                                                                            staticClass: "text-left",
                                                                                            attrs: {col: "6"}
                                                                                        },
                                                                                        [
                                                                                            _c(
                                                                                                "CButton",
                                                                                                {
                                                                                                    staticClass: "px-4 mt-3",
                                                                                                    attrs: {
                                                                                                        color: "primary",
                                                                                                        type: "submit"
                                                                                                    }
                                                                                                },
                                                                                                [_vm._v("Login")]
                                                                                            )
                                                                                        ],
                                                                                        1
                                                                                    ),
                                                                                    _vm._v(" "),
                                                                                    _c(
                                                                                        "CCol",
                                                                                        {
                                                                                            staticClass: "text-right",
                                                                                            attrs: {col: "6"}
                                                                                        },
                                                                                        [
                                                                                            _c(
                                                                                                "CButton",
                                                                                                {
                                                                                                    staticClass: "px-0",
                                                                                                    attrs: {color: "link"}
                                                                                                },
                                                                                                [_vm._v("Forgot password?")]
                                                                                            ),
                                                                                            _vm._v(" "),
                                                                                            _c(
                                                                                                "router-link",
                                                                                                {
                                                                                                    attrs: {
                                                                                                        to: {name: "register"}
                                                                                                    }
                                                                                                },
                                                                                                [
                                                                                                    _c(
                                                                                                        "CButton",
                                                                                                        {
                                                                                                            staticClass: "d-lg-none",
                                                                                                            attrs: {color: "link"}
                                                                                                        },
                                                                                                        [_vm._v("Register now!")]
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
                                                    ),
                                                    _vm._v(" "),
                                                    _c(
                                                        "CCard",
                                                        {
                                                            staticClass: "text-center py-5 d-md-down-none",
                                                            attrs: {
                                                                "body-wrapper": "",
                                                                color: "primary",
                                                                "text-color": "white"
                                                            }
                                                        },
                                                        [
                                                            _c(
                                                                "CCardBody",
                                                                [
                                                                    _c("h2", [_vm._v("Sign up")]),
                                                                    _vm._v(" "),
                                                                    _c("p", [_vm._v("Welcome to Sidooh")]),
                                                                    _vm._v(" "),
                                                                    _c(
                                                                        "router-link",
                                                                        {attrs: {to: {name: "register"}}},
                                                                        [
                                                                            _c(
                                                                                "CButton",
                                                                                {
                                                                                    attrs: {
                                                                                        color: "light",
                                                                                        size: "lg",
                                                                                        variant: "outline"
                                                                                    }
                                                                                },
                                                                                [
                                                                                    _vm._v(
                                                                                        "\n                                    Register Now!\n                                "
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
    "./resources/js/views/auth/Login.vue":
    /*!*******************************************!*\
      !*** ./resources/js/views/auth/Login.vue ***!
      \*******************************************/
    /*! exports provided: default */
    /***/ (function (module, __webpack_exports__, __webpack_require__) {

        "use strict";
        __webpack_require__.r(__webpack_exports__);
        /* harmony import */
        var _Login_vue_vue_type_template_id_46ec553e___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./Login.vue?vue&type=template&id=46ec553e& */ "./resources/js/views/auth/Login.vue?vue&type=template&id=46ec553e&");
        /* harmony import */
        var _Login_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./Login.vue?vue&type=script&lang=js& */ "./resources/js/views/auth/Login.vue?vue&type=script&lang=js&");
        /* empty/unused harmony star reexport *//* harmony import */
        var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");


        /* normalize component */

        var component = Object(_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__["default"])(
            _Login_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__["default"],
            _Login_vue_vue_type_template_id_46ec553e___WEBPACK_IMPORTED_MODULE_0__["render"],
            _Login_vue_vue_type_template_id_46ec553e___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"],
            false,
            null,
            null,
            null
        )

        /* hot reload */
        if (false) {
            var api;
        }
        component.options.__file = "resources/js/views/auth/Login.vue"
        /* harmony default export */
        __webpack_exports__["default"] = (component.exports);

        /***/
    }),

    /***/
    "./resources/js/views/auth/Login.vue?vue&type=script&lang=js&":
    /*!********************************************************************!*\
      !*** ./resources/js/views/auth/Login.vue?vue&type=script&lang=js& ***!
      \********************************************************************/
    /*! exports provided: default */
    /***/ (function (module, __webpack_exports__, __webpack_require__) {

        "use strict";
        __webpack_require__.r(__webpack_exports__);
        /* harmony import */
        var _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_Login_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/babel-loader/lib??ref--4-0!../../../../node_modules/vue-loader/lib??vue-loader-options!./Login.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/views/auth/Login.vue?vue&type=script&lang=js&");
        /* empty/unused harmony star reexport */ /* harmony default export */
        __webpack_exports__["default"] = (_node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_Login_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__["default"]);

        /***/
    }),

    /***/
    "./resources/js/views/auth/Login.vue?vue&type=template&id=46ec553e&":
    /*!**************************************************************************!*\
      !*** ./resources/js/views/auth/Login.vue?vue&type=template&id=46ec553e& ***!
      \**************************************************************************/
    /*! exports provided: render, staticRenderFns */
    /***/ (function (module, __webpack_exports__, __webpack_require__) {

        "use strict";
        __webpack_require__.r(__webpack_exports__);
        /* harmony import */
        var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_Login_vue_vue_type_template_id_46ec553e___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../node_modules/vue-loader/lib??vue-loader-options!./Login.vue?vue&type=template&id=46ec553e& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/views/auth/Login.vue?vue&type=template&id=46ec553e&");
        /* harmony reexport (safe) */
        __webpack_require__.d(__webpack_exports__, "render", function () {
            return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_Login_vue_vue_type_template_id_46ec553e___WEBPACK_IMPORTED_MODULE_0__["render"];
        });

        /* harmony reexport (safe) */
        __webpack_require__.d(__webpack_exports__, "staticRenderFns", function () {
            return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_Login_vue_vue_type_template_id_46ec553e___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"];
        });


        /***/
    })

}]);
