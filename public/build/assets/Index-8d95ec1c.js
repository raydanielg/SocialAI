import{h as b}from"./moment-a9aaa855.js";import{_ as v}from"./AdminLayout-bd13ff9d.js";import{_ as x}from"./PageHeader-8c638686.js";import{s as g,p as s,h as m,c as l,a as n,b as t,t as e,u as o,F as k,r as w,i as C,g as P,o as c,n as y,j as A}from"./app-13978987.js";import $ from"./OverviewGrid-21ea6fc2.js";import{_ as B}from"./NoDataFound-bc81d7fa.js";import"./dropdown-45d66330.js";const D={class:"container flex-grow p-4 sm:p-6"},I={class:"space-y-6"},E={class:"card"},L={class:"table-responsive whitespace-nowrap rounded-primary"},M={class:"table"},j={class:"col-3"},z={class:"col-1"},F={class:"col-2"},N={class:"col-2"},S={class:"col-2"},T={class:"text-right"},V={key:0},O={class:"text-left"},R={class:"text-left"},Y={class:"text-left"},q={class:"dropdown","data-placement":"bottom-start"},G={class:"dropdown-toggle"},H={class:"dropdown-content w-40"},J={class:"dropdown-list"},K={class:"dropdown-list-item"},Q={class:"dropdown-list-item"},U=["onClick"],W=P({layout:v}),it=Object.assign(W,{__name:"Index",props:["prompts","totalPrompts","activePrompts","inActivePrompts","buttons","segments"],setup(i){const{deleteRow:p,textExcerpt:h}=g(),d=i,u=[{value:d.totalPrompts,title:s("Total Prompts"),iconClass:"bx:bar-chart"},{value:d.activePrompts,title:s("Active Prompts"),iconClass:"bx:check-circle"},{value:d.inActivePrompts,title:s("Inactive Prompts"),iconClass:"bx:x-circle"}];return(_,X)=>{const r=m("Icon"),f=m("Link");return c(),l("main",D,[n(x,{title:"Prompts",buttons:i.buttons},null,8,["buttons"]),t("div",I,[n($,{items:u,grid:"3"}),t("div",E,[t("div",L,[t("table",M,[t("thead",null,[t("tr",null,[t("th",j,e(o(s)("Title")),1),t("th",z,e(o(s)("Prompt")),1),t("th",F,e(o(s)("Status")),1),t("th",N,e(o(s)("Created At")),1),t("th",S,[t("p",T,e(o(s)("Action")),1)])])]),i.prompts.total?(c(),l("tbody",V,[(c(!0),l(k,null,w(i.prompts.data,a=>(c(),l("tr",{key:a.id},[t("td",O,e(a.title),1),t("td",R,e(o(h)(a.prompt,70)),1),t("td",Y,[t("span",{class:y(["badge",a.status=="active"?"badge-success":"badge-danger"])},e(a.status=="active"?o(s)("Active"):o(s)("Draft")),3)]),t("td",null,e(o(b)(a.created_at).format("D-MMM-Y")),1),t("td",null,[t("div",q,[t("div",G,[n(r,{class:"text-2xl",icon:"bx:dots-horizontal-rounded"})]),t("div",H,[t("ul",J,[t("li",K,[n(f,{href:_.route("admin.prompts.edit",a.id),class:"dropdown-link"},{default:A(()=>[n(r,{icon:"fe:edit"}),t("span",null,e(o(s)("Edit")),1)]),_:2},1032,["href"])]),t("li",Q,[t("button",{onClick:Z=>o(p)(_.route("admin.prompts.destroy",a.id)),class:"dropdown-link"},[n(r,{icon:"fe:trash"}),t("span",null,e(o(s)("Delete")),1)],8,U)])])])])])]))),128))])):(c(),C(B,{key:1,"for-table":!0}))])])])])])}}});export{it as default};
