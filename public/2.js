(window.webpackJsonp=window.webpackJsonp||[]).push([[2],{104:function(t,e,r){"use strict";const a=(t,e)=>{for(const r of Object.keys(e))e[r]instanceof Object&&Object.assign(e[r],a(t[r],e[r]));return Object.assign(t||{},e),t};e.a=a},105:function(t,e,r){"use strict";var a=()=>{const t={},e=document.styleSheets;let r="";for(let t=e.length-1;t>-1;t--){const a=e[t].cssRules;for(let t=a.length-1;t>-1;t--)if(".ie-custom-properties"===a[t].selectorText){r=a[t].cssText;break}if(r)break}return r=r.substring(r.lastIndexOf("{")+1,r.lastIndexOf("}")),r.split(";").forEach(e=>{if(e){const r=e.split(": ")[0],a=e.split(": ")[1];r&&a&&(t["--"+r.trim()]=a.trim())}}),t};var n=(t,e=document.body)=>{let r;if((t=>t.match(/^--.*/i))(t)&&Boolean(document.documentMode)&&document.documentMode>=10){r=a()[t]}else r=window.getComputedStyle(e,null).getPropertyValue(t).replace(/^\s/,"");return r};e.a=(t,e=document.body)=>{const r=n("--"+t,e);return r||t}},106:function(t,e,r){"use strict";r.r(e);var a=r(11),n=r(1),s=r(105),o=r(104);function i(t,e){var r=Object.keys(t);if(Object.getOwnPropertySymbols){var a=Object.getOwnPropertySymbols(t);e&&(a=a.filter((function(e){return Object.getOwnPropertyDescriptor(t,e).enumerable}))),r.push.apply(r,a)}return r}function c(t){for(var e=1;e<arguments.length;e++){var r=null!=arguments[e]?arguments[e]:{};e%2?i(Object(r),!0).forEach((function(e){l(t,e,r[e])})):Object.getOwnPropertyDescriptors?Object.defineProperties(t,Object.getOwnPropertyDescriptors(r)):i(Object(r)).forEach((function(e){Object.defineProperty(t,e,Object.getOwnPropertyDescriptor(r,e))}))}return t}function l(t,e,r){return e in t?Object.defineProperty(t,e,{value:r,enumerable:!0,configurable:!0,writable:!0}):t[e]=r,t}var u={name:"CChartLineSimple",components:{CChartLine:a.CChartLine},props:c(c({},a.CChartLine.props),{},{borderColor:{type:String,default:"rgba(255,255,255,.55)"},backgroundColor:{type:String,default:"transparent"},dataPoints:{type:Array,default:function(){return[10,22,34,46,58,70,46,23,45,78,34,12]}},label:{type:String,default:"Sales"},pointed:Boolean,pointHoverBackgroundColor:String}),computed:{pointHoverColor:function(){return this.pointHoverBackgroundColor?this.pointHoverBackgroundColor:"transparent"!==this.backgroundColor?this.backgroundColor:this.borderColor},defaultDatasets:function(){return[{data:this.dataPoints,borderColor:Object(s.a)(this.borderColor),backgroundColor:Object(s.a)(this.backgroundColor),pointBackgroundColor:Object(s.a)(this.pointHoverColor),pointHoverBackgroundColor:Object(s.a)(this.pointHoverColor),label:this.label}]},pointedOptions:function(){return{scales:{xAxes:[{offset:!0,gridLines:{color:"transparent",zeroLineColor:"transparent"},ticks:{fontSize:2,fontColor:"transparent"}}],yAxes:[{display:!1,ticks:{display:!1,min:Math.min.apply(Math,this.dataPoints)-5,max:Math.max.apply(Math,this.dataPoints)+5}}]},elements:{line:{borderWidth:1},point:{radius:4,hitRadius:10,hoverRadius:4}}}},straightOptions:function(){return{scales:{xAxes:[{display:!1}],yAxes:[{display:!1}]},elements:{line:{borderWidth:2},point:{radius:0,hitRadius:10,hoverRadius:4}}}},defaultOptions:function(){var t=this.pointed?this.pointedOptions:this.straightOptions;return Object.assign({},t,{maintainAspectRatio:!1,legend:{display:!1}})},computedDatasets:function(){return Object(o.a)(this.defaultDatasets,this.datasets||{})},computedOptions:function(){return Object(o.a)(this.defaultOptions,this.options||{})}}},d=r(3);function p(t,e){var r=Object.keys(t);if(Object.getOwnPropertySymbols){var a=Object.getOwnPropertySymbols(t);e&&(a=a.filter((function(e){return Object.getOwnPropertyDescriptor(t,e).enumerable}))),r.push.apply(r,a)}return r}function h(t){for(var e=1;e<arguments.length;e++){var r=null!=arguments[e]?arguments[e]:{};e%2?p(Object(r),!0).forEach((function(e){f(t,e,r[e])})):Object.getOwnPropertyDescriptors?Object.defineProperties(t,Object.getOwnPropertyDescriptors(r)):p(Object(r)).forEach((function(e){Object.defineProperty(t,e,Object.getOwnPropertyDescriptor(r,e))}))}return t}function f(t,e,r){return e in t?Object.defineProperty(t,e,{value:r,enumerable:!0,configurable:!0,writable:!0}):t[e]=r,t}var b={name:"Home",components:{CChartLineSimple:Object(d.a)(u,(function(){var t=this.$createElement;return(this._self._c||t)("CChartLine",{attrs:{datasets:this.computedDatasets,labels:this.labels,options:this.computedOptions}})}),[],!1,null,null,null).exports,CChartLine:a.CChartLine},data:function(){return{fields:[{key:"id"},{key:"type"},{key:"description"},{key:"amount"},{key:"status"},{key:"created_at"}],options:{maintainAspectRatio:!1,interaction:{mode:"index",intersect:!1},stacked:!1,scales:{y:{type:"linear",display:!0,position:"left"},y1:{type:"linear",display:!0,position:"right",grid:{drawOnChartArea:!1}}}}}},created:function(){var t=this;this.fetchTransactions().then((function(){t.processTransactionChartData()})),this.groupReferrals("y"),this.fetchReferrals().then((function(){t.processReferralChartData()}))},destroyed:function(){},computed:h(h(h({},Object(n.c)("TransactionsIndex",{transactions:"data",transactionsChartData:"chartData",transactionsQuery:"query",transactionsTotal:"total",transactionsLoading:"loading"})),Object(n.c)("ReferralsIndex",{referrals:"data",referralsChartData:"chartData",activeReferrals:"activeReferrals"})),{},{chartLabels:function(){return this.transactionsChartData.map((function(t){return t.date}))},chartData1:function(){return this.transactionsChartData.map((function(t){return t.amount}))},chartData2:function(){return this.transactionsChartData.map((function(t){return t.count}))},totalAmount:function(){return _.sum(this.transactions.map((function(t){return t.amount})))},totalAmountToday:function(){var t=this;return _.sum(this.transactions.filter((function(e){return t.isToday(new Date(e.created_at))})).map((function(t){return t.amount})))},totalAmountThisMonth:function(){var t=this;return _.sum(this.transactions.filter((function(e){return t.isThisMonth(new Date(e.created_at))})).map((function(t){return t.amount})))},todayTransactions:function(){var t=this;return this.transactions.filter((function(e){return t.isToday(new Date(e.created_at))}))},totalTransactions:function(){return this.transactions.length},totalTransactionsToday:function(){return this.todayTransactions.length},totalTransactionsThisMonth:function(){var t=this;return this.transactions.filter((function(e){return t.isThisMonth(new Date(e.created_at))})).length},recentTransactions:function(){return _.isEmpty(this.todayTransactions)?this.transactions.sort((function(t,e){return e.id-t.id})):this.todayTransactions.sort((function(t,e){return e.id-t.id}))},totalActiveReferrals:function(){return this.activeReferrals.length+""},referralChartLabels:function(){return this.referralsChartData.map((function(t){return t.date}))},referralChartData:function(){return this.referralsChartData.map((function(t){return t.count}))},datasets:function(){return[{data:this.chartData1,backgroundColor:"#008",borderColor:"#00c",label:"Amount",fill:!1},{data:this.chartData2,backgroundColor:"#080",borderColor:"#0c0",label:"Count",fill:!1}]}}),methods:h(h(h(h({},Object(n.b)("TransactionsIndex",{fetchTransactions:"fetchData",processTransactionChartData:"processChartData",setTransactionsQuery:"setQuery",resetState:"resetState"})),Object(n.b)("ReferralsIndex",{fetchReferrals:"fetchData",setReferralsQuery:"setQuery",processReferralChartData:"processChartData"})),Object(n.b)("loader",["reset"])),{},{groupTransactions:function(t){var e=Object.assign({},this.transactionsQuery,{group:t});this.setTransactionsQuery(e),this.processTransactionChartData()},groupReferrals:function(t){var e=Object.assign({},this.referralsQuery,{group:t,yearLimit:!1});this.setReferralsQuery(e),this.processReferralChartData()},reloadChart:function(){var t=this;this.fetchTransactions().then((function(){t.processTransactionChartData()}))},isToday:function(t){var e=new Date;return t.getDate()==e.getDate()&&t.getMonth()==e.getMonth()&&t.getFullYear()==e.getFullYear()},isThisMonth:function(t){var e=new Date;return t.getMonth()==e.getMonth()&&t.getFullYear()==e.getFullYear()},rowClicked:function(t,e,r){this.$emit("row-clicked",t,e,r)},getBadge:function(t){return"Active"===t?"success":"Inactive"===t?"secondary":"Pending"===t?"warning":"Banned"===t?"danger":"primary"}})},C=Object(d.a)(b,(function(){var t=this,e=t.$createElement,r=t._self._c||e;return r("div",[r("CCard",[r("CCardBody",[r("CRow",[r("CCol",{staticClass:"col-sm-5"},[r("h4",{staticClass:"card-title mb-0"},[t._v("Transactions Summary")]),t._v(" "),r("div",{staticClass:"small text-muted"},[t._v(t._s("d"===t.transactionsQuery.group?"Transactions done today":"m"===t.transactionsQuery.group?"Transactions done this month":"Transactions done this year")+"\n                    ")])]),t._v(" "),r("CCol",{staticClass:"d-none d-md-block col-sm-7"},[r("button",{staticClass:"btn float-right btn-primary",attrs:{disabled:""},on:{click:t.reloadChart}},[r("CIcon",{attrs:{name:"cil-reload"}})],1),t._v(" "),r("CButtonGroup",{staticClass:"float-right mr-3 btn-group"},[r("CButton",{staticClass:"btn mx-0 btn-outline-secondary",class:["d"===t.transactionsQuery.group?"active":""],on:{click:function(e){return t.groupTransactions("d")}}},[t._v("\n                            Day\n                        ")]),t._v(" "),r("button",{staticClass:"btn mx-0 btn-outline-secondary",class:["m"===t.transactionsQuery.group?"active":""],on:{click:function(e){return t.groupTransactions("m")}}},[t._v("\n                            Month\n                        ")]),t._v(" "),r("button",{staticClass:"btn mx-0 btn-outline-secondary",class:["y"===t.transactionsQuery.group?"active":""],on:{click:function(e){return t.groupTransactions("y")}}},[t._v("\n                            Year\n                        ")])],1)],1)],1),t._v(" "),r("CChartLine",{staticStyle:{height:"300px","margin-top":"40px"},attrs:{datasets:t.datasets,labels:t.chartLabels,options:t.options}})],1),t._v(" "),r("CCardFooter",[r("CRow",{staticClass:"text-center"},[r("CCol",{attrs:{sclass:"mb-sm-2 mb-0 col-sm-12 col-md"}},[r("div",{staticClass:"text-muted"},[t._v("Total Transactions")]),t._v(" "),r("strong",[t._v(t._s(t.totalTransactions))]),t._v(" "),r("span",{attrs:{title:"Today's Transactions"}},[t._v("("+t._s(t.totalTransactionsToday)+")")]),t._v(" "),r("CProgress",{staticClass:"progress-xs mt-2",attrs:{precision:1,value:t.totalTransactionsToday,color:"success"}})],1),t._v(" "),r("CCol",{attrs:{sclass:"mb-sm-2 mb-0 col-sm-12 col-md"}},[r("div",{staticClass:"text-muted"},[t._v("Total Amounts")]),t._v(" "),r("strong",[t._v(t._s(t.totalAmount))]),t._v(" "),r("span",{attrs:{title:"Today's Transactions"}},[t._v("("+t._s(t.totalAmountToday)+")")]),t._v(" "),r("CProgress",{staticClass:"progress-xs mt-2",attrs:{precision:1,value:t.totalAmountToday,color:"success"}})],1)],1)],1)],1),t._v(" "),r("CRow",[r("CCol",{attrs:{lg:"3",sm:"6"}},[r("CWidgetDropdown",{attrs:{header:t.totalActiveReferrals,color:"primary",text:"Invites"},scopedSlots:t._u([{key:"footer",fn:function(){return[r("CChartLineSimple",{staticClass:"mt-3 mx-3",staticStyle:{height:"70px"},attrs:{"data-points":t.referralChartData,labels:t.referralChartLabels,label:"Invites","point-hover-background-color":"primary",pointed:""}})]},proxy:!0}])})],1)],1),t._v(" "),r("CCard",[r("CCardHeader",[t._t("header",[r("CIcon",{attrs:{name:"cil-grid"}}),t._v("\n                Recent Transactions\n            ")])],2),t._v(" "),r("CCardBody",[r("CDataTable",{attrs:{fields:t.fields,items:t.recentTransactions,"items-per-page":8,pagination:{doubleArrows:!1,align:"center"},"clickable-rows":"",hover:"","items-per-page-select":"",sorter:"",striped:"","table-filter":""},on:{"row-clicked":t.rowClicked},scopedSlots:t._u([{key:"status",fn:function(e){return[r("td",[r("CBadge",{attrs:{color:t.getBadge(e.item.status)}},[t._v("\n                            "+t._s(e.item.status)+"\n                        ")])],1)]}}])})],1)],1)],1)}),[],!1,null,"bc8711a6",null);e.default=C.exports}}]);