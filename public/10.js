(window.webpackJsonp=window.webpackJsonp||[]).push([[10],{114:function(t,e,r){"use strict";r.r(e);var n=r(2),o=r.n(n),a=r(1),s=r(6),i=r.n(s);function u(t,e,r,n,o,a,s){try{var i=t[a](s),u=i.value}catch(t){return void r(t)}i.done?e(u):Promise.resolve(u).then(n,o)}function l(t,e){var r=Object.keys(t);if(Object.getOwnPropertySymbols){var n=Object.getOwnPropertySymbols(t);e&&(n=n.filter((function(e){return Object.getOwnPropertyDescriptor(t,e).enumerable}))),r.push.apply(r,n)}return r}function c(t){for(var e=1;e<arguments.length;e++){var r=null!=arguments[e]?arguments[e]:{};e%2?l(Object(r),!0).forEach((function(e){m(t,e,r[e])})):Object.getOwnPropertyDescriptors?Object.defineProperties(t,Object.getOwnPropertyDescriptors(r)):l(Object(r)).forEach((function(e){Object.defineProperty(t,e,Object.getOwnPropertyDescriptor(r,e))}))}return t}function m(t,e,r){return e in t?Object.defineProperty(t,e,{value:r,enumerable:!0,configurable:!0,writable:!0}):t[e]=r,t}var p={name:"Airtime",data:function(){return{form:{amount:"",mpesa_phone:null},voucherAmounts:{100:"100",200:"200",500:"500",1e3:"1000",2500:"2500",1e4:"10000","-1":"Other"},otherAmount:!1,otherNumber:!1,mpesaNumber:!1,options:["MPesa","Voucher"],selectedOption:"MPesa",validation:{amount:"",mpesa_phone:""},showError:!1,loading:!1,message:"",error:null}},computed:c(c({},Object(a.c)("Purchases",["errors"])),{},{validForm:function(){return!this.validation.amount&&!this.validation.purchaseMethod&&(!this.mpesaNumber||!this.validation.mpesa_phone)&&this.form.amount}}),methods:c(c({},Object(a.b)("Purchases",["buyVoucher"])),{},{checkAmount:function(t){if(t>=100&&t<=15e4){/^\d+$/.test(t)?(this.validation.amount="",this.form.amount=t):this.validation.amount="Please only put whole numbers"}else"-1"===t?this.otherAmount=!0:this.validation.amount="Amount should be min of 100 and max of 150000"},checkMpesaPhone:function(t){if(t.number)if(t.valid){/^(?:\+?254|0)?((?:(?:7(?:(?:[01249][0-9])|(?:5[789])|(?:6[89])))|(?:1(?:[1][0-5])))[0-9]{6})$/.test(t.number)?(this.validation.mpesa_phone="",this.error=null,this.form.mpesa_phone=t.number.replace("+","")):this.validation.mpesa_phone="Enter a valid Mpesa Number"}else this.validation.mpesa_phone="Number seems to be invalid. Please try again."},setOtherAmount:function(t){this.otherAmount=t},setMpesaNumber:function(t){this.mpesaNumber=t},submit:function(){var t,e=this;return(t=o.a.mark((function t(){return o.a.wrap((function(t){for(;;)switch(t.prev=t.next){case 0:return t.prev=0,t.next=3,e.buyVoucher(e.form).then((function(t){console.log("success",t),e.showError=!1,i.a.swal({title:t.status,text:t.message,icon:"success"}),e.$router.push({name:"voucher_status",params:{id:t.data.id}})}),(function(t){console.log("error",t),t.error&&(e.showError=!0),e.loading=!1,e.message=t.response&&t.response.data||t.message||t.error||t.toString()}));case 3:t.next=8;break;case 5:t.prev=5,t.t0=t.catch(0),console.log("purchaseVoucherVueError",t.t0);case 8:case"end":return t.stop()}}),t,null,[[0,5]])})),function(){var e=this,r=arguments;return new Promise((function(n,o){var a=t.apply(e,r);function s(t){u(a,n,o,s,i,"next",t)}function i(t){u(a,n,o,s,i,"throw",t)}s(void 0)}))})()}})},h=r(3),d=Object(h.a)(p,(function(){var t=this,e=t.$createElement,r=t._self._c||e;return r("CContainer",[r("CRow",{staticClass:"justify-content-center"},[r("CCol",{attrs:{md:"5",sm:"6"}},[r("CCardGroup",[r("CCard",{staticClass:"p-4"},[r("CCardBody",[r("CForm",{on:{submit:function(e){return e.preventDefault(),t.submit(e)}}},[r("h1",[t._v("Top Up Voucher")]),t._v(" "),r("p",{staticClass:"text-muted"},[t._v("Kindly fill in the required details")]),t._v(" "),t.showError?r("p",{staticClass:"alert-warning",attrs:{id:"error"}},[t._v("Some details were not filled in\n                                correctly")]):t._e(),t._v(" "),t.error?r("p",{staticClass:"alert-warning"},[t._v("\n                                "+t._s(t.error)+"\n                            ")]):t._e(),t._v(" "),r("div",{staticClass:"mt-4"},[r("span",[t._v("Amount")]),t._v(" "),r("CRow",t._l(t.voucherAmounts,(function(e,n){return r("CCol",{staticClass:"mb-3",attrs:{md:"4",sm:"6",xl:"3"}},[r("CButton",{key:n,attrs:{block:"",color:"primary",shape:"pill",variant:"outline"},on:{click:function(e){return t.checkAmount(n)}}},[t._v(t._s(e)+"\n                                        ")])],1)})),1),t._v(" "),r("CInput",{staticClass:"mb-0 mt-3",attrs:{disabled:!t.otherAmount,max:"10000",min:"10",placeholder:"amount",type:"number"},on:{"update:value":t.checkAmount},scopedSlots:t._u([{key:"prepend-content",fn:function(){return[r("CIcon",{attrs:{name:"cil-dollar"}})]},proxy:!0}]),model:{value:t.form.amount,callback:function(e){t.$set(t.form,"amount",e)},expression:"form.amount"}}),t._v(" "),t.validation.amount?r("p",{staticClass:"alert-warning",attrs:{id:"amountError"}},[t._v("\n                                    "+t._s(t.validation.amount)+"\n                                ")]):t._e()],1),t._v(" "),r("div",{staticClass:"mt-3"},[r("CRow",{staticClass:"form-group mb-0",attrs:{form:""}},[r("CCol",{staticClass:"col-form-label",attrs:{md:"6",tag:"label"}},[t._v("\n                                        Other Mpesa Number?\n                                    ")]),t._v(" "),r("CCol",{attrs:{md:"6"}},[r("CSwitch",{staticClass:"mr-1",attrs:{checked:t.mpesaNumber,color:"info",shape:"pill",slabelOn:"Buy for other",variant:"outline"},on:{"update:checked":t.setMpesaNumber}})],1),t._v(" "),t.mpesaNumber?r("CCol",[r("vue-tel-input",{staticClass:"mt-3",attrs:{invalidMsg:t.error},on:{validate:t.checkMpesaPhone}}),t._v(" "),t.errors.mpesaPhone?r("p",{staticClass:"alert-warning",attrs:{id:"mpesaPhoneError"}},[t._v("\n                                            "+t._s(t.errors.mpesaPhone[0])+"\n                                        ")]):t._e(),t._v(" "),t.validation.mpesa_phone?r("p",{staticClass:"alert-warning",attrs:{id:"mpesaNumberError"}},[t._v("\n                                            "+t._s(t.validation.mpesa_phone)+"\n                                        ")]):t._e()],1):t._e()],1)],1),t._v(" "),r("CRow",[r("CCol",{staticClass:"text-left mt-3",attrs:{col:"12"}},[r("CButton",{attrs:{disabled:!t.validForm,color:"primary",sclass:"px-4 mt-3",type:"submit"}},[t._v("Top Up\n                                    ")]),t._v(" "),r("CButton",{attrs:{color:"danger",ssize:"sm",type:"reset"}},[t._v("\n                                        Reset\n                                    ")])],1)],1)],1)],1)],1)],1)],1)],1)],1)}),[],!1,null,null,null);e.default=d.exports}}]);