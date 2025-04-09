import{h as w}from"./moment-a9aaa855.js";import"./swiper-core-2c82c4aa.js";import{S as g,a as j}from"./swiper-vue-f3fe2caf.js";import{N as k}from"./navigation-cc68fbee.js";import{S as $}from"./scrollbar-713b1e47.js";import{m as S,h as y,o as _,c as h,b as s,t,a as r,j as n,F as b,r as x,i as C,k as d,u as l,n as L,s as V,e as P,g as M}from"./app-13978987.js";import{_ as N}from"./DefaultLayout-52cb34e4.js";import"./create-element-if-not-defined-f3dc53ca.js";import"./classes-to-selector-84993e85.js";import"./MobileMenu-4272ee25.js";import"./FeatureSection-b1ebef06.js";import"./SeoMeta-91cb18dc.js";import"./ToastrContainer-82d03ccc.js";const T={class:"tp-project__area grey-bg pt-50 pb-110 fix"},z={class:"container"},D={class:"row"},H={class:"col-xl-6"},B={class:"tp-project__section-box wow tpfadeLeft","data-wow-duration":".9s","data-wow-delay":".3s"},E={class:"tp-section-title"},I={class:"container-fluid gx-0"},O={class:"row gx-0"},Y={class:"col-xl-12"},R={class:"tp-project__slider-section"},F={class:"tp-project__slider-wrapper"},A={class:"tp-project__item d-flex align-items-center"},U={class:"tp-project__thumb"},W=["src"],q={class:"tp-project__content"},G={class:"tp-project__title-box"},J={class:"tp-project__title-sm"},K={class:"tp-project__meta d-flex align-items-center"},Q={class:"tp-project__author-info"},X={class:"tp-project__budget"},Z={class:"tp-project__link"},ss=s("svg",{width:"14",height:"14",viewBox:"0 0 14 14",fill:"none",xmlns:"http://www.w3.org/2000/svg"},[s("path",{d:"M1.00098 7H13.001",stroke:"currentColor","stroke-width":"1.5","stroke-linecap":"round","stroke-linejoin":"round"}),s("path",{d:"M7.00098 1L13.001 7L7.00098 13",stroke:"currentColor","stroke-width":"1.5","stroke-linecap":"round","stroke-linejoin":"round"})],-1),ts=s("div",{class:"tp-scrollbar"},null,-1),es={__name:"RecentProjects",props:{projects:{type:Array,default:[]}},setup(o){const a=S(!1),e=()=>{a.value=!0},m=()=>{a.value=!1};return(i,p)=>{const u=y("Link");return _(),h("div",T,[s("div",z,[s("div",D,[s("div",H,[s("div",B,[s("h3",E,t(i.trans("Check Some Of Our Recent Work.")),1)])])])]),s("div",I,[s("div",O,[s("div",Y,[s("div",R,[r(l(j),{slidesPerView:3,"space-between":30,loop:!0,modules:[l(k),l($)],breakpoints:{1200:{slidesPerView:3},992:{slidesPerView:1},768:{slidesPerView:1},576:{slidesPerView:1},0:{slidesPerView:1}},scrollbar:{el:".tp-scrollbar",clickable:!0},onSliderMove:e,onTransitionEnd:m,class:L(`swiper-container tp-project__slider-active ${a.value?"dragged":""}`)},{default:n(()=>[(_(!0),h(b,null,x(o.projects,(c,f)=>(_(),C(l(g),{key:f,class:"swiper-slide wow tpfadeUp","data-wow-duration":".9s","data-wow-delay":".5s"},{default:n(()=>{var v;return[s("div",F,[s("div",A,[s("div",U,[r(u,{href:i.route("projects.show",c.slug)},{default:n(()=>[s("img",{src:c.preview,alt:"image-here"},null,8,W)]),_:2},1032,["href"])]),s("div",q,[s("div",G,[s("h4",J,[r(u,{href:i.route("projects.show",c.slug)},{default:n(()=>[d(t(c.title),1)]),_:2},1032,["href"])]),s("p",null,t(c.description),1)]),s("div",K,[s("div",Q,[s("span",null,t(i.trans("Client Name")),1),s("h4",null,t(c.client),1)]),s("div",X,[s("span",null,t(i.trans("Service")),1),s("h4",null,t((v=c.category)==null?void 0:v.title),1)]),s("div",Z,[r(u,{href:i.route("projects.show",c.slug)},{default:n(()=>[ss]),_:2},1032,["href"])])])])])])]}),_:2},1024))),128))]),_:1},8,["modules","scrollbar","class"]),ts])])])])])}}},os={class:"breadcrumb__area breadcrumb-height-3 p-relative blue-bg-2 fix"},is=s("div",{class:"breadcrumb__shape-1"},[s("img",{src:"/assets/img/breadcrumb/breadcrumb-shape-1.png",alt:""})],-1),ls=s("div",{class:"breadcrumb__shape-2"},[s("img",{src:"/assets/img/breadcrumb/breadcrumb-shape-2.png",alt:""})],-1),as={class:"container"},cs={class:"breadcrumb__content-wrap"},ns={class:"row justify-content-center"},rs={class:"col-xl-12"},ds={class:"breadcrumb__content z-index-3 mb-60"},_s={class:"breadcrumb__text wow tpfadeIn","data-wow-duration":".9s","data-wow-delay":".6s"},hs={class:"breadcrumb__title"},ps={class:"row g-0 z-index-3"},us={class:"col-xl-3 col-lg-3 col-md-6 pd-border-right mb-40"},ms={class:"breadcrumb__client-info space-left-1"},vs={class:"col-xl-3 col-lg-3 col-md-6 pd-border-right mb-40"},bs={class:"breadcrumb__client-info space-left-2"},fs={class:"col-xl-3 col-lg-3 col-md-6 pd-border-right mb-40"},ws={class:"breadcrumb__client-info space-left-3"},gs=s("br",null,null,-1),js={key:0,class:"col-xl-3 col-lg-3 col-md-6 pd-border-right mb-40"},ks={class:"breadcrumb__client-info space-left-4"},$s={class:"breadcrumb__live-btn"},Ss=["href"],ys=s("i",{class:"fal fa-arrow-up"},null,-1),xs={class:"pd-thumb-area"},Cs={class:"container"},Ls={class:"row"},Vs={class:"col-12"},Ps={class:"pd-thumb"},Ms=["src"],Ns={class:"pd-details-area pt-100 pb-100"},Ts={class:"container"},zs={class:"row g-0"},Ds={class:"col-xl-2 col-lg-2 social-box-pin"},Hs={class:"pd-details-social-box text-lg-center p-relative text-start"},Bs={class:"pd-details-social-title"},Es=s("br",null,null,-1),Is={class:"pd-details-social"},Os=["href"],Ys=s("i",{class:"fab fa-facebook-f"},null,-1),Rs=[Ys],Fs=["href"],As=s("i",{class:"fab fa-twitter"},null,-1),Us=[As],Ws=["href"],qs=s("i",{class:"fab fa-linkedin"},null,-1),Gs=[qs],Js=["href"],Ks=s("i",{class:"fab fa-instagram"},null,-1),Qs=[Ks],Xs={class:"col-xl-10 col-lg-10"},Zs={class:"pd-details-wrapper"},st={class:"pd-details-info"},tt={class:"pd-details-title"},et={class:"pd-details-overview"},ot={class:"pd-details-title"},it=["innerHTML"],lt={class:"pd-details-solution"},at={class:"row"},ct={class:"col-md-3"},nt={class:"pd-solution-title-box"},rt={class:"pd-details-title"},dt={class:"col-md-9"},_t={class:"pd-solution-paragraph"},ht=M({layout:N}),xt=Object.assign(ht,{__name:"Show",props:["project","recentItems"],setup(o){const{socialShare:a}=V();return(e,m)=>{var i,p;return _(),h(b,null,[s("div",os,[is,ls,s("div",as,[s("div",cs,[s("div",ns,[s("div",rs,[s("div",ds,[s("div",_s,[s("span",null,t((i=o.project.category)==null?void 0:i.title),1)]),s("h3",hs,t(o.project.title),1)])])]),s("div",ps,[s("div",us,[s("div",ms,[s("span",null,t(e.trans("CLIENT")),1),s("p",null,t(o.project.client),1)])]),s("div",vs,[s("div",bs,[s("span",null,t(e.trans("Services")),1),s("p",null,t((p=o.project.category)==null?void 0:p.title),1)])]),s("div",fs,[s("div",ws,[s("span",null,t(e.trans("Project Date")),1),s("p",null,[d(t(l(w)(o.project.release_at).format("MMM DD, YYYY"))+" ",1),gs])])]),o.project.preview_link?(_(),h("div",js,[s("div",ks,[s("span",null,t(e.trans("Live Preview")),1),s("div",$s,[s("a",{class:"tp-btn-inner-border",href:e.sanitizeHtml(o.project.preview_link)},[d(t(e.trans("See live"))+" ",1),ys],8,Ss)])])])):P("",!0)])])])]),s("div",xs,[s("div",Cs,[s("div",Ls,[s("div",Vs,[s("div",Ps,[s("img",{src:e.sanitizeHtml(o.project.banner_preview),alt:""},null,8,Ms)])])])])]),s("div",Ns,[s("div",Ts,[s("div",zs,[s("div",Ds,[s("div",Hs,[s("div",Bs,[s("span",null,[d(t(e.trans("Share This"))+" ",1),Es,d(t(e.trans("Story")),1)])]),s("div",Is,[s("a",{href:l(a)("facebook")},Rs,8,Os),s("a",{href:l(a)("twitter")},Us,8,Fs),s("a",{href:l(a)("linkedin")},Gs,8,Ws),s("a",{href:l(a)("instagram")},Qs,8,Js)])])]),s("div",Xs,[s("div",Zs,[s("div",st,[s("h4",tt,t(e.trans("Description")),1),s("p",null,t(o.project.description),1)]),s("div",et,[s("h4",ot,t(e.trans("Overview")),1),s("p",{innerHTML:e.sanitizeHtml(o.project.overview)},null,8,it)]),s("div",lt,[s("div",at,[s("div",ct,[s("div",nt,[s("h4",rt,t(e.trans("Solution & Result")),1)])]),s("div",dt,[s("div",_t,[s("p",null,t(o.project.output),1)])])])])])])])])]),r(es,{projects:o.recentItems},null,8,["projects"])],64)}}});export{xt as default};
