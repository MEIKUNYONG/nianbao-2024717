(global["webpackJsonp"]=global["webpackJsonp"]||[]).push([["pages/login/login"],{"541a":function(t,e,n){"use strict";var a=n("a00f"),i=n.n(a);i.a},"747a":function(t,e,n){"use strict";(function(t){Object.defineProperty(e,"__esModule",{value:!0}),e.default=void 0;var n=getApp(),a={data:function(){return{config:[],miniName:"",isCheck:!1,showPace:!1,paceIndex:0,agreement:"",agreement_title:""}},onLoad:function(t){this.$fn.setTitle(),this.config=n.globalData.config},methods:{checkchange:function(t){this.isCheck=!this.isCheck},toPace:function(t){var e=t.currentTarget.dataset.id;console.log(e),0==e?(this.agreement_title=this.config.agreement_title,this.agreement=this.config.agreement_content,this.showPace=!0):1==e&&(this.agreement_title=this.config.privacy_title,this.agreement=this.config.privacy_content,this.showPace=!0)},closePace:function(){this.showPace=!1},phone:function(){t.showToast({title:"请阅读并同意用户协议和隐私政策",icon:"none"})},getPhone:function(e){e.detail.code&&this.$fn.getPhone({code:e.detail.code},(function(e){console.log(e.data.data),t.setStorage({key:"userInfo",data:e.data.data,success:function(){n.globalData.isLogin=!0,n.globalData.userInfo=e.data.data,n.globalData.mobile=e.data.data.mobile,t.reLaunch({url:"/pages/index/index"})}})}))}}};e.default=a}).call(this,n("543d")["default"])},"97e1":function(t,e,n){"use strict";(function(t,e){var a=n("4ea4");n("982d");a(n("66fd"));var i=a(n("aa93"));t.__webpack_require_UNI_MP_PLUGIN__=n,e(i.default)}).call(this,n("bc2e")["default"],n("543d")["createPage"])},"9e80":function(t,e,n){"use strict";n.d(e,"b",(function(){return a})),n.d(e,"c",(function(){return i})),n.d(e,"a",(function(){}));var a=function(){var t=this.$createElement;this._self._c},i=[]},a00f:function(t,e,n){},aa93:function(t,e,n){"use strict";n.r(e);var a=n("9e80"),i=n("da94");for(var o in i)["default"].indexOf(o)<0&&function(t){n.d(e,t,(function(){return i[t]}))}(o);n("541a");var c=n("f0c5"),s=Object(c["a"])(i["default"],a["b"],a["c"],!1,null,null,null,!1,a["a"],void 0);e["default"]=s.exports},da94:function(t,e,n){"use strict";n.r(e);var a=n("747a"),i=n.n(a);for(var o in a)["default"].indexOf(o)<0&&function(t){n.d(e,t,(function(){return a[t]}))}(o);e["default"]=i.a}},[["97e1","common/runtime","common/vendor"]]]);