(window.webpackJsonp=window.webpackJsonp||[]).push([[11],{85:function(t,e,s){"use strict";s.r(e);var r=s(0);function n(t,e){var s=Object.keys(t);if(Object.getOwnPropertySymbols){var r=Object.getOwnPropertySymbols(t);e&&(r=r.filter((function(e){return Object.getOwnPropertyDescriptor(t,e).enumerable}))),s.push.apply(s,r)}return s}function a(t){for(var e=1;e<arguments.length;e++){var s=null!=arguments[e]?arguments[e]:{};e%2?n(Object(s),!0).forEach((function(e){o(t,e,s[e])})):Object.getOwnPropertyDescriptors?Object.defineProperties(t,Object.getOwnPropertyDescriptors(s)):n(Object(s)).forEach((function(e){Object.defineProperty(t,e,Object.getOwnPropertyDescriptor(s,e))}))}return t}function o(t,e,s){return e in t?Object.defineProperty(t,e,{value:s,enumerable:!0,configurable:!0,writable:!0}):t[e]=s,t}var u={name:"AirtimeStatus",data:function(){return{steps:3,timerCount:30,timerEnabled:!0}},beforeRouteUpdate:function(t,e,s){this.checkVoucherStatus(this.$route.params.id),s()},computed:a(a({},Object(r.c)("Purchases",["status","errors"])),{},{completed:function(){return"Complete"===this.status.payment.status&&"Paid"===this.status.payment.stk_request.status}}),watch:{timerEnabled:function(t){var e=this;t&&setTimeout((function(){e.timerCount--}),1e3)},timerCount:{handler:function(t){var e=this;t>0&&this.timerEnabled&&setTimeout((function(){e.timerCount--}),1e3),0===t&&(this.checkVoucherStatus(this.$route.params.id),this.timerEnabled=!1)},immediate:!0}},mounted:function(){this.checkVoucherStatus(this.$route.params.id),this.timerEnabled=!0},methods:a(a({},Object(r.b)("Purchases",["checkVoucherStatus"])),{},{getColour:function(t){return t=t.toLowerCase().trim(),["success","paid","complete"].includes(t)?"success":["pending","sent"].includes(t)?"secondary":"reimbursed"===t?"warning":"failed"===t?"danger":"primary"}})},i=s(2),c=Object(i.a)(u,(function(){var t=this,e=t.$createElement,s=t._self._c||e;return s("CContainer",[s("CRow",{staticClass:"justify-content-center"},[s("CCol",{attrs:{col:"12",md:"6"}},[t.status?s("CCard",[s("CCardHeader",[s("CIcon",{attrs:{name:"cil-justify-center"}}),t._v("\n                    Voucher "),s("small",[t._v("Status")]),t._v(" "),t.timerEnabled?s("span",{staticClass:"text-right float-right"},[t._v("Refreshing in "+t._s(t.timerCount))]):t._e()],1),t._v(" "),s("CCardBody",[t.status.payment.stk_request?s("div",[s("CAlert",{attrs:{color:t.getColour(t.status.payment.stk_request.status),show:""}},[s("h4",{staticClass:"alert-heading"},[t._v("STK Push")]),t._v(" "),s("p",[t._v("\n                                "+t._s(t.status.payment.stk_request.status)+"\n\n                                "),"Failed"===t.status.payment.stk_request.status?s("span",[t._v("\n                                    - "),s("b",[t._v(t._s(t.status.payment.stk_request.response.ResultDesc))])]):t._e()]),t._v(" "),s("hr"),t._v(" "),s("p",{staticClass:"mb-0"},[t._v("\n                                "+t._s(t._f("moment")(t.status.payment.stk_request.updated_at,"from"))+"\n                            ")])])],1):t._e()]),t._v(" "),s("CCardBody",[t.status.payment?s("div",[s("CAlert",{attrs:{color:t.getColour(t.status.payment.status),show:""}},[s("h4",{staticClass:"alert-heading"},[t._v("Payment")]),t._v(" "),s("p",[t._v("\n                                "+t._s(t.status.payment.status)+"\n                            ")]),t._v(" "),s("hr"),t._v(" "),s("p",{staticClass:"mb-0"},[t._v("\n                                "+t._s(t._f("moment")(t.status.payment.updated_at,"from"))+"\n                            ")])])],1):t._e()]),t._v(" "),s("CCardBody",[t.completed?s("div",[s("CButton",{attrs:{to:{name:"finances"},color:"success",size:"sm"}},[s("CIcon",{attrs:{name:"cil-info"}}),t._v("\n                            Check voucher balance\n                        ")],1)],1):t._e()])],1):s("CCard",[s("CCardBody",[s("CCardText",[s("b",[t._v("Oops!")]),t._v("\n\n                        The item you are looking for does not exist.\n                    ")]),t._v(" "),s("CButton",{attrs:{to:{name:"dashboard"},color:"danger",size:"sm"}},[s("CIcon",{attrs:{name:"cil-ban"}}),t._v("\n                        Go home\n                    ")],1)],1)],1)],1)],1)],1)}),[],!1,null,null,null);e.default=c.exports}}]);