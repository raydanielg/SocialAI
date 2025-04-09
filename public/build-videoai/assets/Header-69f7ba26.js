import{s as U,Q as G,C as L,D as q,m as Q,i as z,K as J,o as c,c as h,b as t,a as i,t as o,u as s,k as l,f as w,j as M,l as u,F as C,r as N,G as v,n as X,d as W,v as Y}from"./app-f0fa1d4d.js";import{u as Z,a as B,_ as tt}from"./Modal-202f4758.js";class et{constructor(n){if(this.dropdown=null,this.dropdownBtns=null,typeof n=="string"&&(this.dropdown=document.querySelector(n)),n instanceof HTMLElement&&(this.dropdown=n),!n)throw new Error("No target element found");this.dropdown&&(this.dropdownBtns=this.dropdown.querySelectorAll("[data-theme-mode]")),this.dropdownBtns&&this.dropdownBtns.length&&(this.updateActiveClass(),[...this.dropdownBtns].forEach(f=>{f.addEventListener("click",()=>this.toggle(f))}))}toggle(n){const f=n.dataset.themeMode;f==="light"&&localStorage.setItem("theme","light"),f==="dark"&&localStorage.setItem("theme","dark"),f==="system"&&localStorage.removeItem("theme"),window.location.reload()}updateActiveClass(){[...this.dropdownBtns].forEach(n=>{n.classList.contains("active")&&n.classList.remove("active"),!localStorage.theme&&n.dataset.themeMode==="system"&&n.classList.add("active"),localStorage.theme===n.dataset.themeMode&&n.classList.add("active")})}}const st={init(){const m=document.querySelector("#theme-switcher-dropdown");m&&new et(m)}},ot={class:"header"},at={class:"container-fluid flex items-center justify-between"},nt={class:"flex items-center space-x-6"},it=t("span",{class:"flex space-x-4"},[t("svg",{stroke:"currentColor",fill:"none","stroke-width":"0",viewBox:"0 0 24 24",height:"22",width:"22",xmlns:"http://www.w3.org/2000/svg"},[t("path",{"stroke-linecap":"round","stroke-linejoin":"round","stroke-width":"2",d:"M4 6h16M4 12h8m-8 6h16"})])],-1),rt=[it],lt={class:"sm:hidden"},dt={class:"ml-2 text-sm text-slate-400"},ct={class:"flex items-center"},ht={class:"dropdown-list"},ut={class:"dropdown","data-strategy":"absolute",id:"theme-switcher-dropdown"},pt={class:"dropdown-toggle px-3 text-slate-500 hover:text-slate-700 focus:text-primary-500 dark:text-slate-400 dark:hover:text-slate-300 dark:focus:text-primary-500",type:"button"},mt={class:"dropdown-content mt-3 w-36"},ft={class:"dropdown-list"},_t={class:"dropdown-list-item"},wt={type:"button",class:"dropdown-btn","data-theme-mode":"light"},gt={class:"dropdown-list-item"},vt={type:"button",class:"dropdown-btn","data-theme-mode":"dark"},xt={class:"dropdown-list-item"},yt={type:"button",class:"dropdown-btn","data-theme-mode":"system"},kt={class:"relative flex items-center justify-center rounded-full text-slate-500 transition-colors duration-150 hover:text-slate-700 focus:text-primary-500 dark:text-slate-400 dark:hover:text-slate-300 dark:focus:text-primary-500"},bt={key:0,class:"absolute -right-1 -top-1.5 flex h-4 w-4 items-center justify-center rounded-full bg-danger-500 text-[11px] text-slate-200"},Ct={class:"w-[17.5rem] divide-y dark:divide-slate-700 sm:w-80"},St={class:"flex items-center justify-between px-4 py-4"},Lt={class:"text-slate-800 dark:text-slate-300"},Mt={class:"h-80 w-full","data-simplebar":""},Nt=["onClick"],Bt=t("div",{class:"flex h-10 w-10 flex-shrink-0 items-center justify-center rounded-full bg-blue-100 text-blue-500"},[t("i",{class:"bx bx-user-voice",width:"20",height:"20"})],-1),Et=["href"],jt={class:"text-sm font-normal"},$t=["title"],At={class:"mt-1 flex items-center gap-1 text-xs text-slate-400"},Dt={key:1,class:"mt-5 text-center"},It={key:0,class:"px-4 py-2"},Tt={class:"group relative flex items-center gap-x-1.5",type:"button"},Vt={class:"avatar avatar-circle avatar-indicator avatar-indicator-online"},qt=["alt"],zt={class:"w-56 divide-y dark:divide-slate-600"},Wt={class:"px-4 py-3"},Ht={class:"text-sm"},Kt={class:"truncate text-sm font-medium"},Pt={class:"dropdown-btn"},Ft={key:0,class:"dropdown-btn"},Ot={href:"/admin/clear-cache"},Rt={class:"py-1"},Ut={method:"POST",action:"#"},Gt={class:"text-center"},Qt={class:"group my-5 flex items-center rounded-lg bg-slate-50 p-1 dark:bg-slate-600"},Jt={key:0,class:"styled-scrollbar max-h-[560px] space-y-2 overflow-y-auto"},Xt={class:"flex items-center gap-2"},Yt={key:1,class:"text-center text-slate-500 dark:text-slate-400"},ee={__name:"Header",props:{panel:{type:String,default:"admin"}},setup(m){const{authUser:n,logout:f,uiAvatar:H}=U(),E=G(),K=E.props.sidebar_menu,j=m,P=(e="#")=>{try{return route(e)}catch{return e}},y=Z(),$=L(),S=()=>{y.open("searchModal"),setTimeout(()=>{var e;(e=$.value)==null||e.focus()},50)},x=L(E.props.userNotifications??[]),A=q(()=>{var e;return((e=x.value)==null?void 0:e.filter(r=>r.seen==0).length)??0}),F=e=>{axios.post(route(j.panel+".notifications.read",e.id)).then(r=>{var a,p;(a=r.data)!=null&&a.redirect_to&&(window.location.href=(p=r.data)==null?void 0:p.redirect_to)})},O=()=>{window.location.href=route(j.panel+".notifications.clear")},k=L(""),D=q(()=>{const e=p=>p.links.flatMap(_=>_.type==="dropdown"&&Array.isArray(_.children)?_.children:_),r=K.flatMap(e);k.value||r.slice(0,100);const a=k.value.toLowerCase().trim().split(/\s+/);return r.filter(p=>{const _=p.text.toLowerCase();return a.every(b=>_.includes(b))})});Q(()=>{st.init(),document.addEventListener("keydown",e=>{e.ctrlKey&&e.key=="k"&&(e.preventDefault(),S())}),document.addEventListener("keydown",e=>{e.key=="Escape"&&(e.preventDefault(),y.close())})});const R=()=>{const e=document.querySelector(".sidebar"),r=document.querySelector(".wrapper");window.innerWidth<1024?(e.classList.toggle("expanded"),document.querySelector(".sidebar-overlay").classList.toggle("active")):(e.classList.toggle("collapsed"),r.classList.toggle("expanded"))};return(e,r)=>{var b,I,T;const a=z("Icon"),p=z("Link"),_=J("lazy");return c(),h(C,null,[t("header",ot,[t("div",at,[t("div",nt,[t("button",{onClick:R},rt),t("div",lt,[t("button",{type:"button",onClick:S,class:"flex items-center justify-center rounded-full text-slate-500 transition-colors duration-150 hover:text-primary-500 focus:text-primary-500 dark:text-slate-400 dark:hover:text-slate-300"},[i(a,{icon:"fe:search"})])]),t("button",{type:"button",onClick:S,class:"group hidden h-10 w-72 items-center overflow-hidden rounded-primary bg-slate-100 px-3 shadow-sm dark:border-transparent dark:bg-slate-700 sm:flex"},[i(a,{icon:"fe:search"}),t("span",dt,[t("code",null,o(s(l)("Ctrl + K")),1),w(" "+o(s(l)("search"))+", ",1),t("code",null,o(s(l)("Esc")),1),w(" "+o(s(l)("to close")),1)])])]),t("div",ct,[Object.keys(((b=e.$page.props)==null?void 0:b.languages)??{}).length>1?(c(),M(B,{key:0,"btn-text":(T=e.$page.props)==null?void 0:T.languages[(I=e.$page.props)==null?void 0:I.locale]},{default:u(()=>[t("ul",ht,[(c(!0),h(C,null,N(e.$page.props.languages,(d,g)=>(c(),h("li",{key:g,class:"dropdown-list-item"},[i(p,{as:"button",href:e.route("set-locale",g),method:"patch",class:"dropdown-btn"},{default:u(()=>[w(o(d),1)]),_:2},1032,["href"])]))),128))])]),_:1},8,["btn-text"])):v("",!0),t("div",ut,[t("button",pt,[i(a,{class:"hidden dark:block",width:"24",height:"24",icon:"fe:moon"},{default:u(()=>[w(o(s(l)("Dark")),1)]),_:1}),i(a,{class:"block dark:hidden",width:"24",height:"24",icon:"fe:sunny-o"},{default:u(()=>[w(o(s(l)("Light")),1)]),_:1})]),t("div",mt,[t("ul",ft,[t("li",_t,[t("button",wt,[i(a,{width:"16",height:"16",icon:"fe:sunny-o"}),t("span",null,o(s(l)("Light")),1)])]),t("li",gt,[t("button",vt,[i(a,{width:"16",height:"16",icon:"fe:moon"}),t("span",null,o(s(l)("Dark")),1)])]),t("li",xt,[t("button",yt,[i(a,{width:"16",height:"16",icon:"tdesign:system-setting"}),t("span",null,o(s(l)("System")),1)])])])])]),i(B,{"btn-type":"slot"},{btnContent:u(()=>[t("button",kt,[i(a,{width:"24",height:"24",icon:"fe:bell"}),A.value?(c(),h("span",bt,o(A.value),1)):v("",!0)])]),default:u(()=>[t("div",Ct,[t("div",St,[t("h6",Lt,o(s(l)("Notifications")),1),x.value.length?(c(),h("button",{key:0,onClick:r[0]||(r[0]=d=>O()),class:"text-xs font-medium text-slate-600 hover:text-primary-500 dark:text-slate-300"},o(s(l)("Clear All")),1)):v("",!0)]),t("div",Mt,[t("ul",null,[x.value.length?(c(!0),h(C,{key:0},N(x.value,(d,g)=>(c(),h("li",{key:g,onClick:V=>F(d),class:X(["flex cursor-pointer gap-4 border-b-2 border-white px-4 py-3 transition-colors duration-150 hover:bg-slate-200/70 dark:border-secondary-600 dark:hover:bg-slate-700",{"bg-slate-100/70 dark:bg-slate-700":!d.seen}])},[Bt,t("a",{href:e.sanitizeHtml(d.url),onClick:r[1]||(r[1]=V=>V.preventDefault())},[t("h6",jt,o(d.title),1),t("p",{class:"text-xs text-slate-400",title:d.comment},o(d.comment_short),9,$t),t("p",At,[i(a,{icon:"fe:clock",width:"1em",height:"1em"}),t("span",null,o(d.created_at_human_date),1)])],8,Et)],10,Nt))),128)):(c(),h("li",Dt,o(s(l)("No notifications")),1))])]),x.value.length>5?(c(),h("div",It,[m.panel==="admin"?(c(),M(p,{key:0,href:e.route("admin.notification.index"),class:"btn btn-primary-plain btn-sm w-full"},{default:u(()=>[t("span",null,o(s(l)("View More")),1),i(a,{icon:"arrow-right",width:"1rem",height:"1rem"})]),_:1},8,["href"])):v("",!0)])):v("",!0)])]),_:1}),i(B,{"btn-type":"slot"},{btnContent:u(()=>[t("button",Tt,[t("div",Vt,[W(t("img",{class:"avatar-img group-focus-within:ring group-focus-within:ring-primary-500",alt:s(n).name},null,8,qt),[[_,s(H)(s(n).name,s(n).avatar)]])])])]),default:u(()=>[t("div",zt,[t("div",Wt,[t("p",Ht,[w(o(s(l)("Welcome"))+" ",1),t("strong",null,o(s(n).name),1),w("! ")]),t("p",Kt,"("+o(s(n).email)+")",1)]),t("div",Pt,[i(a,{icon:"fe:user"}),i(p,{href:`/${m.panel}/profile`},{default:u(()=>[w(o(s(l)("Edit Profile")),1)]),_:1},8,["href"])]),m.panel==="admin"?(c(),h("div",Ft,[i(a,{icon:"fe:lock"}),t("a",Ot,o(s(l)("Clear Cache")),1)])):v("",!0),t("div",Rt,[t("form",Ut,[t("button",{type:"button",onClick:r[2]||(r[2]=d=>s(f)()),class:"dropdown-btn"},[i(a,{icon:"fe:logout"}),t("span",null,o(s(l)("Logout")),1)])])])])]),_:1})])])]),i(tt,{state:s(y).states.searchModal,closeBtn:!1},{default:u(()=>[t("h4",Gt,o(s(l)("Menu Search")),1),t("div",Qt,[W(t("input",{ref_key:"searchInput",ref:$,type:"text","onUpdate:modelValue":r[3]||(r[3]=d=>k.value=d),class:"input w-full",placeholder:"Search"},null,512),[[Y,k.value]])]),D.value.length>0?(c(),h("div",Jt,[(c(!0),h(C,null,N(D.value,(d,g)=>(c(),M(p,{key:g,onClick:s(y).close,href:P(d.href)??"#",class:"flex items-center justify-between gap-2 rounded-primary bg-slate-50 px-4 py-3 text-sm shadow-sm hover:bg-slate-100 dark:bg-slate-700 dark:hover:bg-slate-600"},{default:u(()=>[t("div",Xt,[i(a,{icon:d.icon??"bx:subdirectory-right"},null,8,["icon"]),t("span",null,o(d.text),1)]),i(a,{icon:"bx:chevron-right"})]),_:2},1032,["onClick","href"]))),128))])):(c(),h("div",Yt,o(s(l)("No result found")),1))]),_:1},8,["state"])],64)}}};export{ee as default};
