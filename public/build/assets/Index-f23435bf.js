import{l as V,s as O,T as M,h as k,c as r,b as e,a as c,u as t,F as b,r as v,w as C,t as s,d as w,v as S,f as B,g as H,o as u,p as n,j as I,O as x}from"./app-13978987.js";import{_ as U}from"./AdminLayout-bd13ff9d.js";import{_ as z}from"./PageHeader-8c638686.js";import{d as f}from"./drawer-fe4c5e1a.js";import{_ as D}from"./SpinnerBtn-899a94c2.js";import{s as A}from"./vue-draggable-plus-77a23e2f.js";import"./dropdown-45d66330.js";const F={class:"container flex-grow p-4 sm:p-6"},G={class:"grid gap-6 lg:grid-cols-2"},R={class:"mb-1 font-semibold capitalize"},J={class:"table-responsive whitespace-nowrap rounded-primary"},K={class:"table"},P={class:"!text-right"},Q=["onEnd"],W={class:"cursor-move"},X={class:"cursor-move"},Y={class:"flex justify-end"},Z={class:"dropdown","data-placement":"bottom-start"},ee={class:"dropdown-toggle"},te={class:"dropdown-content w-40"},se={class:"dropdown-list"},ne={class:"dropdown-list-item"},oe={class:"dropdown-list-item"},ae=["onClick"],ie={class:"dropdown-list-item"},de=["onClick"],le={id:"addNewMenuDrawer",class:"drawer drawer-right"},re={class:"drawer-header"},ce=e("button",{type:"button",class:"btn btn-plain-secondary dark:text-slate-300 dark:hover:bg-slate-700 dark:focus:bg-slate-700","data-dismiss":"drawer"},[e("i",{"data-feather":"x",width:"1.5rem",height:"1.5rem"})],-1),ue={class:"drawer-body"},he={class:"label label-required mb-1"},pe={class:"label label-required mb-1"},_e={value:""},me=["value"],be={class:"drawer-footer"},we={class:"flex justify-between gap-2"},fe={type:"button",class:"btn btn-secondary w-full","data-dismiss":"drawer"},ge={id:"editMenuDrawer",class:"drawer drawer-right"},ve={class:"drawer-header"},xe=e("button",{type:"button",class:"btn btn-plain-secondary dark:text-slate-300 dark:hover:bg-slate-700 dark:focus:bg-slate-700","data-dismiss":"drawer"},[e("i",{"data-feather":"x",width:"1.5rem",height:"1.5rem"})],-1),ye={class:"drawer-body space-y-3"},Me={class:"label label-required"},ke={class:"drawer-footer"},Ce={class:"flex justify-between gap-2"},Se={type:"button",class:"btn btn-secondary w-full","data-dismiss":"drawer"},De=H({layout:U}),Ve=Object.assign(De,{__name:"Index",props:["menus","segments","buttons"],setup(m){V(()=>{f.init()});const E=m,{deleteRow:N,trim:y}=O(),h=M({heading:null,location:""}),d=M({heading:null,location:""}),$=(i,o)=>{d.heading=i.heading,d.location=o,d.id=i.id,f.of("#editMenuDrawer").show()};function j(){x.post(route("admin.sidebar-menu.store"),h,{onSuccess:()=>{h.reset(),f.of("#addNewMenuDrawer").hide()}})}function q(i,o=null,l=null){o&&i&&(d.heading=i.heading,d.location=l,d.id=i.id),x.patch(route("admin.sidebar-menu.update",d.id),d,{onSuccess:()=>{setTimeout(()=>window.location.reload(),1e3),f.of("#editMenuDrawer").hide()}})}const L=i=>{setTimeout(()=>{const o=E.menus[i];if(o){const l=o.map((g,a)=>({id:g.id,order:a+1}));x.patch(route("admin.sidebar-menu.arrange",i),{items:l},{onSuccess:()=>{setTimeout(()=>window.location.reload(),1e3)}})}},500)};return(i,o)=>{const l=k("Icon"),g=k("Link");return u(),r(b,null,[e("main",F,[c(z,{title:t(n)("Menu"),buttons:m.buttons},null,8,["title","buttons"]),e("div",G,[(u(!0),r(b,null,v(m.menus,(a,_)=>(u(),r("div",{key:_},[e("p",R,s(t(y)(_)),1),e("div",J,[e("table",K,[e("thead",null,[e("tr",null,[e("th",null,s(t(n)("SN")),1),e("th",null,s(t(n)("Group Heading")),1),e("th",P,s(t(n)("Action")),1)])]),w((u(),r("tbody",{onEnd:p=>L(_)},[(u(!0),r(b,null,v(a,p=>(u(),r("tr",{key:p.id},[e("td",W,s(p.order),1),e("td",X,s(p.heading),1),e("td",null,[e("div",Y,[e("div",Z,[e("div",ee,[c(l,{class:"w-30 text-lg",icon:"bi:three-dots-vertical"})]),e("div",te,[e("ul",se,[e("li",ne,[c(g,{href:i.route("admin.sidebar-menu.show",[p.id,_]),class:"dropdown-link"},{default:I(()=>[c(l,{class:"h-6 text-slate-400",icon:"fe:list-bullet"}),e("span",null,s(t(n)("Manage")),1)]),_:2},1032,["href"])]),e("li",oe,[e("button",{onClick:T=>$(p,_),class:"dropdown-link"},[c(l,{class:"h-6 text-slate-400",icon:"material-symbols:edit-outline"}),e("span",null,s(t(n)("Edit")),1)],8,ae)]),e("li",ie,[e("button",{class:"dropdown-link",onClick:T=>t(N)(i.route("admin.sidebar-menu.destroy",[p.id,_]))},[c(l,{class:"h-6 text-slate-400",icon:"fe:trash"}),e("span",null,s(t(n)("Delete")),1)],8,de)])])])])])])]))),128))],40,Q)),[[t(A),a]])])])]))),128))])]),e("div",le,[e("form",{onSubmit:o[2]||(o[2]=C(a=>j(),["prevent"]))},[e("div",re,[e("h5",null,s(t(n)("Add New Menu")),1),ce]),e("div",ue,[e("div",null,[e("label",he,s(t(n)("Group Headings")),1),w(e("input",{type:"text","onUpdate:modelValue":o[0]||(o[0]=a=>t(h).heading=a),name:"heading",class:"input",required:"",placeholder:"Example"},null,512),[[S,t(h).heading]])]),e("div",null,[e("label",pe,s(t(n)("Select Menu Location")),1),w(e("select",{class:"input capitalize",name:"location","onUpdate:modelValue":o[1]||(o[1]=a=>t(h).location=a)},[e("option",_e,s(t(n)("Select Menu Location")),1),(u(!0),r(b,null,v(Object.keys(m.menus),a=>(u(),r("option",{value:a,key:a},s(t(y)(a)),9,me))),128))],512),[[B,t(h).location]])])]),e("div",be,[e("div",we,[e("button",fe,[e("span",null,s(t(n)("Close")),1)]),c(D,{classes:"btn btn-primary w-full",processing:t(h).processing,"btn-text":t(n)("Create")},null,8,["processing","btn-text"])])])],32)]),e("div",ge,[e("form",{onSubmit:C(q,["prevent"])},[e("div",ve,[e("h5",null,s(t(n)("Edit Menu")),1),xe]),e("div",ye,[e("div",null,[e("label",Me,s(t(n)("Menu Name")),1),w(e("input",{"onUpdate:modelValue":o[3]||(o[3]=a=>t(d).heading=a),type:"text",name:"heading",class:"input",required:"",placeholder:"Heading"},null,512),[[S,t(d).heading]])])]),e("div",ke,[e("div",Ce,[e("button",Se,[e("span",null,s(t(n)("Close")),1)]),c(D,{classes:"btn btn-primary w-full",processing:t(d).processing,"btn-text":t(n)("Save Changes")},null,8,["processing","btn-text"])])])],32)])],64)}}});export{Ve as default};
