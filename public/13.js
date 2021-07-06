(window["webpackJsonp"] = window["webpackJsonp"] || []).push([[13], {

    /***/
    "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/views/transactions/Index.vue?vue&type=script&lang=js&":
    /*!************************************************************************************************************************************************************************!*\
      !*** ./node_modules/babel-loader/lib??ref--4-0!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/views/transactions/Index.vue?vue&type=script&lang=js& ***!
      \************************************************************************************************************************************************************************/
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


        /* harmony default export */
        __webpack_exports__["default"] = ({
            name: "Index",
            components: {
                CChartLine: _coreui_vue_chartjs__WEBPACK_IMPORTED_MODULE_0__["CChartLine"]
            },
            data: function data() {
                return {
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
            created: function created() {
                this.fetchTransactions();
            },
            destroyed: function destroyed() {//TODO: Maybe add this after setting up data persistence
                // this.resetState()
            },
            computed: _objectSpread(_objectSpread({}, Object(vuex__WEBPACK_IMPORTED_MODULE_1__["mapGetters"])('TransactionsIndex', {
                data: 'data'
            })), {}, {
                totalAmount: function totalAmount() {
                    return _.sum(this.data.map(function (a) {
                        return a.amount;
                    }));
                },
                totalAmountToday: function totalAmountToday() {
                    var _this = this;

                    return _.sum(this.data.filter(function (item) {
                        return _this.isToday(new Date(item.created_at));
                    }).map(function (a) {
                        return a.amount;
                    }));
                },
                totalAmountThisMonth: function totalAmountThisMonth() {
                    var _this2 = this;

                    return _.sum(this.data.filter(function (item) {
                        return _this2.isThisMonth(new Date(item.created_at));
                    }).map(function (a) {
                        return a.amount;
                    }));
                },
                totalTransactions: function totalTransactions() {
                    return this.data.length;
                },
                totalTransactionsToday: function totalTransactionsToday() {
                    var _this3 = this;

                    return this.data.filter(function (item) {
                        return _this3.isToday(new Date(item.created_at));
                    }).length;
                },
                totalTransactionsThisMonth: function totalTransactionsThisMonth() {
                    var _this4 = this;

                    return this.data.filter(function (item) {
                        return _this4.isThisMonth(new Date(item.created_at));
                    }).length;
                },
                transactions: function transactions() {
                    return this.data.sort(function (a, b) {
                        return b.id - a.id;
                    });
                }
            }),
            methods: _objectSpread(_objectSpread({}, Object(vuex__WEBPACK_IMPORTED_MODULE_1__["mapActions"])('TransactionsIndex', {
                fetchTransactions: 'fetchData',
                processTransactionChartData: 'processChartData',
                setQuery: 'setQuery',
                resetState: 'resetState'
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
                    return status === 'success' ? 'success' : status === 'pending' ? 'secondary' : status === 'reimbursed' ? 'warning' : status === 'failed' ? 'danger' : 'primary';
                }
            })
        });

        /***/
    }),

    /***/
    "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/views/transactions/Index.vue?vue&type=template&id=79535a92&scoped=true&":
    /*!****************************************************************************************************************************************************************************************************************************!*\
      !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/views/transactions/Index.vue?vue&type=template&id=79535a92&scoped=true& ***!
      \****************************************************************************************************************************************************************************************************************************/
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
                        "CCard",
                        [
                            _c(
                                "CCardHeader",
                                [
                                    _vm._t("header", [
                                        _c("CIcon", {attrs: {name: "cil-grid"}}),
                                        _vm._v("\n                My Transactions\n            ")
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
                                            items: _vm.transactions,
                                            "items-per-page": 15,
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
                                                                        attrs: {color: _vm.getBadge(data.item.status)}
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
    "./resources/js/views/transactions/Index.vue":
    /*!***************************************************!*\
      !*** ./resources/js/views/transactions/Index.vue ***!
      \***************************************************/
    /*! exports provided: default */
    /***/ (function (module, __webpack_exports__, __webpack_require__) {

        "use strict";
        __webpack_require__.r(__webpack_exports__);
        /* harmony import */
        var _Index_vue_vue_type_template_id_79535a92_scoped_true___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./Index.vue?vue&type=template&id=79535a92&scoped=true& */ "./resources/js/views/transactions/Index.vue?vue&type=template&id=79535a92&scoped=true&");
        /* harmony import */
        var _Index_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./Index.vue?vue&type=script&lang=js& */ "./resources/js/views/transactions/Index.vue?vue&type=script&lang=js&");
        /* empty/unused harmony star reexport *//* harmony import */
        var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");


        /* normalize component */

        var component = Object(_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__["default"])(
            _Index_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__["default"],
            _Index_vue_vue_type_template_id_79535a92_scoped_true___WEBPACK_IMPORTED_MODULE_0__["render"],
            _Index_vue_vue_type_template_id_79535a92_scoped_true___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"],
            false,
            null,
            "79535a92",
            null
        )

        /* hot reload */
        if (false) {
            var api;
        }
        component.options.__file = "resources/js/views/transactions/Index.vue"
        /* harmony default export */
        __webpack_exports__["default"] = (component.exports);

        /***/
    }),

    /***/
    "./resources/js/views/transactions/Index.vue?vue&type=script&lang=js&":
    /*!****************************************************************************!*\
      !*** ./resources/js/views/transactions/Index.vue?vue&type=script&lang=js& ***!
      \****************************************************************************/
    /*! exports provided: default */
    /***/ (function (module, __webpack_exports__, __webpack_require__) {

        "use strict";
        __webpack_require__.r(__webpack_exports__);
        /* harmony import */
        var _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_Index_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/babel-loader/lib??ref--4-0!../../../../node_modules/vue-loader/lib??vue-loader-options!./Index.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/views/transactions/Index.vue?vue&type=script&lang=js&");
        /* empty/unused harmony star reexport */ /* harmony default export */
        __webpack_exports__["default"] = (_node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_Index_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__["default"]);

        /***/
    }),

    /***/
    "./resources/js/views/transactions/Index.vue?vue&type=template&id=79535a92&scoped=true&":
    /*!**********************************************************************************************!*\
      !*** ./resources/js/views/transactions/Index.vue?vue&type=template&id=79535a92&scoped=true& ***!
      \**********************************************************************************************/
    /*! exports provided: render, staticRenderFns */
    /***/ (function (module, __webpack_exports__, __webpack_require__) {

        "use strict";
        __webpack_require__.r(__webpack_exports__);
        /* harmony import */
        var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_Index_vue_vue_type_template_id_79535a92_scoped_true___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../node_modules/vue-loader/lib??vue-loader-options!./Index.vue?vue&type=template&id=79535a92&scoped=true& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/views/transactions/Index.vue?vue&type=template&id=79535a92&scoped=true&");
        /* harmony reexport (safe) */
        __webpack_require__.d(__webpack_exports__, "render", function () {
            return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_Index_vue_vue_type_template_id_79535a92_scoped_true___WEBPACK_IMPORTED_MODULE_0__["render"];
        });

        /* harmony reexport (safe) */
        __webpack_require__.d(__webpack_exports__, "staticRenderFns", function () {
            return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_Index_vue_vue_type_template_id_79535a92_scoped_true___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"];
        });


        /***/
    })

}]);
