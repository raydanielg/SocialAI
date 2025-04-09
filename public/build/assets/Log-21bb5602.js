import{_ as x}from"./UserLayout-6a50516d.js";import{h as v,o as t,c as n,b as s,F as c,r as m,n as d,i as g,j as k,e as b,k as f,t as e,s as C,A as $,a as h,g as w,u as p}from"./app-13978987.js";import{_ as N}from"./PageHeader-8c638686.js";import{h as T}from"./moment-a9aaa855.js";import{_ as j}from"./NoDataFound-bc81d7fa.js";import"./dropdown-45d66330.js";const M={key:0},P={class:"pagination-one d-flex align-items-center justify-content-center justify-content-sm-start style-none"},B={key:0,class:"ms-2"},D=s("span",{class:"d-flex align-items-center"},[f(e("Next")+" "),s("img",{src:"/assets/images/icon/icon_42.svg",alt:"",class:"ms-2"})],-1),V=[D],H={key:0,class:"ms-2"},L=s("span",{class:"d-flex align-items-center"},[f(e("Next")+" "),s("img",{src:"/assets/images/icon/icon_50.svg",alt:"",class:"ms-2"})],-1),z=[L],A=["innerHTML"],F={__name:"WebPaginate",props:{links:Array},setup(l){return(i,r)=>{const u=v("Link");return l.links.length>3?(t(),n("div",M,[s("div",P,[(t(!0),n(c,null,m(l.links,(a,_)=>(t(),n(c,{key:_},[a.label.includes("Next")&&a.url===null?(t(),n("li",B,V)):(t(),n("li",{key:1,class:d({active:a.active})},[(t(),g(u,{key:`link-${_}`,href:a.url??"#"},{default:k(()=>[a.label.includes("Next")?(t(),n("li",H,z)):a.label.includes("Previous")?(t(),n(c,{key:1},[],64)):(t(),n("span",{key:2,innerHTML:i.sanitizeHtml(a.label)},null,8,A))]),_:2},1032,["href"]))],2))],64))),128))])])):b("",!0)}}},O={class:"container flex-grow p-4 sm:p-6"},S={class:"mb-5 grid grid-cols-1 gap-8 sm:grid-cols-2 xl:grid-cols-3"},E={class:"flex items-center gap-3 p-5"},G={class:"flex flex-1 flex-col"},W={class:"text-sm tracking-wide text-slate-500"},Y={class:"card card-body"},q={key:0,class:"table-responsive"},I={class:"job-alert-table table"},J={scope:"col"},K={scope:"col"},Q={scope:"col"},R={scope:"col"},U={scope:"col"},X={scope:"col"},Z={class:"border-0"},ss={key:0,class:"badge badge-primary"},ts={key:1,class:"badge badge-warning"},es=w({layout:x}),rs=Object.assign(es,{__name:"Log",props:["creditLogs","credit_fee","gateways","totalCosts","totalCredits","buttons"],setup(l){const{formatCurrency:i}=C(),r=l,u=$(()=>[{title:"Total Purchase",value:r.creditLogs.total,icon:"bx bx-box",classes:"bg-primary-500 text-primary-500"},{title:"Total Costs",value:i(r.totalCosts),icon:"bx bx-dollar-circle",classes:"text-success-500 bg-success-500"},{title:"Total Credits",value:r.totalCredits,icon:"bx bxs-receipt",classes:"text-warning-500 bg-warning-500"}]);return(a,_)=>(t(),n("main",O,[h(N,{title:"Credit Logs",buttons:l.buttons},null,8,["buttons"]),s("section",S,[(t(!0),n(c,null,m(u.value,(o,y)=>(t(),n("div",{key:y,class:"card rounded-2xl"},[s("div",E,[s("div",{class:d(["flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-xl bg-opacity-10",o.classes])},[s("i",{class:d(["text-2xl",o.icon])},null,2)],2),s("div",G,[s("p",W,e(o.title),1),s("h5",null,e(o.value),1)])])]))),128))]),s("div",Y,[l.creditLogs.total?(t(),n("div",q,[s("table",I,[s("thead",null,[s("tr",null,[s("th",J,e(a.trans("Transaction No")),1),s("th",K,e(a.trans("Credits")),1),s("th",Q,e(a.trans("Price")),1),s("th",R,e(a.trans("Status")),1),s("th",U,e(a.trans("Gateway")),1),s("th",X,e(a.trans("Date")),1)])]),s("tbody",Z,[(t(!0),n(c,null,m(l.creditLogs.data,o=>(t(),n("tr",{class:d({active:o.status==1,pending:o.status!=1}),key:o.id},[s("td",null,e(o.invoice_no),1),s("td",null,e(o.credits),1),s("td",null,e(p(i)(o.price)),1),s("td",null,[o.status==1?(t(),n("span",ss,e(a.trans("Complete")),1)):o.status==0?(t(),n("span",ts,e(a.trans("Pending")),1)):b("",!0)]),s("td",null,e(o.gateway.name),1),s("td",null,[s("p",null,e(p(T)(o.updated_at).format("DD MMM Y")),1)])],2))),128))])])])):(t(),g(j,{key:1})),h(F,{links:l.creditLogs.links},null,8,["links"])])]))}});export{rs as default};
