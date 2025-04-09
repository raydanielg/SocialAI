import{B as E,A as b,s as G,m as _,c as l,b as e,a as y,k as L,t as a,F as f,r as A,u as r,a4 as R,j as Y,E as W,g as H,O as V,o as i,d as g,v as S,n as J,I as F,e as C,w as K,q as U}from"./app-13978987.js";import{u as Q,_ as X}from"./Modal-17c50704.js";import{_ as Z}from"./UserLayout-6a50516d.js";import{_ as ee}from"./PageHeader-8c638686.js";import{q as j}from"./vue3-apexcharts-33b91319.js";import{h as I}from"./moment-a9aaa855.js";import"./dropdown-45d66330.js";const te={class:"container flex-grow p-4 sm:p-6"},se={class:"space-y-2"},ae={class:"grid grid-cols-1 gap-6 lg:grid-cols-6"},oe={class:"card card-body col-span-1 lg:col-span-4"},ne={class:"chart-filter-area mb-4 mt-5 flex justify-between"},le={class:"flex items-center gap-2"},ie=e("i",{class:"bx bx-credit-card text-2xl"},null,-1),re=["selected","value"],de={id:"chart"},ce={class:"card card-body col-span-1 lg:col-span-2"},ue=e("span",{class:"me-3 font-bold"},"Monthly Bill",-1),me={class:"mt-12 flex items-center gap-1"},pe={class:"mt-2"},he={class:"mb-3"},ve={class:"text-2xl font-bold"},be={class:"text-md"},_e=e("span",{class:"btn-label-wrap"},[e("span",{class:"btn-label-inner"},"Increase limit‍")],-1),fe=[_e],ge={class:"mt-10"},xe=W('<div class="flex gap-2"><div class="font-bold">Credit Usage</div></div><div class="mb-1 mt-2 flex justify-between gap-3"><div class="flex items-center gap-1"><span class="h-4 w-4 rounded-sm bg-green-400"></span><span> Available</span></div><div class="flex items-center gap-1"><div class="h-4 w-4 rounded-sm bg-red-400"></div><span> Used</span></div></div>',2),ye={class:"flex items-center"},Ce={class:"relative w-full"},we=e("div",{class:"absolute left-0 h-4 w-full rounded bg-red-400"},null,-1),ke={class:"mt-5 flex justify-between"},Ae={class:"mb-3 text-center"},Se={class:"fw-bold mt-2 text-left"},Me={class:"my-8 flex flex-wrap gap-2 px-3"},Oe=["onClick"],Be=e("i",{class:"bx bx-check absolute right-[-10px] top-[-10px] rounded-full bg-primary-600 p-1 text-white"},null,-1),De=[Be],qe=["src"],Ve=["id"],Fe=["onSubmit"],Ue={class:"table-responsive"},je={class:"table-borderless table text-sm"},Ie={key:0,class:"border"},Ne={class:"border border-black p-2"},Pe={class:"text-center"},Te={key:0,class:"table-borderless mt-2 table"},$e={class:"fw-500 text-sm"},ze={class:"text-sm"},Ee={key:1,class:"form-group mt-2"},Ge={class:"fw-500 text-fs-sm my-2"},Le={class:"form-group mt-1"},Re={class:"fw-500 text-fs-sm my-2"},Ye={class:"form-group"},We={class:"fw-500 text-fs-sm my-2"},He=["disabled"],Je=H({layout:Z}),at=Object.assign(Je,{__name:"Index",props:["buttons","request","credits","costChartData","activeChartFilterBtn","credit_fee","gateways","totalCostAmount","availableCreditAmount","spendCreditAmount"],setup(d){var q;const M=Q(),{getState:N}=E(M),n=d,w=b(()=>{let s=n.availableCreditAmount+n.spendCreditAmount;return{available:Math.round(n.availableCreditAmount/s*100),spend:Math.round(n.spendCreditAmount/s*100)}}),P=["day","week","month","year"],O=b(()=>({series:[{name:"costs",data:n.costChartData.map(s=>s.credit)}],chartOptions:{colors:["#69ae84"],chart:{height:350,type:"bar",toolbar:{show:!1}},plotOptions:{bar:{horizontal:!1,columnWidth:"10px",endingShape:"rounded"}},dataLabels:{enabled:!1},stroke:{show:!0,width:2,colors:["transparent"]},yaxis:{show:!1,opposite:!0,labels:{formatter:function(s){return s.toFixed(0)}}},xaxis:{type:"string",categories:n.costChartData.map(s=>s.date)}}})),B=b(()=>({series:[n.availableCreditAmount,n.spendCreditAmount],chartOptions:{colors:["#4ade80","#f87171"],labels:["Available","Used"],chart:{width:250,type:"donut"},dataLabels:{enabled:!1},responsive:[{breakpoint:480,options:{chart:{width:200},legend:{show:!1}}}],legend:{show:!1}}})),{formatCurrency:p,authUser:T}=G(),h=_(((q=n.gateways[0])==null?void 0:q.id)||0),v=_(null),D=_(n.credit_fee),x=b(()=>v.value/D.value),k=_(!1),c=_({image:null,comment:"",phone:T.value.phone}),m=b(()=>n.gateways.find(s=>s.id===h.value)),$=s=>{if(m.value.min_amount>x.value){U.danger("The minimum transaction amount is "+p(m.value.min_amount));return}if(m.value.max_amount!=-1&&m.value.max_amount<x.value){U.danger("The maximum transaction amount is "+p(m.value.max_amount));return}k.value=!0,V.post(route("credit.pay"),{gateway_id:s,total:x.value,credits:v.value,manualPayment:m.value.is_auto==0?c.value:null,phone:c.value.phone},{onFinish:()=>{v.value=0,k.value=!1}})},z=s=>{V.get(s)};return(s,o)=>(i(),l(f,null,[e("main",te,[y(ee,{title:"Credits",buttons:d.buttons},null,8,["buttons"]),e("div",se,[e("div",ae,[e("div",oe,[e("div",ne,[e("h6",le,[ie,L(" Costs: "+a(d.totalCostAmount),1)]),e("select",{class:"select w-36 capitalize",onInput:o[0]||(o[0]=t=>z(t.target.value))},[(i(),l(f,null,A(P,t=>e("option",{key:t,selected:t==d.activeChartFilterBtn,value:s.route("user.credits.index",{scope:t})},a(t),9,re)),64))],32)]),e("div",de,[y(r(j),{type:"bar",height:"350",options:O.value.chartOptions,series:O.value.series},null,8,["options","series"])])]),e("div",ce,[ue,e("span",null,a(r(I)().startOf("month").format("DD MMM"))+" - "+a(r(I)().endOf("month").format("DD MMM")),1),e("div",me,[y(r(j),{type:"donut",height:"200",width:"220",options:B.value.chartOptions,series:B.value.series},null,8,["options","series"]),e("div",pe,[e("div",he,[e("div",ve,a(d.spendCreditAmount),1),e("div",be,"/ "+a(d.availableCreditAmount)+" limit",1)]),e("button",{type:"button",onClick:o[1]||(o[1]=t=>r(M).open("addCredits")),class:"btn btn-sm btn-primary"},fe)])]),e("div",ge,[xe,e("div",ye,[e("div",Ce,[we,e("div",{class:"absolute left-0 h-4 rounded bg-green-400",style:R({width:w.value.available+"%"})},null,4)])]),e("div",ke,[e("span",null,a(w.value.available),1),e("span",null,a(w.value.spend),1)])])])])])]),y(X,{state:r(N)("addCredits"),"header-state":!0,"header-title":"Buy Credits"},{default:Y(()=>[e("p",Ae,a(D.value)+" "+a(s.trans("Credits"))+" = "+a(r(p)(1)),1),g(e("input",{class:"input",step:"5",type:"number","onUpdate:modelValue":o[2]||(o[2]=t=>v.value=t),placeholder:"Enter Credit amount"},null,512),[[S,v.value,void 0,{number:!0}]]),e("p",Se,a(s.trans("Total:"))+" "+a(r(p)(x.value||0)),1),e("div",Me,[(i(!0),l(f,null,A(d.gateways,t=>(i(),l("button",{key:t.id,class:J(["relative flex flex-1 items-center justify-center rounded-lg p-4",{"border bg-slate-50":h.value==t.id}]),onClick:u=>h.value=t.id},[g(e("div",null,De,512),[[F,h.value==t.id]]),e("img",{src:t.logo,class:"max-w-24"},null,8,qe)],10,Oe))),128))]),(i(!0),l(f,null,A(d.gateways,t=>g((i(),l("div",{key:t.id,class:"",id:"gateway-form"+t.id},[e("form",{method:"post",onSubmit:K(u=>$(t.id),["prevent"]),enctype:"multipart/form-data"},[e("div",Ue,[e("table",je,[t.charge!=0?(i(),l("tr",Ie,[e("td",Ne,a(s.trans("Gateway Charge: ")),1),e("td",Pe,a(r(p)(t.charge)),1)])):C("",!0)]),t.comment!=null?(i(),l("table",Te,[e("tr",null,[e("td",$e,a(s.trans("Payment Instruction: ")),1)]),e("tr",null,[e("td",ze,a(t.comment),1)])])):C("",!0),t.phone_required==1?(i(),l("div",Ee,[e("label",Ge,a(s.trans("Your phone number")),1),g(e("input",{type:"number",name:"phone",placeholder:"Your phone number",class:"input",required:"","onUpdate:modelValue":o[3]||(o[3]=u=>c.value.phone=u)},null,512),[[S,c.value.phone]])])):C("",!0),t.is_auto==0?(i(),l(f,{key:2},[e("div",Le,[e("label",Re,a(s.trans("Submit your payment proof")),1),e("input",{onInput:o[4]||(o[4]=u=>{c.value.image=u.target.files[0]}),type:"file",name:"image",class:"input",required:"",accept:"image/*"},null,32)]),e("div",Ye,[e("label",We,a(s.trans("Comment")),1),g(e("textarea",{"onUpdate:modelValue":o[5]||(o[5]=u=>c.value.comment=u),class:"input",required:"",name:"comment",placeholder:"comment",maxlength:"500"},null,512),[[S,c.value.comment]])])],64)):C("",!0)]),e("button",{disabled:k.value,type:"submit",class:"btn btn-primary mt-4 w-full py-2 text-lg"},a(s.trans("Pay Now")),9,He)],40,Fe)],8,Ve)),[[F,h.value===t.id]])),128))]),_:1},8,["state"])],64))}});export{at as default};
