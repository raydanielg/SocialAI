import{s as w,l as v,T as y,h as L,c as d,b as e,a as r,t as a,F as m,r as _,w as C,d as h,v as x,u as o,f as N,g as k,o as i,j,z as S,q as $}from"./app-13978987.js";import{_ as D}from"./SpinnerBtn-cb152833.js";import{_ as M}from"./AdminLayout-bd13ff9d.js";import{_ as V}from"./PageHeader-8c638686.js";import{d as p}from"./drawer-fe4c5e1a.js";import"./dropdown-45d66330.js";const B={class:"container flex-grow p-4 sm:p-6"},I={class:"space-y-6"},q={class:"table-responsive whitespace-nowrap rounded-primary"},A={class:"table"},E={class:"col-2"},F={class:"col-2"},T={class:"col-8"},U={class:"text-right"},z={class:"text-left"},K={class:"text-left"},O={class:"flex justify-end gap-3"},R=["onClick"],G={id:"addNewLanguageDrawer",class:"drawer drawer-right"},H={class:"drawer-header"},J={type:"button",class:"btn btn-plain-secondary dark:text-slate-300 dark:hover:bg-slate-700 dark:focus:bg-slate-700","data-dismiss":"drawer"},P={class:"drawer-body"},Q={class:"mb-2"},W={class:"mb-2"},X=["value"],Y={class:"drawer-footer"},Z={class:"flex justify-between gap-2"},ee={type:"button",class:"btn btn-secondary w-full","data-dismiss":"drawer"},se=k({layout:M}),ie=Object.assign(se,{__name:"Index",props:["languageList","countries"],setup(g){const{deleteRow:b}=w();v(()=>{p.init()});const n=y({name:"",language_code:""}),f=()=>{n.post(route("admin.language.store"),{onSuccess:()=>{n.reset(),$.success(trans("Language has been added successfully")),p.of("#addNewLanguageDrawer").hide()}})};return(s,l)=>{const u=L("Icon");return i(),d(m,null,[e("main",B,[r(V),e("div",I,[e("div",q,[e("table",A,[e("thead",null,[e("tr",null,[e("th",E,a(s.trans("Language Name")),1),e("th",F,a(s.trans("Language Key")),1),e("th",T,[e("div",U,a(s.trans("Action")),1)])])]),e("tbody",null,[(i(!0),d(m,null,_(g.languageList,(t,c)=>(i(),d("tr",{key:c},[e("td",z,a(t),1),e("td",K,a(c),1),e("td",O,[r(o(S),{href:s.route("admin.language.show",c),class:"btn btn-primary"},{default:j(()=>[r(u,{class:"h-6",icon:"material-symbols:edit-outline"})]),_:2},1032,["href"]),e("a",{href:"javascript:void(0)",class:"delete-confirm btn btn-danger",onClick:te=>o(b)(s.route("admin.language.show",c))},[r(u,{class:"h-6",icon:"material-symbols:delete-outline"})],8,R)])]))),128))])])])])]),e("div",G,[e("form",{onSubmit:l[2]||(l[2]=C(t=>f(),["prevent"]))},[e("div",H,[e("h5",null,a(s.trans("Add New Language")),1),e("button",J,[r(u,{class:"text-xl",icon:"mdi:close"})])]),e("div",P,[e("div",Q,[e("label",null,a(s.trans("Language Name")),1),h(e("input",{"onUpdate:modelValue":l[0]||(l[0]=t=>o(n).name=t),type:"text",name:"name",class:"input",required:"",placeholder:"English"},null,512),[[x,o(n).name]])]),e("div",W,[e("label",null,a(s.trans("Select Language")),1),h(e("select",{"onUpdate:modelValue":l[1]||(l[1]=t=>o(n).language_code=t),class:"select",name:"language_code"},[(i(!0),d(m,null,_(g.countries,t=>(i(),d("option",{key:t,value:t.code},a(t.name),9,X))),128))],512),[[N,o(n).language_code]])])]),e("div",Y,[e("div",Z,[e("button",ee,[e("span",null,a(s.trans("Close")),1)]),r(D,{classes:"btn btn-primary w-full",processing:o(n).processing,"btn-text":s.trans("Create")},null,8,["processing","btn-text"])])])],32)])],64)}}});export{ie as default};
