(window.webpackJsonp=window.webpackJsonp||[]).push([[9],{86:function(t,e,n){"use strict";n.r(e);var o=n(1),r=n.n(o),i=n(0),s=n(3),a=n.n(s);function u(t,e,n,o,r,i,s){try{var a=t[i](s),u=a.value}catch(t){return void n(t)}a.done?e(u):Promise.resolve(u).then(o,r)}function c(t,e){var n=Object.keys(t);if(Object.getOwnPropertySymbols){var o=Object.getOwnPropertySymbols(t);e&&(o=o.filter((function(e){return Object.getOwnPropertyDescriptor(t,e).enumerable}))),n.push.apply(n,o)}return n}function h(t){for(var e=1;e<arguments.length;e++){var n=null!=arguments[e]?arguments[e]:{};e%2?c(Object(n),!0).forEach((function(e){m(t,e,n[e])})):Object.getOwnPropertyDescriptors?Object.defineProperties(t,Object.getOwnPropertyDescriptors(n)):c(Object(n)).forEach((function(e){Object.defineProperty(t,e,Object.getOwnPropertyDescriptor(n,e))}))}return t}function m(t,e,n){return e in t?Object.defineProperty(t,e,{value:n,enumerable:!0,configurable:!0,writable:!0}):t[e]=n,t}var l={name:"Airtime",data:function(){return{form:{other_phone:null,amount:"",purchaseMethod:"MPESA"},airtimeAmounts:{20:"20",50:"50",100:"100",200:"200",500:"500",1e3:"1000","-1":"Other"},minAmount:10,maxAmount:10002340,otherAmount:!1,otherNumber:!1,options:["MPESA","VOUCHER"],selectedOption:"MPESA",validation:{other_phone:"",amount:"",purchaseMethod:""},showError:!1,loading:!1,message:"",error:null}},computed:h(h(h({},Object(i.c)("Purchases",["errors"])),Object(i.c)("Accounts",["voucherBalance"])),{},{validForm:function(){return!this.validation.amount&&!this.validation.purchaseMethod&&(!this.otherNumber||!this.validation.other_phone)&&this.form.amount}}),created:function(){this.isAuthenticated&&this.$router.push("/")},mounted:function(){},methods:h(h(h({},Object(i.b)("Purchases",["buyAirtime"])),Object(i.b)("Accounts",["getAccountBalances"])),{},{checkPhone:function(t){console.log(t),t.number&&(t.valid?(this.validation.other_phone="",this.error=null,this.form.other_phone=t.number.replace("+","")):this.validation.other_phone="Number seems to be invalid. Please try again.")},checkAmount:function(t){if(t>=this.minAmount&&t<=this.maxAmount){/^\d+$/.test(t)?(this.validation.amount="",this.form.amount=parseInt(t)):this.validation.amount="Please only put whole numbers"}else"-1"===t?this.otherAmount=!0:this.validation.amount="Amount should be min of ".concat(this.minAmount," and max of ").concat(this.maxAmount)},setOtherNumber:function(t){this.otherNumber=t},setOtherAmount:function(t){this.otherAmount=t},setMethod:function(t){this.form.purchaseMethod=t.toUpperCase(),"VOUCHER"===t&&(this.voucherBalance<parseInt(this.form.amount)&&this.confirmPayment(),console.log(this.voucherBalance,parseInt(this.form.amount)))},confirmPayment:function(){var t=this;a.a.swal({title:"Balance Insufficient",text:"Would you like to top up your voucher?",html:"Current balance: <b>".concat(this.voucherBalance,"</b>, Would you like to top up?"),icon:"info",showCancelButton:!0,confirmButtonText:"Top Up"}).then((function(e){e.isConfirmed?t.$router.push({name:"voucher"}):e.isDenied&&(t.setMethod("MPESA"),t.selectedOption="MPESA")}))},submit:function(){var t,e=this;return(t=r.a.mark((function t(){return r.a.wrap((function(t){for(;;)switch(t.prev=t.next){case 0:if("VOUCHER"!==e.form.purchaseMethod){t.next=3;break}return e.voucherBalance<parseInt(e.form.amount)&&e.confirmPayment(),t.abrupt("return",!1);case 3:return t.prev=3,t.next=6,e.buyAirtime(e.form).then((function(t){console.log("success",t),e.showError=!1,a.a.swal({title:t.status,text:t.message,icon:"success",timer:1500,showConfirmButton:!1,position:"top-end"}),e.$router.push({name:"airtime_status",params:{id:t.data.id}})}),(function(t){console.log("error",t),t.error&&(e.showError=!0),e.loading=!1,e.message=t.response&&t.response.data||t.message||t.error||t.toString()}));case 6:t.next=12;break;case 8:t.prev=8,t.t0=t.catch(3),console.log("purchaseAirtimeVueError",t.t0),e.showError=!0;case 12:case"end":return t.stop()}}),t,null,[[3,8]])})),function(){var e=this,n=arguments;return new Promise((function(o,r){var i=t.apply(e,n);function s(t){u(i,o,r,s,a,"next",t)}function a(t){u(i,o,r,s,a,"throw",t)}s(void 0)}))})()}})},p=n(2),f=Object(p.a)(l,(function(){var t=this.$createElement,e=this._self._c||t;return e("CContainer",{staticClass:" py-5"},[e("CRow",{staticClass:"justify-content-center"},[e("h1",[this._v("Coming Soon!")])]),this._v(" "),e("CRow",{staticClass:"justify-content-center"},[e("h4",[this._v("Stay tuned...")])])],1)}),[],!1,null,null,null);e.default=f.exports}}]);