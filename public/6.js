(window.webpackJsonp=window.webpackJsonp||[]).push([[6],{112:function(t,e,r){"use strict";r.r(e);var o=r(2),n=r.n(o),a=r(1),s=r(6),i=r.n(s);function u(t,e,r,o,n,a,s){try{var i=t[a](s),u=i.value}catch(t){return void r(t)}i.done?e(u):Promise.resolve(u).then(o,n)}function c(t,e){var r=Object.keys(t);if(Object.getOwnPropertySymbols){var o=Object.getOwnPropertySymbols(t);e&&(o=o.filter((function(e){return Object.getOwnPropertyDescriptor(t,e).enumerable}))),r.push.apply(r,o)}return r}function l(t){for(var e=1;e<arguments.length;e++){var r=null!=arguments[e]?arguments[e]:{};e%2?c(Object(r),!0).forEach((function(e){m(t,e,r[e])})):Object.getOwnPropertyDescriptors?Object.defineProperties(t,Object.getOwnPropertyDescriptors(r)):c(Object(r)).forEach((function(e){Object.defineProperty(t,e,Object.getOwnPropertyDescriptor(r,e))}))}return t}function m(t,e,r){return e in t?Object.defineProperty(t,e,{value:r,enumerable:!0,configurable:!0,writable:!0}):t[e]=r,t}var h={name:"Airtime",data:function(){return{form:{other_phone:null,amount:"",purchaseMethod:"MPESA",mpesa_phone:null},airtimeAmounts:{20:"20",50:"50",100:"100",200:"200",500:"500",1e3:"1000","-1":"Other"},minAmount:10,maxAmount:10002340,otherAmount:!1,otherNumber:!1,mpesaNumber:!1,options:["MPESA","VOUCHER"],selectedOption:"MPESA",validation:{other_phone:"",amount:"",purchaseMethod:"",mpesa_phone:""},showError:!1,loading:!1,message:"",error:null}},computed:l(l(l({},Object(a.c)("Purchases",["errors"])),Object(a.c)("Accounts",["voucherBalance"])),{},{validForm:function(){return!this.validation.amount&&!this.validation.purchaseMethod&&(!this.otherNumber||!this.validation.other_phone)&&this.form.amount&&(!this.mpesaNumber||!this.validation.mpesa_phone)}}),created:function(){this.isAuthenticated&&this.$router.push("/")},mounted:function(){},methods:l(l(l({},Object(a.b)("Purchases",["buyAirtime"])),Object(a.b)("Accounts",["getAccountBalances"])),{},{checkPhone:function(t){t.number&&(t.valid?(this.validation.other_phone="",this.error=null,this.form.other_phone=t.number.replace("+","")):this.validation.other_phone="Number seems to be invalid. Please try again.")},checkMpesaPhone:function(t){if(t.number)if(t.valid){/^(?:\+?254|0)?((?:(?:7(?:(?:[01249][0-9])|(?:5[789])|(?:6[89])))|(?:1(?:[1][0-5])))[0-9]{6})$/.test(t.number)?(this.validation.mpesa_phone="",this.error=null,this.form.mpesa_phone=t.number.replace("+","")):this.validation.mpesa_phone="Enter a valid Mpesa Number"}else this.validation.mpesa_phone="Number seems to be invalid. Please try again."},checkAmount:function(t){if(t>=this.minAmount&&t<=this.maxAmount){/^\d+$/.test(t)?(this.validation.amount="",this.form.amount=parseInt(t)):this.validation.amount="Please only put whole numbers"}else"-1"===t?this.otherAmount=!0:this.validation.amount="Amount should be min of ".concat(this.minAmount," and max of ").concat(this.maxAmount)},setOtherNumber:function(t){this.otherNumber=t},setOtherAmount:function(t){this.otherAmount=t},setMethod:function(t){this.form.purchaseMethod=t.toUpperCase(),"VOUCHER"===t&&this.voucherBalance<parseInt(this.form.amount)&&this.confirmPayment()},setMpesaNumber:function(t){this.mpesaNumber=t},confirmPayment:function(){var t=this;i.a.swal({title:"Balance Insufficient",text:"Would you like to top up your voucher?",html:"Current balance: <b>".concat(this.voucherBalance,"</b>, Would you like to top up?"),icon:"info",showCancelButton:!0,confirmButtonText:"Top Up"}).then((function(e){e.isConfirmed?t.$router.push({name:"voucher"}):e.isDenied&&(t.setMethod("MPESA"),t.selectedOption="MPESA")}))},submit:function(){var t,e=this;return(t=n.a.mark((function t(){return n.a.wrap((function(t){for(;;)switch(t.prev=t.next){case 0:if("VOUCHER"!==e.form.purchaseMethod){t.next=3;break}return e.voucherBalance<parseInt(e.form.amount)&&e.confirmPayment(),t.abrupt("return",!1);case 3:return t.prev=3,t.next=6,e.buyAirtime(e.form).then((function(t){console.log("success",t),e.showError=!1,i.a.swal({title:t.status,text:t.message,icon:"success",timer:1500,showConfirmButton:!1,position:"top-end"}),e.$router.push({name:"airtime_status",params:{id:t.data.id}})}),(function(t){console.log("error",t),t.error&&(e.showError=!0),e.loading=!1,e.message=t.response&&t.response.data||t.message||t.error||t.toString()}));case 6:t.next=12;break;case 8:t.prev=8,t.t0=t.catch(3),console.log("purchaseAirtimeVueError",t.t0),e.showError=!0;case 12:case"end":return t.stop()}}),t,null,[[3,8]])})),function(){var e=this,r=arguments;return new Promise((function(o,n){var a=t.apply(e,r);function s(t){u(a,o,n,s,i,"next",t)}function i(t){u(a,o,n,s,i,"throw",t)}s(void 0)}))})()}})},p=r(3),d=Object(p.a)(h,(function(){var t=this,e=t.$createElement,r=t._self._c||e;return r("CContainer",[r("CRow",{staticClass:"justify-content-center"},[r("CCol",{attrs:{md:"5",sm:"6"}},[r("CCardGroup",[r("CCard",{staticClass:"p-4"},[r("CCardBody",[r("CForm",{on:{submit:function(e){return e.preventDefault(),t.submit(e)}}},[r("h1",[t._v("Buy Airtime")]),t._v(" "),r("p",{staticClass:"text-muted"},[t._v("Kindly fill in the required details")]),t._v(" "),t.showError?r("p",{staticClass:"alert-warning",attrs:{id:"error"}},[t._v("Some details were not filled in\n                                correctly")]):t._e(),t._v(" "),t.error?r("p",{staticClass:"alert-warning"},[t._v("\n                                "+t._s(t.error)+"\n                            ")]):t._e(),t._v(" "),r("div",{staticClass:"mt-3"},[r("CRow",{staticClass:"form-group mb-0",attrs:{form:""}},[r("CCol",{staticClass:"col-form-label",attrs:{md:"6",tag:"label"}},[t._v("\n                                        Other Number?\n                                    ")]),t._v(" "),r("CCol",{attrs:{md:"6"}},[r("CSwitch",{staticClass:"mr-1",attrs:{checked:t.otherNumber,color:"info",shape:"pill",slabelOn:"Buy for other",variant:"outline"},on:{"update:checked":t.setOtherNumber}})],1),t._v(" "),t.otherNumber?r("CCol",[r("vue-tel-input",{staticClass:"mt-3",attrs:{invalidMsg:t.error},on:{validate:t.checkPhone}}),t._v(" "),t.errors.phone?r("p",{staticClass:"alert-warning",attrs:{id:"phoneError"}},[t._v("\n                                            "+t._s(t.errors.phone[0])+"\n                                        ")]):t._e(),t._v(" "),t.validation.other_phone?r("p",{staticClass:"alert-warning",attrs:{id:"otherNumberError"}},[t._v("\n                                            "+t._s(t.validation.other_phone)+"\n                                        ")]):t._e()],1):t._e()],1)],1),t._v(" "),r("div",{staticClass:"mt-4"},[r("span",[t._v("Amount")]),t._v(" "),r("CRow",t._l(t.airtimeAmounts,(function(e,o){return r("CCol",{staticClass:"mb-3",attrs:{md:"4",sm:"6",xl:"3"}},[r("CButton",{key:o,attrs:{block:"",color:"primary",shape:"pill",variant:"outline"},on:{click:function(e){return t.checkAmount(o)}}},[t._v(t._s(e)+"\n                                        ")])],1)})),1),t._v(" "),r("CInput",{staticClass:"mb-0 mt-3",attrs:{disabled:!t.otherAmount,max:t.maxAmount,min:t.minAmount,placeholder:"amount",type:"number"},on:{"update:value":t.checkAmount},scopedSlots:t._u([{key:"prepend-content",fn:function(){return[r("CIcon",{attrs:{name:"cil-dollar"}})]},proxy:!0}]),model:{value:t.form.amount,callback:function(e){t.$set(t.form,"amount",e)},expression:"form.amount"}}),t._v(" "),t.validation.amount?r("p",{staticClass:"alert-warning",attrs:{id:"amountError"}},[t._v("\n                                    "+t._s(t.validation.amount)+"\n                                ")]):t._e()],1),t._v(" "),r("div",{staticClass:"mt-4"},[r("CRow",{staticClass:"form-group mt-3",attrs:{form:""}},[r("CCol",{attrs:{sm:"6"}},[t._v("\n                                        Payment Method\n                                    ")]),t._v(" "),r("CInputRadioGroup",{staticClass:"col-sm-6",attrs:{checked:t.selectedOption,inline:!0,options:t.options},on:{"update:checked":t.setMethod}}),t._v(" "),t.validation.purchaseMethod?r("p",{staticClass:"alert-warning",attrs:{id:"methodError"}},[t._v("\n                                        "+t._s(t.validation.purchaseMethod)+"\n                                    ")]):t._e()],1)],1),t._v(" "),"MPESA"===t.form.purchaseMethod?r("div",{staticClass:"mt-3"},[r("CRow",{staticClass:"form-group mb-0",attrs:{form:""}},[r("CCol",{staticClass:"col-form-label",attrs:{md:"6",tag:"label"}},[t._v("\n                                        Other Mpesa Number?\n                                    ")]),t._v(" "),r("CCol",{attrs:{md:"6"}},[r("CSwitch",{staticClass:"mr-1",attrs:{checked:t.mpesaNumber,color:"info",shape:"pill",slabelOn:"Buy for other",variant:"outline"},on:{"update:checked":t.setMpesaNumber}})],1),t._v(" "),t.mpesaNumber?r("CCol",[r("vue-tel-input",{staticClass:"mt-3",attrs:{invalidMsg:t.error},on:{validate:t.checkMpesaPhone}}),t._v(" "),t.errors.mpesaPhone?r("p",{staticClass:"alert-warning",attrs:{id:"mpesaPhoneError"}},[t._v("\n                                            "+t._s(t.errors.mpesaPhone[0])+"\n                                        ")]):t._e(),t._v(" "),t.validation.mpesa_phone?r("p",{staticClass:"alert-warning",attrs:{id:"mpesaNumberError"}},[t._v("\n                                            "+t._s(t.validation.mpesa_phone)+"\n                                        ")]):t._e()],1):t._e()],1)],1):t._e(),t._v(" "),r("CRow",[r("CCol",{staticClass:"text-left mt-3",attrs:{col:"12"}},[r("CButton",{attrs:{disabled:!t.validForm,color:"primary",sclass:"px-4 mt-3",type:"submit"}},[t._v("Buy\n                                    ")]),t._v(" "),r("CButton",{attrs:{color:"danger",ssize:"sm",type:"reset"}},[t._v("\n                                        Reset\n                                    ")])],1)],1)],1)],1)],1)],1)],1)],1)],1)}),[],!1,null,null,null);e.default=d.exports}}]);