(window["webpackJsonp"] = window["webpackJsonp"] || []).push([[4], {

    /***/
    "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/views/auth/Register.vue?vue&type=script&lang=js&":
    /*!*******************************************************************************************************************************************************************!*\
      !*** ./node_modules/babel-loader/lib??ref--4-0!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/views/auth/Register.vue?vue&type=script&lang=js& ***!
      \*******************************************************************************************************************************************************************/
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
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
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
            name: 'Register',
            data: function data() {
                return {
                    form: {
                        phone: '',
                        otp: '',
                        name: '',
                        email: '',
                        password: '',
                        confirmPassword: ''
                    },
                    validation: {
                        otp: '',
                        name: '',
                        email: '',
                        password: '',
                        confirmPassword: ''
                    },
                    otp: null,
                    password_length: 0,
                    contains_eight_characters: false,
                    contains_number: false,
                    contains_uppercase: false,
                    contains_special_character: false,
                    valid_name: false,
                    valid_email: false,
                    valid_password: false,
                    valid_password_confirmation: false,
                    validPhoneInput: false,
                    validOtpInput: false,
                    error: null
                };
            },
            computed: _objectSpread(_objectSpread({}, Object(vuex__WEBPACK_IMPORTED_MODULE_1__["mapGetters"])("auth", ["registrationStep", "errors"])), {}, {
                validForm: function validForm() {
                    return this.valid_name && this.valid_email && this.valid_password && this.valid_password;
                }
            }),
            mounted: function mounted() {
                if (!this.validPhoneInput && this.registrationStep !== 1) {
                    this.setRegistrationStep(1);
                }
            },
            methods: _objectSpread(_objectSpread({}, Object(vuex__WEBPACK_IMPORTED_MODULE_1__["mapActions"])('auth', ["registerCheckPhone", "setRegistrationStep", "register"])), {}, {
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
                submitStepOne: function submitStepOne() {
                    var _this = this;

                    return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default.a.mark(function _callee() {
                        var phone;
                        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default.a.wrap(function _callee$(_context) {
                            while (1) {
                                switch (_context.prev = _context.next) {
                                    case 0:
                                        phone = {
                                            "phone": _this.form.phone
                                        };
                                        _context.prev = 1;
                                        _context.next = 4;
                                        return _this.registerCheckPhone(phone).then(function (d) {
                                            console.log('success', d);

                                            if (d.acc.user) {
                                                _this.form.name = d.acc.user.name;
                                                _this.form.email = d.acc.user.email;

                                                _this.checkName();

                                                _this.checkEmail();
                                            }

                                            _this.otp = d.otp;

                                            _this.setRegistrationStep(2);
                                        }, function (error) {
                                            console.log('error', error);

                                            if (error.error) {
                                                _this.showError = true;
                                            }

                                            _this.loading = false;
                                            _this.error = error.data && error.data.message || error.message || error.error || error.toString();
                                        });

                                    case 4:
                                        _context.next = 10;
                                        break;

                                    case 6:
                                        _context.prev = 6;
                                        _context.t0 = _context["catch"](1);
                                        console.log('regVueError', _context.t0);
                                        _this.showError = true;

                                    case 10:
                                    case "end":
                                        return _context.stop();
                                }
                            }
                        }, _callee, null, [[1, 6]]);
                    }))();
                },
                submitStepTwo: function submitStepTwo() {
                    var _this2 = this;

                    return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default.a.mark(function _callee2() {
                        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default.a.wrap(function _callee2$(_context2) {
                            while (1) {
                                switch (_context2.prev = _context2.next) {
                                    case 0:
                                        if (parseInt(_this2.form.otp) === _this2.otp) {
                                            _this2.setRegistrationStep(3);
                                        }

                                    case 1:
                                    case "end":
                                        return _context2.stop();
                                }
                            }
                        }, _callee2);
                    }))();
                },
                checkOtp: function checkOtp() {
                    var format = /^[0-9]{6}$/;

                    if (this.form.otp.length === 6) {
                        var m = format.test(this.form.otp);

                        if (m && parseInt(this.form.otp) === this.otp) {
                            this.validation.otp = '';
                            this.validOtpInput = true;
                            this.setRegistrationStep(3); //    TODO: Notify user of successful otp
                        } else {
                            this.validation.otp = 'Please check code sent to the number or go back and try again.';
                            this.validOtpInput = false;
                        }
                    } else {
                        this.validation.otp = '';
                        this.validOtpInput = false;
                    }
                },
                checkName: function checkName() {
                    var format = /^[A-z ,\.&'-]{3,}$/;
                    this.form.name = this.form.name.trim();
                    var m = format.test(this.form.name);

                    if (m && this.form.name.length > 0) {
                        this.validation.name = '';
                        this.valid_name = true;
                    } else {
                        this.validation.name = 'Please put at least 3 characters for the name';
                        this.valid_name = false;
                    }
                },
                checkEmail: function checkEmail() {
                    var format = /^([a-z0-9\+_\-]{2,})(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]{2,}\.)+[a-z]{2,6}$/;
                    var m = format.test(this.form.email);

                    if (m && this.form.email.length > 0) {
                        this.validation.email = '';
                        this.valid_email = true;
                    } else {
                        this.validation.email = 'Please match the correct email format';
                        this.valid_email = false;
                    }
                },
                checkPassword: function checkPassword() {
                    this.password_length = this.form.password.length;
                    var format = /[ !@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?]/;

                    if (this.password_length >= 8) {
                        this.contains_eight_characters = true;
                    } else {
                        this.validation.password = 'Needs to be 8 characters.';
                        this.contains_eight_characters = false;
                    }

                    this.contains_number = /\d/.test(this.form.password);
                    this.contains_uppercase = /[A-Z]/.test(this.form.password);
                    this.contains_special_character = format.test(this.form.password);

                    if (this.contains_eight_characters === true && this.contains_special_character === true && this.contains_uppercase === true && this.contains_number === true) {
                        this.valid_password = true;
                        this.validation.password = '';
                    } else {
                        this.valid_password = false;
                        this.validation.password = 'Should contain special, capital characters and number';
                    }

                    if (this.form.password.length === 0) {
                        this.validation.password = '';
                    }
                },
                checkConfirmPassword: function checkConfirmPassword() {
                    if (this.form.confirmPassword.length === this.form.password.length) {
                        if (this.form.confirmPassword === this.form.password) {
                            this.validation.confirmPassword = '';
                            this.valid_password_confirmation = true;
                        } else {
                            this.validation.confirmPassword = 'Passwords do not match';
                            this.valid_password_confirmation = false;
                        }
                    } else {
                        this.validation.confirmPassword = '';
                        this.valid_password_confirmation = false;
                    }
                },
                submitStepFinal: function submitStepFinal() {
                    var _this3 = this;

                    return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default.a.mark(function _callee3() {
                        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default.a.wrap(function _callee3$(_context3) {
                            while (1) {
                                switch (_context3.prev = _context3.next) {
                                    case 0:
                                        console.log(_this3.validForm, "Final step");

                                        if (_this3.validForm) {
                                            _context3.next = 3;
                                            break;
                                        }

                                        return _context3.abrupt("return", false);

                                    case 3:
                                        _this3.form.password_confirmation = _this3.form.confirmPassword;
                                        _context3.prev = 4;
                                        _context3.next = 7;
                                        return _this3.register(_this3.form).then(function (d) {
                                            console.log('success', d);

                                            _this3.$router.push('/');
                                        }, function (error) {
                                            console.log('error', error);

                                            if (error.error) {
                                                _this3.showError = true;
                                            }

                                            _this3.loading = false;
                                            _this3.error = error.response && error.response.data || error.message || error.error || error.toString();
                                        });

                                    case 7:
                                        _context3.next = 13;
                                        break;

                                    case 9:
                                        _context3.prev = 9;
                                        _context3.t0 = _context3["catch"](4);
                                        console.log('regVueError', _context3.t0);
                                        _this3.showError = true;

                                    case 13:
                                    case "end":
                                        return _context3.stop();
                                }
                            }
                        }, _callee3, null, [[4, 9]]);
                    }))();
                }
            })
        });

        /***/
    }),

    /***/
    "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/views/auth/Register.vue?vue&type=template&id=0a273bdb&":
    /*!***********************************************************************************************************************************************************************************************************!*\
      !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/views/auth/Register.vue?vue&type=template&id=0a273bdb& ***!
      \***********************************************************************************************************************************************************************************************************/
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
                {staticClass: "d-flex align-items-center min-vh-100"},
                [
                    _c(
                        "CContainer",
                        {attrs: {fluid: ""}},
                        [
                            _c(
                                "CRow",
                                {staticClass: "justify-content-center"},
                                [
                                    _c(
                                        "CCol",
                                        {attrs: {md: "4", sm: "6"}},
                                        [
                                            _c(
                                                "CCard",
                                                {staticClass: "mx-4 mb-0"},
                                                [
                                                    _c(
                                                        "CCardBody",
                                                        {staticClass: "p-4"},
                                                        [
                                                            _vm.registrationStep === 1
                                                                ? _c(
                                                                    "CForm",
                                                                    {
                                                                        on: {
                                                                            submit: function ($event) {
                                                                                $event.preventDefault()
                                                                                return _vm.submitStepOne($event)
                                                                            }
                                                                        }
                                                                    },
                                                                    [
                                                                        _c("h1", [_vm._v("Register")]),
                                                                        _vm._v(" "),
                                                                        _c("p", {staticClass: "text-muted"}, [
                                                                            _vm._v("Create your account")
                                                                        ]),
                                                                        _vm._v(" "),
                                                                        _c("span", [
                                                                            _c("b", [_vm._v("Step 1:")]),
                                                                            _vm._v(" Check your number.")
                                                                        ]),
                                                                        _vm._v(" "),
                                                                        _c("vue-tel-input", {
                                                                            staticClass: "mt-3",
                                                                            attrs: {invalidMsg: _vm.error},
                                                                            on: {validate: _vm.checkPhone}
                                                                        }),
                                                                        _vm._v(" "),
                                                                        _vm.error
                                                                            ? _c(
                                                                                "span",
                                                                                {
                                                                                    staticClass:
                                                                                        "text-danger text-sm font-sm text-center"
                                                                                },
                                                                                [_vm._v(_vm._s(_vm.error))]
                                                                            )
                                                                            : _vm._e(),
                                                                        _vm._v(" "),
                                                                        _c(
                                                                            "CButton",
                                                                            {
                                                                                staticClass: "mt-3",
                                                                                attrs: {
                                                                                    disabled: !_vm.validPhoneInput,
                                                                                    block: "",
                                                                                    color: "success",
                                                                                    type: "submit"
                                                                                }
                                                                            },
                                                                            [
                                                                                _vm._v(
                                                                                    "\n                                Proceed\n                            "
                                                                                )
                                                                            ]
                                                                        )
                                                                    ],
                                                                    1
                                                                )
                                                                : _vm._e(),
                                                            _vm._v(" "),
                                                            _vm.registrationStep === 2
                                                                ? _c(
                                                                    "CForm",
                                                                    {
                                                                        on: {
                                                                            submit: function ($event) {
                                                                                $event.preventDefault()
                                                                                return _vm.submitStepTwo($event)
                                                                            }
                                                                        }
                                                                    },
                                                                    [
                                                                        _c("h1", [_vm._v("Register")]),
                                                                        _vm._v(" "),
                                                                        _c("p", {staticClass: "text-muted"}, [
                                                                            _vm._v("Create your account")
                                                                        ]),
                                                                        _vm._v(" "),
                                                                        _c("span", [
                                                                            _c("b", [_vm._v("Step 2:")]),
                                                                            _vm._v(" Verify your number.")
                                                                        ]),
                                                                        _vm._v(" "),
                                                                        _vm.otp
                                                                            ? _c(
                                                                                "span",
                                                                                {staticClass: "alert-info, my-2"},
                                                                                [
                                                                                    _vm._v(
                                                                                        "A code was sent to the number, please add it below."
                                                                                    )
                                                                                ]
                                                                            )
                                                                            : _vm._e(),
                                                                        _vm._v(" "),
                                                                        _c("CInput", {
                                                                            staticClass: "mt-3",
                                                                            attrs: {
                                                                                autocomplete: "otp",
                                                                                min: "100000",
                                                                                placeholder: "Code",
                                                                                prepend: "6",
                                                                                type: "number"
                                                                            },
                                                                            on: {input: _vm.checkOtp},
                                                                            model: {
                                                                                value: _vm.form.otp,
                                                                                callback: function ($$v) {
                                                                                    _vm.$set(_vm.form, "otp", $$v)
                                                                                },
                                                                                expression: "form.otp"
                                                                            }
                                                                        }),
                                                                        _vm._v(" "),
                                                                        _vm.validation.otp
                                                                            ? _c(
                                                                                "p",
                                                                                {
                                                                                    staticClass: "alert-warning",
                                                                                    attrs: {id: "otpError"}
                                                                                },
                                                                                [
                                                                                    _vm._v(
                                                                                        "\n                                " +
                                                                                        _vm._s(_vm.validation.otp) +
                                                                                        "\n                            "
                                                                                    )
                                                                                ]
                                                                            )
                                                                            : _vm._e(),
                                                                        _vm._v(" "),
                                                                        _c(
                                                                            "CButton",
                                                                            {
                                                                                staticClass: "mt-3 float-left",
                                                                                attrs: {color: "secondary"},
                                                                                on: {
                                                                                    click: function ($event) {
                                                                                        return _vm.setRegistrationStep(1)
                                                                                    }
                                                                                }
                                                                            },
                                                                            [
                                                                                _vm._v(
                                                                                    "\n                                Back\n                            "
                                                                                )
                                                                            ]
                                                                        ),
                                                                        _vm._v(" "),
                                                                        _c(
                                                                            "CButton",
                                                                            {
                                                                                staticClass: "mt-3 float-right",
                                                                                attrs: {
                                                                                    disabled: !_vm.validOtpInput,
                                                                                    color: "success",
                                                                                    type: "submit"
                                                                                }
                                                                            },
                                                                            [
                                                                                _vm._v(
                                                                                    "\n                                Proceed\n                            "
                                                                                )
                                                                            ]
                                                                        )
                                                                    ],
                                                                    1
                                                                )
                                                                : _vm._e(),
                                                            _vm._v(" "),
                                                            _vm.registrationStep === 3
                                                                ? _c(
                                                                    "CForm",
                                                                    {
                                                                        on: {
                                                                            submit: function ($event) {
                                                                                $event.preventDefault()
                                                                                return _vm.submitStepFinal($event)
                                                                            }
                                                                        }
                                                                    },
                                                                    [
                                                                        _c("h1", [_vm._v("Register")]),
                                                                        _vm._v(" "),
                                                                        _c("p", {staticClass: "text-muted"}, [
                                                                            _vm._v("Create your account")
                                                                        ]),
                                                                        _vm._v(" "),
                                                                        _c("CInput", {
                                                                            attrs: {
                                                                                autocomplete: "name",
                                                                                placeholder: "Name"
                                                                            },
                                                                            on: {input: _vm.checkName},
                                                                            scopedSlots: _vm._u(
                                                                                [
                                                                                    {
                                                                                        key: "prepend-content",
                                                                                        fn: function () {
                                                                                            return [
                                                                                                _c("CIcon", {
                                                                                                    attrs: {name: "cil-user"}
                                                                                                })
                                                                                            ]
                                                                                        },
                                                                                        proxy: true
                                                                                    }
                                                                                ],
                                                                                null,
                                                                                false,
                                                                                3945887885
                                                                            ),
                                                                            model: {
                                                                                value: _vm.form.name,
                                                                                callback: function ($$v) {
                                                                                    _vm.$set(_vm.form, "name", $$v)
                                                                                },
                                                                                expression: "form.name"
                                                                            }
                                                                        }),
                                                                        _vm._v(" "),
                                                                        _vm.validation.name
                                                                            ? _c(
                                                                                "p",
                                                                                {
                                                                                    staticClass: "alert-warning",
                                                                                    attrs: {id: "nameError"}
                                                                                },
                                                                                [
                                                                                    _vm._v(
                                                                                        "\n                                " +
                                                                                        _vm._s(_vm.validation.name) +
                                                                                        "\n                            "
                                                                                    )
                                                                                ]
                                                                            )
                                                                            : _vm._e(),
                                                                        _vm._v(" "),
                                                                        _c("CInput", {
                                                                            attrs: {
                                                                                autocomplete: "email",
                                                                                placeholder: "Email",
                                                                                prepend: "@",
                                                                                type: "email"
                                                                            },
                                                                            on: {input: _vm.checkEmail},
                                                                            model: {
                                                                                value: _vm.form.email,
                                                                                callback: function ($$v) {
                                                                                    _vm.$set(_vm.form, "email", $$v)
                                                                                },
                                                                                expression: "form.email"
                                                                            }
                                                                        }),
                                                                        _vm._v(" "),
                                                                        _vm.validation.email
                                                                            ? _c(
                                                                                "p",
                                                                                {
                                                                                    staticClass: "alert-warning",
                                                                                    attrs: {id: "emailError"}
                                                                                },
                                                                                [
                                                                                    _vm._v(
                                                                                        "\n                                " +
                                                                                        _vm._s(_vm.validation.email) +
                                                                                        "\n                            "
                                                                                    )
                                                                                ]
                                                                            )
                                                                            : _vm._e(),
                                                                        _vm._v(" "),
                                                                        _c("CInput", {
                                                                            attrs: {
                                                                                autocomplete: "new-password",
                                                                                placeholder: "Password",
                                                                                type: "password"
                                                                            },
                                                                            on: {input: _vm.checkPassword},
                                                                            scopedSlots: _vm._u(
                                                                                [
                                                                                    {
                                                                                        key: "prepend-content",
                                                                                        fn: function () {
                                                                                            return [
                                                                                                _c("CIcon", {
                                                                                                    attrs: {
                                                                                                        name: "cil-lock-locked"
                                                                                                    }
                                                                                                })
                                                                                            ]
                                                                                        },
                                                                                        proxy: true
                                                                                    }
                                                                                ],
                                                                                null,
                                                                                false,
                                                                                3300492400
                                                                            ),
                                                                            model: {
                                                                                value: _vm.form.password,
                                                                                callback: function ($$v) {
                                                                                    _vm.$set(_vm.form, "password", $$v)
                                                                                },
                                                                                expression: "form.password"
                                                                            }
                                                                        }),
                                                                        _vm._v(" "),
                                                                        _vm.validation.password
                                                                            ? _c(
                                                                                "p",
                                                                                {
                                                                                    staticClass: "alert-warning",
                                                                                    attrs: {id: "passwordError"}
                                                                                },
                                                                                [
                                                                                    _vm._v(
                                                                                        "\n                                " +
                                                                                        _vm._s(_vm.validation.password) +
                                                                                        "\n                            "
                                                                                    )
                                                                                ]
                                                                            )
                                                                            : _vm._e(),
                                                                        _vm._v(" "),
                                                                        _c("CInput", {
                                                                            staticClass: "mb-4",
                                                                            attrs: {
                                                                                autocomplete: "new-password",
                                                                                placeholder: "Repeat password",
                                                                                type: "password"
                                                                            },
                                                                            on: {input: _vm.checkConfirmPassword},
                                                                            scopedSlots: _vm._u(
                                                                                [
                                                                                    {
                                                                                        key: "prepend-content",
                                                                                        fn: function () {
                                                                                            return [
                                                                                                _c("CIcon", {
                                                                                                    attrs: {
                                                                                                        name: "cil-lock-locked"
                                                                                                    }
                                                                                                })
                                                                                            ]
                                                                                        },
                                                                                        proxy: true
                                                                                    }
                                                                                ],
                                                                                null,
                                                                                false,
                                                                                3300492400
                                                                            ),
                                                                            model: {
                                                                                value: _vm.form.confirmPassword,
                                                                                callback: function ($$v) {
                                                                                    _vm.$set(
                                                                                        _vm.form,
                                                                                        "confirmPassword",
                                                                                        $$v
                                                                                    )
                                                                                },
                                                                                expression: "form.confirmPassword"
                                                                            }
                                                                        }),
                                                                        _vm._v(" "),
                                                                        _vm.validation.confirmPassword
                                                                            ? _c(
                                                                                "p",
                                                                                {
                                                                                    staticClass: "alert-warning",
                                                                                    attrs: {id: "confirmPasswordError"}
                                                                                },
                                                                                [
                                                                                    _vm._v(
                                                                                        "\n                                " +
                                                                                        _vm._s(
                                                                                            _vm.validation.confirmPassword
                                                                                        ) +
                                                                                        "\n                            "
                                                                                    )
                                                                                ]
                                                                            )
                                                                            : _vm._e(),
                                                                        _vm._v(" "),
                                                                        _c(
                                                                            "CButton",
                                                                            {
                                                                                attrs: {
                                                                                    disabled: !_vm.validForm,
                                                                                    block: "",
                                                                                    color: "success",
                                                                                    type: "submit"
                                                                                }
                                                                            },
                                                                            [
                                                                                _vm._v(
                                                                                    "Create Account\n                            "
                                                                                )
                                                                            ]
                                                                        )
                                                                    ],
                                                                    1
                                                                )
                                                                : _vm._e()
                                                        ],
                                                        1
                                                    ),
                                                    _vm._v(" "),
                                                    _c(
                                                        "CCardFooter",
                                                        {staticClass: "p-4"},
                                                        [
                                                            _c(
                                                                "CRow",
                                                                [
                                                                    _c(
                                                                        "CCol",
                                                                        {attrs: {col: "6", md: "12"}},
                                                                        [
                                                                            _c(
                                                                                "router-link",
                                                                                {attrs: {to: {name: "login"}}},
                                                                                [
                                                                                    _c(
                                                                                        "CButton",
                                                                                        {
                                                                                            attrs: {
                                                                                                block: "",
                                                                                                color: "facebook"
                                                                                            }
                                                                                        },
                                                                                        [
                                                                                            _vm._v(
                                                                                                "\n                                        Already have an account?\n                                    "
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
                ],
                1
            )
        }
        var staticRenderFns = []
        render._withStripped = true


        /***/
    }),

    /***/
    "./resources/js/views/auth/Register.vue":
    /*!**********************************************!*\
      !*** ./resources/js/views/auth/Register.vue ***!
      \**********************************************/
    /*! exports provided: default */
    /***/ (function (module, __webpack_exports__, __webpack_require__) {

        "use strict";
        __webpack_require__.r(__webpack_exports__);
        /* harmony import */
        var _Register_vue_vue_type_template_id_0a273bdb___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./Register.vue?vue&type=template&id=0a273bdb& */ "./resources/js/views/auth/Register.vue?vue&type=template&id=0a273bdb&");
        /* harmony import */
        var _Register_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./Register.vue?vue&type=script&lang=js& */ "./resources/js/views/auth/Register.vue?vue&type=script&lang=js&");
        /* empty/unused harmony star reexport *//* harmony import */
        var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");


        /* normalize component */

        var component = Object(_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__["default"])(
            _Register_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__["default"],
            _Register_vue_vue_type_template_id_0a273bdb___WEBPACK_IMPORTED_MODULE_0__["render"],
            _Register_vue_vue_type_template_id_0a273bdb___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"],
            false,
            null,
            null,
            null
        )

        /* hot reload */
        if (false) {
            var api;
        }
        component.options.__file = "resources/js/views/auth/Register.vue"
        /* harmony default export */
        __webpack_exports__["default"] = (component.exports);

        /***/
    }),

    /***/
    "./resources/js/views/auth/Register.vue?vue&type=script&lang=js&":
    /*!***********************************************************************!*\
      !*** ./resources/js/views/auth/Register.vue?vue&type=script&lang=js& ***!
      \***********************************************************************/
    /*! exports provided: default */
    /***/ (function (module, __webpack_exports__, __webpack_require__) {

        "use strict";
        __webpack_require__.r(__webpack_exports__);
        /* harmony import */
        var _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_Register_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/babel-loader/lib??ref--4-0!../../../../node_modules/vue-loader/lib??vue-loader-options!./Register.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/views/auth/Register.vue?vue&type=script&lang=js&");
        /* empty/unused harmony star reexport */ /* harmony default export */
        __webpack_exports__["default"] = (_node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_Register_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__["default"]);

        /***/
    }),

    /***/
    "./resources/js/views/auth/Register.vue?vue&type=template&id=0a273bdb&":
    /*!*****************************************************************************!*\
      !*** ./resources/js/views/auth/Register.vue?vue&type=template&id=0a273bdb& ***!
      \*****************************************************************************/
    /*! exports provided: render, staticRenderFns */
    /***/ (function (module, __webpack_exports__, __webpack_require__) {

        "use strict";
        __webpack_require__.r(__webpack_exports__);
        /* harmony import */
        var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_Register_vue_vue_type_template_id_0a273bdb___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../node_modules/vue-loader/lib??vue-loader-options!./Register.vue?vue&type=template&id=0a273bdb& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/views/auth/Register.vue?vue&type=template&id=0a273bdb&");
        /* harmony reexport (safe) */
        __webpack_require__.d(__webpack_exports__, "render", function () {
            return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_Register_vue_vue_type_template_id_0a273bdb___WEBPACK_IMPORTED_MODULE_0__["render"];
        });

        /* harmony reexport (safe) */
        __webpack_require__.d(__webpack_exports__, "staticRenderFns", function () {
            return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_Register_vue_vue_type_template_id_0a273bdb___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"];
        });


        /***/
    })

}]);
