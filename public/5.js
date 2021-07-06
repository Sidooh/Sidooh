(window["webpackJsonp"] = window["webpackJsonp"] || []).push([[5], {

    /***/
    "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/views/earnings/Index.vue?vue&type=script&lang=js&":
    /*!********************************************************************************************************************************************************************!*\
      !*** ./node_modules/babel-loader/lib??ref--4-0!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/views/earnings/Index.vue?vue&type=script&lang=js& ***!
      \********************************************************************************************************************************************************************/
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
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
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
                    fields: [// {key: 'id', /*_style: { width: '40%'}*/},
                        // {key: 'type',},
                        // {key: 'description'},
                        {
                            key: 'earnings',
                            label: 'Amount'
                        }, {
                            key: 'type'
                        }, {
                            key: 'account',
                            label: 'Invitee'
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
                    ],
                    options: {
                        maintainAspectRatio: false,
                        // elements: {
                        //     line: {
                        //         // tension: .3
                        //     }
                        // },
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

                // this.groupEarnings('y');
                this.fetchEarnings().then(function () {
                    _this.processEarningChartData();
                });
            },
            destroyed: function destroyed() {//TODO: Maybe add this after setting up data persistence
                // this.resetState()
            },
            computed: _objectSpread(_objectSpread({}, Object(vuex__WEBPACK_IMPORTED_MODULE_1__["mapGetters"])('EarningsIndex', {
                data: 'data',
                earningsChartData: 'chartData',
                earningsQuery: 'query',
                earningsTotal: "total"
            })), {}, {
                chartLabels: function chartLabels() {
                    return this.earningsChartData.map(function (a) {
                        return a.date;
                    });
                },
                chartData1: function chartData1() {
                    return this.earningsChartData.map(function (a) {
                        return parseFloat(a.amount).toFixed(4);
                    });
                },
                chartData2: function chartData2() {
                    return this.earningsChartData.map(function (a) {
                        return a.count;
                    });
                },
                totalAmount: function totalAmount() {
                    return _.sum(this.data.map(function (a) {
                        return parseFloat(a.earnings);
                    }));
                },
                totalAmountToday: function totalAmountToday() {
                    var _this2 = this;

                    return _.sum(this.data.filter(function (item) {
                        return _this2.isToday(new Date(item.created_at));
                    }).map(function (a) {
                        return parseFloat(a.earnings);
                    }));
                },
                totalAmountThisMonth: function totalAmountThisMonth() {
                    var _this3 = this;

                    return _.sum(this.data.filter(function (item) {
                        return _this3.isThisMonth(new Date(item.created_at));
                    }).map(function (a) {
                        return parseFloat(a.earnings);
                    }));
                },
                totalEarnings: function totalEarnings() {
                    return this.data.length;
                },
                totalEarningsToday: function totalEarningsToday() {
                    var _this4 = this;

                    return this.data.filter(function (item) {
                        return _this4.isToday(new Date(item.created_at));
                    }).length;
                },
                totalEarningsThisMonth: function totalEarningsThisMonth() {
                    var _this5 = this;

                    return this.data.filter(function (item) {
                        return _this5.isThisMonth(new Date(item.created_at));
                    }).length;
                },
                datasets: function datasets() {
                    return [{
                        data: this.chartData1,
                        backgroundColor: '#008',
                        borderColor: '#00c',
                        label: 'Amount',
                        // cubicInterpolationMode: 'monotone',
                        fill: false // yAxisID: 'y',

                    }, {
                        data: this.chartData2,
                        backgroundColor: '#080',
                        borderColor: '#0c0',
                        label: 'Count',
                        // cubicInterpolationMode: 'monotone',
                        fill: false // yAxisID: 'y1',

                    }];
                }
            }),
            methods: _objectSpread(_objectSpread({}, Object(vuex__WEBPACK_IMPORTED_MODULE_1__["mapActions"])('EarningsIndex', {
                fetchEarnings: 'fetchData',
                processEarningChartData: 'processChartData',
                setQuery: 'setQuery',
                resetState: 'resetState'
            })), {}, {
                groupEarnings: function groupEarnings(e) {
                    var q = Object.assign({}, this.earningsQuery, {
                        group: e,
                        yearLimit: false
                    }); // or
                    // const q = {...this.earningsQuery, { group: e} }

                    this.setQuery(q);
                    this.processEarningChartData();
                },
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
                formatNumber: function formatNumber(e) {
                    var dp = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : 4;
                    return e.toFixed(dp);
                }
            })
        });

        /***/
    }),

    /***/
    "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/views/earnings/Index.vue?vue&type=template&id=422b388b&scoped=true&":
    /*!************************************************************************************************************************************************************************************************************************!*\
      !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/views/earnings/Index.vue?vue&type=template&id=422b388b&scoped=true& ***!
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
                                                    _vm._v("Earnings Summary")
                                                ]),
                                                _vm._v(" "),
                                                _c("div", {staticClass: "small text-muted"}, [
                                                    _vm._v(
                                                        _vm._s(
                                                            _vm.earningsQuery.group === "d"
                                                                ? "Earnings today"
                                                                : _vm.earningsQuery.group === "m"
                                                                ? "Earnings this month"
                                                                : "Earnings this year"
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
                                                        "CButtonGroup",
                                                        {staticClass: "float-right mr-3 btn-group"},
                                                        [
                                                            _c(
                                                                "CButton",
                                                                {
                                                                    staticClass: "btn mx-0 btn-outline-secondary",
                                                                    class: [
                                                                        _vm.earningsQuery.group === "d" ? "active" : ""
                                                                    ],
                                                                    on: {
                                                                        click: function ($event) {
                                                                            return _vm.groupEarnings("d")
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
                                                                        _vm.earningsQuery.group === "m" ? "active" : ""
                                                                    ],
                                                                    on: {
                                                                        click: function ($event) {
                                                                            return _vm.groupEarnings("m")
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
                                                                        _vm.earningsQuery.group === "y" ? "active" : ""
                                                                    ],
                                                                    on: {
                                                                        click: function ($event) {
                                                                            return _vm.groupEarnings("y")
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
                                                        _vm._v("Number of Earnings")
                                                    ]),
                                                    _vm._v(" "),
                                                    _c("strong", [
                                                        _vm._v(
                                                            _vm._s(
                                                                _vm._f("numFormat")(
                                                                    _vm.formatNumber(_vm.totalEarnings),
                                                                    "0,0"
                                                                )
                                                            )
                                                        )
                                                    ]),
                                                    _vm._v(" "),
                                                    _c(
                                                        "span",
                                                        {attrs: {title: "Today's Number of Earnings"}},
                                                        [
                                                            _vm._v(
                                                                "(" +
                                                                _vm._s(
                                                                    _vm._f("numFormat")(
                                                                        _vm.formatNumber(_vm.totalEarningsToday),
                                                                        "0,0"
                                                                    )
                                                                ) +
                                                                ")"
                                                            )
                                                        ]
                                                    ),
                                                    _vm._v(" "),
                                                    _c("CProgress", {
                                                        staticClass: "progress-xs mt-2",
                                                        attrs: {
                                                            precision: 1,
                                                            value: _vm.totalEarnings,
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
                                                            _vm._s(
                                                                _vm._f("numFormat")(
                                                                    _vm.formatNumber(_vm.totalAmount),
                                                                    "0,0.0000"
                                                                )
                                                            )
                                                        )
                                                    ]),
                                                    _vm._v(" "),
                                                    _c("span", {attrs: {title: "Today's Transactions"}}, [
                                                        _vm._v(
                                                            "(" +
                                                            _vm._s(
                                                                _vm._f("numFormat")(
                                                                    _vm.formatNumber(_vm.totalAmountToday),
                                                                    "0,0.0000"
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
                                        _vm._v("\n                My Earnings\n            ")
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
                                            items: _vm.data,
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
                                                key: "account",
                                                fn: function (data) {
                                                    return [
                                                        _c("td", [
                                                            _vm._v(
                                                                "\n                        " +
                                                                _vm._s(data.item.account.id) +
                                                                "\n                    "
                                                            )
                                                        ])
                                                    ]
                                                }
                                            },
                                            {
                                                key: "type",
                                                fn: function (data) {
                                                    return [
                                                        _c(
                                                            "td",
                                                            [
                                                                _c(
                                                                    "CBadge",
                                                                    {
                                                                        attrs: {color: _vm.getBadge(data.item.type)}
                                                                    },
                                                                    [
                                                                        _vm._v(
                                                                            "\n                            " +
                                                                            _vm._s(data.item.type) +
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
    "./resources/js/views/earnings/Index.vue":
    /*!***********************************************!*\
      !*** ./resources/js/views/earnings/Index.vue ***!
      \***********************************************/
    /*! exports provided: default */
    /***/ (function (module, __webpack_exports__, __webpack_require__) {

        "use strict";
        __webpack_require__.r(__webpack_exports__);
        /* harmony import */
        var _Index_vue_vue_type_template_id_422b388b_scoped_true___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./Index.vue?vue&type=template&id=422b388b&scoped=true& */ "./resources/js/views/earnings/Index.vue?vue&type=template&id=422b388b&scoped=true&");
        /* harmony import */
        var _Index_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./Index.vue?vue&type=script&lang=js& */ "./resources/js/views/earnings/Index.vue?vue&type=script&lang=js&");
        /* empty/unused harmony star reexport *//* harmony import */
        var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");


        /* normalize component */

        var component = Object(_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__["default"])(
            _Index_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__["default"],
            _Index_vue_vue_type_template_id_422b388b_scoped_true___WEBPACK_IMPORTED_MODULE_0__["render"],
            _Index_vue_vue_type_template_id_422b388b_scoped_true___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"],
            false,
            null,
            "422b388b",
            null
        )

        /* hot reload */
        if (false) {
            var api;
        }
        component.options.__file = "resources/js/views/earnings/Index.vue"
        /* harmony default export */
        __webpack_exports__["default"] = (component.exports);

        /***/
    }),

    /***/
    "./resources/js/views/earnings/Index.vue?vue&type=script&lang=js&":
    /*!************************************************************************!*\
      !*** ./resources/js/views/earnings/Index.vue?vue&type=script&lang=js& ***!
      \************************************************************************/
    /*! exports provided: default */
    /***/ (function (module, __webpack_exports__, __webpack_require__) {

        "use strict";
        __webpack_require__.r(__webpack_exports__);
        /* harmony import */
        var _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_Index_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/babel-loader/lib??ref--4-0!../../../../node_modules/vue-loader/lib??vue-loader-options!./Index.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/views/earnings/Index.vue?vue&type=script&lang=js&");
        /* empty/unused harmony star reexport */ /* harmony default export */
        __webpack_exports__["default"] = (_node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_Index_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__["default"]);

        /***/
    }),

    /***/
    "./resources/js/views/earnings/Index.vue?vue&type=template&id=422b388b&scoped=true&":
    /*!******************************************************************************************!*\
      !*** ./resources/js/views/earnings/Index.vue?vue&type=template&id=422b388b&scoped=true& ***!
      \******************************************************************************************/
    /*! exports provided: render, staticRenderFns */
    /***/ (function (module, __webpack_exports__, __webpack_require__) {

        "use strict";
        __webpack_require__.r(__webpack_exports__);
        /* harmony import */
        var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_Index_vue_vue_type_template_id_422b388b_scoped_true___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../node_modules/vue-loader/lib??vue-loader-options!./Index.vue?vue&type=template&id=422b388b&scoped=true& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/views/earnings/Index.vue?vue&type=template&id=422b388b&scoped=true&");
        /* harmony reexport (safe) */
        __webpack_require__.d(__webpack_exports__, "render", function () {
            return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_Index_vue_vue_type_template_id_422b388b_scoped_true___WEBPACK_IMPORTED_MODULE_0__["render"];
        });

        /* harmony reexport (safe) */
        __webpack_require__.d(__webpack_exports__, "staticRenderFns", function () {
            return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_Index_vue_vue_type_template_id_422b388b_scoped_true___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"];
        });


        /***/
    })

}]);
