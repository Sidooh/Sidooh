(window["webpackJsonp"] = window["webpackJsonp"] || []).push([[8], {

    /***/
    "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/views/purchases/Merchant.vue?vue&type=script&lang=js&":
    /*!************************************************************************************************************************************************************************!*\
      !*** ./node_modules/babel-loader/lib??ref--4-0!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/views/purchases/Merchant.vue?vue&type=script&lang=js& ***!
      \************************************************************************************************************************************************************************/
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
        var vue__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! vue */ "./node_modules/vue/dist/vue.common.js");
        /* harmony import */
        var vue__WEBPACK_IMPORTED_MODULE_2___default = /*#__PURE__*/__webpack_require__.n(vue__WEBPACK_IMPORTED_MODULE_2__);


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


        /* harmony default export */
        __webpack_exports__["default"] = ({
            name: 'Airtime',
            data: function data() {
                return {
                    form: {
                        other_phone: null,
                        amount: "",
                        purchaseMethod: "MPESA"
                    },
                    airtimeAmounts: {
                        20: '20',
                        50: '50',
                        100: '100',
                        200: '200',
                        500: '500',
                        1000: '1000',
                        '-1': 'Other'
                    },
                    minAmount: 10,
                    maxAmount: 10002340,
                    otherAmount: false,
                    otherNumber: false,
                    options: ['MPESA', 'VOUCHER'],
                    selectedOption: 'MPESA',
                    validation: {
                        other_phone: '',
                        amount: '',
                        purchaseMethod: ''
                    },
                    showError: false,
                    loading: false,
                    message: '',
                    error: null
                };
            },
            computed: _objectSpread(_objectSpread(_objectSpread({}, Object(vuex__WEBPACK_IMPORTED_MODULE_1__["mapGetters"])("Purchases", ["errors"])), Object(vuex__WEBPACK_IMPORTED_MODULE_1__["mapGetters"])("Accounts", ['voucherBalance'])), {}, {
                validForm: function validForm() {
                    return !this.validation.amount && !this.validation.purchaseMethod && (this.otherNumber ? !this.validation.other_phone : true) && this.form.amount;
                }
            }),
            created: function created() {
                if (this.isAuthenticated) {
                    this.$router.push('/');
                }
            },
            mounted: function mounted() {// this.checkAmount(this.form.amount)
            },
            methods: _objectSpread(_objectSpread(_objectSpread({}, Object(vuex__WEBPACK_IMPORTED_MODULE_1__["mapActions"])('Purchases', ["buyAirtime"])), Object(vuex__WEBPACK_IMPORTED_MODULE_1__["mapActions"])('Accounts', ["getAccountBalances"])), {}, {
                checkPhone: function checkPhone(phoneObject) {
                    console.log(phoneObject);
                    if (phoneObject.number) if (phoneObject.valid) {
                        // let safRegex = /^(?:\+?254|0)?((?:(?:7(?:(?:[01249][0-9])|(?:5[789])|(?:6[89])))|(?:1(?:[1][0-5])))[0-9]{6})$/
                        //
                        // if (safRegex.test(phoneObject.number)) {
                        this.validation.other_phone = '';
                        this.error = null;
                        this.form.other_phone = phoneObject.number.replace("+", "");
                    } else {
                        this.validation.other_phone = "Number seems to be invalid. Please try again.";
                    } // }
                },
                checkAmount: function checkAmount(amount) {
                    if (amount >= this.minAmount && amount <= this.maxAmount) {
                        var amountRegex = /^\d+$/;

                        if (amountRegex.test(amount)) {
                            this.validation.amount = '';
                            this.form.amount = parseInt(amount);
                        } else {
                            this.validation.amount = "Please only put whole numbers";
                        }
                    } else if (amount === '-1') {
                        this.otherAmount = true;
                    } else {
                        this.validation.amount = "Amount should be min of ".concat(this.minAmount, " and max of ").concat(this.maxAmount);
                    }
                },
                setOtherNumber: function setOtherNumber(e) {
                    this.otherNumber = e;
                },
                setOtherAmount: function setOtherAmount(e) {
                    this.otherAmount = e;
                },
                setMethod: function setMethod(e) {
                    this.form.purchaseMethod = e.toUpperCase();

                    if (e === 'VOUCHER') {
                        if (this.voucherBalance < parseInt(this.form.amount)) {
                            this.confirmPayment();
                        }

                        console.log(this.voucherBalance, parseInt(this.form.amount));
                    }
                },
                confirmPayment: function confirmPayment() {
                    var _this = this;

                    vue__WEBPACK_IMPORTED_MODULE_2___default.a.swal({
                        title: 'Balance Insufficient',
                        text: "Would you like to top up your voucher?",
                        html: "Current balance: <b>".concat(this.voucherBalance, "</b>, Would you like to top up?"),
                        icon: 'info',
                        // showDenyButton: true,
                        showCancelButton: true,
                        confirmButtonText: "Top Up" // denyButtonText: `Use MPESA`,

                    }).then(function (result) {
                        /* Read more about isConfirmed, isDenied below */
                        if (result.isConfirmed) {
                            _this.$router.push({
                                name: 'voucher'
                            });
                        } else if (result.isDenied) {
                            _this.setMethod('MPESA');

                            _this.selectedOption = 'MPESA';
                        }
                    });
                },
                submit: function submit() {
                    var _this2 = this;

                    return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default.a.mark(function _callee() {
                        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default.a.wrap(function _callee$(_context) {
                            while (1) {
                                switch (_context.prev = _context.next) {
                                    case 0:
                                        if (!(_this2.form.purchaseMethod === 'VOUCHER')) {
                                            _context.next = 3;
                                            break;
                                        }

                                        if (_this2.voucherBalance < parseInt(_this2.form.amount)) {
                                            _this2.confirmPayment();
                                        }

                                        return _context.abrupt("return", false);

                                    case 3:
                                        _context.prev = 3;
                                        _context.next = 6;
                                        return _this2.buyAirtime(_this2.form).then(function (d) {
                                            console.log('success', d);
                                            _this2.showError = false;
                                            vue__WEBPACK_IMPORTED_MODULE_2___default.a.swal({
                                                title: d.status,
                                                text: d.message,
                                                icon: 'success',
                                                timer: 1500,
                                                showConfirmButton: false,
                                                position: 'top-end'
                                            });

                                            _this2.$router.push({
                                                name: 'airtime_status',
                                                params: {
                                                    id: d.data.id
                                                }
                                            });
                                        }, function (error) {
                                            console.log('error', error);

                                            if (error.error) {
                                                _this2.showError = true;
                                            }

                                            _this2.loading = false;
                                            _this2.message = error.response && error.response.data || error.message || error.error || error.toString();
                                        });

                                    case 6:
                                        _context.next = 12;
                                        break;

                                    case 8:
                                        _context.prev = 8;
                                        _context.t0 = _context["catch"](3);
                                        console.log('purchaseAirtimeVueError', _context.t0);
                                        _this2.showError = true;

                                    case 12:
                                    case "end":
                                        return _context.stop();
                                }
                            }
                        }, _callee, null, [[3, 8]]);
                    }))();
                }
            })
        });

        /***/
    }),

    /***/
    "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/views/purchases/Merchant.vue?vue&type=template&id=676a6ef8&":
    /*!****************************************************************************************************************************************************************************************************************!*\
      !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/views/purchases/Merchant.vue?vue&type=template&id=676a6ef8& ***!
      \****************************************************************************************************************************************************************************************************************/
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
                {staticClass: " py-5"},
                [
                    _c("CRow", {staticClass: "justify-content-center"}, [
                        _c("h1", [_vm._v("Coming Soon!")])
                    ]),
                    _vm._v(" "),
                    _c("CRow", {staticClass: "justify-content-center"}, [
                        _c("h4", [_vm._v("Stay tuned...")])
                    ])
                ],
                1
            )
        }
        var staticRenderFns = []
        render._withStripped = true


        /***/
    }),

    /***/
    "./resources/js/views/purchases/Merchant.vue":
    /*!***************************************************!*\
      !*** ./resources/js/views/purchases/Merchant.vue ***!
      \***************************************************/
    /*! exports provided: default */
    /***/ (function (module, __webpack_exports__, __webpack_require__) {

        "use strict";
        __webpack_require__.r(__webpack_exports__);
        /* harmony import */
        var _Merchant_vue_vue_type_template_id_676a6ef8___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./Merchant.vue?vue&type=template&id=676a6ef8& */ "./resources/js/views/purchases/Merchant.vue?vue&type=template&id=676a6ef8&");
        /* harmony import */
        var _Merchant_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./Merchant.vue?vue&type=script&lang=js& */ "./resources/js/views/purchases/Merchant.vue?vue&type=script&lang=js&");
        /* empty/unused harmony star reexport *//* harmony import */
        var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");


        /* normalize component */

        var component = Object(_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__["default"])(
            _Merchant_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__["default"],
            _Merchant_vue_vue_type_template_id_676a6ef8___WEBPACK_IMPORTED_MODULE_0__["render"],
            _Merchant_vue_vue_type_template_id_676a6ef8___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"],
            false,
            null,
            null,
            null
        )

        /* hot reload */
        if (false) {
            var api;
        }
        component.options.__file = "resources/js/views/purchases/Merchant.vue"
        /* harmony default export */
        __webpack_exports__["default"] = (component.exports);

        /***/
    }),

    /***/
    "./resources/js/views/purchases/Merchant.vue?vue&type=script&lang=js&":
    /*!****************************************************************************!*\
      !*** ./resources/js/views/purchases/Merchant.vue?vue&type=script&lang=js& ***!
      \****************************************************************************/
    /*! exports provided: default */
    /***/ (function (module, __webpack_exports__, __webpack_require__) {

        "use strict";
        __webpack_require__.r(__webpack_exports__);
        /* harmony import */
        var _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_Merchant_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/babel-loader/lib??ref--4-0!../../../../node_modules/vue-loader/lib??vue-loader-options!./Merchant.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/views/purchases/Merchant.vue?vue&type=script&lang=js&");
        /* empty/unused harmony star reexport */ /* harmony default export */
        __webpack_exports__["default"] = (_node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_Merchant_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__["default"]);

        /***/
    }),

    /***/
    "./resources/js/views/purchases/Merchant.vue?vue&type=template&id=676a6ef8&":
    /*!**********************************************************************************!*\
      !*** ./resources/js/views/purchases/Merchant.vue?vue&type=template&id=676a6ef8& ***!
      \**********************************************************************************/
    /*! exports provided: render, staticRenderFns */
    /***/ (function (module, __webpack_exports__, __webpack_require__) {

        "use strict";
        __webpack_require__.r(__webpack_exports__);
        /* harmony import */
        var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_Merchant_vue_vue_type_template_id_676a6ef8___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../node_modules/vue-loader/lib??vue-loader-options!./Merchant.vue?vue&type=template&id=676a6ef8& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/views/purchases/Merchant.vue?vue&type=template&id=676a6ef8&");
        /* harmony reexport (safe) */
        __webpack_require__.d(__webpack_exports__, "render", function () {
            return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_Merchant_vue_vue_type_template_id_676a6ef8___WEBPACK_IMPORTED_MODULE_0__["render"];
        });

        /* harmony reexport (safe) */
        __webpack_require__.d(__webpack_exports__, "staticRenderFns", function () {
            return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_Merchant_vue_vue_type_template_id_676a6ef8___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"];
        });


        /***/
    })

}]);
