import{h as p,o as t,c as a,F as u,r as g,b as s,n as r,a as m,e as n,t as o}from"./app-13978987.js";const f={class:"card-body flex items-center gap-4"},x={class:"flex flex-1 flex-col gap-1"},y={class:"text-sm tracking-wide text-slate-500"},_={class:"flex flex-wrap items-baseline justify-between gap-2"},k={__name:"OverviewGrid",props:{items:{type:Array,default:()=>[]},grid:{type:[Number,String],default:4}},setup(l){const c=l,i=()=>`lg:grid-cols-${c.grid}`;return(v,h)=>{const d=p("Icon");return l.items.length?(t(),a("section",{key:0,class:r([i(),"mb-4 grid grid-cols-1 gap-4"])},[(t(!0),a(u,null,g(l.items,e=>(t(),a("div",{class:"card",key:e},[s("div",f,[e.icon??e.iconClass?(t(),a("div",{key:0,class:r(["rounded-full p-3 text-xl",[e.style??"bg-primary-500/20 text-primary-600"]])},[m(d,{icon:e.icon??e.iconClass},null,8,["icon"])],2)):n("",!0),s("div",x,[s("p",y,o(e.title),1),s("div",_,[s("h4",null,o(e.value),1)])])])]))),128))],2)):n("",!0)}}};export{k as default};
