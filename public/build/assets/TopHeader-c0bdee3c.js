import{B as K,m as Q,A as W,h as X,c as a,a as u,j as Z,u as t,b as l,F as p,r as x,q as F,o,n as m,t as r,e as i,k as L,i as U,p as d,d as tt,v as et}from"./app-13978987.js";import{h as st}from"./moment-a9aaa855.js";import{_ as H}from"./SpinnerBtn-cb152833.js";import{u as lt,_ as ot}from"./Modal-17c50704.js";import{u as at}from"./publishStore-a6d0eb83.js";const nt={class:"mx-2 my-6 flex max-h-[600px] flex-col gap-2"},it={class:"styled-scrollbar space-y-2 overflow-y-auto"},rt=["onClick"],dt={class:"flex items-center justify-between"},ct={class:"flex items-center justify-between gap-3"},ut=["src","alt"],bt=["src"],pt={class:"text-nowrap"},gt={key:0,class:"truncate text-sm text-gray-500"},mt={class:"flex items-center justify-between gap-3"},ht={key:0,class:"h-8",src:"/assets/images/ajax_loading.svg",alt:"ajax_loading"},ft={key:1,class:"bx bx-circle text-2xl"},_t={key:2,class:"bx bxs-check-circle text-2xl text-green-600"},xt={key:3,class:"bx bxs-x-circle text-2xl text-red-600"},yt={key:0},kt={key:0,class:"mt-3 text-start !text-sm text-red-600"},vt={class:"border p-2 font-semibold"},Pt={class:"border p-2"},wt={key:1,class:"mt-3 text-start !text-sm text-red-600"},Ct=l("strong",null,"Error:",-1),Bt=["disabled"],Nt={key:1,src:"/assets/svg/loader.svg",class:"h-8",alt:""},jt={class:"mb-2"},St=l("label",null,"Date and Time",-1),At=["min"],$t=l("p",{class:"mt-3 !text-[12px] text-xs text-blue-500"},[l("strong",null,"Note:"),L(" Post will be schedule according to your current timezone ")],-1),Tt=["disabled"],Vt={key:1,src:"/assets/svg/loader.svg",class:"h-8",alt:""},Dt={class:"flex gap-1"},Et=["disabled"],It=["disabled"],Mt=["disabled"],qt={class:"flex flex-col items-center justify-between gap-2 pb-2 pt-5 lg:flex-row"},zt={class:"card max-w-max space-x-2 p-1"},Ft=["onClick","disabled"],Ut=["src","alt"],Ht={class:"flex items-center justify-end gap-3"},Kt={__name:"TopHeader",setup(Lt){const e=at(),{getPlatformTabState:O,platforms:R,publishAccounts:Y,form:y}=K(e),h=lt(),k=[{step:1,title:"Instant Publish"},{step:2,title:"Schedule for later"}],c=Q(1),G=W(()=>k.find(f=>f.step==c.value)||k[0]),J=()=>{if(e.publishAccounts.length==0){e.setTab("connect"),F.info("Please connect your social accounts first");return}if((e.findPublishAccountByName("tiktok")??null)&&!e.tiktokOptions.privacy_level){F.danger("Please choose privacy setting for tiktok");return}h.open("publishContent")};return(f,n)=>{const b=X("Icon");return o(),a(p,null,[u(ot,{state:t(h).states.publishContent,"close-btn":!t(e).loading.publish,"header-state":!0,"header-title":G.value.title,"backdrop-close":!1},{default:Z(()=>[l("div",nt,[l("div",it,[(o(!0),a(p,null,x(t(Y),s=>{var _,v,P,w,C,B,N,j,S,A,$,T,V,D,E,I,M,q;return o(),a("div",{key:s},[l("button",{onClick:g=>t(e).togglePublishAccount(s),class:"w-full"},[l("div",{class:m(["rounded-lg border border-dashed p-3",{"border-red-600 bg-red-50 dark:bg-red-200":((_=t(e).findPostPlatformByName(s.platform))==null?void 0:_.status)==="failed","border-green-600 bg-green-50 dark:bg-primary-200":((v=t(e).findPostPlatformByName(s.platform))==null?void 0:v.status)==="published","cursor-not-allowed bg-primary-50 dark:bg-green-100 dark:text-dark-700":t(e).findPostPlatformByName(s.platform)}])},[l("div",dt,[l("span",ct,[l("img",{class:"h-6",src:`/assets/svg/${s.platform}.svg?v=1`,alt:s.platform},null,8,ut),l("img",{src:s.picture??"/assets/images/no-image.jpg",onError:n[0]||(n[0]=g=>g.target.src="/assets/images/no-image.jpg"),class:"h-10 w-10 rounded-full"},null,40,bt),l("span",pt,r(s.name),1),s.username?(o(),a("span",gt,"("+r(s.username)+")",1)):i("",!0)]),l("div",mt,[((P=t(e).publishingPlatform)==null?void 0:P.id)==s.id?(o(),a("img",ht)):i("",!0),((w=t(e).findPostPlatformByName(s.platform))==null?void 0:w.status)==="draft"?(o(),a("i",ft)):i("",!0),((C=t(e).findPostPlatformByName(s.platform))==null?void 0:C.status)==="published"?(o(),a("i",_t)):i("",!0),((B=t(e).findPostPlatformByName(s.platform))==null?void 0:B.status)==="failed"?(o(),a("i",xt)):i("",!0)])]),((N=t(e).findPostPlatformByName(s.platform))==null?void 0:N.status)==="failed"?(o(),a("div",yt,[typeof((S=(j=t(e).findPostPlatformByName(s.platform))==null?void 0:j.data)==null?void 0:S.message)=="object"?(o(),a("table",kt,[($=(A=t(e).findPostPlatformByName(s.platform))==null?void 0:A.data)!=null&&$.message?(o(!0),a(p,{key:0},x((V=(T=t(e).findPostPlatformByName(s.platform))==null?void 0:T.data)==null?void 0:V.message,(g,z)=>(o(),a("tr",{key:z},[l("td",vt,r(z),1),l("td",Pt,r(g),1)]))),128)):i("",!0)])):((D=t(e).findPostPlatformByName(s.platform))==null?void 0:D.status)==="failed"?(o(),a("p",wt,[Ct,L(" "+r(((I=(E=t(e).findPostPlatformByName(s.platform))==null?void 0:E.data)==null?void 0:I.message)||"Unknown Error")+" ("+r((q=(M=t(e).findPostPlatformByName(s.platform))==null?void 0:M.data)==null?void 0:q.failed_at)+") ",1)])):i("",!0)])):i("",!0)],2)],8,rt)])}),128))]),c.value==1?(o(),a("button",{key:0,disabled:t(e).loading.publish||t(e).publishAccounts.length==0,onClick:n[1]||(n[1]=s=>t(e).publishPost("publish")),class:m(["flex items-center justify-center gap-2 rounded-md p-3 text-left text-lg dark:bg-gray-700 dark:hover:bg-slate-900",t(e).loading.publish||t(e).publishAccounts.length==0?"cursor-not-allowed bg-purple-200 hover:bg-purple-300":"bg-purple-600 text-white"])},[t(e).loading.publish?i("",!0):(o(),U(b,{key:0,icon:"mi:send",class:"text-lg"})),l("span",null,r(t(e).loading.publish?t(d)("Publishing"):t(d)("Start Publish")),1),t(e).loading.publish?(o(),a("img",Nt)):i("",!0)],10,Bt)):i("",!0),c.value==2?(o(),a(p,{key:1},[l("div",jt,[St,tt(l("input",{type:"datetime-local",min:t(st)().format("Y-M-DThh:mm"),"onUpdate:modelValue":n[2]||(n[2]=s=>t(y).scheduled_at=s),class:"input",required:""},null,8,At),[[et,t(y).scheduled_at]]),$t]),l("button",{disabled:t(e).loading.publish||t(e).publishAccounts.length==0,onClick:n[3]||(n[3]=s=>t(e).schedulePost()),class:m(["flex items-center justify-center gap-2 rounded-md p-3 text-left text-lg dark:bg-gray-700 dark:hover:bg-slate-900",t(e).loading.publish||t(e).publishAccounts.length==0?"cursor-not-allowed bg-purple-200 hover:bg-purple-300":"bg-purple-600 text-white"])},[t(e).loading.publish?i("",!0):(o(),U(b,{key:0,icon:"fe:clock",class:"text-lg"})),l("span",null,r(t(e).loading.publish?t(d)("Scheduling"):t(d)("Schedule")),1),t(e).loading.publish?(o(),a("img",Vt)):i("",!0)],10,Tt)],64)):i("",!0),l("div",Dt,[c.value==1?(o(),a("button",{key:0,onClick:n[4]||(n[4]=s=>c.value=2),disabled:t(e).loading.publish||t(e).publishAccounts.length==0,class:"btn btn-soft-primary w-full py-4 font-bold"},[u(b,{icon:"fe:clock",class:"text-lg"}),l("span",null,r(t(d)("Schedule for later")),1)],8,Et)):(o(),a("button",{key:1,onClick:n[5]||(n[5]=s=>c.value=1),disabled:t(e).loading.publish||t(e).publishAccounts.length==0,class:"btn btn-soft-primary w-full py-4 font-bold"},[u(b,{icon:"bx:rocket",class:"text-lg"}),l("span",null,r(t(d)("Instant Publish")),1)],8,It)),l("button",{onClick:n[6]||(n[6]=s=>t(h).close()),disabled:t(e).loading.publish,class:"btn btn-soft-secondary w-full py-4"},[u(b,{icon:"bx:x-circle",class:"text-lg"}),l("span",null,r(t(d)("Close")),1)],8,Mt)])])]),_:1},8,["state","close-btn","header-title"]),l("div",qt,[l("div",zt,[(o(!0),a(p,null,x(t(R),s=>(o(),a("button",{key:s,class:m(["btn py-3 hover:bg-primary-800 sm:px-8",{"btn-soft-primary":t(O)(s)}]),onClick:_=>t(e).setPlatformTab(s),disabled:s=="wordpress"},[l("img",{class:"w-4",src:`/assets/svg/${s}.svg?v=1`,alt:s},null,8,Ut)],10,Ft))),128))]),l("div",Ht,[u(H,{processing:t(e).loading.draft,onClick:n[7]||(n[7]=s=>t(e).draftPost()),"btn-text":t(d)("Save Changes"),icon:"bx bx-save",class:"btn-success"},null,8,["processing","btn-text"]),u(H,{processing:t(e).loading.publish,onClick:J,"btn-text":t(d)("Publish"),icon:"bx bx-paper-plane",class:"btn-primary"},null,8,["processing","btn-text"])])])],64)}}};export{Kt as default};
