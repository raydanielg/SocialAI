import{B as I,m as P,l as j,C as A,h as x,c as p,a as v,b as t,j as R,F as h,r as B,u as e,i as r,e as i,k as $,t as g,n as u,d as F,v as N,g as z,o as n,D as l,_ as c}from"./app-13978987.js";import{_ as H}from"./AdminLayout-bd13ff9d.js";import{u as M}from"./designStore-f93d210d.js";import"./dropdown-45d66330.js";import"./fabric-1ff51d4a.js";const U={class:"mt-4 flex h-20 flex-col items-start justify-between gap-2 px-6 lg:flex-row"},G=t("i",{class:"bx bx-chevron-left"},null,-1),q=t("span",null,"Back",-1),J={class:"card max-w-max space-x-2 rounded-md p-2"},K=["onClick"],Q={class:"flex justify-end gap-3"},W=t("i",{class:"bx bx-memory-card text-2xl"},null,-1),X=t("span",null,"Save as draft ",-1),Y=[W,X],Z=t("i",{class:"bx bx-paper-plane text-2xl"},null,-1),ee=t("span",null,"Publish",-1),te=[Z,ee],se={class:"mt-2 flex min-h-[calc(100vh-12rem)]"},oe={class:"w-full overflow-y-auto px-3 lg:px-6"},ae={class:"mt-2 grid grid-cols-1 gap-y-8 lg:grid-cols-12 lg:gap-x-8"},ne={class:"card styled-scrollbar col-span-3 overflow-y-auto overflow-x-hidden rounded-2xl p-5 lg:h-[calc(100vh-13rem)]"},re={class:"col-span-9 ml-24"},ie={class:"flex items-center gap-1"},le=t("label",{class:"label"},"Opacity",-1),ce={class:"label card w-10 rounded-md px-2 py-1 text-center"},de=t("i",{class:"bx bxs-arrow-from-bottom text-xl"},null,-1),_e=[de],pe=t("i",{class:"bx bxs-arrow-from-top text-xl"},null,-1),ue=[pe],me=t("i",{class:"bx bxs-trash-alt"},null,-1),be=[me],xe=z({layout:H}),Te=Object.assign(xe,{__name:"Create",props:["shapes","categories"],setup(m){const s=M(),{getTabState:d,getSelectedObjectState:_}=I(s),b=P(null);j(()=>s.initializeCanvas(b.value));const y=l(()=>c(()=>import("./SettingsTab-2da0554b.js"),["assets/SettingsTab-2da0554b.js","assets/app-13978987.js","assets/app-e969cddd.css","assets/designStore-f93d210d.js","assets/fabric-1ff51d4a.js"])),f=l(()=>c(()=>import("./TextTab-2e8b2d17.js"),["assets/TextTab-2e8b2d17.js","assets/designStore-f93d210d.js","assets/app-13978987.js","assets/app-e969cddd.css","assets/fabric-1ff51d4a.js"])),k=l(()=>c(()=>import("./ShapeTab-ebf909f2.js"),["assets/ShapeTab-ebf909f2.js","assets/designStore-f93d210d.js","assets/app-13978987.js","assets/app-e969cddd.css","assets/fabric-1ff51d4a.js"])),T=l(()=>c(()=>import("./ImageTab-275f21dd.js"),["assets/ImageTab-275f21dd.js","assets/designStore-f93d210d.js","assets/app-13978987.js","assets/app-e969cddd.css","assets/fabric-1ff51d4a.js"])),E=l(()=>c(()=>import("./PlaceholderTab-4bf47a5a.js"),["assets/PlaceholderTab-4bf47a5a.js","assets/designStore-f93d210d.js","assets/app-13978987.js","assets/app-e969cddd.css","assets/fabric-1ff51d4a.js"])),O=l(()=>c(()=>import("./SelectedTextTab-6050e119.js"),["assets/SelectedTextTab-6050e119.js","assets/app-13978987.js","assets/app-e969cddd.css","assets/designStore-f93d210d.js","assets/fabric-1ff51d4a.js","assets/multiselect-4ccf8c7b.js"])),w=l(()=>c(()=>import("./SelectedShapeTab-6a6c1898.js"),["assets/SelectedShapeTab-6a6c1898.js","assets/app-13978987.js","assets/app-e969cddd.css","assets/designStore-f93d210d.js","assets/fabric-1ff51d4a.js"])),C=l(()=>c(()=>import("./SelectedGroupTab-a055b1d8.js"),["assets/SelectedGroupTab-a055b1d8.js","assets/app-13978987.js","assets/app-e969cddd.css","assets/designStore-f93d210d.js","assets/fabric-1ff51d4a.js"])),L=l(()=>c(()=>import("./SelectedImageTab-cb1dcbbd.js"),["assets/SelectedImageTab-cb1dcbbd.js","assets/app-13978987.js","assets/app-e969cddd.css","assets/designStore-f93d210d.js","assets/fabric-1ff51d4a.js"]));return A(()=>s.$reset()),(V,a)=>{const D=x("Head"),S=x("Link");return n(),p(h,null,[v(D,{title:"Brand Logo Create"}),t("div",U,[v(S,{href:V.route("admin.brand-logos.index"),class:"btn btn-dark btn-md"},{default:R(()=>[G,q]),_:1},8,["href"]),t("div",J,[(n(!0),p(h,null,B(e(s).tabLists,o=>(n(),p("button",{key:o.label,class:u(["btn px-2 py-1 transition-colors hover:bg-primary-800/60 hover:text-white",{"btn-soft-primary":e(d)(o.label)}]),onClick:ve=>e(s).setTab(o.label)},[t("i",{class:u(["bx text-xl",`${o.icon}`])},null,2)],10,K))),128))]),t("div",Q,[t("button",{onClick:a[0]||(a[0]=o=>e(s).submitLogo("inactive")),class:"btn bg-secondary-100 py-1 text-secondary-950 hover:bg-secondary-300"},Y),t("button",{onClick:a[1]||(a[1]=o=>e(s).submitLogo("active")),class:"btn btn-soft-primary py-1"},te)])]),t("div",se,[t("div",oe,[t("div",ae,[t("div",ne,[e(d)("settings")?(n(),r(e(y),{key:0,categories:m.categories},null,8,["categories"])):i("",!0),e(d)("text")?(n(),r(e(f),{key:1})):i("",!0),e(d)("shapes")?(n(),r(e(k),{key:2,shapes:m.shapes},null,8,["shapes"])):i("",!0),e(d)("image")?(n(),r(e(T),{key:3})):i("",!0),e(d)("placeholder")?(n(),r(e(E),{key:4})):i("",!0),e(_)("i-text")?(n(),r(e(O),{key:5})):i("",!0),e(_)("shape")?(n(),r(e(w),{key:6})):i("",!0),e(_)("group")?(n(),r(e(C),{key:7})):i("",!0),e(_)("image")?(n(),r(e(L),{key:8})):i("",!0)]),t("div",re,[$(g(e(s).canvasLoading?"loading...":"")+" ",1),t("div",{class:u(["card mb-5 mt-3 flex max-w-max items-center gap-1 rounded-md p-2",e(s).selectedObject?"visible opacity-100":"invisible opacity-0"])},[t("div",ie,[le,F(t("input",{step:"5",onInput:a[2]||(a[2]=(...o)=>e(s).changeObjectOpacity&&e(s).changeObjectOpacity(...o)),"onUpdate:modelValue":a[3]||(a[3]=o=>e(s).objectOpacity=o),class:"cursor-pointer accent-primary-600",type:"range",min:"0",max:"100"},null,544),[[N,e(s).objectOpacity]]),t("span",ce,g(e(s).objectOpacity),1)]),t("button",{onClick:a[4]||(a[4]=(...o)=>e(s).bringToFront&&e(s).bringToFront(...o)),class:"btn px-2 py-1 hover:bg-primary-800/60 hover:text-white"},_e),t("button",{onClick:a[5]||(a[5]=(...o)=>e(s).sendToBack&&e(s).sendToBack(...o)),class:"btn px-2 py-1 hover:bg-primary-800/60 hover:text-white"},ue),t("button",{onClick:a[6]||(a[6]=(...o)=>e(s).remove&&e(s).remove(...o)),class:"btn p-2 hover:bg-primary-800/60 hover:text-white"},be)],2),t("canvas",{ref_key:"canvasEl",ref:b,class:"rounded border border-secondary-200 shadow dark:border-secondary-800"},null,512)])])])])],64)}}});export{Te as default};
