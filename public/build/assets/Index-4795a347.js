import{T as f,c as i,a as d,b as e,d as x,I as k,t as a,u as s,k as v,w as b,e as D,g as N,o as r,p as t,a8 as S}from"./app-13978987.js";import{_ as U}from"./AdminLayout-bd13ff9d.js";import{_ as V}from"./PageHeader-8c638686.js";import{_ as y}from"./SpinnerBtn-899a94c2.js";import"./dropdown-45d66330.js";const j={class:"flex-grow p-4 sm:p-6"},C={class:"space-y-6"},K={class:"alert alert-info",role:"alert"},B=e("i",{width:"1rem",height:"1rem","data-feather":"alert-circle"},null,-1),I={class:"card"},T={class:"card-body"},$={class:"flex justify-between"},z={class:"card-title"},A={key:0,class:"flex items-center justify-between p-4 my-3 border rounded-lg"},E={class:"mb-2"},Y={for:""},F=["value"],M={class:"mb-2"},O={key:0,class:"alert alert-info",role:"alert"},P=e("i",{width:"1rem",height:"1rem","data-feather":"alert-circle"},null,-1),W=N({layout:U}),Q=Object.assign(W,{__name:"Index",props:["version","purchaseKey","updateData"],setup(o){var m;const c=o,u=f({purchase_key:c.purchaseKey}),p=f({version:(m=c.updateData)==null?void 0:m.version}),g=()=>{u.post(route("admin.update.store"),{onError:n=>{console.log(n)}})},w=()=>{var l;if(p.processing)return;let n=(l=c.updateData)==null?void 0:l.version;S.init(route("admin.update.update",n),{method:"put",options:{confirm_text:t("Are you sure you want to update to version v."+n+"?"),message:t("Warning: You will not be able to revert this back once updated!"),accept_btn_text:t("Yes, Update Now"),reject_btn_text:t("No, Skip This Update")}})};return(n,l)=>{var h,_;return r(),i("main",j,[d(V),e("div",C,[x(e("div",K,[B,e("p",null,[e("b",null,a(s(t)("Note"))+":",1),v(" "+a((h=o.updateData)==null?void 0:h.message),1)])],512),[[k,(_=o.updateData)==null?void 0:_.message]]),e("div",I,[e("div",T,[e("div",$,[e("h4",z,a(s(t)("Site Update")),1),e("p",null,a(s(t)("Current Version"))+" "+a(o.version),1)]),o.updateData?(r(),i("div",A,[e("p",null,a(s(t)("Update Available")),1),e("h6",null,a(o.updateData.version),1),e("div",null,[e("form",{onSubmit:b(w,["prevent"])},[d(y,{processing:s(p).processing,"btn-text":s(t)("Update Now")},null,8,["processing","btn-text"])],32)])])):(r(),i("form",{key:1,onSubmit:b(g,["prevent"])},[e("div",E,[e("label",Y,a(s(t)("Purchase Key")),1),e("input",{type:"text",class:"input",value:o.purchaseKey,disabled:""},null,8,F)]),e("div",M,[d(y,{processing:s(u).processing,"btn-text":s(t)("Check New Update")},null,8,["processing","btn-text"])])],32))])]),o.updateData?D("",!0):(r(),i("div",O,[P,e("p",null,[e("b",null,a(s(t)("Note"))+":",1),v(" "+a(s(t)("If you have customized the script from codebase do not use this option. you will lose your customization.")),1)])]))])])}}});export{Q as default};
