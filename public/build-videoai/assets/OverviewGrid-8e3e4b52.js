import{i as p,o as t,c as a,F as g,r as u,b as s,n as o,a as m,G as r,t as c}from"./app-f0fa1d4d.js";const f={class:"card-body flex items-center gap-4"},x={class:"flex flex-1 flex-col gap-1"},y={class:"text-sm tracking-wide text-slate-500"},_={class:"flex flex-wrap items-baseline justify-between gap-2"},k={__name:"OverviewGrid",props:{items:{type:Array,default:()=>[]},grid:{type:[Number,String],default:4}},setup(l){const n=l,i=()=>`lg:grid-cols-${n.grid}`;return(v,b)=>{const d=p("Icon");return l.items.length?(t(),a("section",{key:0,class:o([i(),"grid grid-cols-1 gap-4 mb-4"])},[(t(!0),a(g,null,u(l.items,e=>(t(),a("div",{class:"card",key:e},[s("div",f,[e.icon??e.iconClass?(t(),a("div",{key:0,class:o(["rounded-full p-3 text-xl bg-opacity-20",[e.style??"bg-primary-500 text-primary-600"]])},[m(d,{icon:e.icon??e.iconClass},null,8,["icon"])],2)):r("",!0),s("div",x,[s("p",y,c(e.title),1),s("div",_,[s("h4",null,c(e.value),1)])])])]))),128))],2)):r("",!0)}}};export{k as default};
